<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Mouvements de Stock</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CSS personnalisé -->
    <style>
        /* Réinitialiser les marges et les paddings par défaut */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Style pour le body avec une image de fond */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0; /* Couleur de fond de secours */
            background-image: url('img/entrepot.jpg'); /* Chemin vers votre image de fond */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: white; /* Couleur de texte pour tout le corps */
        }

        /* Container principal */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Fond blanc transparent */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Style pour le titre */
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
            color: #fff; /* Couleur de texte pour le titre */
        }

        /* Style pour les boutons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff; /* Bleu */
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Bleu foncé au survol */
        }

        .btn-danger {
            background-color: #dc3545; /* Rouge */
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333; /* Rouge foncé au survol */
        }

        /* Style pour la table des mouvements */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #fff; /* Couleur de texte pour les cellules de la table */
        }

        .table th {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); /* Fond gris clair pour les entêtes */
        }

        /* Style pour les boutons dans les cellules de la table */
        .table .btn {
            margin: 0;
        }

        /* Responsive design pour la table */
        @media (max-width: 768px) {
            .table th, .table td {
                padding: 8px;
            }
            .btn {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Mouvements de Stock</h1>

        <!-- Bouton de retour -->
        <a href="dashboard.php" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>

        <!-- Tableau des articles avec détails et mouvements de stock -->
        <table class="table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Stock Actuel</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données (à remplacer par vos informations de connexion)
                $bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

                // Requête pour récupérer la liste des articles avec leurs détails et le stock actuel
                $requete = $bdd->query('SELECT id, nom_article, description_article, prix_article, stock_article FROM articles');
                $articles = $requete->fetchAll();

                foreach ($articles as $article) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($article['nom_article']) ?></td>
                        <td><?= htmlspecialchars($article['description_article']) ?></td>
                        <td><?= number_format($article['prix_article'], 2, ',', ' ') ?> €</td>
                        <td><?= $article['stock_article'] ?></td>
                        <td>
                            <a href="ajouter_stock.php?id=<?= $article['id'] ?>" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter Stock</a>
                            <a href="retirer_stock.php?id=<?= $article['id'] ?>" class="btn btn-warning"><i class="fas fa-minus"></i> Retirer Stock</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Inclusion de Bootstrap JS et jQuery pour les fonctionnalités JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
