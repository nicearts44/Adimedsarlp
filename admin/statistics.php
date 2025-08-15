<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Récupérer les statistiques
// Dans une implémentation réelle, ces données viendraient de la base de données

// Statistiques des articles
$total_articles = 10;
$published_articles = 8;
$draft_articles = 2;

// Articles par catégorie
$articles_by_category = [
    ['name' => 'Actualités', 'count' => 5],
    ['name' => 'Produits', 'count' => 3],
    ['name' => 'Événements', 'count' => 2]
];

// Articles par auteur
$articles_by_author = [
    ['name' => 'Admin Système', 'count' => 5],
    ['name' => 'Jean Dupont', 'count' => 3],
    ['name' => 'Marie Martin', 'count' => 2]
];

// Statistiques des visites (données fictives pour la démonstration)
$visits_data = [
    ['date' => '2023-06-01', 'count' => 120],
    ['date' => '2023-06-02', 'count' => 145],
    ['date' => '2023-06-03', 'count' => 132],
    ['date' => '2023-06-04', 'count' => 160],
    ['date' => '2023-06-05', 'count' => 178],
    ['date' => '2023-06-06', 'count' => 165],
    ['date' => '2023-06-07', 'count' => 190]
];

// Articles les plus populaires
$popular_articles = [
    ['id' => 1, 'title' => 'Nouveaux équipements médicaux disponibles', 'views' => 325, 'comments' => 12],
    ['id' => 2, 'title' => 'Guide d\'achat pour les stéthoscopes', 'views' => 287, 'comments' => 8],
    ['id' => 3, 'title' => 'Les avantages des tensiomètres numériques', 'views' => 245, 'comments' => 6],
    ['id' => 4, 'title' => 'Comment choisir un lit médical adapté', 'views' => 210, 'comments' => 4],
    ['id' => 5, 'title' => 'Entretien des équipements médicaux', 'views' => 198, 'comments' => 3]
];

// Statistiques des produits
$total_products = 15;
$active_products = 12;
$inactive_products = 3;

// Produits les plus consultés
$popular_products = [
    ['id' => 1, 'name' => 'Tensiomètre automatique', 'views' => 420],
    ['id' => 2, 'name' => 'Stéthoscope professionnel', 'views' => 385],
    ['id' => 3, 'name' => 'Lit médical électrique', 'views' => 310],
    ['id' => 4, 'name' => 'Fauteuil roulant pliable', 'views' => 275],
    ['id' => 5, 'name' => 'Oxymètre de pouls', 'views' => 260]
];

// Statistiques des utilisateurs
$total_users = 3;
$admin_users = 1;
$editor_users = 1;
$author_users = 1;

// Activité récente
$recent_activities = [
    ['user' => 'Admin Système', 'action' => 'a publié un article', 'item' => 'Nouveaux équipements médicaux disponibles', 'time' => '2023-06-07 14:30:00'],
    ['user' => 'Jean Dupont', 'action' => 'a modifié un produit', 'item' => 'Tensiomètre automatique', 'time' => '2023-06-07 11:15:00'],
    ['user' => 'Marie Martin', 'action' => 'a ajouté un produit', 'item' => 'Oxymètre de pouls', 'time' => '2023-06-06 16:45:00'],
    ['user' => 'Admin Système', 'action' => 'a modifié un article', 'item' => 'Guide d\'achat pour les stéthoscopes', 'time' => '2023-06-06 10:20:00'],
    ['user' => 'Jean Dupont', 'action' => 'a publié un article', 'item' => 'Les avantages des tensiomètres numériques', 'time' => '2023-06-05 15:30:00']
];
?>

<div class="admin-header">
    <h2 class="admin-title">Statistiques</h2>
</div>

