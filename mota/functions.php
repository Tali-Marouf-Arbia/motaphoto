<?php

function enqueue_my_theme_styles() {
    // Enqueue le fichier principal (style.css)
    wp_enqueue_style('my-theme-style', get_stylesheet_uri());

    // Enqueue les autres fichiers CSS
    wp_enqueue_style('page-constr-style', get_template_directory_uri() . '/css/page-constr.css');
    wp_enqueue_style('vie-privee-style', get_template_directory_uri() . '/css/vie-privee.css');
    wp_enqueue_style('modale-style', get_template_directory_uri() . '/css/modale.css');
    wp_enqueue_style('single-photo-style', get_template_directory_uri() . '/css/single-photos.css');
    wp_enqueue_style('index-style', get_template_directory_uri() . '/css/index.css');
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
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts', );

// Fonction pour ajouter le support des miniatures pour le Custom PT "Photos"
function add_thumbnail_photos() {
    add_theme_support('post-thumbnails');
    add_image_size('custom-thumbnail', 81, 71, true); //definit la taille des miniatures utilisees ds single-phots
}

// Ajout de l'action pour exécuter la fonction lors de l'initialisation d'ACF
add_action('acf/init', 'add_thumbnail_photos');

// Ajout du fichier pagination
function enqueue_pagination_js() {
    wp_enqueue_script('pagination', get_template_directory_uri() . '/js/pagination.js', array('jquery'), '', true);
    wp_localize_script('pagination', 'wp_data', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_pagination_js');

// fonction de chargement des photos via AJAX
function load_more_posts() {
    $page = $_POST['page']; // recup le num de page depuis les données POST

    $args_photos = array( // parametres de la requete pr recup les photos
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'paged' => $page,
    );

    $photos_query = new WP_Query($args_photos); // init les requetes wp_Query avc les parametres definis

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) : $photos_query->the_post(); // si il y a des posts, boucle
            // Affiche le contenu de chaque post
            ?>
            <div class="photo-bloc">
                <?php
                $accueil_post_id = get_the_ID();
                $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id, 'large');
                if (!empty($accueil_thumbnail)) {
                    echo $accueil_thumbnail;
                }
                ?>
            </div>
            <?php
        endwhile;
        wp_reset_postdata(); // reinit les donnees du post
    } else {
        // affiche la fin de galerie
        echo '<div class="mess-end-load-gallery">' .'<p>' .  'Fin de la galerie' . '</p>' . '<img id="icone-pinkCam" src="' . get_template_directory_uri() . '/assets/images/pinkCam.png">' .'</div>' ;
    }
     // Imprime le résultat de la requête AJAX (success contenu et num de page)
        echo json_encode(array('result' => 'success', 'content' => ob_get_clean(), 'page' => $page));
     die(); // termine le script php
}

// action pr gerer la resquete ajax des utilisateurs co et non-co
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
