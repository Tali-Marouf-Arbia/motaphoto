<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title() ?></title>
    <!-- inclusion jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <?php wp_head(); ?>
</head>


<body>
  <div class="bigContainer">

    <header id="header">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png" class="logo" alt="logo" />
            <?php 
                wp_nav_menu(array(
                    'theme_location' => 'header',
                    'menu_id' => 'menu-header', 
                ));
            ?>
            <div class="burger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <!-- <img src="<//?php// echo get_template_directory_uri() ?>/assets/images/menu-btn.png" alt="bouton d'ouverture du menu" id="menu-btn" class="mobile" />
            <img src="<?php //echo get_template_directory_uri() ?>/assets/images/croix.png" alt="bouton de fermeture du menu" id="menu-btn-2" class="mobile inactive-mobile" /> -->
        
        </header>
        <!--Menu mobile-->
        <div class="menu-open inactive-mobile fade-in" id="mega-menu">
            <?php 
            wp_nav_menu(array(
                'theme_location' => 'header',
                'menu_id' => 'mega-menu', // ID attribué au menu mobile
            ));
            ?>
        </div>




