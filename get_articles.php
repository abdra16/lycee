<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "essai");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nom_article, prix_article FROM articles";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '" data-prix="' . $row['prix_article'] . '">' . $row['nom_article'] . '</option>';
    }
}

$conn->close();
?>
