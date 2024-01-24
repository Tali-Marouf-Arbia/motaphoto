<?php

// Utilisation de WP_Query pour récupérer les objets du CPT "photos"
$args = array(
    'post_type' => 'photos', //CPT Photo
    'posts_per_page' => -1, //-1 pour récupérer toutes les photos
);

$query = new WP_Query($args); 

//  si articles 
if ($query->have_posts()) {
    // Initialise un tableau pour stocker les objets
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
        <img id="croixLightbox" class="croixLightbox" src="<?php echo get_template_directory_uri(); ?>/assets/images/croix.png"/>   
    </div>

    <!-- Lightbox content -->
    <div class="lightbox-content">
        <div class="precedent-container">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/precedente.png" alt="Fleche précédente" />
        </div>

        <div class="lightbox-image-container">
        <img src='<?php echo get_the_post_thumbnail_url(); ?>'id="lightbox-image"/>

        </div>

        <div class="suivant-container">
            <img src="<?php echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante"/>
        </div>
    </div>

    <div class="infos-lightbox-container">
        <p id='lightbox-info-ref'>REF</p>
        <p id='lightbox-info-cat'>CAT</p>
    </div>
</div>

<script>
    // Utilise le tableau dataPhotos pour initialiser la lightbox
    let lightbox = document.getElementById("myLightbox");
    let lightbox_overlay = document.querySelector(".lightbox-container");
    let lightbox_cross = document.querySelector(".croix-container");
    let lightbox_image = document.getElementById("lightbox-image");

    let photo = document.getElementById("iconeFullscreen");

    // Fonction pour ouvrir la lightbox
    function openLightbox() {
        lightbox.classList.add("active-flex");
        lightbox.classList.remove("inactive");
        lightbox_overlay.classList.add("active");
        lightbox_overlay.classList.remove("inactive");
        lightbox_cross.classList.add("active");
        lightbox_cross.classList.remove("inactive");
        
        // Afficher la première image au démarrage de la lightbox
        lightbox_image.src = dataPhotos[0].thumbnail;
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        lightbox.classList.add("inactive");
        lightbox.classList.remove("active-flex");
        lightbox_overlay.classList.add("inactive");
        lightbox_overlay.classList.remove("active");
        lightbox_cross.classList.add("inactive");
        lightbox_cross.classList.remove("active");
    }

    // Ouverture de la lightbox au clic sur l'icone
    photo.addEventListener("click", function () {
        openLightbox();
        console.log('clic sur l icone lightbox')
    });

    // Fermeture de la lightbox au clic sur la croix
    lightbox_cross.addEventListener("click", function () {
        closeLightbox();
    });
</script>
