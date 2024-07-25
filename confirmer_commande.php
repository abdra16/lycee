<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "essai";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifiez si la clé 'action' et 'commande_id' existent dans $_POST
    if (isset($_POST['action'], $_POST['commande_id'])) {
        $commande_id = intval($_POST['commande_id']);
        $action = $_POST['action']; // "accepter" ou "annuler"

        // Définir le statut en fonction de l'action
        $statut = '';
        if ($action == 'accepter') {
            $statut = 'Acceptée';
        } elseif ($action == 'annuler') {
            $statut = 'Annulée';
        } else {
            die("Action non valide.");
        }

        // Préparez la mise à jour du statut
        $sql_update = "UPDATE articles_commandes SET statut = ? WHERE commande_id = ?";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update === false) {
            die("Erreur lors de la préparation de la requête de mise à jour : " . $conn->error);
        }

        $stmt_update->bind_param("si", $statut, $commande_id);

        if ($stmt_update->execute()) {
            // Récupérer le username associé à la commande
            $sql_user = "SELECT username FROM user_orders WHERE commande_id = ?";
            $stmt_user = $conn->prepare($sql_user);

            if ($stmt_user === false) {
                die("Erreur lors de la préparation de la requête pour récupérer l'utilisateur : " . $conn->error);
            }

            $stmt_user->bind_param("i", $commande_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $username = $result_user->fetch_assoc()['username'];

            // Enregistrer le message dans la table des messages
            $message = "Votre commande a été " . strtolower($statut) . ". Merci pour votre patience.";
            $sql_message = "INSERT INTO messages (username, message, statut) VALUES (?, ?, 'non lu')";
            $stmt_message = $conn->prepare($sql_message);

            if ($stmt_message === false) {
                die("Erreur lors de la préparation de la requête pour enregistrer le message : " . $conn->error);
            }

            $stmt_message->bind_param("ss", $username, $message);

            if ($stmt_message->execute()) {
                // Redirection après traitement
                header("Location: confirmation.php?status=success");
                exit();
            } else {
                die("Erreur lors de l'enregistrement du message : " . $stmt_message->error);
            }
        } else {
            die("Erreur lors de la mise à jour du statut : " . $stmt_update->error);
        }
    } else {
        die("Données manquantes dans le formulaire.");
    }
}

$conn->close();
?>
