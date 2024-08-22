<?php
function add_dynamic_site_fields_script() {
    global $pagenow, $post;

    // Vérifier si nous sommes sur l'écran d'édition d'un itinéraire
    if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        if (get_post_type($post) == 'itinerary') {
            ?>
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    const maxSites = 10; // Nombre maximum de sites
                    let currentSiteIndex = 1;

                    // Fonction pour afficher les champs qui sont remplis
                    function showFilledSiteFields() {
                        for (let i = 1; i <= maxSites; i++) {
                            let fields = document.querySelectorAll(`[data-name*="_${i}"]`);
                            let isFilled = false;

                            fields.forEach(field => {
                                const input = field.querySelector('input, textarea, select');
                                if (input && input.value) {
                                    isFilled = true;
                                }
                            });

                            if (isFilled) {
                                fields.forEach(field => field.style.display = 'block');
                                currentSiteIndex = i; // Mettre à jour l'index courant
                            } else {
                                fields.forEach(field => field.style.display = 'none');
                            }
                        }
                    }

                    // Fonction pour afficher l'ensemble des champs pour le prochain site
                    function showNextSiteFields() {
                        if (currentSiteIndex < maxSites) {
                            currentSiteIndex++;
                            let fields = document.querySelectorAll(`[data-name*="_${currentSiteIndex}"]`);
                            fields.forEach(field => field.style.display = 'block');
                        }
                    }

                    // Afficher tous les champs déjà remplis
                    showFilledSiteFields();

                    // Trouver tous les conteneurs des champs de site
                    const fieldsContainers = document.querySelectorAll('.inside.acf-fields.-top > .acf-field[data-name*="title-site"]');

                    if (fieldsContainers.length > 0) {
                        // Créer le bouton
                        const addButton = document.createElement('button');
                        addButton.type = 'button';
                        addButton.style.marginTop = '10px';
                        addButton.textContent = 'Ajouter un autre site';

                        // Ajouter le bouton après le dernier champ de site
                        const lastContainer = fieldsContainers[fieldsContainers.length - 1];
                        lastContainer.insertAdjacentElement('afterend', addButton);

                        addButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            showNextSiteFields();

                            // Déplacer le bouton à la fin des nouveaux champs
                            const updatedFieldsContainers = document.querySelectorAll('.inside.acf-fields.-top > .acf-field[data-name*="title-site"]');
                            const newLastContainer = updatedFieldsContainers[updatedFieldsContainers.length - 1];
                            newLastContainer.insertAdjacentElement('afterend', addButton);
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
