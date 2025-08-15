<?php
// Inclusion des fichiers d'en-tête et de pied de page
include 'includes/header.php';

// Dans une implémentation réelle, nous récupérerions l'article depuis la base de données
// en utilisant l'ID passé dans l'URL ($_GET['id'])
// Pour l'exemple, nous utilisons des données statiques
$article_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Données d'exemple pour les articles
$articles = [
    1 => [
        'title' => 'Installation d\'équipements médicaux à l\'hôpital central',
        'date' => '15 Juin 2023',
        'author' => 'Admin',
        'category' => 'Équipements médicaux',
        'image' => 'assets/img/blog/blog-1.jpg',
        'content' => '<p>Notre équipe a récemment complété l\'installation de nouveaux équipements d\'imagerie médicale à l\'hôpital central, améliorant considérablement les capacités diagnostiques de l\'établissement.</p>

<p>Le projet, qui a duré trois semaines, comprenait l\'installation d\'un scanner CT de dernière génération, d\'un système d\'IRM avancé et de plusieurs appareils d\'échographie. Ces équipements représentent une avancée significative pour les soins de santé dans la région, permettant des diagnostics plus précis et plus rapides.</p>

<h3>Défis et solutions</h3>

<p>L\'installation de ces équipements sophistiqués a présenté plusieurs défis techniques, notamment en termes d\'espace et d\'alimentation électrique. Notre équipe d\'ingénieurs a travaillé en étroite collaboration avec le personnel de l\'hôpital pour concevoir une disposition optimale qui maximise l\'efficacité tout en assurant la sécurité des patients et du personnel.</p>

<p>Une attention particulière a été portée à la calibration des appareils pour garantir des résultats précis dès le premier jour d\'utilisation. Nos techniciens ont également formé le personnel médical sur l\'utilisation correcte des nouveaux équipements.</p>

<img src="assets/img/blog/blog-inside-1.jpg" class="img-fluid" alt="Installation d\'équipements">

<h3>Impact sur les soins aux patients</h3>

<p>Avec ces nouveaux équipements, l\'hôpital central peut désormais offrir des services de diagnostic avancés qui n\'étaient pas disponibles auparavant dans la région. Les patients n\'auront plus à se déplacer vers d\'autres établissements pour certains examens spécialisés.</p>

<p>Le Dr. Martin, chef du département de radiologie, a déclaré : "Ces nouveaux équipements transforment notre capacité à diagnostiquer et traiter une variété de conditions médicales. Nous sommes extrêmement reconnaissants envers ADIMED SARL pour leur expertise et leur professionnalisme tout au long de ce projet."</p>

<h3>Maintenance et support continu</h3>

<p>ADIMED SARL continuera à fournir un support technique et des services de maintenance réguliers pour assurer le fonctionnement optimal des équipements. Notre équipe de techniciens sera disponible 24/7 pour répondre à toute urgence technique.</p>

<p>Nous sommes fiers de contribuer à l\'amélioration des soins de santé dans notre communauté et nous nous engageons à maintenir les plus hauts standards de qualité dans tous nos projets d\'installation et de maintenance d\'équipements médicaux.</p>'
    ],
    2 => [
        'title' => 'Formation sur les nouveaux équipements de laboratoire',
        'date' => '28 Mai 2023',
        'author' => 'Technicien',
        'category' => 'Formations',
        'image' => 'assets/img/blog/blog-2.jpg',
        'content' => '<p>ADIMED SARL a organisé une session de formation intensive pour le personnel médical sur l\'utilisation des nouveaux équipements de laboratoire récemment installés dans plusieurs cliniques de la région.</p>

<p>La formation, qui s\'est déroulée sur trois jours, a couvert tous les aspects de l\'utilisation et de la maintenance de base des équipements, permettant au personnel de maximiser l\'efficacité et la précision des tests de laboratoire.</p>

<h3>Programme de formation complet</h3>

<p>Notre programme de formation a été conçu pour répondre aux besoins spécifiques du personnel médical, en mettant l\'accent sur les applications pratiques et les scénarios réels. Les participants ont eu l\'occasion de manipuler les équipements sous la supervision de nos experts techniques.</p>

<p>Les sujets abordés comprenaient :</p>
<ul>
    <li>Principes de fonctionnement des analyseurs automatiques</li>
    <li>Procédures de calibration et de contrôle qualité</li>
    <li>Dépannage de base et maintenance préventive</li>
    <li>Interprétation des résultats et gestion des erreurs</li>
    <li>Mesures de sécurité et précautions</li>
</ul>

<img src="assets/img/blog/blog-inside-2.jpg" class="img-fluid" alt="Session de formation">

<h3>Retour des participants</h3>

<p>Les retours des participants ont été extrêmement positifs, soulignant la clarté des explications et l\'approche pratique de la formation. Dr. Kamara, directrice de laboratoire, a commenté : "La formation fournie par ADIMED SARL était exactement ce dont notre équipe avait besoin. Nous nous sentons maintenant confiants dans l\'utilisation de ces équipements sophistiqués."</p>

<blockquote>
    <p>La qualité de la formation et le professionnalisme des formateurs d\'ADIMED SARL ont dépassé nos attentes. Notre équipe est maintenant bien préparée pour utiliser efficacement les nouveaux équipements.</p>
    <footer>- Dr. Sow, Responsable du département de pathologie</footer>
</blockquote>

<h3>Suivi et support continu</h3>

<p>Notre engagement envers nos clients ne s\'arrête pas à la fin de la formation. ADIMED SARL offre un support technique continu et des sessions de formation de rappel pour assurer que le personnel reste à jour avec les meilleures pratiques d\'utilisation des équipements.</p>

<p>Nous prévoyons d\'organiser des webinaires mensuels pour discuter des avancées technologiques et répondre aux questions qui pourraient surgir lors de l\'utilisation quotidienne des équipements.</p>'
    ],
    3 => [
        'title' => 'Maintenance préventive des équipements de radiologie',
        'date' => '10 Mai 2023',
        'author' => 'Ingénieur',
        'category' => 'Maintenance',
        'image' => 'assets/img/blog/blog-3.jpg',
        'content' => '<p>L\'importance de la maintenance préventive des équipements de radiologie ne peut être sous-estimée. Notre équipe technique explique les meilleures pratiques pour prolonger la durée de vie de vos équipements et assurer des performances optimales.</p>

<p>Les équipements de radiologie représentent un investissement significatif pour tout établissement de santé. Une maintenance régulière et préventive est essentielle non seulement pour protéger cet investissement, mais aussi pour garantir la sécurité des patients et la qualité des diagnostics.</p>

<h3>Pourquoi la maintenance préventive est cruciale</h3>

<p>La maintenance préventive permet de détecter et de résoudre les problèmes potentiels avant qu\'ils ne deviennent critiques, réduisant ainsi les temps d\'arrêt coûteux et les réparations d\'urgence. Elle contribue également à :</p>

<ul>
    <li>Prolonger la durée de vie des équipements</li>
    <li>Maintenir la qualité d\'image optimale</li>
    <li>Assurer la sécurité des patients et du personnel</li>
    <li>Réduire les coûts opérationnels à long terme</li>
    <li>Respecter les exigences réglementaires</li>
</ul>

<img src="assets/img/blog/blog-inside-3.jpg" class="img-fluid" alt="Maintenance d\'équipement de radiologie">

<h3>Programme de maintenance recommandé</h3>

<p>Chez ADIMED SARL, nous recommandons un programme de maintenance complet qui comprend :</p>

<h4>Inspections quotidiennes</h4>
<p>Ces vérifications rapides, effectuées par les opérateurs, incluent l\'examen visuel des câbles, des connecteurs et des composants mécaniques, ainsi que des tests de fonctionnement de base.</p>

<h4>Maintenance mensuelle</h4>
<p>Réalisée par des techniciens formés, elle comprend le nettoyage approfondi des composants, la vérification des paramètres de calibration et l\'ajustement des pièces mobiles.</p>

<h4>Maintenance trimestrielle</h4>
<p>Cette maintenance plus approfondie inclut des tests de performance, la vérification des systèmes de sécurité et l\'inspection détaillée des composants électroniques.</p>

<h4>Maintenance annuelle</h4>
<p>Effectuée par nos ingénieurs spécialisés, elle comprend une révision complète de l\'équipement, le remplacement des pièces usées et la mise à jour des logiciels si nécessaire.</p>

<h3>Notre service de maintenance</h3>

<p>ADIMED SARL offre des contrats de maintenance personnalisés pour répondre aux besoins spécifiques de chaque établissement. Nos techniciens certifiés utilisent des outils de diagnostic avancés pour assurer que vos équipements fonctionnent selon les spécifications du fabricant.</p>

<p>Nous proposons également des formations pour votre personnel technique sur les procédures de maintenance de base, leur permettant de contribuer efficacement à la longévité et à la performance de vos équipements.</p>'
    ],
    4 => [
        'title' => 'Nouveaux produits médicaux disponibles chez ADIMED',
        'date' => '2 Mai 2023',
        'author' => 'Commercial',
        'category' => 'Nouveaux produits',
        'image' => 'assets/img/blog/blog-4.jpg',
        'content' => '<p>Découvrez notre nouvelle gamme de produits médicaux de haute qualité, conçus pour améliorer les soins aux patients et faciliter le travail des professionnels de santé.</p>

<p>Chez ADIMED SARL, nous nous engageons à fournir les équipements et produits médicaux les plus innovants et fiables du marché. Notre dernière sélection de produits reflète notre dévouement à l\'excellence et à l\'amélioration continue des soins de santé.</p>

<h3>Moniteurs de signes vitaux nouvelle génération</h3>

<p>Notre nouvelle ligne de moniteurs de signes vitaux combine technologie avancée et facilité d\'utilisation. Ces appareils offrent :</p>

<ul>
    <li>Écrans tactiles haute résolution</li>
    <li>Connectivité sans fil pour l\'intégration aux systèmes d\'information hospitaliers</li>
    <li>Batterie longue durée pour une mobilité accrue</li>
    <li>Algorithmes avancés pour une détection précoce des changements critiques</li>
    <li>Interface intuitive réduisant le temps de formation</li>
</ul>

<img src="assets/img/blog/blog-inside-4.jpg" class="img-fluid" alt="Nouveaux moniteurs de signes vitaux">

<h3>Équipements de diagnostic portatifs</h3>

<p>Notre gamme d\'équipements de diagnostic portatifs permet aux professionnels de santé d\'effectuer des examens précis où qu\'ils soient. Ces appareils compacts mais puissants incluent :</p>

<ul>
    <li>Échographes portatifs avec qualité d\'image comparable aux systèmes fixes</li>
    <li>Électrocardiographes numériques avec interprétation assistée</li>
    <li>Spiromètres avec analyse en temps réel et comparaison aux valeurs prédites</li>
    <li>Analyseurs de sang portables pour résultats rapides au point d\'intervention</li>
</ul>

<h3>Solutions de télémédecine intégrées</h3>

<p>Répondant à la demande croissante de services de santé à distance, nos solutions de télémédecine offrent :</p>

<ul>
    <li>Plateformes de consultation vidéo sécurisées et conformes aux réglementations</li>
    <li>Dispositifs de surveillance à distance pour patients chroniques</li>
    <li>Systèmes d\'archivage et de partage d\'images médicales</li>
    <li>Applications mobiles pour la gestion des rendez-vous et le suivi des patients</li>
</ul>

<h3>Équipements de stérilisation avancés</h3>

<p>La prévention des infections étant plus importante que jamais, nos nouveaux équipements de stérilisation offrent :</p>

<ul>
    <li>Cycles de stérilisation rapides et efficaces</li>
    <li>Systèmes de traçabilité intégrés</li>
    <li>Consommation d\'eau et d\'énergie réduite</li>
    <li>Conformité aux normes internationales les plus strictes</li>
</ul>

<p>Tous nos produits sont accompagnés de garanties complètes et de services de support technique. Nos spécialistes sont disponibles pour des démonstrations et des consultations personnalisées afin de vous aider à choisir les équipements les mieux adaptés à vos besoins.</p>

<p>Contactez notre équipe commerciale dès aujourd\'hui pour en savoir plus sur ces nouveaux produits et découvrir comment ils peuvent améliorer votre pratique médicale.</p>'
    ]
];

