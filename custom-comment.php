<?php
// Function to group comments by parent ID
function group_comments_by_parent($comments) {
    $comment_array = array();
    foreach ($comments as $comment) {
        $comment_array[$comment->comment_parent][] = $comment;
    }
    return $comment_array;
}

if (have_comments()) :
?>

<h3 class="comments-title">
    Comments
</h3>
<div class="comments-area">
<?php
    $comments_by_parent = group_comments_by_parent($comments);

    foreach ($comments_by_parent[0] as $comment) :
        $reply_count = isset($comments_by_parent[$comment->comment_ID]) ? count($comments_by_parent[$comment->comment_ID]) : 0;
    ?>

    <div class="comment_wrap">

        <div class="comment main_comment" id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <div>
                    <?php comment_author(); ?>
                    <span class="comment-date">
                        <?php
                        printf(esc_html__('%1$s ago', 'your-theme-textdomain'), human_time_diff(get_comment_time('U'), current_time('timestamp')));
                        ?>
                    </span>
                </div>
                <div class="reply">
                    <?php comment_reply_link(); ?>
                    <a rel="nofollow" class="comment-reply-link" href="#comment-<?php comment_ID(); ?>" data-commentid="<?php comment_ID(); ?>" data-postid="<?php echo get_the_ID();?>" data-belowelement="comment-<?php comment_ID(); ?>" data-respondelement="respond" data-replyto="Reply to <?php comment_author(); ?>" aria-label="Reply to <?php comment_author(); ?>"><i class="fa fa-reply"></i> Reply</a>
                </div>
            </div>
            <div class="comment-content"><?php comment_text(); ?></div>
            <?php
            // Check if this comment has replies (child comments)
             if ($reply_count > 0) : ?>
                <div class="reply-count">
                    <?php
                    printf(_n('View %d reply', 'View %d replies', $reply_count, 'your-theme-textdomain'), $reply_count);
                    ?>
                </div>
                <?php endif; ?>
        </div>
        <?php
        // Check if this comment has replies (child comments)
        if ($reply_count > 0) :
        ?>
            <div class="replies">
                <?php
                // Loop through the replies (child comments)
                foreach ($comments_by_parent[$comment->comment_ID] as $reply) :
                    // Output the reply structure here
                    ?>
                    <div class="comment reply_comment" id="comment-<?php echo $reply->comment_ID; ?>">
                        <div class="comment-author">
                            <div>
                                <?php comment_author($reply); ?>
                                <span class="comment-date">
                                    <?php
                                    printf(esc_html__('%1$s ago', 'your-theme-textdomain'), human_time_diff(get_comment_time('U', $reply), current_time('timestamp')));
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="comment-content"><?php comment_text($reply); ?></div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<?php
endif;  // Display the comment form
comment_form();
?>

<script>
jQuery(document).ready(function($){
    // Initially hide all replies
    $('.comment_wrap .replies').hide();

    // Add a click event handler to elements with class 'display_reply'
    $('.comment_wrap .reply-count').click(function(){
        // Find the closest ancestor with class 'comment_wrap' and then find '.replies' within it
        $(this).closest('.comment_wrap').find('.replies').slideToggle();
    });
});
</script>
