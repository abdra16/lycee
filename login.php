<?php
// Informations de connexion à la base de données
$host = 'localhost';
$db = 'gestion_stock';
$user = 'root';
$pass = '';

// Connexion à la base de données
$conn = new mysqli($host, $user, $pass, $db);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Préparation de la requête SQL
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
$stmt->bind_param("ss", $username, $role);

// Exécution de la requête
$stmt->execute();
$result = $stmt->get_result();

// Vérification des résultats
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Vérification du mot de passe
    if (password_verify($password, $user['password'])) {
        // Démarrer la session
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirection en fonction du rôle
        if ($role === 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($role === 'supplier') {
            header("Location: supplier_dashboard.php");
        } elseif ($role === 'client') {
            header("Location: client_dashboard.php");
        }
        exit();
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Nom d'utilisateur ou rôle incorrect.";
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>
