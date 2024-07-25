<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir un Fournisseur</title>
    <!-- Inclure Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Inclure vos styles CSS ici -->
    <link rel="stylesheet" href="fourni.css">
</head>
<body>
    <header>
        <!-- Header de votre site -->
        <h1><i class="fas fa-truck"></i> Choisir un Fournisseur</h1>
    </header>

    <main>
        <section id="choix-fournisseur">
            <h2><i class="fas fa-list"></i> Sélectionnez un Fournisseur</h2>
            <form action="passer_commande.php" method="post">
                <label for="fournisseur"><i class="fas fa-building"></i> Fournisseur :</label>
                <select name="fournisseur" id="fournisseur">
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

                    // Requête SQL pour récupérer tous les fournisseurs
                    $sql = "SELECT * FROM fournisseurs";
                    $result = $conn->query($sql);

                    // Vérification s'il y a des résultats
                    if ($result->num_rows > 0) {
                        // Affichage des options pour chaque fournisseur
                        while($row = $result->fetch_assoc()) {
                            // Construction de la chaîne affichée dans la liste déroulante
                            $info_fournisseur = $row["nom"] . " (" . $row["ville"] . ")";
                            echo "<option value='" . $row["id"] . "'>" . htmlspecialchars($info_fournisseur) . "</option>";
                        }
                    } else {
                        echo "<option value=''><i class='fas fa-exclamation-circle'></i> Aucun fournisseur trouvé</option>";
                    }

                    // Fermeture de la connexion
                    $conn->close();
                    ?>
                </select>
                <br><br>
                <button type="submit"><i class="fas fa-check-circle"></i> Choisir ce fournisseur</button>
            </form>
        </section>
    </main>

    <footer>
        <!-- Footer de votre site -->
        <p>&copy; 2024 Pharmacie Officine du Mali. Tous droits réservés.</p>
    </footer>
</body>
</html>
