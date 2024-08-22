<div class="polaroid-collage">
    <?php
    for ($i = 1; $i <= 5; $i++) {
        $image_url = get_theme_mod("mytheme_banner_image_$i");
        $banner_text_title = get_theme_mod("mytheme_banner_text_title_$i");
        $banner_text = get_theme_mod("mytheme_banner_text_$i");
        if ($image_url) {
            echo '<div class="polaroid-item" style="--rotation: ' . ($i % 2 == 0 ? '1' : '-1') . ';">';
            echo '<img src="' . esc_url($image_url) . '" alt="Polaroid Image ' . $i . '">';
            if ($banner_text_title || $banner_text) {
                echo '<div class="image-title">';
                if ($banner_text_title) {
                    echo '<h2>' . esc_html($banner_text_title) . '</h2>';
                }
                if ($banner_text) {
                    echo '<p>' . esc_html($banner_text) . '</p>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    }
    ?>
</div>
