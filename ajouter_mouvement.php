<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

require 'db_conn.php'; // Include the database connection

// Fetch articles from the database
$articlesResult = $conn->query("SELECT id, nom FROM article");
$articles = $articlesResult->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $article_id = $_POST['article_id'];
    $quantite = $_POST['quantite'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO mouvements (type, article_id, quantite, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $type, $article_id, $quantite, $description);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Mouvement ajouté avec succès.";
        header("Location: mouvement.php");
        exit();
    } else {
        $error_message = "Erreur lors de l'ajout du mouvement. Veuillez réessayer.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Mouvement - Gestion de Stock</title>
    <link rel="stylesheet" href="mouv.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="dashboard-container">
        <header>
            <h1>Ajouter un Mouvement</h1>
            <p><i class="fas fa-exchange-alt"></i> Gestion des mouvements de stocks de l'entrepôt</p>
        </header>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <main>
            <form action="ajouter_mouvement.php" method="POST">
                <div class="form-group">
                    <label for="type">Type de Mouvement</label>
                    <select name="type" id="type" required>
                        <option value="entrée">Entrée</option>
                        <option value="sortie">Sortie</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="article_id">Article</label>
                    <select name="article_id" id="article_id" required>
                        <?php foreach ($articles as $article): ?>
                            <option value="<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité</label>
                    <input type="number" name="quantite" id="quantite" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description"></textarea>
                </div>

                <button type="submit" class="submit-button"><i class="fas fa-save"></i> Ajouter Mouvement</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2023 Gestion des Mouvements de Stock</p>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
