<?php
/*
Template name: Page - Global Investing Report
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex, nofollow">
	<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		html, body {
			width: 100%;
			height: 100%;
			overflow: hidden;
		}
		#pdf-container {
			width: 100vw;
			height: 100vh;
			position: fixed;
			top: 0;
			left: 0;
			background: #525252;
		}
		#pdf-embed {
			width: 100%;
			height: 100%;
			border: none;
		}

		#wpadminbar {
			display: none !important;
		}
	</style>
</head>
<body <?php body_class(); ?>>
	<div id="pdf-container">
		<iframe 
			id="pdf-embed"
			src="https://vested-wordpress-media-prod-in.s3.ap-south-1.amazonaws.com/wp-content/uploads/2025/12/15044554/How-India-Invests-Globally-2025-Edition.pdf"
			type="application/pdf"
			title="Global Investing Report">
			<p>Your browser does not support PDFs. 
				<a href="https://vested-wordpress-media-prod-in.s3.ap-south-1.amazonaws.com/wp-content/uploads/2025/12/15044554/How-India-Invests-Globally-2025-Edition.pdf" target="_blank">
					Download the PDF
				</a>
			</p>
		</iframe>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
