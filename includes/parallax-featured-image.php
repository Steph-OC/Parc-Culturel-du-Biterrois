<?php
//parallax image single-itinarery.php
function add_parallax_featured_image() {
    if (has_post_thumbnail()) {
        echo '<div class="parallax" style="background-image: url(' . get_the_post_thumbnail_url(get_the_ID(), 'full') . ');">';
        echo '<h1>' . get_the_title() . '</h1>';
        echo '</div>';
    }
}
add_action('kadence_single_content_before', 'add_parallax_featured_image');