<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Vente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Formulaire de Vente</h1>
    </header>
    <main>
        <form action="formulaire_vente.php" method="post">
            <div class="form-group">
                <label for="client_name">Nom du Client:</label>
                <input type="text" id="client_name" name="client_name" required>
            </div>

            <div class="form-group">
                <label for="client_email">Email du Client:</label>
                <input type="email" id="client_email" name="client_email" required>
            </div>

            <h2>Articles Disponibles</h2>
            <div class="articles">
                <?php
                // Connexion à la base de données
                $pdo = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

                // Récupération des articles
                $stmt = $pdo->query("SELECT id, nom_article, prix_article, stock_article FROM articles");
                $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($articles as $article):
                ?>
                <div class="article">
                    <p><strong><?php echo htmlspecialchars($article['nom_article']); ?></strong></p>
                    <p>Prix: <?php echo htmlspecialchars($article['prix_article']); ?> EUR</p>
                    <p>Stock: <?php echo htmlspecialchars($article['stock_article']); ?></p>
                    <label>
                        Quantité:
                        <input type="number" name="articles[<?php echo $article['id']; ?>]" min="1" max="<?php echo $article['stock_article']; ?>" placeholder="Quantité">
                    </label>
                </div>
                <?php endforeach; ?>
            </div>

            <button type="submit">Valider la Vente</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Pharmacie Officine du Centre</p>
    </footer>
</body>
</html>
