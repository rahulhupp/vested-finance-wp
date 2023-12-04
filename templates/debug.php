<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php $mycountry  = do_shortcode('[geoip_detect2 property="country"]');  ?>
<?php
    echo $mycountry;
    if ($mycountry === 'India') {
        echo "India";
    } else {
        echo "Global";
    }
?>
<?php get_footer(); ?>