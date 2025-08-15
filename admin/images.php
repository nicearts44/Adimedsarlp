<?php
// Inclure l'en-tête
require_once 'includes/header.php';
require_once 'includes/image.php';

// Traitement du téléchargement d'image
$message = '';
$error = '';
$uploaded_image = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si une image a été téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Télécharger l'image
        $uploaded_image = upload_image($_FILES['image']);
        
        if ($uploaded_image) {
            // Enregistrer l'image dans la base de données (dans une implémentation réelle)
            // $image_id = save_image_to_db($uploaded_image);
            
            $message = 'L\'image a été téléchargée avec succès.';
        } else {
            $error = 'Une erreur est survenue lors du téléchargement de l\'image.';
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Erreur de téléchargement
        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error = 'L\'image est trop volumineuse.';
                break;
            default:
                $error = 'Une erreur est survenue lors du téléchargement de l\'image.';
                break;
        }
    }
    
    // Traitement de la suppression d'image
    if (isset($_POST['delete_image']) && !empty($_POST['delete_image'])) {
        $filename = $_POST['delete_image'];
        
        // Supprimer l'image du système de fichiers
        if (delete_image($filename)) {
            // Supprimer l'image de la base de données (dans une implémentation réelle)
            // db_delete('images', "filename = '" . db_escape($filename) . "'");
            
            $message = 'L\'image a été supprimée avec succès.';
        } else {
            $error = 'Une erreur est survenue lors de la suppression de l\'image.';
        }
    }
}

// Récupérer la liste des images
$images = get_images();
?>

<div class="admin-header">
    <h2 class="admin-title">Gestion des images</h2>
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
    <!-- Formulaire de téléchargement d'image -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Télécharger une nouvelle image</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="image" class="form-label">Sélectionner une image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Formats acceptés: JPG, PNG, GIF. Taille maximale: 5MB.</div>
                    </div>
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Texte alternatif</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" placeholder="Description de l'image">
                    </div>
                    <div class="mb-3">
                        <label for="caption" class="form-label">Légende</label>
                        <textarea class="form-control" id="caption" name="caption" rows="2" placeholder="Légende de l'image"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Télécharger</button>
                </form>
            </div>
        </div>
        
        <?php if ($uploaded_image): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Image téléchargée</h5>
            </div>
            <div class="card-body">
                <div class="image-preview text-center">
                    <img src="<?php echo htmlspecialchars($uploaded_image['url']); ?>" alt="Image téléchargée" class="img-fluid mb-2">
                    <div class="mt-2">
                        <p><strong>Nom:</strong> <?php echo htmlspecialchars($uploaded_image['filename']); ?></p>
                        <p><strong>Dimensions:</strong> <?php echo $uploaded_image['width']; ?> x <?php echo $uploaded_image['height']; ?> px</p>
                        <p><strong>Taille:</strong> <?php echo round($uploaded_image['size'] / 1024, 2); ?> KB</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Galerie d'images -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Galerie d'images</h5>
                <div>
                    <select class="form-select form-select-sm" id="image-filter">
                        <option value="all">Toutes les images</option>
                        <option value="jpg">JPG</option>
                        <option value="png">PNG</option>
                        <option value="gif">GIF</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($images)): ?>
                <div class="alert alert-info mb-0">
                    Aucune image n'a été téléchargée.
                </div>
                <?php else: ?>
                <div class="row image-gallery">
                    <?php foreach ($images as $image): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="image-card">
                            <div class="image-preview">
                                <img src="<?php echo htmlspecialchars($image['thumb_url']); ?>" alt="<?php echo htmlspecialchars($image['filename']); ?>" class="img-fluid">
                            </div>
                            <div class="image-info">
                                <p class="image-name" title="<?php echo htmlspecialchars($image['filename']); ?>"><?php echo htmlspecialchars(substr($image['filename'], 0, 20) . (strlen($image['filename']) > 20 ? '...' : '')); ?></p>
                                <p class="image-dimensions"><?php echo $image['width']; ?> x <?php echo $image['height']; ?> px</p>
                            </div>
                            <div class="image-actions">
                                <a href="<?php echo htmlspecialchars($image['url']); ?>" class="btn-action" style="background-color: #6c757d;" target="_blank"><i class="bx bx-show"></i></a>
                                <button type="button" class="btn-action btn-copy" data-url="<?php echo htmlspecialchars($image['url']); ?>" style="background-color: #0d6efd;"><i class="bx bx-copy"></i></button>
                                <form action="" method="post" class="d-inline" onsubmit="return confirmDelete('Êtes-vous sûr de vouloir supprimer cette image ?');">
                                    <input type="hidden" name="delete_image" value="<?php echo htmlspecialchars($image['filename']); ?>">
                                    <button type="submit" class="btn-action btn-delete"><i class="bx bx-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Copier l'URL de l'image dans le presse-papier
    document.querySelectorAll('.btn-copy').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                // Changer temporairement l'icône pour indiquer que l'URL a été copiée
                const icon = this.querySelector('i');
                icon.classList.remove('bx-copy');
                icon.classList.add('bx-check');
                
                setTimeout(() => {
                    icon.classList.remove('bx-check');
                    icon.classList.add('bx-copy');
                }, 1500);
            });
        });
    });
    
    // Filtrer les images par type
    document.getElementById('image-filter').addEventListener('change', function() {
        const type = this.value;
        // Dans une implémentation réelle, vous pourriez utiliser AJAX pour filtrer les images
        // Pour cette démonstration, nous rechargerons simplement la page avec un paramètre de filtre
        window.location.href = 'images.php?type=' + type;
    });
</script>

<style>
    .image-gallery {
        margin: 0 -10px;
    }
    
    .image-card {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .image-preview {
        height: 150px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .image-preview img {
        max-height: 100%;
        object-fit: cover;
        width: 100%;
    }
    
    .image-info {
        padding: 10px;
        background-color: #fff;
        flex-grow: 1;
    }
    
    .image-name {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .image-dimensions {
        margin: 5px 0 0;
        font-size: 12px;
        color: #6c757d;
    }
    
    .image-actions {
        display: flex;
        justify-content: space-between;
        padding: 8px;
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
    }
    
    .btn-action {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-action:hover {
        opacity: 0.9;
    }
</style>

<?php
// Inclure le pied de page
require_once 'includes/footer.php';
?>