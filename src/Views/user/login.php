<?php   ?>
<html>
    <head>
        <title>Connexion Utilisateur</title>
        <link rel="stylesheet" type="text/css" href="../../public/css/login.css">
    </head>
    <body class="body-register">
            <form method="post" action="/user/login">
                <label class="label-register" for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required><br>

            <label class="label-register" for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label class="label-register" for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Se connecter">
        </form>
    </body>
</html>
