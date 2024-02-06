jQuery(document).ready(function($) {
    // console.log('script filtre.js chargé !')

    // Personnalisation des filtres

    // Itération à travers chaque select
    $('select').each(function () {

        // Cache les options
        var $this = $(this),
            numberOfOptions = $(this).children('option').length;

        // Cache les selects
        $this.addClass('s-hidden');

        // Entoure le select d'un div
        $this.wrap('<div class="select"></div>');

        // Ajout d'un div stylisé pour remplacer le select caché
        $this.after('<div class="styledSelect"></div>');

        // Affiche le div
        var $styledSelect = $this.next('div.styledSelect');

        // Affiche la première option dans le div styled
        $styledSelect.text($this.children('option').eq(0).text());

        // Ajoute une ul pour les options
        var $list = $('<ul />', {
            'class': 'options'
        }).insertAfter($styledSelect);

        // Ajoute les options dans les li
        for (var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        // Affiche les li
        var $listItems = $list.children('li');

        // Affiche la liste des options quand le div select est cliqué et cache quand le select est à nouveau cliqué
        $styledSelect.click(function (e) {
            e.stopPropagation();
            $('div.styledSelect.active').each(function () {
                $(this).removeClass('active').next('ul.options').hide();
            });
            $(this).toggleClass('active').next('ul.options').toggle();
        });

        // Cache la liste quand un item est selectionné
        // Met à jour la valeur selectionnée dans la liste
        $listItems.click(function (e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel')); 
            $list.hide();
        });

        // Cache la liste quand on clique en dehors de l'élément
        $(document).click(function () {
            $styledSelect.removeClass('active');
            $list.hide();
        });

    });


    // Filtre les photos lorsqu'un filtre est changé
    $('.options li').on('click', function() {
        // console.log('Filtre changé.');
        // Réinitialise la pagination
        page = 1;

        // Récupere les valeurs des filtres sélectionnés 
        let category = $('#categorie-select').val(); 
        let format = $('#format-select').val();  
        let order = $('#order-select').val();  

        // console.log('Catégorie:', category);
        // console.log('Format:', format);
        // console.log('Order:', order);

        // Requête AJAX pour charger les nouvelles photos
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_photos',
                category: category,
                format: format,
                order: order
            },
            success: function (response) {
                // Si la requête AJAX a reussi
                if (response) {
                    // console.log('Requête AJAX OK');

                    // Affiche la rep dans '.photos-accueil-container'
                    $('#photos-accueil-container').html(response);
                } else {
                    console.error('Erreur lors du chargement des photos. Réponse du serveur :', response);
                }
            },
            error: function (error) {
                console.error('Erreur AJAX :', error);
            }
        });
    });
});
