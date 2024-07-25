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
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion de Stock</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
    <header>
            <h1> Bienvenue,Administrateur <?php echo $username; ?>!</h1>
            <p><i class="fas fa-tasks"></i> Tableau de bord de gestion de stock de l'entrepôt</p>
        </header>

        <?php
        // Display a success message if it exists
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>

        <div class="dashboard-buttons">
        <a href="ventes.php" class="dashboard-button"><i class="fas fa-shopping-cart"></i><br>Ventes</a>
            <a href="liste_articles.php" class="dashboard-button"><i class="fas fa-box"></i><br>Articles</a>
            <a href="categorie.php" class="dashboard-button"><i class="fas fa-truck"></i><br>Catégorie</a>
            <a href="livreur.php" class="dashboard-button"><i class="fas fa-truck"></i><br>Livreur</a>
            <a href="liste_commande.php" class="dashboard-button"><i class="fas fa-receipt"></i><br>Commande chez les Fournisseurs</a>
            <a href="commande_client.php" class="dashboard-button"><i class="fas fa-receipt"></i><br>Commande des Clients</a>
            <a href="mouvement.php" class="dashboard-button"><i class="fas fa-exchange-alt"></i><br>Gestion des mouvements de stocks</a>
            <a href="rapport.php" class="dashboard-button"><i class="fas fa-chart-line"></i><br>Génération de rapports</a>
            <a href="logout.php" class="dashboard-button"><i class="fas fa-sign-out-alt"></i><br>Déconnexion</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include your script.js or other JavaScript files here -->
</body>

</html>
