<?php
// Vérifier si le formulaire a été soumis et le champ 'id' est présent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Récupérer l'ID de la catégorie à supprimer depuis le formulaire
    $categorie_id = $_POST['id'];

    // Connexion à la base de données
    $mysqli = new mysqli('localhost', 'root', '', 'essai');
    if ($mysqli->connect_errno) {
        echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
        exit();
    }

    // Préparer la requête SQL pour supprimer la catégorie
    $sql = "DELETE FROM categorie WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Liaison des paramètres
        $stmt->bind_param("i", $categorie_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            // Redirection vers la liste des catégories après suppression avec un message de confirmation
            header("Location: categorie.php?success=1");
            exit();
        } else {
            echo "Erreur lors de la suppression de la catégorie: " . $stmt->error;
        }

        // Fermeture du statement
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête SQL: " . $mysqli->error;
    }

    // Fermer la connexion à la base de données
    $mysqli->close();
} else {
    // Redirection vers une page d'erreur si l'ID n'est pas spécifié ou le formulaire n'est pas soumis correctement
    header("Location: erreur.php");
    exit();
}
?>
