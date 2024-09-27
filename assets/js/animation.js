document.addEventListener('DOMContentLoaded', function() {
    const titles = document.querySelectorAll('.entry-title, .page-title, .post-home-title, .archive-title');
    
    // Applique la classe 'animate' à tous les titres
    titles.forEach(title => {
        title.classList.add('animate');
    });
});
