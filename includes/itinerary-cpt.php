<?php
function register_itinerary_cpt() {
    $labels = array(
        'name' => __('Itinéraires et Sites', 'textdomain'),
        'singular_name' => __('Itinéraire ou Site', 'textdomain'),
        'menu_name' => __('Itinéraires et Sites', 'textdomain'),
        'all_items' => __('Tous les itinéraires et sites', 'textdomain'),
        'add_new' => __('Ajouter un itinéraire ou site', 'textdomain'),
        'add_new_item' => __('Ajouter un nouvel itinéraire ou site', 'textdomain'),
        'edit_item' => __('Modifier l\'itinéraire ou site', 'textdomain'),
        'new_item' => __('Nouvel itinéraire ou site', 'textdomain'),
        'view_item' => __('Voir l\'itinéraire ou site', 'textdomain'),
        'search_items' => __('Rechercher des itinéraires ou sites', 'textdomain'),
        'not_found' => __('Aucun itinéraire ou site trouvé', 'textdomain'),
        'not_found_in_trash' => __('Aucun itinéraire ou site trouvé dans la corbeille', 'textdomain'),
    );

    $args = array(
        'label' => __('Itinéraire ou Site', 'textdomain'),
        'description' => __('Itinéraires de découverte et sites d\'intérêt', 'textdomain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location-alt',
        'has_archive' => true,
       'rewrite' => array(
            'slug' => 'itineraires-de-decouverte',
            'with_front' => false
        ),
        'show_in_rest' => true, // Important pour l'éditeur Gutenberg
        'taxonomies' => array('itinerary_category'), // Associe la taxonomie
    );

    register_post_type('itinerary', $args);
}
add_action('init', 'register_itinerary_cpt');

function register_itinerary_taxonomy() {
    $labels = array(
        'name' => _x('Catégories d\'itinéraires et sites', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Catégorie d\'itinéraire ou site', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Rechercher des catégories', 'textdomain'),
        'all_items' => __('Toutes les catégories', 'textdomain'),
        'parent_item' => __('Catégorie parente', 'textdomain'),
        'parent_item_colon' => __('Catégorie parente :', 'textdomain'),
        'edit_item' => __('Modifier la catégorie', 'textdomain'),
        'update_item' => __('Mettre à jour la catégorie', 'textdomain'),
        'add_new_item' => __('Ajouter une nouvelle catégorie', 'textdomain'),
        'new_item_name' => __('Nom de la nouvelle catégorie', 'textdomain'),
        'menu_name' => __('Catégories', 'textdomain'),
    );

    $args = array(
        'hierarchical' => true, // Comme les catégories
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'categorie-itineraires-sites'),
        'show_in_rest' => true, // Important pour l'éditeur Gutenberg
    );

    register_taxonomy('itinerary_category', array('itinerary'), $args);
}
add_action('init', 'register_itinerary_taxonomy');
