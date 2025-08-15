<?php
$page_title = "Contact";
$page_description = "Contactez ADIMED SARL, expert en maintenance et installation de dispositifs biomédicaux et équipements de laboratoires au Bénin";
$body_class = "contact-page";
$additional_css = '<link href="assets/css/footer-responsive.css" rel="stylesheet">';

include 'includes/header.php';
?>

<main class="main">

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

<!-- Contact Methods Section -->
<section id="contact-methods" class="contact-methods section">
  <div class="container">
    <div class="section-header">
      <h2>Nos Moyens de Contact</h2>
      <p>Choisissez le moyen de communication qui vous convient le mieux</p>
    </div>

    <div class="row gy-4">
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <div class="contact-method-card">
          <div class="card-icon">
            <i class="bi bi-envelope"></i>
          </div>
          <h3>Email</h3>
          <p>Envoyez-nous un email pour toute demande d'information ou de devis.</p>
          <a href="mailto:contact@adimed.bj" class="contact-button">contact@adimed.bj</a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-method-card">
          <div class="card-icon">
            <i class="bi bi-telephone"></i>
          </div>
          <h3>Téléphone</h3>
          <p>Appelez-nous directement pour une réponse immédiate à vos questions.</p>
          <a href="tel:+22997825820" class="contact-button">+229 97 82 58 20</a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="contact-method-card">
          <div class="card-icon">
            <i class="bi bi-whatsapp"></i>
          </div>
          <h3>WhatsApp</h3>
          <p>Contactez-nous via WhatsApp pour une communication rapide et efficace.</p>
          <a href="https://wa.me/22997825820" class="contact-button">Discuter sur WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</section><!-- /Contact Methods Section -->

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