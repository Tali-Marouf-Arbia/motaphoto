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
            // console.log('Contenu de dataPhotos:', dataPhotos);
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
    // Escape pour fermer la lightbox
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
    // NAV avec les flêches du clavier
    $(document).off().on('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            index = (index - 1 + dataPhotos.length) % dataPhotos.length;
            openLightbox(index);
        } else if (e.key === 'ArrowRight') {
            index = (index + 1) % dataPhotos.length;
            openLightbox(index);
        }
    });
};

// Appeler initLightbox lorsque le document est prêt
jQuery(document).ready(function($) {
    initLightbox();
});
