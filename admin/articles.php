<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Dans une implémentation réelle, ces données seraient récupérées depuis la base de données
$articles = [
    ['id' => 1, 'title' => 'Installation d\'équipements médicaux à l\'hôpital central', 'author' => 'Admin', 'category' => 'Équipements médicaux', 'date' => '2023-06-15', 'status' => 'Publié'],
    ['id' => 2, 'title' => 'Formation sur les nouveaux équipements de laboratoire', 'author' => 'Technicien', 'category' => 'Formations', 'date' => '2023-05-28', 'status' => 'Publié'],
    ['id' => 3, 'title' => 'Maintenance préventive des équipements de radiologie', 'author' => 'Ingénieur', 'category' => 'Maintenance', 'date' => '2023-05-10', 'status' => 'Publié'],
    ['id' => 4, 'title' => 'Nouveaux produits médicaux disponibles chez ADIMED', 'author' => 'Commercial', 'category' => 'Nouveaux produits', 'date' => '2023-05-02', 'status' => 'Publié'],
    ['id' => 5, 'title' => 'Les avantages des équipements d\'imagerie médicale modernes', 'author' => 'Admin', 'category' => 'Équipements médicaux', 'date' => '2023-04-20', 'status' => 'Brouillon'],
    ['id' => 6, 'title' => 'Comment choisir le bon équipement pour votre clinique', 'author' => 'Commercial', 'category' => 'Conseils', 'date' => '2023-04-15', 'status' => 'Publié'],
    ['id' => 7, 'title' => 'L\'importance de la formation continue pour le personnel médical', 'author' => 'Technicien', 'category' => 'Formations', 'date' => '2023-04-05', 'status' => 'Publié'],
    ['id' => 8, 'title' => 'Innovations dans les équipements de laboratoire', 'author' => 'Ingénieur', 'category' => 'Nouveaux produits', 'date' => '2023-03-28', 'status' => 'Brouillon']
];

// Traitement de la suppression (dans une implémentation réelle)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    // Code pour supprimer l'article de la base de données
    
    // Redirection pour éviter les soumissions multiples
    header('Location: articles.php?deleted=1');
    exit;
}

// Message de confirmation
$message = '';
if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
    $message = 'L\'article a été supprimé avec succès.';
} elseif (isset($_GET['added']) && $_GET['added'] == 1) {
    $message = 'L\'article a été ajouté avec succès.';
} elseif (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $message = 'L\'article a été mis à jour avec succès.';
}
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des articles</h2>
    <div class="admin-actions">
        <a href="articles-edit.php" class="admin-btn">Publier un article</a>
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
                <input type="text" class="form-control" id="search" name="search" placeholder="Titre de l'article...">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Catégorie</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Toutes les catégories</option>
                    <option value="Équipements médicaux">Équipements médicaux</option>
                    <option value="Formations">Formations</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Nouveaux produits">Nouveaux produits</option>
                    <option value="Conseils">Conseils</option>
                    <option value="Événements">Événements</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="author" class="form-label">Auteur</label>
                <select class="form-select" id="author" name="author">
                    <option value="">Tous les auteurs</option>
                    <option value="Admin">Admin</option>
                    <option value="Technicien">Technicien</option>
                    <option value="Ingénieur">Ingénieur</option>
                    <option value="Commercial">Commercial</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des articles -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?php echo $article['id']; ?></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars($article['author']); ?></td>
                        <td><?php echo htmlspecialchars($article['category']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($article['date'])); ?></td>
                        <td>
                            <span class="badge <?php echo $article['status'] === 'Publié' ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo htmlspecialchars($article['status']); ?>
                            </span>
                        </td>
                        <td class="actions">
                            <a href="../blog-single.php?id=<?php echo $article['id']; ?>" class="btn-action" style="background-color: #6c757d;" target="_blank"><i class="bx bx-show"></i></a>
                            <a href="articles-edit.php?id=<?php echo $article['id']; ?>" class="btn-action btn-edit"><i class="bx bx-edit"></i></a>
                            <a href="articles.php?delete=<?php echo $article['id']; ?>" class="btn-action btn-delete" onclick="return confirmDelete('Êtes-vous sûr de vouloir supprimer cet article ?');"><i class="bx bx-trash"></i></a>
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
        <li class="page-item">
            <a class="page-link" href="#">Suivant</a>
        </li>
    </ul>
</nav>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>