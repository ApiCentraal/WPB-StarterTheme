<?php
/**
 * Theme Name:   WP Bootstrap Starter Child
 * Theme URI:    https://github.com/ApiCentraal/WPB-StarterTheme
 * Description:  Child theme voor WP Bootstrap Starter
 * Author:       FectionLabs
 * Author URI:   https://fectionlabs.com
 * Template:     wp-bootstrap-starter
 * Version:      1.0.0
 * License:      GPL-2.0+
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  wp-bootstrap-starter-child
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Laad parent en child theme stylesheets
 */
function wpbs_child_enqueue_styles() {
    // Parent theme style
    wp_enqueue_style(
        'wpbs-parent-style',
        get_template_directory_uri() . '/style.css',
        array('bootstrap-css'),
        wp_get_theme('wp-bootstrap-starter')->get('Version')
    );

    // Child theme style
    wp_enqueue_style(
        'wpbs-child-style',
        get_stylesheet_uri(),
        array('wpbs-parent-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'wpbs_child_enqueue_styles', 20);

/**
 * Child theme setup
 * 
 * Voeg hier je eigen theme setup toe.
 * Alle parent theme functies zijn beschikbaar.
 */
function wpbs_child_setup() {
    // Voeg eventueel extra theme supports toe
    // add_theme_support('...');

    // Registreer extra menu locaties
    // register_nav_menus(array(...));
}
add_action('after_setup_theme', 'wpbs_child_setup');

/**
 * Voeg custom widgets toe
 */
function wpbs_child_widgets_init() {
    // Registreer extra widget areas
    // register_sidebar(array(...));
}
add_action('widgets_init', 'wpbs_child_widgets_init');

/**
 * Voeg custom scripts en styles toe
 */
function wpbs_child_enqueue_scripts() {
    // Custom JavaScript
    // wp_enqueue_script('wpbs-child-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'wpbs_child_enqueue_scripts');
