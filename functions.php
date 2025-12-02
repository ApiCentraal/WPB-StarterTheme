<?php
/**
 * WP Bootstrap Starter - functions.php
 * 
 * Thema setup, asset loading en security hardening
 */

// =============================================================================
// 1. THEMA SETUP
// =============================================================================

if (!function_exists('wpbs_setup')) {
    /**
     * Initialiseert basisfunctionaliteit van het thema
     * 
     * Pipeline:
     * WordPress Init → after_setup_theme hook → wpbs_setup()
     *   ├─→ title-tag support
     *   ├─→ post-thumbnails support
     *   ├─→ html5 support
     *   └─→ register_nav_menus
     */
    function wpbs_setup() {
        // Laat WordPress de <title> tag beheren
        add_theme_support('title-tag');
        
        // Schakel uitgelichte afbeeldingen in
        add_theme_support('post-thumbnails');
        
        // HTML5 markup voor formulieren en galerijen
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        
        // Registreer menu locatie voor navbar
        register_nav_menus(array(
            'primary' => __('Hoofdmenu', 'wp-bootstrap-starter'),
        ));
    }
    add_action('after_setup_theme', 'wpbs_setup');
}

// =============================================================================
// 2. ASSET LOADING
// =============================================================================

if (!function_exists('wpbs_enqueue_assets')) {
    /**
     * Laadt CSS en JavaScript in de juiste volgorde
     * 
     * Pipeline:
     * wp_enqueue_scripts hook → wpbs_enqueue_assets()
     * 
     * CSS Keten: bootstrap-css → wpbs-style → wpbs-custom
     * JS Keten:  bootstrap-js → wpbs-theme
     */
    function wpbs_enqueue_assets() {
        // ---------------------------------------------------------------------
        // CSS: Bootstrap → Theme → Custom
        // ---------------------------------------------------------------------
        
        // Bootstrap CSS via jsDelivr CDN
        wp_enqueue_style(
            'bootstrap-css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css',
            array(),
            null
        );
        
        // Thema stylesheet (style.css) - afhankelijk van Bootstrap
        wp_enqueue_style(
            'wpbs-style',
            get_stylesheet_uri(),
            array('bootstrap-css'),
            filemtime(get_template_directory() . '/style.css')
        );
        
        // Custom CSS - afhankelijk van thema stylesheet
        wp_enqueue_style(
            'wpbs-custom',
            get_template_directory_uri() . '/assets/css/custom.css',
            array('wpbs-style'),
            filemtime(get_template_directory() . '/assets/css/custom.css')
        );
        
        // ---------------------------------------------------------------------
        // JavaScript: Bootstrap Bundle (incl. Popper) → Theme
        // ---------------------------------------------------------------------
        
        // Bootstrap Bundle JS via jsDelivr CDN (in footer)
        wp_enqueue_script(
            'bootstrap-js',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js',
            array(),
            null,
            true // In footer laden
        );
        
        // Thema JavaScript - afhankelijk van Bootstrap
        wp_enqueue_script(
            'wpbs-theme',
            get_template_directory_uri() . '/assets/js/theme.js',
            array('bootstrap-js'),
            filemtime(get_template_directory() . '/assets/js/theme.js'),
            true // In footer laden
        );
    }
    add_action('wp_enqueue_scripts', 'wpbs_enqueue_assets');
}

// =============================================================================
// 3. SECURITY & PERFORMANCE CLEANUP
// =============================================================================

/**
 * Verwijdert onnodige meta tags en scripts
 * 
 * Pipeline:
 * init hook → wpbs_cleanup_head()
 *   ├─→ Verbergt WordPress versie
 *   └─→ Verwijdert emoji scripts/styles
 */
function wpbs_cleanup_head() {
    // Verberg WordPress versie (security)
    remove_action('wp_head', 'wp_generator');
    
    // Verwijder emoji scripts (performance)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'wpbs_cleanup_head');

// =============================================================================
// 4. WIDGET AREAS
// =============================================================================

if (!function_exists('wpbs_widgets_init')) {
    /**
     * Registreert widget gebieden (sidebars)
     * 
     * Pipeline:
     * widgets_init hook → wpbs_widgets_init()
     *   └─→ Registreert 'primary-sidebar'
     */
    function wpbs_widgets_init() {
        register_sidebar(array(
            'name'          => __('Primaire Sidebar', 'wp-bootstrap-starter'),
            'id'            => 'primary-sidebar',
            'description'   => __('Widgets in deze sidebar verschijnen naast de content.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="widget card mb-3 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="card-header"><h5 class="widget-title mb-0">',
            'after_title'   => '</h5></div>',
        ));
    }
    add_action('widgets_init', 'wpbs_widgets_init');
}
