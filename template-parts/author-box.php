<?php
/**
 * Template Part: Author Box
 *
 * Toont auteur informatie onder berichten.
 * Gebruik: get_template_part('template-parts/author-box');
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Haal auteur data op
$author_id          = get_the_author_meta('ID');
$author_name        = get_the_author();
$author_description = get_the_author_meta('description');
$author_url         = get_author_posts_url($author_id);
$author_website     = get_the_author_meta('url');
$author_posts_count = count_user_posts($author_id);

// Social links (indien ingevuld in user profiel)
$author_twitter   = get_the_author_meta('twitter');
$author_facebook  = get_the_author_meta('facebook');
$author_linkedin  = get_the_author_meta('linkedin');
$author_instagram = get_the_author_meta('instagram');

// Alleen tonen als er een bio is
if (empty($author_description)) {
    return;
}
?>

<aside class="author-box card mb-4">
    <div class="card-body">
        <div class="d-flex gap-3">
            <!-- Avatar -->
            <div class="author-avatar flex-shrink-0">
                <a href="<?php echo esc_url($author_url); ?>">
                    <?php echo get_avatar($author_id, 100, '', $author_name, array('class' => 'rounded-circle')); ?>
                </a>
            </div>

            <!-- Info -->
            <div class="author-info flex-grow-1">
                <h4 class="author-name h5 mb-1">
                    <a href="<?php echo esc_url($author_url); ?>" class="text-decoration-none">
                        <?php echo esc_html($author_name); ?>
                    </a>
                </h4>

                <p class="author-meta text-muted small mb-2">
                    <?php
                    printf(
                        /* translators: %d: aantal berichten */
                        esc_html(_n('%d bericht', '%d berichten', $author_posts_count, 'wp-bootstrap-starter')),
                        $author_posts_count
                    );
                    ?>
                </p>

                <p class="author-bio mb-2">
                    <?php echo wp_kses_post($author_description); ?>
                </p>

                <!-- Social & Website Links -->
                <div class="author-links d-flex flex-wrap gap-2 align-items-center">
                    <?php if (!empty($author_website)) : ?>
                        <a href="<?php echo esc_url($author_website); ?>" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-globe me-1"></i><?php esc_html_e('Website', 'wp-bootstrap-starter'); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($author_twitter)) : ?>
                        <a href="<?php echo esc_url('https://twitter.com/' . $author_twitter); ?>" class="text-body-secondary" aria-label="Twitter" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-twitter-x fs-5"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($author_facebook)) : ?>
                        <a href="<?php echo esc_url($author_facebook); ?>" class="text-body-secondary" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($author_linkedin)) : ?>
                        <a href="<?php echo esc_url($author_linkedin); ?>" class="text-body-secondary" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-linkedin fs-5"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($author_instagram)) : ?>
                        <a href="<?php echo esc_url('https://instagram.com/' . $author_instagram); ?>" class="text-body-secondary" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($author_url); ?>" class="ms-auto small text-decoration-none">
                        <?php esc_html_e('Alle berichten bekijken', 'wp-bootstrap-starter'); ?> &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
