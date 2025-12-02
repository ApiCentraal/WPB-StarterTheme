<?php
/**
 * Theme Customizer instellingen
 *
 * Voegt layout opties toe aan de WordPress Customizer.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!function_exists('wpbs_customize_register')) {
    /**
     * Registreert Customizer instellingen en controls
     *
     * Pipeline:
     * customize_register hook → wpbs_customize_register()
     *   ├─→ Sectie: wpbs_theme_layout_options
     *   ├─→ Setting: wpbs_container_type
     *   ├─→ Setting: wpbs_sidebar_position
     *   └─→ Setting: wpbs_footer_text
     *
     * @param WP_Customize_Manager $wp_customize Customizer reference.
     */
    function wpbs_customize_register($wp_customize) {
        
        // =====================================================================
        // SECTIE: Theme Layout Options
        // =====================================================================
        
        $wp_customize->add_section(
            'wpbs_theme_layout_options',
            array(
                'title'       => __('Thema Layout', 'wp-bootstrap-starter'),
                'description' => __('Container breedte en sidebar instellingen', 'wp-bootstrap-starter'),
                'priority'    => 160,
            )
        );

        // =====================================================================
        // SETTING: Container Type
        // =====================================================================
        
        $wp_customize->add_setting(
            'wpbs_container_type',
            array(
                'default'           => 'container',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'wpbs_sanitize_select',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'wpbs_container_type',
            array(
                'label'       => __('Container Type', 'wp-bootstrap-starter'),
                'description' => __('Kies tussen vaste breedte of volledige breedte.', 'wp-bootstrap-starter'),
                'section'     => 'wpbs_theme_layout_options',
                'type'        => 'select',
                'choices'     => array(
                    'container'       => __('Vaste breedte (container)', 'wp-bootstrap-starter'),
                    'container-fluid' => __('Volledige breedte (container-fluid)', 'wp-bootstrap-starter'),
                ),
            )
        );

        // =====================================================================
        // SETTING: Sidebar Position
        // =====================================================================
        
        $wp_customize->add_setting(
            'wpbs_sidebar_position',
            array(
                'default'           => 'right',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'wpbs_sanitize_select',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'wpbs_sidebar_position',
            array(
                'label'       => __('Sidebar Positie', 'wp-bootstrap-starter'),
                'description' => __('Bepaal waar de sidebar wordt getoond.', 'wp-bootstrap-starter'),
                'section'     => 'wpbs_theme_layout_options',
                'type'        => 'select',
                'choices'     => array(
                    'right' => __('Rechts', 'wp-bootstrap-starter'),
                    'left'  => __('Links', 'wp-bootstrap-starter'),
                    'none'  => __('Geen sidebar', 'wp-bootstrap-starter'),
                ),
            )
        );

        // =====================================================================
        // SETTING: Navbar Type (collapse vs offcanvas)
        // =====================================================================
        
        $wp_customize->add_setting(
            'wpbs_navbar_type',
            array(
                'default'           => 'collapse',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'wpbs_sanitize_select',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'wpbs_navbar_type',
            array(
                'label'       => __('Navigatie Type', 'wp-bootstrap-starter'),
                'description' => __('Kies het type mobiele navigatie.', 'wp-bootstrap-starter'),
                'section'     => 'wpbs_theme_layout_options',
                'type'        => 'select',
                'choices'     => array(
                    'collapse'  => __('Collapse (inklapbaar)', 'wp-bootstrap-starter'),
                    'offcanvas' => __('Offcanvas (zijpaneel)', 'wp-bootstrap-starter'),
                ),
            )
        );

        // =====================================================================
        // SECTIE: Footer Options
        // =====================================================================
        
        $wp_customize->add_section(
            'wpbs_footer_options',
            array(
                'title'    => __('Footer', 'wp-bootstrap-starter'),
                'priority' => 170,
            )
        );

        // Footer tekst override
        $wp_customize->add_setting(
            'wpbs_footer_text',
            array(
                'default'           => '',
                'type'              => 'theme_mod',
                'sanitize_callback' => 'wp_kses_post',
                'transport'         => 'postMessage',
            )
        );

        $wp_customize->add_control(
            'wpbs_footer_text',
            array(
                'label'       => __('Footer Tekst', 'wp-bootstrap-starter'),
                'description' => __('Overschrijf de standaard footer tekst. HTML toegestaan.', 'wp-bootstrap-starter'),
                'section'     => 'wpbs_footer_options',
                'type'        => 'textarea',
            )
        );
    }
    add_action('customize_register', 'wpbs_customize_register');
}

/**
 * Sanitize select input
 *
 * @param string $input   The input value.
 * @param object $setting The setting object.
 * @return string Sanitized value.
 */
function wpbs_sanitize_select($input, $setting) {
    // Get all choices from the control
    $choices = $setting->manager->get_control($setting->id)->choices;
    
    // Return input if valid, otherwise return default
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Haal container type op
 *
 * @return string container of container-fluid
 */
function wpbs_get_container_type() {
    return get_theme_mod('wpbs_container_type', 'container');
}

/**
 * Haal sidebar positie op
 *
 * @return string right, left, of none
 */
function wpbs_get_sidebar_position() {
    return get_theme_mod('wpbs_sidebar_position', 'right');
}

/**
 * Check of sidebar getoond moet worden
 *
 * @return bool
 */
function wpbs_has_sidebar() {
    return wpbs_get_sidebar_position() !== 'none';
}

/**
 * Haal navbar type op
 *
 * @return string collapse of offcanvas
 */
function wpbs_get_navbar_type() {
    return get_theme_mod('wpbs_navbar_type', 'collapse');
}
