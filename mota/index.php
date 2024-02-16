<?php 
get_header(); ?>

<?php 
    $args_hero_photo = array(
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand', 
    );

    $hero_photo_query = new WP_Query($args_hero_photo);

    // Parcourt les résultats de la requête
    while ($hero_photo_query->have_posts()) :
        $hero_photo_query->the_post();

    // Récupere l'img 
    $original_image_url = wp_get_attachment_url(get_post_thumbnail_id());
?>    


<main class="content">
    <div class="hero-header" style="background-image: url('<?php echo $original_image_url; ?>');">
    <h1 class="hero-title ">PHOTOGRAPHIE EVENT</h1>
    </div>
    <?php endwhile; ?>

    <?php wp_reset_postdata(); // Réinitialise les données de publication à leur état d'origine ?>

    <!-- Section filtres -->
    <?php
    // Récupère toutes les catégories
    $taxonomy = 'category';
    $categories = get_terms($taxonomy, array('hide_empty' => false, ));
    $category_filter = (isset($_GET['category'])) ? $_GET['category'] : '';

    // Récupère tous les formats
    $taxoFormat = 'format';
    $formats = get_terms($taxoFormat,array('hide_empty' => false,));
    $category_filter_format = (isset($_GET['format'])) ? $_GET['format'] : ''; 

    ?>

    <div class="justify-center">
        <div class="filtres-container">
            <div class="filtres-gauche">
                <!-- Filtre catégorie -->
                <select id="categorie-select" class="filtre" name="category">
                    <option  value="all">Catégories</option>
                    <?php
                        // Récupère tous les termes de la taxonomie catégorie
                        $terms = get_terms(array(
                            'taxonomy' => 'category',
                            'hide_empty' => false,
                        ));
                        // Vérifie s'il y a des termes
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) { // pour chaque categ 
                                $selected = ($term->slug === $category_filter) ? 'selected' : ''; // si le slug du term = categorie filtree, attribue 'selected' à $selected 
                                echo '<option class="option" value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                            }
                        }
                    ?>
                </select>

                <!-- Filtre format -->
                <select id="format-select" class="filtre" name="format"> 
                    <option value="all">Formats</option>
                    <?php
                        // Récupérer tous les termes de la taxonomie format
                        $terms = get_terms(array(
                            'taxonomy' => 'format',
                            'hide_empty' => false,
                        ));
                        // Vérifier s'il y a des termes
                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $selected = ($term->slug === $category_filter_format) ? 'selected' : ''; 
                                echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="filtres-droite">
                <!-- Filtre tri par date -->
                <select id="order-select" class="filtre" name="category">
                    <option value="-" >Tri par</option>
                    <option value="DESC">Les plus récentes</option>
                    <option value="ASC">Les plus anciennes</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Bloc de photos accueil -->
    <section class="justify-center" >
        <div class="photos-accueil-container" id="photos-accueil-container">
            <?php
            $args_accueil_posts = array(
                'post_type' => 'photos',
                'posts_per_page' => 8,
                'orderby' => 'ASC',
            
            );

            $photos_query = new WP_Query($args_accueil_posts);

            while ($photos_query->have_posts()) : $photos_query->the_post();
                $accueil_post_id = get_the_ID();
                $accueil_thumbnail = get_the_post_thumbnail($accueil_post_id,'large');
                    if (!empty($photos_query)) {
                    
                        echo '<div class="photo-bloc photo-block">'
                        . '<div class="iconeFullscreen-container">'
                            . '<img id="iconeFullscreen" class="iconeFullscreen" src="' . get_template_directory_uri() . '/assets/images/iconFullscreen.png" alt="bouton d\'ouverture de la lightbox" />'
                        . '</div>'
                        . '<a class="permaLink photo-thumbnail" href="' . get_permalink() . '">' 
                            . $accueil_thumbnail 
                            . '<img src="' . get_template_directory_uri() . '/assets/images/eye.png" class="eye-icone"/>'
                            . '<div class="infos-hover">'
                                . '<div class="ref-container">'
                                    . get_field('reference')
                                . '</div>'
                                . '<div class="cat-container">'
                                    . strip_tags(get_the_term_list(get_the_ID(), 'category'))
                                . '</div>'
                            . '</div>'
                        . '</a>'
                    . '</div>';                
                    }
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

</main>

<!-- script js responsable du HOVER  --> 
<script>

    document.addEventListener('DOMContentLoaded', function () {
        function hover(photoBloc) {
        let eyeIcone = photoBloc.querySelector('.eye-icone');
        let infosHover = photoBloc.querySelector('.infos-hover');
        let iconFullscreen = photoBloc.querySelector('#iconeFullscreen');

        if (eyeIcone) {
            photoBloc.addEventListener('mouseenter', function () {
                eyeIcone.style.opacity = 1;
                if (infosHover) {
                    infosHover.style.opacity = 1;
                }
                if (iconFullscreen) {
                    iconFullscreen.style.opacity = 1;
                }
            });

            photoBloc.addEventListener('mouseleave', function () {
                // console.log('Mouse left:', photoBloc);
                eyeIcone.style.opacity = 0;
                if (infosHover) {
                    infosHover.style.opacity = 0;
                }
                if (iconFullscreen) {
                    iconFullscreen.style.opacity = 0;
                }
            });
        }
    }

    // Applique sur les éléments existants OK
    let photoBlocs = document.querySelectorAll('.photo-bloc');
        photoBlocs.forEach(hover);

    // Observe les mutations pour les nouv photos
    let observer = new MutationObserver(function (mutations) {

        // Cette fonction sera appelée CHAQUE FOIS qu'une mutation est détectée
        mutations.forEach(function (mutation) {
            // Pour chaque mutation détectée dans la liste des mutations
            if (mutation.type === 'childList') {
                // Si le type de mutation est une modification de la liste des enfants
                mutation.addedNodes.forEach(function (addedNode) {
                    // Pour chaque Node ajouté lors de la mutation
                    if (addedNode.classList && addedNode.classList.contains('photo-bloc')) {
                        // Si le noeu ajouté a une liste de classes et contient la classe 'photo-bloc'
                        hover(addedNode);
                        initLightbox();
                    }
                });
            }
        });
    });

    // Configurer et lancer l'observateur
    observer.observe(document.body, { childList: true, subtree: true });
});
</script>

<!-- </main> -->
<?php get_footer(); ?>


