
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
            <div class="post-card">
                <div class="post-header">
                    <h2 class="post-title">Titre : exemple de post</h2>
                    <p class="post-author">Par : exemple d'auteur</p>
                    <p class="post-date">Date : exemple de date</p>
                </div>
                
                <div class="post-content">
                    <p>Contenu du post ici...</p>
                </div>
                
                <div class="post-actions">
                    <button class="btn-comment">Commenter</button>
                    <button class="btn-like">J'aime</button>
                </div>
                
                <!-- Section Commentaires -->
                <div class="comments-section">
                    <h3>Commentaires</h3>
                    
                    <!-- Formulaire d'ajout de commentaire -->
                    <div class="add-comment">
                        <textarea placeholder="Ajouter un commentaire..."></textarea>
                        <button class="btn-submit-comment">Publier</button>
                    </div>
                    
                    <!-- Liste des commentaires -->
                    <div class="comments-list">
                        <div class="comment">
                            <div class="comment-header">
                                <span class="comment-author">Nom utilisateur</span>
                                <span class="comment-date">Il y a 2 heures</span>
                            </div>
                            <p class="comment-text">Exemple de commentaire 1</p>
                            
                        </div>
                        
                        <div class="comment">
                            <div class="comment-header">
                                <span class="comment-author">Autre utilisateur</span>
                                <span class="comment-date">Il y a 1 jour</span>
                            </div>
                            <p class="comment-text">Exemple de commentaire 2</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>