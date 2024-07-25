<?php
session_start();
include 'db_conn.php'; // Fichier de connexion à la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et valider les données du formulaire
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
        header("Location: login.php");
        exit();
    }

    // Hacher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer et exécuter la requête d'insertion
    $sql = "INSERT INTO administrateurs (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header("Location: login.php");
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            header("Location: login.php");
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Erreur de préparation de la requête.";
        header("Location: login.php");
    }

    // Fermer la connexion
    $conn->close();
} else {
    header("Location: login.php");
}
?>
