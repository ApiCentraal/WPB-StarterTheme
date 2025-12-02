<?php
/**
 * Template voor het weergeven van een enkel bericht
 * 
 * Pipeline:
 * Browser Request: /blog/artikel → single.php
 *   → get_header() → Enkel artikel met volledige content → get_sidebar() → get_footer()
 */
get_header(); ?>

<div class="row">
    <!-- Content kolom -->
    <div class="col-md-8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-4">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <p class="entry-meta text-muted">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo get_the_date(); ?>
                        </time>
                        · <?php the_author(); ?>
                    </p>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail mb-4">
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                    </div>
                <?php endif; ?>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // Paginatie binnen bericht (<!--nextpage-->)
                wp_link_pages(array(
                    'before' => '<nav class="page-links mt-4">' . __('Pagina\'s:', 'wp-bootstrap-starter'),
                    'after'  => '</nav>',
                ));
                ?>
                
                <footer class="entry-footer mt-4 pt-3 border-top">
                    <?php
                    // Categorieën
                    $categories = get_the_category_list(', ');
                    if ($categories) {
                        printf('<p><strong>%s:</strong> %s</p>', 
                            esc_html__('Categorieën', 'wp-bootstrap-starter'),
                            $categories
                        );
                    }
                    
                    // Tags
                    $tags = get_the_tag_list('', ', ');
                    if ($tags) {
                        printf('<p><strong>%s:</strong> %s</p>',
                            esc_html__('Tags', 'wp-bootstrap-starter'),
                            $tags
                        );
                    }
                    ?>
                </footer>
            </article>
            
            <!-- Post navigatie -->
            <nav class="post-navigation mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-6">
                        <?php previous_post_link('%link', '&laquo; %title'); ?>
                    </div>
                    <div class="col-6 text-end">
                        <?php next_post_link('%link', '%title &raquo;'); ?>
                    </div>
                </div>
            </nav>
            
            <?php
            // Reacties
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
            
        <?php endwhile; endif; ?>
    </div>
    
    <!-- Sidebar kolom -->
    <aside class="col-md-4">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
