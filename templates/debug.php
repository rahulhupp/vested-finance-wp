<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php $mycountry  = do_shortcode('[geoip_detect2 property="country"]');  ?>
<?php
    $userInfo = geoip_detect2_get_info_from_current_ip();
    echo $userInfo->country->isoCode;
    echo "<br/> <br/> <br/> <br/>";
    echo $mycountry;
    if ($mycountry === 'India') {
        echo "India";
    } else {
        echo "Global";
    }
?>
<?php get_footer(); ?>