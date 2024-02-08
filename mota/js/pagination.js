function initPagination(){
jQuery(function($) {
    var page = 2;
    var canLoadMore = true;

    $('#pagination-photos').on('click', function() {
        if (canLoadMore) {
            var category = $('#categorie-select').val(); // Valeur de la catégorie sélectionnée
            var format = $('#format-select').val(); // Valeur du format sélectionné
            var order = $('#order-select').val(); // Valeur de l'ordre sélectionné
            
            $.ajax({
                url: wp_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: page,
                    category: category, // Ajouter la catégorie sélectionnée à l'objet data
                    format: format, // Ajouter le format sélectionné à l'objet data
                    order: order // Ajouter l'ordre sélectionné à l'objet data
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.result === 'success') {
                        $('.photos-accueil-container').append(result.content);
                        page++;
                        if (result.content.indexOf('Fin de la galerie') !== -1) {
                            $('.pagination-accueil-container').hide();
                        }
                    } else {
                        console.log('Error in response');
                    }
                }
            });
        }
    });
});
}


// Appeler initLightbox lorsque le document est prêt
jQuery(document).ready(function($) {
    initPagination();
});
