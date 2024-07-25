<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <link rel="stylesheet" href="fact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1><i class="fas fa-file-invoice"></i> Facture</h1>
    </header>

    <main>
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

        // Récupérer l'identifiant du fournisseur depuis l'URL
        $fournisseur_id = isset($_GET['fournisseur_id']) ? intval($_GET['fournisseur_id']) : 0;

        // Préparer et exécuter la requête pour obtenir les détails de la facture
        $sql = "SELECT * FROM commandes WHERE fournisseur_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fournisseur_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Afficher les détails de la facture
        if ($result->num_rows > 0) {
            echo "<h2><i class='fas fa-list'></i> Détails de la Commande</h2>";
            echo "<table>";
            echo "<tr><th><i class='fas fa-box'></i> Produit</th><th><i class='fas fa-sort-numeric-up'></i> Quantité</th><th><i class='fas fa-money-bill-wave'></i> Prix en FCFA</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['produit']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantite']) . "</td>";
                echo "<td>" . htmlspecialchars($row['prix_fcfa']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p><i class='fas fa-exclamation-triangle'></i> Aucune commande trouvée pour ce fournisseur.</p>";
        }

        // Fermeture de la connexion
        $conn->close();
        ?>

        <!-- Boutons Imprimer et Retour -->
        <div class="btn-container">
            <a href="#" class="btn btn-print" onclick="window.print()"><i class="fas fa-print"></i> Imprimer</a>
            <a href="javascript:history.back()" class="btn btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Pharmacie Officine du Mali. Tous droits réservés. <i class="fas fa-copyright"></i></p>
    </footer>
</body>
</html>
