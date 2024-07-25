<?php
// Connexion à la base de données (à remplacer par vos informations de connexion)
$bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '');

// Suppression de tous les articles
$requete = $bdd->exec('DELETE FROM articles');

if ($requete === false) {
    http_response_code(500);
    echo json_encode(["error" => "Erreur lors de la suppression de tous les articles"]);
    exit;
}

echo json_encode(["success" => true]);
?>
