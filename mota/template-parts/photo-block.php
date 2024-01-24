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
    );

        $related_photos_query = new WP_Query($args);
        // Boucle pour afficher les photos apparentées
        if ($related_photos_query->have_posts()) :
            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                $related_post_id = get_the_ID();
                $related_thumbnail = get_the_post_thumbnail($related_post_id, 'large'); 
                if (!empty($related_thumbnail)) {
                    echo '<div class="photo-apparentee">'
                            . '<a class="permaLink" href="' . get_permalink() . '">' 
                                . $related_thumbnail 
                                . '<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone"/>'
                                . '<div class="infos-hover">'
                                    . '<div>'
                                        . get_field('reference')
                                    . '</div>'
                                    . '<div class="cat-container">'
                                        . strip_tags(get_the_term_list(get_the_ID(), 'category'))
                                    . '</div>'
                                . '</div>'
                            . '</a>'
                        . '</div>';

                } else {
                    echo 'Aucune miniature définie.';
                }
            endwhile;
        else :
            echo '<div id="redirection-accueil">' . 'Aucune photo apparentée trouvée, retrouvez toutes nos photos ' . '<a href=" ' . get_site_url() . ' ">'  . ' ici' . '</a>' . '</div>';
        endif;
?>



<!-- echo '<div class="photo-apparentee ">'. '<a class="permaLink" href="' . get_permalink() . '">' . $related_thumbnail . '<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone"<p></></a></div>'; -->
