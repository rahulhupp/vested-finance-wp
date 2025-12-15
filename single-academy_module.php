<?php
/**
 * Template for displaying single Academy Module posts
 * 
 * This template loads the module page template for backward compatibility
 * 
 * @package Vested Finance WP
 */

// Load the Academy Module page template
$template_path = get_stylesheet_directory() . '/templates/page-academy-module.php';
if ( file_exists( $template_path ) ) {
    include $template_path;
    return;
}

// Fallback to default single template
get_header();
?>

<div class="academy-module-single">
    <h1><?php the_title(); ?></h1>
    <div class="module-content">
        <?php the_content(); ?>
    </div>
</div>

<?php
get_footer();

