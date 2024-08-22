<?php
function display_itinerary_map() {
    $points = []; // Initialisation du tableau $points

    $args = array(
        'post_type' => 'itinerary', // Utilisation du type de publication correct
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Boucle pour récupérer tous les points d'intérêt pour chaque itinéraire
            $index = 1;
            while ($latitude = get_field('latitude_' . $index)) {
                $longitude = get_field('longitude_' . $index);
                $photo = get_field('photo_' . $index);
                $site_title = get_field('title-site_' . $index); // Titre spécifique du site

                // Récupération des champs ACF pour les icônes et les couleurs
                $icon = get_field('marker_icon');
                $color = get_field('marker_color');

                // Si les valeurs sont vides, définir des valeurs par défaut
                $icon = $icon ?: 'default-icon';
                $color = $color ?: 'blue';

                if ($latitude && $longitude) {
                    $points[] = [
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'title' => get_the_title(),
                        'site_title' => $site_title, // Titre spécifique au site
                        'permalink' => get_permalink(),
                        'icon' => $icon, // Icône du marqueur
                        'color' => $color, // Couleur du marqueur
                        'photo_url' => $photo ? $photo['url'] : '',
                        'id' => get_the_ID() // Ajout de l'ID du post pour le filtrage
                    ];
                }
                $index++;
            }
        }
        wp_reset_postdata();
    }

    ob_start();
    ?>
    <div id="itinerary-map" style="width: 100%; height: 600px;"></div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('itinerary-map').setView([43.325178, 3.173081], 11.5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const markers = L.markerClusterGroup({
        maxClusterRadius: 10,
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

    const points = <?php echo json_encode(array_values($points)); ?>;
    const allMarkers = []; // Pour garder une trace de tous les marqueurs

    if (points.length === 0) {
        console.warn("Aucun point à afficher sur la carte.");
    }

    points.forEach(function(point, index) {
        if (!point.color || !point.icon) {
            console.warn(`Le point ${index + 1}: ${point.title} n'a pas d'icône ou de couleur définie, il ne sera pas affiché.`);
            return;
        }

        const markerIcon = L.AwesomeMarkers.icon({
            icon: point.icon,
            markerColor: point.color,
            prefix: 'fa',
            iconColor: 'white'
        });

        const marker = L.marker([point.lat, point.lng], {
            icon: markerIcon
        }).bindPopup(`
            <div style="text-align: center;">
                <img src="${point.photo_url}" alt="${point.site_title}" style="width:100%; height:auto;">
                <h3 class="popup-title">${point.title}</h3>
                <h4 class="popup-title">${point.site_title}</h4>
                <a href="${point.permalink}" class="itinerary-link">Voir l'itinéraire</a>
            </div>
        `);

        markers.addLayer(marker);
        allMarkers.push({marker, itineraryId: point.id}); // Ajouter à la liste des marqueurs avec l'ID de l'itinéraire
    });

    map.addLayer(markers);

    // Fonction pour filtrer les marqueurs par itinéraire
    document.querySelectorAll('.filter-map').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const itineraryId = this.getAttribute('data-itinerary-id');

            // Retirer tous les marqueurs du groupe de clusters
            markers.clearLayers();

            // Ajouter uniquement les marqueurs correspondant à l'itinéraire sélectionné
            allMarkers.forEach(function(obj) {
                if (obj.itineraryId == itineraryId) {
                    markers.addLayer(obj.marker);
                }
            });

            // Ajuster la vue sans zoomer au-delà d'un certain niveau
            const bounds = markers.getBounds();
            map.fitBounds(bounds, {
                maxZoom: 13 // Limite le niveau de zoom maximum
            });
        });
    });

    // Fonction pour afficher tous les marqueurs
    document.querySelector('.show-all-markers').addEventListener('click', function(e) {
        e.preventDefault();

        // Retirer tous les marqueurs du groupe de clusters
        markers.clearLayers();

        // Réajouter tous les marqueurs
        allMarkers.forEach(function(obj) {
            markers.addLayer(obj.marker);
        });

        // Ajuster la vue pour afficher tous les marqueurs
        const bounds = markers.getBounds();
        map.fitBounds(bounds, {
            maxZoom: 12 // Retour à un zoom par défaut
        });
    });
});

    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('itinerary_map', 'display_itinerary_map');


function display_itinerary_legend() {
    $args = array(
        'post_type' => 'itinerary',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    // Tableau pour stocker les itinéraires par catégorie
    $itineraries_by_category = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $categories = get_the_terms(get_the_ID(), 'itinerary_category');
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    // Vérifier que la catégorie a un parent (catégorie enfant)
                    if ($category->parent != 0) {
                        $itineraries_by_category[$category->name][] = array(
                            'title' => get_the_title(),
                            'permalink' => get_permalink(),
                            'icon' => get_field('marker_icon'),
                            'color' => get_field('marker_color'),
                            'post_id' => get_the_ID()
                        );
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    ob_start();
    ?>

    <ul class="itinerary-legend">
        <?php
        foreach ($itineraries_by_category as $category_name => $itineraries) {
            // Afficher le nom de la sous-catégorie dans un h4
            echo '<h4 class="category-name">' . esc_html($category_name) . '</h4>';

            foreach ($itineraries as $itinerary) {
                if ($itinerary['color'] && $itinerary['icon']) {
                    ?>
                    <li class="legend-item">
                        <span class="legend-color" style="background-color: <?php echo esc_attr($itinerary['color']); ?>;">
                            <i class="fa <?php echo esc_attr($itinerary['icon']); ?>" style="color: white;"></i>
                        </span>
                        <a href="<?php echo esc_url($itinerary['permalink']); ?>" style="color: var(--gris-ardoise);"><?php echo esc_html($itinerary['title']); ?></a>
                        <a href="#" class="filter-map legend-color-link" data-itinerary-id="<?php echo esc_attr($itinerary['post_id']); ?>" style="color: <?php echo esc_attr($itinerary['color']); ?>;"><i class="fas fa-search-location"></i> Voir sur la carte</a>
                    </li>
                    <?php
                }
            }
        }
        ?>
    </ul>
    <a href="#" class="show-all-markers" style="display: block; margin-top: 20px;">Voir tous les sites</a>

    <?php
    return ob_get_clean();
}
add_shortcode('itinerary_legend', 'display_itinerary_legend');