</div>
    </main>
    
    <!-- ======= Footer ======= -->
    <footer id="footer" class="admin-footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>ADIMED SARL</span></strong>. Tous droits réservés
            </div>
            <div class="credits">
                Interface d'administration
            </div>
        </div>
    </footer>
    
    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
    
    <!-- Custom Admin JS -->
    <script>
        // Confirmation de suppression
        function confirmDelete(message) {
            return confirm(message || 'Êtes-vous sûr de vouloir supprimer cet élément ?');
        }
        
        // Prévisualisation d'image
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>