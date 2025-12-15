<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
if ( apply_filters( 'astra_header_profile_gmpg_link', true ) ) {
	?>
	 <link rel="profile" href="https://gmpg.org/xfn/11"> 
	 <?php
} 
?>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>

<!-- Google Tag Manager -->
<script defer>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TMG4BQ9');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-5NBVQLBS78"></script>
<script defer>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5NBVQLBS78');
</script>

</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TMG4BQ9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<a
	class="skip-link screen-reader-text"
	href="#content"
	role="link"
	title="<?php echo esc_attr( astra_default_strings( 'string-header-skip-link', false ) ); ?>">
		<?php echo esc_html( astra_default_strings( 'string-header-skip-link', false ) ); ?>
</a>

<div
<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<?php
		$is_academy_page = false;
		
		// Check if it's a module post type
		if ( is_singular( 'module' ) ) {
			$is_academy_page = true;
		}
		
		// Check if it's a modules taxonomy page
		if ( is_tax( 'modules' ) ) {
			$is_academy_page = true;
		}
		
		// Check if it's the Academy page template
		$page_id = get_the_ID();
		if ( ! $page_id && is_page() ) {
			global $wp_query;
			if ( isset( $wp_query->queried_object_id ) ) {
				$page_id = $wp_query->queried_object_id;
			}
		}
		$page_template = '';
		if ( $page_id ) {
			$page_template = get_page_template_slug( $page_id );
		}
		// Also check via global query object
		if ( empty( $page_template ) && is_page() ) {
			global $wp_query;
			if ( isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->page_template ) ) {
				$page_template = $wp_query->queried_object->page_template;
			}
		}
		$academy_templates = array(
			'templates/page-vested-academy.php',
			'templates/page-academy-home.php',
			'templates/page-academy-module.php',
			'templates/page-academy-login.php',
			'templates/page-academy-signup.php',
			'page-academy-dashboard.php',
		);
		if ( in_array( $page_template, $academy_templates ) ) {
			$is_academy_page = true;
		}
		
		// Quizzes are now stored on chapters, no separate quiz post type
		
		// Check if URL contains /academy/
		if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/academy/' ) !== false ) {
			$is_academy_page = true;
		}

		if ( $is_academy_page ) {
			// Load Academy-specific header
			get_template_part( 'template-parts/header/academy-header' );
			// Don't open content wrapper for Academy pages - templates handle their own structure
		} elseif ( $page_template !== 'templates/page-us.php' ) {
			// Load default Astra header
			astra_header_before();
			astra_header();
			astra_header_after();
		} else {
			astra_content_before();
		}
		?>
	<div id="content" class="site-content">
		<div class="ast-container">
		<?php astra_content_top(); ?>
