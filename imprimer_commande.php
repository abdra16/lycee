<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock";

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fonction pour récupérer les détails d'une commande depuis la base de données
    function getCommandeDetails($id_commande, $pdo) {
        $stmt = $pdo->prepare("SELECT c.id, c.date_commande, ca.quantite AS quantite, ca.prix AS prix_total, a.nom_article, c.nom AS client_nom, c.prenom, c.telephone, c.adresse, c.statut
                               FROM commande c
                               INNER JOIN commande_article ca ON c.id = ca.id_commande
                               INNER JOIN article a ON ca.id_article = a.id
                               WHERE c.id = ?");
        $stmt->execute([$id_commande]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vérifier si l'ID de la commande est présent dans l'URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID de commande non valide.");
    }

    $id_commande = $_GET['id'];

    // Récupérer les détails de la commande spécifiée
    $commande = getCommandeDetails($id_commande, $pdo);

    if (!$commande) {
        die("Commande non trouvée.");
    }

    // Déterminer le statut de la commande pour affichage
    $statut_commande = '';
    switch ($commande['statut']) {
        case 'acceptee':
            $statut_commande = 'Facture payée';
            break;
        default:
            $statut_commande = 'Facture non payée';
            break;
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture Commande #<?= $commande['id'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #007bff;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .hidden-print {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        .hidden-print:hover {
            background-color: #0056b3;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>FACTURE</h2>
        <p>Reçu N° #: <?= $commande['id'] ?></p>
        <p>Date: <?= date('d/m/Y H:i:s', strtotime($commande['date_commande'])) ?></p>
        <p>Statut: <?= $statut_commande ?></p> <!-- Affichage du statut de la commande -->
    </div>

    <div class="info">
        <div class="info-item">
            <p><strong>Nom du client :</strong> <?= htmlspecialchars($commande['client_nom'] . ' ' . $commande['prenom']) ?></p>
        </div>
        <div class="info-item">
            <p><strong>Tel :</strong> <?= htmlspecialchars($commande['telephone']) ?></p>
        </div>
        <div class="info-item">
            <p><strong>Adresse :</strong> <?= htmlspecialchars($commande['adresse']) ?></p>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Designation</th>
                    <th>Quantité</th>
                    <th>Prix total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($commande['nom_article']) ?></td>
                    <td><?= htmlspecialchars($commande['quantite']) ?></td>
                    <td><?= htmlspecialchars($commande['prix_total']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bouton pour imprimer la facture -->
    <button class="hidden-print" onclick="window.print();"><i class='bx bx-printer'></i> Imprimer</button>

    <div class="signature">
        <p>Signature : Votre Entreprise</p>
    </div>
</div>

</body>
</html>
