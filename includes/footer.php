<!-- WhatsApp Button -->
  <a href="https://wa.me/22997825820" class="whatsapp-button">
    <i class="bi bi-whatsapp"></i>
    <span>Discuter</span>
  </a>

  </main><!-- End #main -->

  <!-- Footer -->
  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-3 col-md-6">
          <div class="footer-info">
            <h3 class="sitename">ADIMED SARL</h3>
            <p>
              Rue 12.017, Maison ADJINACOU <br>
              Quartier Agla, Cotonou<br><br>
              <strong>Téléphone:</strong> +229 97 82 58 20 / 95 56 23 29<br>
              <strong>Email:</strong> contact@adimed.bj<br>
            </p>
            <p class="mt-3">Importations et Ventes de matériels médicaux - BTP - Prestations de sevices - Energies renouvelables</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Liens Utiles</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="index.php">Accueil</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="about.php">A propos</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="services.php">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="products.php">Nos produits</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="blog.php">Blog</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Nos Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="services.php">Vente et Installation</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="services.php">Consultant</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="services.php">Formation</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="services.php">Maintenance et SAV</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Nos Réseaux Sociaux</h4>
          <p>Suivez-nous pour rester informé de nos dernières actualités et offres</p>
          <div class="social-links d-flex mt-3">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            <a href="https://wa.me/22997825820" class="whatsapp"><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt-4">
      <div class="copyright">
        <span>Copyright</span> <strong class="px-1 sitename">Adimed Sarl</strong> <span>Tous droits reservés</span>
      </div>
      <div class="credits">
        Designed by <a href="">Nice Arts</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Script emailjs -->
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script>
    (function(){ 
      emailjs.init("vrcuqcjQqZjeg_jsh");
    })();
  </script>
  
  <?php if(isset($additional_js)): ?>
  <?php echo $additional_js; ?>
  <?php endif; ?>

</body>

</html>