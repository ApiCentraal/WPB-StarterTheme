<?php
/**
 * Bootstrap 5.3 Shortcodes voor WP Bootstrap Starter
 *
 * Geïnspireerd door bootstrap-3-shortcodes, aangepast voor Bootstrap 5.3
 * 
 * @package WP_Bootstrap_Starter
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class WPBS_Shortcodes
 * 
 * Registreert en verwerkt alle Bootstrap 5 shortcodes
 */
class WPBS_Shortcodes {

    /**
     * Instance van deze class
     */
    private static $instance = null;

    /**
     * Counters voor unieke IDs
     */
    private $tabs_count = 0;
    private $accordion_count = 0;
    private $modal_count = 0;
    private $carousel_count = 0;

    /**
     * Singleton pattern
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - registreer alle shortcodes
     */
    private function __construct() {
        $this->register_shortcodes();
    }

    /**
     * Registreer alle shortcodes
     */
    private function register_shortcodes() {
        $shortcodes = array(
            // Grid
            'container',
            'row',
            'column',
            'col',
            
            // Componenten
            'button',
            'btn',
            'alert',
            'badge',
            'card',
            'card-header',
            'card-body',
            'card-footer',
            'progress',
            'spinner',
            
            // Interactief
            'tabs',
            'tab',
            'accordion',
            'accordion-item',
            'collapse',
            'modal',
            'modal-footer',
            'carousel',
            'carousel-item',
            
            // Utilities
            'icon',
            'tooltip',
            'popover',
            'embed-responsive',
            'lead',
            'blockquote',
            'figure',
            'list-group',
            'list-group-item',
        );

        foreach ($shortcodes as $shortcode) {
            $method = 'shortcode_' . str_replace('-', '_', $shortcode);
            if (method_exists($this, $method)) {
                add_shortcode($shortcode, array($this, $method));
            }
        }
    }

    /**
     * Helper: Parse data attributen
     */
    private function parse_data_attributes($data) {
        if (empty($data)) {
            return '';
        }
        
        $output = '';
        $pairs = explode('|', $data);
        
        foreach ($pairs as $pair) {
            $kv = explode(',', $pair, 2);
            if (count($kv) === 2) {
                $output .= sprintf(' data-bs-%s="%s"', 
                    esc_attr(trim($kv[0])), 
                    esc_attr(trim($kv[1]))
                );
            }
        }
        
        return $output;
    }

    /**
     * Helper: Bouw class string
     */
    private function build_classes($base, $classes = array(), $xclass = '') {
        $all = array_filter(array_merge((array) $base, (array) $classes));
        if (!empty($xclass)) {
            $all[] = $xclass;
        }
        return esc_attr(implode(' ', $all));
    }

    // =========================================================================
    // GRID SHORTCODES
    // =========================================================================

    /**
     * [container] - Bootstrap container
     * 
     * @param string $fluid     'true' voor container-fluid
     * @param string $breakpoint sm|md|lg|xl|xxl voor responsive container
     * @param string $xclass    Extra CSS classes
     * @param string $data      Data attributen (key,value|key,value)
     */
    public function shortcode_container($atts, $content = null) {
        $atts = shortcode_atts(array(
            'fluid'      => 'false',
            'breakpoint' => '',
            'xclass'     => '',
            'data'       => '',
        ), $atts, 'container');

        if ($atts['fluid'] === 'true') {
            $class = 'container-fluid';
        } elseif (!empty($atts['breakpoint'])) {
            $class = 'container-' . sanitize_html_class($atts['breakpoint']);
        } else {
            $class = 'container';
        }

        return sprintf(
            '<div class="%s"%s>%s</div>',
            $this->build_classes($class, array(), $atts['xclass']),
            $this->parse_data_attributes($atts['data']),
            do_shortcode($content)
        );
    }

    /**
     * [row] - Bootstrap row
     * 
     * @param string $cols      row-cols-* waarde (1-6 of auto)
     * @param string $gutter    g-0 t/m g-5, of gx-*/gy-* combinatie
     * @param string $align     justify-content-* waarde
     * @param string $valign    align-items-* waarde
     * @param string $xclass    Extra CSS classes
     */
    public function shortcode_row($atts, $content = null) {
        $atts = shortcode_atts(array(
            'cols'    => '',
            'gutter'  => '',
            'align'   => '',
            'valign'  => '',
            'xclass'  => '',
            'data'    => '',
        ), $atts, 'row');

        $classes = array('row');

        if (!empty($atts['cols'])) {
            $classes[] = 'row-cols-' . sanitize_html_class($atts['cols']);
        }
        if (!empty($atts['gutter'])) {
            $classes[] = sanitize_html_class($atts['gutter']);
        }
        if (!empty($atts['align'])) {
            $classes[] = 'justify-content-' . sanitize_html_class($atts['align']);
        }
        if (!empty($atts['valign'])) {
            $classes[] = 'align-items-' . sanitize_html_class($atts['valign']);
        }

        return sprintf(
            '<div class="%s"%s>%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $this->parse_data_attributes($atts['data']),
            do_shortcode($content)
        );
    }

