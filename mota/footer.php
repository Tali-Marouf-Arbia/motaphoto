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

<?php wp_footer(); ?>  

</body>
</html>