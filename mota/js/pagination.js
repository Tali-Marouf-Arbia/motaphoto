jQuery(function($) { // attend le chargement du DOM et execute le code
    var page = 2; // init la variable a 2
    var canLoadMore = true;

    $('#pagination-photos').on('click', function() { // associe le clic au bouton charger +
        // console.log('clic sur bouton "charger plus"');
        if (canLoadMore) {
            // console.log('Can load more!');// pr verif si chargement supplem  est bien autorisé
            
            // effectue la requete ajax vers le serveur wp
            $.ajax({
                url: wp_data.ajax_url, // vers le fichier admin-ajax.php sur le serveur wp
                type: 'POST',
                data: { // données a envoyees avec la requete
                    action: 'load_more_posts', // action a executer
                    page: page, // num de page
                },

                // si requete ajax success, execute la fonction
                success: function(response) {
                    // console.log('Ajax success!'); // pr verif si requete success
                    // console.log(response); // affiche la reponse ajax ds la console

                    var result = JSON.parse(response);  // Parse la réponse JSON
                    // console.log(result);
                    // console.log(result.result);
                    if (result.result === 'success') { // si requete ajax reussie, ajoute le contenu de la rep a la div  
                        $('.photos-accueil-container').append(result.content);
                        page++; // incremente le num de page pr la prochaine requete
                        // Vérifie si la réponse du serveur contient le message "Fin de la galerie", et s'il le fait, masque la div pagination-accueil-container
                        if (result.content.indexOf('Fin de la galerie') !== -1) {
                            $('.pagination-accueil-container').hide(); // masque la div qui contient le btn à la fin de la gallerie
                        }
                    } else {
                        console.log('Error in response'); // affiche un mess ds la cons en cas d erreur
                    }
                }
            });
        }
    });
});(jQuery);




