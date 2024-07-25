<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

require 'db_conn.php'; // Include the database connection

// Handle livreur deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['livreur_id'])) {
    $livreur_id = $_POST['livreur_id'];

    $stmt = $conn->prepare("DELETE FROM livreurs WHERE id = ?");
    $stmt->bind_param("i", $livreur_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Livreur supprimé avec succès.";
    } else {
        $_SESSION['error_message'] = "Erreur lors de la suppression du livreur.";
    }

    $stmt->close();

    header("Location: liste_livreur.php");
    exit();
}

// Redirect if livreur_id is not provided
if (!isset($_GET['livreur_id'])) {
    header("Location: liste_livreur.php");
    exit();
}

$livreur_id = $_GET['livreur_id'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Livreur</title>
    <link rel="stylesheet" href="livreurs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <p><i class="fas fa-user-times"></i> Supprimer Livreur</p>
        </header>

        <div class="dashboard-buttons">
            <a href="dashboard.php" class="dashboard-button"><i class="fas fa-tachometer-alt"></i><br>Dashboard</a>
            <a href="liste_livreurs.php" class="dashboard-button"><i class="fas fa-users"></i><br>Liste des Livreurs</a>
        </div>

        <div class="livreur-form">
            <h2><i class="fas fa-user-times"></i> Confirmer la suppression</h2>
            <p>Êtes-vous sûr de vouloir supprimer ce livreur?</p>
            <form method="POST" action="supprimer_livreur.php">
                <input type="hidden" name="livreur_id" value="<?php echo htmlspecialchars($livreur_id); ?>">
                <button type="submit" class="delete-button"><i class="fas fa-trash-alt"></i> Supprimer</button>
                <a href="liste_livreurs.php" class="cancel-button"><i class="fas fa-times"></i> Annuler</a>
            </form>
        </div>

        <footer>
            <p>&copy; 2023 Gestion des Livreurs</p>
        </footer>
    </div>
</body>
</html>
