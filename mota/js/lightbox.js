// Fonction pour initialiser la lightbox
function initLightbox() {
    
    function openLightbox(index, isPhotoApparentee) {
        console.log('Contenu de dataPhotos:', dataPhotos);
    
        console.log('Ouverture de la lightbox avec l\'index:', index);
        currentIndex = index;
        console.log('Index courant:', currentIndex);
    
        // Récupérer les données de la photo correspondante à l'index ou à l'élément photo-apparentee cliqué
        var photoData;
        if (isPhotoApparentee) {
            // Récupérer les données de la photo-apparentee cliquée
            var photoApparentee = $('.photo-apparentee').eq(index);
            photoData = {
                thumbnail: photoApparentee.find('.permaLink img:first').attr('src'),
                reference: photoApparentee.find('.infos-hover .ref-container').text(),
                category: photoApparentee.find('.infos-hover .cat-container').text()
            };
        } else {
            // Récupérer les données de la photo correspondante à l'index
            photoData = dataPhotos[index];
            
        }
    
        console.log('Données de la photo:', photoData);
    
        // Mettre à jour le contenu de la lightbox avec les données de la photo
        $('#lightbox-image').attr('src', photoData.thumbnail);
        $('#lightbox-info-ref').text(photoData.reference);
        $('#lightbox-info-cat').text(photoData.category);
        $('#myLightbox').fadeIn();
    }
    
    // Clic sur bouton d'ouverture
    $('.iconeFullscreen').on('click', function() {
        let index = $(this).closest('.photo-bloc, .photo-apparentee').index();
        let isPhotoApparentee = $(this).closest('.photo-apparentee').length > 0;
    
        console.log('index cliqué: ', index);
        console.log('dataPhotos: ', dataPhotos);
    
        // Si l'index est valide
        if (index >= 0) {
            openLightbox(index, isPhotoApparentee);
        } else {
            console.error('Invalid index:');
        }
    });
    
    
    // navigation gauche/droite 
    $('.precedent-container').on('click', function() {
        currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
        openLightbox(currentIndex);
        console.log('clic a gauche !');
    });
    
    $('.suivant-container').on('click', function() {
        currentIndex = (currentIndex + 1) % dataPhotos.length;
        openLightbox(currentIndex);
        console.log('clic a droite ! ');
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
    
    // NAV avec le clavier
    $(document).on('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
            openLightbox(currentIndex);
        } else if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % dataPhotos.length;
            openLightbox(currentIndex);
        }
    }); 
};

// Appeler initLightbox lorsque le document est prêt
jQuery(document).ready(function($) {
    initLightbox();
});




    // function openLightbox(index) {
    //     console.log('Contenu de dataPhotos:', dataPhotos);
    //     // console.log('Ouverture de la lightbox avec l\'index:', index);
        
    //     currentIndex = index;
    //     console.log('Index courant:', currentIndex);

    //     // Récupérer les données de la photo depuis dataPhotos
    //     var photoData = dataPhotos[index];
    //     var thumbnailSrc = photoData.thumbnail;
    //     var reference = photoData.reference;
    //     var category = photoData.category;

    //     console.log('Source miniature:', thumbnailSrc);
    //     console.log('Référence:', reference);
    //     console.log('Catégorie:', category);

    //     $('#lightbox-image').attr('src', thumbnailSrc);
    //     $('#lightbox-info-ref').text(reference);
    //     $('#lightbox-info-cat').text(category);
    //     $('#myLightbox').fadeIn();
    // }

