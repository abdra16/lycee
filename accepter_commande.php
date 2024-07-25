<?php
// Vérifier si l'identifiant de la commande est présent dans l'URL
if (isset($_GET['id'])) {
    $commande_id = $_GET['id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestion_stock"; // Remplacez par le nom de votre base de données

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mettre à jour le statut de la commande à "acceptee"
        $sql_update = "UPDATE commande SET statut = 'acceptee' WHERE id = :commande_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        $stmt_update->execute();

        // Redirection vers la page principale avec un message de succès
        header("Location: liste_commadmin.php?acceptee=1");
        exit();

    } catch(PDOException $e) {
        // En cas d'erreur lors de la connexion à la base de données ou de l'exécution de la requête, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }

    // Fermeture de la connexion PDO
    $pdo = null;
} else {
    // Si l'identifiant de la commande n'est pas présent dans l'URL, rediriger vers la page principale
    header("Location: liste_commadmin.php");
    exit();
}
?>
