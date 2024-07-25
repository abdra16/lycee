<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "essai";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des détails de la commande
    $commande_details = null;
    if (isset($_GET['id'])) {
        $details_id = $_GET['id'];
        $sql_details = "SELECT c.*, f.nom AS NomFournisseur, f.adresse, f.ville, f.code_postal, f.pays, f.telephone, f.email
                        FROM commandes c 
                        JOIN fournisseurs f ON c.fournisseur_id = f.id
                        WHERE c.id = :id";
        $stmt_details = $pdo->prepare($sql_details);
        $stmt_details->bindParam(':id', $details_id, PDO::PARAM_INT);
        $stmt_details->execute();
        $commande_details = $stmt_details->fetch(PDO::FETCH_ASSOC);
    }

} catch(PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
    $commande_details = [];
    echo $error; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'article</title>
    <link rel="stylesheet" href="details_article.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2><i class="fas fa-info-circle"></i> Détails de l'article</h2>
        
        <?php if ($commande_details): ?>
            <table>
                <tr>
                    <th><i class="fas fa-info-circle"></i> Détail</th>
                    <th><i class="fas fa-cogs"></i> Information</th>
                </tr>
                <tr>
                    <td><i class="fas fa-store"></i> Nom Fournisseur</td>
                    <td><?php echo htmlspecialchars($commande_details['NomFournisseur']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-map-marker-alt"></i> Adresse</td>
                    <td><?php echo htmlspecialchars($commande_details['adresse']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-city"></i> Ville</td>
                    <td><?php echo htmlspecialchars($commande_details['ville']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-postcode"></i> Code Postal</td>
                    <td><?php echo htmlspecialchars($commande_details['code_postal']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-flag"></i> Pays</td>
                    <td><?php echo htmlspecialchars($commande_details['pays']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-phone"></i> Téléphone</td>
                    <td><?php echo htmlspecialchars($commande_details['telephone']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-envelope"></i> Email</td>
                    <td><?php echo htmlspecialchars($commande_details['email']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-box"></i> Produit</td>
                    <td><?php echo htmlspecialchars($commande_details['produit']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-cube"></i> Quantité</td>
                    <td><?php echo htmlspecialchars($commande_details['quantite']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-money-bill-wave"></i> Prix FCFA</td>
                    <td><?php echo htmlspecialchars($commande_details['prix_fcfa']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-calendar-day"></i> Date Commande</td>
                    <td><?php echo htmlspecialchars($commande_details['date_commande']); ?></td>
                </tr>
                <tr>
                    <td><i class="fas fa-info-circle"></i> Statut</td>
                    <td><?php echo htmlspecialchars($commande_details['statut']); ?></td>
                </tr>
            </table>
            
            <a href="liste_articles.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour à la Liste</a>
            <a href="#" class="btn btn-print" onclick="window.print(); return false;"><i class="fas fa-print"></i> Imprimer</a>
        <?php else: ?>
            <p>Commande non trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>
