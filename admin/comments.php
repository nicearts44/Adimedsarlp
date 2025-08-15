<?php
// Inclure l'en-tête
require_once 'includes/header.php';

// Vérifier si l'utilisateur est connecté
require_login();

// Initialiser les variables
$message = '';
$message_type = '';
$comments = [];

// Générer un token CSRF
$csrf_token = generate_csrf_token();

// Traitement des actions (approbation, rejet, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        $message = 'Erreur de sécurité. Veuillez réessayer.';
        $message_type = 'danger';
    } else {
        // Traiter l'action demandée
        if (isset($_POST['action']) && isset($_POST['comment_id'])) {
            $comment_id = intval($_POST['comment_id']);
            
            switch ($_POST['action']) {
                case 'approve':
                    // Code pour approuver un commentaire
                    // Dans une implémentation réelle, vous mettriez à jour la base de données
                    $message = 'Le commentaire a été approuvé avec succès.';
                    $message_type = 'success';
                    break;
                    
                case 'reject':
                    // Code pour rejeter un commentaire
                    $message = 'Le commentaire a été rejeté avec succès.';
                    $message_type = 'success';
                    break;
                    
                case 'delete':
                    // Code pour supprimer un commentaire
                    $message = 'Le commentaire a été supprimé avec succès.';
                    $message_type = 'success';
                    break;
                    
                default:
                    $message = 'Action non reconnue.';
                    $message_type = 'danger';
            }
        }
    }
}

// Récupérer les commentaires (dans une implémentation réelle, ces données viendraient de la base de données)
// Exemple de données pour la démonstration
$comments = [
    [
        'id' => 1,
        'article_id' => 1,
        'article_title' => 'Nouveaux équipements médicaux disponibles',
        'author' => 'Jean Dupont',
        'email' => 'jean.dupont@example.com',
        'content' => 'Très intéressant ! J\'aimerais en savoir plus sur les tensiomètres automatiques.',
        'date' => '2023-06-07 10:15:30',
        'status' => 'approved',
        'ip' => '192.168.1.1'
    ],
    [
        'id' => 2,
        'article_id' => 1,
        'article_title' => 'Nouveaux équipements médicaux disponibles',
        'author' => 'Marie Martin',
        'email' => 'marie.martin@example.com',
        'content' => 'Est-ce que ces équipements sont disponibles pour les particuliers ou seulement pour les professionnels ?',
        'date' => '2023-06-07 11:30:45',
        'status' => 'pending',
        'ip' => '192.168.1.2'
    ],
    [
        'id' => 3,
        'article_id' => 2,
        'article_title' => 'Guide d\'achat pour les stéthoscopes',
        'author' => 'Pierre Durand',
        'email' => 'pierre.durand@example.com',
        'content' => 'J\'utilise le modèle Littmann Classic III et je le recommande vivement pour sa qualité acoustique.',
        'date' => '2023-06-06 14:20:15',
        'status' => 'approved',
        'ip' => '192.168.1.3'
    ],
    [
        'id' => 4,
        'article_id' => 3,
        'article_title' => 'Les avantages des tensiomètres numériques',
        'author' => 'Sophie Lefebvre',
        'email' => 'sophie.lefebvre@example.com',
        'content' => 'Les tensiomètres numériques sont-ils plus précis que les modèles analogiques ?',
        'date' => '2023-06-05 09:45:10',
        'status' => 'pending',
        'ip' => '192.168.1.4'
    ],
    [
        'id' => 5,
        'article_id' => 4,
        'article_title' => 'Comment choisir un lit médical adapté',
        'author' => 'Robert Martin',
        'email' => 'robert.martin@example.com',
        'content' => 'Cet article m\'a beaucoup aidé pour choisir un lit médical pour ma mère. Merci !',
        'date' => '2023-06-04 16:30:20',
        'status' => 'approved',
        'ip' => '192.168.1.5'
    ],
    [
        'id' => 6,
        'article_id' => 5,
        'article_title' => 'Entretien des équipements médicaux',
        'author' => 'Anonyme',
        'email' => 'anonyme@example.com',
        'content' => 'Contenu inapproprié ou spam à rejeter.',
        'date' => '2023-06-03 08:15:40',
        'status' => 'rejected',
        'ip' => '192.168.1.6'
    ]
];

// Filtrer les commentaires selon le statut sélectionné
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
if ($status_filter !== 'all') {
    $comments = array_filter($comments, function($comment) use ($status_filter) {
        return $comment['status'] === $status_filter;
    });
}

// Compter les commentaires par statut
$count_all = count([
    ['id' => 1, 'status' => 'approved'],
    ['id' => 2, 'status' => 'pending'],
    ['id' => 3, 'status' => 'approved'],
    ['id' => 4, 'status' => 'pending'],
    ['id' => 5, 'status' => 'approved'],
    ['id' => 6, 'status' => 'rejected']
]);

