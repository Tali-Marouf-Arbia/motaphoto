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
            <p id='lightbox-info-ref'></p>
            <p id='lightbox-info-cat'></p>
        </div>
        </div>

        <div class="suivant-container"  >
            <img src="<?php  echo get_template_directory_uri() ?>/assets/images/suivante.png" alt="Fleche suivante" id="img-next-desk" />
        </div>
    </div>

</div>



