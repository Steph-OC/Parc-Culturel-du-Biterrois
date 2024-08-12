<?php
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <!--<h2>Le Parc</h2>-->
        <div class="presentation-text">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <?php get_template_part('template-parts/map'); ?>

        <?php get_template_part('template-parts/carousel-articles'); ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>