<html>
    <head>
        <title>Créer un Nouveau Post</title>
        <link rel="stylesheet" type="text/css" href="../../public/css/create.css">
    </head>
    <body class="body-create">
            <form method="post" action="/posts/create">
                <label class="label-create" for="title">Titre du Post:</label>
            <input type="text" id="title" name="title" required><br>

            <label class="label-create" for="content">Contenu du Post:</label>
            <textarea id="content" name="content" required></textarea><br>

            <input type="submit" value="Créer le Post">
        </form>
    </body>
</html>