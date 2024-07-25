<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Passer Commande</title>
    <!-- Inclure vos styles CSS ici -->
    <link rel="stylesheet" href="pass.css">
    <!-- Inclure Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <!-- Header de votre site -->
        <?php
        // Initialisation des variables
        $nom_fournisseur = "";
        $adresse_fournisseur = "";
        $email_fournisseur = "";

        // Vérifier si un fournisseur a été choisi
        if (isset($_POST['fournisseur'])) {
            $fournisseur_id = intval($_POST['fournisseur']); // Utilisation de intval pour éviter les injections SQL

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

            // Préparation de la requête pour récupérer les détails du fournisseur
            $sql = "SELECT nom, adresse, email FROM fournisseurs WHERE id = $fournisseur_id";
            $result = $conn->query($sql);

            // Vérification s'il y a des résultats
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nom_fournisseur = $row['nom'];
                $adresse_fournisseur = $row['adresse'];
                $email_fournisseur = $row['email'];
            }

            // Fermeture de la connexion
            $conn->close();
        }
        ?>
        <h1><i class="fas fa-shopping-cart"></i> Passer une Commande chez <?php echo htmlspecialchars($nom_fournisseur); ?></h1>
        <!-- Bouton de retour -->
        <button onclick="window.history.back();" class="btn-retour"><i class="fas fa-arrow-left"></i> Retour</button>
    </header>

    <main>
        <section id="details-fournisseur">
            <!-- Afficher les détails du fournisseur ici -->
            <?php
            // Vérifier si un fournisseur a été choisi
            if (!empty($nom_fournisseur)) {
                echo "<h2><i class=\"far fa-address-card\"></i> Détails du Fournisseur</h2>";
                echo "<p><i class=\"fas fa-user\"></i> Nom: " . htmlspecialchars($nom_fournisseur) . "</p>";
                echo "<p><i class=\"fas fa-map-marker-alt\"></i> Adresse: " . htmlspecialchars($adresse_fournisseur) . "</p>";
                echo "<p><i class=\"far fa-envelope\"></i> Email: " . htmlspecialchars($email_fournisseur) . "</p>";
            } else {
                echo "<p>Aucun fournisseur sélectionné.</p>";
            }
            ?>
        </section>

        <section id="details-commandes">
            <!-- Liste des produits ajoutés -->
            <?php
            if (isset($_POST['produit'])) {
                echo "<h2><i class=\"fas fa-check-circle\"></i> Produits Ajoutés</h2>";
                echo "<ul>";
                $produits = $_POST['produit'];
                $quantites = $_POST['quantite'];
                $prix_fcfa = $_POST['prix_fcfa'];

                // Parcourir tous les produits ajoutés
                for ($i = 0; $i < count($produits); $i++) {
                    echo "<li><i class=\"fas fa-box\"></i> <strong>Produit:</strong> " . htmlspecialchars($produits[$i]) . "</li>";
                    echo "<li><i class=\"fas fa-sort-numeric-up\"></i> <strong>Quantité:</strong> " . htmlspecialchars($quantites[$i]) . "</li>";
                    echo "<li><i class=\"fas fa-money-bill-wave\"></i> <strong>Prix en FCFA:</strong> " . htmlspecialchars($prix_fcfa[$i]) . "</li>";
                }
                echo "</ul>";
            }
            ?>
        </section>

        <section id="passer-commande">
            <!-- Formulaire de commande -->
            <h2><i class="fas fa-cart-plus"></i> Formulaire de Commande</h2>
            <form action="traitement_commande.php" method="post" id="commande-form">
                <input type="hidden" name="fournisseur_id" value="<?php echo htmlspecialchars($_POST['fournisseur']); ?>">

                <div id="produits">
                    <div class="produit">
                        <label for="produit1"><i class="fas fa-box"></i> Produit:</label>
                        <input type="text" name="produit[]" id="produit1" required>

                        <label for="quantite1"><i class="fas fa-sort-numeric-up"></i> Quantité:</label>
                        <input type="number" name="quantite[]" id="quantite1" required>

                        <label for="prix_fcfa1"><i class="fas fa-money-bill"></i> Prix en FCFA:</label>
                        <input type="text" name="prix_fcfa[]" id="prix_fcfa1" required>
                    </div>
                </div>
                <button type="button" onclick="ajouterProduit()"><i class="fas fa-plus"></i> Ajouter un produit</button><br><br>
                <!-- Utilisation d'un bouton avec une icône Font Awesome -->
                <button type="submit"><i class="fas fa-arrow-right"></i> Passer la Commande</button>
            </form>
        </section>
    </main>

    <script>
        var count = 1; // Compteur pour les produits ajoutés

        function ajouterProduit() {
            count++;

            var produitDiv = document.createElement('div');
            produitDiv.className = 'produit';
            produitDiv.innerHTML = '<label for="produit' + count + '">Produit:</label>' +
                '<input type="text" name="produit[]" id="produit' + count + '" required>' +
                '<label for="quantite' + count + '">Quantité:</label>' +
                '<input type="number" name="quantite[]" id="quantite' + count + '" required>' +
                '<label for="prix_fcfa' + count + '">Prix en FCFA:</label>' +
                '<input type="text" name="prix_fcfa[]" id="prix_fcfa' + count + '" required>';

            document.getElementById('produits').appendChild(produitDiv);

            // Mettre à jour la liste des détails de commande directement après l'ajout
            updateDetailsCommande();
        }

        function updateDetailsCommande() {
            var detailsCommande = document.getElementById('details-commandes');
            var form = document.getElementById('commande-form');
            var produits = form.elements['produit[]'];
            var quantites = form.elements['quantite[]'];
            var prix_fcfa = form.elements['prix_fcfa[]'];

            // Effacer l'ancienne liste
            detailsCommande.innerHTML = '<h2><i class="fas fa-check-circle"></i> Produits Ajoutés</h2><ul>';

            // Parcourir tous les produits
            for (var i = 0; i < produits.length; i++) {
                detailsCommande.innerHTML += '<li><strong>Produit:</strong> ' + produits[i].value + ', ' +
                    '<strong>Quantité:</strong> ' + quantites[i].value + ', ' +
                    '<strong>Prix en FCFA:</strong> ' + prix_fcfa[i].value + '</li>';
            }

            detailsCommande.innerHTML += '</ul>';
        }
    </script>
</body>
</html>
