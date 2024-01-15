<?php
/**
 * Template Name: Photo unique
 */

get_header();
?>
<div class="post-aera">
    <div class="post-content">
        <?php
        // Affiche le contenu de l'article
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        ?>

        <div class="post-infos">
            <div class="infosPost">
            <h2>
                <?php
                // Récupère l'ID du custom post type en cours
                $post_id = get_the_ID();
                // Récupére le titre du custom post type
                $title = get_the_title($post_id);
                echo $title;
                ?>
            </h2>

            <p>référence :
                <?php
                // Récupér la valeur du custom field "reference"
                $ma_reference = get_post_meta($post_id, 'reference', true);
                // Vérifie si la référence existe
                if ($ma_reference) {
                    // Affiche la référence
                    echo $ma_reference;
                } else {
                    echo 'Aucune référence définie pour cet article.';
                }
                ?>
            </p>

            <p>catégorie :
                <?php
                // Récupérer les termes de la taxonomie "categorie" associés à ce post
                $terms = get_the_terms($post_id, 'category');
                if ($terms && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $cat = $term->name;
                        echo $cat;
                    }
                } else {
                    echo 'Aucune catégorie définie pour cet article.';
                }
                ?>
            </p>

            <p>format :
                <?php
                // Récupérer les termes de la taxonomie "format" associés à ce post
                $terms = get_the_terms($post_id, 'format');
                // Vérifier si des termes existent
                if ($terms && !is_wp_error($terms)) {
                    // Boucler à travers les termes
                    foreach ($terms as $term) {
                        // Afficher la référence
                        echo $term->name;
                    }
                } else {
                    // Afficher un message si aucun terme n'est trouvé
                    echo 'Aucune référence définie pour cet article.';
                }
                ?>
            </p>

            <p>type :
                <?php
                // Récupérer la valeur du custom field "type"
                $mon_type = get_post_meta($post_id, 'type', true);
                if ($mon_type) {
                    echo $mon_type;
                } else {
                    echo 'Aucune référence définie pour cet article.';
                }
                ?>
            </p>

            <p>date :
                <?php
                // Récupére la date du custom post type
                $date = get_the_date('Y', $post_id);
                echo $date;
                ?>
            </p>
            </div>
        </div>
    </div>
  <div class="contact-post-container">
    <div class="contact-post-aera">
        <div>
            <p>Cette photo vous intéresse ?</p>
        </div>
        <div class="bouton-single-photo">
            <a id="contact-modale" href="#" >Contact</a>
        </div>
    </div>

    <div class="miniature-aera">
        <?php
        // Récupére la miniature du post actuel
        $thumbnail = get_the_post_thumbnail($post_id, 'custom-thumbnail');
        $prev_custom_post = get_previous_post($post_id);
        $next_custom_post = get_next_post($post_id);
        $next_post_thumbnail = get_the_post_thumbnail($next_custom_post, 'custom-thumbnail');
        
        // Affiche la miniature
        if (!empty($thumbnail)) {
            echo '<div class="miniature-container">' . $next_post_thumbnail . '</div>';
        } else {
            echo 'Aucune miniature définie.';
        }
        ?>
        <div class="fleches-container">
            <?php
            
                $prev_custom_post_link = get_permalink($prev_custom_post);
                echo '<a href="' . esc_url($prev_custom_post_link) . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="photo précédente" class="arrow-left"/></a>';
            

            
                $next_custom_post_link = get_permalink($next_custom_post);
                echo '<a href="' . esc_url($next_custom_post_link) . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="photo suivante" class="arrow-right"/></a>';
            
            ?>
        </div>
    </div>
  </div>


  <div class="autre-post-aera">
    <div>
        <h3 class="autre-post-title">VOUS AIMEREZ AUSSI</h3>
    </div>

    <div class="photos-apparentees-container">

        <?php
        // Récupére la catégorie actuelle
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
                $related_thumbnail = get_the_post_thumbnail($related_post_id, 'large'); // large ou medium ??
                if (!empty($related_thumbnail)) {
                    echo '<div class="photo-apparentee">' . $related_thumbnail . '</div>';
                } else {
                    echo 'Aucune miniature définie.';
                }
            endwhile;
        else :
            echo '<div id="redirection-photos">' . 'Aucune photo apparentée trouvée, retrouvez toutes nos photos ' . '<a href="http://localhost/motaphoto">'  . ' ici' . '</a>' . '</div>';
        endif;
        ?>
    </div>



    <div class="bouton-all-photos bouton-single-photo">
        <a href="#">Toutes les photos</a>
    </div>
  </div>


</div>

<?php
get_footer();
?>
