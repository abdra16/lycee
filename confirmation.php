<?php
// Connexion à la base de données (si nécessaire)
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "essai";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifiez le statut de la commande passé en paramètre
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'error';

$message = '';

if ($status == 'success') {
    $message = "La mise à jour de la commande a été effectuée avec succès.";
} elseif ($status == 'error') {
    $message = "Une erreur est survenue lors de la mise à jour de la commande.";
} else {
    $message = "Statut inconnu.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="confirmation.css"> <!-- Assurez-vous d'avoir ce fichier CSS pour le style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Inclure Font Awesome -->
</head>

<body>
    <header>
        <h1><i class="fas fa-check-circle"></i> Confirmation</h1>
    </header>

    <div class="container">
        <section class="confirmation-message">
            <h2><i class="fas fa-info-circle"></i> <?php echo htmlspecialchars($message); ?></h2>
            <a href="commande_client.php" class="back-button"><i class="fas fa-arrow-left"></i> Retour à la liste des commandes</a>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Entrepôt - Tous droits réservés <i class="fa fa-copyright"></i></p>
    </footer>
</body>

</html>
