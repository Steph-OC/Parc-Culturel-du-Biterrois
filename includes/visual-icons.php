<?php
function my_acf_icon_picker_script()
{
?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const selectField = document.querySelector('select[name="acf[field_66b8eabd064f8]"]');

    if (selectField) {
        const iconPicker = document.createElement('div');
        iconPicker.classList.add('icon-picker');

        const icons = {
            'fa-home': 'Maison',
            'fa-info-circle': 'Information',
            'fa-star': 'Étoile',
            'fa-flag': 'Drapeau',
            'fa-heart': 'Cœur',
            'fa-history': 'Histoire',
            'fa-map-signs': 'Panneaux',
            'fa-university': 'Université',
            // Ajoutez d'autres icônes ici
        };

        for (const [iconClass, label] of Object.entries(icons)) {
            const iconOption = document.createElement('div');
            iconOption.classList.add('icon-option');
            iconOption.innerHTML = `<i class="fa ${iconClass}"></i><br>${label}`;
            iconOption.dataset.value = iconClass;

            iconOption.addEventListener('click', function() {
                selectField.value = iconClass;
                console.log('Icone sélectionnée:', iconClass); // Pour vérifier la sélection
                document.querySelectorAll('.icon-option').forEach(el => el.classList.remove('selected'));
                iconOption.classList.add('selected');
            });

            iconPicker.appendChild(iconOption);
        }

        selectField.style.display = 'none'; // Cachez la liste déroulante
        selectField.parentElement.appendChild(iconPicker);

        // Sélectionner l'icône par défaut si elle existe
        const currentValue = selectField.value;
        if (currentValue) {
            const currentIcon = iconPicker.querySelector(`.icon-option[data-value="${currentValue}"]`);
            if (currentIcon) {
                currentIcon.classList.add('selected');
            }
        }
    } else {
        console.error('Le champ de sélection d\'icône est introuvable.');
    }
});

    </script>

<?php
}
add_action('acf/input/admin_footer', 'my_acf_icon_picker_script');
