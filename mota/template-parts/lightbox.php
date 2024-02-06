<?php
// Initialiser un tableau pour stocker les objets de photos
$photo_objects = array();
$post_id = get_the_ID();

// Vérifier si nous sommes sur la page d'accueil
if (is_home() || is_front_page()) {
    // Récupérer toutes les catégories de photos disponibles
    $all_categories = get_terms('category', array('taxonomy' => 'category', 'fields' => 'ids'));
    
    // Utiliser toutes les catégories disponibles pour la requête
    $args['tax_query'][0]['terms'] = $all_categories;
} else {
    // Utiliser la logique actuelle pour les pages d'articles individuelles
    $current_category = get_the_terms($post_id, 'category');
    $args['tax_query'][0]['terms'] = $current_category[0]->term_id;
}

// WP_Query pour récupérer les articles de la même catégorie
$args = array(
    'post_type' => 'photos', 
    'posts_per_page' => -1, // Nombre de photos à afficher
    'tax_query' => array(
        array(
            'taxonomy' => 'category', 
            'field' => 'id',
            'terms' => $args['tax_query'][0]['terms'], // Utilise le terme de la catégorie défini précédemment
        ),
    ),
);

$query = new WP_Query($args);

// Vérifier si des articles ont été trouvés
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        
        // Récupérer l'ID de la photo en cours
        $current_photo_id = get_the_ID();
    
        // Récupérer les catégories de la categorie pour chaque photo
        $categories = get_the_terms($current_photo_id, 'category');
        
        // Obtenir les données de la photo pour la lightbox
        $photo_data = array(
            'thumbnail' => get_the_post_thumbnail_url($current_photo_id),
            'reference' => get_post_meta($current_photo_id, 'reference', true),
            'category'  => !empty($categories) ? $categories[0]->name : '', // Assurer que $categories est défini
        );
    
        $photo_objects[] = $photo_data; // on stocke les données dans le tableau principal (tableau dans le tableau)
    }
    wp_reset_postdata();
}
?>

<script>
    //on passe le tableau à javascript
    let dataPhotos = <?php echo json_encode($photo_objects); ?>;
    let categories = <?php echo json_encode(wp_list_pluck($categories, 'name')); ?>; // Ajout de cette ligne pour récupérer les noms des catégories
</script>


















<!-- The Lightbox -->
<div id="myLightbox" class="lightbox-container">
    <div id="lightbox-cross" class="croix-container">
        <img id="croixLightbox" class="croixLightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/croix.png" />
    </div>

    <!-- Lightbox content -->
    <div class="lightbox-content">
        <div class="precedent-container">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/precedente.png" alt="Fleche précédente" />
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-mob"/>
        </div>

        <div class="lightbox-image-container">
            <img src='<?php echo get_the_post_thumbnail_url(); ?>' id="lightbox-image" />
        </div>

        <div class="suivant-container"  >
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-desk" />
        </div>
    </div>

    <div class="infos-lightbox-container" id="infos-lightbox-container">
        <p id='lightbox-info-ref'><?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
        <p id='lightbox-info-cat'>
            <?php
            if (!empty($categories)) {
                foreach ($categories as $categorie) {
                    echo esc_html($categorie->name);
                }
            }
            ?>
        </p>
    </div>
</div>












<script>
    
// Fonction pour initialiser la lightbox
function initLightbox() {

    function openLightbox(index) {
        currentIndex = index;
        $('#lightbox-image').attr('src', dataPhotos[currentIndex].thumbnail);
        $('#lightbox-info-ref').text(dataPhotos[index].reference);
        $('#lightbox-info-cat').text(dataPhotos[index].category);
        $('#myLightbox').fadeIn();
    }

    // Événement de clic sur les éléments avec la classe 'iconeFullscreen'
    $('.iconeFullscreen').on('click', function() {
    let index = $(this).closest('.photo-bloc, .photo-apparentee').index();
    console.log('index cliqué: ', index);

    // Vérifier si l'index est valide
    if (index >= 0) {
        openLightbox(index);
    } else {
        console.error('Invalid index:', index);
    }
    });


    // Événement de clic sur la croix pour fermer la lightbox   
     $('#lightbox-cross').on('click', function() {
        closeLightbox();
    });

    function closeLightbox() {
        $('#myLightbox').fadeOut();
    }

    // Événement de clic sur la flèche précédente
    $('.precedent-container').on('click', function() {
        currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
        openLightbox(currentIndex);
    });

    // Événement de clic sur la flèche suivante
    $('.suivant-container').on('click', function() {
        currentIndex = (currentIndex + 1) % dataPhotos.length;
        openLightbox(currentIndex);
    });

    // Ajoutez les fonctionnalités de navigation gauche/droite ici  
    $('.precedent-lightbox').on('click', function() {
        leftLightbox();
    });

    $('.suivant-lightbox').on('click', function() {
        rightLightbox();
    });

    // Fonctions pour la navigation gauche/droite
    function leftLightbox() {
        currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
        updateLightboxContent(currentIndex);
    }

    function rightLightbox() {
        currentIndex = (currentIndex + 1) % dataPhotos.length;
        updateLightboxContent(currentIndex);
    }
   
    function updateLightboxContent(index) {
        $('#lightbox-image').attr('src', dataPhotos[index].thumbnail);
        $('#lightbox-info-ref').text(dataPhotos[index].reference);
        $('#lightbox-info-cat').text(dataPhotos[index].category);
    }

    // CLIC sur Escape pour fermer la lightbox
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // NAV avec le clavier
    $(document).on('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            leftLightbox();
        } else if (e.key === 'ArrowRight') {
            rightLightbox();
        }
    }); 
};



// Appeler initLightbox lorsque le document est prêt
jQuery(document).ready(function($) {
    initLightbox();
});

</script>

