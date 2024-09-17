<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Kadence
 */

namespace Kadence;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hook for bottom of inner wrap.
 */
do_action('kadence_after_content');
?>
</div><!-- #inner-wrap -->
<?php
do_action('kadence_before_footer');
do_action('kadence_footer');
do_action('kadence_after_footer');
?>
</div><!-- #wrapper -->
<?php do_action('kadence_after_wrapper'); ?>

<?php wp_footer(); ?>
</body>
</html>
