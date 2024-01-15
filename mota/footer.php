<footer>
        <?php 
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_id' => 'menu-footer', // ID attribué au menu
            ));
        ?>
        <p>TOUS DROITS RÉSERVÉS</p>

        <?php get_template_part('template-parts/modal'); ?>

</footer>

<!-- <script>
    // Attendre que le DOM soit entièrement chargé
    document.addEventListener('DOMContentLoaded', function () {
        // Variables pour suivre l'index actuel
        var currentIndex = 0;
        var totalPhotos = <?php echo $related_photos_query->post_count; ?>;

        // Fonction pour mettre à jour l'affichage en fonction de l'index actuel
        function updatePhotoDisplay() {
            // Masquer toutes les photos miniatures
            var allPhotos = document.querySelectorAll('.miniature-container');
            allPhotos.forEach(function (photo) {
                photo.style.display = 'none';
            });

            // Afficher la miniature correspondant à l'index actuel
            var currentPhoto = document.querySelector('.miniature-container-' + currentIndex);
            if (currentPhoto) {
                currentPhoto.style.display = 'block';
            }
        }

        // Gestionnaire de clic pour la flèche droite
        document.querySelector('.arrow-right').addEventListener('click', function () {
            // Incrémenter l'index et ajuster au besoin pour boucler
            currentIndex = (currentIndex + 1) % totalPhotos;
            updatePhotoDisplay();
        });

        // Gestionnaire de clic pour la flèche gauche
        document.querySelector('.arrow-left').addEventListener('click', function () {
            // Décrémenter l'index et ajuster au besoin pour boucler
            currentIndex = (currentIndex - 1 + totalPhotos) % totalPhotos;
            updatePhotoDisplay();
        });
    });
</script> -->

<?php wp_footer(); ?>  
</body>
</div>
</html>