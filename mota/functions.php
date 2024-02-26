<?php

function enqueue_my_theme_styles() {
    // Enqueue le fichier style.css
    wp_enqueue_style('my-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'enqueue_my_theme_styles');

// Enqueue scripts.js
function enqueue_scripts_js() {
    wp_enqueue_script('js-script', get_template_directory_uri() . '/scripts.js', array('jquery'), '1.0', true);
    wp_localize_script('js-script', 'wp_data', array( //transmet wp_data à mon JS
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    wp_localize_script('js-script', 'ajax_object', array( //transmet ajax_object
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_scripts_js');

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

// Fonction pour ajouter le support des miniatures pour le Custom PT "Photos"
function add_thumbnail_photos() {
    add_theme_support('post-thumbnails');
    add_image_size('custom-thumbnail', 81, 71, true); //definit la taille des miniatures utilisees ds single-phots
}
// Ajout de l'action pour exécuter la fonction lors de l'initialisation d'ACF
add_action('acf/init', 'add_thumbnail_photos');

// fonction de chargement des photos via AJAX
function load_more_posts() {
    $page = $_POST['page'];
    $category = isset($_POST['category']) ? $_POST['category'] : ''; // Catégorie sélectionnée
    $format = isset($_POST['format']) ? $_POST['format'] : ''; 
    $order = isset($_POST['order']) ? $_POST['order'] : ''; 

    // Construction des arguments pour la requête WP_Query en fonction des filtres
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
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
    // Créer un tableau pour stocker les nouvelles données de photos
    $new_photos_data = array();

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) : $photos_query->the_post();
            // Collecter les données de chaque nouvelle photo
            $thumbnail_url = get_the_post_thumbnail_url();
            $reference = get_post_meta(get_the_ID(), 'reference', true);
            $categories = get_the_terms(get_the_ID(), 'category');
            $category_name = !empty($categories) ? $categories[0]->name : '';

            // Ajouter les données de la nouvelle photo au tableau
            $new_photos_data[] = array(
                'thumbnail' => $thumbnail_url,
                'reference' => $reference,
                'category' => $category_name
            );
            // Afficher le contenu de chaque post
            ?>
            <div class="photo-bloc photo-block">
                <?php
                $accueil_post_id = get_the_ID();
                $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id, 'large');
                if (!empty($accueil_thumbnail)) {
                    echo '<div class="iconeFullscreen-container">'
                        . '<img id="iconeFullscreen" class="iconeFullscreen" src="' . get_template_directory_uri() . '/assets/images/iconFullscreen.png" alt="bouton d\'ouverture de la lightbox" />'
                    . '</div>'
                    . '<a class="permaLink photo-thumbnail" href="' . get_permalink() . '">' 
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
        wp_reset_postdata(); // Réinitialiser les données de post
    } else {
        // affiche la fin de galerie
        echo '<div class="mess-end-load-gallery">' .'<p>' .  'Fin de la galerie' . '</p>' . '<img id="icone-pinkCam" src="' . get_template_directory_uri() . '/assets/images/pinkCam.png">' .'</div>' ;
    }
    
    // Récupérer le contenu du tampon de sortie et le nettoyer, puis l'assigner à la variable $content
    $content = ob_get_clean();
    
    // Imprimer le résultat de la requête AJAX (contenu du succès et numéro de page)
    echo json_encode(array('result' => 'success', 'content' => $content, 'page' => $page, 'new_photos_data' => $new_photos_data));
    die(); // Termine le script PHP
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
            'posts_per_page' => 8,
            'paged' => $page,
            'order' => $order,
        );
    } else if ($categorie == 'all') {
        // Si on veut seulement toutes les catégories, on filtre uniquement sur le format
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
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
            'posts_per_page' => 8,
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
            'posts_per_page' => 8,
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
        $accueil_thumbnail_id = get_post_thumbnail_id($accueil_post_id);
        $accueil_thumbnail_src = wp_get_attachment_image_src($accueil_thumbnail_id, 'large');
        $tableau[] = ['thumbnail' => $accueil_thumbnail_src[0], 'category' => strip_tags(get_the_term_list(get_the_ID(), 'category')), 'reference' => get_field('reference')];
            if($format_sortie != 'Json'){
                // Affichage du bloc de photo avec des détails
                echo '<div class="photo-bloc photo-block">'
                    . '<div class="iconeFullscreen-container">'
                    . '<img id="iconeFullscreen" class="iconeFullscreen" src="' . get_template_directory_uri() . '/assets/images/iconFullscreen.png" alt="bouton d\'ouverture de la lightbox" />'
                    . '</div>'
                    . '<a class="permaLink" href="' . get_permalink() . '">'
                    . '<img class="wp-post-image" src="' . $accueil_thumbnail_src[0] . '" alt="" />' // Utilisation de l'URL de l'image sans les balises <img>
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
            }
        
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


