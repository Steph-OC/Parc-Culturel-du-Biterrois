document.addEventListener('DOMContentLoaded', function() {
    const elem = document.querySelector('.banner-grid');
    const msnry = new Masonry(elem, {
        itemSelector: '.banner-item',
        columnWidth: '.banner-item',
        percentPosition: true
    });

    imagesLoaded(elem, function() {
        msnry.layout();
    });
});
