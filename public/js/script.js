document.addEventListener('DOMContentLoaded', function() {
    loadComments();
    
    // Ajouter un commentaire
    document.querySelectorAll('.btn-submit-comment').forEach(button => {
        button.addEventListener('click', function() {
            const postCard = this.closest('.post-card');
            const postId = postCard.dataset.postId;
            const textarea = postCard.querySelector('.comment-textarea');
            const commentText = textarea.value.trim();
            
            if (commentText === '') {
                alert('Veuillez écrire un commentaire');
                return;
            }
            
            addComment(postId, commentText);
            textarea.value = '';
        });
    });
});

function addComment(postId, commentText) {
    const formData = new FormData();
    formData.append('action', 'add_comment');
    formData.append('post_id', postId);
    formData.append('comment_text', commentText);
    
    fetch('/controllers/AjaxController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadComments();
        } else {
            alert('Erreur : ' + data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}

function loadComments() {
    document.querySelectorAll('.post-card').forEach(postCard => {
        const postId = postCard.dataset.postId;
        const formData = new FormData();
        formData.append('action', 'get_comments');
        formData.append('post_id', postId);
        
        fetch('/controllers/AjaxController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(comments => {
            const commentsList = postCard.querySelector(`#comments-list-${postId}`);
            commentsList.innerHTML = '';
            
            if (comments.length === 0) {
                commentsList.innerHTML = '<p class="no-comments">Aucun commentaire pour le moment</p>';
                return;
            }
            
            comments.forEach(comment => {
                const commentEl = createCommentElement(comment);
                commentsList.appendChild(commentEl);
            });
        })
        .catch(error => console.error('Erreur:', error));
    });
}

function createCommentElement(comment) {
    const div = document.createElement('div');
    div.className = 'comment';
    div.dataset.commentId = comment.id;
    
    const header = document.createElement('div');
    header.className = 'comment-header';
    
    const author = document.createElement('span');
    author.className = 'comment-author';
    author.textContent = comment.username;
    
    const date = document.createElement('span');
    date.className = 'comment-date';
    date.textContent = formatDate(comment.created_at);
    
    header.appendChild(author);
    header.appendChild(date);
    
    const text = document.createElement('p');
    text.className = 'comment-text';
    text.textContent = comment.content;
    
    div.appendChild(header);
    div.appendChild(text);
    
    return div;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);
    
    if (diffMins < 1) return 'À l\'instant';
    if (diffMins < 60) return `Il y a ${diffMins}m`;
    if (diffHours < 24) return `Il y a ${diffHours}h`;
    if (diffDays < 7) return `Il y a ${diffDays}j`;
    
    return date.toLocaleDateString('fr-FR');
}