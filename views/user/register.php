<?php   ?>
<html>
    <head>
        <title>Inscription Utilisateur</title>
        <link rel="stylesheet" type="text/css" href="../../public/css/register.css">
    </head>
    <body class="body-register">
            <form method="post" action="/user/register">
                <label class="label-register" for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required><br>

            <label class="label-register" for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label class="label-register" for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br>

            <input class="btn-submit_register" type="submit" value="S'inscrire">
        </form>
    </body>
</html>
