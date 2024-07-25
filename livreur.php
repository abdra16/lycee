<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']);
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

require 'db_conn.php'; // Include the database connection

// Handle form submission for adding a new livreur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    $stmt = $conn->prepare("INSERT INTO livreurs (nom, adresse, telephone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $adresse, $telephone);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Livreur ajouté avec succès.";
    } else {
        $_SESSION['error_message'] = "Erreur lors de l'ajout du livreur.";
    }

    $stmt->close();

    header("Location: livreur.php");
    exit();
}

// Retrieve the list of livreurs
$result = $conn->query("SELECT * FROM livreurs");
$livreurs = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Livreurs</title>
    <link rel="stylesheet" href="livreurs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <p><i class="fas fa-tasks"></i> Gestion des Livreurs de l'entrepôt</p>
        </header>

        <?php
        // Display success or error message if exists
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . $_SESSION['success_message'] . ' <i class="fas fa-check-circle"></i></div>';
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error-message">' . $_SESSION['error_message'] . ' <i class="fas fa-exclamation-circle"></i></div>';
            unset($_SESSION['error_message']);
        }
        ?>

<div class="dashboard-buttons">
    <a href="dashboard.php" class="dashboard-button"><i class="fas fa-tachometer-alt"></i><br>Dashboard</a>
    <a href="liste_livreur.php" class="dashboard-button"><i class="fas fa-users"></i><br>Liste des Livreurs</a>
</div>


        <div class="livreur-form">
            <h2><i class="fas fa-plus-circle"></i> Ajouter un Livreur</h2>
            <form method="POST" action="livreur.php">
                <div class="form-group">
                    <label for="nom"><i class="fas fa-user"></i> Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="adresse"><i class="fas fa-map-marker-alt"></i> Adresse:</label>
                    <textarea id="adresse" name="adresse" required></textarea>
                </div>
                <div class="form-group">
                    <label for="telephone"><i class="fas fa-phone"></i> Téléphone:</label>
                    <input type="text" id="telephone" name="telephone" required>
                </div>
                <button type="submit"><i class="fas fa-plus"></i> Ajouter</button>
            </form>
        </div>
        
       

        <footer>
            <p>&copy; 2023 Gestion des Livreurs</p>
        </footer>
    </div>
</body>
</html>
