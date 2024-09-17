<?php
function add_dynamic_site_fields_script()
{
    global $pagenow, $post;

    // Vérifie si nous sommes sur l'écran d'édition d'un itinéraire
    if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        if (get_post_type($post) == 'itinerary') {
?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    const maxSites = 10; // Nombre maximum de sites
                    let currentSiteIndex = 1;

                    // Fonction pour afficher les champs du marqueur (couleur et icône) en premier
                    function showMarkerFields() {
                        const markerFields = document.querySelectorAll(`[data-name="marker_color"], [data-name="marker_icon"]`);
                        markerFields.forEach(field => {
                            field.style.display = 'block';
                            field.style.backgroundColor = '#eef5ff';
                            field.style.borderBottom = '1px solid #ddd';
                            field.style.padding = '10px';
                            field.style.marginBottom = '10px';
                        });
                    }

                    // Fonction pour afficher les autres champs qui sont remplis ou le premier groupe de champs par défaut
                    function showFilledOrFirstSiteFields() {
                        let firstFieldDisplayed = false;

                        for (let i = 1; i <= maxSites; i++) {
                            let fields = document.querySelectorAll(`[data-name="title-site_${i}"], [data-name="photo_${i}"], [data-name="longitude_${i}"], [data-name="latitude_${i}"]`);

                            if (!fields.length) {
                                console.warn(`Aucun champ trouvé pour l'index ${i}.`);
                                continue;
                            }

                            let isFilled = false;

                            fields.forEach(field => {
                                const input = field.querySelector('input, textarea, select');
                                if (input && input.value.trim() !== '') {
                                    isFilled = true;
                                }
                            });

                            if (isFilled || i === 1) { // Toujours afficher le premier groupe de champs par défaut
                                fields.forEach(field => {
                                    field.style.display = 'block';
                                    field.style.backgroundColor = (i % 2 === 0) ? '#ffffff' : '#eef5ff';
                                    field.style.borderBottom = '1px solid #ddd';
                                    field.style.padding = '10px';
                                    field.style.marginBottom = '10px';
                                });
                                currentSiteIndex = i; // mise à jour l'index courant
                                firstFieldDisplayed = true; // Assure que le premier champ est affiché
                            } else {
                                fields.forEach(field => field.style.display = 'none');
                            }
                        }
                    }

                    // Fonction pour afficher l'ensemble des champs pour le prochain site
                    function showNextSiteFields() {
                        if (currentSiteIndex < maxSites) {
                            currentSiteIndex++;
                            let fields = document.querySelectorAll(`[data-name="title-site_${currentSiteIndex}"], [data-name="photo_${currentSiteIndex}"], [data-name="longitude_${currentSiteIndex}"], [data-name="latitude_${currentSiteIndex}"]`);
                            if (!fields.length) {
                                console.warn(`Aucun champ trouvé pour l'index ${currentSiteIndex}.`);
                                return;
                            }

                            fields.forEach(field => {
                                field.style.display = 'block';
                                field.style.backgroundColor = (currentSiteIndex % 2 === 0) ? '#f9f9f9' : '#ffffff';
                                field.style.borderBottom = '1px solid #ddd';
                                field.style.padding = '10px';
                                field.style.marginBottom = '10px';
                            });
                        } else {
                            console.warn('Nombre maximum de sites atteints.');
                        }
                    }

                    // Affiche les champs de marqueur en premier
                    showMarkerFields();

                    // Affiche tous les champs déjà remplis ou le premier groupe de champs par défaut
                    showFilledOrFirstSiteFields();

                    // Trouve tous les conteneurs des champs de site
                    const fieldsContainers = document.querySelectorAll('.inside.acf-fields.-top > .acf-field[data-name*="title-site"]');

                    if (fieldsContainers.length > 0) {
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.style.marginTop = '10px';
                        addButton.textContent = 'Ajouter un autre site';

                        const lastContainer = fieldsContainers[fieldsContainers.length - 1];
                        if (lastContainer) {
                            lastContainer.insertAdjacentElement('afterend', addButton);
                        } else {
                            console.error('Impossible de trouver le dernier conteneur de champs pour ajouter le bouton.');
                        }

                        addButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            showNextSiteFields();

                            const updatedFieldsContainers = document.querySelectorAll('.inside.acf-fields.-top > .acf-field[data-name*="title-site"]');
                            const newLastContainer = updatedFieldsContainers[updatedFieldsContainers.length - 1];
                            if (newLastContainer) {
                                newLastContainer.insertAdjacentElement('afterend', addButton);
                            } else {
                                console.error('Impossible de trouver le nouveau dernier conteneur de champs après mise à jour.');
                            }
                        });
                    } else {
                        console.error('Conteneur des champs de site introuvable.');
                    }
                });
            </script>
<?php
        }
    }
}
add_action('admin_footer', 'add_dynamic_site_fields_script');
?>