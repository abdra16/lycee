<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="liste_arti.css">
    <!-- Inline CSS pour l'image de fond -->
</head>
<body>
    <div class="container">
    <h1><i class="fas fa-list"></i> Liste des Articles</h1>

        <!-- Boutons d'actions -->
        <a href="dashboard.php" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>
        <a href="article.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Ajouter un Article</a>
        <button id="delete-all-btn" class="btn btn-danger mb-3"><i class="fas fa-trash-alt"></i> Supprimer Tout</button>
        
        <table class="table table-striped table-bordered">
        <thead>
    <tr>
        <th><i class="fas fa-box"></i> Nom de l'Article</th>
        <th><i class="fas fa-image"></i> Image</th>
        <th><i class="fas fa-info-circle"></i> Détails</th>
        <th><i class="fas fa-cogs"></i> Actions</th>
    </tr>
</thead>

            <tbody>
                <?php include 'fetch_articles.php'; ?>
            </tbody>
        </table>
    </div>

    <!-- Inclusion de Bootstrap JS et jQuery pour les fonctionnalités JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script JavaScript pour les options des articles -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const optionButtons = document.querySelectorAll('.options-btn');
            
            optionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const articleId = this.getAttribute('data-article-id');
                    let action = prompt("Voulez-vous modifier, supprimer ou réapprovisionner l'article ?", "modifier / supprimer / réapprovisionner");
                    
                    if (action) {
                        action = action.toLowerCase();
                        switch (action) {
                            case 'modifier':
                                window.location.href = 'modifier_article.php?id=' + articleId;
                                break;
                            case 'supprimer':
                                if (confirm("Êtes-vous sûr de vouloir supprimer cet article ?")) {
                                    supprimerArticle(articleId);
                                }
                                break;
                            case 'réapprovisionner':
                                window.location.href = 'reapprovisionner_article.php?id=' + articleId;
                                break;
                            default:
                                alert("Action non reconnue. Veuillez entrer 'modifier', 'supprimer' ou 'réapprovisionner'.");
                        }
                    }
                });
            });

            // Fonction pour supprimer un article par ID
            function supprimerArticle(articleId) {
                fetch('supprimer_article.php?id=' + articleId, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la suppression des articles');
                    }
                    // Actualiser la page après la suppression
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la suppression des articles.');
                });
            }

            // Gestion du bouton "Supprimer Tout"
            const deleteAllBtn = document.getElementById('delete-all-btn');
            deleteAllBtn.addEventListener('click', function() {
                if (confirm("Êtes-vous sûr de vouloir supprimer tous les articles ?")) {
                    fetch('supprimer_tous_articles.php', {
                        method: 'DELETE'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur lors de la suppression de tous les articles');
                        }
                        // Actualiser la page après la suppression
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors de la suppression de tous les articles.');
                    });
                }
            });
        });
    </script>
</body>
</html>
