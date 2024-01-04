document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    let modal = document.getElementById('myModal');

    // Affiche la modale
    modal.style.display = 'block';

    // When the user clicks anywhere outside of the modal, close it
    document.addEventListener('click', function(event) {
        if (event.target !== modal && !modal.contains(event.target)) {
            modal.style.display = 'none';
        }
    });
    
});