// Récupération de l'article demandé ou redirection si non trouvé
$article = isset($articles[$article_id]) ? $articles[$article_id] : null;

if (!$article) {
    // Redirection vers la page du blog si l'article n'existe pas
    header('Location: blog.php');
    exit;
}
?>

<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Blog</h2>
                <ol>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><?php echo htmlspecialchars($article['title']); ?></li>
                </ol>
            </div>
        </div>
    </section>

    <section class="blog-section">
        <div class="container blog-container">
            <div class="row">
                <!-- Blog Single Content -->
                <div class="col-lg-8">
                    <div class="blog-single">
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($article['title']); ?>">
                        
                        <h2 class="blog-single-title mt-4"><?php echo htmlspecialchars($article['title']); ?></h2>
                        
                        <div class="blog-single-meta">
                            <span><i class="bx bx-calendar"></i> <?php echo htmlspecialchars($article['date']); ?></span>
                            <span><i class="bx bx-user"></i> <?php echo htmlspecialchars($article['author']); ?></span>
                            <span><i class="bx bx-folder"></i> <?php echo htmlspecialchars($article['category']); ?></span>
                        </div>
                        
                        <div class="blog-single-content">
                            <?php echo $article['content']; // Note: contenu HTML déjà échappé dans les données d'exemple ?>
                        </div>
                        
                        <!-- Tags -->
                        <div class="blog-tags mt-4">
                            <i class="bx bx-tag"></i>
                            <a href="#">Médical</a>
                            <a href="#"><?php echo htmlspecialchars($article['category']); ?></a>
                            <a href="#">ADIMED</a>
                        </div>
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
                            
                            <?php foreach (array_slice($articles, 0, 4, true) as $id => $recent_article): ?>
                            <!-- Recent Post -->
                            <div class="blog-recent-post">
                                <img src="<?php echo htmlspecialchars($recent_article['image']); ?>" alt="" class="blog-recent-post-img">
                                <div class="blog-recent-post-info">
                                    <h6><a href="blog-single.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars(substr($recent_article['title'], 0, 30) . (strlen($recent_article['title']) > 30 ? '...' : '')); ?></a></h6>
                                    <span><i class="bx bx-calendar"></i> <?php echo htmlspecialchars($recent_article['date']); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
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