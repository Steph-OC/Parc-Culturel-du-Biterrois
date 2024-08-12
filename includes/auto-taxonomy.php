<?php
function auto_set_default_taxonomy_term($post_id) {
    // Vérifiez que c'est bien un type de post 'itinerary'
    if (get_post_type($post_id) === 'itinerary') {

        // Définir le slug de la catégorie par défaut (la catégorie parente)
        $default_term_slug = 'categorie_itineraire'; // Remplacez par le slug de votre catégorie parente "Catégorie d'itinéraire"

        // Récupérer l'objet de la catégorie parente
        $default_term = get_term_by('slug', $default_term_slug, 'itinerary_category');

        // Vérifier que la catégorie existe
        if ($default_term) {
            // Récupérer les termes actuels assignés à l'article
            $terms = wp_get_post_terms($post_id, 'itinerary_category', array('fields' => 'ids'));

            // Ajouter la catégorie parente si elle n'est pas déjà assignée
            if (!in_array($default_term->term_id, $terms)) {
                $terms[] = $default_term->term_id;
                wp_set_post_terms($post_id, $terms, 'itinerary_category');
            }
        }
    }
}
add_action('save_post', 'auto_set_default_taxonomy_term');
