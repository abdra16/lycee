<?php
// Récupérer l'ID de la commande depuis l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de commande non valide.");
}

$commandeId = $_GET['id'];

// Ici, vous pouvez récupérer les détails de la commande depuis la base de données
// et construire le contenu de la facture à imprimer
// Exemple simplifié :

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock"; // Remplacez par le nom de votre base de données

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les détails de la commande
    $sql = "SELECT c.id, a.nom_article, f.nom AS fournisseur_nom, cl.nom AS client_nom, cl.prenom AS client_prenom, cl.adresse AS client_adresse, cl.telephone AS client_telephone, c.quantite, c.prix_total, c.statut
            FROM commandes c
            LEFT JOIN article a ON c.id_article = a.id
            LEFT JOIN fournisseurs f ON c.id_fournisseur = f.id
            LEFT JOIN clients cl ON c.id = cl.id
            WHERE c.id = :commande_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':commande_id', $commandeId, PDO::PARAM_INT);
    $stmt->execute();
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si la commande existe
    if (!$commande) {
        die("Commande non trouvée.");
    }

    // Ici, vous pouvez générer le contenu de la facture
    $nom_article = $commande['nom_article'];
    $fournisseur_nom = $commande['fournisseur_nom'];
    $client_nom = $commande['client_nom'];
    $client_prenom = $commande['client_prenom'];
    $client_adresse = $commande['client_adresse'];
    $client_telephone = $commande['client_telephone'];
    $quantite = $commande['quantite'];
    $prix_total = $commande['prix_total'];

    // Exemple de contenu de la facture HTML
    $content = "
        <h2>Facture pour la Commande #{$commandeId}</h2>
        <p><strong>Nom de l'Article:</strong> {$nom_article}</p>
        <p><strong>Fournisseur:</strong> {$fournisseur_nom}</p>
        <p><strong>Nom du Client:</strong> {$client_nom} {$client_prenom}</p>
        <p><strong>Adresse:</strong> {$client_adresse}</p>
        <p><strong>Numéro de Téléphone:</strong> {$client_telephone}</p>
        <p><strong>Quantité:</strong> {$quantite}</p>
        <p><strong>Prix Total:</strong> {$prix_total}</p>
        <p><em>Signature Automatique</em></p>
    ";

    // Imprimer le contenu de la facture
    echo $content;

} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Fermeture de la connexion PDO
$pdo = null;
?>
