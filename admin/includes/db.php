<?php
/**
 * Fichier de connexion à la base de données et fonctions utilitaires
 * pour le blog et l'administration d'ADIMED SARL
 */

// Informations de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // À modifier selon votre configuration
define('DB_PASS', ''); // À modifier selon votre configuration
define('DB_NAME', 'adimed_db');

/**
 * Établit une connexion à la base de données
 * @return mysqli|false Connexion à la base de données ou false en cas d'erreur
 */
function db_connect() {
    static $connection;
    
    if (!isset($connection)) {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$connection) {
            error_log('Erreur de connexion à la base de données: ' . mysqli_connect_error());
            return false;
        }
        mysqli_set_charset($connection, 'utf8mb4');
    }
    
    return $connection;
}

/**
 * Exécute une requête SQL et retourne le résultat
 * @param string $query Requête SQL à exécuter
 * @return mysqli_result|bool Résultat de la requête ou false en cas d'erreur
 */
function db_query($query) {
    $connection = db_connect();
    if (!$connection) {
        return false;
    }
    
    $result = mysqli_query($connection, $query);
    if (!$result) {
        error_log('Erreur d\'exécution de la requête: ' . mysqli_error($connection));
    }
    
    return $result;
}

/**
 * Récupère toutes les lignes d'un résultat de requête sous forme de tableau associatif
 * @param string $query Requête SQL à exécuter
 * @return array|false Tableau de résultats ou false en cas d'erreur
 */
function db_fetch_all($query) {
    $result = db_query($query);
    if (!$result) {
        return false;
    }
    
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    mysqli_free_result($result);
    return $rows;
}

/**
 * Récupère une seule ligne d'un résultat de requête sous forme de tableau associatif
 * @param string $query Requête SQL à exécuter
 * @return array|false Tableau associatif ou false si aucun résultat ou erreur
 */
function db_fetch_one($query) {
    $result = db_query($query);
    if (!$result) {
        return false;
    }
    
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    
    return $row;
}

/**
 * Échappe une chaîne pour l'utiliser dans une requête SQL
 * @param string $string Chaîne à échapper
 * @return string Chaîne échappée
 */
function db_escape($string) {
    $connection = db_connect();
    if (!$connection) {
        return $string;
    }
    
    return mysqli_real_escape_string($connection, $string);
}

/**
 * Insère des données dans une table
 * @param string $table Nom de la table
 * @param array $data Données à insérer (clé => valeur)
 * @return int|false ID de la dernière insertion ou false en cas d'erreur
 */
function db_insert($table, $data) {
    $connection = db_connect();
    if (!$connection) {
        return false;
    }
    
    $columns = [];
    $values = [];
    
    foreach ($data as $column => $value) {
        $columns[] = "`$column`";
        if ($value === null) {
            $values[] = "NULL";
        } else {
            $values[] = "'" . db_escape($value) . "'";
        }
    }
    
    $columns_str = implode(", ", $columns);
    $values_str = implode(", ", $values);
    
    $query = "INSERT INTO `$table` ($columns_str) VALUES ($values_str)";
    
    if (db_query($query)) {
        return mysqli_insert_id($connection);
    }
    
    return false;
}

/**
 * Met à jour des données dans une table
 * @param string $table Nom de la table
 * @param array $data Données à mettre à jour (clé => valeur)
 * @param string $where Condition WHERE (sans le mot-clé WHERE)
 * @return bool True si succès, false sinon
 */
function db_update($table, $data, $where) {
    $connection = db_connect();
    if (!$connection) {
        return false;
    }
    
    $set = [];
    
    foreach ($data as $column => $value) {
        if ($value === null) {
            $set[] = "`$column` = NULL";
        } else {
            $set[] = "`$column` = '" . db_escape($value) . "'";
        }
    }
    
    $set_str = implode(", ", $set);
    
    $query = "UPDATE `$table` SET $set_str WHERE $where";
    
    return db_query($query) ? true : false;
}

/**
 * Supprime des données d'une table
 * @param string $table Nom de la table
 * @param string $where Condition WHERE (sans le mot-clé WHERE)
 * @return bool True si succès, false sinon
 */
function db_delete($table, $where) {
    $query = "DELETE FROM `$table` WHERE $where";
    return db_query($query) ? true : false;
}

/**
 * Compte le nombre de lignes dans une table selon une condition
 * @param string $table Nom de la table
 * @param string $where Condition WHERE (sans le mot-clé WHERE), peut être vide
 * @return int|false Nombre de lignes ou false en cas d'erreur
 */
function db_count($table, $where = '') {
    $query = "SELECT COUNT(*) as count FROM `$table`";
    if (!empty($where)) {
        $query .= " WHERE $where";
    }
    
    $result = db_fetch_one($query);
    if ($result) {
        return (int) $result['count'];
    }
    
    return false;
}

/**
 * Génère un slug à partir d'une chaîne
 * @param string $string Chaîne à convertir en slug
 * @return string Slug généré
 */
