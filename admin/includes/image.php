<?php
/**
 * Fichier de gestion des images pour le blog et l'administration
 * d'ADIMED SARL
 */

// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Définir les constantes pour les chemins d'images
define('UPLOAD_DIR', '../../assets/img/blog/');
define('THUMB_DIR', '../../assets/img/blog/thumbs/');
define('MAX_WIDTH', 1200); // Largeur maximale des images
define('MAX_HEIGHT', 800); // Hauteur maximale des images
define('THUMB_WIDTH', 300); // Largeur des miniatures
define('THUMB_HEIGHT', 200); // Hauteur des miniatures

/**
 * Vérifie si les répertoires d'upload existent, sinon les crée
 * @return bool True si les répertoires existent ou ont été créés, false sinon
 */
function check_upload_dirs() {
    // Vérifier et créer le répertoire principal d'upload
    if (!file_exists(UPLOAD_DIR)) {
        if (!mkdir(UPLOAD_DIR, 0755, true)) {
            error_log('Impossible de créer le répertoire d\'upload: ' . UPLOAD_DIR);
            return false;
        }
    }
    
    // Vérifier et créer le répertoire des miniatures
    if (!file_exists(THUMB_DIR)) {
        if (!mkdir(THUMB_DIR, 0755, true)) {
            error_log('Impossible de créer le répertoire des miniatures: ' . THUMB_DIR);
            return false;
        }
    }
    
    return true;
}

/**
 * Télécharge une image et crée une miniature
 * @param array $file Tableau $_FILES de l'image
 * @param string $prefix Préfixe pour le nom de fichier (optionnel)
 * @return array|false Informations sur l'image téléchargée ou false en cas d'erreur
 */
function upload_image($file, $prefix = '') {
    // Vérifier si les répertoires d'upload existent
    if (!check_upload_dirs()) {
        return false;
    }
    
    // Vérifier si le fichier est une image valide
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        error_log('Type de fichier non autorisé: ' . $file['type']);
        return false;
    }
    
    // Vérifier la taille du fichier (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        error_log('Fichier trop volumineux: ' . $file['size'] . ' bytes');
        return false;
    }
    
    // Générer un nom de fichier unique
    $filename = $prefix . time() . '_' . sanitize_filename(basename($file['name']));
    $upload_path = UPLOAD_DIR . $filename;
    $thumb_path = THUMB_DIR . $filename;
    
    // Déplacer le fichier téléchargé
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        error_log('Erreur lors du téléchargement du fichier: ' . $upload_path);
        return false;
    }
    
    // Redimensionner l'image si nécessaire
    if (!resize_image($upload_path, $upload_path, MAX_WIDTH, MAX_HEIGHT)) {
        error_log('Erreur lors du redimensionnement de l\'image: ' . $upload_path);
        unlink($upload_path); // Supprimer le fichier en cas d'erreur
        return false;
    }
    
    // Créer une miniature
    if (!create_thumbnail($upload_path, $thumb_path, THUMB_WIDTH, THUMB_HEIGHT)) {
        error_log('Erreur lors de la création de la miniature: ' . $thumb_path);
        // Ne pas supprimer l'image principale en cas d'erreur de miniature
    }
    
    // Récupérer les dimensions de l'image
    $image_info = getimagesize($upload_path);
    
    // Retourner les informations sur l'image
    return [
        'filename' => $filename,
        'path' => $upload_path,
        'thumb_path' => $thumb_path,
        'width' => $image_info[0],
        'height' => $image_info[1],
        'type' => $file['type'],
        'size' => $file['size']
    ];
}

/**
 * Redimensionne une image
 * @param string $source Chemin de l'image source
 * @param string $destination Chemin de l'image de destination
 * @param int $max_width Largeur maximale
 * @param int $max_height Hauteur maximale
 * @return bool True si le redimensionnement réussit, false sinon
 */
