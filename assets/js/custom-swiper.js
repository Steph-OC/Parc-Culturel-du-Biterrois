document.addEventListener('DOMContentLoaded', function () {
    
   // Carrousel des articles
const coverflowSwiper = new Swiper('.coverflow-carousel', {
    loop: true,
    autoplay: {
        delay: 7000,
        disableOnInteraction: false,
    },
    effect: 'coverflow',
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    slidesPerView: 'auto', // Affiche automatiquement en fonction de la taille
    centeredSlides: true,
    pagination: {
        el: '.swiper-pagination-coverflow',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next-coverflow',
        prevEl: '.swiper-button-prev-coverflow',
    },
    breakpoints: {
        1084: { // Pour les tablettes et plus grands écrans
            slidesPerView: 2, // Nombre de slides à afficher
            spaceBetween: 30, // Espace entre les slides
        },
        768: { // Pour les tablettes
            slidesPerView: 1.5,
            spaceBetween: 20,
        },
        480: { // Pour les mobiles
            slidesPerView: 1,
            spaceBetween: 10,
            coverflowEffect: {
                rotate: 30, // Réduire la rotation pour les petits écrans
                stretch: 10,
                depth: 50,
                modifier: 1,
                slideShadows: false,
            },
        }
    }
});  

}); 
