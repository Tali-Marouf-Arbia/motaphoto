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
    wp_enqueue_style('lightbox-style', get_template_directory_uri() . '/css/lightbox.css');
    wp_enqueue_style('hoverCard-style', get_template_directory_uri() . '/css/hover-card.css');
 
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

// enqueue filtre.js
function enqueue_filtres() {
    wp_enqueue_script('filtres-script', get_template_directory_uri() . '/js/filtres.js', array('jquery'), '1.0', true);
    
    // Transmettez la variable ajax_url au script
    wp_localize_script('filtres-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_filtres');


// fonction de chargement des photos via AJAX
function load_more_posts() {
    $page = $_POST['page'];
    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Catégorie sélectionnée
    $format = isset($_POST['format']) ? $_POST['format'] : ''; // Format sélectionné
    $order = isset($_POST['order']) ? $_POST['order'] : ''; // Ordre sélectionné

    // Construction des arguments pour la requête WP_Query en fonction des filtres
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'paged' => $page,
        'order' => $order,
    );

    // Ajouter des conditions pour les filtres de catégorie et de format
    if (!empty($category) && $category !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format) && $format !== 'all') {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    // Exécuter la requête WP_Query avec les arguments construits
    $photos_query = new WP_Query($args);

    ob_start(); // Démarre la mise en mémoire tampon

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) : $photos_query->the_post(); // si il y a des posts, boucle
            // Affiche le contenu de chaque post
            ?>
            <div class="photo-bloc">
                <?php
                $accueil_post_id = get_the_ID();
                $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id, 'large');
                if (!empty($accueil_thumbnail)) {
                    echo '<div class="iconeFullscreen-container">'
                        . '<img id="iconeFullscreen" class="iconeFullscreen" src="' . get_template_directory_uri() . '/assets/images/iconFullscreen.png" alt="bouton d\'ouverture de la lightbox" />'
                    . '</div>'
                    . '<a class="permaLink" href="' . get_permalink() . '">' 
                    . $accueil_thumbnail 
                    . '<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone"/>'
                    . '<div class="infos-hover">'
                        . '<div class="ref-container">'
                            . get_field('reference')
                        . '</div>'
                        . '<div class="cat-container">'
                            . strip_tags(get_the_term_list(get_the_ID(), 'category'))
                        . '</div>'
                    . '</div>'
                . '</a>';
                    
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
    
    // Récupère le contenu du tampon de sortie et le nettoie, puis l'assigne à la variable $content
    $content = ob_get_clean();
    
    // Imprime le résultat de la requête AJAX (success contenu et num de page)
    echo json_encode(array('result' => 'success', 'content' => $content, 'page' => $page));
    die(); // termine le script php
}

// action pr gerer la resquete ajax des utilisateurs co et non-co
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


// FILTRES

function filter_photos() {
    // Récupération des données POST
    $page = $_POST['page'];
    $categorie = $_POST['category'];
    $format = $_POST['format'];
    $order = $_POST['order'];
    $format_sortie = $_POST['format_sortie'];

    // On vérifie si le contenu doit être filtré
    if ($categorie == 'all' && $format == 'all') {
        // Si on veut tout sans filtre
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 12,
            'paged' => $page,
            'order' => $order,
        );
    } else if ($categorie == 'all') {
        // Si on veut seulement toutes les catégories, on filtre uniquement sur le format
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 12,
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => $format,
                ),
            ),
            'order' => $order,
        );
    } else if ($format == 'all') {
        // Si on veut seulement tous les formats, on filtre uniquement sur les catégories
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 12,
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $categorie,
                ),
            ),
            'order' => $order,
        );
    } else {
        // Sinon, c'est que l'on filtre à la fois les formats et les catégories
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 12,
            'paged' => $page,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => $format,
                ),
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $categorie,
                ),
            ),
            'order' => $order,
        );
    }

    // Création de la requête WP_Query avec les arguments définis
    $query = new WP_Query($args);
    $tableau = array();
    // Si la requête retourne des résultats
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $accueil_post_id = get_the_ID();
            $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id, 'large');

            // Vérification de la non-nullité de $query (c'est probablement une erreur, car $query est une requête et non un tableau)
            if (!empty($query)) {
                $tableau[] = ['thumbnail' => $accueil_thumbnail, 'category' => strip_tags(get_the_term_list(get_the_ID(), 'category')), 'reference' => get_field('reference')];
                if($format_sortie != 'Json'){
                // Affichage du bloc de photo avec des détails
                echo '<div class="photo-bloc">'
                    . '<div class="iconeFullscreen-container">'
                    . '<img id="iconeFullscreen" class="iconeFullscreen" src="' . get_template_directory_uri() . '/assets/images/iconFullscreen.png" alt="bouton d\'ouverture de la lightbox" />'
                    . '</div>'
                    . '<a class="permaLink" href="' . get_permalink() . '">'
                    . $accueil_thumbnail
                    . '<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone"/>'
                    . '<div class="infos-hover">'
                    . '<div class="ref-container">'
                    . get_field('reference')
                    . '</div>'
                    . '<div class="cat-container">'
                    . strip_tags(get_the_term_list(get_the_ID(), 'category'))
                    . '</div>'
                    . '</div>'
                    . '</a>'
                    . '</div>';
            }}
        endwhile;

        // Réinitialisation des données de post
        wp_reset_postdata();
    else :
        // Si aucune photo n'est trouvée
        echo 'Pas de photos trouvées<br/>';
    endif;
        if ($format_sortie == 'Json'){
            echo json_encode($tableau);
        }
        
    // Arrêt de l'exécution
    die();
}

// Ajout des actions WordPress pour l'appel AJAX
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');


