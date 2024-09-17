<?php
function display_itinerary_map()
{
    $points = []; // Initialisation du tableau $points
    $existingCoordinates = []; // Pour éviter les doublons de coordonnées

    $args = array(
        'post_type' => 'itinerary',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Boucle pour récupérer tous les points d'intérêt pour chaque itinéraire
            $index = 1;
            while (true) {
                $latitude = get_field('latitude_' . $index);
                $longitude = get_field('longitude_' . $index);

                // Si ni latitude ni longitude ne sont présentes, on arrête la boucle
                if (empty($latitude) && empty($longitude)) {
                    break;
                }

                // Si l'un des deux champs est vide, ignorer ce point spécifique
                if (empty($latitude) || empty($longitude)) {
                    $index++;
                    continue; // Passe au prochain index
                }

                // Convertir en nombres
                $latitude = floatval($latitude);
                $longitude = floatval($longitude);

                // Vérifier si ces coordonnées existent déjà pour éviter les doublons
                $coordinateKey = $latitude . ',' . $longitude;
                if (in_array($coordinateKey, $existingCoordinates)) {
                    $index++;
                    continue;
                }

                $existingCoordinates[] = $coordinateKey;

                $photo = get_field('photo_' . $index);
                $site_title = get_field('title-site_' . $index);

                $icon = get_field('marker_icon') ?: 'default-icon';
                $color = get_field('marker_color') ?: 'blue';

                $photo_url = is_array($photo) && isset($photo['url']) ? $photo['url'] : '';

                if ($latitude && $longitude) {
                    $points[] = [
                        'lat' => $latitude,
                        'lng' => $longitude,
                        'title' => get_the_title(),
                        'site_title' => $site_title,
                        'permalink' => get_permalink(),
                        'icon' => $icon,
                        'color' => $color,
                        'photo_url' => $photo_url,
                        'id' => get_the_ID()
                    ];
                }

                $index++;
            }
        }
        wp_reset_postdata();
    }

    ob_start();
?>
    <div id="itinerary-map"></div>

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
            // console.log("Points to be added to the map:", points);
            const allMarkers = [];

            points.forEach(function(point, index) {
                //console.log("Processing point:", point);

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
                        <img class="popup-img" src="${point.photo_url}" alt="${point.site_title}">
                        <h3 class="popup-title">${point.title}</h3>
                        <h4 class="popup-title">${point.site_title}</h4>
                        <a href="${point.permalink}" class="itinerary-link">Voir l'itinéraire</a>
                    </div>
                `);

                markers.addLayer(marker);
                allMarkers.push({
                    marker,
                    itineraryId: point.id
                });
            });

            map.addLayer(markers);

            // Vérifie si le groupe de clusters contient des marqueurs
            if (markers.getLayers().length > 0) {
                const bounds = markers.getBounds();
                if (bounds.isValid()) {
                    map.fitBounds(bounds, {
                        maxZoom: 13
                    });
                } else {
                    console.warn("Les limites calculées ne sont pas valides.");
                }
            } else {
                console.warn("Aucun marqueur valide à afficher.");
                map.setView([43.325178, 3.173081], 11.5); // Réinitialise la vue par défaut
            }

            document.querySelectorAll('.filter-map').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const itineraryId = this.getAttribute('data-itinerary-id');

                    markers.clearLayers();

                    allMarkers.forEach(function(obj) {
                        if (obj.itineraryId == itineraryId) {
                            markers.addLayer(obj.marker);
                        }
                    });

                    if (markers.getLayers().length > 0) {
                        const bounds = markers.getBounds();
                        if (bounds.isValid()) {
                            map.fitBounds(bounds, {
                                maxZoom: 13
                            });
                        } else {
                            console.warn("Les limites calculées ne sont pas valides après filtrage.");
                        }
                    } else {
                        console.warn("Aucun marqueur à afficher pour cet itinéraire.");
                    }
                });
            });

            document.querySelector('.show-all-markers').addEventListener('click', function(e) {
                e.preventDefault();

                markers.clearLayers();

                allMarkers.forEach(function(obj) {
                    markers.addLayer(obj.marker);
                });

                if (markers.getLayers().length > 0) {
                    const bounds = markers.getBounds();
                    if (bounds.isValid()) {
                        map.fitBounds(bounds, {
                            maxZoom: 12
                        });
                    } else {}
                } else {
                    map.setView([43.325178, 3.173081], 11.5);
                }
            });
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('itinerary_map', 'display_itinerary_map');



function display_itinerary_legend()
{
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
                    // Vérifie que la catégorie a un parent (catégorie enfant)
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
            // Affiche le nom de la sous-catégorie dans un h4
            echo '<h4 class="category-name">' . esc_html($category_name) . '</h4>';

            foreach ($itineraries as $itinerary) {
                if ($itinerary['color'] && $itinerary['icon']) {
        ?>
                    <li class="legend-item">
                        <span class="legend-color" style="background-color: <?php echo esc_attr($itinerary['color']); ?>;">
                            <i class="fa <?php echo esc_attr($itinerary['icon']); ?>" style="color: white;"></i>
                        </span>
                        <a href="<?php echo esc_url($itinerary['permalink']); ?>" style="color: var(--gris-ardoise);"><?php echo esc_html($itinerary['title']); ?></a>
                        <a href="#" class="filter-map legend-color-link" data-itinerary-id="<?php echo esc_attr($itinerary['post_id']); ?>" style="color: <?php echo esc_attr($itinerary['color']); ?>;"><i class="fas fa-search-location icon-site"></i></a>
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