    /**
     * [column] / [col] - Bootstrap column
     * 
     * @param string $xs|sm|md|lg|xl|xxl  Kolom breedte per breakpoint (1-12 of auto)
     * @param string $offset_*            Offset per breakpoint
     * @param string $order               Order class
     * @param string $align               align-self-* waarde
     * @param string $xclass              Extra CSS classes
     */
    public function shortcode_column($atts, $content = null) {
        $atts = shortcode_atts(array(
            'xs'        => '',
            'sm'        => '',
            'md'        => '',
            'lg'        => '',
            'xl'        => '',
            'xxl'       => '',
            'offset_xs' => '',
            'offset_sm' => '',
            'offset_md' => '',
            'offset_lg' => '',
            'offset_xl' => '',
            'offset_xxl'=> '',
            'order'     => '',
            'align'     => '',
            'xclass'    => '',
            'data'      => '',
        ), $atts, 'column');

        $classes = array();

        // Basis column classes
        $breakpoints = array('xs', 'sm', 'md', 'lg', 'xl', 'xxl');
        $has_size = false;

        foreach ($breakpoints as $bp) {
            if (!empty($atts[$bp])) {
                $has_size = true;
                if ($bp === 'xs') {
                    $classes[] = 'col-' . sanitize_html_class($atts[$bp]);
                } else {
                    $classes[] = 'col-' . $bp . '-' . sanitize_html_class($atts[$bp]);
                }
            }
        }

        // Default col als geen size is opgegeven
        if (!$has_size) {
            $classes[] = 'col';
        }

        // Offsets
        foreach ($breakpoints as $bp) {
            $offset_key = 'offset_' . $bp;
            if (!empty($atts[$offset_key])) {
                if ($bp === 'xs') {
                    $classes[] = 'offset-' . sanitize_html_class($atts[$offset_key]);
                } else {
                    $classes[] = 'offset-' . $bp . '-' . sanitize_html_class($atts[$offset_key]);
                }
            }
        }

        // Order
        if (!empty($atts['order'])) {
            $classes[] = 'order-' . sanitize_html_class($atts['order']);
        }

        // Vertical alignment
        if (!empty($atts['align'])) {
            $classes[] = 'align-self-' . sanitize_html_class($atts['align']);
        }

        return sprintf(
            '<div class="%s"%s>%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $this->parse_data_attributes($atts['data']),
            do_shortcode($content)
        );
    }

    // Alias voor column
    public function shortcode_col($atts, $content = null) {
        return $this->shortcode_column($atts, $content);
    }

    // =========================================================================
    // COMPONENT SHORTCODES
    // =========================================================================

