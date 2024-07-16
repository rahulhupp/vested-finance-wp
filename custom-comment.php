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
                    <a rel="nofollow" class="comment-reply-link" href="javascript:void(0);" data-commentid="<?php comment_ID(); ?>" data-postid="<?php echo get_the_ID();?>" data-belowelement="comment-<?php comment_ID(); ?>" data-respondelement="respond" data-replyto="Reply to <?php comment_author(); ?>" aria-label="Reply to <?php comment_author(); ?>"><svg fill="#002852" width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#002852"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>reply</title> <path d="M3.488 15.136q0 0.96 0.8 1.472l10.72 7.136q0.416 0.288 0.896 0.32t0.928-0.224 0.704-0.672 0.256-0.896v-3.584q3.456 0 6.208 1.984t3.872 5.152q0.64-1.792 0.64-3.552 0-2.912-1.44-5.376t-3.904-3.904-5.376-1.44v-3.584q0-0.48-0.256-0.896t-0.704-0.672-0.928-0.224-0.896 0.32l-10.72 7.136q-0.8 0.512-0.8 1.504z"></path> </g></svg> Reply</a>
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
