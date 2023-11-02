<?php
    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page(array(
            'page_title'    => 'Global General Settings',
            'menu_title'    => 'Global Settings',
            'menu_slug'     => 'global-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));

        acf_add_options_sub_page(array(
                'page_title' => 'Investors Slider',
                'menu_title' => 'Investors Slider',
                'parent_slug'   => 'global-general-settings',
            )
        );

    }
?>