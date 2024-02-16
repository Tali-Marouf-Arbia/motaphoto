// var dataPhotos = [];
// // Fonction pour initialiser la lightbox
// function initLightbox() {
//     function openLightbox(index, isPhotoApparentee) {
//         dataPhotos = [];

//         $( ".photo-bloc" ).each(function( index ) {
//             // console.log( index + ": " + $( this ).text() );
//             var thumbnail = $(this).find('.wp-post-image').attr('src');
//             var reference = $(this).find('.ref-container').text();
//             var categorie = $(this).find('.cat-container').text();
//             var data = {'thumbnail' : thumbnail, 'reference' : reference, 'category' : categorie};
//             dataPhotos.push(data);
//             console.log('Contenu de dataPhotos:', dataPhotos);
//         });

//         currentIndex = index;
//         // Récupérer les données de la photo correspondante à l'index ou à l'élément photo-apparentee cliqué
//         var photoData;
//         if (isPhotoApparentee) {
//             // Récupérer les données de la photo-apparentee cliquée
//             var photoApparentee = $('.photo-apparentee').eq(index);
//             photoData = {
//                 thumbnail: photoApparentee.find('.permaLink img:first').attr('src'),
//                 reference: photoApparentee.find('.infos-hover .ref-container').text(),
//                 category: photoApparentee.find('.infos-hover .cat-container').text()
//             };
//         } else {
//             // Récupérer les données de la photo correspondante à l'index
//             photoData = dataPhotos[index];
//             console.log('photoData =', photoData);
//         }
//         // Mettre à jour le contenu de la lightbox avec les données de la photo
//         $('#lightbox-image').attr('src', photoData.thumbnail);
//         $('#lightbox-info-ref').text(photoData.reference);
//         $('#lightbox-info-cat').text(photoData.category);
//         $('#myLightbox').fadeIn();
//     }
//     // Clic sur bouton d'ouverture
//     $('.iconeFullscreen').off().on('click', function() {
//         let index = $(this).closest('.photo-bloc, .photo-apparentee').index();
//         let isPhotoApparentee = $(this).closest('.photo-apparentee').length > 0;
//         // Si l'index est valide
//         if (index >= 0) {
//             openLightbox(index, isPhotoApparentee);
//         } else {
//             console.error('Invalid index:');
//         }
//     });
//     // navigation gauche/droite 
//     $('.fleche-prev').on('click', function() {
//         currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
//         openLightbox(currentIndex);
//     });
    
//     $('.suivant-container').on('click', function() {
//         currentIndex = (currentIndex + 1) % dataPhotos.length;
//         openLightbox(currentIndex);
//     });

//     $('.fleche-next-mob').on('click', function() {
//         currentIndex = (currentIndex + 1) % dataPhotos.length;
//         openLightbox(currentIndex);
//     });
    
//     // clic sur la croix pour fermer la lightbox   
//     $('#lightbox-cross').on('click', function() {
//         closeLightbox();
//     });
    
//     function closeLightbox() {
//         $('#myLightbox').fadeOut();
//     }
    
//     // CLAVIER 
//     // Escape pour fermer la lightbox
//     $(document).on('keydown', function(e) {
//         if (e.key === 'Escape') {
//             closeLightbox();
//         }
//     });
    
//     // NAV avec le clavier
//     $(document).on('keydown', function(e) {
//         if (e.key === 'ArrowLeft') {
//             currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
//             openLightbox(currentIndex);
//         } else if (e.key === 'ArrowRight') {
//             currentIndex = (currentIndex + 1) % dataPhotos.length;
//             openLightbox(currentIndex);
//         }
//     }); 
// };
// // Appeler initLightbox lorsque le document est prêt
// jQuery(document).ready(function($) {
//     initLightbox();
// });


var dataPhotos = [];
// Fonction pour initialiser la lightbox
function initLightbox() {
    function openLightbox(index) {
        dataPhotos = [];

        $( ".photo-bloc" ).each(function( index ) {
            // console.log( index + ": " + $( this ).text() );
            var thumbnail = $(this).find('.wp-post-image').attr('src');
            var reference = $(this).find('.ref-container').text();
            var categorie = $(this).find('.cat-container').text();
            var data = {'thumbnail' : thumbnail, 'reference' : reference, 'category' : categorie};
            dataPhotos.push(data);
            console.log('Contenu de dataPhotos:', dataPhotos);
        });

        currentIndex = index;
        // Récupérer les données de la photo correspondante à l'index ou à l'élément photo-apparentee cliqué
        var photoData;
        photoData = dataPhotos[index];
        console.log('photoData =', photoData);
        
        // Mettre à jour le contenu de la lightbox avec les données de la photo
        $('#lightbox-image').attr('src', photoData.thumbnail);
        $('#lightbox-info-ref').text(photoData.reference);
        $('#lightbox-info-cat').text(photoData.category);
        $('#myLightbox').fadeIn();
    }
    // Clic sur bouton d'ouverture
    $('.iconeFullscreen').off().on('click', function() {
        let index = $(this).closest('.photo-bloc').index();
        // Si l'index est valide
        if (index >= 0) {
            openLightbox(index);
        } else {
            console.error('Invalid index:');
        }
    });
    // navigation gauche/droite 
    $('.fleche-prev').on('click', function() {
        currentIndex = (currentIndex - 1 + dataPhotos.length) % dataPhotos.length;
        openLightbox(currentIndex);
    });
    
    $('.suivant-container').on('click', function() {
        currentIndex = (currentIndex + 1) % dataPhotos.length;
        openLightbox(currentIndex);
    });

    $('.fleche-next-mob').on('click', function() {
        currentIndex = (currentIndex + 1) % dataPhotos.length;
        openLightbox(currentIndex);
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
