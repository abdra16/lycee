<?php
$servername = "localhost"; // Adresse du serveur de base de données
$username = "root";        // Nom d'utilisateur de la base de données
$password = "";            // Mot de passe de la base de données
$dbname = "essai";      // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
