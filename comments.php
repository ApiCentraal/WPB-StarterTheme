<?php
/**
 * Template voor reacties (comments)
 * 
 * Pipeline:
 * comments_template() → comments.php
 *   → Reactie formulier + Reactie lijst
 */

// Niet laden als wachtwoord vereist is
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-5 pt-4 border-top">
    
    <?php if (have_comments()) : ?>
        
        <h3 class="comments-title mb-4">
            <?php
            $comment_count = get_comments_number();
            printf(
                esc_html(_n(
                    '%d reactie',
                    '%d reacties',
                    $comment_count,
                    'wp-bootstrap-starter'
                )),
                $comment_count
            );
            ?>
        </h3>
        
        <ol class="comment-list list-unstyled">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ));
            ?>
        </ol>
        
        <?php
        // Reactie paginatie
        the_comments_navigation(array(
            'prev_text' => __('&laquo; Oudere reacties', 'wp-bootstrap-starter'),
            'next_text' => __('Nieuwere reacties &raquo;', 'wp-bootstrap-starter'),
        ));
        ?>
        
    <?php endif; ?>
    
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <div class="alert alert-secondary">
            <p class="no-comments mb-0"><?php esc_html_e('Reacties zijn gesloten.', 'wp-bootstrap-starter'); ?></p>
        </div>
    <?php endif; ?>
    
    <?php
    // Reactie formulier
    comment_form(array(
        'title_reply'          => __('Laat een reactie achter', 'wp-bootstrap-starter'),
        'title_reply_to'       => __('Reageer op %s', 'wp-bootstrap-starter'),
        'cancel_reply_link'    => __('Annuleren', 'wp-bootstrap-starter'),
        'label_submit'         => __('Reactie plaatsen', 'wp-bootstrap-starter'),
        'class_form'           => 'comment-form mt-4',
        'class_submit'         => 'btn btn-primary',
    ));
    ?>
    
</div>
