<!-- supprimer_categorie.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Catégorie</title>
    <link rel="stylesheet" href="supp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <header>
        <h1><i class="fa fa-trash"></i> Supprimer une Catégorie</h1>
        <div class="header-buttons">
            <a href="index.php" class="header-button"><i class="fa fa-home"></i> Accueil</a>
            <a href="categorie.php" class="header-button"><i class="fa fa-list"></i> Liste des Catégories</a>
        </div>
    </header>
    <div class="form-container">
        <?php
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $categorie_id = $_GET['id'];

            // Connexion à la base de données
            $mysqli = new mysqli('localhost', 'root', '', 'essai');
            if ($mysqli->connect_errno) {
                echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
                exit();
            }

            // Récupérer les informations de la catégorie pour confirmation
            $sql = "SELECT nom FROM categories WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                // Liaison des paramètres
                $stmt->bind_param("i", $categorie_id);

                // Exécution de la requête
                $stmt->execute();

                // Liaison des résultats
                $stmt->bind_result($nom);

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

        // Affichage du message de confirmation
        ?>
        <div class="confirmation">
            <p>Êtes-vous sûr de vouloir supprimer la catégorie "<?php echo htmlspecialchars($nom); ?>" ?</p>
            <form action="delete_categorie.php" method="post">
                <input type="hidden" name="id" value="<?php echo $categorie_id; ?>">
                <button type="submit" name="confirm" class="delete-button"><i class="fas fa-trash"></i> Oui, Supprimer</button>
                <a href="categorie.php" class="cancel-button"><i class="fas fa-times"></i> Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>
