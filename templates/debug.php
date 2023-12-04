<?php
/*
Template name: Page - Debug
*/
get_header(); ?>
<?php
    
    echo "<br/> <br/>";
    $record = geoip_detect2_get_info_from_ip('87.200.16.47', [ 0 => 'en' ]);
    echo "$record";
    echo $record->country->name;


?>
<?php get_footer(); ?>