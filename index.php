<?php
$page_title = "Accueil";
$page_description = "ADIMED SARL - Experts en Maintenance et Installation de dispositifs biomédicaux et équipements de laboratoires au Bénin";
$body_class = "index-page";
$additional_css = '<link href="assets/css/footer-responsive.css" rel="stylesheet">';

include 'includes/header.php';
?>

<main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">

    <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

    <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2>Bienvenue à ADIMED Sarl </h2>
          <p>Nous sommes les experts en Maintenance <br> Installation de dispositifs biomédicaux et équipements de laboratoires </p>
          <a href="about.php" class="btn-get-started">A propos de nous</a>
        </div>
      </div>
    </div>

  </section><!-- /Hero Section -->

  <!-- Featured Services Section -->
  <section id="featured-services" class="featured-services section">
    <div class="container">
      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-cart-check"></i>
            </div>
            <h4>Vente et Installation</h4>
            <p>Fourniture et installation des matériels, équipements et dispositifs médicaux pour les professionnels de Santé et de laboratoire</p>
            <a href="services.php" class="readmore">En savoir plus <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-wrench"></i>
            </div>
            <h4>Maintenance et SAV</h4>
            <p>Maintenance préventive et curative des équipements médicaux et de laboratoire. Service après-vente réactif et efficace</p>
            <a href="services.php" class="readmore">En savoir plus <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-people"></i>
            </div>
            <h4>Formation</h4>
            <p>Formation du personnel médical et technique à l'utilisation et à la maintenance de base des équipements</p>
            <a href="services.php" class="readmore">En savoir plus <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

      </div>
    </div>
  </section><!-- /Featured Services Section -->

  <!-- About Section -->
  <section id="about" class="about section">

    <div class="container">
      <div class="row gy-4 align-items-center">

        <div class="col-lg-5 position-relative about-img" data-aos="fade-right">
          <div class="call-us position-absolute">
            <h4>Contactez-nous</h4>
            <p>+229 97 82 58 20</p>
          </div>
        </div>

        <div class="col-lg-7 d-flex flex-column justify-content-center" data-aos="fade-left">
          <div class="section-header">
            <h2>À propos de nous</h2>
            <p>ADIMED SARL est une entreprise spécialisée dans la vente, l'installation et la maintenance d'équipements médicaux et de laboratoire au Bénin.</p>
          </div>

          <div class="row gy-4 icon-boxes">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box">
                <i class="bi bi-building"></i>
                <h3>Notre entreprise</h3>
                <p>Fondée en 2018, ADIMED SARL s'est rapidement imposée comme un acteur incontournable dans le secteur médical au Bénin.</p>
              </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-gem"></i>
                <h3>Notre mission</h3>
                <p>Fournir des équipements médicaux de qualité et assurer un service après-vente irréprochable pour améliorer les soins de santé au Bénin.</p>
              </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-geo-alt"></i>
                <h3>Notre couverture</h3>
                <p>Nous intervenons sur l'ensemble du territoire béninois et dans la sous-région ouest-africaine.</p>
              </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="icon-box">
                <i class="bi bi-command"></i>
                <h3>Notre expertise</h3>
                <p>Notre équipe est composée de techniciens qualifiés et expérimentés dans le domaine biomédical.</p>
              </div>
            </div>
          </div>

          <a href="about.php" class="read-more align-self-start">En savoir plus <i class="bi bi-arrow-right"></i></a>
        </div>

      </div>
    </div>

  </section><!-- /About Section -->

  <!-- Services Section -->
  <section id="services" class="services section">

    <div class="container">

      <div class="section-header">
        <h2>Nos Services</h2>
        <p>ADIMED SARL propose une gamme complète de services pour répondre aux besoins des professionnels de santé et des laboratoires.</p>
      </div>

      <div class="row gy-4">

        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item d-flex">
            <div class="icon flex-shrink-0"><i class="bi bi-cart-check"></i></div>
            <div>
              <h4 class="title">Vente et Installation</h4>
              <p class="description">Fourniture et installation des matériels, équipements et dispositifs médicaux pour les professionnels de Santé et de laboratoire</p>
              <a href="services.php" class="readmore"><span>En savoir plus</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-item d-flex">
            <div class="icon flex-shrink-0"><i class="bi bi-wrench"></i></div>
            <div>
              <h4 class="title">Maintenance et SAV</h4>
              <p class="description">Maintenance préventive et curative des équipements médicaux et de laboratoire. Service après-vente réactif et efficace</p>
              <a href="services.php" class="readmore"><span>En savoir plus</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-item d-flex">
            <div class="icon flex-shrink-0"><i class="bi bi-people"></i></div>
            <div>
              <h4 class="title">Formation</h4>
              <p class="description">Formation du personnel médical et technique à l'utilisation et à la maintenance de base des équipements</p>
              <a href="services.php" class="readmore"><span>En savoir plus</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="service-item d-flex">
            <div class="icon flex-shrink-0"><i class="bi bi-person-workspace"></i></div>
            <div>
              <h4 class="title">Consultant</h4>
              <p class="description">Conseil et accompagnement pour l'acquisition d'équipements médicaux adaptés à vos besoins et à votre budget</p>
              <a href="services.php" class="readmore"><span>En savoir plus</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>

      </div>

    </div>

  </section><!-- /Services Section -->

  <!-- Team Section -->
  <section id="team" class="team section">

    <div class="container">

      <div class="section-header">
        <h2>Notre Équipe</h2>
        <p>Notre équipe est composée de professionnels qualifiés et passionnés par leur métier.</p>
      </div>

      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="team-member">
            <div class="member-img">
              <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
              <div class="social">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Nom Prénom</h4>
              <span>Directeur Général</span>
              <p>Expert en équipements médicaux avec plus de 15 ans d'expérience dans le secteur</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="team-member">
            <div class="member-img">
              <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
              <div class="social">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Nom Prénom</h4>
              <span>Responsable Technique</span>
              <p>Ingénieur biomédical spécialisé dans la maintenance des équipements de laboratoire</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="team-member">
            <div class="member-img">
              <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
              <div class="social">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Nom Prénom</h4>
              <span>Responsable Commercial</span>
              <p>Expert en vente d'équipements médicaux avec une connaissance approfondie du marché africain</p>
            </div>
          </div>
        </div>

      </div>

      <div class="text-center mt-4">
        <a href="team.php" class="read-more">Voir toute l'équipe <i class="bi bi-arrow-right"></i></a>
      </div>

    </div>

  </section><!-- /Team Section -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <div class="container">

      <div class="section-header">
        <h2>Contact</h2>
        <p>Contactez-nous pour toute demande d'information ou de devis. Notre équipe se fera un plaisir de vous répondre dans les plus brefs délais.</p>
      </div>

    </div>

    <div class="map">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.0477893793!2d2.3568540147711184!3d6.3867319953969!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023553e2f8f94a5%3A0x5e2e7b2b5b7b5b7b!2sAdimed%20Sarl!5e0!3m2!1sfr!2sbj!4v1620000000000!5m2!1sfr!2sbj" style="border:0; width: 100%; height: 350px;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <div class="container">

      <div class="row gy-5 gx-lg-5">

        <div class="col-lg-4">

          <div class="info">
            <h3>Nos coordonnées</h3>
            <div class="info-item d-flex">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h4>Adresse:</h4>
                <p>Rue 12.017, Maison ADJINACOU, Quartier Agla, Cotonou, Bénin</p>
              </div>
            </div>

            <div class="info-item d-flex">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h4>Email:</h4>
                <p>contact@adimed.bj</p>
              </div>
            </div>

            <div class="info-item d-flex">
              <i class="bi bi-phone flex-shrink-0"></i>
              <div>
                <h4>Téléphone:</h4>
                <p>+229 97 82 58 20 / 95 56 23 29</p>
              </div>
            </div>

            <div class="info-item d-flex">
              <i class="bi bi-clock flex-shrink-0"></i>
              <div>
                <h4>Heures d'ouverture:</h4>
                <p>Lundi - Vendredi: 8h00 - 18h00</p>
              </div>
            </div>
          </div>

        </div>

        <div class="col-lg-8">
          <form id="contact-form" class="php-email-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom" required="">
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required="">
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required="">
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="6" placeholder="Entrez votre message" required=""></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Votre message a été envoyé . Merci!</div>

              <button type="submit">Envoyer</button>
            </div>

          </div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>

</section><!-- /Contact Section -->

</main>

<?php
$additional_js = <<<EOT
<script>
  document.getElementById('contact-form').addEventListener('submit', function(e){
    e.preventDefault();
    
    // Afficher l'indicateur de chargement
    this.querySelector('.loading').style.display = 'block';
    this.querySelector('.error-message').style.display = 'none';
    this.querySelector('.sent-message').style.display = 'none';
    
    emailjs.sendForm('service_4juexye', 'template_tec11ki', this)
      .then(function() {
        // Masquer l'indicateur de chargement et afficher le message de succès
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('.sent-message').style.display = 'block';
        document.getElementById('contact-form').reset();
      }, function(error) {
        // Masquer l'indicateur de chargement et afficher le message d'erreur
        document.querySelector('.loading').style.display = 'none';
        document.querySelector('.error-message').innerHTML = 'Erreur lors de l\'envoi du message: ' + error.text;
        document.querySelector('.error-message').style.display = 'block';
      });
  });
</script>
EOT;

include 'includes/footer.php';
?>