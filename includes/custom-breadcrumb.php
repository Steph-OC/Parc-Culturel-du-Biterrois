<?php
function my_custom_breadcrumb() {
    echo '<nav id="breadcrumb" class="breadcrumb">';

    // Lien vers la page d'accueil
    echo '<a href="' . home_url() . '"><i class="fas fa-home"></i></a>';

    // Si on est sur la page d'accueil ou la page d'accueil du blog
    if (is_front_page()) {
        echo ' &gt; Accueil';
    } elseif (is_home()) {
        echo ' &gt; Actualités';
    } 
    // Si on est sur une page de catégorie
    elseif (is_category()) {
        echo ' &gt; <a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Actualité</a>';
        echo ' &gt; ' . single_cat_title('', false);
    } 
    // Si on est sur un article de blog
    elseif (is_singular('post')) {
        echo ' &gt; <a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Actualité</a>';
        echo ' &gt; ' . get_the_title();
    } 
    // Si on est sur une page standard
    elseif (is_singular('page')) {
        echo ' &gt; ' . get_the_title();
    } 
    // Si on est sur une page d'itinéraire
    elseif (is_singular('itinerary')) {
        echo ' &gt; <a href="' . esc_url(home_url('/itineraire-de-decouverte/')) . '">Itinéraire de découverte</a>';
        echo ' &gt; ' . get_the_title();
    } 
    // Si on est sur une page d'étiquette
    elseif (is_tag()) {
        echo ' &gt; ' . single_tag_title('', false);
    } 
    // Si on est sur une page de résultats de recherche
    elseif (is_search()) {
        echo ' &gt; Résultats de recherche pour "' . get_search_query() . '"';
    } 
    // Si on est sur une page d'archive par date (mois ou année)
    elseif (is_date()) {
        echo ' &gt; <a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Actualité</a>';
        echo ' &gt; Archives pour ' . get_the_date('F Y');
    } 
    // Si on est sur une page 404
    elseif (is_404()) {
        echo ' &gt; Page non trouvée';
    }

    echo '</nav>';
}
