<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mota Photo</title>
    <?php wp_head(); ?>
</head>
<body>

    <header id="header">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/logo.png" class="logo" alt="logo" />
            <?php 
                wp_nav_menu(array(
                    'theme_location' => 'header',
                    'menu_id' => 'menu-header', 
                ));
            ?>
    </header>