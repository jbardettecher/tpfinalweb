-- database.sql

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stocke le hash
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des messages
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    utilisateur_id INT NOT NULL,
    date_publication TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des commentaires
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT NOT NULL,
    utilisateur_id INT NOT NULL,
    post_id INT NOT NULL,
    date_commentaire TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

-- Table des réactions (Pour les "J'aime" ou autres smileys)
CREATE TABLE reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    type_reaction VARCHAR(50) NOT NULL, -- 'like', 'love', etc.
    UNIQUE KEY unique_reaction (post_id, utilisateur_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des votes sur les commentaires (Upvote/Downvote)
CREATE TABLE comment_votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    type_vote ENUM('up', 'down') NOT NULL,
    UNIQUE KEY unique_vote (comment_id, utilisateur_id),
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE,
    FOREIGN KEY (utilisateur_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_cible_id INT NOT NULL, -- L'utilisateur qui reçoit la notification
    utilisateur_source_id INT NOT NULL, -- L'utilisateur qui a généré l'action
    type_action VARCHAR(50) NOT NULL, -- 'new_comment', 'post_liked', etc.
    element_id INT, -- ID du post ou du commentaire concerné
    lu BOOLEAN DEFAULT FALSE,
    date_notification TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_cible_id) REFERENCES users(id) ON DELETE CASCADE
);