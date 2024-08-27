<?php
function kadence_child_enqueue_assets()
{
  // Enqueue the parent and child theme styles
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));

  // Enqueue Font Awesome (kit)
  wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/277d797764.js', array(), null, true);

  // Enqueue Swiper CSS and JS
  wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
  wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);

  // Enqueue Leaflet CSS and JS
  wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
  wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), null, true);

  // Enqueue Leaflet Awesome Markers CSS and JS
  wp_enqueue_style('leaflet-awesome-markers-css', 'https://cdn.jsdelivr.net/npm/leaflet.awesome-markers@2.0.5/dist/leaflet.awesome-markers.css');
  wp_enqueue_script('leaflet-awesome-markers-js', 'https://cdn.jsdelivr.net/npm/leaflet.awesome-markers@2.0.5/dist/leaflet.awesome-markers.js', array('leaflet-js'), null, true);

  // Enqueue Leaflet.markercluster
  wp_enqueue_style('leaflet-markercluster-css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');
  wp_enqueue_style('leaflet-markercluster-default-css', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');
  wp_enqueue_script('leaflet-markercluster-js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array('leaflet-js'), null, true);

  // Enqueue custom JavaScript
  wp_enqueue_script('custom-swiper', get_stylesheet_directory_uri() . '/assets/js/custom-swiper.js', array('swiper-js'), null, true);
  wp_enqueue_script('menu-js', get_stylesheet_directory_uri() . '/assets/js/menu.js', array(), null, true);
  wp_enqueue_script('banner-js', get_stylesheet_directory_uri() . '/assets/js/banner.js', array(), null, true);
}

add_action('wp_enqueue_scripts', 'kadence_child_enqueue_assets');

// Inclure les fichiers de fonctions
require_once get_stylesheet_directory() . '/includes/remove-parent-functions.php';
require_once get_stylesheet_directory() . '/includes/customizer.php';
require_once get_stylesheet_directory() . '/includes/register-menus.php';
require_once get_stylesheet_directory() . '/includes/itinerary-cpt.php';
require_once get_stylesheet_directory() . '/includes/display_itinerary_map.php';
require_once get_stylesheet_directory() . '/includes/auto-taxonomy.php';
require_once get_stylesheet_directory() . '/includes/link-clic-acf.php';
require_once get_stylesheet_directory() . '/includes/dynamic-fields.php';
require_once get_stylesheet_directory() . '/includes/custom-breadcrumb.php';
require_once get_stylesheet_directory() . '/includes/parallax-featured-image.php';