<div class="row">
    <!-- Statistiques générales -->
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Articles</h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-value"><?php echo $total_articles; ?></div>
                    <div class="stat-icon bg-primary"><i class="bx bx-news"></i></div>
                </div>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($published_articles / $total_articles) * 100; ?>%" aria-valuenow="<?php echo $published_articles; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_articles; ?>"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-success"><?php echo $published_articles; ?> publiés</small>
                    <small class="text-muted"><?php echo $draft_articles; ?> brouillons</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Produits</h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-value"><?php echo $total_products; ?></div>
                    <div class="stat-icon bg-success"><i class="bx bx-package"></i></div>
                </div>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo ($active_products / $total_products) * 100; ?>%" aria-valuenow="<?php echo $active_products; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_products; ?>"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-success"><?php echo $active_products; ?> actifs</small>
                    <small class="text-muted"><?php echo $inactive_products; ?> inactifs</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Utilisateurs</h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-value"><?php echo $total_users; ?></div>
                    <div class="stat-icon bg-info"><i class="bx bx-user"></i></div>
                </div>
                <div class="progress mb-2" style="height: 5px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo ($admin_users / $total_users) * 100; ?>%" aria-valuenow="<?php echo $admin_users; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_users; ?>"></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo ($editor_users / $total_users) * 100; ?>%" aria-valuenow="<?php echo $editor_users; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_users; ?>"></div>
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ($author_users / $total_users) * 100; ?>%" aria-valuenow="<?php echo $author_users; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_users; ?>"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-danger"><?php echo $admin_users; ?> admin</small>
                    <small class="text-warning"><?php echo $editor_users; ?> éditeur</small>
                    <small class="text-info"><?php echo $author_users; ?> auteur</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Visites</h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="stat-value"><?php echo array_sum(array_column($visits_data, 'count')); ?></div>
                    <div class="stat-icon bg-warning"><i class="bx bx-bar-chart-alt"></i></div>
                </div>
                <div class="mini-chart">
                    <?php 
                    $max_visits = max(array_column($visits_data, 'count'));
                    foreach ($visits_data as $data): 
                        $height = ($data['count'] / $max_visits) * 100;
                    ?>
                    <div class="mini-chart-bar" style="height: <?php echo $height; ?>%" title="<?php echo date('d/m/Y', strtotime($data['date'])); ?>: <?php echo $data['count']; ?> visites"></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Graphique des visites -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Visites des 7 derniers jours</h5>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Jour</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary active">Semaine</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Mois</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="visitsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Articles par catégorie -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Articles par catégorie</h5>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="260"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Articles populaires -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Articles les plus populaires</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Vues</th>
                                <th>Commentaires</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($popular_articles as $article): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($article['title']); ?></td>
                                <td><span class="badge bg-primary"><?php echo $article['views']; ?></span></td>
                                <td><span class="badge bg-info"><?php echo $article['comments']; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Produits populaires -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Produits les plus consultés</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Vues</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($popular_products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><span class="badge bg-success"><?php echo $product['views']; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Activité récente -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Activité récente</h5>
            </div>
            <div class="card-body">
                <ul class="activity-list">
                    <?php foreach ($recent_activities as $activity): ?>
                    <li class="activity-item">
                        <div class="activity-icon"><i class="bx bx-user-circle"></i></div>
                        <div class="activity-content">
                            <div class="activity-title">
                                <strong><?php echo htmlspecialchars($activity['user']); ?></strong> 
                                <?php echo htmlspecialchars($activity['action']); ?> 
                                <strong><?php echo htmlspecialchars($activity['item']); ?></strong>
                            </div>
                            <div class="activity-time"><?php echo format_date($activity['time']); ?></div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-value {
        font-size: 2rem;
        font-weight: 600;
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .stat-icon i {
        font-size: 24px;
    }
    
    .mini-chart {
        display: flex;
        align-items: flex-end;
        height: 50px;
        margin-top: 10px;
    }
    
    .mini-chart-bar {
        flex: 1;
        background-color: #ffc107;
        margin: 0 1px;
        border-radius: 2px 2px 0 0;
        min-height: 5px;
    }
    
    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .activity-item {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .activity-icon i {
        font-size: 20px;
        color: #6c757d;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-time {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données pour le graphique des visites
    const visitsData = {
        labels: [<?php echo implode(', ', array_map(function($data) { return '"' . date('d/m', strtotime($data['date'])) . '"'; }, $visits_data)); ?>],
        datasets: [{
            label: 'Visites',
            data: [<?php echo implode(', ', array_column($visits_data, 'count')); ?>],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    };
    
    // Données pour le graphique des catégories
    const categoriesData = {
        labels: [<?php echo implode(', ', array_map(function($cat) { return '"' . $cat['name'] . '"'; }, $articles_by_category)); ?>],
        datasets: [{
            data: [<?php echo implode(', ', array_column($articles_by_category, 'count')); ?>],
            backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
            borderWidth: 0
        }]
    };
    
    // Initialiser les graphiques
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des visites
        const visitsCtx = document.getElementById('visitsChart').getContext('2d');
        new Chart(visitsCtx, {
            type: 'line',
            data: visitsData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Graphique des catégories
        const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
        new Chart(categoriesCtx, {
            type: 'doughnut',
            data: categoriesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>