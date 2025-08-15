<?php
// Inclusion des fichiers d'en-tête et de pied de page
include 'includes/header.php';
?>

<main id="main">
    <!-- ======= Blog Section ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Blog</h2>
                <ol>
                    <li><a href="index.php">Accueil</a></li>
                    <li>Blog</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="blog-section">
        <div class="container blog-container">
            <div class="row">
                <!-- Blog Posts Column -->
                <div class="col-lg-8">
                    <div class="row">
                        <!-- Blog Post 1 (Exemple) -->
                        <div class="col-md-6 mb-4">
                            <div class="blog-post">
                                <img src="assets/img/blog/blog-1.jpg" class="blog-post-img" alt="Blog Image">
                                <div class="blog-post-content">
                                    <h3 class="blog-post-title">Installation d'équipements médicaux à l'hôpital central</h3>
                                    <div class="blog-post-meta">
                                        <span><i class="bx bx-calendar"></i> 15 Juin 2023</span>
                                        <span><i class="bx bx-user"></i> Admin</span>
                                    </div>
                                    <p class="blog-post-excerpt">Notre équipe a récemment complété l'installation de nouveaux équipements d'imagerie médicale à l'hôpital central, améliorant considérablement les capacités diagnostiques...</p>
                                    <a href="blog-single.php?id=1" class="blog-post-link">Lire plus</a>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post 2 (Exemple) -->
                        <div class="col-md-6 mb-4">
                            <div class="blog-post">
                                <img src="assets/img/blog/blog-2.jpg" class="blog-post-img" alt="Blog Image">
                                <div class="blog-post-content">
                                    <h3 class="blog-post-title">Formation sur les nouveaux équipements de laboratoire</h3>
                                    <div class="blog-post-meta">
                                        <span><i class="bx bx-calendar"></i> 28 Mai 2023</span>
                                        <span><i class="bx bx-user"></i> Technicien</span>
                                    </div>
                                    <p class="blog-post-excerpt">ADIMED SARL a organisé une session de formation intensive pour le personnel médical sur l'utilisation des nouveaux équipements de laboratoire récemment installés...</p>
                                    <a href="blog-single.php?id=2" class="blog-post-link">Lire plus</a>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post 3 (Exemple) -->
                        <div class="col-md-6 mb-4">
                            <div class="blog-post">
                                <img src="assets/img/blog/blog-3.jpg" class="blog-post-img" alt="Blog Image">
                                <div class="blog-post-content">
                                    <h3 class="blog-post-title">Maintenance préventive des équipements de radiologie</h3>
                                    <div class="blog-post-meta">
                                        <span><i class="bx bx-calendar"></i> 10 Mai 2023</span>
                                        <span><i class="bx bx-user"></i> Ingénieur</span>
                                    </div>
                                    <p class="blog-post-excerpt">L'importance de la maintenance préventive des équipements de radiologie ne peut être sous-estimée. Notre équipe technique explique les meilleures pratiques...</p>
                                    <a href="blog-single.php?id=3" class="blog-post-link">Lire plus</a>
                                </div>
                            </div>
                        </div>

                        <!-- Blog Post 4 (Exemple) -->
                        <div class="col-md-6 mb-4">
                            <div class="blog-post">
                                <img src="assets/img/blog/blog-4.jpg" class="blog-post-img" alt="Blog Image">
                                <div class="blog-post-content">
                                    <h3 class="blog-post-title">Nouveaux produits médicaux disponibles chez ADIMED</h3>
                                    <div class="blog-post-meta">
                                        <span><i class="bx bx-calendar"></i> 2 Mai 2023</span>
                                        <span><i class="bx bx-user"></i> Commercial</span>
                                    </div>
                                    <p class="blog-post-excerpt">Découvrez notre nouvelle gamme de produits médicaux de haute qualité, conçus pour améliorer les soins aux patients et faciliter le travail des professionnels de santé...</p>
                                    <a href="blog-single.php?id=4" class="blog-post-link">Lire plus</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="blog-pagination">
                        <ul class="pagination">
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="bx bx-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <!-- Search Widget -->
                        <div class="sidebar-item search-form mb-4">
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Rechercher...">
                                    <div class="input-group-append">
                                        <button class="btn" type="button" style="background-color: #0ea2bd; color: white;">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                        <div class="blog-categories mb-4">
                            <h3 class="blog-sidebar-title">Catégories</h3>
                            <ul>
                                <li><a href="#">Équipements médicaux <span>(12)</span></a></li>
                                <li><a href="#">Formations <span>(8)</span></a></li>
                                <li><a href="#">Maintenance <span>(5)</span></a></li>
                                <li><a href="#">Nouveaux produits <span>(7)</span></a></li>
                                <li><a href="#">Événements <span>(3)</span></a></li>
                            </ul>
                        </div>

                        <!-- Recent Posts Widget -->
                        <div class="blog-recent-posts">
                            <h3 class="blog-sidebar-title">Articles récents</h3>
                            
                            <!-- Recent Post 1 -->
                            <div class="blog-recent-post">
                                <img src="assets/img/blog/blog-1.jpg" alt="" class="blog-recent-post-img">
                                <div class="blog-recent-post-info">
                                    <h6><a href="blog-single.php?id=1">Installation d'équipements médicaux</a></h6>
                                    <span><i class="bx bx-calendar"></i> 15 Juin 2023</span>
                                </div>
                            </div>

                            <!-- Recent Post 2 -->
                            <div class="blog-recent-post">
                                <img src="assets/img/blog/blog-2.jpg" alt="" class="blog-recent-post-img">
                                <div class="blog-recent-post-info">
                                    <h6><a href="blog-single.php?id=2">Formation sur les équipements</a></h6>
                                    <span><i class="bx bx-calendar"></i> 28 Mai 2023</span>
                                </div>
                            </div>

                            <!-- Recent Post 3 -->
                            <div class="blog-recent-post">
                                <img src="assets/img/blog/blog-3.jpg" alt="" class="blog-recent-post-img">
                                <div class="blog-recent-post-info">
                                    <h6><a href="blog-single.php?id=3">Maintenance préventive</a></h6>
                                    <span><i class="bx bx-calendar"></i> 10 Mai 2023</span>
                                </div>
                            </div>

                            <!-- Recent Post 4 -->
                            <div class="blog-recent-post">
                                <img src="assets/img/blog/blog-4.jpg" alt="" class="blog-recent-post-img">
                                <div class="blog-recent-post-info">
                                    <h6><a href="blog-single.php?id=4">Nouveaux produits médicaux</a></h6>
                                    <span><i class="bx bx-calendar"></i> 2 Mai 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Inclusion du pied de page
include 'includes/footer.php';
?>