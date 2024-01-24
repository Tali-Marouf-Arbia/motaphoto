<footer>
        <?php 
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_id' => 'menu-footer', // ID attribué au menu
            ));
        ?>
        <p>TOUS DROITS RÉSERVÉS</p>

        <?php get_template_part('template-parts/modal'); ?>
        <?php get_template_part('template-parts/lightbox');?>

</footer>
<?php wp_footer(); ?>  
  </div>
</body>
</html>