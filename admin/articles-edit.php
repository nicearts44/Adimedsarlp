<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Initialiser les variables
$article = [
    'id' => '',
    'title' => '',
    'slug' => '',
    'content' => '',
    'excerpt' => '',
    'category' => '',
    'author' => '',
    'status' => 'Brouillon',
    'image' => '',
    'date' => date('Y-m-d')
];

$errors = [];
$success = false;
$edit_mode = false;

// Vérifier si nous sommes en mode édition
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $edit_mode = true;
    $article_id = intval($_GET['id']);
    
    // Dans une implémentation réelle, récupérer les données de l'article depuis la base de données
    // Exemple de données simulées pour la démonstration
    if ($article_id === 1) {
        $article = [
            'id' => 1,
            'title' => 'Installation d\'équipements médicaux à l\'hôpital central',
            'slug' => 'installation-equipements-medicaux-hopital-central',
            'content' => '<p>ADIMED SARL a récemment complété l\'installation de nouveaux équipements médicaux à l\'hôpital central. Cette installation comprend des appareils d\'imagerie médicale de dernière génération et des équipements de laboratoire avancés.</p><p>Notre équipe d\'ingénieurs qualifiés a assuré une installation conforme aux normes internationales, garantissant la sécurité et l\'efficacité des équipements.</p><p>La formation du personnel médical a également été assurée pour permettre une utilisation optimale des nouveaux équipements.</p>',
            'excerpt' => 'ADIMED SARL a récemment complété l\'installation de nouveaux équipements médicaux à l\'hôpital central, incluant des appareils d\'imagerie médicale de dernière génération.',
            'category' => 'Équipements médicaux',
            'author' => 'Admin',
            'status' => 'Publié',
            'image' => 'blog-1.jpg',
            'date' => '2023-06-15'
        ];
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et valider les données du formulaire
    $article['title'] = trim($_POST['title'] ?? '');
    $article['content'] = $_POST['content'] ?? '';
    $article['excerpt'] = trim($_POST['excerpt'] ?? '');
    $article['category'] = $_POST['category'] ?? '';
    $article['author'] = $_POST['author'] ?? '';
    $article['status'] = $_POST['status'] ?? 'Brouillon';
    $article['date'] = $_POST['date'] ?? date('Y-m-d');
    
    // Validation
    if (empty($article['title'])) {
        $errors[] = 'Le titre est obligatoire';
    }
    
    if (empty($article['content'])) {
        $errors[] = 'Le contenu est obligatoire';
    }
    
    if (empty($article['category'])) {
        $errors[] = 'La catégorie est obligatoire';
    }
    
    if (empty($article['author'])) {
        $errors[] = 'L\'auteur est obligatoire';
    }
    
    // Traitement de l'image (dans une implémentation réelle)
    /*
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            $errors[] = 'Le type de fichier n\'est pas autorisé. Seuls JPG, PNG et GIF sont acceptés.';
        } elseif ($_FILES['image']['size'] > $max_size) {
            $errors[] = 'La taille de l\'image ne doit pas dépasser 2MB.';
        } else {
            $upload_dir = '../assets/img/blog/';
            $filename = time() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $article['image'] = $filename;
            } else {
                $errors[] = 'Une erreur est survenue lors du téléchargement de l\'image.';
            }
        }
    }
    */
    
    // Si pas d'erreurs, enregistrer l'article
    if (empty($errors)) {
        // Générer un slug à partir du titre
        $article['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $article['title'])));
        
        // Dans une implémentation réelle, enregistrer dans la base de données
        // ...
        
        $success = true;
        
        // Redirection
        if ($edit_mode) {
            header('Location: articles.php?updated=1');
        } else {
            header('Location: articles.php?added=1');
        }
        exit;
    }
}
?>

<div class="admin-header">
    <h2 class="admin-title"><?php echo $edit_mode ? 'Modifier l\'article' : 'Publier un nouvel article'; ?></h2>
    <div class="admin-actions">
        <a href="articles.php" class="admin-btn admin-btn-secondary">Retour à la liste</a>
    </div>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if ($success): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    L'article a été <?php echo $edit_mode ? 'mis à jour' : 'publié'; ?> avec succès.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
            <?php endif; ?>
            
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="title" class="form-label">Titre de l'article <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="date" class="form-label">Date de publication</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $article['date']; ?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category" class="form-label">Catégorie <span class="text-danger">*</span></label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="" disabled <?php echo empty($article['category']) ? 'selected' : ''; ?>>Sélectionner une catégorie</option>
                        <option value="Équipements médicaux" <?php echo $article['category'] === 'Équipements médicaux' ? 'selected' : ''; ?>>Équipements médicaux</option>
                        <option value="Formations" <?php echo $article['category'] === 'Formations' ? 'selected' : ''; ?>>Formations</option>
                        <option value="Maintenance" <?php echo $article['category'] === 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                        <option value="Nouveaux produits" <?php echo $article['category'] === 'Nouveaux produits' ? 'selected' : ''; ?>>Nouveaux produits</option>
                        <option value="Conseils" <?php echo $article['category'] === 'Conseils' ? 'selected' : ''; ?>>Conseils</option>
                        <option value="Événements" <?php echo $article['category'] === 'Événements' ? 'selected' : ''; ?>>Événements</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="author" class="form-label">Auteur <span class="text-danger">*</span></label>
                    <select class="form-select" id="author" name="author" required>
                        <option value="" disabled <?php echo empty($article['author']) ? 'selected' : ''; ?>>Sélectionner un auteur</option>
                        <option value="Admin" <?php echo $article['author'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="Technicien" <?php echo $article['author'] === 'Technicien' ? 'selected' : ''; ?>>Technicien</option>
                        <option value="Ingénieur" <?php echo $article['author'] === 'Ingénieur' ? 'selected' : ''; ?>>Ingénieur</option>
                        <option value="Commercial" <?php echo $article['author'] === 'Commercial' ? 'selected' : ''; ?>>Commercial</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="excerpt" class="form-label">Extrait</label>
                <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($article['excerpt']); ?></textarea>
                <div class="form-text">Un court résumé de l'article qui apparaîtra sur la page principale du blog.</div>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Contenu de l'article <span class="text-danger">*</span></label>
                <textarea class="form-control tinymce" id="content" name="content" rows="10"><?php echo $article['content']; ?></textarea>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image" class="form-label">Image principale</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">Formats acceptés: JPG, PNG, GIF. Taille maximale: 2MB.</div>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="Brouillon" <?php echo $article['status'] === 'Brouillon' ? 'selected' : ''; ?>>Brouillon</option>
                        <option value="Publié" <?php echo $article['status'] === 'Publié' ? 'selected' : ''; ?>>Publié</option>
                    </select>
                </div>
            </div>
            
            <?php if (!empty($article['image'])): ?>
            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <div class="image-preview">
                    <img src="../assets/img/blog/<?php echo htmlspecialchars($article['image']); ?>" alt="Image de l'article" class="img-thumbnail" style="max-height: 200px;">
                </div>
            </div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="articles.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary"><?php echo $edit_mode ? 'Mettre à jour' : 'Publier'; ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialisation de TinyMCE
    tinymce.init({
        selector: '.tinymce',
        height: 400,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; }'
    });
</script>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>