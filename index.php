<?php
/**
 * De hoofdtemplate voor het weergeven van posts
 * 
 * Pipeline:
 * Browser Request → WordPress Template Hiërarchie → index.php
 *   → get_header() → The Loop → get_sidebar() → get_footer()
 */
get_header(); ?>

<div class="row">
    <!-- Content kolom -->
    <div class="col-md-8">
        <?php if (have_posts()) : ?>
            
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', get_post_type()); ?>
            <?php endwhile; ?>
            
            <!-- Paginatie -->
            <nav class="posts-navigation mt-4" aria-label="<?php esc_attr_e('Posts navigatie', 'wp-bootstrap-starter'); ?>">
                <?php
                echo paginate_links(array(
                    'prev_text' => __('&laquo; Vorige', 'wp-bootstrap-starter'),
                    'next_text' => __('Volgende &raquo;', 'wp-bootstrap-starter'),
                    'type'      => 'list',
                    'class'     => 'pagination',
                ));
                ?>
            </nav>
            
        <?php else : ?>
            
            <div class="alert alert-info">
                <p class="mb-0"><?php esc_html_e('Geen berichten gevonden.', 'wp-bootstrap-starter'); ?></p>
            </div>
            
        <?php endif; ?>
    </div>
    
    <!-- Sidebar kolom -->
    <aside class="col-md-4">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
