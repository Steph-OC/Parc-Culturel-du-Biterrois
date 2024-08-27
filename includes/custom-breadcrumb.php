<?php
//fil d'ariane
function my_custom_breadcrumb()
{
    echo '<nav class="breadcrumb">';

    echo '<a href="' . home_url() . '"><i class="fas fa-home"></i></a>';

    if (is_home() || is_front_page()) {
        echo ' &gt; Accueil';
    } elseif (is_category()) {
        echo ' &gt; ' . single_cat_title('', false);
    } elseif (is_singular('post')) {
        echo ' &gt; <a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Blog</a>';
        echo ' &gt; ' . get_the_title();
    } elseif (is_singular('page')) {
        echo ' &gt; ' . get_the_title();
    } elseif (is_singular('itinerary')) {
        echo ' &gt; <a href="' . esc_url(home_url('/itineraire-de-decouverte/')) . '">Itinéraire de découverte</a>';
        echo ' &gt; ' . get_the_title();
    } elseif (is_tag()) {
        echo ' &gt; ' . single_tag_title('', false);
    } elseif (is_search()) {
        echo ' &gt; Résultats de recherche pour "' . get_search_query() . '"';
    } elseif (is_404()) {
        echo ' &gt; Page non trouvée';
    }

    echo '</nav>';
}
