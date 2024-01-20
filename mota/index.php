<?php 
get_header(); ?>

<?php 
$args_hero_photo = array(
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand', // Tri des résultats de manière aléatoire
    );

$hero_photo_query = new WP_Query($args_hero_photo);

    // Boucle | Parcourir les résultats de la requête
while ($hero_photo_query->have_posts()) :
    $hero_photo_query->the_post();
    $post_permalink = get_permalink(); // Lien permanent de la publication actuelle

    // Récupérer l'img 
    $original_image_url = wp_get_attachment_url(get_post_thumbnail_id());
    $post_id = get_the_ID();
    ?>    


<main class="content">
    <div class="hero-header" style="background-image: url('<?php echo $original_image_url; ?>');">
    <h1 class="hero-title ">PHOTOGRAPHIE EVENT</h1>
    </div>


<?php endwhile; ?>

<?php wp_reset_postdata(); // Réinitialiser | Données de publication à leur état d'origine ?>



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
                    echo '<div class="photo-bloc">' . $accueil_thumbnail . '</div>';
                }
                else {
                    echo 'hello';
                }
        endwhile;
        ?>
    </div>
</section>

</main>

<?php get_footer(); ?>