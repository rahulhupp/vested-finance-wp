<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php
    $userInfo = geoip_detect2_get_info_from_current_ip();
    $mycountry = $userInfo->country->isoCode;
    echo "<br/> <br/>";
    echo $mycountry;
    echo "<br/> <br/>";
    if ($mycountry === 'India') {
        echo "India";
    } else {
        echo "Global";
    }
    echo "<br/> ipAddress Start  <br/>";
    echo $userInfo->traits->ipAddress;
    echo " <br/>ipAddress End";
    // $ip = geoip_detect2_get_client_ip();
    // $userInfoo = geoip_detect2_get_info_from_current_ip($ip);
    // echo $userInfoo->country->name;


?>
<?php get_footer(); ?>