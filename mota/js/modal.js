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


