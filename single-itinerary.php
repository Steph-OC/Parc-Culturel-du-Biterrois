<?php

/**
 * The single itinerary template file.
 *
 * @package kadence
 */

namespace Kadence;

if (! defined('ABSPATH')) {
    exit;
}

get_header();

kadence()->print_styles('kadence-content');

// Affiche l'image mise en avant avec effet Parallax directement avant le contenu principal
if (has_post_thumbnail()) : ?>
    <div class="parallax" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
        <h1><?php the_title(); ?></h1>
    </div>
<?php endif; ?>

<div class="back-to-map">
    <a href="<?php echo esc_url(home_url('/#map-container')); ?>">Voir la carte</a>
</div>

<?php
/**
 * Hook for everything, makes for better Elementor theming support.
 * Ce hook va utiliser la même structure de page que les articles.
 */
do_action('kadence_single');

get_footer();
