<?php
/**
 * Sidebar template met widget gebied
 * 
 * Pipeline:
 * get_sidebar() → sidebar.php
 *   → dynamic_sidebar('primary-sidebar') → Widget output
 */
?>

<aside class="widget-area">
    <?php if (is_active_sidebar('primary-sidebar')) : ?>
        
        <?php dynamic_sidebar('primary-sidebar'); ?>
        
    <?php else : ?>
        
        <!-- Fallback wanneer geen widgets actief zijn -->
        <div class="card mb-3">
            <div class="card-body">
                <p class="mb-0">
                    <?php 
                    printf(
                        esc_html__('Voeg widgets toe via %sWeergave → Widgets%s', 'wp-bootstrap-starter'),
                        '<a href="' . esc_url(admin_url('widgets.php')) . '">',
                        '</a>'
                    );
                    ?>
                </p>
            </div>
        </div>
        
    <?php endif; ?>
</aside>
