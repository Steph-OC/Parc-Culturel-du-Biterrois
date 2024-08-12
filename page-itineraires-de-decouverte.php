<?php
/*
Plugin Name: Custom Gutenberg Justify
Description: Ajoute une option de style de justification de texte à l'éditeur Gutenberg.
Version: 1.0
Author: Votre Nom
*/

// Enqueue script and styles for the custom block style
function add_justify_block_style() {
    // Enqueue the script for the custom block style
    wp_enqueue_script(
        'custom-justify-button',
        plugins_url( 'custom-justify-button.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-edit-post' ),
        true
    );

    // Enqueue the custom CSS
    wp_enqueue_style(
        'custom-justify-style',
        plugins_url( 'custom-justify-button.css', __FILE__ ) . '?v=' . time(),
        array(),
        '1.0'
    );
}
add_action( 'enqueue_block_editor_assets', 'add_justify_block_style' );
