<?php
        // Récupére la catégorie actuelle
        $post_id = get_the_ID();
        $current_category = get_the_terms($post_id, 'category');

        // WP_Query pour récupérer les articles de la meme catégorie
        $args = array(
            'post_type' => 'photos', 
            'posts_per_page' => 2, // Nombre de photos à afficher
            'post__not_in' => array($post_id), // N inclue pas la photo actuelle
            'tax_query' => array(
                array(
                    'taxonomy' => 'category', 
                    'field' => 'id',
                    'terms' => $current_category[0]->term_id, // Utilise le premier terme de la catégorie
                ),
            ),
            'orderby' => 'RAND', // Ordre aléatoire
            // 'order' => 'ASC', // odre croissant
        );

        $related_photos_query = new WP_Query($args);

        // Boucle pour afficher les photos apparentées
        if ($related_photos_query->have_posts()) :
            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                $related_post_id = get_the_ID();
                $related_thumbnail = get_the_post_thumbnail($related_post_id, 'large'); 
                if (!empty($related_thumbnail)) {
                    echo '<div class="photo-apparentee">' . $related_thumbnail . '</div>';
                } else {
                    echo 'Aucune miniature définie.';
                }
            endwhile;
        else :
            echo '<div id="redirection-photos">' . 'Aucune photo apparentée trouvée, retrouvez toutes nos photos ' . '<a href=" ' . get_site_url() . ' ">'  . ' ici' . '</a>' . '</div>';
        endif;
?>



