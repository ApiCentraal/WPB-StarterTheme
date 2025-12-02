<?php
/**
 * Template voor 404 foutpagina's
 * 
 * Pipeline:
 * Browser Request: /niet-bestaande-pagina → 404.php
 *   → get_header() → Foutmelding → get_sidebar() → get_footer()
 */
get_header(); ?>

<div class="row">
    <!-- Content kolom -->
    <div class="col-md-8">
        <article class="error-404 not-found">
            <header class="entry-header mb-4">
                <h1 class="entry-title">
                    <?php esc_html_e('404 — Pagina niet gevonden', 'wp-bootstrap-starter'); ?>
                </h1>
            </header>
            
            <div class="entry-content">
                <div class="alert alert-warning">
                    <p class="mb-0">
                        <?php esc_html_e('De opgevraagde pagina kon niet worden gevonden. Misschien helpt zoeken?', 'wp-bootstrap-starter'); ?>
                    </p>
                </div>
                
                <!-- Zoekformulier -->
                <div class="search-form-wrapper my-4">
                    <?php get_search_form(); ?>
                </div>
                
                <!-- Recente berichten -->
                <div class="recent-posts mt-4">
                    <h3><?php esc_html_e('Recente berichten', 'wp-bootstrap-starter'); ?></h3>
                    <ul class="list-group">
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish',
                        ));
                        
                        foreach ($recent_posts as $post) {
                            printf(
                                '<li class="list-group-item"><a href="%s">%s</a></li>',
                                esc_url(get_permalink($post['ID'])),
                                esc_html($post['post_title'])
                            );
                        }
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div>
        </article>
    </div>
    
    <!-- Sidebar kolom -->
    <aside class="col-md-4">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
