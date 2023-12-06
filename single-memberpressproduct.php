<?php

/**
 * The blog template file.
 *
 */

get_header();

?>
<style>
	.main_content {
		max-width: 700px;
		margin-left: auto;
		margin-right: auto;
		padding: 60px 0;
	}

	.main_content h1 {
		margin: 0 !important;
		font-size: 30px;
	}

	.main_content {
		max-width: 700px;
		margin-left: auto;
		margin-right: auto;
		padding: 60px 0;
	}

	.main_content h1 {
		margin-top: 0 !important;
		font-size: 22px;
		font-weight: 400;
		margin-bottom: 20px;
	}

	.main_content h4 {
		font-size: 16px;
		font-weight: 400;
		margin-bottom: 10px;
	}

	.main_content h2 {
		font-size: 24px;
		font-weight: 600;
		margin-bottom: 20px;
	}

	@media (max-width: 767px) {
		.main_content h1 {
			font-size: 20px !important;
		}
	}
</style>

<div id="content" class="blog-wrapper blog-single page-wrapper">
	<div class="ast-container">
		<?php
		$post = get_post();
		?>
		<div class="main_content">
			<?php echo the_content(); ?>
		</div>

	</div>
</div>
<?php get_footer();
