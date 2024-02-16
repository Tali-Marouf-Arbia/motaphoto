function initPagination() {
    jQuery(function($) {
        var page = 2;
        var canLoadMore = true;

        $('#pagination-photos').off().on('click', function() {
            if (canLoadMore) {
                var category = $('#categorie-select').val(); // Valeur de la catégorie sélectionnée
                var format = $('#format-select').val(); 
                var order = $('#order-select').val(); 

                $.ajax({
                    url: wp_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'load_more_posts',
                        page: page,
                        category: category, 
                        format: format, 
                        order: order 
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

// Appelle lorsque le document est prêt
jQuery(document).ready(function($) {
    initPagination();
});
