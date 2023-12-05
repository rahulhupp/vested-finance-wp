<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php $mycountry  = do_shortcode('[geoip_detect2 property="country"]');  ?>
<?php
    $userInfo = geoip_detect2_get_info_from_current_ip();
    echo $userInfo->country->isoCode;
    echo "<br/> <br/>";
    echo $mycountry;
    echo "<br/> <br/>";
    if ($mycountry === 'India') {
        echo "India";
    } else {
        echo "Global";
    }
    echo "<br/> <br/> <br/> <br/>";
    $ip = geoip_detect2_get_client_ip();
    $userInfoo = geoip_detect2_get_info_from_current_ip($ip);
    echo $userInfoo->country->name;


?>
<?php get_footer(); ?>