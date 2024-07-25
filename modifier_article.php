<?php
// Connexion à la base de données (à remplacer par vos informations de connexion)
$bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

// Vérification de l'existence de l'ID de l'article dans la requête GET
if (isset($_GET['id'])) {
    $id_article = $_GET['id'];

    // Requête pour récupérer les détails de l'article
    $requete = $bdd->prepare('SELECT * FROM articles WHERE id = :id');
    $requete->bindParam(':id', $id_article);
    $requete->execute();
    $article = $requete->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'article existe
    if (!$article) {
        // Redirection vers une page d'erreur ou gestion d'erreur si l'article n'existe pas
        header('Location: erreur.php');
        exit; // Arrêter l'exécution du script
    }
} else {
    // Redirection vers une page d'erreur ou gestion d'erreur si l'ID n'est pas présent dans la requête
    header('Location: erreur.php');
    exit; // Arrêter l'exécution du script
}

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs du formulaire
    $nom_article = $_POST['nom_article'];
    $description_article = $_POST['description_article'];
    $prix_article = $_POST['prix_article'];
    $stock_article = $_POST['stock_article'];
    $categorie_id = $_POST['categorie_id'];
    $fournisseur_id = $_POST['fournisseur_id'];

    // Requête de mise à jour de l'article
    $requete = $bdd->prepare('UPDATE articles SET nom_article = :nom_article, description_article = :description_article, prix_article = :prix_article, stock_article = :stock_article, categorie_id = :categorie_id, fournisseur_id = :fournisseur_id WHERE id = :id');
    $requete->bindParam(':nom_article', $nom_article);
    $requete->bindParam(':description_article', $description_article);
    $requete->bindParam(':prix_article', $prix_article);
    $requete->bindParam(':stock_article', $stock_article);
    $requete->bindParam(':categorie_id', $categorie_id);
    $requete->bindParam(':fournisseur_id', $fournisseur_id);
    $requete->bindParam(':id', $id_article);

    // Exécution de la requête
    if ($requete->execute()) {
        // Redirection après succès de la mise à jour
        header('Location: details_article.php?id=' . $id_article);
        exit; // Arrêter l'exécution du script
    } else {
        $message = "Erreur lors de la mise à jour de l'article.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article <?= htmlspecialchars($article['nom_article']) ?></title>
    <link rel="stylesheet" href="modifier_article.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Modifier l'article <?= htmlspecialchars($article['nom_article']) ?></h1>
        <?php if (isset($message)) { echo '<p class="alert alert-danger">' . htmlspecialchars($message) . '</p>'; } ?>
        <form action="modifier_article.php?id=<?= $id_article ?>" method="POST">
            <div class="form-group">
                <label for="nom_article">Nom de l'article</label>
                <input type="text" class="form-control" id="nom_article" name="nom_article" value="<?= htmlspecialchars($article['nom_article']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description_article">Description</label>
                <textarea class="form-control" id="description_article" name="description_article" required><?= htmlspecialchars($article['description_article']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="prix_article">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix_article" name="prix_article" value="<?= htmlspecialchars($article['prix_article']) ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_article">Stock</label>
                <input type="number" class="form-control" id="stock_article" name="stock_article" value="<?= htmlspecialchars($article['stock_article']) ?>" required>
            </div>
            <div class="form-group">
                <label for="categorie_id">Catégorie</label>
                <select class="form-control" id="categorie_id" name="categorie_id" required>
                    <?php
                    // Récupération des catégories pour les options du menu déroulant
                    $requete = $bdd->query('SELECT id, nom FROM categories');
                    while ($categorie = $requete->fetch(PDO::FETCH_ASSOC)) {
                        $selected = $article['categorie_id'] == $categorie['id'] ? 'selected' : '';
                        echo '<option value="' . $categorie['id'] . '" ' . $selected . '>' . htmlspecialchars($categorie['nom']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fournisseur_id">Fournisseur</label>
                <select class="form-control" id="fournisseur_id" name="fournisseur_id" required>
                    <?php
                    // Récupération des fournisseurs pour les options du menu déroulant
                    $requete = $bdd->query('SELECT id, nom FROM fournisseurs');
                    while ($fournisseur = $requete->fetch(PDO::FETCH_ASSOC)) {
                        $selected = $article['fournisseur_id'] == $fournisseur['id'] ? 'selected' : '';
                        echo '<option value="' . $fournisseur['id'] . '" ' . $selected . '>' . htmlspecialchars($fournisseur['nom']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
        <p><a href="liste_articles.php" class="btn btn-secondary">Retour à la liste des articles</a></p>
    </div>

    <!-- Inclusion de Bootstrap JS et jQuery pour les fonctionnalités JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
