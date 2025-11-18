<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/templates/css-ipo-details-params.css" type="text/css" media="all" />
</head>
<body <?php body_class(); ?>>
	<?php get_template_part('template-parts/ipo/ipo-details-content'); ?>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/templates/js-ipo-details.js"></script>
</body>
</html>