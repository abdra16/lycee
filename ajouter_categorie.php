<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Catégorie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Inclusion de Font Awesome -->
    <link rel="stylesheet" href="cate_ajout.css">
</head>
<body>
    <header>
        <h1>Ajouter une Catégorie</h1>
        <div class="header-buttons">
            <a href="dashboard.php" class="header-button"><i class="fas fa-home"></i> Accueil</a>
            <a href="categorie.php" class="header-button"><i class="fas fa-list"></i> Liste des Catégories</a>
        </div>
    </header>
    <div class="form-container">
        <form action="save_categorie.php" method="post">
        <?php
        // Affichage du message de succès s'il est présent dans l'URL
        if (isset($_GET['success'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
            <div class="form-group">
                <label for="name"><i class="fas fa-tag"></i> Nom de la catégorie</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle"></i> Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit"><i class="fas fa-plus"></i> Ajouter la Catégorie</button>
            </div>
        </form>
    </div>
</body>
</html>
