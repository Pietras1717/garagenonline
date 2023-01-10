<?php
if (post_password_required())
    return;
?>
<?php if (have_comments()) : ?>
    <div id="comments" class="comments-area">
        <h2 class="comments-title">
            Komentarze
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol><!-- .comment-list -->

        <?php
        // Are there comments to navigate through?
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
            <nav class="navigation comment-navigation" role="navigation">
                <div class="nav-previous"><?php previous_comments_link(__('&larr; Older', 'projectsengine')); ?></div>
                <div class="nav-next"><?php next_comments_link(__('Newer &rarr;', 'projectsengine')); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation 
        ?>

        <?php if (!comments_open() && get_comments_number()) : ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'projectsengine'); ?></p>
        <?php endif; ?>
    </div><!-- #comments -->
<?php endif; // have_comments() 
?>
<?php render_comment_form() ?>