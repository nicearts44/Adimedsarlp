<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Vérifier si l'utilisateur actuel a les droits d'administrateur
if (!has_role('admin')) {
    // Rediriger vers le tableau de bord avec un message d'erreur
    $_SESSION['error'] = 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.';
    header('Location: index.php');
    exit;
}

// Initialiser les variables
$message = '';
$error = '';
$user = ['id' => '', 'username' => '', 'email' => '', 'first_name' => '', 'last_name' => '', 'role' => 'author', 'status' => 'active'];
$edit_mode = false;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        // Traitement de la suppression
        if (isset($_POST['delete_user'])) {
            $user_id = (int)$_POST['delete_user'];
            
            // Vérifier que l'utilisateur n'essaie pas de se supprimer lui-même
            if ($user_id === get_current_user()['id']) {
                $error = 'Vous ne pouvez pas supprimer votre propre compte.';
            } else {
                // Dans une implémentation réelle, supprimer l'utilisateur
                // if (delete_user($user_id)) {
                //     $message = 'L\'utilisateur a été supprimé avec succès.';
                // } else {
                //     $error = 'Une erreur est survenue lors de la suppression de l\'utilisateur.';
                // }
                
                // Pour la démonstration
                $message = 'L\'utilisateur a été supprimé avec succès.';
            }
        } 
        // Traitement de l'ajout/modification
        else {
            // Récupérer et valider les données
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $role = $_POST['role'];
            $status = $_POST['status'];
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
            
            // Validation
            if (empty($username)) {
                $error = 'Le nom d\'utilisateur est obligatoire.';
            } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'L\'adresse e-mail est invalide.';
            } elseif ($user_id === 0 && empty($password)) {
                $error = 'Le mot de passe est obligatoire pour un nouvel utilisateur.';
            } elseif (!empty($password) && $password !== $confirm_password) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif (!in_array($role, ['admin', 'editor', 'author'])) {
                $error = 'Le rôle sélectionné est invalide.';
            } elseif (!in_array($status, ['active', 'inactive'])) {
                $error = 'Le statut sélectionné est invalide.';
            } else {
                // Vérifier si le nom d'utilisateur ou l'email existe déjà
                // $existing = db_fetch_one("SELECT id FROM users WHERE (username = '" . db_escape($username) . "' OR email = '" . db_escape($email) . "') AND id != $user_id");
                // if ($existing) {
                //     $error = 'Le nom d\'utilisateur ou l\'adresse e-mail est déjà utilisé.';
                // } else {
                    // Préparer les données
                    $user_data = [
                        'username' => $username,
                        'email' => $email,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'role' => $role,
                        'status' => $status
                    ];
                    
                    // Ajouter le mot de passe si nécessaire
                    if (!empty($password)) {
                        $user_data['password'] = password_hash($password, PASSWORD_DEFAULT);
                    }
                    
                    // Ajouter ou mettre à jour
                    if ($user_id > 0) {
                        // update_user($user_id, $user_data);
                        $message = 'L\'utilisateur a été mis à jour avec succès.';
                    } else {
                        // create_user($user_data);
                        $message = 'L\'utilisateur a été ajouté avec succès.';
                    }
                    
                    // Réinitialiser le formulaire
                    $user = ['id' => '', 'username' => '', 'email' => '', 'first_name' => '', 'last_name' => '', 'role' => 'author', 'status' => 'active'];
                    $edit_mode = false;
                // }
            }
        }
    }
}

// Mode édition
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $user_id = (int)$_GET['edit'];
    
    // Dans une implémentation réelle, récupérer les données de l'utilisateur
    // $user = get_user($user_id);
    
    // Pour la démonstration
    if ($user_id === 1) {
        $user = [
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@adimed.com',
            'first_name' => 'Admin',
            'last_name' => 'Système',
            'role' => 'admin',
            'status' => 'active'
        ];
        $edit_mode = true;
    } elseif ($user_id === 2) {
        $user = [
            'id' => 2,
            'username' => 'editeur',
            'email' => 'editeur@adimed.com',
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'role' => 'editor',
            'status' => 'active'
        ];
        $edit_mode = true;
    } elseif ($user_id === 3) {
        $user = [
            'id' => 3,
            'username' => 'auteur',
            'email' => 'auteur@adimed.com',
            'first_name' => 'Marie',
            'last_name' => 'Martin',
            'role' => 'author',
            'status' => 'active'
        ];
        $edit_mode = true;
    }
}

