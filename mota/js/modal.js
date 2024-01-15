document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    let modal = document.getElementById('myModal');
    let contactLink = document.getElementById('contact-modale');
    console.log('Modal et lien de contact récupérés !!!!');



    // Affiche la modale
    modal.style.display = 'block';

    //bouton contact single-photo
    contactLink.addEventListener('click', function(event) {
        // event.preventDefault(); // Empêcher le comportement par défaut du lien (rechargement de la page)
        modal.style.display = 'block'; // Affiche la modale
        console.log('CLICK SUR LE LIEN CONTACT OK !!!!');
    });
    

    // Ferme la  modale
    document.addEventListener('click', function(event) {
        // Récupère l'élément sur lequel le clic s'est produit
        let target = event.target;

        // Vérifie si le clic n'est pas dans la modale , ni sur le bouton contact
        if (target !== modal && !modal.contains(target) &&  target !== contactLink) {
            modal.style.display = 'none';
            console.log('Clic hors modale');
        }
    });
});

