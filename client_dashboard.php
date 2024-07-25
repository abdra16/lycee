<?php
session_start();

// Vérification si l'utilisateur est bien un client
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Client - Gestion de Stock</title>
    <link rel="stylesheet" href="styl.css"> <!-- Assurez-vous d'ajouter le bon lien vers votre fichier CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
        /* Ajoutez ces styles après votre CSS existant */
        body{
  background-image: url("https://st3.depositphotos.com/1103339/13209/v/1600/depositphotos_132095056-stock-illustration-abstract-seamless-pattern-in-postmodern.jpg");
}
div{
  margin: 2em 5em 3em 5em;

  padding: 2em 6em 2em 6em;
  background: rgb(2,0,36);
background: linear-gradient(117deg, rgba(2,0,36,1) 0%, rgba(125,129,150,0.9757503221014968) 96%, rgba(222,199,45,1) 98%, rgba(222,199,45,1) 98%, rgba(142,49,242,0.5859143339953169) 98%);
  color: #ffff;
  font-family: cursive;
  border-radius: 1.25rem;
}
#container_1{
  text-align:center;
}
#container_2{
 display: block;

  
}
.form{
  width: 100%;
  margin-bottom: 1em;
}

h1{
    color:#ddd;
}
a {
    color:#ddd;
}
#submit{
  display: block;
  width: 100%;
  padding: 0.75rem;
  background: rgb(2,0,36);
  color: inherit;
  border-radius: 15px;
  cursor: pointer;
}

textarea{
  width: 100%;
}

main nav ul li a{
    color:#ddd;
}
    </style>
<body>
    <div class="dashboard-container">
        <header>
            <div class="welcome">
                <h1>Bienvenue, Client <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </header>
        <main>
            <nav>
                <ul class="main">
                    <li><a href="commande.php"><i class="fas fa-truck"></i> Gestion des Commandes</a></li>
                   
                </ul>
            </nav>
        </main>
    </div>
</body>
</html>
