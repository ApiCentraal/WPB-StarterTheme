<?php
/**
 * WP Bootstrap Starter - functions.php
 * 
 * Thema setup, asset loading en security hardening
 *
 * @package WP_Bootstrap_Starter
 * @since 0.1.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// =============================================================================
// INCLUDES
// =============================================================================

// Nav Walker voor Bootstrap 5 dropdown menu's
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

// Theme Customizer instellingen
require_once get_template_directory() . '/inc/customizer.php';

// Bootstrap 5.3 Shortcodes
require_once get_template_directory() . '/inc/shortcodes.php';

// Custom Widgets
require_once get_template_directory() . '/inc/widgets/class-wpbs-social-widget.php';
require_once get_template_directory() . '/inc/widgets/class-wpbs-recent-posts-widget.php';

// User Profile Extensions (social media velden)
require_once get_template_directory() . '/inc/user-profile.php';

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
     *   ├─→ custom-logo support
     *   ├─→ custom-header support
     *   ├─→ custom-background support
     *   ├─→ editor-styles support
     *   ├─→ align-wide support
     *   ├─→ responsive-embeds support
     *   ├─→ post-formats support
     *   └─→ register_nav_menus
     */
    function wpbs_setup() {
        // Vertalingen laden
        load_theme_textdomain('wp-bootstrap-starter', get_template_directory() . '/languages');

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
            'script',
            'style',
        ));

        // Custom logo support
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 350,
            'flex-height' => true,
            'flex-width'  => true,
        ));

        // Custom header image support
        add_theme_support('custom-header', apply_filters('wpbs_custom_header_args', array(
            'default-image'      => '',
            'default-text-color' => '000000',
            'width'              => 1920,
            'height'             => 500,
            'flex-height'        => true,
            'flex-width'         => true,
        )));

        // Custom background support
        add_theme_support('custom-background', apply_filters('wpbs_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Gutenberg/Block Editor support
        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');

        // Post formats support
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
        ));

        // Selective refresh voor widgets in Customizer
        add_theme_support('customize-selective-refresh-widgets');

        // Automatische feed links
        add_theme_support('automatic-feed-links');
        
        // Registreer menu locaties
        register_nav_menus(array(
            'primary' => __('Hoofdmenu', 'wp-bootstrap-starter'),
            'footer'  => __('Footer Menu', 'wp-bootstrap-starter'),
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
     *   ├─→ Registreert 'primary-sidebar'
     *   ├─→ Registreert 'footer-1'
     *   ├─→ Registreert 'footer-2'
     *   └─→ Registreert 'footer-3'
     */
    function wpbs_widgets_init() {
        // Primaire sidebar (naast content)
        register_sidebar(array(
            'name'          => __('Primaire Sidebar', 'wp-bootstrap-starter'),
            'id'            => 'primary-sidebar',
            'description'   => __('Widgets in deze sidebar verschijnen naast de content.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="widget card mb-3 %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="card-header"><h5 class="widget-title mb-0">',
            'after_title'   => '</h5></div>',
        ));

        // Footer widget kolom 1
        register_sidebar(array(
            'name'          => __('Footer Kolom 1', 'wp-bootstrap-starter'),
            'id'            => 'footer-1',
            'description'   => __('Eerste kolom in de footer.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Footer widget kolom 2
        register_sidebar(array(
            'name'          => __('Footer Kolom 2', 'wp-bootstrap-starter'),
            'id'            => 'footer-2',
            'description'   => __('Tweede kolom in de footer.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Footer widget kolom 3
        register_sidebar(array(
            'name'          => __('Footer Kolom 3', 'wp-bootstrap-starter'),
            'id'            => 'footer-3',
            'description'   => __('Derde kolom in de footer.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));

        // Hero/Header widget area
        register_sidebar(array(
            'name'          => __('Hero Sectie', 'wp-bootstrap-starter'),
            'id'            => 'hero',
            'description'   => __('Hero sectie boven de content, ideaal voor een banner of call-to-action.', 'wp-bootstrap-starter'),
            'before_widget' => '<div id="%1$s" class="hero-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="hero-title">',
            'after_title'   => '</h2>',
        ));

        // Registreer custom widgets
        register_widget('WPBS_Social_Widget');
        register_widget('WPBS_Recent_Posts_Widget');
    }
    add_action('widgets_init', 'wpbs_widgets_init');
}

// =============================================================================
// 5. HELPER FUNCTIES
// =============================================================================

/**
 * Toont het custom logo of de site titel
 *
 * Pipeline:
 * header.php → wpbs_the_custom_logo()
 *   ├─→ has_custom_logo() → the_custom_logo()
 *   └─→ fallback → site titel link
 */
function wpbs_the_custom_logo() {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        if (is_front_page() && is_home()) {
            echo '<h1 class="navbar-brand mb-0"><a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a></h1>';
        } else {
            echo '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
        }
    }
}

/**
 * Toont de footer site info
 *
 * Pipeline:
 * footer.php → wpbs_site_info()
 *   ├─→ Customizer override check
 *   └─→ Default copyright tekst
 */
function wpbs_site_info() {
    $site_info = get_theme_mod('wpbs_footer_text', '');
    
    if (!empty($site_info)) {
        echo wp_kses_post($site_info);
    } else {
        printf(
            '&copy; %1$s %2$s',
            date('Y'),
            get_bloginfo('name')
        );
    }
}
