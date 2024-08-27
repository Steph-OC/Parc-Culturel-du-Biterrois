document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.querySelector('.navbar-menu');

    burger.addEventListener('click', function() {
        burger.classList.toggle('is-active');
        menu.classList.toggle('is-active');

        // Mise à jour du style pour le menu
        if (menu.classList.contains('is-active')) {
            menu.style.display = 'flex';
            menu.style.left = '0';
        } else {
            menu.style.display = '';
            menu.style.left = '';
        }
    });
});