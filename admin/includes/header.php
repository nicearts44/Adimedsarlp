<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier de configuration
require_once 'config.php';

// Vérifier si l'utilisateur est connecté
requireLogin();

// Récupérer le nom de la page actuelle
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ADIMED SARL - Administration</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/blog-admin.css" rel="stylesheet">
    
    <!-- TinyMCE pour l'éditeur de texte riche -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce',
            height: 400,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
</head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top bg-white">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">ADIMED SARL<span>.</span></a></h1>
            
            <nav class="navbar">
                <ul>
                    <li><a class="nav-link <?php echo $current_page === 'index.php' ? 'active' : ''; ?>" href="index.php">Tableau de bord</a></li>
                    <li><a class="nav-link <?php echo $current_page === 'products.php' ? 'active' : ''; ?>" href="products.php">Produits</a></li>
                    <li><a class="nav-link <?php echo $current_page === 'articles.php' ? 'active' : ''; ?>" href="articles.php">Articles</a></li>
                    <li><a class="nav-link <?php echo $current_page === 'users.php' ? 'active' : ''; ?>" href="authors.php">Auteurs</a></li>
                    <li><a class="nav-link <?php echo $current_page === 'settings.php' ? 'active' : ''; ?>" href="settings.php">Paramètres</a></li>
                    <li><a class="nav-link" href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- ======= Main Content ======= -->
    <main id="main" class="admin-section mt-5 pt-5">
        <div class="container admin-container">