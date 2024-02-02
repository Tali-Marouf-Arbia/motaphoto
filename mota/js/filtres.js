jQuery(function($) {

    //personnalisation des filtres

    // iteration à travers chaque select
    jQuery('select').each(function () {

        // cache les options
        var $this = $(this),
            numberOfOptions = $(this).children('option').length;
    
            // cache les selects
            $this.addClass('s-hidden');
    
            // entoure le select d'un div
            $this.wrap('<div class="select"></div>');
    
            // ajout d'un div stylisé pour remplacer le select caché
            $this.after('<div class="styledSelect"></div>');
    
            // affiche le div
            var $styledSelect = $this.next('div.styledSelect');
    
            // affiche la première option dans le div stylisé
            $styledSelect.text($this.children('option').eq(0).text());

                
            // ajoute une liste ul pour les options
            var $list = $('<ul />', {
                'class': 'options'
            }).insertAfter($styledSelect);
    
            // ajoute les options dans les li
            for (var i = 0; i < numberOfOptions; i++) {
                $('<li />', {
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).val()
                }).appendTo($list);
            }
    
            // affiche les li
            var $listItems = $list.children('li');
    
            // affiche la liste des options quand le div select est cliqué et cache quand le select est à nouveau cliqué
            $styledSelect.click(function (e) {
                e.stopPropagation();
                $('div.styledSelect.active').each(function () {
                    $(this).removeClass('active').next('ul.options').hide();
                });
                $(this).toggleClass('active').next('ul.options').toggle();
            });
    
            //cache la liste quand un item est selectionné
            // met à jour la valeur selectionnée dans la liste
            $listItems.click(function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $list.hide();
            });
    
            // cache la liste quand on clique en dehors de l'élément
            $(document).click(function () {
                $styledSelect.removeClass('active');
                $list.hide();
            });
    
        });

    


            // Filtrer les photos lorsqu'un filtre est changé
            $('.options li').on('click', function() {
                // Réinitialiser la pagination
             page = 1;

            // Réinitialiser les photos affichées
            $('#photos-container').empty();

            // Charger les nouvelles photos avec les filtres actuels
            
    });
});




    
           // Lorsque la valeur du filtre change
    // $('#order-select, #categorie-select, #format-select').change(function() {
    //     let order = $('#order-select').val();
    //     let category = $('#categorie-select').val();
    //     let format = $('#format-select').val();

    //     // Effectuez la requête Ajax
    //     $.ajax({
    //         type: 'POST',
    //         url: ajax_object.ajax_url,
    //         data: {
    //             action: 'filter_photos', function.php
    //             order: order,
    //             category: category,
    //             format: format,
    //         },
    //         success: function(response) {
    //             // Met à jour la liste des photos avec la réponse
    //             $('#photos-accueil-container').html(response);
    //         },
    //         error: function(error) {
    //             console.log(error);
    //         }
    //     });
    // });