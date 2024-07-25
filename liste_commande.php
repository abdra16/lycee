<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "essai";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mise à jour du statut
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_statut'])) {
        $commande_id = $_POST['commande_id'];
        $nouveau_statut = $_POST['nouveau_statut'];

        $sql_update = "UPDATE commandes SET statut = :nouveau_statut WHERE id = :commande_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':nouveau_statut', $nouveau_statut, PDO::PARAM_STR);
        $stmt_update->bindParam(':commande_id', $commande_id, PDO::PARAM_INT);
        $stmt_update->execute();
    }

    // Récupération des commandes avec les noms des fournisseurs
    $sql = "SELECT c.id, f.nom AS NomFournisseur, c.produit, c.quantite, c.prix_fcfa, c.date_commande, c.statut 
            FROM commandes c 
            JOIN fournisseurs f ON c.fournisseur_id = f.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
    $commandes = [];
    echo $error; 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="lis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Liste des Commandes</h2>
        <div class="mb-3">
            <a href="choisir_fournisseur.php" class="btn btn-success"><i class="fas fa-plus-circle"></i> Ajouter une Commande</a>
            <a href="dashboard.php" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </div>

        <div class="legend">
            <p><span class="color-box" style="background-color: rgba(255, 165, 0, 0.7);"></span> En attente</p>
            <p><span class="color-box" style="background-color: rgba(0, 128, 0, 0.7);"></span> Acceptée</p>
            <p><span class="color-box" style="background-color: rgba(255, 0, 0, 0.7);"></span> Annulée</p>
            <p><span class="color-box" style="background-color: rgba(128, 0, 128, 0.7);"></span> Rupture de stock</p>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><i class="fas fa-file-alt"></i> ID</th>
                    <th><i class="fas fa-user"></i> Nom Fournisseur</th>
                    <th><i class="fas fa-file-alt"></i> Produit</th>
                    <th><i class="fas fa-shopping-cart"></i> Quantité</th>
                    <th><i class="fas fa-euro-sign"></i> Prix FCFA</th>
                    <th><i class="far fa-calendar-alt"></i> Date Commande</th>
                    <th><i class="fas fa-info-circle"></i> Statut</th>
                    <th><i class="fas fa-eye"></i> Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($commandes)) {
                    foreach ($commandes as $commande) {
                        $statusClass = '';
                        switch ($commande['statut']) {
                            case 'En attente':
                                $statusClass = 'status-en-attente';
                                break;
                            case 'Acceptée':
                                $statusClass = 'status-acceptee';
                                break;
                            case 'Annulée':
                                $statusClass = 'status-annulee';
                                break;
                            case 'Rupture':
                                $statusClass = 'status-rupture';
                                break;
                        }
                        echo "<tr class='{$statusClass}'>
                                <td>{$commande['id']}</td>
                                <td>{$commande['NomFournisseur']}</td>
                                <td>{$commande['produit']}</td>
                                <td>{$commande['quantite']}</td>
                                <td>{$commande['prix_fcfa']}</td>
                                <td>{$commande['date_commande']}</td>
                                <td>
                                    <form method='post' action=''>
                                        <input type='hidden' name='commande_id' value='{$commande['id']}' />
                                        <select name='nouveau_statut' onchange='this.form.submit()'>
                                            <option value='En attente' " . ($commande['statut'] == 'En attente' ? 'selected' : '') . ">En attente</option>
                                            <option value='Acceptée' " . ($commande['statut'] == 'Acceptée' ? 'selected' : '') . ">Acceptée</option>
                                            <option value='Rupture' " . ($commande['statut'] == 'Rupture' ? 'selected' : '') . ">Rupture de stock</option>
                                            <option value='Annulée' " . ($commande['statut'] == 'Annulée' ? 'selected' : '') . ">Annulée</option>
                                        </select>
                                        <input type='hidden' name='update_statut' />
                                    </form>
                                </td>
                                <td>
                                    <a href='details_commande.php?id={$commande['id']}' class='btn btn-info'><i class='fas fa-eye'></i> Détails</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Aucune commande trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
