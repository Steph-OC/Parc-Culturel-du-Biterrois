<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kadence
 */

namespace Kadence;

if (!defined('ABSPATH')) {
    exit;
}

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js" <?php kadence()->print_microdata('html'); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php
    /**
     * Kadence before wrapper hook.
     */
    do_action('kadence_before_wrapper');
    ?>
    <div id="wrapper" class="site wp-site-blocks">
        <!-- Titre du site et logo -->
        <header class="site-header">
            <div class="site-title-logo">
                <div class="site-title">
                    <h1><?php bloginfo('name'); ?></h1>
                    <p><?php bloginfo('description'); ?></p>
                </div>
                <div class="site-logo">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/PCB.png'); ?>" alt="Logo">
                </div>
            </div>
        </header>

        <div class="banner-wrapper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    for ($i = 1; $i <= 6; $i++) {
                        $banner_image = get_theme_mod("mytheme_banner_image_$i");
                        $banner_text_title = get_theme_mod("mytheme_banner_text_title_$i");
                        if ($banner_image) {
                    ?>
                            <div class="swiper-slide">
                                <div class="polaroid">
                                    <img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($banner_text_title); ?>">
                                    <div class="caption"><?php echo esc_html($banner_text_title); ?></div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="regular-banner">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    $banner_image = get_theme_mod("mytheme_banner_image_$i");
                    $banner_text_title = get_theme_mod("mytheme_banner_text_title_$i");
                    if ($banner_image) {
                ?>
                        <div class="item">
                            <div class="polaroid">
                                <img src="<?php echo esc_url($banner_image); ?>" alt="<?php echo esc_attr($banner_text_title); ?>">
                                <div class="caption"><?php echo esc_html($banner_text_title); ?></div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="breadcrumb-container">
            <?php
            if (function_exists('my_custom_breadcrumb')) {
                my_custom_breadcrumb(); // Votre fonction de fil d'Ariane personnalisé
            }
            ?>
        </div>

        <!-- Code HTML de la navbar -->
        <nav class="navbar is-dark is-vertical" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/PCB.png'); ?>" alt="Logo">
                </a>
            </div>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <p class="text-menu">Menu</p>
            </a>

            <div id="navbarMenu" class="navbar-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'navbar-start',
                    'container' => false,
                ));
                ?>
            </div>

            <div class="navbar-bottom">
                <div class="vertical-column">
                    <p><span class="highlight">P</span>arc</p>
                </div>
                <div class="vertical-column">
                    <p><span class="highlight">C</span>ulturel</p>
                </div>
                <div class="vertical-column">
                    <p><span class="highlight">B</span>iterrois</p>
                </div>
            </div>
        </nav>

        <div id="inner-wrap" class="wrap hfeed kt-clear">
            <?php
            /**
             * Hook for top of inner wrap.
             */
            do_action('kadence_before_content');
            ?>
            