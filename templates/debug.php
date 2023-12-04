<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php echo do_shortcode('[geoip_detect2 property="country.name" default="(country could not be detected)" lang="en"]')  ?>
<?php get_footer(); ?>