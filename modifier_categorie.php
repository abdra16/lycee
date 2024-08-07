<!-- modifier_categorie.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Catégorie</title>
    <link rel="stylesheet" href="cate_ajout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <header>
        <h1><i class="fa fa-edit"></i> Modifier une Catégorie</h1>
        <div class="header-buttons">
            <a href="index.php" class="header-button"><i class="fa fa-home"></i> Accueil</a>
            <a href="categorie.php" class="header-button"><i class="fa fa-list"></i> Liste des Catégories</a>
        </div>
    </header>
    <div class="form-container">
        <?php
        // Récupérer l'ID de la catégorie depuis l'URL
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $categorie_id = $_GET['id'];

            // Connexion à la base de données
            $mysqli = new mysqli('localhost', 'root', '', 'essai');
            if ($mysqli->connect_errno) {
                echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
                exit();
            }

            // Préparer la requête SQL pour récupérer les informations de la catégorie
            $sql = "SELECT nom, description FROM categories WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                // Liaison des paramètres
                $stmt->bind_param("i", $categorie_id);

                // Exécution de la requête
                $stmt->execute();

                // Liaison des résultats
                $stmt->bind_result($nom, $description);

                // Récupération des valeurs
                $stmt->fetch();

                // Fermeture du statement
                $stmt->close();
            } else {
                echo "Erreur de préparation de la requête SQL: " . $mysqli->error;
            }

            // Fermer la connexion à la base de données
            $mysqli->close();
        } else {
            echo "ID de la catégorie non spécifié.";
            exit();
        }
        ?>
        <form action="update_categorie.php" method="post">
            <input type="hidden" name="id" value="<?php echo $categorie_id; ?>">
            <div class="form-group">
                <label for="nom"><i class="fas fa-tag"></i> Nom de la catégorie</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
            </div>
            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle"></i> Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit"><i class="fas fa-save"></i> Enregistrer les Modifications</button>
            </div>
        </form>
    </div>
</body>
</html>