function generate_slug($string) {
    // Convertir en minuscules et supprimer les espaces en début et fin
    $string = trim(strtolower($string));
    
    // Remplacer les caractères accentués
    $string = str_replace(
        ['à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'œ', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ'],
        ['a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'u', 'u', 'u', 'u', 'y', 'y'],
        $string
    );
    
    // Remplacer tout ce qui n'est pas une lettre, un chiffre ou un tiret par un tiret
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    
    // Remplacer les tirets multiples par un seul tiret
    $string = preg_replace('/-+/', '-', $string);
    
    // Supprimer les tirets en début et fin
    return trim($string, '-');
}

/**
 * Vérifie si un slug existe déjà dans une table
 * @param string $table Nom de la table
 * @param string $slug Slug à vérifier
 * @param int $exclude_id ID à exclure (pour les mises à jour)
 * @return bool True si le slug existe, false sinon
 */
function slug_exists($table, $slug, $exclude_id = 0) {
    $query = "SELECT id FROM `$table` WHERE slug = '" . db_escape($slug) . "'";
    if ($exclude_id > 0) {
        $query .= " AND id != " . (int) $exclude_id;
    }
    
    $result = db_fetch_one($query);
    return $result ? true : false;
}

/**
 * Génère un slug unique pour une table
 * @param string $table Nom de la table
 * @param string $string Chaîne à convertir en slug
 * @param int $exclude_id ID à exclure (pour les mises à jour)
 * @return string Slug unique généré
 */
function generate_unique_slug($table, $string, $exclude_id = 0) {
    $slug = generate_slug($string);
    $original_slug = $slug;
    $counter = 1;
    
    while (slug_exists($table, $slug, $exclude_id)) {
        $slug = $original_slug . '-' . $counter;
        $counter++;
    }
    
    return $slug;
}

/**
 * Formate une date MySQL en format lisible
 * @param string $date Date au format MySQL (YYYY-MM-DD HH:MM:SS)
 * @param string $format Format de date PHP
 * @return string Date formatée
 */
function format_date($date, $format = 'd/m/Y à H:i') {
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

/**
 * Tronque un texte à une longueur donnée
 * @param string $text Texte à tronquer
 * @param int $length Longueur maximale
 * @param string $suffix Suffixe à ajouter si le texte est tronqué
 * @return string Texte tronqué
 */
function truncate_text($text, $length = 100, $suffix = '...') {
    // Supprimer les balises HTML
    $text = strip_tags($text);
    
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . $suffix;
}

/**
 * Pagination pour les requêtes SQL
 * @param string $table Nom de la table
 * @param string $where Condition WHERE (sans le mot-clé WHERE), peut être vide
 * @param int $page Page actuelle
 * @param int $per_page Nombre d'éléments par page
 * @param string $order_by Ordre de tri (par défaut: id DESC)
 * @return array Tableau contenant les résultats et les informations de pagination
 */
function paginate($table, $where = '', $page = 1, $per_page = 10, $order_by = 'id DESC') {
    $page = max(1, (int) $page);
    $per_page = max(1, (int) $per_page);
    
    $total = db_count($table, $where);
    $total_pages = ceil($total / $per_page);
    $page = min($page, max(1, $total_pages));
    
    $offset = ($page - 1) * $per_page;
    
    $query = "SELECT * FROM `$table`";
    if (!empty($where)) {
        $query .= " WHERE $where";
    }
    $query .= " ORDER BY $order_by LIMIT $offset, $per_page";
    
    $items = db_fetch_all($query);
    
    return [
        'items' => $items,
        'total' => $total,
        'per_page' => $per_page,
        'current_page' => $page,
        'total_pages' => $total_pages,
        'has_previous' => $page > 1,
        'has_next' => $page < $total_pages,
        'previous_page' => $page - 1,
        'next_page' => $page + 1
    ];
}

/**
 * Génère les liens de pagination HTML
 * @param array $pagination Tableau de pagination généré par la fonction paginate()
 * @param string $url_pattern Modèle d'URL avec {page} comme placeholder
 * @return string HTML de la pagination
 */
function pagination_links($pagination, $url_pattern) {
    if ($pagination['total_pages'] <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Pagination"><ul class="pagination justify-content-center">';
    
    // Lien précédent
    if ($pagination['has_previous']) {
        $prev_url = str_replace('{page}', $pagination['previous_page'], $url_pattern);
        $html .= '<li class="page-item"><a class="page-link" href="' . $prev_url . '" aria-label="Précédent"><span aria-hidden="true">&laquo;</span> Précédent</a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link"><span aria-hidden="true">&laquo;</span> Précédent</span></li>';
    }
    
    // Liens des pages
    $start = max(1, $pagination['current_page'] - 2);
    $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
    
    if ($start > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', 1, $url_pattern) . '">1</a></li>';
        if ($start > 2) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $pagination['current_page']) {
            $html .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', $i, $url_pattern) . '">' . $i . '</a></li>';
        }
    }
    
    if ($end < $pagination['total_pages']) {
        if ($end < $pagination['total_pages'] - 1) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $html .= '<li class="page-item"><a class="page-link" href="' . str_replace('{page}', $pagination['total_pages'], $url_pattern) . '">' . $pagination['total_pages'] . '</a></li>';
    }
    
    // Lien suivant
    if ($pagination['has_next']) {
        $next_url = str_replace('{page}', $pagination['next_page'], $url_pattern);
        $html .= '<li class="page-item"><a class="page-link" href="' . $next_url . '" aria-label="Suivant">Suivant <span aria-hidden="true">&raquo;</span></a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link">Suivant <span aria-hidden="true">&raquo;</span></span></li>';
    }
    
    $html .= '</ul></nav>';
    
    return $html;
}