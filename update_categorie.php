<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $categorie_id = $_POST['id'];
    $nom = $_POST['name'];
    $description = $_POST['description'];

    // Connexion à la base de données
    $mysqli = new mysqli('localhost', 'root', '', 'essai');
    if ($mysqli->connect_errno) {
        echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
        exit();
    }

    // Préparer la requête SQL pour mettre à jour la catégorie
    $sql = "UPDATE categories SET nom = ?, description = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Liaison des paramètres
        $stmt->bind_param("ssi", $nom, $description, $categorie_id);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers la liste des catégories avec un message de succès
            header("Location: categorie.php?success=update");
            exit();
        } else {
            echo "Erreur lors de l'exécution de la requête: " . $stmt->error;
        }

        // Fermeture du statement
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête SQL: " . $mysqli->error;
    }

    // Fermer la connexion à la base de données
    $mysqli->close();
} else {
    // Redirection si le formulaire n'a pas été soumis
    header("Location: categorie.php");
    exit();
}
?>
