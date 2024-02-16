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
                        // console.log('result de la fonction load_more_post:', result);
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



                    
                // $.ajax({
                //     url: wp_data.ajax_url,
                //     type: 'POST',
                //     data: {
                //         action: 'load_more_posts',
                //         page: page,
                //         category: category, // Ajoute la catégorie sélectionnée à l'objet data
                //         format: format, // Ajoute le format sélectionné à l'objet data
                //         order: order // Ajoute l'ordre sélectionné à l'objet data
                //        format_sortie: 'Json'
                //     },
                // success: function (response) {
                //     // Si la requête AJAX a réussi
                //     if (response) {                   
                //         // Mettre à jour dataPhotos avec la réponse JSON
                //         dataPhotos = JSON.parse(response);
                //         console.log('Requête AJAX réussie ! réponse:', response);
                    // success: function(response) {
                    //     var result = JSON.parse(response);
                    //     if (result.result === 'success') {
                    //         $('.photos-accueil-container').append(result.content);

                    //         // Met à jour dataPhotos avec les nouvelles données de photos
                    //         let newPhotosData = result.new_photos_data;
                    //         // dataPhotos = [];
                    //         dataPhotos = dataPhotos.concat(newPhotosData); // concatene les nouvll donnees avc dataPhotos 
                    //         console.log('dataPhotos concat newPhotosData :', newPhotosData);

                    //         if (result.content.indexOf('Fin de la galerie') !== -1) {
                    //         $('.pagination-accueil-container').hide(); // Cache la div du message de fin de galerie
                    //             // canLoadMore = false; // Empêche le chargement supplémentaire
                    //         }
                            
                    //     } else {
                    //         console.log('Error in response');
                    //     }
                    // }
