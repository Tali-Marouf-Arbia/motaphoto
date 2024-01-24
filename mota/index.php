<?php 
get_header(); ?>

<?php 
$args_hero_photo = array(
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand', // Tri des résultats de manière aléatoire
    );

$hero_photo_query = new WP_Query($args_hero_photo);

    // Parcourt les résultats de la requête
while ($hero_photo_query->have_posts()) :
    $hero_photo_query->the_post();
    $post_permalink = get_permalink(); // Lien permanent de la publication actuelle

    // Récupere l'img 
    $original_image_url = wp_get_attachment_url(get_post_thumbnail_id());
    $post_id = get_the_ID();
    ?>    


<main class="content">
    <div class="hero-header" style="background-image: url('<?php echo $original_image_url; ?>');">
    <h1 class="hero-title ">PHOTOGRAPHIE EVENT</h1>
    </div>


<?php endwhile; ?>

<?php wp_reset_postdata(); // Réinitialise les données de publication à leur état d'origine ?>



<!-- Bloc de photos accueil -->
<section class="justify-center">

    <div class="photos-accueil-container">
        <?php
        $args_accueil_posts = array(
            'post_type' => 'photos',
            'posts_per_page' => 12,
            'orderby' => 'date',
        );

        $photos_query = new WP_Query($args_accueil_posts);

        while ($photos_query->have_posts()) : $photos_query->the_post();
            $accueil_post_id = get_the_ID();
            $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id,'large');
                if (!empty($photos_query)) {
                
                    echo '<div class="photo-bloc">'
                    . '<a class="permaLink" href="' . get_permalink() . '">' 
                        . $accueil_thumbnail 
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
                . '</div>';                }
                else {
                    echo 'Aucunes photos trouvées';
                }
        endwhile;
        ?>
    </div>
</section>

<!-- Pagination page d'accueil -->
<div class="pagination-accueil-container">
        <button id="pagination-photos" class="pagination-photos">Charger plus</button>
</div>


<div class="iconeFullscreen-container">
            <img id="iconeFullscreen" src="<?php echo get_template_directory_uri() ?>/assets/images/iconFullscreen.png" alt="bouton d'ouverture de la lightbox"/>
</div>

</main>

<!-- script js responsable de la gestion du hover sur les cards de la page d accueil -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    let photoApparentees = document.querySelectorAll('.photo-bloc');

    photoApparentees.forEach(function (photoApparentee) {
        let eyeIcone = photoApparentee.querySelector('.eye-icone');
        let infosHover = photoApparentee.querySelector('.infos-hover');

        photoApparentee.addEventListener('mouseenter', function () {
            eyeIcone.style.opacity = 1;
            infosHover.style.opacity = 1;
        });

        photoApparentee.addEventListener('mouseleave', function () {
            eyeIcone.style.opacity = 0;
            infosHover.style.opacity = 0;
        });
    });
});
</script>

</main>
<?php get_footer(); ?>


<?php get_footer(); ?>


<!-- echo '<div class="photo-bloc">'. '<a href="' . get_permalink() . '">' . $accueil_thumbnail .'<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone">'  .  '</a>' . '</div>'; -->
