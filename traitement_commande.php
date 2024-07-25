<?php
// Connexion à la base de données (à adapter avec vos paramètres)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "essai";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Fonction pour sécuriser les données
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $fournisseur_id = sanitizeInput($_POST['fournisseur_id']);
    $produits = $_POST['produit'];
    $quantites = $_POST['quantite'];
    $prix_fcfa = $_POST['prix_fcfa'];

    // Préparer et exécuter l'insertion de la commande
    $stmt = $conn->prepare("INSERT INTO commandes (fournisseur_id, produit, quantite, prix_fcfa) VALUES (?, ?, ?, ?)");

    // Vérifier si la préparation a réussi
    if (!$stmt) {
        die("Échec de la préparation de la requête : " . $conn->error);
    }

    // Boucle à travers les produits ajoutés
    for ($i = 0; $i < count($produits); $i++) {
        $produit = sanitizeInput($produits[$i]);
        $quantite = (int) sanitizeInput($quantites[$i]);
        $prix = (float) sanitizeInput($prix_fcfa[$i]);

        // Lier les paramètres
        $stmt->bind_param("isid", $fournisseur_id, $produit, $quantite, $prix);

        // Exécuter la requête
        if (!$stmt->execute()) {
            echo "Erreur lors de l'insertion : " . $stmt->error;
        }
    }

    // Fermeture de la déclaration
    $stmt->close();
    
    // Fermeture de la connexion
    $conn->close();

    // Redirection vers la page de facture avec un identifiant de commande
    header("Location: facture.php?fournisseur_id=" . urlencode($fournisseur_id));
    exit();
}
?>
