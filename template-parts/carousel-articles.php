<section class="agenda">
    <h2 class="title-h2">L'agenda du Parc </h2>

    <div class="swiper-container coverflow-carousel articles-carousel">
        <div class="swiper-wrapper">
            <?php
            // Arguments pour récupérer les événements futurs
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 5,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'event_start_date', 
                        'compare' => 'EXISTS'
                    ),
                    array(
                        'key' => 'event_start_date',
                        'value' => date('Ymd'),
                        'compare' => '>=',
                        'type' => 'DATE'
                    )
                ),
                'orderby' => 'meta_value',
                'meta_key' => 'event_start_date', 
                'order' => 'ASC'
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();

                    // Récupère les champs de date de début et de fin
                    $start_date = get_field('event_start_date');
                    $end_date = get_field('event_end_date');

                    // Récupère le lieu de l'événement
                    $event_location = get_field('event_location'); 

                    // Récupère le contenu de l'article
                    $content = apply_filters('the_content', get_the_content());

                    // Extraire le premier <h2> du contenu
                    preg_match('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);
                    $h1_content = !empty($matches[1]) ? $matches[1] : '';

            ?>
                    <div class="swiper-slide">
                        <div class="slide-image">
                            <?php the_post_thumbnail('full'); ?>
                            <div class="slide-content">
                                <!-- Affiche le titre de l'article -->
                                <h4><?php the_title(); ?></h4>

                                <!-- Affiche le contenu du H1 si trouvé -->
                                <?php if ($h1_content): ?>
                                    <h5 style="margin: 10px;"><?php echo esc_html($h1_content); ?></h5>
                                <?php endif; ?>

                                <!-- Affiche la date de l'événement -->
                                <?php if ($start_date): ?>
                                    <p>
                                        <?php
                                        // Affiche la date ou la plage de dates
                                        echo date_i18n('j F Y', strtotime($start_date)); 
                                        if ($end_date) {
                                            echo ' - ' . date_i18n('j F Y', strtotime($end_date));
                                        }
                                        ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Affiche le lieu de l'événement -->
                                <?php if ($event_location): ?>
                                    <p><?php echo esc_html($event_location); ?></p>
                                <?php endif; ?>

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
