<?php
/**
 * Template part voor het weergeven van post excerpts
 * 
 * Pipeline:
 * get_template_part('template-parts/content', get_post_type())
 *   → content.php → Post excerpt met metadata
 * 
 * Wordt gebruikt in: index.php, archive.php, search.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-4'); ?>>
    <header class="entry-header">
        <h2 class="entry-title h4">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <p class="entry-meta text-muted small mb-2">
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo get_the_date(); ?>
            </time>
            · <?php the_author(); ?>
        </p>
    </header>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-thumbnail mb-3">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', array('class' => 'img-fluid rounded')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="entry-content">
        <?php the_excerpt(); ?>
    </div>
    
    <footer class="entry-footer">
        <a class="btn btn-sm btn-primary" href="<?php the_permalink(); ?>">
            <?php esc_html_e('Lees meer', 'wp-bootstrap-starter'); ?>
        </a>
    </footer>
</article>
