<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Initialiser les variables
$product = [
    'id' => '',
    'name' => '',
    'category' => '',
    'description' => '',
    'price' => '',
    'status' => 'En stock',
    'image' => ''
];
$is_edit = false;
$page_title = 'Ajouter un produit';

// Vérifier s'il s'agit d'une édition
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $is_edit = true;
    $page_title = 'Modifier le produit';
    
    // Dans une implémentation réelle, ces données seraient récupérées depuis la base de données
    // Exemple de données pour l'édition
    if ($product_id === 1) {
        $product = [
            'id' => 1,
            'name' => 'Scanner CT Siemens',
            'category' => 'Imagerie médicale',
            'description' => 'Scanner CT de dernière génération offrant une qualité d\'image exceptionnelle avec une dose de radiation réduite. Idéal pour les diagnostics précis et rapides.',
            'price' => '120000',
            'status' => 'En stock',
            'image' => '../assets/img/products/scanner.jpg'
        ];
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $product['name'] = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
    $product['category'] = isset($_POST['category']) ? sanitizeInput($_POST['category']) : '';
    $product['description'] = isset($_POST['description']) ? $_POST['description'] : ''; // Le contenu HTML est géré par TinyMCE
    $product['price'] = isset($_POST['price']) ? sanitizeInput($_POST['price']) : '';
    $product['status'] = isset($_POST['status']) ? sanitizeInput($_POST['status']) : '';
    
    // Validation des données
    $errors = [];
    if (empty($product['name'])) {
        $errors[] = 'Le nom du produit est requis.';
    }
    if (empty($product['category'])) {
        $errors[] = 'La catégorie est requise.';
    }
    if (empty($product['price'])) {
        $errors[] = 'Le prix est requis.';
    } elseif (!is_numeric(str_replace(',', '.', $product['price']))) {
        $errors[] = 'Le prix doit être un nombre.';
    }
    
    // Traitement de l'image (dans une implémentation réelle)
    // if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    //     $upload_result = uploadImage($_FILES['image'], '../assets/img/products');
    //     if ($upload_result['success']) {
    //         $product['image'] = $upload_result['file_path'];
    //     } else {
    //         $errors[] = $upload_result['message'];
    //     }
    // }
    
    // Si aucune erreur, enregistrer les données
    if (empty($errors)) {
        // Dans une implémentation réelle, ces données seraient enregistrées dans la base de données
        
        // Redirection avec message de succès
        if ($is_edit) {
            header('Location: products.php?updated=1');
        } else {
            header('Location: products.php?added=1');
        }
        exit;
    }
}
?>

<div class="admin-header">
    <h2 class="admin-title"><?php echo $page_title; ?></h2>
    <div class="admin-actions">
        <a href="products.php" class="admin-btn">Retour à la liste</a>
    </div>
</div>

<?php if (isset($errors) && !empty($errors)): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Formulaire d'édition -->
<div class="admin-form">
    <form action="" method="post" enctype="multipart/form-data">
        <?php if ($is_edit): ?>
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nom du produit *</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Catégorie *</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Imagerie médicale" <?php echo $product['category'] === 'Imagerie médicale' ? 'selected' : ''; ?>>Imagerie médicale</option>
                                <option value="Surveillance" <?php echo $product['category'] === 'Surveillance' ? 'selected' : ''; ?>>Surveillance</option>
                                <option value="Urgence" <?php echo $product['category'] === 'Urgence' ? 'selected' : ''; ?>>Urgence</option>
                                <option value="Laboratoire" <?php echo $product['category'] === 'Laboratoire' ? 'selected' : ''; ?>>Laboratoire</option>
                                <option value="Stérilisation" <?php echo $product['category'] === 'Stérilisation' ? 'selected' : ''; ?>>Stérilisation</option>
                                <option value="Diagnostic" <?php echo $product['category'] === 'Diagnostic' ? 'selected' : ''; ?>>Diagnostic</option>
                                <option value="Mobilier médical" <?php echo $product['category'] === 'Mobilier médical' ? 'selected' : ''; ?>>Mobilier médical</option>
                                <option value="Anesthésie" <?php echo $product['category'] === 'Anesthésie' ? 'selected' : ''; ?>>Anesthésie</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Prix (€) *</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="En stock" <?php echo $product['status'] === 'En stock' ? 'selected' : ''; ?>>En stock</option>
                        <option value="En rupture" <?php echo $product['status'] === 'En rupture' ? 'selected' : ''; ?>>En rupture</option>
                        <option value="Sur commande" <?php echo $product['status'] === 'Sur commande' ? 'selected' : ''; ?>>Sur commande</option>
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control tinymce" id="description" name="description" rows="10"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label class="form-label">Image du produit</label>
                    
                    <?php if (!empty($product['image'])): ?>
                    <div class="image-preview mb-3">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" id="image-preview" alt="Aperçu de l'image" class="img-fluid">
                    </div>
                    <?php else: ?>
                    <div class="image-preview mb-3">
                        <img src="../assets/img/no-image.jpg" id="image-preview" alt="Aucune image" class="img-fluid">
                    </div>
                    <?php endif; ?>
                    
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this, 'image-preview')">
                    <small class="form-text text-muted">Formats acceptés: JPG, PNG, GIF. Taille maximale: 5MB.</small>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="products.php" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>