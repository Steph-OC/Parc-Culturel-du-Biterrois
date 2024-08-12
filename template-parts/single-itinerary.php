<?php
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>

                    <div class="custom-gallery gallery" id="gallery--getting-started">
                        <?php
                        $gallery = get_post_gallery(get_the_ID(), false);
                        if ($gallery) :
                            $gallery_ids = explode(',', $gallery['ids']);
                            foreach ($gallery_ids as $id) :
                                $image_url = wp_get_attachment_url($id);
                                $thumbnail_url = wp_get_attachment_image_src($id, 'thumbnail')[0];
                                $full_size = wp_get_attachment_image_src($id, 'full');
                                $attachment = get_post($id);
                                $image_caption = $attachment->post_excerpt; // Utilisez post_excerpt pour obtenir la légende

                                ?>
                                <a href="<?php echo esc_url($full_size[0]); ?>" data-pswp-width="<?php echo esc_attr($full_size[1]); ?>" data-pswp-height="<?php echo esc_attr($full_size[2]); ?>" data-caption="<?php echo esc_attr($image_caption); ?>" class="photoswipe-gallery">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($image_caption); ?>">
                                </a>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </article>

        <?php endwhile; ?>
    </main>
</div>

<?php get_footer(); ?>
