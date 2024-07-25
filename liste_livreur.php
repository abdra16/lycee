<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

require 'db_conn.php'; // Include the database connection

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
    <title>Liste des Livreurs</title>
    <link rel="stylesheet" href="liste_livreur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <p><i class="fas fa-users"></i> Liste des Livreurs de l'entrepôt</p>
        </header>

        <div class="dashboard-buttons">
            <a href="dashboard.php" class="dashboard-button"><i class="fas fa-tachometer-alt"></i><br>Dashboard</a>
            <a href="livreur.php" class="dashboard-button"><i class="fas fa-plus-circle"></i><br>Ajouter un Livreur</a>
        </div>

        <div class="livreurs-list">
            <?php if (count($livreurs) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livreurs as $livreur): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($livreur['nom']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['adresse']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['telephone']); ?></td>
                                <td>
                                    <a href="modifier_livreur.php?livreur_id=<?php echo $livreur['id']; ?>" class="edit-button"><i class="fas fa-edit"></i> Modifier</a>
                                    <a href="supprimer_livreur.php?livreur_id=<?php echo $livreur['id']; ?>" class="delete-button"><i class="fas fa-trash-alt"></i> Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun livreur trouvé.</p>
            <?php endif; ?>
        </div>

        <footer>
            <p>&copy; 2023 Gestion des Livreurs</p>
        </footer>
    </div>
</body>
</html>
