<footer>
        <?php 
            wp_nav_menu(array(
                'theme_location' => 'footer',
                'menu_id' => 'menu-footer', // ID attribué au menu
            ));
        ?>
        <p>TOUS DROITS RÉSERVÉS</p>
    </footer>
    <?php wp_footer(); ?>  
</body>
</html>