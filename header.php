<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                <?php bloginfo('name'); ?>
            </a>
            
            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#primaryMenu" 
                    aria-controls="primaryMenu" 
                    aria-expanded="false" 
                    aria-label="<?php esc_attr_e('Toggle navigation', 'wp-bootstrap-starter'); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="primaryMenu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'    => 'wp_page_menu',
                    'depth'          => 2,
                ));
                ?>
            </div>
        </div>
    </nav>
</header>

<main class="site-main container mt-4" id="main" role="main">
