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
    <link rel="stylesheet" href="moo.css">
    <!-- Inline CSS pour l'image de fond -->

</head>
<body>
    <div class="container">
        <h1>Gestion des Mouvements de Stock</h1>
        <a href="dashboard.php" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Article</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données (à remplacer par vos informations de connexion)
                $bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

                // Requête pour récupérer les mouvements de stock
                $requete = $bdd->query('SELECT * FROM mouvements_stock');
                $mouvements = $requete->fetchAll();

                foreach ($mouvements as $mouvement) {
                    ?>
                    <tr>
                        <th scope="row"><?= $mouvement['id'] ?></th>
                        <td><?= $mouvement['article'] ?></td>
                        <td><?= $mouvement['quantite'] ?></td>
                        <td><?= $mouvement['type'] ?></td>
                        <td><?= $mouvement['date_mouvement'] ?></td>
                        <td>
                            <a href="modifier_mouvement.php?id=<?= $mouvement['id'] ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                            <a href="supprimer_mouvement.php?id=<?= $mouvement['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?');"><i class="fas fa-trash-alt"></i> Supprimer</a>
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
