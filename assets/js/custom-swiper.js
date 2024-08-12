document.addEventListener('DOMContentLoaded', function () {
    // Carrousel de la bannière
    const bannerSwiper = new Swiper('.banner-carousel', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        speed: 5000,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.swiper-pagination-banner',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next-banner',
            prevEl: '.swiper-button-prev-banner',
        },
    });

    // Carrousel des articles
    const coverflowSwiper = new Swiper('.coverflow-carousel', {
        loop: true,
        autoplay: {
            delay: 3000,
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
        slidesPerView: 'auto', // 'auto' et mini 4 slides
        centeredSlides: true,
        pagination: {
            el: '.swiper-pagination-coverflow',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next-coverflow',
            prevEl: '.swiper-button-prev-coverflow',
        },
    });
});


