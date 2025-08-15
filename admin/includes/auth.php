<?php
/**
 * Fichier de gestion de l'authentification et des utilisateurs
 * pour l'administration d'ADIMED SARL
 */

// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si un utilisateur est connecté
 * @return bool True si l'utilisateur est connecté, false sinon
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Vérifie si l'utilisateur connecté a un rôle spécifique
 * @param string|array $roles Rôle(s) à vérifier
 * @return bool True si l'utilisateur a le rôle spécifié, false sinon
 */
function has_role($roles) {
    if (!is_logged_in()) {
        return false;
    }
    
    if (!isset($_SESSION['user_role'])) {
        return false;
    }
    
    if (is_array($roles)) {
        return in_array($_SESSION['user_role'], $roles);
    }
    
    return $_SESSION['user_role'] === $roles;
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
 * @param string|array $required_roles Rôle(s) requis pour accéder à la page
 * @return void
 */
function require_login($required_roles = null) {
    if (!is_logged_in()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: ../login.php');
        exit;
    }
    
    if ($required_roles !== null && !has_role($required_roles)) {
        $_SESSION['error'] = 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.';
        header('Location: ../index.php');
        exit;
    }
}

/**
 * Authentifie un utilisateur
 * @param string $username Nom d'utilisateur
 * @param string $password Mot de passe
 * @return bool True si l'authentification réussit, false sinon
 */
function login($username, $password) {
    $username = db_escape($username);
    
    $query = "SELECT id, username, password, email, full_name, role FROM users WHERE username = '$username'";
    $user = db_fetch_one($query);
    
    if (!$user) {
        return false;
    }
    
    if (password_verify($password, $user['password'])) {
        // Enregistrer les informations de l'utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_fullname'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        
        // Mettre à jour la dernière connexion
        $now = date('Y-m-d H:i:s');
        db_update('users', ['last_login' => $now], "id = {$user['id']}");
        
        // Enregistrer l'activité
        log_activity('Connexion', 'L\'utilisateur s\'est connecté', $user['id']);
        
        return true;
    }
    
    return false;
}

/**
 * Déconnecte l'utilisateur actuel
 * @return void
 */
function logout() {
    if (is_logged_in()) {
        // Enregistrer l'activité avant de supprimer la session
        log_activity('Déconnexion', 'L\'utilisateur s\'est déconnecté', $_SESSION['user_id']);
    }
    
    // Détruire toutes les données de session
    $_SESSION = [];
    
    // Détruire le cookie de session si nécessaire
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Détruire la session
    session_destroy();
}

/**
 * Récupère les informations d'un utilisateur
 * @param int $user_id ID de l'utilisateur
 * @return array|false Informations de l'utilisateur ou false si non trouvé
 */
function get_user($user_id) {
    $user_id = (int) $user_id;
    $query = "SELECT id, username, email, full_name, role, profile_image, bio, created_at, updated_at FROM users WHERE id = $user_id";
    return db_fetch_one($query);
}

/**
 * Récupère l'utilisateur actuellement connecté
 * @return array|false Informations de l'utilisateur ou false si non connecté
 */
function get_current_user() {
    if (!is_logged_in()) {
        return false;
    }
    
    return get_user($_SESSION['user_id']);
}

/**
 * Récupère tous les utilisateurs
 * @param string $role Filtrer par rôle (optionnel)
 * @return array Liste des utilisateurs
 */
function get_all_users($role = null) {
    $query = "SELECT id, username, email, full_name, role, created_at FROM users";
    
    if ($role !== null) {
        $role = db_escape($role);
        $query .= " WHERE role = '$role'";
    }
    
    $query .= " ORDER BY id ASC";
    
    return db_fetch_all($query);
}

/**
 * Crée un nouvel utilisateur
 * @param array $user_data Données de l'utilisateur
 * @return int|false ID de l'utilisateur créé ou false en cas d'erreur
 */
function create_user($user_data) {
    // Vérifier si le nom d'utilisateur existe déjà
    $username = db_escape($user_data['username']);
    $query = "SELECT id FROM users WHERE username = '$username'";
    if (db_fetch_one($query)) {
        return false; // Le nom d'utilisateur existe déjà
    }
    
    // Vérifier si l'email existe déjà
    $email = db_escape($user_data['email']);
    $query = "SELECT id FROM users WHERE email = '$email'";
    if (db_fetch_one($query)) {
        return false; // L'email existe déjà
    }
    
    // Hacher le mot de passe
    $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
    
    // Insérer l'utilisateur dans la base de données
    $user_id = db_insert('users', $user_data);
    
    if ($user_id) {
        // Enregistrer l'activité
        log_activity('Création d\'utilisateur', "L'utilisateur {$user_data['username']} a été créé", get_current_user() ? $_SESSION['user_id'] : null);
    }
    
    return $user_id;
}

/**
 * Met à jour un utilisateur existant
 * @param int $user_id ID de l'utilisateur
 * @param array $user_data Données de l'utilisateur à mettre à jour
 * @return bool True si la mise à jour réussit, false sinon
 */
function update_user($user_id, $user_data) {
    $user_id = (int) $user_id;
    
    // Vérifier si l'utilisateur existe
    $query = "SELECT id FROM users WHERE id = $user_id";
    if (!db_fetch_one($query)) {
        return false; // L'utilisateur n'existe pas
    }
    
    // Vérifier si le nom d'utilisateur existe déjà (pour un autre utilisateur)
    if (isset($user_data['username'])) {
        $username = db_escape($user_data['username']);
        $query = "SELECT id FROM users WHERE username = '$username' AND id != $user_id";
        if (db_fetch_one($query)) {
            return false; // Le nom d'utilisateur existe déjà pour un autre utilisateur
        }
    }
    
    // Vérifier si l'email existe déjà (pour un autre utilisateur)
    if (isset($user_data['email'])) {
        $email = db_escape($user_data['email']);
        $query = "SELECT id FROM users WHERE email = '$email' AND id != $user_id";
        if (db_fetch_one($query)) {
            return false; // L'email existe déjà pour un autre utilisateur
        }
    }
    
    // Hacher le mot de passe si présent
    if (isset($user_data['password']) && !empty($user_data['password'])) {
        $user_data['password'] = password_hash($user_data['password'], PASSWORD_DEFAULT);
    } else {
        // Ne pas mettre à jour le mot de passe s'il est vide
        unset($user_data['password']);
    }
    
    // Mettre à jour l'utilisateur dans la base de données
    $result = db_update('users', $user_data, "id = $user_id");
    
    if ($result) {
        // Mettre à jour les informations de session si c'est l'utilisateur actuel
        if (is_logged_in() && $_SESSION['user_id'] == $user_id) {
            if (isset($user_data['username'])) {
                $_SESSION['username'] = $user_data['username'];
            }
            if (isset($user_data['email'])) {
                $_SESSION['user_email'] = $user_data['email'];
            }
            if (isset($user_data['full_name'])) {
                $_SESSION['user_fullname'] = $user_data['full_name'];
            }
            if (isset($user_data['role'])) {
                $_SESSION['user_role'] = $user_data['role'];
            }
        }
        
        // Enregistrer l'activité
        log_activity('Mise à jour d\'utilisateur', "L'utilisateur #$user_id a été mis à jour", get_current_user() ? $_SESSION['user_id'] : null);
    }
    
    return $result;
}

/**
 * Supprime un utilisateur
 * @param int $user_id ID de l'utilisateur à supprimer
 * @return bool True si la suppression réussit, false sinon
 */
function delete_user($user_id) {
    $user_id = (int) $user_id;
    
    // Vérifier si l'utilisateur existe
    $user = get_user($user_id);
    if (!$user) {
        return false; // L'utilisateur n'existe pas
    }
    
    // Empêcher la suppression de l'utilisateur connecté
    if (is_logged_in() && $_SESSION['user_id'] == $user_id) {
        return false; // Ne pas supprimer l'utilisateur connecté
    }
    
    // Supprimer l'utilisateur de la base de données
    $result = db_delete('users', "id = $user_id");
    
    if ($result) {
        // Enregistrer l'activité
        log_activity('Suppression d\'utilisateur', "L'utilisateur {$user['username']} a été supprimé", get_current_user() ? $_SESSION['user_id'] : null);
    }
    
    return $result;
}

/**
 * Change le mot de passe d'un utilisateur
 * @param int $user_id ID de l'utilisateur
 * @param string $current_password Mot de passe actuel
 * @param string $new_password Nouveau mot de passe
 * @return bool True si le changement réussit, false sinon
 */
function change_password($user_id, $current_password, $new_password) {
    $user_id = (int) $user_id;
    
    // Vérifier si l'utilisateur existe
    $query = "SELECT id, password FROM users WHERE id = $user_id";
    $user = db_fetch_one($query);
    if (!$user) {
        return false; // L'utilisateur n'existe pas
    }
    
    // Vérifier le mot de passe actuel
    if (!password_verify($current_password, $user['password'])) {
        return false; // Mot de passe actuel incorrect
    }
    
    // Hacher le nouveau mot de passe
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Mettre à jour le mot de passe dans la base de données
    $result = db_update('users', ['password' => $hashed_password], "id = $user_id");
    
    if ($result) {
        // Enregistrer l'activité
        log_activity('Changement de mot de passe', "L'utilisateur #$user_id a changé son mot de passe", $user_id);
    }
    
    return $result;
}

/**
 * Enregistre une activité dans le journal
 * @param string $action Type d'action
 * @param string $description Description de l'action
 * @param int|null $user_id ID de l'utilisateur (null si non connecté)
 * @return int|false ID de l'activité enregistrée ou false en cas d'erreur
 */
function log_activity($action, $description, $user_id = null) {
    $data = [
        'action' => $action,
        'description' => $description,
        'user_id' => $user_id,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    return db_insert('activity_log', $data);
}

/**
 * Récupère les dernières activités du journal
 * @param int $limit Nombre d'activités à récupérer
 * @param int|null $user_id ID de l'utilisateur (null pour toutes les activités)
 * @return array Liste des activités
 */
function get_recent_activities($limit = 10, $user_id = null) {
    $limit = (int) $limit;
    
    $query = "SELECT a.*, u.username, u.full_name 
              FROM activity_log a 
              LEFT JOIN users u ON a.user_id = u.id";
    
    if ($user_id !== null) {
        $user_id = (int) $user_id;
        $query .= " WHERE a.user_id = $user_id";
    }
    
    $query .= " ORDER BY a.created_at DESC LIMIT $limit";
    
    return db_fetch_all($query);
}

/**
 * Génère un jeton CSRF
 * @return string Jeton CSRF
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie un jeton CSRF
 * @param string $token Jeton CSRF à vérifier
 * @return bool True si le jeton est valide, false sinon
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}