<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Récupérer l'utilisateur actuel
$user = get_current_user();

// Initialiser les variables
$message = '';
$error = '';
$password_message = '';
$password_error = '';

// Traitement du formulaire de profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        // Récupérer et valider les données
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        
        // Validation
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'L\'adresse e-mail est invalide.';
        } else {
            // Vérifier si l'email existe déjà pour un autre utilisateur
            // $existing = db_fetch_one("SELECT id FROM users WHERE email = '" . db_escape($email) . "' AND id != {$user['id']}");
            // if ($existing) {
            //     $error = 'Cette adresse e-mail est déjà utilisée par un autre utilisateur.';
            // } else {
                // Préparer les données
                $user_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email
                ];
                
                // Mettre à jour l'utilisateur
                // update_user($user['id'], $user_data);
                
                // Mettre à jour les données de session
                $_SESSION['user']['first_name'] = $first_name;
                $_SESSION['user']['last_name'] = $last_name;
                $_SESSION['user']['email'] = $email;
                
                $message = 'Votre profil a été mis à jour avec succès.';
                
                // Mettre à jour l'utilisateur local pour l'affichage
                $user['first_name'] = $first_name;
                $user['last_name'] = $last_name;
                $user['email'] = $email;
            // }
        }
    }
}

// Traitement du formulaire de mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $password_error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        // Récupérer et valider les données
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validation
        if (empty($current_password)) {
            $password_error = 'Le mot de passe actuel est obligatoire.';
        } elseif (empty($new_password)) {
            $password_error = 'Le nouveau mot de passe est obligatoire.';
        } elseif ($new_password !== $confirm_password) {
            $password_error = 'Les mots de passe ne correspondent pas.';
        } elseif (strlen($new_password) < 8) {
            $password_error = 'Le mot de passe doit contenir au moins 8 caractères.';
        } else {
            // Vérifier le mot de passe actuel
            // Dans une implémentation réelle, vérifier avec la base de données
            // $user_data = db_fetch_one("SELECT password FROM users WHERE id = {$user['id']}");
            // if (!password_verify($current_password, $user_data['password'])) {
            //     $password_error = 'Le mot de passe actuel est incorrect.';
            // } else {
                // Mettre à jour le mot de passe
                // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                // db_update('users', ['password' => $hashed_password], "id = {$user['id']}");
                
                $password_message = 'Votre mot de passe a été mis à jour avec succès.';
            // }
        }
    }
}

// Pour la démonstration, utiliser des données statiques
if (empty($user)) {
    $user = [
        'id' => 1,
        'username' => 'admin',
        'email' => 'admin@adimed.com',
        'first_name' => 'Admin',
        'last_name' => 'Système',
        'role' => 'admin',
        'status' => 'active',
        'created_at' => '2023-01-01 00:00:00',
        'last_login' => '2023-06-15 10:30:00'
    ];
}
?>

<div class="admin-header">
    <h2 class="admin-title">Mon profil</h2>
</div>

<div class="row">
    <!-- Informations du profil -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="profile-avatar mb-3">
                    <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                </div>
                <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="text-muted"><?php echo htmlspecialchars($user['username']); ?></p>
                
                <div class="d-flex justify-content-center mb-2">
                    <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge bg-danger">Administrateur</span>
                    <?php elseif ($user['role'] === 'editor'): ?>
                    <span class="badge bg-warning">Éditeur</span>
                    <?php else: ?>
                    <span class="badge bg-info">Auteur</span>
                    <?php endif; ?>
                </div>
                
                <div class="profile-info">
                    <div class="profile-info-item">
                        <i class="bx bx-envelope"></i>
                        <span><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="profile-info-item">
                        <i class="bx bx-calendar"></i>
                        <span>Inscrit le <?php echo format_date($user['created_at']); ?></span>
                    </div>
                    <div class="profile-info-item">
                        <i class="bx bx-time"></i>
                        <span>Dernière connexion le <?php echo format_date($user['last_login']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Formulaires de modification -->
    <div class="col-md-8">
        <!-- Modifier le profil -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier mon profil</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <input type="hidden" name="update_profile" value="1">
                    
                    <div class="row mb-3">
                        <div class="col">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                        </div>
                        <div class="col">
                            <label for="last_name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                        <div class="form-text">Le nom d'utilisateur ne peut pas être modifié.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                </form>
            </div>
        </div>
        
        <!-- Modifier le mot de passe -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier mon mot de passe</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($password_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($password_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($password_error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($password_error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <input type="hidden" name="update_password" value="1">
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="form-text">Le mot de passe doit contenir au moins 8 caractères.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 500;
        margin: 0 auto;
    }
    
    .profile-info {
        margin-top: 20px;
        text-align: left;
    }
    
    .profile-info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .profile-info-item i {
        margin-right: 10px;
        font-size: 18px;
        color: #6c757d;
    }
</style>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>