$count_approved = count(array_filter($comments, function($comment) {
    return $comment['status'] === 'approved';
}));

$count_pending = count(array_filter($comments, function($comment) {
    return $comment['status'] === 'pending';
}));

$count_rejected = count(array_filter($comments, function($comment) {
    return $comment['status'] === 'rejected';
}));
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des commentaires</h2>
</div>

<?php if (!empty($message)): ?>
<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="card-title mb-0">Liste des commentaires</h5>
                <p class="text-muted small mb-0">Gérez les commentaires des articles du blog</p>
            </div>
            <div class="btn-group">
                <a href="?status=all" class="btn btn-sm <?php echo $status_filter === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                    Tous <span class="badge bg-secondary"><?php echo $count_all; ?></span>
                </a>
                <a href="?status=approved" class="btn btn-sm <?php echo $status_filter === 'approved' ? 'btn-success' : 'btn-outline-success'; ?>">
                    Approuvés <span class="badge bg-secondary"><?php echo $count_approved; ?></span>
                </a>
                <a href="?status=pending" class="btn btn-sm <?php echo $status_filter === 'pending' ? 'btn-warning' : 'btn-outline-warning'; ?>">
                    En attente <span class="badge bg-secondary"><?php echo $count_pending; ?></span>
                </a>
                <a href="?status=rejected" class="btn btn-sm <?php echo $status_filter === 'rejected' ? 'btn-danger' : 'btn-outline-danger'; ?>">
                    Rejetés <span class="badge bg-secondary"><?php echo $count_rejected; ?></span>
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Commentaire</th>
                        <th>Article</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($comments)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">Aucun commentaire trouvé</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2 bg-light rounded-circle text-center">
                                    <span class="text-muted"><?php echo substr($comment['author'], 0, 1); ?></span>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?php echo htmlspecialchars($comment['author']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($comment['email']); ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="comment-content">
                                <?php echo htmlspecialchars($comment['content']); ?>
                            </div>
                            <small class="text-muted">IP: <?php echo $comment['ip']; ?></small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <?php echo htmlspecialchars($comment['article_title']); ?>
                            </a>
                        </td>
                        <td>
                            <span class="text-muted">
                                <?php echo date('d/m/Y H:i', strtotime($comment['date'])); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($comment['status'] === 'approved'): ?>
                                <span class="badge bg-success">Approuvé</span>
                            <?php elseif ($comment['status'] === 'pending'): ?>
                                <span class="badge bg-warning">En attente</span>
                            <?php elseif ($comment['status'] === 'rejected'): ?>
                                <span class="badge bg-danger">Rejeté</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <?php if ($comment['status'] !== 'approved'): ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success" title="Approuver">
                                        <i class="bx bx-check"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <?php if ($comment['status'] !== 'rejected'): ?>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-warning" title="Rejeter">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <button type="button" class="btn btn-sm btn-info" title="Voir" data-bs-toggle="modal" data-bs-target="#viewCommentModal<?php echo $comment['id']; ?>">
                                    <i class="bx bx-show"></i>
                                </button>
                                
                                <form method="post" class="d-inline delete-form">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Modal pour voir le commentaire -->
                            <div class="modal fade" id="viewCommentModal<?php echo $comment['id']; ?>" tabindex="-1" aria-labelledby="viewCommentModalLabel<?php echo $comment['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewCommentModalLabel<?php echo $comment['id']; ?>">Détails du commentaire</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h6>Auteur</h6>
                                                <p><?php echo htmlspecialchars($comment['author']); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Email</h6>
                                                <p><?php echo htmlspecialchars($comment['email']); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>IP</h6>
                                                <p><?php echo $comment['ip']; ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Date</h6>
                                                <p><?php echo date('d/m/Y H:i:s', strtotime($comment['date'])); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Article</h6>
                                                <p><?php echo htmlspecialchars($comment['article_title']); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Statut</h6>
                                                <p>
                                                    <?php if ($comment['status'] === 'approved'): ?>
                                                        <span class="badge bg-success">Approuvé</span>
                                                    <?php elseif ($comment['status'] === 'pending'): ?>
                                                        <span class="badge bg-warning">En attente</span>
                                                    <?php elseif ($comment['status'] === 'rejected'): ?>
                                                        <span class="badge bg-danger">Rejeté</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div>
                                                <h6>Commentaire</h6>
                                                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <?php if ($comment['status'] !== 'approved'): ?>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn btn-success">Approuver</button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if ($comment['status'] !== 'rejected'): ?>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn btn-warning">Rejeter</button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (à implémenter avec la base de données réelle) -->
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
    </div>
</div>

<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        line-height: 32px;
        font-size: 16px;
    }
    
    .comment-content {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    // Confirmation avant suppression
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ? Cette action est irréversible.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>