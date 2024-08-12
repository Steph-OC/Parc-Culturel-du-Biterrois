<?php
function mytheme_customize_register($wp_customize) {
      // Ajout section pour la bannière
    $wp_customize->add_section('mytheme_banner_section', array(
        'title' => __('Bannière', 'mytheme'),
        'priority' => 30,
        'description' => 'Téléverser les images et les titres pour la bannière.',
    ));

    // Ajout plusieurs paramètres pour les images de la bannière
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("mytheme_banner_image_$i", array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "mytheme_banner_image_$i", array(
            'label' => __("Image $i", 'mytheme'),
            'section' => 'mytheme_banner_section',
            'settings' => "mytheme_banner_image_$i",
        )));

        $wp_customize->add_setting("mytheme_banner_text_title_$i", array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control("mytheme_banner_text_title_$i", array(
            'label' => __("Titre de l'image $i", 'mytheme'),
            'section' => 'mytheme_banner_section',
            'settings' => "mytheme_banner_text_title_$i",
            'type' => 'text'
        ));
    }

}
add_action('customize_register', 'mytheme_customize_register');
