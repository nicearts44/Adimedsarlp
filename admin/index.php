<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Dans une implémentation réelle, ces données seraient récupérées depuis la base de données
$total_products = 24;
$total_articles = 15;
$total_authors = 3;
$recent_activities = [
    ['date' => '2023-06-20 14:30:00', 'user' => 'Admin', 'action' => 'A ajouté un nouveau produit: Scanner CT Siemens'],
    ['date' => '2023-06-18 10:15:00', 'user' => 'Technicien', 'action' => 'A publié un nouvel article: Formation sur les équipements de laboratoire'],
    ['date' => '2023-06-15 16:45:00', 'user' => 'Admin', 'action' => 'A mis à jour les informations du produit: Échographe portable'],
    ['date' => '2023-06-12 09:20:00', 'user' => 'Ingénieur', 'action' => 'A publié un nouvel article: Maintenance préventive des équipements de radiologie'],
    ['date' => '2023-06-10 11:30:00', 'user' => 'Admin', 'action' => 'A ajouté un nouvel auteur: Dr. Kamara']
];
?>

<div class="admin-header">
    <h2 class="admin-title">Tableau de bord</h2>
    <div class="admin-actions">
        <a href="products-edit.php" class="admin-btn">Ajouter un produit</a>
        <a href="articles-edit.php" class="admin-btn">Publier un article</a>
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Produits</h5>
                        <h2 class="mb-0"><?php echo $total_products; ?></h2>
                    </div>
                    <i class="bx bx-package" style="font-size: 3rem;"></i>
                </div>
                <a href="products.php" class="text-white">Gérer les produits <i class="bx bx-right-arrow-alt"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Articles</h5>
                        <h2 class="mb-0"><?php echo $total_articles; ?></h2>
                    </div>
                    <i class="bx bx-news" style="font-size: 3rem;"></i>
                </div>
                <a href="articles.php" class="text-white">Gérer les articles <i class="bx bx-right-arrow-alt"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Auteurs</h5>
                        <h2 class="mb-0"><?php echo $total_authors; ?></h2>
                    </div>
                    <i class="bx bx-user" style="font-size: 3rem;"></i>
                </div>
                <a href="authors.php" class="text-white">Gérer les auteurs <i class="bx bx-right-arrow-alt"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Activités récentes -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Activités récentes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_activities as $activity): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($activity['date'])); ?></td>
                        <td><?php echo htmlspecialchars($activity['user']); ?></td>
                        <td><?php echo htmlspecialchars($activity['action']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Raccourcis -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Gestion des produits</h5>
            </div>
            <div class="card-body">
                <p>Ajoutez, modifiez ou supprimez des produits du catalogue.</p>
                <div class="d-flex gap-2">
                    <a href="products.php" class="btn btn-outline-primary">Voir tous les produits</a>
                    <a href="products-edit.php" class="btn btn-primary">Ajouter un produit</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Gestion du blog</h5>
            </div>
            <div class="card-body">
                <p>Publiez, modifiez ou supprimez des articles du blog.</p>
                <div class="d-flex gap-2">
                    <a href="articles.php" class="btn btn-outline-success">Voir tous les articles</a>
                    <a href="articles-edit.php" class="btn btn-success">Publier un article</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>