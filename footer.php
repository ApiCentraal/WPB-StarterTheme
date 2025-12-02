</main><!-- /.site-main -->

<?php
/**
 * Template voor site footer
 *
 * Pipeline:
 * get_footer() → footer.php
 *   → Footer widgets → Footer menu → Site info → wp_footer() hook → </body></html>
 *
 * @package WP_Bootstrap_Starter
 */

$container = wpbs_get_container_type();
$has_footer_widgets = is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3');
?>

<?php if ($has_footer_widgets) : ?>
<!-- Footer Widget Area -->
<div id="wrapper-footer-widgets" class="footer-widgets bg-dark text-light py-5">
    <div class="<?php echo esc_attr($container); ?>">
        <div class="row">
            <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="col-md-4">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
            <?php endif; ?>
            
            <?php if (is_active_sidebar('footer-2')) : ?>
            <div class="col-md-4">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
            <?php endif; ?>
            
            <?php if (is_active_sidebar('footer-3')) : ?>
            <div class="col-md-4">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Footer -->
<footer class="site-footer bg-light py-4" id="colophon">
    <div class="<?php echo esc_attr($container); ?>">
        <div class="row align-items-center">
            <!-- Site Info -->
            <div class="col-md-6 text-center text-md-start">
                <div class="site-info">
                    <?php wpbs_site_info(); ?>
                </div>
            </div>
            
            <!-- Footer Menu -->
            <div class="col-md-6 text-center text-md-end">
                <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer Menu', 'wp-bootstrap-starter'); ?>">
                    <?php
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container'      => false,
                            'menu_class'     => 'menu list-inline mb-0',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ));
                    }
                    ?>
                </nav>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#page" class="back-to-top btn btn-primary" aria-label="<?php esc_attr_e('Terug naar boven', 'wp-bootstrap-starter'); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
    </svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
