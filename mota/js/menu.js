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




// menuBtn.addEventListener('click', () => {
//     menuBtn.classList.remove('active-mobile');
//     menuBtn.classList.add('inactive-mobile');
//     megaMenu.classList.remove('inactive-mobile');
//     megaMenu.classList.add('active-mobile');
//     header_mobile.classList.add('header-mobile');
//     menuBtnFermeture.classList.add('active-mobile');
//     menuBtnFermeture.classList.remove('inactive-mobile');
// });

// menuBtnFermeture.addEventListener('click', () => {
//     menuBtn.classList.remove('inactive-mobile');
//     menuBtn.classList.add('active-mobile');
//     megaMenu.classList.remove('active-mobile');
//     megaMenu.classList.add('inactive-mobile');
//     header_mobile.classList.remove('header-mobile');
//     menuBtnFermeture.classList.add('inactive-mobile');
//     menuBtnFermeture.classList.remove('active-mobile');
// });