<?php
/**
 * Template voor het weergeven van een pagina (full-width)
 * 
 * Pipeline:
 * Browser Request: /over-ons → page.php
 *   → get_header() → Pagina content (volledige breedte) → get_footer()
 */
get_header(); ?>

<div class="row">
    <!-- Full-width content kolom -->
    <div class="col-md-12">
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-4">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
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
                // Paginatie binnen pagina (<!--nextpage-->)
                wp_link_pages(array(
                    'before' => '<nav class="page-links mt-4">' . __('Pagina\'s:', 'wp-bootstrap-starter'),
                    'after'  => '</nav>',
                ));
                ?>
            </article>
            
            <?php
            // Reacties (indien ingeschakeld voor pagina's)
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
