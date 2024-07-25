<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des articles depuis la base de données
$stmt_articles = $pdo->query("SELECT * FROM article");
$articles = $stmt_articles->fetchAll(PDO::FETCH_ASSOC);

// Définir le numéro de contact pour le virement (à remplacer par le vrai numéro)
$numero_contact = "+22375678790";

// Traitement du formulaire de commande
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $date_commande = $_POST['date_commande'];
    $articlesCommande = isset($_POST['articles']) ? $_POST['articles'] : [];

    // Validation des données du formulaire
    if (empty($prenom) || empty($nom) || empty($adresse) || empty($telephone)) {
        $_SESSION['message'] = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (empty($articlesCommande)) {
        $_SESSION['message'] = 'Veuillez ajouter au moins un article à la commande.';
    } else {
        $total = 0;
        foreach ($articlesCommande as $article) {
            if (isset($article['prix']) && isset($article['quantite']) && !empty($article['prix']) && !empty($article['quantite'])) {
                $total += $article['prix'] * $article['quantite'];
            } else {
                $_SESSION['message'] = 'Les informations des articles sont incomplètes.';
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }

        try {
            $pdo->beginTransaction();

            // Insérer la commande dans la table 'commande'
            $stmt = $pdo->prepare("INSERT INTO commande (prenom, nom, adresse, telephone, date_commande, total, statut) VALUES (:prenom, :nom, :adresse, :telephone, :date_commande, :total, 'en attente')");
            $stmt->execute([
                'prenom' => $prenom,
                'nom' => $nom,
                'adresse' => $adresse,
                'telephone' => $telephone,
                'date_commande' => $date_commande,
                'total' => $total
            ]);

            $id_commande = $pdo->lastInsertId();

            // Insérer chaque article commandé dans la table 'commande_article'
            $stmt = $pdo->prepare("INSERT INTO commande_article (id_commande, id_article, quantite, prix) VALUES (:id_commande, :id_article, :quantite, :prix)");
            foreach ($articlesCommande as $article) {
                // Vérifier le stock disponible
                $stmt_check_stock = $pdo->prepare("SELECT quantite FROM article WHERE id = :id_article");
                $stmt_check_stock->execute(['id_article' => $article['id']]);
                $stock = $stmt_check_stock->fetchColumn();

                if ($stock < $article['quantite']) {
                    throw new Exception("Quantité demandée pour l'article ID " . $article['id'] . " dépasse le stock disponible.");
                }

                // Insérer l'article dans la table 'commande_article'
                $stmt->execute([
                    'id_commande' => $id_commande,
                    'id_article' => $article['id'],
                    'quantite' => $article['quantite'],
                    'prix' => $article['prix']
                ]);

                // Mettre à jour le stock dans la table 'article'
                $stmt_update = $pdo->prepare("UPDATE article SET quantite = quantite - :quantite WHERE id = :id_article");
                $stmt_update->execute([
                    'quantite' => $article['quantite'],
                    'id_article' => $article['id']
                ]);
            }

            $pdo->commit();

            $_SESSION['message'] = 'Commande validée !';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['message'] = 'Erreur lors de la validation de la commande : ' . $e->getMessage();
        }
    }
}

// Récupérer le message de la session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des commandes administrateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-custom th, .table-custom td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Liste des commandes administrateur</h1>
            <!-- Intégration du formulaire de commande -->
            <div class="card">
                <h3 class="card-header">Passer une Commande</h3>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-info">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="numero_contact">Numéro de Contact pour Virement</label>
                        <input type="text" class="form-control" id="numero_contact" name="numero_contact" value="<?= htmlspecialchars($numero_contact) ?>" readonly>
                    </div>
                    <form id="commande" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="date_commande" value="<?= date('Y-m-d') ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Votre adresse" required>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Votre téléphone" required>
                        </div>

                        <h2>Liste des Articles</h2>

                        <table class="table table-bordered table-custom">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Article</th>
                                    <th>Prix Unitaire (FCFA)</th>
                                    <th>Quantité</th>
                                    <th>Ajouter</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($articles)): ?>
                                <?php foreach ($articles as $article): ?>
                                    <tr>
                                        <td><img src="<?= htmlspecialchars($article['images']) ?>" alt="Image de l'article" style="max-width: 100px;"></td>
                                        <td><?= htmlspecialchars($article['nom_article']) ?></td>
                                        <td><?= htmlspecialchars($article['prix_unitaire']) ?> FCFA</td>
                                        <td><input type="number" class="form-control" id="quantite-<?= $article['id'] ?>" placeholder="Quantité"></td>
                                        <td><button type="button" class="btn btn-primary" onclick="ajouterAuPanier(<?= $article['id'] ?>, '<?= htmlspecialchars($article['nom_article']) ?>', document.getElementById('quantite-<?= $article['id'] ?>').value, <?= $article['prix_unitaire'] ?>, '<?= htmlspecialchars($article['images']) ?>')">Ajouter</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5">Aucun article trouvé.</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                        <h2>Votre Panier</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Article</th>
                                    <th>Quantité</th>
                                    <th>Prix Unitaire</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="panier">
                                <!-- Les articles du panier seront affichés ici -->
                            </tbody>
                        </table>

                        <!-- Bouton pour valider la commande -->
                        <button type="submit" class="btn btn-primary">Valider la commande</button>
                    </form>
                </div>
            </div>
            <!-- Fin du formulaire de commande -->
        </div>
    </div>
</div>

<script>
    const panier = [];

    function ajouterAuPanier(id, nom, quantite, prix, images) {
        if (quantite <= 0) {
            alert("Veuillez entrer une quantité valide.");
            return;
        }

        const article = { id, nom, quantite, prix, images };
        panier.push(article);

        afficherPanier();
    }

    function retirerDuPanier(index) {
        panier.splice(index, 1);
        afficherPanier();
    }

    function afficherPanier() {
        const panierElement = document.getElementById('panier');
        panierElement.innerHTML = '';

        panier.forEach((article, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td><img src="${article.images}" alt="Image de l'article" style="max-width: 100px;"></td>
                <td>${article.nom}</td>
                <td>${article.quantite}</td>
                <td>${article.prix} FCFA</td>
                <td><button class="btn btn-danger" type="button" onclick="retirerDuPanier(${index})">Retirer</button></td>
                <input type="hidden" name="articles[${index}][id]" value="${article.id}">
                <input type="hidden" name="articles[${index}][nom]" value="${article.nom}">
                <input type="hidden" name="articles[${index}][quantite]" value="${article.quantite}">
                <input type="hidden" name="articles[${index}][prix]" value="${article.prix}">
            `;

            panierElement.appendChild(row);
        });
    }
</script>

</body>
</html>
