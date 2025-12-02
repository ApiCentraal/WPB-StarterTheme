<?php
/**
 * Social Links Widget
 *
 * Toont social media iconen met links naar profielen.
 * Ondersteunt Bootstrap Icons en Font Awesome.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Social Links Widget Class
 */
class WPBS_Social_Widget extends WP_Widget {

    /**
     * Beschikbare social netwerken met icoon classes
     *
     * @var array
     */
    private $social_networks = array(
        'facebook'  => array('label' => 'Facebook',  'icon' => 'bi-facebook',  'fa' => 'fab fa-facebook-f'),
        'twitter'   => array('label' => 'X (Twitter)', 'icon' => 'bi-twitter-x', 'fa' => 'fab fa-x-twitter'),
        'instagram' => array('label' => 'Instagram', 'icon' => 'bi-instagram', 'fa' => 'fab fa-instagram'),
        'linkedin'  => array('label' => 'LinkedIn',  'icon' => 'bi-linkedin',  'fa' => 'fab fa-linkedin-in'),
        'youtube'   => array('label' => 'YouTube',   'icon' => 'bi-youtube',   'fa' => 'fab fa-youtube'),
        'tiktok'    => array('label' => 'TikTok',    'icon' => 'bi-tiktok',    'fa' => 'fab fa-tiktok'),
        'pinterest' => array('label' => 'Pinterest', 'icon' => 'bi-pinterest', 'fa' => 'fab fa-pinterest-p'),
        'github'    => array('label' => 'GitHub',    'icon' => 'bi-github',    'fa' => 'fab fa-github'),
        'whatsapp'  => array('label' => 'WhatsApp',  'icon' => 'bi-whatsapp',  'fa' => 'fab fa-whatsapp'),
        'telegram'  => array('label' => 'Telegram',  'icon' => 'bi-telegram',  'fa' => 'fab fa-telegram'),
        'email'     => array('label' => 'E-mail',    'icon' => 'bi-envelope',  'fa' => 'fas fa-envelope'),
        'rss'       => array('label' => 'RSS Feed',  'icon' => 'bi-rss',       'fa' => 'fas fa-rss'),
    );

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'wpbs_social_widget',
            __('Social Links', 'wp-bootstrap-starter'),
            array(
                'description' => __('Toont social media iconen met links.', 'wp-bootstrap-starter'),
                'classname'   => 'wpbs-social-widget',
            )
        );
    }

    /**
     * Frontend output
     *
     * @param array $args     Widget argumenten.
     * @param array $instance Widget instance.
     */
    public function widget($args, $instance) {
        $title      = !empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : '';
        $icon_style = !empty($instance['icon_style']) ? $instance['icon_style'] : 'bootstrap';
        $size       = !empty($instance['size']) ? $instance['size'] : 'normal';
        $style      = !empty($instance['style']) ? $instance['style'] : 'icons';
        $new_tab    = !empty($instance['new_tab']) ? true : false;

        // Verzamel actieve links
        $links = array();
        foreach ($this->social_networks as $network => $data) {
            if (!empty($instance[$network])) {
                $links[$network] = array(
                    'url'   => $instance[$network],
                    'label' => $data['label'],
                    'icon'  => ($icon_style === 'fontawesome') ? $data['fa'] : 'bi ' . $data['icon'],
                );
            }
        }

        // Stop als geen links
        if (empty($links)) {
            return;
        }

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        // Size class
        $size_class = '';
        if ($size === 'small') {
            $size_class = 'fs-6';
        } elseif ($size === 'large') {
            $size_class = 'fs-3';
        } else {
            $size_class = 'fs-5';
        }

        // Container
        $container_class = 'wpbs-social-links d-flex flex-wrap gap-2';
        if ($style === 'buttons') {
            $container_class .= ' gap-2';
        }

        echo '<div class="' . esc_attr($container_class) . '">';

        foreach ($links as $network => $data) {
            $target = $new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
            
            if ($style === 'buttons') {
                // Button stijl
                printf(
                    '<a href="%s" class="btn btn-outline-secondary %s" aria-label="%s"%s><i class="%s"></i></a>',
                    esc_url($data['url']),
                    esc_attr($size_class),
                    esc_attr($data['label']),
                    $target,
                    esc_attr($data['icon'])
                );
            } else {
                // Alleen iconen
                printf(
                    '<a href="%s" class="text-body-secondary %s" aria-label="%s"%s><i class="%s"></i></a>',
                    esc_url($data['url']),
                    esc_attr($size_class),
                    esc_attr($data['label']),
                    $target,
                    esc_attr($data['icon'])
                );
            }
        }

        echo '</div>';

        echo $args['after_widget'];
    }

    /**
     * Backend formulier
     *
     * @param array $instance Widget instance.
     * @return void
     */
    public function form($instance) {
        $title      = !empty($instance['title']) ? $instance['title'] : '';
        $icon_style = !empty($instance['icon_style']) ? $instance['icon_style'] : 'bootstrap';
        $size       = !empty($instance['size']) ? $instance['size'] : 'normal';
        $style      = !empty($instance['style']) ? $instance['style'] : 'icons';
        $new_tab    = !empty($instance['new_tab']) ? (bool) $instance['new_tab'] : true;
        ?>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Titel:', 'wp-bootstrap-starter'); ?>
            </label>
            <input 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                type="text" 
                value="<?php echo esc_attr($title); ?>"
            />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('icon_style')); ?>">
                <?php esc_html_e('Icoon bibliotheek:', 'wp-bootstrap-starter'); ?>
            </label>
            <select 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('icon_style')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('icon_style')); ?>"
            >
                <option value="bootstrap" <?php selected($icon_style, 'bootstrap'); ?>>Bootstrap Icons</option>
                <option value="fontawesome" <?php selected($icon_style, 'fontawesome'); ?>>Font Awesome</option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('style')); ?>">
                <?php esc_html_e('Weergave stijl:', 'wp-bootstrap-starter'); ?>
            </label>
            <select 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('style')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('style')); ?>"
            >
                <option value="icons" <?php selected($style, 'icons'); ?>><?php esc_html_e('Alleen iconen', 'wp-bootstrap-starter'); ?></option>
                <option value="buttons" <?php selected($style, 'buttons'); ?>><?php esc_html_e('Buttons', 'wp-bootstrap-starter'); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('size')); ?>">
                <?php esc_html_e('Grootte:', 'wp-bootstrap-starter'); ?>
            </label>
            <select 
                class="widefat" 
                id="<?php echo esc_attr($this->get_field_id('size')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('size')); ?>"
            >
                <option value="small" <?php selected($size, 'small'); ?>><?php esc_html_e('Klein', 'wp-bootstrap-starter'); ?></option>
                <option value="normal" <?php selected($size, 'normal'); ?>><?php esc_html_e('Normaal', 'wp-bootstrap-starter'); ?></option>
                <option value="large" <?php selected($size, 'large'); ?>><?php esc_html_e('Groot', 'wp-bootstrap-starter'); ?></option>
            </select>
        </p>

        <p>
            <input 
                type="checkbox" 
                class="checkbox" 
                id="<?php echo esc_attr($this->get_field_id('new_tab')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('new_tab')); ?>"
                <?php checked($new_tab, true); ?>
            />
            <label for="<?php echo esc_attr($this->get_field_id('new_tab')); ?>">
                <?php esc_html_e('Open links in nieuw tabblad', 'wp-bootstrap-starter'); ?>
            </label>
        </p>

        <hr />
        <p><strong><?php esc_html_e('Social Media URLs:', 'wp-bootstrap-starter'); ?></strong></p>

        <?php foreach ($this->social_networks as $network => $data) : 
            $value = !empty($instance[$network]) ? $instance[$network] : '';
        ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id($network)); ?>">
                    <?php echo esc_html($data['label']); ?>:
                </label>
                <input 
                    class="widefat" 
                    id="<?php echo esc_attr($this->get_field_id($network)); ?>" 
                    name="<?php echo esc_attr($this->get_field_name($network)); ?>" 
                    type="url" 
                    value="<?php echo esc_url($value); ?>"
                    placeholder="https://"
                />
            </p>
        <?php endforeach; ?>
        <?php
    }

    /**
     * Opslaan van widget instellingen
     *
     * @param array $new_instance Nieuwe instance waarden.
     * @param array $old_instance Oude instance waarden.
     * @return array Bijgewerkte instance.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        
        $instance['title']      = sanitize_text_field($new_instance['title']);
        $instance['icon_style'] = sanitize_text_field($new_instance['icon_style']);
        $instance['size']       = sanitize_text_field($new_instance['size']);
        $instance['style']      = sanitize_text_field($new_instance['style']);
        $instance['new_tab']    = !empty($new_instance['new_tab']) ? 1 : 0;

        // Social URLs
        foreach ($this->social_networks as $network => $data) {
            if (!empty($new_instance[$network])) {
                $instance[$network] = esc_url_raw($new_instance[$network]);
            }
        }

        return $instance;
    }
}
