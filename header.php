<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip to content link voor accessibility -->
<a class="skip-link screen-reader-text visually-hidden-focusable" href="#main">
    <?php esc_html_e('Ga naar inhoud', 'wp-bootstrap-starter'); ?>
</a>

<header class="site-header" id="wrapper-navbar">
    <?php $navbar_type = wpbs_get_navbar_type(); ?>
    
    <?php if ($navbar_type === 'offcanvas') : ?>
    <!-- Offcanvas Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'wp-bootstrap-starter'); ?>">
        <div class="<?php echo esc_attr(wpbs_get_container_type()); ?>">
            <!-- Brand/Logo -->
            <?php wpbs_the_custom_logo(); ?>
            
            <!-- Offcanvas Toggle -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#navbarOffcanvas" 
                    aria-controls="navbarOffcanvas" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Menu openen', 'wp-bootstrap-starter'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Offcanvas Menu -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvas" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php bloginfo('name'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e('Menu sluiten', 'wp-bootstrap-starter'); ?>"></button>
                </div>
                <div class="offcanvas-body">
                    <?php
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'menu_class'      => 'navbar-nav justify-content-end flex-grow-1',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                        'depth'           => 2,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </nav>
    
    <?php else : ?>
    <!-- Collapse Navbar (standaard) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="<?php esc_attr_e('Hoofdnavigatie', 'wp-bootstrap-starter'); ?>">
        <div class="<?php echo esc_attr(wpbs_get_container_type()); ?>">
            <!-- Brand/Logo -->
            <?php wpbs_the_custom_logo(); ?>
            
            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#primaryMenu" 
                    aria-controls="primaryMenu" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Menu openen', 'wp-bootstrap-starter'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="primaryMenu">
                <?php
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'menu_class'      => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                    'walker'          => new WP_Bootstrap_Navwalker(),
                    'depth'           => 2,
                ));
                ?>
            </div>
        </div>
    </nav>
    <?php endif; ?>
</header>

<?php
// Hero widget area (indien widgets aanwezig)
if (is_active_sidebar('hero')) : ?>
<div id="wrapper-hero" class="hero-wrapper">
    <div class="<?php echo esc_attr(wpbs_get_container_type()); ?>">
        <?php dynamic_sidebar('hero'); ?>
    </div>
</div>
<?php endif; ?>

<main class="site-main <?php echo esc_attr(wpbs_get_container_type()); ?> mt-4" id="main" role="main">
