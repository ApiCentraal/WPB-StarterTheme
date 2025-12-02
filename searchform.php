<?php
/**
 * Custom zoekformulier template met Bootstrap styling
 *
 * Pipeline:
 * get_search_form() → searchform.php
 *   → Bootstrap input group → Zoekicoon knop
 *
 * @package WP_Bootstrap_Starter
 */

$unique_id = wp_unique_id('search-form-');
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="<?php echo esc_attr($unique_id); ?>" class="screen-reader-text">
        <?php esc_html_e('Zoeken naar:', 'wp-bootstrap-starter'); ?>
    </label>
    <div class="input-group">
        <input 
            type="search" 
            id="<?php echo esc_attr($unique_id); ?>"
            class="form-control search-field" 
            placeholder="<?php esc_attr_e('Zoeken...', 'wp-bootstrap-starter'); ?>" 
            value="<?php echo get_search_query(); ?>" 
            name="s" 
            required
        />
        <button type="submit" class="btn btn-primary search-submit">
            <span class="screen-reader-text"><?php esc_html_e('Zoeken', 'wp-bootstrap-starter'); ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
    </div>
</form>
