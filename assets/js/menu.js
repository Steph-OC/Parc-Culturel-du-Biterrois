document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.navbar-burger');
    const menu = document.querySelector('.navbar-menu');
    const body = document.querySelector('body');

    // Fonction pour ouvrir/fermer le menu
    function toggleMenu() {
        burger.classList.toggle('is-active');
        menu.classList.toggle('is-active');
    }

    // Lorsque l'on clique sur le burger
    burger.addEventListener('click', function () {
        toggleMenu();
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener('click', function (event) {
        const isClickInsideMenu = menu.contains(event.target);
        const isClickInsideBurger = burger.contains(event.target);

        // Si le clic n'est ni dans le menu ni sur le burger, fermer le menu
        if (!isClickInsideMenu && !isClickInsideBurger && menu.classList.contains('is-active')) {
            toggleMenu();
        }
    });
});
