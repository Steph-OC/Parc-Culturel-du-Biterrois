<?php
function kadence_child_remove_parent_functions() {
    remove_action( 'kadence_header', 'Kadence\header_markup', 10 );
  
}
add_action( 'wp_loaded', 'kadence_child_remove_parent_functions' );
