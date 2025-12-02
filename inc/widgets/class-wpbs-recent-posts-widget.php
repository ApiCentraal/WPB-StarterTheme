<?php
/**
 * Recent Posts Widget met Thumbnails
 *
 * Verbeterde versie van de standaard WordPress recent posts widget
 * met uitgelichte afbeeldingen en Bootstrap styling.
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Recent Posts Widget Class
 */
class WPBS_Recent_Posts_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'wpbs_recent_posts_widget',
            __('Recente Berichten (met afbeelding)', 'wp-bootstrap-starter'),
            array(
                'description' => __('Toont recente berichten met thumbnails.', 'wp-bootstrap-starter'),
                'classname'   => 'wpbs-recent-posts-widget',
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
        $title         = !empty($instance['title']) ? apply_filters('widget_title', $instance['title']) : __('Recente Berichten', 'wp-bootstrap-starter');
        $number        = !empty($instance['number']) ? absint($instance['number']) : 5;
        $show_date     = !empty($instance['show_date']) ? true : false;
        $show_thumb    = !empty($instance['show_thumb']) ? true : false;
        $show_excerpt  = !empty($instance['show_excerpt']) ? true : false;
        $excerpt_length = !empty($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 10;
        $category      = !empty($instance['category']) ? absint($instance['category']) : 0;

        // Query argumenten
        $query_args = array(
            'posts_per_page'      => $number,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        );

        if ($category > 0) {
            $query_args['cat'] = $category;
        }

        $recent_posts = new WP_Query($query_args);

        if (!$recent_posts->have_posts()) {
            return;
        }

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        echo '<div class="wpbs-recent-posts-list">';

        while ($recent_posts->have_posts()) {
            $recent_posts->the_post();
            ?>
            <article class="wpbs-recent-post d-flex gap-3 mb-3 pb-3 border-bottom">
                <?php if ($show_thumb && has_post_thumbnail()) : ?>
                    <div class="wpbs-recent-post-thumb flex-shrink-0">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('thumbnail', array('class' => 'rounded', 'style' => 'width: 80px; height: 80px; object-fit: cover;')); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="wpbs-recent-post-content">
                    <h6 class="wpbs-recent-post-title mb-1">
                        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                            <?php the_title(); ?>
                        </a>
                    </h6>

                    <?php if ($show_date) : ?>
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?php echo get_the_date(); ?>
                        </small>
                    <?php endif; ?>

                    <?php if ($show_excerpt) : ?>
                        <p class="wpbs-recent-post-excerpt small text-muted mb-0">
                            <?php echo wp_trim_words(get_the_excerpt(), $excerpt_length, '&hellip;'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </article>
            <?php
        }

        echo '</div>';

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /**
     * Backend formulier
     *
     * @param array $instance Widget instance.
     * @return void
     */
    public function form($instance) {
        $title          = !empty($instance['title']) ? $instance['title'] : __('Recente Berichten', 'wp-bootstrap-starter');
        $number         = !empty($instance['number']) ? absint($instance['number']) : 5;
        $show_date      = !empty($instance['show_date']) ? (bool) $instance['show_date'] : true;
        $show_thumb     = !empty($instance['show_thumb']) ? (bool) $instance['show_thumb'] : true;
        $show_excerpt   = !empty($instance['show_excerpt']) ? (bool) $instance['show_excerpt'] : false;
        $excerpt_length = !empty($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 10;
        $category       = !empty($instance['category']) ? absint($instance['category']) : 0;
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
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>">
                <?php esc_html_e('Aantal berichten:', 'wp-bootstrap-starter'); ?>
            </label>
            <input 
                class="tiny-text" 
                id="<?php echo esc_attr($this->get_field_id('number')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('number')); ?>" 
                type="number" 
                step="1" 
                min="1" 
                max="20"
                value="<?php echo esc_attr($number); ?>"
                style="width: 60px;"
            />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>">
                <?php esc_html_e('Categorie:', 'wp-bootstrap-starter'); ?>
            </label>
            <?php
            wp_dropdown_categories(array(
                'show_option_all' => __('Alle categorieën', 'wp-bootstrap-starter'),
                'class'           => 'widefat',
                'id'              => $this->get_field_id('category'),
                'name'            => $this->get_field_name('category'),
                'selected'        => $category,
            ));
            ?>
        </p>

        <p>
            <input 
                type="checkbox" 
                class="checkbox" 
                id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>"
                <?php checked($show_thumb, true); ?>
            />
            <label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>">
                <?php esc_html_e('Toon thumbnails', 'wp-bootstrap-starter'); ?>
            </label>
        </p>

        <p>
            <input 
                type="checkbox" 
                class="checkbox" 
                id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('show_date')); ?>"
                <?php checked($show_date, true); ?>
            />
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>">
                <?php esc_html_e('Toon datum', 'wp-bootstrap-starter'); ?>
            </label>
        </p>

        <p>
            <input 
                type="checkbox" 
                class="checkbox" 
                id="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('show_excerpt')); ?>"
                <?php checked($show_excerpt, true); ?>
            />
            <label for="<?php echo esc_attr($this->get_field_id('show_excerpt')); ?>">
                <?php esc_html_e('Toon excerpt', 'wp-bootstrap-starter'); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>">
                <?php esc_html_e('Excerpt lengte (woorden):', 'wp-bootstrap-starter'); ?>
            </label>
            <input 
                class="tiny-text" 
                id="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>" 
                name="<?php echo esc_attr($this->get_field_name('excerpt_length')); ?>" 
                type="number" 
                step="1" 
                min="5" 
                max="50"
                value="<?php echo esc_attr($excerpt_length); ?>"
                style="width: 60px;"
            />
        </p>
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
        
        $instance['title']          = sanitize_text_field($new_instance['title']);
        $instance['number']         = absint($new_instance['number']);
        $instance['category']       = absint($new_instance['category']);
        $instance['show_date']      = !empty($new_instance['show_date']) ? 1 : 0;
        $instance['show_thumb']     = !empty($new_instance['show_thumb']) ? 1 : 0;
        $instance['show_excerpt']   = !empty($new_instance['show_excerpt']) ? 1 : 0;
        $instance['excerpt_length'] = absint($new_instance['excerpt_length']);

        return $instance;
    }
}