// Récupérer la liste des utilisateurs
// Dans une implémentation réelle
// $users = get_all_users();

// Pour la démonstration
$users = [
    [
        'id' => 1,
        'username' => 'admin',
        'email' => 'admin@adimed.com',
        'first_name' => 'Admin',
        'last_name' => 'Système',
        'role' => 'admin',
        'status' => 'active',
        'created_at' => '2023-01-01 00:00:00',
        'article_count' => 5
    ],
    [
        'id' => 2,
        'username' => 'editeur',
        'email' => 'editeur@adimed.com',
        'first_name' => 'Jean',
        'last_name' => 'Dupont',
        'role' => 'editor',
        'status' => 'active',
        'created_at' => '2023-01-15 00:00:00',
        'article_count' => 3
    ],
    [
        'id' => 3,
        'username' => 'auteur',
        'email' => 'auteur@adimed.com',
        'first_name' => 'Marie',
        'last_name' => 'Martin',
        'role' => 'author',
        'status' => 'active',
        'created_at' => '2023-02-01 00:00:00',
        'article_count' => 2
    ]
];

// Récupérer l'utilisateur actuel
$current_user = get_current_user();
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des utilisateurs</h2>
</div>

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

<div class="row">
    <!-- Formulaire d'ajout/modification -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo $edit_mode ? 'Modifier l\'utilisateur' : 'Ajouter un utilisateur'; ?></h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    
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
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label"><?php echo $edit_mode ? 'Nouveau mot de passe (laisser vide pour ne pas changer)' : 'Mot de passe'; ?></label>
                        <input type="password" class="form-control" id="password" name="password" <?php echo $edit_mode ? '' : 'required'; ?>>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" <?php echo $edit_mode ? '' : 'required'; ?>>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                            <option value="editor" <?php echo $user['role'] === 'editor' ? 'selected' : ''; ?>>Éditeur</option>
                            <option value="author" <?php echo $user['role'] === 'author' ? 'selected' : ''; ?>>Auteur</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Actif</option>
                            <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>Inactif</option>
                        </select>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <?php if ($edit_mode): ?>
                        <a href="users.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <?php else: ?>
                        <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Liste des utilisateurs -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Liste des utilisateurs</h5>
                <div>
                    <select class="form-select form-select-sm" id="role-filter">
                        <option value="all">Tous les rôles</option>
                        <option value="admin">Administrateurs</option>
                        <option value="editor">Éditeurs</option>
                        <option value="author">Auteurs</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                <div class="alert alert-info mb-0">
                    Aucun utilisateur n'a été créé.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Statut</th>
                                <th>Articles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <?php echo strtoupper(substr($u['first_name'], 0, 1) . substr($u['last_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($u['username']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                    <span class="badge bg-danger">Administrateur</span>
                                    <?php elseif ($u['role'] === 'editor'): ?>
                                    <span class="badge bg-warning">Éditeur</span>
                                    <?php else: ?>
                                    <span class="badge bg-info">Auteur</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($u['status'] === 'active'): ?>
                                    <span class="badge bg-success">Actif</span>
                                    <?php else: ?>
                                    <span class="badge bg-secondary">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-primary"><?php echo $u['article_count']; ?></span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="users.php?edit=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary me-2"><i class="bx bx-edit"></i></a>
                                        <?php if ($u['id'] !== $current_user['id']): ?>
                                        <form action="" method="post" onsubmit="return confirmDelete('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                            <input type="hidden" name="delete_user" value="<?php echo $u['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 500;
    }
</style>

<script>
    // Filtrer les utilisateurs par rôle
    document.getElementById('role-filter').addEventListener('change', function() {
        const role = this.value;
        // Dans une implémentation réelle, vous pourriez utiliser AJAX pour filtrer les utilisateurs
        // Pour cette démonstration, nous rechargerons simplement la page avec un paramètre de filtre
        window.location.href = 'users.php?role=' + role;
    });
</script>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>