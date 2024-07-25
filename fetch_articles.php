<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "essai";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête pour récupérer les articles
$sql = "SELECT id, nom_article, image_article FROM articles";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $image = $row['image_article'] ? 'data:image/jpeg;base64,' . base64_encode($row['image_article']) : 'img/default.jpg';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nom_article']) . "</td>";
        echo "<td><img src='$image' alt='Image de l'article' style='width: 100px; height: auto;'></td>";
        echo "<td><a href='details_article.php?id=" . $row['id'] . "' class='btn btn-info'><i class='fas fa-info-circle'></i> Détails</a></td>";
        echo "<td>
                <button class='btn btn-info options-btn' data-article-id='" . $row['id'] . "'><i class='fas fa-cogs'></i> Options</button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Aucun article trouvé</td></tr>";
}

$conn->close();
?>
