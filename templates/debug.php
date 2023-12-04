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
    echo "<br/> <br/> <br/> <br/>";
    if ($mycountry === 'India') {
        echo "India";
    } else {
        echo "Global";
    }
    echo "<br/> <br/> <br/> <br/>";
    $record = geoip_detect2_get_info_from_ip('87.200.16.47', [ 0 => 'en' ]);
    echo "$record";
    echo $record->country->name


?>
<?php get_footer(); ?>