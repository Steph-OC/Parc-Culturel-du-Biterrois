document.addEventListener('DOMContentLoaded', function() {
    function adjustMapHeight() {
        const legendColumn = document.querySelector('.legend-column'); 
        const mapColumn = document.querySelector('#itinerary-map'); 

        if (legendColumn && mapColumn) {
            let legendHeight = legendColumn.offsetHeight;
            mapColumn.style.height = legendHeight + 'px';
        }
    }

    // Ajuste la hauteur au chargement
    adjustMapHeight();

    // Ajuste la hauteur lors du redimensionnement de la fenêtre
    window.addEventListener('resize', adjustMapHeight);
});
