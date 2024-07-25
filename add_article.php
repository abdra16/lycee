<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "essai");

// Vérification de la connexion
if (!$conn) {
  die("Erreur de connexion : ". mysqli_connect_error());
}

// Traitement du formulaire d'ajout d'article
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nom_article = $_POST["nom_article"];
  $description_article = $_POST["description_article"];
  $prix_article = $_POST["prix_article"];
  $stock_article = $_POST["stock_article"];
  $categorie_id = $_POST["categorie_article"];
  $fournisseur_id = $_POST["fournisseur_article"];
  $image_article = $_FILES["image_article"];

  // Vérification des champs obligatoires
  if (empty($nom_article) || empty($description_article) || empty($prix_article) || empty($stock_article) || empty($categorie_id) || empty($fournisseur_id)) {
    $error = "Veuillez remplir tous les champs obligatoires";
  } else {
    // Insertion de l'article dans la base de données
    $query = "INSERT INTO articles (nom_article, description_article, prix_article, stock_article, categorie_id, fournisseur_id, image_article) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssss", $nom_article, $description_article, $prix_article, $stock_article, $categorie_id, $fournisseur_id, $image_data);
    $image_data = file_get_contents($image_article["tmp_name"]); // Lecture du contenu de l'image
    mysqli_stmt_execute($stmt);

    // Récupération de l'ID de l'article créé
    $article_id = mysqli_insert_id($conn);

    // Redirection vers la page "articles" avec le message de succès
    header("Location: article.php?success=true");
    exit;
  }
}

// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>