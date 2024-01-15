document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    let modal = document.getElementById('myModal');

    // Affiche la modale
    modal.style.display = 'block';

    // Ferme la  modale
    document.addEventListener('click', function(event) {
        // Récupère l'élément sur lequel le clic s'est produit
        let target = event.target;

        // Vérifie si le clic n'est pas dans la modale
        if (target !== modal && !modal.contains(target)) {
            modal.style.display = 'none';
        }
    });
});


// document.addEventListener('DOMContentLoaded', function() {
//     // Get the modal

       // Affiche la modale
       // modal.style.display = 'block';

    // Associe l ouvertuure au clic sur le lien "Contact"
    // document.getElementById('contact-modale').addEventListener('click', function(event) {
    // modal.style.display = 'block';
    // });

//     // When the user clicks anywhere outside of the modal, close it
//     document.addEventListener('click', function(event) {
//         if (event.target !== modal && !modal.contains(event.target)) {
//             modal.style.display = 'none';
//         }
//     });
// });
