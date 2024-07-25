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
$email = $_POST['email'];
$age = $_POST['age'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hachage du mot de passe
$role = $_POST['role'];

// Préparation de la requête SQL
$stmt = $conn->prepare("INSERT INTO users (username, email, age, password, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $username, $email, $age, $password, $role);

// Exécution de la requête
if ($stmt->execute()) {
    echo "Inscription réussie !";
    // Redirection vers la page de connexion
    header("Location: index.php");
    exit();
} else {
    echo "Erreur: " . $stmt->error;
}

// Fermeture de la connexion
$stmt->close();
$conn->close();
?>
