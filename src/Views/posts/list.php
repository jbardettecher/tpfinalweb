
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Posts</title>
        <link rel="stylesheet" type="text/css" href="/public/css/list.css">
    </head>
    <body class="body-list">
        <div class="container">
            <!-- Post -->
            <div class="post-card" data-post-id="1">
                <div class="post-header">
                    <h2 class="post-title">Titre : exemple de post</h2>
                    <p class="post-author">Par : exemple d'auteur</p>
                    <p class="post-date">Date : exemple de date</p>
                </div>
                
                <div class="post-content">
                    <p>Contenu du post ici...</p>
                </div>
                
                <div class="post-actions">
                    <button class="btn-like">J'aime</button>
                </div>
                
                <!-- Section Commentaires -->
                <div class="comments-section">
                    <h3>Commentaires</h3>
                    
                    <!-- Formulaire d'ajout de commentaire -->
                    <div class="add-comment">
                        <textarea class="comment-textarea" placeholder="Ajouter un commentaire..."></textarea>
                        <button class="btn-submit-comment">Publier</button>
                    </div>
                    
                    <!-- Liste des commentaires (chargée dynamiquement) -->
                    <div class="comments-list" id="comments-list-1">
                        <!-- Les commentaires seront ajoutés ici via AJAX -->
                    </div>
                </div>
            </div>
        </div>
        
        <script src="/public/js/comments.js"></script>
    </body>
</html>