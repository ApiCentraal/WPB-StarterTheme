<?php
/**
 * Template Part: Related Posts
 *
 * Toont gerelateerde berichten onder een artikel.
 * Gebruik: get_template_part('template-parts/related-posts');
 *
 * @package WP_Bootstrap_Starter
 * @since 0.2.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Alleen tonen op single posts
if (!is_singular('post')) {
    return;
}

// Instellingen
$posts_per_row = apply_filters('wpbs_related_posts_count', 3);
$related_title = apply_filters('wpbs_related_posts_title', __('Gerelateerde berichten', 'wp-bootstrap-starter'));

// Haal categorieën van huidige post
$categories = get_the_category();

if (empty($categories)) {
    return;
}

// Bouw category ID array
$category_ids = array();
foreach ($categories as $category) {
    $category_ids[] = $category->term_id;
}

// Query voor gerelateerde posts
$related_query = new WP_Query(array(
    'posts_per_page'      => $posts_per_row,
    'post__not_in'        => array(get_the_ID()),
    'category__in'        => $category_ids,
    'ignore_sticky_posts' => true,
    'orderby'             => 'rand',
));

// Als niet genoeg in dezelfde categorie, vul aan met recente posts
if ($related_query->post_count < $posts_per_row) {
    $exclude_ids = array(get_the_ID());
    
    // Voeg gevonden posts toe aan exclude lijst
    if ($related_query->have_posts()) {
        while ($related_query->have_posts()) {
            $related_query->the_post();
            $exclude_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }

    // Nieuwe query voor aanvullende posts
    $additional_posts = $posts_per_row - $related_query->post_count;
    $fallback_query = new WP_Query(array(
        'posts_per_page'      => $additional_posts,
        'post__not_in'        => $exclude_ids,
        'ignore_sticky_posts' => true,
    ));

    // Merge posts
    $all_posts = array_merge($related_query->posts, $fallback_query->posts);
} else {
    $all_posts = $related_query->posts;
}

// Stop als geen posts
if (empty($all_posts)) {
    return;
}

// Bereken kolom breedte
$col_class = 'col-md-4';
if ($posts_per_row === 2) {
    $col_class = 'col-md-6';
} elseif ($posts_per_row === 4) {
    $col_class = 'col-md-6 col-lg-3';
}
?>

<section class="related-posts my-5 pt-4 border-top">
    <h3 class="related-posts-title h4 mb-4"><?php echo esc_html($related_title); ?></h3>

    <div class="row g-4">
        <?php foreach ($all_posts as $post) : 
            setup_postdata($post);
        ?>
            <div class="<?php echo esc_attr($col_class); ?>">
                <article class="card h-100 related-post-card">
                    <?php if (has_post_thumbnail($post)) : ?>
                        <a href="<?php echo get_permalink($post); ?>" class="card-img-top-wrapper">
                            <?php echo get_the_post_thumbnail($post, 'medium', array(
                                'class' => 'card-img-top',
                                'style' => 'height: 180px; object-fit: cover;',
                            )); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo get_permalink($post); ?>" class="card-img-top-wrapper">
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-white fs-1"></i>
                            </div>
                        </a>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title h6">
                            <a href="<?php echo get_permalink($post); ?>" class="text-decoration-none stretched-link">
                                <?php echo get_the_title($post); ?>
                            </a>
                        </h5>

                        <p class="card-text small text-muted">
                            <time datetime="<?php echo get_the_date('c', $post); ?>">
                                <?php echo get_the_date('', $post); ?>
                            </time>
                        </p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php wp_reset_postdata(); ?>
