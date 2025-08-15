-- Base de données pour le site ADIMED SARL
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS adimed_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utilisation de la base de données
USE adimed_db;

-- Table des utilisateurs (administrateurs)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'editor', 'author') NOT NULL DEFAULT 'author',
    profile_image VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    excerpt TEXT DEFAULT NULL,
    featured_image VARCHAR(255) DEFAULT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    status ENUM('published', 'draft') NOT NULL DEFAULT 'draft',
    views INT DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des produits
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    short_description VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10, 2) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des images (pour les galeries d'images dans les articles)
CREATE TABLE IF NOT EXISTS images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT DEFAULT NULL,
    product_id INT DEFAULT NULL,
    filename VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) DEFAULT NULL,
    caption TEXT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des tags
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table de relation entre articles et tags (many-to-many)
CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des commentaires (si nécessaire pour le blog)
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    author_name VARCHAR(100) NOT NULL,
    author_email VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    status ENUM('approved', 'pending', 'spam') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des sessions (pour la gestion des sessions utilisateurs)
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(128) NOT NULL PRIMARY KEY,
    user_id INT DEFAULT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertion d'un utilisateur administrateur par défaut
-- Mot de passe: admin123 (haché avec password_hash)
INSERT INTO users (username, password, email, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@adimed.com', 'Administrateur', 'admin');

-- Insertion de quelques catégories par défaut
INSERT INTO categories (name, slug, description) VALUES
('Équipements médicaux', 'equipements-medicaux', 'Articles sur les équipements médicaux vendus et installés par ADIMED SARL'),
('Formations', 'formations', 'Formations proposées par ADIMED SARL pour l\'utilisation des équipements médicaux'),
('Maintenance', 'maintenance', 'Services de maintenance et d\'entretien des équipements médicaux'),
('Nouveaux produits', 'nouveaux-produits', 'Présentation des nouveaux produits disponibles chez ADIMED SARL'),
('Conseils', 'conseils', 'Conseils et recommandations pour l\'utilisation et le choix des équipements médicaux'),
('Événements', 'evenements', 'Événements et actualités concernant ADIMED SARL');

-- Insertion de quelques tags par défaut
INSERT INTO tags (name, slug) VALUES
('Imagerie médicale', 'imagerie-medicale'),
('Laboratoire', 'laboratoire'),
('Radiologie', 'radiologie'),
('Échographie', 'echographie'),
('Cardiologie', 'cardiologie'),
('Dentaire', 'dentaire'),
('Ophtalmologie', 'ophtalmologie');

-- Insertion de quelques produits par défaut
INSERT INTO products (name, slug, description, short_description, category, featured, status) VALUES
('Échographe portable', 'echographe-portable', 'Échographe portable de haute qualité pour les examens médicaux en déplacement. Cet appareil compact offre une excellente qualité d\'image et une grande autonomie.', 'Échographe portable de haute qualité pour les examens médicaux en déplacement.', 'Imagerie médicale', TRUE, 'active'),
('Analyseur de biochimie', 'analyseur-biochimie', 'Analyseur de biochimie automatisé pour laboratoires médicaux. Permet d\'effectuer rapidement et avec précision de nombreux tests biochimiques.', 'Analyseur de biochimie automatisé pour laboratoires médicaux.', 'Laboratoire', FALSE, 'active'),
('Appareil de radiographie numérique', 'radiographie-numerique', 'Système de radiographie numérique de dernière génération offrant une qualité d\'image exceptionnelle et une faible dose de radiation.', 'Système de radiographie numérique de dernière génération.', 'Radiologie', TRUE, 'active'),
('Électrocardiographe', 'electrocardiographe', 'Électrocardiographe moderne pour l\'enregistrement et l\'analyse de l\'activité électrique du cœur. Interface intuitive et résultats précis.', 'Électrocardiographe moderne pour l\'enregistrement et l\'analyse de l\'activité électrique du cœur.', 'Cardiologie', FALSE, 'active');

-- Création d'un utilisateur MySQL avec les privilèges nécessaires
-- GRANT ALL PRIVILEGES ON adimed_db.* TO 'adimed_user'@'localhost' IDENTIFIED BY 'password_secure';
-- FLUSH PRIVILEGES;