<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock"; // Remplacez par le nom de votre base de données

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les commandes avec les détails requis
    $sql = "SELECT c.id AS commande_id, a.id AS article_id, a.nom_article, c.nom AS client_nom, c.prenom AS client_prenom, c.adresse AS client_adresse, c.telephone AS client_telephone, ca.quantite AS quantite_commandee, a.prix_unitaire, c.date_commande, c.statut,
            (ca.quantite * a.prix_unitaire) AS prix_total, a.quantite AS quantite_en_stock
            FROM commande c
            INNER JOIN commande_article ca ON c.id = ca.id_commande
            INNER JOIN article a ON ca.id_article = a.id";

    // Ajout du filtre par année si spécifié
    if (isset($_GET['annee']) && $_GET['annee'] != '') {
        $sql .= " WHERE YEAR(c.date_commande) = :annee";
    }

    $stmt = $pdo->prepare($sql);

    // Bind du paramètre pour le filtre par année
    if (isset($_GET['annee']) && $_GET['annee'] != '') {
        $stmt->bindParam(':annee', $_GET['annee'], PDO::PARAM_INT);
    }

    $stmt->execute();
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
    $commandes = []; // Assurer que $commandes est défini même en cas d'erreur
    echo $error; // Afficher l'erreur pour le débogage
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes</title>
    <a href="admin_dashboard.php" class="redirect-button">RETOUR</a>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles personnalisés pour les classes de ligne, sans couleur spécifique */
        .actions a {
            margin-right: 10px;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .notification-rupture {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Liste des Commandes</h2>
        <form method="get" action="" class="mb-3">
            <div class="form-group">
                <label for="annee">Filtrer par année:</label>
                <input type="number" class="form-control" id="annee" name="annee" placeholder="Entrez l'année" value="<?= isset($_GET['annee']) ? htmlspecialchars($_GET['annee']) : '' ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Nom Client</th>
                    <th>Prénom Client</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Quantité Commandée</th>
                    <th>Prix Total</th>
                    <th>Date Commande</th>
                    <th>Notification</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($commandes)) {
                    foreach ($commandes as $commande) {
                        // Déterminer la classe CSS en fonction du statut de la commande
                        $ligneClass = '';
                        $notification = '';
                        if ($commande['quantite_commandee'] > $commande['quantite_en_stock']) {
                            $commande['statut'] = 'rupture';
                            $notification = 'Commande disponible dans 48h';
                        }
                        switch ($commande['statut']) {
                            case 'acceptee':
                                $ligneClass = 'table-success'; // Commande confirmée
                                break;
                            case 'rupture':
                                $ligneClass = 'table-danger'; // Rupture de stock
                                break;
                            case 'annulee':
                                $ligneClass = 'table-dark'; // Commande annulée
                                break;
                            default:
                                $ligneClass = 'table-warning'; // Commande en attente
                                break;
                        }

                        // Affichage de la ligne dans le tableau HTML
                        echo "<tr class='$ligneClass'>
                                <td>{$commande['nom_article']}</td>
                                <td>{$commande['client_nom']}</td>
                                <td>{$commande['client_prenom']}</td>
                                <td>{$commande['client_adresse']}</td>
                                <td>{$commande['client_telephone']}</td>
                                <td>{$commande['quantite_commandee']}</td>
                                <td>{$commande['prix_total']}</td>
                                <td>{$commande['date_commande']}</td>
                                <td class='notification-rupture'>$notification</td>
                                <td class='actions'>";

                        if ($commande['statut'] != 'acceptee' && $commande['statut'] != 'rupture') {
                            // Lien pour accepter la commande
                            echo "<a href='accepter_commande.php?id={$commande['commande_id']}' class='btn btn-success btn-sm' onclick='return confirm(\"Voulez-vous vraiment accepter cette commande ?\");'>Accepter</a>  ";
                        } else if ($commande['statut'] == 'rupture') {
                            // Afficher le lien pour accepter la commande en rupture de stock
                            echo "<a href='accepter_commande.php?id={$commande['commande_id']}' class='btn btn-success btn-sm' onclick='return confirm(\"Voulez-vous vraiment accepter cette commande malgré la rupture de stock ?\");'> Accepter</a>  ";
                        }

                        // Toujours afficher le lien pour imprimer la commande
                        echo "<a href='imprimer_commande.php?id={$commande['commande_id']}' class='btn btn-primary btn-sm' onclick='return confirm(\"Voulez-vous imprimer cette commande ?\");'>Imprimer</a>";

                        echo "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucune commande trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
