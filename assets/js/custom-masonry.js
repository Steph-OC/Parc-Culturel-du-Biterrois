document.addEventListener('DOMContentLoaded', function() {
    var elem = document.querySelector('.banner-grid');
    var msnry = new Masonry(elem, {
        itemSelector: '.banner-item',
        columnWidth: '.banner-item',
        percentPosition: true
    });

    imagesLoaded(elem, function() {
        msnry.layout();
    });
});
