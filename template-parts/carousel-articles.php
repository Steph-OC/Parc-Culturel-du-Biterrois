<section class="agenda">
    <h2 class="title-h2">L'agenda du Parc</h2>

    <div class="swiper-container coverflow-carousel articles-carousel">
        <div class="swiper-wrapper">
            <?php
            // Arguments pour récupérer les événements futurs avec ACF
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'event_start_date',
                        'value' => date('Ymd'),
                        'compare' => '>=',
                        'type' => 'DATE'
                    ),
                    array(
                        'key' => 'event_end_date',
                        'value' => date('Ymd'),
                        'compare' => '>=',
                        'type' => 'DATE'
                    )
                ),
                'orderby' => 'meta_value',
                'meta_key' => 'event_start_date',
                'order' => 'ASC',
                'post_status' => 'publish'
            );

            $the_query = new WP_Query($args);
            $slides = array();
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();

                    $start_date = get_field('event_start_date');
                    $end_date = get_field('event_end_date');
                    $event_location = get_field('event_location');
                    $content = apply_filters('the_content', get_the_content());
                    preg_match('/<h2[^>]*>(.*?)<\/h2>/', $content, $matches);
                    $h1_content = !empty($matches[1]) ? $matches[1] : '';

                    $slides[] = '
                    <div class="swiper-slide">
                        <div class="slide-image">
                            ' . get_the_post_thumbnail(null, 'full') . '
                            <div class="slide-content">
                                <h4>' . get_the_title() . '</h4>
                                ' . (!empty($h1_content) ? '<h5 style="margin: 10px;">' . esc_html($h1_content) . '</h5>' : '') . '
                                ' . ($start_date ? '<p>' . date_i18n('j F Y', strtotime($start_date)) . ($end_date ? ' - ' . date_i18n('j F Y', strtotime($end_date)) : '') . '</p>' : '') . '
                                ' . ($event_location ? '<p>' . esc_html($event_location) . '</p>' : '') . '
                                <a href="' . get_permalink() . '">En savoir plus...</a>
                            </div>
                        </div>
                    </div>';
                endwhile;
                wp_reset_postdata();
            endif;

            foreach ($slides as $slide) {
                echo $slide;
            }

            // Si moins de 4 slides, ajoute des duplicatas
            $slide_count = count($slides);
            if ($slide_count < 4) {
                $needed_slides = 4 - $slide_count;

                for ($i = 0; $i < $needed_slides; $i++) {
                    echo $slides[($i + 1) % $slide_count];
                }
            }
            ?>
        </div>
        <div class="swiper-pagination swiper-pagination-coverflow"></div>
        <div class="swiper-button-next swiper-button-next-coverflow"></div>
        <div class="swiper-button-prev swiper-button-prev-coverflow"></div>
    </div>
</section>