<?php

/**
 * The blog template file.
 *
 */

get_header();

?>

<div id="content" class="blog-wrapper blog-single page-wrapper">
	<div class="ast-container">
		<?php
		$post = get_post();

		// Get the post type
		$post_type = get_post_type($post);

		// Output the post type
		echo 'Post Type: ' . esc_html($post_type);
		?>

		<?php echo the_content(); ?>
	</div>
</div>
<?php get_footer();
