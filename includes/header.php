<?php
// Déterminer la page active
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo isset($page_title) ? $page_title . ' - ADIMED SARL' : 'ADIMED SARL'; ?></title>
  <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'ADIMED SARL - Experts en Maintenance et Installation de dispositifs biomédicaux et équipements de laboratoires au Bénin'; ?>">
  <meta name="keywords" content="ADIMED, biomédical, laboratoire, équipement médical, Bénin, Cotonou">

  <!-- Favicons -->
  <!-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">-->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  
  <?php if(isset($additional_css)): ?>
  <?php echo $additional_css; ?>
  <?php endif; ?>
</head>

<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.jpg" alt=""> 
        <h1 class="sitename">ADIMED SARL</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" <?php echo ($current_page == 'index.php') ? 'class="active"' : ''; ?>>Accueil</a></li>
          <li><a href="about.php" <?php echo ($current_page == 'about.php') ? 'class="active"' : ''; ?>>A propos</a></li>
          <li><a href="team.php" <?php echo ($current_page == 'team.php') ? 'class="active"' : ''; ?>>Equipe</a></li>
          <li><a href="services.php" <?php echo ($current_page == 'services.php') ? 'class="active"' : ''; ?>>Services</a></li>
          <li><a href="products.php" <?php echo ($current_page == 'products.php') ? 'class="active"' : ''; ?>>Nos Produits</a></li>
          <li><a href="blog.php" <?php echo ($current_page == 'blog.php') ? 'class="active"' : ''; ?>>Blog</a></li>
          <li><a href="contact.php" <?php echo ($current_page == 'contact.php') ? 'class="active"' : ''; ?>>Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>