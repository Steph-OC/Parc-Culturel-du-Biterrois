<?php
function display_itinerary_map()
{
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
            const map = L.map('itinerary-map').setView([43.285303, 3.085803], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialiser le groupe de clusters avec personnalisation
            const markers = L.markerClusterGroup({
                maxClusterRadius: 150, // distance de regroupement
                iconCreateFunction: function(cluster) {
                    const childCount = cluster.getChildCount();

                    let c = ' marker-cluster-';

                    if (childCount < 10) {
                        c += 'small';
                    } else if (childCount < 100) {
                        c += 'medium';
                    } else {
                        c += 'large';
                    }

                    return new L.DivIcon({
                        html: '<div><span>' + childCount + '</span></div>',
                        className: 'marker-cluster' + c,
                        iconSize: new L.Point(40, 40)
                    });
                }
            });

            const points = <?php echo json_encode($points); ?>;
            points.forEach(function(point) {
                // Ignorer les points avec une couleur null
                if (!point.color) {
                    return;
                }

                const markerIcon = L.AwesomeMarkers.icon({
                    icon: point.icon, // Utilise l'icône définie pour l'itinéraire
                    markerColor: point.color, // Utilise la couleur définie pour la catégorie
                    prefix: 'fa',
                    iconColor: 'white'
                });

                const marker = L.marker([point.lat, point.lng], {
                    icon: markerIcon
                });

                const popupContent = `
            <div style="text-align: center;">
                <img src="${point.photo_url}" alt="${point.title}" style="width:100%; height:auto;">
                <h3 class="popup-title">${point.title}</h3>
                <a href="${point.permalink}" class="itinerary-link">Voir l'itinéraire</a>
            </div>`;

                marker.bindPopup(popupContent);

                // Ajout le marqueur au groupe de clusters
                markers.addLayer(marker);
            });

            // Ajouter le groupe de clusters à la carte
            map.addLayer(markers);
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('itinerary_map', 'display_itinerary_map');

function display_itinerary_legend()
{
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
