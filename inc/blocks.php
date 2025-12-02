<?php
/**
 * Bootstrap Gutenberg Blocks
 *
 * Registreert Bootstrap 5 blocks voor de Gutenberg editor.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Bootstrap Blocks Class
 */
class WPBS_Bootstrap_Blocks {

    /**
     * Instance
     */
    private static $instance = null;

    /**
     * Singleton
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        add_action('init', array($this, 'register_blocks'));
        add_action('enqueue_block_editor_assets', array($this, 'enqueue_editor_assets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
    }

    /**
     * Registreer alle blocks
     */
    public function register_blocks() {
        // Container Block
        register_block_type('wpbs/container', array(
            'render_callback' => array($this, 'render_container_block'),
            'attributes'      => array(
                'fluid' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'breakpoint' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'className' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
            ),
        ));

        // Row Block
        register_block_type('wpbs/row', array(
            'render_callback' => array($this, 'render_row_block'),
            'attributes'      => array(
                'template' => array(
                    'type'    => 'string',
                    'default' => '1:1',
                ),
                'noGutters' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'horizontalGutter' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'verticalGutter' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'verticalAlignment' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'horizontalAlignment' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'className' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
            ),
        ));

        // Column Block
        register_block_type('wpbs/column', array(
            'render_callback' => array($this, 'render_column_block'),
            'attributes'      => array(
                'sizeXs' => array('type' => 'string', 'default' => ''),
                'sizeSm' => array('type' => 'string', 'default' => ''),
                'sizeMd' => array('type' => 'string', 'default' => ''),
                'sizeLg' => array('type' => 'string', 'default' => ''),
                'sizeXl' => array('type' => 'string', 'default' => ''),
                'sizeXxl' => array('type' => 'string', 'default' => ''),
                'offsetXs' => array('type' => 'string', 'default' => ''),
                'offsetSm' => array('type' => 'string', 'default' => ''),
                'offsetMd' => array('type' => 'string', 'default' => ''),
                'offsetLg' => array('type' => 'string', 'default' => ''),
                'offsetXl' => array('type' => 'string', 'default' => ''),
                'offsetXxl' => array('type' => 'string', 'default' => ''),
                'order' => array('type' => 'string', 'default' => ''),
                'verticalAlignment' => array('type' => 'string', 'default' => ''),
                'className' => array('type' => 'string', 'default' => ''),
            ),
        ));

        // Button Block
        register_block_type('wpbs/button', array(
            'render_callback' => array($this, 'render_button_block'),
            'attributes'      => array(
                'text' => array(
                    'type'    => 'string',
                    'default' => 'Button',
                ),
                'url' => array(
                    'type'    => 'string',
                    'default' => '#',
                ),
                'style' => array(
                    'type'    => 'string',
                    'default' => 'primary',
                ),
                'size' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'outline' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'block' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'disabled' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'newTab' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'className' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
            ),
        ));

        // Alert Block
        register_block_type('wpbs/alert', array(
            'render_callback' => array($this, 'render_alert_block'),
            'attributes'      => array(
                'type' => array(
                    'type'    => 'string',
                    'default' => 'primary',
                ),
                'dismissible' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'className' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
            ),
        ));

        // Card Block
        register_block_type('wpbs/card', array(
            'render_callback' => array($this, 'render_card_block'),
            'attributes'      => array(
                'headerText' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'footerText' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'imageUrl' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'imagePosition' => array(
                    'type'    => 'string',
                    'default' => 'top',
                ),
                'className' => array(
                    'type'    => 'string',
                    'default' => '',
                ),
            ),
        ));
    }

