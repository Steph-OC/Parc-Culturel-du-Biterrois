document.addEventListener("DOMContentLoaded", function() {
    // Vérifie si on est sur la page d'accueil (ne pas activer le défilement)
    if (!document.body.classList.contains('home')) {
        const breadcrumb = document.getElementById('breadcrumb');
        if (breadcrumb) {
            breadcrumb.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
});
