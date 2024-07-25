<?php
// Fonction pour récupérer le nombre de commandes par mois et par année
function getCommandesParMois($pdo, $annee) {
    $sql = "SELECT MONTH(date_commande) AS mois, COUNT(*) AS nombre_commandes
            FROM commande
            WHERE YEAR(date_commande) = :annee
            GROUP BY mois
            ORDER BY mois";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['annee' => $annee]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Connexion à la base de données (à adapter selon votre configuration)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stock";

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Déterminer l'année actuelle et par défaut (si aucune sélectionnée)
    $anneeActuelle = date('Y');
    $annee = isset($_GET['annee']) ? intval($_GET['annee']) : $anneeActuelle;

    // Liste des années pour lesquelles les données sont disponibles
    $anneesDisponibles = range(2000, 2050);

    // Vérification si l'année est valide (dans la plage de 2000 à 2050)
    if ($annee < 2000 || $annee > 2050) {
        $annee = $anneeActuelle; // Retour à l'année actuelle si une année invalide est sélectionnée
    }

    // Récupérer les données pour le graphique
    $resultats = getCommandesParMois($pdo, $annee);

} catch(PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
    echo $error; // Afficher l'erreur pour le débogage
    $resultats = []; // Assurer que $resultats est défini même en cas d'erreur
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Commandes</title>
    <!-- Inclure CDN de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles personnalisés pour la mise en forme du graphique et du tableau */
        .chart-container {
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }
        .chart-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <h2>Statistiques des Commandes par Mois (<?= $annee ?>)</h2>

        <!-- Sélecteur d'année pour la navigation -->
        <form method="get" action="">
            <label for="annee">Choisir une année :</label>
            <select name="annee" id="annee">
                <?php foreach ($anneesDisponibles as $a) : ?>
                    <option value="<?= $a ?>" <?= $a == $annee ? 'selected' : '' ?>><?= $a ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Afficher</button>
        </form>

        <!-- Graphique pour afficher les commandes par mois -->
        <canvas id="commandesChart"></canvas>
    </div>

    <!-- Script JavaScript pour initialiser le graphique avec Chart.js -->
    <script>
    // Récupérer les données PHP dans JavaScript
    var phpData = <?php echo json_encode($resultats); ?>;

    // Préparer les données pour le graphique
    var labels = [];
    var data = [];

    phpData.forEach(function(item) {
        // Convertir le mois en nom complet (optionnel)
        var moisLabels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                          'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        labels.push(moisLabels[item.mois - 1]); // -1 pour correspondre à l'index 0 des mois
        data.push(item.nombre_commandes);
    });

    // Créer le graphique avec Chart.js
    var ctx = document.getElementById('commandesChart').getContext('2d');
    var commandesChart = new Chart(ctx, {
        type: 'line', // Type de graphique en courbe
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre de Commandes',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        precision: 0
                    }
                }]
            }
        }
    });
    </script>
</body>
</html>
