<?php
/**
 * WP Bootstrap Navwalker voor Bootstrap 5
 *
 * Aangepaste WordPress nav walker class voor Bootstrap 5 navigatie
 * met dropdown menu support.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!class_exists('WP_Bootstrap_Navwalker')) {
    /**
     * WP_Bootstrap_Navwalker class
     *
     * Pipeline:
     * wp_nav_menu() → WP_Bootstrap_Navwalker
     *   ├─→ start_lvl()  → Opent dropdown <ul>
     *   ├─→ start_el()   → Genereert <li> en <a> met BS5 classes
     *   ├─→ end_el()     → Sluit <li>
     *   └─→ end_lvl()    → Sluit dropdown <ul>
     *
     * @extends Walker_Nav_Menu
     */
    class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {

        /**
         * Start het niveau (submenu/dropdown)
         *
         * @param string   $output Passed by reference.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            
            // Bootstrap 5 dropdown-menu class
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }

        /**
         * Sluit het niveau (submenu/dropdown)
         *
         * @param string   $output Passed by reference.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        /**
         * Start het element (menu item)
         *
         * @param string   $output Passed by reference.
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         * @param int      $id     Current item ID.
         */
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            // CSS classes voor het <li> element
            $classes   = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'nav-item';
            $classes[] = 'menu-item-' . $item->ID;

            // Check of dit item kinderen heeft (dropdown)
            $has_children = in_array('menu-item-has-children', $classes);
            
            if ($has_children && $depth === 0) {
                $classes[] = 'dropdown';
            }

            // Filter de classes
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            // ID attribute
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            // Output het <li> element
            $output .= $indent . '<li' . $id . $class_names . '>';

            // Link attributes
            $atts           = array();
            $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
            $atts['href']   = !empty($item->url) ? $item->url : '';

            // Bootstrap 5 classes voor de link
            if ($depth === 0) {
                $atts['class'] = 'nav-link';
                
                if ($has_children) {
                    $atts['class']          .= ' dropdown-toggle';
                    $atts['role']            = 'button';
                    $atts['data-bs-toggle']  = 'dropdown';
                    $atts['aria-expanded']   = 'false';
                }
            } else {
                // Dropdown items
                $atts['class'] = 'dropdown-item';
            }

            // Active state
            if (in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes)) {
                $atts['class'] .= ' active';
                $atts['aria-current'] = 'page';
            }

            // Filter attributes
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            // Build attributes string
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            // Build the link
            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            // Output
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        /**
         * Sluit het element
         *
         * @param string   $output Passed by reference.
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= "</li>\n";
        }

        /**
         * Fallback functie wanneer geen menu is ingesteld
         *
         * @param array $args wp_nav_menu() arguments.
         */
        public static function fallback($args) {
            if (!current_user_can('edit_theme_options')) {
                return;
            }

            $output = '';

            if ($args['container']) {
                $output .= '<' . esc_attr($args['container']);
                if ($args['container_id']) {
                    $output .= ' id="' . esc_attr($args['container_id']) . '"';
                }
                if ($args['container_class']) {
                    $output .= ' class="' . esc_attr($args['container_class']) . '"';
                }
                $output .= '>';
            }

            $output .= '<ul';
            if ($args['menu_id']) {
                $output .= ' id="' . esc_attr($args['menu_id']) . '"';
            }
            if ($args['menu_class']) {
                $output .= ' class="' . esc_attr($args['menu_class']) . '"';
            }
            $output .= '>';

            $output .= '<li class="nav-item">';
            $output .= '<a href="' . esc_url(admin_url('nav-menus.php')) . '" class="nav-link">';
            $output .= esc_html__('Menu instellen', 'wp-bootstrap-starter');
            $output .= '</a>';
            $output .= '</li>';

            $output .= '</ul>';

            if ($args['container']) {
                $output .= '</' . esc_attr($args['container']) . '>';
            }

            echo $output;
        }
    }
}
