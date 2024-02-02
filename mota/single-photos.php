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
                $reference = get_post_meta($post_id, 'reference', true);
                // Vérifie si la référence existe
                if ($reference) {
                    // Affiche la référence
                    echo $reference;
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
                $type = get_post_meta($post_id, 'type', true);
                if ($type) {
                    echo $type;
                } else {
                    echo 'Aucune référence définie pour cet article.';
                }
                ?>
            </p>

            <p>année :
                <?php
                // Récupére la date du custom post type
                $annee = get_the_date('Y', $post_id);
                echo $annee;
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
            <a id="contact-modale" href="#" data-ref="<?php echo $reference ?>" >Contact</a>
        </div>
    </div>

    <div class="miniature-aera">
        <?php
        // Récupére la miniature du post actuel
        $thumbnail = get_the_post_thumbnail($post_id, 'custom-thumbnail');
        $prev_custom_post = get_previous_post();
        $next_custom_post = get_next_post();
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
            if ($prev_custom_post){
                $prev_custom_post_link = get_permalink($prev_custom_post);
                echo '<a href="' . esc_url($prev_custom_post_link) . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="photo précédente" class="arrow-left"/></a>';
            }

            if ($next_custom_post){
                $next_custom_post_link = get_permalink($next_custom_post);
                echo '<a href="' . esc_url($next_custom_post_link) . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="photo suivante" class="arrow-right"/></a>';
            }
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
       get_template_part('template-parts/photo-block'); 
    ?>
    </div>
  </div>


</div> 

<!-- script js responsable de la gestion du hover sur les photos apparentées page de photo unique -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    let photoApparentees = document.querySelectorAll('.photo-apparentee');

    photoApparentees.forEach(function (photoApparentee) {
        let eyeIcone = photoApparentee.querySelector('.eye-icone');
        let infosHover = photoApparentee.querySelector('.infos-hover');
        let iconFullscreen = photoApparentee.querySelector('#iconeFullscreen'); 

        photoApparentee.addEventListener('mouseenter', function () {
            eyeIcone.style.opacity = 1;
            infosHover.style.opacity = 1;
            iconFullscreen.style.opacity = 0.8; // Gestion de l'opacité de l'icône fullscreen
        });

        photoApparentee.addEventListener('mouseleave', function () {
            eyeIcone.style.opacity = 0;
            infosHover.style.opacity = 0;
            iconFullscreen.style.opacity = 0; // Gestion de l'opacité de l'icône fullscreen
        });
    });
});


</script>

<?php
get_footer();
?>
