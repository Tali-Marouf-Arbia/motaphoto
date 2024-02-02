document.addEventListener('DOMContentLoaded', function() {
    // recupère la modale et les liens qui déclenchent son ouverture
    let modal = document.getElementById('myModal');
    let contactLink = document.getElementById('contact-modale');
    let contactNavLink = document.getElementById('menu-item-10');
    // console.log('modale et liens de contact récupérés');
    // console.log(contactNavLink);
    // Affiche la modale
    modal.style.display = 'block';

    // au clic sur le lien CONTACT du header, ouvrir la modale
    contactNavLink.addEventListener('click', function(event) {
        event.preventDefault();
        modal.style.display = 'block';
        console.log('clic sur contact header');
    });

    // au clic sur le bouton Contact de single-photo, ouvrir la modale avec le champs réf.photo pré-rempli
    if (contactLink){
        contactLink.addEventListener('click', function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien (rechargement de la page)
            modal.style.display = 'block'; // Affiche la modale

            let refPhoto = $(this).attr("data-ref");
            // console.log($(this));
            jQuery("#reference-photo").val(refPhoto);
            // console.log('click sur le lien contact');
    })};


    // Ferme la  modale
    document.addEventListener('click', function(event) {
        // Récupère l'élément sur lequel le clic s'est produit
        let target = event.target;

        // Vérifie si le clic n'est pas dans la modale , ni sur les liens de contact
        if (target !== modal && !modal.contains(target) && target !== contactLink && target !== contactNavLink) {
            modal.style.display = 'none';
            // console.log('clic hors modale');
        }
    });
});

