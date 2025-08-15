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

// Récupérer les paramètres actuels
// Dans une implémentation réelle
// $settings = get_all_settings();

// Pour la démonstration
$settings = [
    'site_title' => 'Adimed Sarl',
    'site_description' => 'Entreprise spécialisée dans la vente de matériel médical',
    'site_email' => 'contact@adimed.com',
    'site_phone' => '+237 123 456 789',
    'site_address' => 'Douala, Cameroun',
    'blog_posts_per_page' => 6,
    'blog_show_author' => 'yes',
    'blog_show_date' => 'yes',
    'blog_allow_comments' => 'yes',
    'social_facebook' => 'https://facebook.com/adimed',
    'social_twitter' => 'https://twitter.com/adimed',
    'social_instagram' => 'https://instagram.com/adimed',
    'social_linkedin' => 'https://linkedin.com/company/adimed',
    'email_notifications' => 'yes',
    'email_new_comment' => 'yes',
    'email_new_user' => 'yes',
    'maintenance_mode' => 'no',
    'maintenance_message' => 'Le site est actuellement en maintenance. Veuillez revenir plus tard.'
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        // Récupérer les données du formulaire
        $updated_settings = [
            'site_title' => trim($_POST['site_title']),
            'site_description' => trim($_POST['site_description']),
            'site_email' => trim($_POST['site_email']),
            'site_phone' => trim($_POST['site_phone']),
            'site_address' => trim($_POST['site_address']),
            'blog_posts_per_page' => (int)$_POST['blog_posts_per_page'],
            'blog_show_author' => isset($_POST['blog_show_author']) ? 'yes' : 'no',
            'blog_show_date' => isset($_POST['blog_show_date']) ? 'yes' : 'no',
            'blog_allow_comments' => isset($_POST['blog_allow_comments']) ? 'yes' : 'no',
            'social_facebook' => trim($_POST['social_facebook']),
            'social_twitter' => trim($_POST['social_twitter']),
            'social_instagram' => trim($_POST['social_instagram']),
            'social_linkedin' => trim($_POST['social_linkedin']),
            'email_notifications' => isset($_POST['email_notifications']) ? 'yes' : 'no',
            'email_new_comment' => isset($_POST['email_new_comment']) ? 'yes' : 'no',
            'email_new_user' => isset($_POST['email_new_user']) ? 'yes' : 'no',
            'maintenance_mode' => isset($_POST['maintenance_mode']) ? 'yes' : 'no',
            'maintenance_message' => trim($_POST['maintenance_message'])
        ];
        
        // Validation
        if (empty($updated_settings['site_title'])) {
            $error = 'Le titre du site est obligatoire.';
        } elseif (!empty($updated_settings['site_email']) && !filter_var($updated_settings['site_email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'L\'adresse e-mail du site est invalide.';
        } elseif ($updated_settings['blog_posts_per_page'] < 1) {
            $error = 'Le nombre d\'articles par page doit être supérieur à 0.';
        } else {
            // Mettre à jour les paramètres
            // Dans une implémentation réelle
            // foreach ($updated_settings as $key => $value) {
            //     update_setting($key, $value);
            // }
            
            $message = 'Les paramètres ont été mis à jour avec succès.';
            $settings = $updated_settings;
        }
    }
}
?>

<div class="admin-header">
    <h2 class="admin-title">Paramètres du site</h2>
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

<div class="card">
    <div class="card-body">
        <form action="" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
            
            <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">Général</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="blog-tab" data-bs-toggle="tab" data-bs-target="#blog" type="button" role="tab" aria-controls="blog" aria-selected="false">Blog</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Réseaux sociaux</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">Notifications</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab" aria-controls="maintenance" aria-selected="false">Maintenance</button>
                </li>
            </ul>
            
            <div class="tab-content" id="settingsTabsContent">
                <!-- Paramètres généraux -->
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="site_title" class="form-label">Titre du site</label>
                            <input type="text" class="form-control" id="site_title" name="site_title" value="<?php echo htmlspecialchars($settings['site_title']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="site_email" class="form-label">Email du site</label>
                            <input type="email" class="form-control" id="site_email" name="site_email" value="<?php echo htmlspecialchars($settings['site_email']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="site_description" class="form-label">Description du site</label>
                        <textarea class="form-control" id="site_description" name="site_description" rows="2"><?php echo htmlspecialchars($settings['site_description']); ?></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="site_phone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="site_phone" name="site_phone" value="<?php echo htmlspecialchars($settings['site_phone']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="site_address" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="site_address" name="site_address" value="<?php echo htmlspecialchars($settings['site_address']); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres du blog -->
                <div class="tab-pane fade" id="blog" role="tabpanel" aria-labelledby="blog-tab">
                    <div class="mb-3">
                        <label for="blog_posts_per_page" class="form-label">Nombre d'articles par page</label>
                        <input type="number" class="form-control" id="blog_posts_per_page" name="blog_posts_per_page" value="<?php echo (int)$settings['blog_posts_per_page']; ?>" min="1" max="20">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="blog_show_author" name="blog_show_author" <?php echo $settings['blog_show_author'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="blog_show_author">Afficher l'auteur des articles</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="blog_show_date" name="blog_show_date" <?php echo $settings['blog_show_date'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="blog_show_date">Afficher la date des articles</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="blog_allow_comments" name="blog_allow_comments" <?php echo $settings['blog_allow_comments'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="blog_allow_comments">Autoriser les commentaires</label>
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres des réseaux sociaux -->
                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                    <div class="mb-3">
                        <label for="social_facebook" class="form-label">Facebook</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bxl-facebook"></i></span>
                            <input type="url" class="form-control" id="social_facebook" name="social_facebook" value="<?php echo htmlspecialchars($settings['social_facebook']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="social_twitter" class="form-label">Twitter</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bxl-twitter"></i></span>
                            <input type="url" class="form-control" id="social_twitter" name="social_twitter" value="<?php echo htmlspecialchars($settings['social_twitter']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="social_instagram" class="form-label">Instagram</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bxl-instagram"></i></span>
                            <input type="url" class="form-control" id="social_instagram" name="social_instagram" value="<?php echo htmlspecialchars($settings['social_instagram']); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="social_linkedin" class="form-label">LinkedIn</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bxl-linkedin"></i></span>
                            <input type="url" class="form-control" id="social_linkedin" name="social_linkedin" value="<?php echo htmlspecialchars($settings['social_linkedin']); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres des notifications par email -->
                <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" <?php echo $settings['email_notifications'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="email_notifications">Activer les notifications par email</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="email_new_comment" name="email_new_comment" <?php echo $settings['email_new_comment'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="email_new_comment">Recevoir un email pour chaque nouveau commentaire</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="email_new_user" name="email_new_user" <?php echo $settings['email_new_user'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="email_new_user">Recevoir un email pour chaque nouvel utilisateur</label>
                        </div>
                    </div>
                </div>
                
                <!-- Paramètres de maintenance -->
                <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" <?php echo $settings['maintenance_mode'] === 'yes' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="maintenance_mode">Activer le mode maintenance</label>
                        </div>
                        <div class="form-text">Lorsque le mode maintenance est activé, seuls les administrateurs peuvent accéder au site.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="maintenance_message" class="form-label">Message de maintenance</label>
                        <textarea class="form-control" id="maintenance_message" name="maintenance_message" rows="3"><?php echo htmlspecialchars($settings['maintenance_message']); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <button type="reset" class="btn btn-secondary ms-2">Réinitialiser</button>
            </div>
        </form>
    </div>
</div>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>