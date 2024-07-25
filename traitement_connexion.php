<?php
session_start();
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Tous les champs sont obligatoires.";
        header("Location: index.php");
        exit();
    }

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE username = ?");

    if ($stmt === false) {
        $_SESSION['error_message'] = "Erreur dans la préparation de la requête SQL.";
        header("Location: index.php");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['success_message'] = "Connexion réussie. Bienvenue, " . $admin['username'] . "!";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Mot de passe incorrect.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Nom d'utilisateur incorrect.";
        header("Location: index.php");
        exit();
    }
}
?>
