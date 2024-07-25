<?php
// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $article_id = htmlspecialchars($_POST['article_id']);
    $quantite = intval($_POST['quantite']); // Convertir en entier pour sécurité
    
    // Vérification si la quantité est positive
    if ($quantite > 0) {
        try {
            // Connexion à la base de données (à remplacer par vos informations de connexion)
            $bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

            // Désactiver le mode émulation pour éviter les injections SQL
            $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Commencer une transaction
            $bdd->beginTransaction();

            // Sélectionner l'article pour verrouiller la ligne et éviter les problèmes de concurrence
            $requete_select = $bdd->prepare('SELECT * FROM articles WHERE id = :article_id FOR UPDATE');
            $requete_select->bindParam(':article_id', $article_id);
            $requete_select->execute();

            // Vérifier si l'article existe et récupérer ses informations
            $article = $requete_select->fetch(PDO::FETCH_ASSOC);
            if (!$article) {
                throw new Exception("L'article avec l'ID $article_id n'existe pas.");
            }

            // Mettre à jour la quantité de l'article
            $nouveau_stock = $article['stock_article'] + $quantite;
            $requete_update = $bdd->prepare('UPDATE articles SET stock_article = :nouveau_stock WHERE id = :article_id');
            $requete_update->bindParam(':nouveau_stock', $nouveau_stock);
            $requete_update->bindParam(':article_id', $article_id);
            $requete_update->execute();

            // Valider la transaction
            $bdd->commit();

            // Redirection vers la liste des articles avec un message de succès
            header('Location: liste_articles.php?reapprovisionnement=success');
            exit();
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $bdd->rollBack();
            echo "Erreur de base de données : " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "La quantité doit être supérieure à zéro.";
    }
} else {
    // Redirection si le formulaire n'est pas soumis
    header('Location: liste_articles.php');
    exit();
}
?>
