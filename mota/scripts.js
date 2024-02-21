// Script du menu
document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.querySelector('.burger-menu');
    const megaMenu = document.getElementById('mega-menu');

    burgerMenu.addEventListener('click', function() {
        burgerMenu.classList.toggle('change');
        megaMenu.classList.toggle('active-mobile');
        megaMenu.classList.toggle('inactive-mobile');
    });

    megaMenu.addEventListener('click', function() {
        burgerMenu.classList.remove('change');
        megaMenu.classList.remove('active-mobile');
        megaMenu.classList.add('inactive-mobile');
    });
});


// script de la modale
document.addEventListener('DOMContentLoaded', function() {
    // recupère la modale et les liens qui déclenchent son ouverture
    let modal = document.getElementById('myModal');
    let contactLink = document.getElementById('contact-modale');
    let contactNavLink = document.querySelector('.menu-item-10');
    let contactMob = document.querySelector('ul#mega-menu .menu-item-10');
    
    // Affiche la modale
    modal.style.display = 'block';

    // au clic sur le bouton Contact de single-photo, ouvrir la modale avec le champ réf.photo pré-rempli
    if (contactLink) {
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien (rechargement de la page)
            modal.style.display = 'block'; // Affiche la modale

            let refPhoto = $(this).attr("data-ref");
            jQuery("#reference-photo").val(refPhoto);
        });
    }

    // au clic sur le lien CONTACT du header, ouvrir la modale
    contactNavLink.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation(); // Arrête la propagation de l'événement
        modal.style.display = 'block';
    });


    contactMob.addEventListener('click', function(event) {
        event.preventDefault();
        event.stopPropagation(); 
        modal.style.display = 'block';
    });


    // Ferme la modale
    document.addEventListener('click', function(event) {
        // Récupère l'élément sur lequel le clic s'est produit
        let target = event.target;

        // Vérifie si le clic n'est pas dans la modale, ni sur les liens de contact
        if (target !== modal && !modal.contains(target) && target !== contactLink && target !== contactNavLink && target !== contactMob) {
            modal.style.display = 'none';
        }
    });
});


//script de la lightbox
var dataPhotos = [];
var index = 0; //  index en tant que variable globale et j ai nettoye tous les currentIndx ...

// Fonction pour initialiser la lightbox
function initLightbox() {
    function openLightbox(index) {
        dataPhotos = [];
        $(".photo-bloc").each(function() {
            var thumbnail = $(this).find('.wp-post-image').attr('src');
            var reference = $(this).find('.ref-container').text();
            var categorie = $(this).find('.cat-container').text();
            var data = { 'thumbnail': thumbnail, 'reference': reference, 'category': categorie };
            dataPhotos.push(data);
        });
        // Mettre à jour le contenu de la lightbox avec les données de la photo
        $('#lightbox-image').attr('src', dataPhotos[index].thumbnail);
        $('#lightbox-info-ref').text(dataPhotos[index].reference);
        $('#lightbox-info-cat').text(dataPhotos[index].category);
        $('#myLightbox').fadeIn();
    }
    // Clic sur bouton d'ouverture
    $('.iconeFullscreen').off().on('click', function() {
        index = $(this).closest('.photo-bloc').index();
        // Si l'index est valide
        if (index >= 0) {
            openLightbox(index);
        } else {
            console.error('Invalid index:');
        }
    });

    // navigation gauche/droite 
    $('.fleche-prev').off().on('click', function() {
        index = (index - 1 + dataPhotos.length) % dataPhotos.length;
        openLightbox(index);
    });
    $('.suivant-container').off().on('click', function() {
        index = (index + 1) % dataPhotos.length;
        openLightbox(index);
    });
    $('.fleche-next-mob').off().on('click', function() {
        index = (index + 1) % dataPhotos.length;
        openLightbox(index);
    });
    // clic sur la croix pour fermer la lightbox   
    $('#lightbox-cross').on('click', function() {
        closeLightbox();
    });
    function closeLightbox() {
        $('#myLightbox').fadeOut();
    }
    // CLAVIER 
    // NAV avec les flêches du clavier
    $(document).off().on('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            index = (index - 1 + dataPhotos.length) % dataPhotos.length;
            openLightbox(index);
        } else if (e.key === 'ArrowRight') {
            index = (index + 1) % dataPhotos.length;
            openLightbox(index);
        }
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
};
// Appeler initLightbox lorsque le document est prêt
jQuery(document).ready(function($) {
    initLightbox();
});

// script des filtres 
jQuery(document).ready(function($) {
    // Personnalisation des filtres
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

        // Gestion du background sur les éléments de la liste state = checked
        $('.options li').on('click', function() {
        // Supprime d'abord la classe 'selected' de tous les éléments de la liste
        $('.options li').removeClass('selected');
        // Ajoute ensuite la classe 'selected' à l'élément sur lequel l'utilisateur a cliqué
        $(this).addClass('selected');
        }); 
    });

    // Filtre les photos lorsqu'un filtre est changé
    $('.options li').on('click', function() {
        
        initPagination(); // Réinitialise la pagination
        initLightbox();
        $('.pagination-accueil-container').show();

        // Récupere les valeurs des filtres sélectionnés 
        let category = $('#categorie-select').val(); 
        let format = $('#format-select').val();  
        let order = $('#order-select').val();  

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



// script de la pagination 
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