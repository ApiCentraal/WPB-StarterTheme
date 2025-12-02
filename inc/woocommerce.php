<?php
/**
 * WooCommerce Ondersteuning
 *
 * Bootstrap 5 styling voor WooCommerce templates.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Controleer of WooCommerce actief is
 */
if (!class_exists('WooCommerce')) {
    return;
}

// =============================================================================
// WOOCOMMERCE SETUP
// =============================================================================

/**
 * WooCommerce thema ondersteuning
 */
function wpbs_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'max_rows'        => 6,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ));

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'wpbs_woocommerce_setup');

// =============================================================================
// WRAPPER HOOKS
// =============================================================================

/**
 * Verwijder standaard WooCommerce wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Opening wrapper met Bootstrap container
 */
function wpbs_woocommerce_wrapper_before() {
    $container_type = wpbs_get_container_type();
    ?>
    <main id="primary" class="site-main">
        <div class="<?php echo esc_attr($container_type); ?> py-4">
            <div class="row">
                <div class="col-12">
    <?php
}
add_action('woocommerce_before_main_content', 'wpbs_woocommerce_wrapper_before');

/**
 * Sluit Bootstrap wrapper
 */
function wpbs_woocommerce_wrapper_after() {
    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
}
add_action('woocommerce_after_main_content', 'wpbs_woocommerce_wrapper_after');

// =============================================================================
// BREADCRUMB STYLING
// =============================================================================

/**
 * Bootstrap breadcrumb classes voor WooCommerce
 */
