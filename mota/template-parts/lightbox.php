<?php
    // Récupère les termes de la custom taxonomy Catégorie pour le post en cours
    $categories = get_the_terms(get_the_ID(), 'category');

    //Données pour la Lightbox
    // Utilisation de WP_Query pour récupérer les objets du CPT "photo"
    $args = array(
        'post_type' => 'photos', //CPT Photo
        'posts_per_page' => -1, //-1 pour récupérer toutes les photos
    );

    // Vérifier si on est sur la page d'accueil ou non
    if (is_home() || is_front_page()) {
        // Si on est sur la page d'accueil, ne pas filtrer par catégorie
    } elseif (!empty($categories)) {
        // Si une catégorie est définie pour l'article actuel, filtrer les photos par cette catégorie
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $categories[0]->term_id,
            ),
        );
    }

    $query = new WP_Query($args); //requette avec les arguments donnés précédemment

    // Vérifier si des articles ont été trouvés
    if ($query->have_posts()) {
        // Initialiser un tableau pour stocker les objets
        $photo_objects = array();

        while ($query->have_posts()) {//parcours de toutes les photos
            $query->the_post();
            $categories = get_the_terms(get_the_ID(), 'category'); //récupération de la catégorie

            // Obtenir les données de la photo pour la lightbox
            $photo_data = array( //stockage des données dans un tableau
                'thumbnail' => get_the_post_thumbnail_url(),
                'reference' => get_post_meta(get_the_ID(), 'reference', true),
                'category' => $categories[0]->name,
            );
            $photo_objects[] = $photo_data; //stockage des tableaux de données dans le tableau principal
        }
        wp_reset_postdata();


    }

?>

<script>
    //on passe le tableau à javascript
    let dataPhotos = <?php echo json_encode($photo_objects); ?>;
</script>




<!-- The Lightbox -->
<div id="myLightbox" class="lightbox-container">
    <div id="lightbox-cross" class="croix-container">
        <img id="croixLightbox" class="croixLightbox" src="<?php  echo get_template_directory_uri(); ?>/assets/images/croix.png" />
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
            <img src="<?php  echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-desk" />
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

    // // NAV avec le clavier
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
