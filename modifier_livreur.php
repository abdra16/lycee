<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

require 'db_conn.php'; // Include the database connection

// Handle form submission for updating a livreur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['livreur_id'])) {
    $livreur_id = $_POST['livreur_id'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    $stmt = $conn->prepare("UPDATE livreurs SET nom = ?, adresse = ?, telephone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nom, $adresse, $telephone, $livreur_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Livreur modifié avec succès.";
    } else {
        $_SESSION['error_message'] = "Erreur lors de la modification du livreur.";
    }

    $stmt->close();

    header("Location: liste_livreur.php");
    exit();
}

// Retrieve livreur details based on livreur_id
if (isset($_GET['livreur_id'])) {
    $livreur_id = $_GET['livreur_id'];

    $stmt = $conn->prepare("SELECT * FROM livreurs WHERE id = ?");
    $stmt->bind_param("i", $livreur_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $livreur = $result->fetch_assoc();

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Livreur</title>
    <link rel="stylesheet" href="livreurs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <p><i class="fas fa-user-edit"></i> Modifier Livreur</p>
        </header>

        <div class="dashboard-buttons">
            <a href="dashboard.php" class="dashboard-button"><i class="fas fa-tachometer-alt"></i><br>Dashboard</a>
            <a href="liste_livreurs.php" class="dashboard-button"><i class="fas fa-users"></i><br>Liste des Livreurs</a>
        </div>

        <div class="livreur-form">
            <h2><i class="fas fa-user-edit"></i> Modifier un Livreur</h2>
            <form method="POST" action="modifier_livreur.php">
                <input type="hidden" name="livreur_id" value="<?php echo htmlspecialchars($livreur['id']); ?>">
                <div class="form-group">
                    <label for="nom"><i class="fas fa-user"></i> Nom:</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($livreur['nom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="adresse"><i class="fas fa-map-marker-alt"></i> Adresse:</label>
                    <textarea id="adresse" name="adresse" required><?php echo htmlspecialchars($livreur['adresse']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="telephone"><i class="fas fa-phone"></i> Téléphone:</label>
                    <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($livreur['telephone']); ?>" required>
                </div>
                <button type="submit"><i class="fas fa-save"></i> Enregistrer</button>
            </form>
        </div>

        <footer>
            <p>&copy; 2023 Gestion des Livreurs</p>
        </footer>
    </div>
</body>
</html>
