<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Dans une implémentation réelle, ces données seraient récupérées depuis la base de données
$products = [
    ['id' => 1, 'name' => 'Scanner CT Siemens', 'category' => 'Imagerie médicale', 'price' => '120000', 'status' => 'En stock'],
    ['id' => 2, 'name' => 'Échographe portable', 'category' => 'Imagerie médicale', 'price' => '45000', 'status' => 'En stock'],
    ['id' => 3, 'name' => 'Moniteur de signes vitaux', 'category' => 'Surveillance', 'price' => '8500', 'status' => 'En stock'],
    ['id' => 4, 'name' => 'Défibrillateur automatique', 'category' => 'Urgence', 'price' => '12000', 'status' => 'En rupture'],
    ['id' => 5, 'name' => 'Analyseur de sang', 'category' => 'Laboratoire', 'price' => '35000', 'status' => 'En stock'],
    ['id' => 6, 'name' => 'Stérilisateur à vapeur', 'category' => 'Stérilisation', 'price' => '18000', 'status' => 'En stock'],
    ['id' => 7, 'name' => 'Système d\'IRM', 'category' => 'Imagerie médicale', 'price' => '250000', 'status' => 'Sur commande'],
    ['id' => 8, 'name' => 'Électrocardiographe', 'category' => 'Diagnostic', 'price' => '9500', 'status' => 'En stock'],
    ['id' => 9, 'name' => 'Lit d\'hôpital électrique', 'category' => 'Mobilier médical', 'price' => '7500', 'status' => 'En stock'],
    ['id' => 10, 'name' => 'Appareil d\'anesthésie', 'category' => 'Anesthésie', 'price' => '85000', 'status' => 'Sur commande']
];

// Traitement de la suppression (dans une implémentation réelle)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    // Code pour supprimer le produit de la base de données
    
    // Redirection pour éviter les soumissions multiples
    header('Location: products.php?deleted=1');
    exit;
}

// Message de confirmation
$message = '';
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $message = 'Le produit a été supprimé avec succès.';
} elseif (isset($_GET['added']) && $_GET['added'] == 1) {
    $message = 'Le produit a été ajouté avec succès.';
} elseif (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $message = 'Le produit a été mis à jour avec succès.';
}
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des produits</h2>
    <div class="admin-actions">
        <a href="products-edit.php" class="admin-btn">Ajouter un produit</a>
    </div>
</div>

<?php if (!empty($message)): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo htmlspecialchars($message); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form action="" method="get" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Rechercher</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Nom du produit...">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Catégorie</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Toutes les catégories</option>
                    <option value="Imagerie médicale">Imagerie médicale</option>
                    <option value="Surveillance">Surveillance</option>
                    <option value="Urgence">Urgence</option>
                    <option value="Laboratoire">Laboratoire</option>
                    <option value="Stérilisation">Stérilisation</option>
                    <option value="Diagnostic">Diagnostic</option>
                    <option value="Mobilier médical">Mobilier médical</option>
                    <option value="Anesthésie">Anesthésie</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Statut</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Tous les statuts</option>
                    <option value="En stock">En stock</option>
                    <option value="En rupture">En rupture</option>
                    <option value="Sur commande">Sur commande</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des produits -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du produit</th>
                        <th>Catégorie</th>
                        <th>Prix (€)</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td><?php echo number_format($product['price'], 2, ',', ' '); ?></td>
                        <td>
                            <span class="badge <?php 
                                echo $product['status'] === 'En stock' ? 'bg-success' : 
                                    ($product['status'] === 'En rupture' ? 'bg-danger' : 'bg-warning'); 
                            ?>">
                                <?php echo htmlspecialchars($product['status']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="products-edit.php?id=<?php echo $product['id']; ?>" class="btn-action btn-edit"><i class="bx bx-edit"></i></a>
                            <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn-action btn-delete" onclick="return confirmDelete('Êtes-vous sûr de vouloir supprimer ce produit ?');"><i class="bx bx-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link" href="#">Suivant</a>
        </li>
    </ul>
</nav>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>