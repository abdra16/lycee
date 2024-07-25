<?php
// Connexion à la base de données (à remplacer par vos informations de connexion)
$bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

// Vérifier si l'ID de l'article est passé dans l'URL
if (isset($_GET['id'])) {
    $article_id = $_GET['id'];

    // Requête pour récupérer les informations de l'article
    $requete = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $requete->execute(['id' => $article_id]);
    $article = $requete->fetch();

    // Vérifier si l'article existe
    if ($article) {
        // Supprimer l'article après confirmation de l'utilisateur
        if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            $delete = $bdd->prepare('DELETE FROM articles WHERE id = :id');
            $delete->execute(['id' => $article_id]);
            echo "<p>L'article a été supprimé avec succès.</p>";
            echo "<a href='liste_articles.php' class='btn btn-primary'>Retour à la liste des articles</a>";
            exit;
        }
    } else {
        echo "<p>Article non trouvé.</p>";
        echo "<a href='liste_articles.php' class='btn btn-primary'>Retour à la liste des articles</a>";
        exit;
    }
} else {
    echo "<p>ID d'article non spécifié.</p>";
    echo "<a href='liste_articles.php' class='btn btn-primary'>Retour à la liste des articles</a>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Article</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="suppp.css">
    <!-- Inline CSS pour l'image de fond -->
    <style>
        body {
            background-image: url('img/art.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Supprimer Article</h1>
        <p>Êtes-vous sûr de vouloir supprimer l'article suivant?</p>
        <p><strong>Nom:</strong> <?= $article['nom_article'] ?></p>
        <p><strong>Description:</strong> <?= $article['description_article'] ?></p>
        <form method="post">
            <button type="submit" name="confirm" value="yes" class="btn btn-danger">Oui, supprimer</button>
            <a href="liste_articles.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
