<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réapprovisionner Article</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="rea.css">
</head>
<body>
    <div class="container">
        <h1>Réapprovisionner Article</h1>

        <?php
        // Vérifier si l'ID de l'article est passé en paramètre
        if (isset($_GET['id'])) {
            $article_id = htmlspecialchars($_GET['id']);

            // Connexion à la base de données (à remplacer par vos informations de connexion)
            $bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

            // Préparer et exécuter la requête pour récupérer l'article par son ID
            $requete = $bdd->prepare('SELECT nom_article FROM articles WHERE id = :article_id');
            $requete->bindParam(':article_id', $article_id);
            $requete->execute();
            $article = $requete->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'article existe
            if ($article) {
                echo '<p>Nom de l\'article : ' . htmlspecialchars($article['nom_article']) . '</p>';
            } else {
                echo '<p>Article non trouvé.</p>';
            }
        } else {
            echo '<p>Erreur : ID de l\'article non spécifié.</p>';
        }
        ?>

        <form action="reapprovisionner_article_action.php" method="POST">
            <div class="form-group">
                <label for="article_id">ID de l'article</label>
                <input type="text" class="form-control" id="article_id" name="article_id" readonly value="<?= htmlspecialchars($_GET['id']); ?>">
            </div>
            <div class="form-group">
                <label for="quantite">Quantité à ajouter</label>
                <input type="number" class="form-control" id="quantite" name="quantite" required>
            </div>
            <button type="submit" class="btn btn-primary">Réapprovisionner</button>
            <a href="liste_articles.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    <!-- Inclusion de Bootstrap JS et jQuery pour les fonctionnalités JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
