<?php

function enqueue_my_theme_styles() {
        wp_enqueue_style('my-theme-style', get_stylesheet_uri());
    }

add_action('wp_enqueue_scripts', 'enqueue_my_theme_styles');


// Fonction pour enregistrer mes menus
function register_my_menus() {
    register_nav_menus(
        array(
            'header' => __('Menu du header'),  // Enregistre un emplacement de menu pour le header avec le libelle "Menu du header"
            'footer' => __('Menu du footer')   // Enregistre un emplacement avc le libelle "Menu du footer"
        )
    );
}

// Action pour exécuter la fonction après la configuration du thème
add_action('after_setup_theme', 'register_my_menus');

// Enqueue mes fichier js 
function enqueue_custom_scripts() {
    // Charge le script 'menu.js'
    wp_enqueue_script('menu-script', get_template_directory_uri() . '/js/menu.js', array(), '1.0', true);

    // Charge le script 'modal.js'
    wp_enqueue_script('modal-script', get_template_directory_uri() . '/js/modal.js', array(), '1.0', true);
    
    // Charge le script 'arrows.js'
    // wp_enqueue_script('arrows-script', get_template_directory_uri() . '/js/arrows.js', array(), '1.0', true );
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts', );


// Fonction pour ajouter le support des miniatures pour le Custom PT "Photos"
function add_thumbnail_photos() {
    add_theme_support('post-thumbnails');
    add_image_size('custom-thumbnail', 81, 71, true); //definit la taille des miniatures utilisees ds single-phots
    // add_image_size('custom-medium-thumbnail', 564, 495, true); // definit la taille des images apparentees 
}
// Ajout de l'action pour exécuter la fonction lors de l'initialisation d'ACF
add_action('acf/init', 'add_thumbnail_photos');