function resize_image($source, $destination, $max_width, $max_height) {
    // Récupérer les informations sur l'image source
    list($width, $height, $type) = getimagesize($source);
    
    // Vérifier si le redimensionnement est nécessaire
    if ($width <= $max_width && $height <= $max_height) {
        // Si l'image est déjà plus petite que les dimensions maximales, la copier simplement
        if ($source !== $destination) {
            return copy($source, $destination);
        }
        return true;
    }
    
    // Calculer les nouvelles dimensions en conservant les proportions
    $ratio = min($max_width / $width, $max_height / $height);
    $new_width = round($width * $ratio);
    $new_height = round($height * $ratio);
    
    // Créer une nouvelle image
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
    // Charger l'image source selon son type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source_image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $source_image = imagecreatefrompng($source);
            // Préserver la transparence
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            break;
        case IMAGETYPE_GIF:
            $source_image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }
    
    // Redimensionner l'image
    imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Enregistrer l'image redimensionnée selon son type
    $result = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $result = imagejpeg($new_image, $destination, 90); // Qualité 90%
            break;
        case IMAGETYPE_PNG:
            $result = imagepng($new_image, $destination, 9); // Compression maximale
            break;
        case IMAGETYPE_GIF:
            $result = imagegif($new_image, $destination);
            break;
    }
    
    // Libérer la mémoire
    imagedestroy($source_image);
    imagedestroy($new_image);
    
    return $result;
}

/**
 * Crée une miniature d'une image
 * @param string $source Chemin de l'image source
 * @param string $destination Chemin de la miniature
 * @param int $width Largeur de la miniature
 * @param int $height Hauteur de la miniature
 * @return bool True si la création réussit, false sinon
 */
function create_thumbnail($source, $destination, $width, $height) {
    // Récupérer les informations sur l'image source
    list($src_width, $src_height, $type) = getimagesize($source);
    
    // Calculer les dimensions de la miniature (recadrage centré)
    $src_ratio = $src_width / $src_height;
    $dst_ratio = $width / $height;
    
    if ($src_ratio > $dst_ratio) {
        // L'image source est plus large que la miniature
        $crop_width = round($src_height * $dst_ratio);
        $crop_height = $src_height;
        $crop_x = round(($src_width - $crop_width) / 2);
        $crop_y = 0;
    } else {
        // L'image source est plus haute que la miniature
        $crop_width = $src_width;
        $crop_height = round($src_width / $dst_ratio);
        $crop_x = 0;
        $crop_y = round(($src_height - $crop_height) / 2);
    }
    
    // Créer une nouvelle image pour la miniature
    $dst_image = imagecreatetruecolor($width, $height);
    
    // Charger l'image source selon son type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src_image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $src_image = imagecreatefrompng($source);
            // Préserver la transparence
            imagealphablending($dst_image, false);
            imagesavealpha($dst_image, true);
            break;
        case IMAGETYPE_GIF:
            $src_image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }
    
    // Recadrer et redimensionner l'image
    imagecopyresampled($dst_image, $src_image, 0, 0, $crop_x, $crop_y, $width, $height, $crop_width, $crop_height);
    
    // Enregistrer la miniature selon le type de l'image source
    $result = false;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $result = imagejpeg($dst_image, $destination, 90); // Qualité 90%
            break;
        case IMAGETYPE_PNG:
            $result = imagepng($dst_image, $destination, 9); // Compression maximale
            break;
        case IMAGETYPE_GIF:
            $result = imagegif($dst_image, $destination);
            break;
    }
    
    // Libérer la mémoire
    imagedestroy($src_image);
    imagedestroy($dst_image);
    
    return $result;
}

/**
 * Supprime une image et sa miniature
 * @param string $filename Nom du fichier à supprimer
 * @return bool True si la suppression réussit, false sinon
 */
function delete_image($filename) {
    $image_path = UPLOAD_DIR . $filename;
    $thumb_path = THUMB_DIR . $filename;
    
    $result = true;
    
    // Supprimer l'image principale
    if (file_exists($image_path)) {
        if (!unlink($image_path)) {
            error_log('Erreur lors de la suppression de l\'image: ' . $image_path);
            $result = false;
        }
    }
    
    // Supprimer la miniature
    if (file_exists($thumb_path)) {
        if (!unlink($thumb_path)) {
            error_log('Erreur lors de la suppression de la miniature: ' . $thumb_path);
            $result = false;
        }
    }
    
    return $result;
}

/**
 * Récupère la liste des images dans le répertoire d'upload
 * @param string $type Type de fichier à récupérer (jpg, png, gif ou all)
 * @return array Liste des images
 */
