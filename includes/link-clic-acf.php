<?php
//lien dans les post itineraires et site pour le site latlong.net
function make_acf_instructions_link_clickable($field)
{
    if ($field['name'] == 'latitude') {
        $field['instructions'] .= '<br/><a href="https://www.latlong.net/" target="_blank">Trouver les coordonnées GPS sur LatLong.net</a>';
    }
    return $field;
}
add_filter('acf/load_field/name=latitude', 'make_acf_instructions_link_clickable');
add_filter('acf/load_field/name=longitude', 'make_acf_instructions_link_clickable');
