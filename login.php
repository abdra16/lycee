<?php
session_start();

// Vérifier si un message de succès est présent dans la session
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    // Effacer le message de la session après l'avoir affiché
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion de Stock</title>
    <link rel="stylesheet" href="connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="message">
        <div class="message">
        <h1><i class="fas fa-user-shield"></i> Connexion / Inscription Administrateur</h1>
                 <p>Choisissez une action :</p>
        <div class="btn-wrapper">
        <button class="button" id="show-signup"><i class="fas fa-user-plus"></i> S'inscrire</button>
        <button class="button" id="show-login"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
    </div>
</div>

        </div>
        <div class="form-wrapper">
            <div class="form form--login">
                <div class="form--heading">😊 Content de te revoir</div>
                <form id="login-form" action="traitement_connexion.php" method="post">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nom d'utilisateur" name="username" required>
                    </div>
                    <p class="form--explanation">Entrez votre nom d'utilisateur enregistré.</p>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Mot de passe" name="password" required>
                    </div>
                    <p class="form--explanation">Entrez votre mot de passe pour accéder à votre compte.</p>
                    <button class="button" type="submit"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
                </form>
            </div>

            <div class="form form--signup">
                <div class="form--heading">😊 Accueillir! S'inscrire</div>
                <form id="register-form" action="traitement_inscription.php" method="post">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required>
                    </div>
                    <p class="form--explanation">Entrez votre nom d'utilisateur unique.</p>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" id="email" name="email" required>
                    </div>
                    <p class="form--explanation">Utilisez une adresse email valide pour l'inscription.</p>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Mot de passe" id="password" name="password" required>
                    </div>
                    <p class="form--explanation">Choisissez un mot de passe sécurisé.</p>
                    <button class="button" type="submit"><i class="fas fa-user-plus"></i> S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
