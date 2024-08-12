<section class="agenda">
    <h2 class="title-h2">L'agenda du Parc </h2>

    <div class="swiper-container coverflow-carousel articles-carousel">
        <div class="swiper-wrapper">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 5
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
            ?>
                    <div class="swiper-slide">
                        <div class="slide-image">
                            <?php the_post_thumbnail('full'); ?>
                            <div class="slide-content">
                                <h4><?php the_title(); ?></h4>
                                <a href="<?php the_permalink(); ?>">En savoir plus...</a>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="swiper-pagination swiper-pagination-coverflow"></div>
        <div class="swiper-button-next swiper-button-next-coverflow"></div>
        <div class="swiper-button-prev swiper-button-prev-coverflow"></div>
    </div>
</section>