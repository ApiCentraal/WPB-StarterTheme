<?php
/**
 * Template voor zoekresultaten
 * 
 * Pipeline:
 * Browser Request: /?s=zoekterm → search.php
 *   → get_header() → Zoekresultaten loop → get_sidebar() → get_footer()
 */
get_header(); ?>

<div class="row">
    <!-- Content kolom -->
    <div class="col-md-8">
        <header class="page-header mb-4">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Zoekresultaten voor: %s', 'wp-bootstrap-starter'),
                    '<span class="search-query">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>
        
        <?php if (have_posts()) : ?>
            
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', 'search'); ?>
            <?php endwhile; ?>
            
            <!-- Paginatie -->
            <nav class="posts-navigation mt-4" aria-label="<?php esc_attr_e('Zoekresultaten navigatie', 'wp-bootstrap-starter'); ?>">
                <?php
                echo paginate_links(array(
                    'prev_text' => __('&laquo; Vorige', 'wp-bootstrap-starter'),
                    'next_text' => __('Volgende &raquo;', 'wp-bootstrap-starter'),
                ));
                ?>
            </nav>
            
        <?php else : ?>
            
            <div class="alert alert-info">
                <p class="mb-3"><?php esc_html_e('Geen resultaten gevonden. Probeer een andere zoekterm.', 'wp-bootstrap-starter'); ?></p>
                <?php get_search_form(); ?>
            </div>
            
        <?php endif; ?>
    </div>
    
    <!-- Sidebar kolom -->
    <aside class="col-md-4">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
