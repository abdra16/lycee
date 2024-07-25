<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Stock</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: normal;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .fa-pills {
            color: #4CAF50;
        }
        .fa-box-open {
            color: #FFC107;
        }
        .fa-calendar-alt {
            color: #2196F3;
        }
        .liste_ul ul {
            list-style-type: none;
            padding: 0;
        }
        .liste_ul ul li {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .liste_ul ul li i {
            margin-right: 10px;
        }
        .liste_ul ul li strong {
            font-weight: bold;
            color: red;
        }
        .section_title {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
<a href="admin_dashboard.php" class="redirect-button">RETOUR</a>
    <h3>Les stocks en cours (basé sur les articles)</h3>
    <table>
        <tr>
            <th><i class="fas fa-box-open"></i> Article ID</th>
            <th><i class="fas fa-pills"></i> Nom de l'Article</th>
            <th><i class="fas fa-box-open"></i> Quantité Stock</th>
           
        </tr>
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gestion_stock"; // Remplacez par le nom de votre base de données

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }

        // Requête SQL pour récupérer les informations sur les articles
        $sqlArticles = "SELECT id, nom_article, quantite FROM article";
        $resultArticles = $conn->query($sqlArticles);

        if ($resultArticles) {
            // Afficher les données de chaque ligne dans le tableau
            while ($row = $resultArticles->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nom_article"] . "</td>";
                echo "<td>" . $row["quantite"] . "</td>";
               
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune donnée d'article trouvée.</td></tr>";
        }

        ?>
    </table>

    <h3 class="section_title">Les sorties des produits (basé sur les commandes)</h3>
    <div class="liste_ul">
        <ul>
            <?php
            // Requête SQL pour obtenir les commandes et calculer les sorties de stock
            $sqlCommandes = "SELECT article.nom_article AS nom_article, SUM(commande.quantite) AS quantite_commande
                             FROM commande
                             INNER JOIN article ON commande.id_article = article.id 
                             GROUP BY article.nom_article";
            $resultCommandes = $conn->query($sqlCommandes);

            if ($resultCommandes) {
                // Afficher les produits commandés
                while ($rowCommande = $resultCommandes->fetch_assoc()) {
                    echo "<li><i class='fas fa-box'></i> " . $rowCommande['nom_article'] . ", Quantité Total Commandée: <strong>" . $rowCommande['quantite_commande'] . "</strong></li>";
                }
            } else {
                echo "<li>Aucune donnée de commande trouvée.</li>";
            }

            // Fermer la connexion
            $conn->close();
            ?>
        </ul>
    </div>

</div>

</body>
</html>
