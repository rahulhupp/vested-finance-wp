<?php get_header(); ?>

<?php
	$category = get_queried_object();
	
	// Check if it's a parent category
	$child_categories = get_term_children($category->term_id, $category->taxonomy);

	if (empty($child_categories)) {
		get_template_part('template-parts/sub-category');
	} else {
		get_template_part('template-parts/main-category');
	}
?>

<?php get_footer(); ?>
