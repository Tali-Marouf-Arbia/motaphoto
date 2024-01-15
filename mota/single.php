<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header(); 
?>

<main class="main-post">
    <?php
        while (have_posts()) : // Tant qu'il y a des articles à afficher, boucle.
          the_post(); // Charge l'article actuel.
    ?>

    <div class="post">
    	<h2 class="post-title"><?php the_title(); ?></h2>
        <div class="post-content">
            <?php the_content(); // Affiche le contenu de l'article. ?>
        </div>
	</div>
    <?php
        endwhile;
    ?>
</main>

<?php the_post_navigation(); ?>

<?php
get_footer();