<?php
// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "essai");

// Vérification de la connexion
if (!$conn) {
  die("Erreur de connexion : ". mysqli_connect_error());
}

// Récupération des catégories à partir de la base de données
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
$categories = array();
while ($row = mysqli_fetch_assoc($result)) {
  $categories[] = $row;
}

// Récupération des fournisseurs à partir de la base de données
$query = "SELECT * FROM fournisseurs";
$result = mysqli_query($conn, $query);
$fournisseurs = array();
while ($row = mysqli_fetch_assoc($result)) {
  $fournisseurs[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un article</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="arti.css"> <!-- Assurez-vous d'ajuster le chemin vers votre fichier CSS -->
</head>
<body>

<div class="container">
<?php if (isset($_GET["success"]) && $_GET["success"] == "true" && isset($_GET["message"])) {?>
    <div class="alert alert-success">
      <?php echo $_GET["message"];?>
    </div>
  <?php }?>
  <h2><i class="fas fa-plus-circle"></i> Ajouter un article</h2>
  <form action="add_article.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="nom_article"><i class="fas fa-pencil-alt"></i> Nom de l'article :</label>
      <input type="text" id="nom_article" name="nom_article" required>
    </div>
    <div class="form-group">
      <label for="description_article"><i class="fas fa-align-left"></i> Description de l'article :</label>
      <textarea id="description_article" name="description_article" required></textarea>
    </div>
    <div class="form-group">
      <label for="prix_article"><i class="fas fa-money-bill-wave"></i> Prix de l'article :</label>
      <input type="number" id="prix_article" name="prix_article" required>
    </div>
    <div class="form-group">
      <label for="stock_article"><i class="fas fa-cubes"></i> Stock initial :</label>
      <input type="number" id="stock_article" name="stock_article" required>
    </div>
    <div class="form-group">
      <label for="categorie_article"><i class="fas fa-tag"></i> Catégorie de l'article :</label>
      <select id="categorie_article" name="categorie_article" required>
        <option value="">Sélectionnez une catégorie</option>
        <?php foreach ($categories as $categorie) {?>
          <option value="<?php echo $categorie['id'];?>"><?php echo $categorie['nom'];?></option>
        <?php }?>
      </select>
    </div>
    <div class="form-group">
      <label for="fournisseur_article"><i class="fas fa-truck"></i> Fournisseur de l'article :</label>
      <select id="fournisseur_article" name="fournisseur_article" required>
        <option value="">Sélectionnez un fournisseur</option>
        <?php foreach ($fournisseurs as $fournisseur) {?>
          <option value="<?php echo $fournisseur['id'];?>"><?php echo $fournisseur['nom'];?></option>
        <?php }?>
      </select>
    </div>
    <div class="form-group">
      <label for="image_article"><i class="fas fa-image"></i> Image de l'article :</label>
      <input type="file" id="image_article" name="image_article">
      <img id="preview" src="" alt="Image de l'article">
    </div>
    <div class="form-group">
      <input type="submit" value="Ajouter l'article" class="btn btn-primary">
    </div>
  </form>
  <a href="liste_articles.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Retour
</a>

</div>

<script>
  const imageInput = document.getElementById('image_article');
  const previewImage = document.getElementById('preview');

  imageInput.addEventListener('change', (e) => {
    const file = imageInput.files[0];
    const reader = new FileReader();

    reader.onload = (e) => {
      previewImage.src = e.target.result;
    };

    reader.readAsDataURL(file);
  });
</script>

</body>
</html>