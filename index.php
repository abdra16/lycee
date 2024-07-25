<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion de Stock</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400");
        @import url("https://fonts.googleapis.com/css?family=Playfair+Display");

        body,
        .message,
        .form,
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        body {
            height: 100vh;
            background: url('https://source.unsplash.com/featured/?pharmacy') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Source Sans Pro', sans-serif;
            overflow: hidden;
            backdrop-filter: blur(5px);
        }

        .container {
            width: 700px;
            height: 500px;
            background: rgba(255, 255, 255, 0.9);
            position: relative;
            display: grid;
            grid-template: 100% / 50% 50%;
            box-shadow: 2px 2px 20px 0 rgba(51, 51, 51, 0.3);
            border-radius: 10px;
        }

        .message {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            width: 50%;
            height: 100%;
            transition: 0.6s all ease;
            transform: translateX(100%);
            z-index: 4;
            border-radius: 10px;
        }

        .message:before {
            position: absolute;
            content: "";
            width: 1px;
            height: 70%;
            background: #c3c3d8;
            opacity: 0;
            left: 0;
            top: 15%;
        }

        .signup:before {
            opacity: 0.3;
            left: 0;
        }

        .login:before {
            opacity: 0.3;
            left: 100%;
        }

        .btn-wrapper {
            width: 60%;
        }

        .button {
            margin: 10px 0;
            width: 100%;
            height: 40px;
            border: 0;
            outline: 0;
            color: white;
            font-size: 16px;
            font-weight: 400;
            position: relative;
            z-index: 3;
            background: #3b5998;
            font-family: 'Source Sans Pro', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #2d4373;
        }

        .form {
            width: 100%;
            height: 100%;
            padding: 20px;
        }

        .form--heading {
            font-size: 28px;
            height: 50px;
            color: #3b5998;
        }

        .form--signup {
            border-right: 1px solid #999;
        }

        form {
            width: 80%;
        }

        form > * {
            margin: 10px;
        }

        input {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #aaa;
            font-size: 14px;
            font-weight: 300;
            color: #333;
            letter-spacing: 0.1em;
        }

        input::placeholder {
            color: #333;
            font-size: 12px;
        }

        input:focus {
            outline: 0;
            border-bottom: 1px solid rgba(128, 155, 206, 0.7);
            transition: 0.6s all ease;
        }

        label {
            display: block;
            margin-top: 15px;
            text-align: left;
            color: #3b5998;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #3b5998;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        p {
            margin-top: 20px;
            color: #555;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message signup">
            <div class="btn-wrapper">
                <button class="button" id="signup"><i class="fas fa-user-plus"></i> S'inscrire</button>
                <button class="button" id="login"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
            </div>
        </div>

        <div class="form form--signup">
            <div class="form--heading"><i class="fas fa-user-plus"></i> Accueillir! S'inscrire</div>
            <form id="register-form" action="traitement_inscription.php" method="post">
                <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" required>
                <input type="email" placeholder="Email" id="email" name="email" required>
                <input type="number" placeholder="Âge" id="age" name="age" required>
                <input type="password" placeholder="Mot de passe" id="password" name="password" required>
                <label for="role">Type d'utilisateur:</label>
                <select id="role" name="role" required>
                    <option value="admin">Administrateur</option>
                   
                </select>
                <button class="button" type="submit"><i class="fas fa-user-plus"></i> S'inscrire</button>
            </form>
        </div>

        <div class="form form--login">
            <div class="form--heading"><i class="fas fa-sign-in-alt"></i> Content de te revoir</div>
            <form id="login-form" action="login.php" method="post">
                <input type="text" placeholder="Nom d'utilisateur" name="username" required>
                <input type="password" placeholder="Mot de passe" name="password" required>
                <label for="role">Type d'utilisateur:</label>
                <select id="role" name="role" required>
                    <option value="admin">Administrateur</option>
                    
                </select>
                <button class="button" type="submit"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
            </form>
        </div>
    </div>

    <script>
        $("#signup").click(function() {
            $(".message").css("transform", "translateX(100%)");
            if ($(".message").hasClass("login")) {
                $(".message").removeClass("login");
            }
            $(".message").addClass("signup");
        });

        $("#login").click(function() {
            $(".message").css("transform", "translateX(0)");
            if ($(".message").hasClass("signup")) {
                $(".message").removeClass("signup");
            }
            $(".message").addClass("login");
        });
    </script>
</body>
</html>
