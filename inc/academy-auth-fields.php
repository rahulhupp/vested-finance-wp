<?php
/**
 * Academy Auth Pages ACF Fields
 * 
 * Registers ACF fields for Login and Signup pages
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ACF fields for Academy Auth Pages
 */
function vested_academy_register_auth_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_academy_auth',
		'title' => 'Academy Auth Pages Settings',
		'fields' => array(
			// Logo Image
			array(
				'key' => 'field_auth_logo_image',
				'label' => 'Logo Image',
				'name' => 'academy_auth_logo_image',
				'type' => 'image',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			// Left Column Title
			array(
				'key' => 'field_auth_left_title',
				'label' => 'Left Column Title',
				'name' => 'academy_auth_left_title',
				'type' => 'text',
				'default_value' => 'Why Partner With Vested?',
				'placeholder' => 'Why Partner With Vested?',
			),
			// Features Repeater
			array(
				'key' => 'field_auth_features',
				'label' => 'Features',
				'name' => 'academy_auth_features',
				'type' => 'repeater',
				'layout' => 'block',
				'sub_fields' => array(
					array(
						'key' => 'field_feature_icon',
						'label' => 'Icon Image',
						'name' => 'icon_image',
						'type' => 'image',
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array(
						'key' => 'field_feature_title',
						'label' => 'Title',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_feature_description',
						'label' => 'Description',
						'name' => 'description',
						'type' => 'textarea',
						'rows' => 3,
					),
				),
				'min' => 1,
				'max' => 10,
			),
			// Login Page Title
			array(
				'key' => 'field_auth_login_title',
				'label' => 'Login Page Title',
				'name' => 'academy_auth_login_title',
				'type' => 'text',
				'default_value' => 'Welcome Back',
				'placeholder' => 'Welcome Back',
			),
			// Signup Page Title
			array(
				'key' => 'field_auth_signup_title',
				'label' => 'Signup Page Title',
				'name' => 'academy_auth_signup_title',
				'type' => 'text',
				'default_value' => 'Join Academy',
				'placeholder' => 'Join Academy',
			),
			// Button Text
			array(
				'key' => 'field_auth_button_text',
				'label' => 'Button Text',
				'name' => 'academy_auth_button_text',
				'type' => 'text',
				'default_value' => 'Continue with Vested Account',
				'placeholder' => 'Continue with Vested Account',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'academy-auth-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	) );
}
add_action( 'acf/init', 'vested_academy_register_auth_fields' );
