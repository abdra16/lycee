<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Catégories</title>
    <link rel="stylesheet" href="ca.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <header>
        <h1><i class="fa fa-list"></i> Liste des Catégories</h1>
        <div class="header-buttons">
            <a href="dashboard.php" class="header-button"><i class="fa fa-home"></i> Accueil</a>
            <a href="ajouter_categorie.php" class="header-button"><i class="fa fa-plus"></i> Ajouter une Catégorie</a>
        </div>
    </header>
    <div class="category-list">
        <?php
        // Connexion à la base de données
        $mysqli = new mysqli('localhost', 'root', '', 'essai');
        if ($mysqli->connect_errno) {
            echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
            exit();
        }

        // Vérifier s'il y a un message de succès
        if (isset($_GET['success']) && $_GET['success'] == 'update') {
            echo '<div class="success-message">La catégorie a été mise à jour avec succès.</div>';
        }

        // Vérifier si le paramètre de succès est présent dans l'URL
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<div class="success-message">La catégorie a été supprimée avec succès.</div>';
        }

        // Requête SQL pour récupérer toutes les catégories
        $sql = "SELECT id, nom, description FROM categories";
        $result = $mysqli->query($sql);

        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            // Affichage des catégories sous forme de tableau

            echo "<table>";
            echo "<tr><th><i class='fas fa-tag'></i> Nom</th><th><i class='fas fa-align-left'></i> Description</th><th><i class='fas fa-cog'></i> Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['nom']}</td>";
                echo "<td>{$row['description']}</td>";
                echo "<td><a href='modifier_categorie.php?id={$row['id']}' class='modifier'><i class='fas fa-edit'></i> Modifier</a> ";
                echo "<a href='supprimer_categorie.php?id={$row['id']}' class='supprimer'><i class='fas fa-trash-alt'></i> Supprimer</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune catégorie trouvée.";
        }

        // Libérer le résultat
        $result->free();

        // Fermer la connexion à la base de données
        $mysqli->close();
        ?>
    </div>
</body>
</html>
