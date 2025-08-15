<?php
/**
 * Configuration de la base de données et fonctions utilitaires
 */

// Informations de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // À remplacer par votre nom d'utilisateur MySQL
define('DB_PASS', ''); // À remplacer par votre mot de passe MySQL
define('DB_NAME', 'adimed_db'); // À remplacer par le nom de votre base de données

// Connexion à la base de données
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données: " . $conn->connect_error);
    }
    
    // Définir le jeu de caractères
    $conn->set_charset("utf8");
    
    return $conn;
}

// Fonction pour échapper les données avant insertion dans la base de données
function escapeString($conn, $string) {
    return $conn->real_escape_string($string);
}

// Fonction pour générer un slug à partir d'un titre
function generateSlug($string) {
    // Remplacer les caractères non alphanumériques par des tirets
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($string)));
    // Supprimer les tirets en début et fin de chaîne
    $slug = trim($slug, '-');
    return $slug;
}

// Fonction pour formater la date
function formatDate($date, $format = 'd F Y') {
    $timestamp = strtotime($date);
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
    return strftime($format, $timestamp);
}

// Fonction pour vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Fonction pour rediriger si l'utilisateur n'est pas connecté
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

// Fonction pour nettoyer les données de formulaire
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fonction pour télécharger une image
function uploadImage($file, $destination_folder) {
    // Vérifier si le fichier a été correctement téléchargé
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Erreur lors du téléchargement du fichier.'];
    }
    
    // Vérifier le type de fichier
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Type de fichier non autorisé. Seuls les formats JPEG, PNG et GIF sont acceptés.'];
    }
    
    // Vérifier la taille du fichier (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['success' => false, 'message' => 'Le fichier est trop volumineux. La taille maximale autorisée est de 5MB.'];
    }
    
    // Créer le dossier de destination s'il n'existe pas
    if (!file_exists($destination_folder)) {
        mkdir($destination_folder, 0777, true);
    }
    
    // Générer un nom de fichier unique
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = uniqid() . '.' . $file_extension;
    $destination = $destination_folder . '/' . $file_name;
    
    // Déplacer le fichier téléchargé vers le dossier de destination
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'file_name' => $file_name, 'file_path' => $destination];
    } else {
        return ['success' => false, 'message' => 'Erreur lors de l\'enregistrement du fichier.'];
    }
}

// Fonction pour supprimer une image
function deleteImage($file_path) {
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

// Fonction pour tronquer un texte
function truncateText($text, $length = 100, $append = '...') {
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length);
        $text = substr($text, 0, strrpos($text, ' '));
        $text .= $append;
    }
    return $text;
}

// Fonction pour générer un jeton CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fonction pour vérifier un jeton CSRF
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}