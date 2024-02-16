<?php
    // Récupère les termes de la custom taxonomy Catégorie pour le post en cours
    // $categories = get_the_terms(get_the_ID(), 'category');

    // //Données pour la Lightbox
    // $args = array(
    //     'post_type' => 'photos', 
    //     'posts_per_page' => -1, 
        
    // );

    //  si on est sur la page d'accueil 
    // if (is_home() || is_front_page()) {
    //     //  ne pas filtrer par catégorie
    // } elseif (!empty($categories)) {
    //     // Si une catégorie est définie pour l'article actuel, filtrer les photos par cette catégorie
    //     $args['tax_query'] = array(
    //         array(
    //             'taxonomy' => 'category',
    //             'field' => 'term_id',
    //             'terms' => $categories[0]->term_id,
    //             'order' => 'ASC',
    //         ),
    //     );
    // }

    // $query = new WP_Query($args); //requette avec les arguments donnés précédemment

    // // Vérifier si des articles ont été trouvés
    // if ($query->have_posts()) {
    //     // Initialiser un tableau pour stocker les objets
    //     $photo_objects = array();

    //     while ($query->have_posts()) {//parcours de toutes les photos
    //         $query->the_post();
    //         $categories = get_the_terms(get_the_ID(), 'category'); //récupération de la catégorie

    //         // Obtenir les données de la photo pour la lightbox
    //         $photo_data = array( //stockage des données dans un tableau
    //             'thumbnail' => get_the_post_thumbnail_url(),
    //             'reference' => get_post_meta(get_the_ID(), 'reference', true),
    //             'category' => $categories[0]->name,
    //         );
    //         $photo_objects[] = $photo_data; //stockage des tableaux de données dans le tableau principal
    //     }
    //     wp_reset_postdata();


    // }

?>

<script>
    //on passe le tableau à javascript
    // let dataPhotos = <?php //echo json_encode($photo_objects); ?>;
</script>




<!-- The Lightbox -->
<div id="myLightbox" class="lightbox-container">
    <div id="lightbox-cross" class="croix-container">
        <img id="croixLightbox" class="croixLightbox" src="<?php  echo get_template_directory_uri(); ?>/assets/images/croix.png" />
    </div>

    <!-- Lightbox content -->
    <div class="lightbox-content" id="lightbox-content">
        <div class="precedent-container">
            <img class="fleche-prev" src="<?php echo get_template_directory_uri() ?>/assets/images/precedente.png" alt="Fleche précédente" />
            <img class="fleche-next-mob" src="<?php echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-mob"/>
        </div>
        <div>
        <div class="lightbox-image-container">
            <img id="lightbox-image" />
        </div>
        <div class="infos-lightbox-container" id="infos-lightbox-container">
            <p id='lightbox-info-ref'><?php //echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
            <p id='lightbox-info-cat'>
                <?php 
                // if (!empty($categories)) {
                // foreach ($categories as $categorie) {
                //     echo esc_html($categorie->name);  j ai nettoye vu qu on recupere les infos ds data 
                //     }
                // }
                ?>
            </p>
        </div>
        </div>

        <div class="suivant-container"  >
            <img src="<?php  echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-desk" />
        </div>
    </div>

</div>



