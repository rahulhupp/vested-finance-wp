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
    // userInfoo = geoip_detect2_get_info_from_current_ip($ip);
    // echo $userInfoo->country->name;$

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
           $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
           $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
           $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
           $ipaddress = getenv('REMOTE_ADDR');
        else
           $ipaddress = 'UNKNOWN';
   
        return $ipaddress;
   }

    $myipd = get_client_ip(); 
    $userInfoo = geoip_detect2_get_info_from_ip($myipd, NULL);
    echo $userInfoo->country->isoCode;

?>
<?php get_footer(); ?>