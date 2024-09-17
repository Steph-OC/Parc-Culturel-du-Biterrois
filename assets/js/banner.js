document.addEventListener('DOMContentLoaded', function() {
    // Configuration du swiper pour les mobiles uniquement
    if (window.innerWidth <= 768) { 
        const swiper = new Swiper('.swiper-container', {
            effect: 'cards',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            cardsEffect: {
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        // Gérer le clic sur les diapositives
        document.querySelectorAll('.swiper-slide').forEach(function(slide) {
            slide.addEventListener('click', function() {
                slide.classList.toggle('active');
            });
        });
    }
  
    });     