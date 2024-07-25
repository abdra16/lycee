<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=gestion_stock', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fonction pour récupérer les ventes sur une période spécifique ou par client
function getSales($start_date = null, $end_date = null, $client_id = null) {
    global $pdo;
    
    $sql = "SELECT v.*, a.nom_article, c.nom AS nom_client, c.prenom AS prenom_client 
            FROM ventes v 
            INNER JOIN article a ON v.id_article = a.id 
            INNER JOIN clients c ON v.id_client = c.id";
    
    $params = [];
    $where = [];

    if ($start_date && $end_date) {
        $where[] = "date_vente BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;
    }

    if ($client_id) {
        $where[] = "v.id_client = ?";
        $params[] = $client_id;
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Exemple d'utilisation : récupérer toutes les ventes
$sales = getSales();

// Ou récupérer les ventes pour un client spécifique
// $sales = getSales(null, null, $client_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vue d'ensemble des ventes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Vue d'ensemble des ventes</h1>

        <!-- Affichage des ventes -->
        <div class="sales-list">
            <table>
                <thead>
                    <tr>
                        <th>ID Vente</th>
                        <th>Article</th>
                        <th>Quantité</th>
                        <th>Client</th>
                        <th>Prix Total</th>
                        <th>Date de Vente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= $sale['id'] ?></td>
                            <td><?= $sale['nom_article'] ?></td>
                            <td><?= $sale['quantite'] ?></td>
                            <td><?= $sale['nom_client'] . ' ' . $sale['prenom_client'] ?></td>
                            <td><?= $sale['prix'] ?></td>
                            <td><?= $sale['date_vente'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
