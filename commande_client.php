<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);

// Connexion à la base de données
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "essai";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les commandes avec les noms des articles, les images, et le username
$sql_commandes = "
    SELECT ac.id, ac.commande_id, u.username, a.nom_article AS article_nom, a.image_article, ac.quantite, ac.prix, ac.statut
    FROM articles_commandes ac
    JOIN articles a ON ac.article_id = a.id
    JOIN user_orders u ON ac.commande_id = u.commande_id"; // Assurez-vous que les jointures sont correctes
$stmt_commandes = $conn->prepare($sql_commandes);

if ($stmt_commandes === false) {
    die("Erreur de préparation de la requête: " . $conn->error);
}

$stmt_commandes->execute();
$result_commandes = $stmt_commandes->get_result();

$commandes = [];
if ($result_commandes->num_rows > 0) {
    while ($row = $result_commandes->fetch_assoc()) {
        // Convertir les données longblob en base64
        if (!empty($row['image_article'])) {
            $row['image_article'] = 'data:image/jpeg;base64,' . base64_encode($row['image_article']);
        }
        $commandes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <link rel="stylesheet" href="client.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <h1><i class="fas fa-warehouse"></i> Entrepôt de stock</h1>
    </header>

    <div class="container">
        <section class="order-list">
            <h2><i class="fas fa-list-alt"></i> Commandes Passées</h2>
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Client</th>
                        <th><i class="fas fa-image"></i> Image de l'Article</th>
                        <th><i class="fas fa-box"></i> Nom de l'Article</th>
                        <th><i class="fas fa-sort-amount-up"></i> Quantité</th>
                        <th><i class="fas fa-money-bill-wave"></i> Prix (FCFA)</th>
                        <th><i class="fas fa-check-circle"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($commandes)): ?>
                        <?php foreach ($commandes as $commande): ?>
                            <?php
                                // Déterminer la classe CSS en fonction du statut
                                $status_class = '';
                                switch ($commande['statut']) {
                                    case 'en attente':
                                        $status_class = 'status-attente';
                                        break;
                                    case 'acceptee':
                                        $status_class = 'status-acceptee';
                                        break;
                                    case 'annulee':
                                        $status_class = 'status-annulee';
                                        break;
                                    case 'reapprovisionner':
                                        $status_class = 'status-reapprovisionner';
                                        break;
                                }
                            ?>
                            <tr class="<?php echo $status_class; ?>">
                                <td><?php echo htmlspecialchars($commande['username']); ?></td>
                                <td>
                                    <?php if (!empty($commande['image_article'])): ?>
                                        <img src="<?php echo $commande['image_article']; ?>" alt="<?php echo htmlspecialchars($commande['article_nom']); ?>" style="width: 50px; height: 50px;">
                                    <?php else: ?>
                                        <img src="default_image.png" alt="Image non disponible" style="width: 50px; height: 50px;">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($commande['article_nom']); ?></td>
                                <td class="<?php echo ($commande['quantite'] > 10) ? 'error' : ''; ?>"><?php echo htmlspecialchars($commande['quantite']); ?></td>
                                <td><?php echo htmlspecialchars($commande['prix']); ?></td>
                                <td>
                                    <?php if ($commande['statut'] === 'en attente'): ?>
                                        <form action="confirmer_commande.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="commande_id" value="<?php echo htmlspecialchars($commande['commande_id']); ?>">
                                            <button type="submit" name="action" value="accepter" class="confirm-button"><i class="fas fa-check"></i> Accepter</button>
                                            <button type="submit" name="action" value="annuler" class="confirm-button cancel-button"><i class="fas fa-times"></i> Annuler</button>
                                            <button type="submit" name="action" value="reapprovisionner" class="confirm-button reappro-button"><i class="fas fa-sync"></i> Réapprovisionner</button>
                                        </form>
                                    <?php else: ?>
                                        <span><?php echo ucfirst(htmlspecialchars($commande['statut'])); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Aucune commande trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Entrepôt - Tous droits réservés <i class="fa fa-copyright"></i></p>
    </footer>
</body>

</html>
