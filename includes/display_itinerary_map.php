<?php
function display_itinerary_map() {
    $points = []; // Initialisation du tableau $points

    $args = array(
        'post_type' => 'itinerary', 
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $latitude = get_field('latitude');
            $longitude = get_field('longitude');
            $icon = get_field('marker_icon'); // Récupère l'icône pour cet itinéraire
            $photo = get_field('photo');
            $title = get_the_title();
            $permalink = get_permalink();
            $categories = get_the_terms(get_the_ID(), 'itinerary_category'); // Récupère les catégories associées

            if ($latitude && $longitude && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $category_name = $category->name;
                    $category_color = get_field('marker_color', 'itinerary_category_' . $category->term_id); // Récupère la couleur de la catégorie

                    $points[] = [
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'title' => $title,
                        'permalink' => $permalink,
                        'icon' => $icon, // Utilise l'icône de l'itinéraire
                        'color' => $category_color, // Utilise la couleur de la catégorie
                        'photo_url' => $photo ? $photo['url'] : '',
                        'categories' => $category_name,
                    ];
                }
            }
        }
        wp_reset_postdata();
    }

    ob_start();
    ?>
    <div id="itinerary-map" style="width: 100%; height: 600px;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('itinerary-map').setView([43.298373, 3.109855], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var points = <?php echo json_encode($points); ?>;
            points.forEach(function(point) {
                var markerIcon = L.divIcon({
                    className: `awesome-marker awesome-marker-icon-${point.color}`,
                    html: `<i class="fa fa-${point.icon} icon-white"></i>`,
                    iconSize: [35, 46],
                    iconAnchor: [17.5, 46],
                    popupAnchor: [0, -46]
                });

                var marker = L.marker([point.lat, point.lng], { icon: markerIcon }).addTo(map);

                var popupContent = `
                    <div style="text-align: center;">
                        <img src="${point.photo_url}" alt="${point.title};">
                        <h3 class="popup-title">${point.title}</h3>
                        <a href="${point.permalink}" class="itinerary-link">En savoir plus</a>
                    </div>
                `;

                marker.bindPopup(popupContent);
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('itinerary_map', 'display_itinerary_map');

function display_itinerary_legend() {
    $parent_category = get_term_by('name', 'Catégorie d\'itinéraire', 'itinerary_category');
    
    if (!$parent_category) {
        return '<p>Catégorie parent non trouvée.</p>';
    }

    $child_categories = get_terms(array(
        'taxonomy' => 'itinerary_category',
        'child_of' => $parent_category->term_id,
        'hide_empty' => false,
    ));

    ob_start();
    ?>
    <ul>
        <?php
        foreach ($child_categories as $category) {
            $category_name = $category->name;
            $category_color = get_field('marker_color', 'itinerary_category_' . $category->term_id); // Récupère la couleur de la catégorie

            echo '<li class="legend-item">';
            echo '<span class="legend-color" style="background-color: ' . esc_attr($category_color) . ';"></span>';
            echo esc_html($category_name);
            echo '</li>';
        }
        ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('itinerary_legend', 'display_itinerary_legend');

