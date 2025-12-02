<?php
/**
 * Contact Form 7 Compatibility
 *
 * Laadt Bootstrap 5 styling voor Contact Form 7.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Controleer of Contact Form 7 actief is
 */
if (!defined('WPCF7_VERSION')) {
    return;
}

/**
 * Laad CF7 Bootstrap styles
 */
function wpbs_cf7_enqueue_styles() {
    wp_enqueue_style(
        'wpbs-cf7-bootstrap',
        get_template_directory_uri() . '/assets/css/cf7-bootstrap.css',
        array('contact-form-7'),
        filemtime(get_template_directory() . '/assets/css/cf7-bootstrap.css')
    );
}
add_action('wp_enqueue_scripts', 'wpbs_cf7_enqueue_styles', 20);

/**
 * Voeg Bootstrap classes toe aan CF7 form wrapper
 */
function wpbs_cf7_form_class_attr($class) {
    $class .= ' needs-validation';
    return $class;
}
add_filter('wpcf7_form_class_attr', 'wpbs_cf7_form_class_attr');

/**
 * Custom default form template met Bootstrap markup
 * 
 * Voorbeeld gebruik in CF7 editor:
 * 
 * <div class="mb-3">
 *     <label class="form-label" for="your-name">[label]</label>
 *     [text* your-name id:your-name class:form-control placeholder "Uw naam"]
 * </div>
 * 
 * <div class="mb-3">
 *     <label class="form-label" for="your-email">E-mail *</label>
 *     [email* your-email id:your-email class:form-control placeholder "uw@email.nl"]
 * </div>
 * 
 * <div class="mb-3">
 *     <label class="form-label" for="your-message">Bericht</label>
 *     [textarea your-message id:your-message class:form-control rows:5 placeholder "Uw bericht..."]
 * </div>
 * 
 * <div class="mb-3 form-check">
 *     [acceptance privacy class:form-check-input] 
 *     <label class="form-check-label">Ik ga akkoord met het <a href="/privacy">privacybeleid</a></label>
 * </div>
 * 
 * [submit class:btn class:btn-primary "Versturen"]
 */

/**
 * Pas ajax loader aan naar Bootstrap spinner
 */
function wpbs_cf7_ajax_loader() {
    return '<span class="spinner-border spinner-border-sm ms-2" role="status"><span class="visually-hidden">' . esc_html__('Laden...', 'wp-bootstrap-starter') . '</span></span>';
}
add_filter('wpcf7_ajax_loader', 'wpbs_cf7_ajax_loader');

/**
 * Voeg novalidate attribuut toe voor custom validation
 */
function wpbs_cf7_form_novalidate($form) {
    $form = str_replace('<form ', '<form novalidate ', $form);
    return $form;
}
add_filter('wpcf7_form_elements', 'wpbs_cf7_form_novalidate');
