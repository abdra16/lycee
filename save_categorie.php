<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les données nécessaires sont présentes
    if (isset($_POST['name']) && isset($_POST['description'])) {
        // Récupérer les données du formulaire
        $name = $_POST['name'];
        $description = $_POST['description'];

        // Connexion à la base de données
        $mysqli = new mysqli('localhost', 'root', '', 'essai');
        if ($mysqli->connect_errno) {
            echo "Erreur de connexion à la base de données: " . $mysqli->connect_error;
            exit();
        }

        // Préparer la requête d'insertion
        $sql = "INSERT INTO categorie (name, description, created_at) VALUES (?, ?, NOW())";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            echo "Erreur de préparation de la requête SQL: " . $mysqli->error;
            $mysqli->close();
            exit();
        }

        // Liage des paramètres et exécution de la requête
        $stmt->bind_param("ss", $name, $description);
        if ($stmt->execute()) {
            // Succès de l'insertion
            $success_message = "La catégorie \"$name\" a été ajoutée avec succès.";

            // Redirection vers ajouter_categorie.php avec le message de succès
            header("Location: ajouter_categorie.php?success=" . urlencode($success_message));
            exit();
        } else {
            // Erreur lors de l'exécution de la requête
            echo "Erreur lors de l'insertion des données: " . $stmt->error;
        }

        // Fermeture du statement et de la connexion
        $stmt->close();
        $mysqli->close();
    } else {
        // Données manquantes dans le formulaire
        echo "Veuillez remplir tous les champs du formulaire.";
    }
} else {
    // Méthode de requête incorrecte
    echo "Méthode de requête non autorisée.";
}
?>
