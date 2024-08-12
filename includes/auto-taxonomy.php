<?php
function auto_set_default_taxonomy_term($post_id)
{
    if (get_post_type($post_id) === 'itinerary') {

        // slug de la catégorie par défaut (la catégorie parente)
        $default_term_slug = 'categorie_itineraire';

        // Récupére l'objet de la catégorie parente
        $default_term = get_term_by('slug', $default_term_slug, 'itinerary_category');

        if ($default_term) {
            $terms = wp_get_post_terms($post_id, 'itinerary_category', array('fields' => 'ids'));

            // Ajout la catégorie parente si elle n'est pas déjà assignée
            if (!in_array($default_term->term_id, $terms)) {
                $terms[] = $default_term->term_id;
                wp_set_post_terms($post_id, $terms, 'itinerary_category');
            }
        }
    }
}
add_action('save_post', 'auto_set_default_taxonomy_term');
