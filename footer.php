<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
	</div>
<?php 

 // Get the current page's ID
 $page_id = get_the_ID();
 
 // Get the value of the custom meta field for the current page
 $custom_meta_value = get_post_meta($page_id, '_custom_page_meta_key', true);
 
 // Check the value and display HTML accordingly
 if ($custom_meta_value === 'global-footer') {
     // Display HTML for the Global Footer
        get_template_part('template-parts/footer/footer-global');
 } elseif ($custom_meta_value === 'india-market') {
     // Display HTML for the India Market Footer
     get_template_part('template-parts/footer/footer-india-market');
 } elseif ($custom_meta_value === 'us-market') {
     // Display HTML for the US Market Footer
     get_template_part('template-parts/footer/footer-us-market');
 } else {
     // Default HTML for other cases
     get_template_part('template-parts/footer/footer-global');
 }
 
	wp_footer(); 
?>
	</body>
</html>