    /**
     * [button] / [btn] - Bootstrap button
     * 
     * @param string $type     primary|secondary|success|danger|warning|info|light|dark|link
     * @param string $outline  'true' voor outline variant
     * @param string $size     sm|lg
     * @param string $link     URL
     * @param string $target   _blank|_self|_parent|_top
     * @param string $disabled 'true' voor disabled state
     * @param string $block    'true' voor d-grid wrapper
     */
    public function shortcode_button($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type'     => 'primary',
            'outline'  => 'false',
            'size'     => '',
            'link'     => '#',
            'target'   => '',
            'disabled' => 'false',
            'block'    => 'false',
            'xclass'   => '',
            'data'     => '',
        ), $atts, 'button');

        $classes = array('btn');

        // Type (solid of outline)
        if ($atts['outline'] === 'true') {
            $classes[] = 'btn-outline-' . sanitize_html_class($atts['type']);
        } else {
            $classes[] = 'btn-' . sanitize_html_class($atts['type']);
        }

        // Size
        if (!empty($atts['size'])) {
            $classes[] = 'btn-' . sanitize_html_class($atts['size']);
        }

        // Disabled
        $disabled_attr = '';
        if ($atts['disabled'] === 'true') {
            $classes[] = 'disabled';
            $disabled_attr = ' aria-disabled="true"';
        }

        // Target
        $target_attr = '';
        if (!empty($atts['target'])) {
            $target_attr = sprintf(' target="%s"', esc_attr($atts['target']));
            if ($atts['target'] === '_blank') {
                $target_attr .= ' rel="noopener noreferrer"';
            }
        }

        $button = sprintf(
            '<a href="%s" class="%s"%s%s%s>%s</a>',
            esc_url($atts['link']),
            $this->build_classes($classes, array(), $atts['xclass']),
            $target_attr,
            $disabled_attr,
            $this->parse_data_attributes($atts['data']),
            do_shortcode($content)
        );

        // Block button wrapper
        if ($atts['block'] === 'true') {
            $button = '<div class="d-grid gap-2">' . $button . '</div>';
        }

        return $button;
    }

    // Alias voor button
    public function shortcode_btn($atts, $content = null) {
        return $this->shortcode_button($atts, $content);
    }

    /**
     * [alert] - Bootstrap alert
     * 
     * @param string $type        primary|secondary|success|danger|warning|info|light|dark
     * @param string $dismissible 'true' voor sluitknop
     * @param string $heading     Optionele heading
     */
    public function shortcode_alert($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type'        => 'primary',
            'dismissible' => 'false',
            'heading'     => '',
            'xclass'      => '',
            'data'        => '',
        ), $atts, 'alert');

        $classes = array('alert', 'alert-' . sanitize_html_class($atts['type']));
        $dismiss_btn = '';

        if ($atts['dismissible'] === 'true') {
            $classes[] = 'alert-dismissible';
            $classes[] = 'fade';
            $classes[] = 'show';
            $dismiss_btn = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="' . esc_attr__('Sluiten', 'wp-bootstrap-starter') . '"></button>';
        }

        $heading_html = '';
        if (!empty($atts['heading'])) {
            $heading_html = sprintf('<h4 class="alert-heading">%s</h4>', esc_html($atts['heading']));
        }

        return sprintf(
            '<div class="%s" role="alert"%s>%s%s%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $this->parse_data_attributes($atts['data']),
            $dismiss_btn,
            $heading_html,
            do_shortcode($content)
        );
    }

    /**
     * [badge] - Bootstrap badge
     * 
     * @param string $type   primary|secondary|success|danger|warning|info|light|dark
     * @param string $pill   'true' voor rounded-pill
     */
    public function shortcode_badge($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type'   => 'primary',
            'pill'   => 'false',
            'xclass' => '',
        ), $atts, 'badge');

        $classes = array('badge', 'text-bg-' . sanitize_html_class($atts['type']));

        if ($atts['pill'] === 'true') {
            $classes[] = 'rounded-pill';
        }

        return sprintf(
            '<span class="%s">%s</span>',
            $this->build_classes($classes, array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    /**
     * [card] - Bootstrap card
     * 
     * @param string $title   Card title
     * @param string $img     Image URL
     * @param string $img_pos top|bottom
     * @param string $footer  Footer tekst
     */
    public function shortcode_card($atts, $content = null) {
        $atts = shortcode_atts(array(
            'title'   => '',
            'img'     => '',
            'img_pos' => 'top',
            'footer'  => '',
            'xclass'  => '',
            'data'    => '',
        ), $atts, 'card');

        $img_html = '';
        if (!empty($atts['img'])) {
            $img_class = $atts['img_pos'] === 'bottom' ? 'card-img-bottom' : 'card-img-top';
            $img_html = sprintf('<img src="%s" class="%s" alt="">', esc_url($atts['img']), $img_class);
        }

        $title_html = '';
        if (!empty($atts['title'])) {
            $title_html = sprintf('<h5 class="card-title">%s</h5>', esc_html($atts['title']));
        }

        $footer_html = '';
        if (!empty($atts['footer'])) {
            $footer_html = sprintf('<div class="card-footer">%s</div>', esc_html($atts['footer']));
        }

        $body = sprintf(
            '<div class="card-body">%s<div class="card-text">%s</div></div>',
            $title_html,
            do_shortcode($content)
        );

        $card_content = $atts['img_pos'] === 'bottom' 
            ? $body . $img_html 
            : $img_html . $body;

        return sprintf(
            '<div class="%s"%s>%s%s</div>',
            $this->build_classes('card', array(), $atts['xclass']),
            $this->parse_data_attributes($atts['data']),
            $card_content,
            $footer_html
        );
    }

    /**
     * [card-header], [card-body], [card-footer] - Card onderdelen
     */
    public function shortcode_card_header($atts, $content = null) {
        $atts = shortcode_atts(array('xclass' => ''), $atts);
        return sprintf('<div class="%s">%s</div>', 
            $this->build_classes('card-header', array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    public function shortcode_card_body($atts, $content = null) {
        $atts = shortcode_atts(array('xclass' => ''), $atts);
        return sprintf('<div class="%s">%s</div>', 
            $this->build_classes('card-body', array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    public function shortcode_card_footer($atts, $content = null) {
        $atts = shortcode_atts(array('xclass' => ''), $atts);
        return sprintf('<div class="%s">%s</div>', 
            $this->build_classes('card-footer', array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    /**
     * [progress] - Bootstrap progress bar
     * 
     * @param string $value     0-100
     * @param string $type      primary|success|info|warning|danger
     * @param string $striped   'true' voor striped
     * @param string $animated  'true' voor animatie
     * @param string $label     'true' om percentage te tonen
     */
    public function shortcode_progress($atts, $content = null) {
        $atts = shortcode_atts(array(
            'value'    => '0',
            'type'     => '',
            'striped'  => 'false',
            'animated' => 'false',
            'label'    => 'false',
            'height'   => '',
            'xclass'   => '',
        ), $atts, 'progress');

        $value = intval($atts['value']);
        $value = max(0, min(100, $value));

        $bar_classes = array('progress-bar');
        if (!empty($atts['type'])) {
            $bar_classes[] = 'bg-' . sanitize_html_class($atts['type']);
        }
        if ($atts['striped'] === 'true') {
            $bar_classes[] = 'progress-bar-striped';
        }
        if ($atts['animated'] === 'true') {
            $bar_classes[] = 'progress-bar-animated';
        }

        $label_text = $atts['label'] === 'true' ? $value . '%' : '';

        $style = '';
        if (!empty($atts['height'])) {
            $style = sprintf(' style="height: %s"', esc_attr($atts['height']));
        }

        return sprintf(
            '<div class="%s" role="progressbar" aria-valuenow="%d" aria-valuemin="0" aria-valuemax="100"%s>
                <div class="%s" style="width: %d%%">%s</div>
            </div>',
            $this->build_classes('progress', array(), $atts['xclass']),
            $value,
            $style,
            esc_attr(implode(' ', $bar_classes)),
            $value,
            $label_text
        );
    }

    /**
     * [spinner] - Bootstrap spinner
     * 
     * @param string $type   border|grow
     * @param string $color  primary|secondary|success|danger|warning|info|light|dark
     * @param string $size   sm voor kleine spinner
     */
    public function shortcode_spinner($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type'   => 'border',
            'color'  => 'primary',
            'size'   => '',
            'xclass' => '',
        ), $atts, 'spinner');

        $classes = array('spinner-' . sanitize_html_class($atts['type']));
        $classes[] = 'text-' . sanitize_html_class($atts['color']);

        if ($atts['size'] === 'sm') {
            $classes[] = 'spinner-' . sanitize_html_class($atts['type']) . '-sm';
        }

        return sprintf(
            '<div class="%s" role="status"><span class="visually-hidden">%s</span></div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            esc_html__('Laden...', 'wp-bootstrap-starter')
        );
    }

    // =========================================================================
    // INTERACTIVE SHORTCODES
    // =========================================================================

    /**
     * [tabs] - Bootstrap tabs container
     * 
     * @param string $type  tabs|pills|underline
     * @param string $fade  'true' voor fade effect
     * @param string $fill  'true' voor nav-fill
     */
    public function shortcode_tabs($atts, $content = null) {
        $this->tabs_count++;
        $tabs_id = 'wpbs-tabs-' . $this->tabs_count;

        $atts = shortcode_atts(array(
            'type'   => 'tabs',
            'fade'   => 'false',
            'fill'   => 'false',
            'xclass' => '',
        ), $atts, 'tabs');

        // Store settings for child [tab] shortcodes
        $GLOBALS['wpbs_tabs_id'] = $tabs_id;
        $GLOBALS['wpbs_tabs_fade'] = $atts['fade'] === 'true';
        $GLOBALS['wpbs_tabs_items'] = array();
        $GLOBALS['wpbs_tabs_first'] = true;

        // Process content to collect tabs
        $processed_content = do_shortcode($content);

        $nav_classes = array('nav');
        $nav_classes[] = 'nav-' . sanitize_html_class($atts['type']);
        if ($atts['fill'] === 'true') {
            $nav_classes[] = 'nav-fill';
        }

        // Build nav tabs
        $nav_items = '';
        foreach ($GLOBALS['wpbs_tabs_items'] as $index => $tab) {
            $active = $index === 0 ? ' active' : '';
            $selected = $index === 0 ? 'true' : 'false';
            $nav_items .= sprintf(
                '<li class="nav-item" role="presentation">
                    <button class="nav-link%s" id="%s-tab" data-bs-toggle="%s" data-bs-target="#%s" type="button" role="tab" aria-controls="%s" aria-selected="%s">%s</button>
                </li>',
                $active,
                esc_attr($tab['id']),
                esc_attr($atts['type'] === 'pills' ? 'pill' : 'tab'),
                esc_attr($tab['id']),
                esc_attr($tab['id']),
                $selected,
                esc_html($tab['title'])
            );
        }

        // Cleanup globals
        unset($GLOBALS['wpbs_tabs_id'], $GLOBALS['wpbs_tabs_fade'], $GLOBALS['wpbs_tabs_items'], $GLOBALS['wpbs_tabs_first']);

        return sprintf(
            '<ul class="%s" id="%s" role="tablist">%s</ul>
            <div class="tab-content">%s</div>',
            $this->build_classes($nav_classes, array(), $atts['xclass']),
            esc_attr($tabs_id),
            $nav_items,
            $processed_content
        );
    }

    /**
     * [tab] - Individuele tab
     * 
     * @param string $title  Tab titel
     * @param string $active 'true' voor actieve tab
     */
    public function shortcode_tab($atts, $content = null) {
        $atts = shortcode_atts(array(
            'title'  => __('Tab', 'wp-bootstrap-starter'),
            'active' => 'false',
            'xclass' => '',
        ), $atts, 'tab');

        if (!isset($GLOBALS['wpbs_tabs_id'])) {
            return do_shortcode($content);
        }

        $tabs_id = $GLOBALS['wpbs_tabs_id'];
        $tab_index = count($GLOBALS['wpbs_tabs_items']);
        $tab_id = $tabs_id . '-' . $tab_index;

        // First tab is active by default
        $is_active = $GLOBALS['wpbs_tabs_first'] || $atts['active'] === 'true';
        if ($GLOBALS['wpbs_tabs_first']) {
            $GLOBALS['wpbs_tabs_first'] = false;
        }

        // Register tab for nav building
        $GLOBALS['wpbs_tabs_items'][] = array(
            'id'    => $tab_id,
            'title' => $atts['title'],
        );

        $classes = array('tab-pane');
        if ($GLOBALS['wpbs_tabs_fade']) {
            $classes[] = 'fade';
            if ($is_active) {
                $classes[] = 'show';
            }
        }
        if ($is_active) {
            $classes[] = 'active';
        }

        return sprintf(
            '<div class="%s" id="%s" role="tabpanel" aria-labelledby="%s-tab" tabindex="0">%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            esc_attr($tab_id),
            esc_attr($tab_id),
            do_shortcode($content)
        );
    }

    /**
     * [accordion] - Bootstrap accordion container
     * 
     * @param string $flush    'true' voor flush style
     * @param string $always_open 'true' om meerdere open te houden
     */
    public function shortcode_accordion($atts, $content = null) {
        $this->accordion_count++;
        $accordion_id = 'wpbs-accordion-' . $this->accordion_count;

        $atts = shortcode_atts(array(
            'flush'       => 'false',
            'always_open' => 'false',
            'xclass'      => '',
        ), $atts, 'accordion');

        $GLOBALS['wpbs_accordion_id'] = $accordion_id;
        $GLOBALS['wpbs_accordion_always_open'] = $atts['always_open'] === 'true';
        $GLOBALS['wpbs_accordion_count'] = 0;

        $classes = array('accordion');
        if ($atts['flush'] === 'true') {
            $classes[] = 'accordion-flush';
        }

        $output = sprintf(
            '<div class="%s" id="%s">%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            esc_attr($accordion_id),
            do_shortcode($content)
        );

        unset($GLOBALS['wpbs_accordion_id'], $GLOBALS['wpbs_accordion_always_open'], $GLOBALS['wpbs_accordion_count']);

        return $output;
    }

    /**
     * [accordion-item] / [collapse] - Accordion item
     * 
     * @param string $title  Item titel
     * @param string $open   'true' voor standaard open
     */
    public function shortcode_accordion_item($atts, $content = null) {
        $atts = shortcode_atts(array(
            'title' => __('Item', 'wp-bootstrap-starter'),
            'open'  => 'false',
            'xclass' => '',
        ), $atts, 'accordion-item');

        if (!isset($GLOBALS['wpbs_accordion_id'])) {
            return do_shortcode($content);
        }

        $accordion_id = $GLOBALS['wpbs_accordion_id'];
        $item_index = $GLOBALS['wpbs_accordion_count']++;
        $item_id = $accordion_id . '-item-' . $item_index;

        $is_open = $atts['open'] === 'true';
        $collapsed_class = $is_open ? '' : ' collapsed';
        $show_class = $is_open ? ' show' : '';

        $parent_attr = '';
        if (!$GLOBALS['wpbs_accordion_always_open']) {
            $parent_attr = sprintf(' data-bs-parent="#%s"', esc_attr($accordion_id));
        }

        return sprintf(
            '<div class="%s">
                <h2 class="accordion-header">
                    <button class="accordion-button%s" type="button" data-bs-toggle="collapse" data-bs-target="#%s" aria-expanded="%s" aria-controls="%s">%s</button>
                </h2>
                <div id="%s" class="accordion-collapse collapse%s"%s>
                    <div class="accordion-body">%s</div>
                </div>
            </div>',
            $this->build_classes('accordion-item', array(), $atts['xclass']),
            $collapsed_class,
            esc_attr($item_id),
            $is_open ? 'true' : 'false',
            esc_attr($item_id),
            esc_html($atts['title']),
            esc_attr($item_id),
            $show_class,
            $parent_attr,
            do_shortcode($content)
        );
    }

    // Alias
    public function shortcode_collapse($atts, $content = null) {
        return $this->shortcode_accordion_item($atts, $content);
    }

    /**
     * [modal] - Bootstrap modal
     * 
     * @param string $title      Modal titel
     * @param string $button     Trigger button tekst
     * @param string $button_type Button type (primary, etc)
     * @param string $size       sm|lg|xl
     * @param string $centered   'true' voor verticaal gecentreerd
     * @param string $scrollable 'true' voor scrollable body
     * @param string $static     'true' voor static backdrop
     */
    public function shortcode_modal($atts, $content = null) {
        $this->modal_count++;
        $modal_id = 'wpbs-modal-' . $this->modal_count;

        $atts = shortcode_atts(array(
            'title'       => '',
            'button'      => __('Open', 'wp-bootstrap-starter'),
            'button_type' => 'primary',
            'size'        => '',
            'centered'    => 'false',
            'scrollable'  => 'false',
            'static'      => 'false',
            'xclass'      => '',
        ), $atts, 'modal');

        $GLOBALS['wpbs_modal_id'] = $modal_id;

        // Dialog classes
        $dialog_classes = array('modal-dialog');
        if (!empty($atts['size'])) {
            $dialog_classes[] = 'modal-' . sanitize_html_class($atts['size']);
        }
        if ($atts['centered'] === 'true') {
            $dialog_classes[] = 'modal-dialog-centered';
        }
        if ($atts['scrollable'] === 'true') {
            $dialog_classes[] = 'modal-dialog-scrollable';
        }

        // Backdrop
        $backdrop_attr = '';
        if ($atts['static'] === 'true') {
            $backdrop_attr = ' data-bs-backdrop="static" data-bs-keyboard="false"';
        }

        // Header
        $header = '';
        if (!empty($atts['title'])) {
            $header = sprintf(
                '<div class="modal-header">
                    <h5 class="modal-title">%s</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="%s"></button>
                </div>',
                esc_html($atts['title']),
                esc_attr__('Sluiten', 'wp-bootstrap-starter')
            );
        }

        // Trigger button
        $trigger = sprintf(
            '<button type="button" class="btn btn-%s" data-bs-toggle="modal" data-bs-target="#%s">%s</button>',
            esc_attr($atts['button_type']),
            esc_attr($modal_id),
            esc_html($atts['button'])
        );

        // Process content (may contain [modal-footer])
        $processed_content = do_shortcode($content);

        // Check if content contains modal-footer
        $footer = '';
        if (isset($GLOBALS['wpbs_modal_footer'])) {
            $footer = $GLOBALS['wpbs_modal_footer'];
            unset($GLOBALS['wpbs_modal_footer']);
        }

        $modal = sprintf(
            '<div class="%s" id="%s" tabindex="-1" aria-hidden="true"%s>
                <div class="%s">
                    <div class="modal-content">
                        %s
                        <div class="modal-body">%s</div>
                        %s
                    </div>
                </div>
            </div>',
            $this->build_classes('modal fade', array(), $atts['xclass']),
            esc_attr($modal_id),
            $backdrop_attr,
            esc_attr(implode(' ', $dialog_classes)),
            $header,
            $processed_content,
            $footer
        );

        unset($GLOBALS['wpbs_modal_id']);

        return $trigger . $modal;
    }

    /**
     * [modal-footer] - Modal footer
     */
    public function shortcode_modal_footer($atts, $content = null) {
        $atts = shortcode_atts(array('xclass' => ''), $atts);
        
        $footer = sprintf(
            '<div class="%s">%s</div>',
            $this->build_classes('modal-footer', array(), $atts['xclass']),
            do_shortcode($content)
        );

        // Store for parent modal
        $GLOBALS['wpbs_modal_footer'] = $footer;
        return '';
    }

    /**
     * [carousel] - Bootstrap carousel
     * 
     * @param string $controls   'true' voor prev/next knoppen
     * @param string $indicators 'true' voor slide indicators
     * @param string $fade       'true' voor fade effect
     * @param string $autoplay   'true' voor autoplay (default true)
     * @param string $interval   Interval in ms
     */
    public function shortcode_carousel($atts, $content = null) {
        $this->carousel_count++;
        $carousel_id = 'wpbs-carousel-' . $this->carousel_count;

        $atts = shortcode_atts(array(
            'controls'   => 'true',
            'indicators' => 'true',
            'fade'       => 'false',
            'autoplay'   => 'true',
            'interval'   => '5000',
            'xclass'     => '',
        ), $atts, 'carousel');

        $GLOBALS['wpbs_carousel_id'] = $carousel_id;
        $GLOBALS['wpbs_carousel_items'] = array();
        $GLOBALS['wpbs_carousel_first'] = true;

        // Process content to collect items
        $processed_content = do_shortcode($content);

        $classes = array('carousel', 'slide');
        if ($atts['fade'] === 'true') {
            $classes[] = 'carousel-fade';
        }

        $ride_attr = $atts['autoplay'] === 'true' ? ' data-bs-ride="carousel"' : '';
        $interval_attr = sprintf(' data-bs-interval="%d"', intval($atts['interval']));

        // Indicators
        $indicators = '';
        if ($atts['indicators'] === 'true' && count($GLOBALS['wpbs_carousel_items']) > 0) {
            $indicator_items = '';
            foreach ($GLOBALS['wpbs_carousel_items'] as $index => $item) {
                $active = $index === 0 ? ' class="active" aria-current="true"' : '';
                $indicator_items .= sprintf(
                    '<button type="button" data-bs-target="#%s" data-bs-slide-to="%d"%s aria-label="Slide %d"></button>',
                    esc_attr($carousel_id),
                    $index,
                    $active,
                    $index + 1
                );
            }
            $indicators = sprintf('<div class="carousel-indicators">%s</div>', $indicator_items);
        }

        // Controls
        $controls = '';
        if ($atts['controls'] === 'true') {
            $controls = sprintf(
                '<button class="carousel-control-prev" type="button" data-bs-target="#%1$s" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">%2$s</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#%1$s" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">%3$s</span>
                </button>',
                esc_attr($carousel_id),
                esc_html__('Vorige', 'wp-bootstrap-starter'),
                esc_html__('Volgende', 'wp-bootstrap-starter')
            );
        }

        $output = sprintf(
            '<div id="%s" class="%s"%s%s>
                %s
                <div class="carousel-inner">%s</div>
                %s
            </div>',
            esc_attr($carousel_id),
            $this->build_classes($classes, array(), $atts['xclass']),
            $ride_attr,
            $interval_attr,
            $indicators,
            $processed_content,
            $controls
        );

        unset($GLOBALS['wpbs_carousel_id'], $GLOBALS['wpbs_carousel_items'], $GLOBALS['wpbs_carousel_first']);

        return $output;
    }

    /**
     * [carousel-item] - Carousel slide
     * 
     * @param string $img     Afbeelding URL
     * @param string $caption Caption tekst
     * @param string $title   Caption titel
     * @param string $active  'true' voor actieve slide
     */
    public function shortcode_carousel_item($atts, $content = null) {
        $atts = shortcode_atts(array(
            'img'     => '',
            'caption' => '',
            'title'   => '',
            'active'  => 'false',
            'xclass'  => '',
        ), $atts, 'carousel-item');

        if (!isset($GLOBALS['wpbs_carousel_id'])) {
            return '';
        }

        // First item is active by default
        $is_active = $GLOBALS['wpbs_carousel_first'] || $atts['active'] === 'true';
        if ($GLOBALS['wpbs_carousel_first']) {
            $GLOBALS['wpbs_carousel_first'] = false;
        }

        // Register item for indicators
        $GLOBALS['wpbs_carousel_items'][] = true;

        $classes = array('carousel-item');
        if ($is_active) {
            $classes[] = 'active';
        }

        // Image of content
        $inner = '';
        if (!empty($atts['img'])) {
            $inner = sprintf('<img src="%s" class="d-block w-100" alt="">', esc_url($atts['img']));
        } else {
            $inner = do_shortcode($content);
        }

        // Caption
        $caption = '';
        if (!empty($atts['title']) || !empty($atts['caption'])) {
            $title_html = !empty($atts['title']) ? sprintf('<h5>%s</h5>', esc_html($atts['title'])) : '';
            $caption_html = !empty($atts['caption']) ? sprintf('<p>%s</p>', esc_html($atts['caption'])) : '';
            $caption = sprintf('<div class="carousel-caption d-none d-md-block">%s%s</div>', $title_html, $caption_html);
        }

        return sprintf(
            '<div class="%s">%s%s</div>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $inner,
            $caption
        );
    }

    // =========================================================================
    // UTILITY SHORTCODES
    // =========================================================================

    /**
     * [icon] - Bootstrap Icon
     * 
     * @param string $name  Icon naam (zonder bi- prefix)
     * @param string $size  Font-size waarde
     * @param string $color Bootstrap color class
     */
    public function shortcode_icon($atts, $content = null) {
        $atts = shortcode_atts(array(
            'name'   => 'star',
            'size'   => '',
            'color'  => '',
            'xclass' => '',
        ), $atts, 'icon');

        $classes = array('bi', 'bi-' . sanitize_html_class($atts['name']));
        if (!empty($atts['color'])) {
            $classes[] = 'text-' . sanitize_html_class($atts['color']);
        }

        $style = '';
        if (!empty($atts['size'])) {
            $style = sprintf(' style="font-size: %s"', esc_attr($atts['size']));
        }

        return sprintf(
            '<i class="%s"%s></i>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $style
        );
    }

    /**
     * [tooltip] - Bootstrap tooltip
     * 
     * @param string $title     Tooltip tekst
     * @param string $placement top|bottom|left|right
     */
    public function shortcode_tooltip($atts, $content = null) {
        $atts = shortcode_atts(array(
            'title'     => '',
            'placement' => 'top',
            'xclass'    => '',
        ), $atts, 'tooltip');

        return sprintf(
            '<span class="%s" data-bs-toggle="tooltip" data-bs-placement="%s" title="%s">%s</span>',
            $this->build_classes('d-inline-block', array(), $atts['xclass']),
            esc_attr($atts['placement']),
            esc_attr($atts['title']),
            do_shortcode($content)
        );
    }

    /**
     * [popover] - Bootstrap popover
     * 
     * @param string $title     Popover titel
     * @param string $content   Popover content (use text= to avoid conflict)
     * @param string $placement top|bottom|left|right
     * @param string $trigger   click|hover|focus
     */
    public function shortcode_popover($atts, $content = null) {
        $atts = shortcode_atts(array(
            'title'     => '',
            'text'      => '',
            'placement' => 'top',
            'trigger'   => 'click',
            'xclass'    => '',
        ), $atts, 'popover');

        $title_attr = !empty($atts['title']) ? sprintf(' title="%s"', esc_attr($atts['title'])) : '';

        return sprintf(
            '<span class="%s" data-bs-toggle="popover" data-bs-placement="%s" data-bs-trigger="%s" data-bs-content="%s"%s tabindex="0">%s</span>',
            $this->build_classes('d-inline-block', array(), $atts['xclass']),
            esc_attr($atts['placement']),
            esc_attr($atts['trigger']),
            esc_attr($atts['text']),
            $title_attr,
            do_shortcode($content)
        );
    }

    /**
     * [embed-responsive] - Responsive embed wrapper
     * 
     * @param string $ratio  1x1|4x3|16x9|21x9
     */
    public function shortcode_embed_responsive($atts, $content = null) {
        $atts = shortcode_atts(array(
            'ratio'  => '16x9',
            'xclass' => '',
        ), $atts, 'embed-responsive');

        return sprintf(
            '<div class="%s">%s</div>',
            $this->build_classes('ratio ratio-' . sanitize_html_class($atts['ratio']), array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    /**
     * [lead] - Lead paragraph
     */
    public function shortcode_lead($atts, $content = null) {
        $atts = shortcode_atts(array('xclass' => ''), $atts);
        return sprintf(
            '<p class="%s">%s</p>',
            $this->build_classes('lead', array(), $atts['xclass']),
            do_shortcode($content)
        );
    }

    /**
     * [blockquote] - Bootstrap blockquote
     * 
     * @param string $cite   Citaat bron
     * @param string $source Bron naam
     */
    public function shortcode_blockquote($atts, $content = null) {
        $atts = shortcode_atts(array(
            'cite'   => '',
            'source' => '',
            'xclass' => '',
        ), $atts, 'blockquote');

        $footer = '';
        if (!empty($atts['cite']) || !empty($atts['source'])) {
            $cite_tag = !empty($atts['source']) 
                ? sprintf('<cite title="%s">%s</cite>', esc_attr($atts['source']), esc_html($atts['source']))
                : '';
            $footer = sprintf('<figcaption class="blockquote-footer">%s %s</figcaption>', esc_html($atts['cite']), $cite_tag);
        }

        return sprintf(
            '<figure class="%s">
                <blockquote class="blockquote"><p>%s</p></blockquote>
                %s
            </figure>',
            $this->build_classes('', array(), $atts['xclass']),
            do_shortcode($content),
            $footer
        );
    }

    /**
     * [figure] - Figure with caption
     * 
     * @param string $img     Image URL
     * @param string $caption Caption tekst
     * @param string $align   start|end|center
     */
    public function shortcode_figure($atts, $content = null) {
        $atts = shortcode_atts(array(
            'img'     => '',
            'caption' => '',
            'align'   => '',
            'xclass'  => '',
        ), $atts, 'figure');

        $classes = array('figure');
        $caption_classes = array('figure-caption');
        if (!empty($atts['align'])) {
            $caption_classes[] = 'text-' . sanitize_html_class($atts['align']);
        }

        $img = !empty($atts['img']) 
            ? sprintf('<img src="%s" class="figure-img img-fluid rounded" alt="">', esc_url($atts['img']))
            : do_shortcode($content);

        $caption = !empty($atts['caption'])
            ? sprintf('<figcaption class="%s">%s</figcaption>', esc_attr(implode(' ', $caption_classes)), esc_html($atts['caption']))
            : '';

        return sprintf(
            '<figure class="%s">%s%s</figure>',
            $this->build_classes($classes, array(), $atts['xclass']),
            $img,
            $caption
        );
    }

    /**
     * [list-group] - List group container
     * 
     * @param string $flush     'true' voor flush style
     * @param string $numbered  'true' voor genummerde lijst
     * @param string $horizontal 'true' of breakpoint voor horizontal
     */
    public function shortcode_list_group($atts, $content = null) {
        $atts = shortcode_atts(array(
            'flush'      => 'false',
            'numbered'   => 'false',
            'horizontal' => '',
            'xclass'     => '',
        ), $atts, 'list-group');

        $classes = array('list-group');
        if ($atts['flush'] === 'true') {
            $classes[] = 'list-group-flush';
        }
        if ($atts['numbered'] === 'true') {
            $classes[] = 'list-group-numbered';
        }
        if (!empty($atts['horizontal'])) {
            if ($atts['horizontal'] === 'true') {
                $classes[] = 'list-group-horizontal';
            } else {
                $classes[] = 'list-group-horizontal-' . sanitize_html_class($atts['horizontal']);
            }
        }

        $tag = $atts['numbered'] === 'true' ? 'ol' : 'ul';

        return sprintf(
            '<%s class="%s">%s</%s>',
            $tag,
            $this->build_classes($classes, array(), $atts['xclass']),
            do_shortcode($content),
            $tag
        );
    }

    /**
     * [list-group-item] - List group item
     * 
     * @param string $type   primary|secondary|success|danger|warning|info|light|dark
     * @param string $active 'true' voor active state
     * @param string $disabled 'true' voor disabled state
     * @param string $link   URL voor action item
     */
    public function shortcode_list_group_item($atts, $content = null) {
        $atts = shortcode_atts(array(
            'type'     => '',
            'active'   => 'false',
            'disabled' => 'false',
            'link'     => '',
            'xclass'   => '',
        ), $atts, 'list-group-item');

        $classes = array('list-group-item');
        if (!empty($atts['type'])) {
            $classes[] = 'list-group-item-' . sanitize_html_class($atts['type']);
        }
        if ($atts['active'] === 'true') {
            $classes[] = 'active';
        }
        if ($atts['disabled'] === 'true') {
            $classes[] = 'disabled';
        }

        if (!empty($atts['link'])) {
            $classes[] = 'list-group-item-action';
            return sprintf(
                '<a href="%s" class="%s"%s>%s</a>',
                esc_url($atts['link']),
                $this->build_classes($classes, array(), $atts['xclass']),
                $atts['disabled'] === 'true' ? ' aria-disabled="true"' : '',
                do_shortcode($content)
            );
        }

        return sprintf(
            '<li class="%s">%s</li>',
            $this->build_classes($classes, array(), $atts['xclass']),
            do_shortcode($content)
        );
    }
}

/**
 * Initialiseer shortcodes
 */
function wpbs_init_shortcodes() {
    WPBS_Shortcodes::get_instance();
}
add_action('init', 'wpbs_init_shortcodes');

/**
 * Initialiseer tooltips en popovers via JavaScript
 */
function wpbs_shortcodes_scripts() {
    global $post;
    
    if (!is_a($post, 'WP_Post')) {
        return;
    }

    // Check of er tooltips of popovers in de content staan
    $has_tooltip = has_shortcode($post->post_content, 'tooltip');
    $has_popover = has_shortcode($post->post_content, 'popover');

    if ($has_tooltip || $has_popover) {
        $script = '';
        
        if ($has_tooltip) {
            $script .= "document.querySelectorAll('[data-bs-toggle=\"tooltip\"]').forEach(el => new bootstrap.Tooltip(el));";
        }
        if ($has_popover) {
            $script .= "document.querySelectorAll('[data-bs-toggle=\"popover\"]').forEach(el => new bootstrap.Popover(el));";
        }

        wp_add_inline_script('bootstrap-js', $script);
    }
}
add_action('wp_enqueue_scripts', 'wpbs_shortcodes_scripts', 20);