function get_images($type = 'all') {
    $images = [];
    
    // Vérifier si le répertoire d'upload existe
    if (!file_exists(UPLOAD_DIR)) {
        return $images;
    }
    
    // Récupérer la liste des fichiers
    $files = scandir(UPLOAD_DIR);
    
    foreach ($files as $file) {
        // Ignorer les répertoires et les fichiers cachés
        if ($file === '.' || $file === '..' || substr($file, 0, 1) === '.') {
            continue;
        }
        
        // Vérifier le type de fichier
        $file_info = pathinfo($file);
        $extension = strtolower($file_info['extension'] ?? '');
        
        if ($type === 'all' || 
            ($type === 'jpg' && ($extension === 'jpg' || $extension === 'jpeg')) ||
            ($type === 'png' && $extension === 'png') ||
            ($type === 'gif' && $extension === 'gif')) {
            
            // Récupérer les informations sur l'image
            $image_path = UPLOAD_DIR . $file;
            $thumb_path = THUMB_DIR . $file;
            $image_info = getimagesize($image_path);
            
            $images[] = [
                'filename' => $file,
                'path' => $image_path,
                'thumb_path' => file_exists($thumb_path) ? $thumb_path : $image_path,
                'width' => $image_info[0],
                'height' => $image_info[1],
                'type' => $image_info['mime'],
                'size' => filesize($image_path),
                'url' => '../assets/img/blog/' . $file,
                'thumb_url' => '../assets/img/blog/thumbs/' . $file
            ];
        }
    }
    
    return $images;
}

/**
 * Sanitize un nom de fichier
 * @param string $filename Nom de fichier à sanitizer
 * @return string Nom de fichier sanitizé
 */
function sanitize_filename($filename) {
    // Supprimer les caractères spéciaux et les espaces
    $filename = preg_replace('/[^\w\-\.]+/', '-', $filename);
    
    // Convertir en minuscules
    $filename = strtolower($filename);
    
    // Supprimer les tirets multiples
    $filename = preg_replace('/-+/', '-', $filename);
    
    // Supprimer les tirets en début et fin
    $filename = trim($filename, '-');
    
    return $filename;
}

/**
 * Enregistre une image dans la base de données
 * @param array $image_data Données de l'image
 * @param int|null $article_id ID de l'article associé (optionnel)
 * @param int|null $product_id ID du produit associé (optionnel)
 * @return int|false ID de l'image enregistrée ou false en cas d'erreur
 */
function save_image_to_db($image_data, $article_id = null, $product_id = null) {
    $data = [
        'article_id' => $article_id,
        'product_id' => $product_id,
        'filename' => $image_data['filename'],
        'alt_text' => $image_data['alt_text'] ?? '',
        'caption' => $image_data['caption'] ?? '',
        'sort_order' => $image_data['sort_order'] ?? 0,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    return db_insert('images', $data);
}

/**
 * Récupère les images associées à un article ou un produit
 * @param int $id ID de l'article ou du produit
 * @param string $type Type d'association ('article' ou 'product')
 * @return array Liste des images
 */
function get_associated_images($id, $type = 'article') {
    $id = (int) $id;
    $field = $type . '_id';
    
    $query = "SELECT * FROM images WHERE $field = $id ORDER BY sort_order ASC";
    $images = db_fetch_all($query);
    
    // Ajouter les URLs aux images
    foreach ($images as &$image) {
        $image['url'] = '../assets/img/blog/' . $image['filename'];
        $image['thumb_url'] = '../assets/img/blog/thumbs/' . $image['filename'];
    }
    
    return $images;
}

/**
 * Met à jour les informations d'une image dans la base de données
 * @param int $image_id ID de l'image
 * @param array $image_data Données de l'image à mettre à jour
 * @return bool True si la mise à jour réussit, false sinon
 */
function update_image_in_db($image_id, $image_data) {
    $image_id = (int) $image_id;
    
    $data = [];
    
    if (isset($image_data['alt_text'])) {
        $data['alt_text'] = $image_data['alt_text'];
    }
    
    if (isset($image_data['caption'])) {
        $data['caption'] = $image_data['caption'];
    }
    
    if (isset($image_data['sort_order'])) {
        $data['sort_order'] = (int) $image_data['sort_order'];
    }
    
    if (empty($data)) {
        return false; // Aucune donnée à mettre à jour
    }
    
    return db_update('images', $data, "id = $image_id");
}

/**
 * Supprime une image de la base de données et du système de fichiers
 * @param int $image_id ID de l'image à supprimer
 * @return bool True si la suppression réussit, false sinon
 */
function delete_image_from_db($image_id) {
    $image_id = (int) $image_id;
    
    // Récupérer les informations de l'image
    $query = "SELECT filename FROM images WHERE id = $image_id";
    $image = db_fetch_one($query);
    
    if (!$image) {
        return false; // L'image n'existe pas
    }
    
    // Supprimer l'image du système de fichiers
    $file_deleted = delete_image($image['filename']);
    
    // Supprimer l'image de la base de données
    $db_deleted = db_delete('images', "id = $image_id");
    
    return $file_deleted && $db_deleted;
}