<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Initialiser les variables
$message = '';
$error = '';
$category = ['id' => '', 'name' => '', 'slug' => '', 'description' => ''];
$edit_mode = false;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $error = 'Erreur de sécurité. Veuillez réessayer.';
    } else {
        // Traitement de la suppression
        if (isset($_POST['delete_category'])) {
            $category_id = (int)$_POST['delete_category'];
            
            // Dans une implémentation réelle, vérifier si la catégorie est utilisée
            // $articles_count = db_count('articles', "category_id = $category_id");
            // if ($articles_count > 0) {
            //     $error = 'Cette catégorie ne peut pas être supprimée car elle est utilisée par des articles.';
            // } else {
            //     if (db_delete('categories', "id = $category_id")) {
            //         $message = 'La catégorie a été supprimée avec succès.';
            //     } else {
            //         $error = 'Une erreur est survenue lors de la suppression de la catégorie.';
            //     }
            // }
            
            // Pour la démonstration
            $message = 'La catégorie a été supprimée avec succès.';
        } 
        // Traitement de l'ajout/modification
        else {
            // Récupérer et valider les données
            $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            
            // Validation
            if (empty($name)) {
                $error = 'Le nom de la catégorie est obligatoire.';
            } else {
                // Générer le slug
                $slug = generate_slug($name);
                
                // Vérifier si le slug existe déjà (sauf pour la même catégorie en mode édition)
                // $existing = db_fetch_one("SELECT id FROM categories WHERE slug = '" . db_escape($slug) . "' AND id != $category_id");
                // if ($existing) {
                //     $error = 'Une catégorie avec un nom similaire existe déjà.';
                // } else {
                    // Préparer les données
                    $category_data = [
                        'name' => $name,
                        'slug' => $slug,
                        'description' => $description
                    ];
                    
                    // Ajouter ou mettre à jour
                    if ($category_id > 0) {
                        // db_update('categories', $category_data, "id = $category_id");
                        $message = 'La catégorie a été mise à jour avec succès.';
                    } else {
                        // db_insert('categories', $category_data);
                        $message = 'La catégorie a été ajoutée avec succès.';
                    }
                    
                    // Réinitialiser le formulaire
                    $category = ['id' => '', 'name' => '', 'slug' => '', 'description' => ''];
                    $edit_mode = false;
                // }
            }
        }
    }
}

// Mode édition
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $category_id = (int)$_GET['edit'];
    
    // Dans une implémentation réelle, récupérer les données de la catégorie
    // $category = db_fetch_one("SELECT * FROM categories WHERE id = $category_id");
    
    // Pour la démonstration
    if ($category_id === 1) {
        $category = [
            'id' => 1,
            'name' => 'Actualités',
            'slug' => 'actualites',
            'description' => 'Dernières nouvelles et mises à jour'
        ];
        $edit_mode = true;
    } elseif ($category_id === 2) {
        $category = [
            'id' => 2,
            'name' => 'Produits',
            'slug' => 'produits',
            'description' => 'Informations sur nos produits'
        ];
        $edit_mode = true;
    } elseif ($category_id === 3) {
        $category = [
            'id' => 3,
            'name' => 'Événements',
            'slug' => 'evenements',
            'description' => 'Événements à venir et passés'
        ];
        $edit_mode = true;
    }
}

// Récupérer la liste des catégories
// Dans une implémentation réelle
// $categories = db_fetch_all("SELECT * FROM categories ORDER BY name ASC");

// Pour la démonstration
$categories = [
    [
        'id' => 1,
        'name' => 'Actualités',
        'slug' => 'actualites',
        'description' => 'Dernières nouvelles et mises à jour',
        'article_count' => 5
    ],
    [
        'id' => 2,
        'name' => 'Produits',
        'slug' => 'produits',
        'description' => 'Informations sur nos produits',
        'article_count' => 3
    ],
    [
        'id' => 3,
        'name' => 'Événements',
        'slug' => 'evenements',
        'description' => 'Événements à venir et passés',
        'article_count' => 2
    ]
];
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des catégories</h2>
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
                <h5 class="card-title mb-0"><?php echo $edit_mode ? 'Modifier la catégorie' : 'Ajouter une catégorie'; ?></h5>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($category['description']); ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <?php if ($edit_mode): ?>
                        <a href="categories.php" class="btn btn-secondary">Annuler</a>
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
    
    <!-- Liste des catégories -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Liste des catégories</h5>
            </div>
            <div class="card-body">
                <?php if (empty($categories)): ?>
                <div class="alert alert-info mb-0">
                    Aucune catégorie n'a été créée.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Articles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                                <td><code><?php echo htmlspecialchars($cat['slug']); ?></code></td>
                                <td><?php echo htmlspecialchars(substr($cat['description'], 0, 50) . (strlen($cat['description']) > 50 ? '...' : '')); ?></td>
                                <td><span class="badge bg-info"><?php echo $cat['article_count']; ?></span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="categories.php?edit=<?php echo $cat['id']; ?>" class="btn btn-sm btn-primary me-2"><i class="bx bx-edit"></i></a>
                                        <form action="" method="post" onsubmit="return confirmDelete('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                            <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                            <input type="hidden" name="delete_category" value="<?php echo $cat['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" <?php echo $cat['article_count'] > 0 ? 'disabled title="Cette catégorie est utilisée par des articles"' : ''; ?>><i class="bx bx-trash"></i></button>
                                        </form>
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

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>