    /**
     * Render Container Block
     */
    public function render_container_block($attributes, $content) {
        $classes = array();

        if (!empty($attributes['fluid'])) {
            $classes[] = 'container-fluid';
        } elseif (!empty($attributes['breakpoint'])) {
            $classes[] = 'container-' . esc_attr($attributes['breakpoint']);
        } else {
            $classes[] = 'container';
        }

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_container_block_classes', $classes, $attributes);

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $classes)),
            $content
        );
    }

    /**
     * Render Row Block
     */
    public function render_row_block($attributes, $content) {
        $classes = array('row');

        // Gutters
        if (!empty($attributes['noGutters'])) {
            $classes[] = 'g-0';
        } else {
            if (!empty($attributes['horizontalGutter'])) {
                $classes[] = 'gx-' . esc_attr($attributes['horizontalGutter']);
            }
            if (!empty($attributes['verticalGutter'])) {
                $classes[] = 'gy-' . esc_attr($attributes['verticalGutter']);
            }
        }

        // Vertical alignment
        if (!empty($attributes['verticalAlignment'])) {
            $classes[] = 'align-items-' . esc_attr($attributes['verticalAlignment']);
        }

        // Horizontal alignment
        if (!empty($attributes['horizontalAlignment'])) {
            $classes[] = 'justify-content-' . esc_attr($attributes['horizontalAlignment']);
        }

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_row_block_classes', $classes, $attributes);

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $classes)),
            $content
        );
    }

    /**
     * Render Column Block
     */
    public function render_column_block($attributes, $content) {
        $classes = array();

        // Column sizes per breakpoint
        $breakpoints = array('xs', 'sm', 'md', 'lg', 'xl', 'xxl');
        $has_size = false;

        foreach ($breakpoints as $bp) {
            $size_key = 'size' . ucfirst($bp);
            if (!empty($attributes[$size_key])) {
                $has_size = true;
                if ($bp === 'xs') {
                    $classes[] = 'col-' . esc_attr($attributes[$size_key]);
                } else {
                    $classes[] = 'col-' . $bp . '-' . esc_attr($attributes[$size_key]);
                }
            }
        }

        // Default col class if no sizes
        if (!$has_size) {
            $classes[] = 'col';
        }

        // Offsets
        foreach ($breakpoints as $bp) {
            $offset_key = 'offset' . ucfirst($bp);
            if (!empty($attributes[$offset_key])) {
                if ($bp === 'xs') {
                    $classes[] = 'offset-' . esc_attr($attributes[$offset_key]);
                } else {
                    $classes[] = 'offset-' . $bp . '-' . esc_attr($attributes[$offset_key]);
                }
            }
        }

        // Order
        if (!empty($attributes['order'])) {
            $classes[] = 'order-' . esc_attr($attributes['order']);
        }

        // Vertical alignment
        if (!empty($attributes['verticalAlignment'])) {
            $classes[] = 'align-self-' . esc_attr($attributes['verticalAlignment']);
        }

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_column_block_classes', $classes, $attributes);

        return sprintf(
            '<div class="%s">%s</div>',
            esc_attr(implode(' ', $classes)),
            $content
        );
    }

    /**
     * Render Button Block
     */
    public function render_button_block($attributes, $content) {
        $classes = array('btn');

        // Style
        $style = !empty($attributes['style']) ? $attributes['style'] : 'primary';
        if (!empty($attributes['outline'])) {
            $classes[] = 'btn-outline-' . esc_attr($style);
        } else {
            $classes[] = 'btn-' . esc_attr($style);
        }

        // Size
        if (!empty($attributes['size'])) {
            $classes[] = 'btn-' . esc_attr($attributes['size']);
        }

        // Block
        if (!empty($attributes['block'])) {
            $classes[] = 'd-block w-100';
        }

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_button_block_classes', $classes, $attributes);

        // Attributes
        $attrs = array(
            'class' => implode(' ', $classes),
            'href'  => esc_url($attributes['url']),
        );

        if (!empty($attributes['disabled'])) {
            $attrs['class'] .= ' disabled';
            $attrs['aria-disabled'] = 'true';
            $attrs['tabindex'] = '-1';
        }

        if (!empty($attributes['newTab'])) {
            $attrs['target'] = '_blank';
            $attrs['rel'] = 'noopener noreferrer';
        }

        $attr_string = '';
        foreach ($attrs as $key => $value) {
            $attr_string .= sprintf(' %s="%s"', esc_attr($key), esc_attr($value));
        }

        return sprintf(
            '<a%s>%s</a>',
            $attr_string,
            esc_html($attributes['text'])
        );
    }

    /**
     * Render Alert Block
     */
    public function render_alert_block($attributes, $content) {
        $classes = array('alert');
        $classes[] = 'alert-' . esc_attr($attributes['type']);

        if (!empty($attributes['dismissible'])) {
            $classes[] = 'alert-dismissible';
            $classes[] = 'fade';
            $classes[] = 'show';
        }

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_alert_block_classes', $classes, $attributes);

        $dismiss_button = '';
        if (!empty($attributes['dismissible'])) {
            $dismiss_button = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="' . esc_attr__('Sluiten', 'wp-bootstrap-starter') . '"></button>';
        }

        return sprintf(
            '<div class="%s" role="alert">%s%s</div>',
            esc_attr(implode(' ', $classes)),
            $content,
            $dismiss_button
        );
    }

    /**
     * Render Card Block
     */
    public function render_card_block($attributes, $content) {
        $classes = array('card');

        if (!empty($attributes['className'])) {
            $classes[] = esc_attr($attributes['className']);
        }

        $classes = apply_filters('wpbs_card_block_classes', $classes, $attributes);

        $output = '<div class="' . esc_attr(implode(' ', $classes)) . '">';

        // Image top
        if (!empty($attributes['imageUrl']) && $attributes['imagePosition'] === 'top') {
            $output .= '<img src="' . esc_url($attributes['imageUrl']) . '" class="card-img-top" alt="" />';
        }

        // Header
        if (!empty($attributes['headerText'])) {
            $output .= '<div class="card-header">' . esc_html($attributes['headerText']) . '</div>';
        }

        // Body
        $output .= '<div class="card-body">' . $content . '</div>';

        // Footer
        if (!empty($attributes['footerText'])) {
            $output .= '<div class="card-footer">' . esc_html($attributes['footerText']) . '</div>';
        }

        // Image bottom
        if (!empty($attributes['imageUrl']) && $attributes['imagePosition'] === 'bottom') {
            $output .= '<img src="' . esc_url($attributes['imageUrl']) . '" class="card-img-bottom" alt="" />';
        }

        $output .= '</div>';

        return $output;
    }

    /**
     * Laad editor assets
     */
    public function enqueue_editor_assets() {
        wp_enqueue_script(
            'wpbs-blocks-editor',
            get_template_directory_uri() . '/assets/js/blocks-editor.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-block-editor'),
            filemtime(get_template_directory() . '/assets/js/blocks-editor.js'),
            true
        );

        wp_enqueue_style(
            'wpbs-blocks-editor',
            get_template_directory_uri() . '/assets/css/blocks-editor.css',
            array(),
            filemtime(get_template_directory() . '/assets/css/blocks-editor.css')
        );
    }

    /**
     * Laad frontend assets (indien nodig)
     */
    public function enqueue_frontend_assets() {
        // Bootstrap is al geladen via theme
    }
}

// Initialiseer
WPBS_Bootstrap_Blocks::get_instance();