function wpbs_woocommerce_breadcrumb_defaults($defaults) {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<nav aria-label="breadcrumb"><ol class="breadcrumb mb-4">',
        'wrap_after'  => '</ol></nav>',
        'before'      => '<li class="breadcrumb-item">',
        'after'       => '</li>',
        'home'        => __('Home', 'wp-bootstrap-starter'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'wpbs_woocommerce_breadcrumb_defaults');

// =============================================================================
// BUTTON STYLING
// =============================================================================

/**
 * Filter om Bootstrap button classes toe te voegen
 */
function wpbs_woocommerce_loop_add_to_cart_args($args, $product) {
    $args['class'] = str_replace('button', 'button btn btn-primary', $args['class']);
    return $args;
}
add_filter('woocommerce_loop_add_to_cart_args', 'wpbs_woocommerce_loop_add_to_cart_args', 10, 2);

// =============================================================================
// FORM STYLING
// =============================================================================

/**
 * Bootstrap form classes voor WooCommerce formulieren
 */
function wpbs_woocommerce_form_field_args($args, $key, $value) {
    // Input classes
    if (in_array($args['type'], array('text', 'email', 'tel', 'number', 'password', 'url', 'date', 'datetime-local'))) {
        $args['input_class'][] = 'form-control';
    }

    // Select classes
    if ($args['type'] === 'select') {
        $args['input_class'][] = 'form-select';
    }

    // Textarea classes
    if ($args['type'] === 'textarea') {
        $args['input_class'][] = 'form-control';
    }

    // Checkbox/radio
    if (in_array($args['type'], array('checkbox', 'radio'))) {
        $args['input_class'][] = 'form-check-input';
        $args['label_class'][] = 'form-check-label';
    }

    // Label classes
    $args['label_class'][] = 'form-label';

    return $args;
}
add_filter('woocommerce_form_field_args', 'wpbs_woocommerce_form_field_args', 10, 3);

// =============================================================================
// PAGINATION
// =============================================================================

/**
 * Bootstrap pagination voor WooCommerce
 */
function wpbs_woocommerce_pagination_args($args) {
    $args['prev_text'] = '<span aria-hidden="true">&laquo;</span>';
    $args['next_text'] = '<span aria-hidden="true">&raquo;</span>';
    
    return $args;
}
add_filter('woocommerce_pagination_args', 'wpbs_woocommerce_pagination_args');

// =============================================================================
// PRODUCT CARD STYLING
// =============================================================================

/**
 * Opening product card wrapper
 */
function wpbs_woocommerce_before_shop_loop_item() {
    echo '<div class="card h-100 product-card">';
}
add_action('woocommerce_before_shop_loop_item', 'wpbs_woocommerce_before_shop_loop_item', 5);

/**
 * Card body opening
 */
function wpbs_woocommerce_before_shop_loop_item_title() {
    echo '<div class="card-body d-flex flex-column">';
}
add_action('woocommerce_before_shop_loop_item_title', 'wpbs_woocommerce_before_shop_loop_item_title', 15);

/**
 * Sluit card body en card wrapper
 */
function wpbs_woocommerce_after_shop_loop_item() {
    echo '</div></div>'; // Sluit card-body en card
}
add_action('woocommerce_after_shop_loop_item', 'wpbs_woocommerce_after_shop_loop_item', 15);

// =============================================================================
// CART & CHECKOUT
// =============================================================================

/**
 * Bootstrap classes voor cart tabel
 */
function wpbs_woocommerce_cart_item_class($class, $cart_item, $cart_item_key) {
    return $class . ' align-middle';
}
add_filter('woocommerce_cart_item_class', 'wpbs_woocommerce_cart_item_class', 10, 3);

// =============================================================================
// NOTICES / ALERTS
// =============================================================================

/**
 * WooCommerce notices met Bootstrap alert styling
 * 
 * Filter de notice wrappers naar Bootstrap alert classes
 */
function wpbs_woocommerce_demo_store_notice() {
    if (!is_store_notice_showing()) {
        return;
    }

    $notice = get_option('woocommerce_demo_store_notice');

    if (empty($notice)) {
        $notice = __('Dit is een demo winkel voor testdoeleinden.', 'wp-bootstrap-starter');
    }

    $notice_id = md5($notice);
    
    echo '<div class="alert alert-info alert-dismissible fade show woocommerce-store-notice" data-notice-id="' . esc_attr($notice_id) . '" role="alert">';
    echo '<div class="container">';
    echo wp_kses_post($notice);
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="' . esc_attr__('Sluiten', 'wp-bootstrap-starter') . '"></button>';
    echo '</div>';
    echo '</div>';
}

// =============================================================================
// MINI CART (HEADER)
// =============================================================================

/**
 * Mini cart voor navbar
 *
 * Gebruik: <?php wpbs_woocommerce_header_cart(); ?>
 */
function wpbs_woocommerce_header_cart() {
    if (!function_exists('wc_get_cart_url')) {
        return;
    }
    ?>
    <div class="wpbs-mini-cart dropdown">
        <a class="nav-link dropdown-toggle" href="<?php echo esc_url(wc_get_cart_url()); ?>" id="miniCartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-cart3"></i>
            <span class="badge bg-primary rounded-pill wpbs-cart-count">
                <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="miniCartDropdown" style="min-width: 300px;">
            <h6 class="dropdown-header"><?php esc_html_e('Winkelwagen', 'wp-bootstrap-starter'); ?></h6>
            <?php the_widget('WC_Widget_Cart', 'title='); ?>
        </div>
    </div>
    <?php
}

/**
 * AJAX cart fragments voor mini cart update
 */
function wpbs_woocommerce_header_cart_fragment($fragments) {
    ob_start();
    ?>
    <span class="badge bg-primary rounded-pill wpbs-cart-count">
        <?php echo esc_html(WC()->cart->get_cart_contents_count()); ?>
    </span>
    <?php
    $fragments['.wpbs-cart-count'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'wpbs_woocommerce_header_cart_fragment');

// =============================================================================
// QUANTITY INPUT
// =============================================================================

/**
 * Bootstrap styling voor quantity inputs
 */
function wpbs_woocommerce_quantity_input_classes($classes) {
    $classes[] = 'form-control';
    $classes[] = 'text-center';
    return $classes;
}
add_filter('woocommerce_quantity_input_classes', 'wpbs_woocommerce_quantity_input_classes');

// =============================================================================
// RATING STARS
// =============================================================================

/**
 * Bootstrap Icons voor rating stars
 */
function wpbs_woocommerce_get_star_rating_html($html, $rating, $count) {
    $full_stars  = floor($rating);
    $half_stars  = ceil($rating - $full_stars);
    $empty_stars = 5 - $full_stars - $half_stars;

    $stars_html = '';
    
    // Volle sterren
    for ($i = 0; $i < $full_stars; $i++) {
        $stars_html .= '<i class="bi bi-star-fill text-warning"></i>';
    }
    
    // Halve ster
    if ($half_stars) {
        $stars_html .= '<i class="bi bi-star-half text-warning"></i>';
    }
    
    // Lege sterren
    for ($i = 0; $i < $empty_stars; $i++) {
        $stars_html .= '<i class="bi bi-star text-warning"></i>';
    }

    if ($count > 0) {
        $stars_html .= ' <small class="text-muted">(' . $count . ')</small>';
    }

    return '<span class="wpbs-star-rating">' . $stars_html . '</span>';
}
add_filter('woocommerce_get_star_rating_html', 'wpbs_woocommerce_get_star_rating_html', 10, 3);

// =============================================================================
// ENQUEUE WOOCOMMERCE STYLES
// =============================================================================

/**
 * Laad WooCommerce Bootstrap overrides
 */
function wpbs_woocommerce_scripts() {
    wp_enqueue_style(
        'wpbs-woocommerce',
        get_template_directory_uri() . '/assets/css/woocommerce.css',
        array('woocommerce-general'),
        filemtime(get_template_directory() . '/assets/css/woocommerce.css')
    );
}
add_action('wp_enqueue_scripts', 'wpbs_woocommerce_scripts', 20);

// =============================================================================
// REMOVE WOOCOMMERCE DEFAULT STYLES (OPTIONAL)
// =============================================================================

/**
 * Selectief WooCommerce stylesheets verwijderen
 * Uncomment om standaard WC styles te vervangen door Bootstrap
 */
// add_filter('woocommerce_enqueue_styles', '__return_empty_array');
