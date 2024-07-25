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
    <title>Détails de la Commande</title>
    <link rel="stylesheet" href="deta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Détails de la Commande</h2>
        <?php if ($commande_details): ?>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($commande_details['id']); ?></p>
        <p><strong>Nom Fournisseur:</strong> <?php echo htmlspecialchars($commande_details['NomFournisseur']); ?></p>
        <p><strong>Adresse:</strong> <?php echo htmlspecialchars($commande_details['adresse']); ?></p>
        <p><strong>Ville:</strong> <?php echo htmlspecialchars($commande_details['ville']); ?></p>
        <p><strong>Code Postal:</strong> <?php echo htmlspecialchars($commande_details['code_postal']); ?></p>
        <p><strong>Pays:</strong> <?php echo htmlspecialchars($commande_details['pays']); ?></p>
        <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($commande_details['telephone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($commande_details['email']); ?></p>
        <p><strong>Produit:</strong> <?php echo htmlspecialchars($commande_details['produit']); ?></p>
        <p><strong>Quantité:</strong> <?php echo htmlspecialchars($commande_details['quantite']); ?></p>
        <p><strong>Prix FCFA:</strong> <?php echo htmlspecialchars($commande_details['prix_fcfa']); ?></p>
        <p><strong>Date Commande:</strong> <?php echo htmlspecialchars($commande_details['date_commande']); ?></p>
        <p><strong>Statut:</strong> <?php echo htmlspecialchars($commande_details['statut']); ?></p>
        <a href="liste_commande.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour à la Liste</a>
        <?php else: ?>
        <p>Commande non trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>
