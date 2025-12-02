<?php
/**
 * Template part voor zoekresultaten
 * 
 * Pipeline:
 * get_template_part('template-parts/content', 'search')
 *   → content-search.php → Compact zoekresultaat item
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mb-4 pb-3 border-bottom'); ?>>
    <header class="entry-header">
        <h2 class="entry-title h5">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        <p class="entry-meta text-muted small mb-2">
            <span class="post-type badge bg-secondary me-2">
                <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?>
            </span>
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                <?php echo get_the_date(); ?>
            </time>
        </p>
    </header>
    
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>
