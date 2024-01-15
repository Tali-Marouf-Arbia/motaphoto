document.addEventListener('DOMContentLoaded', function () {
    // Variables pour suivre l'index actuel
    var currentIndex = 0;
    var totalPhotos = customScriptData.totalPhotos;

    // Fonction pour mettre à jour l'affichage en fonction de l'index actuel
    function updatePhotoDisplay() {
        // Masquer toutes les photos miniatures
        var allPhotos = document.querySelectorAll('.miniature-container');
        allPhotos.forEach(function (photo) {
            photo.style.display = 'none';
        });

     }

    // Gestionnaire de clic pour la flèche droite
    document.querySelector('.arrow-right').addEventListener('click', function () {
        // Incrémenter l'index et ajuster au besoin pour boucler
        currentIndex = (currentIndex + 1) % totalPhotos;
        updatePhotoDisplay();
    });

    // Gestionnaire de clic pour la flèche gauche
    document.querySelector('.arrow-left').addEventListener('click', function () {
        // Décrémenter l'index et ajuster au besoin pour boucler
        currentIndex = (currentIndex - 1 + totalPhotos) % totalPhotos;
        updatePhotoDisplay();
    });
});
