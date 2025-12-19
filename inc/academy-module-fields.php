<?php
/**
 * Academy Module Page ACF Fields
 * 
 * Registers ACF fields for Academy Module post type
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ACF fields for Academy Module
 */
function vested_academy_register_module_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
		'key' => 'group_academy_module',
		'title' => 'Academy Module Fields',
		'fields' => array(
			// Rating Section Tab
			array(
				'key' => 'field_tab_rating',
				'label' => 'Rating Section',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_rating_avatars',
				'label' => 'Rating Avatars',
				'name' => 'rating_avatars',
				'type' => 'repeater',
				'layout' => 'table',
				'sub_fields' => array(
					array(
						'key' => 'field_avatar_image',
						'label' => 'Avatar Image',
						'name' => 'avatar_image',
						'type' => 'image',
						'return_format' => 'url',
						'preview_size' => 'thumbnail',
					),
				),
				'min' => 1,
				'max' => 4,
			),
			array(
				'key' => 'field_rating_value',
				'label' => 'Rating Value',
				'name' => 'rating_value',
				'type' => 'text',
			),
			array(
				'key' => 'field_rating_text',
				'label' => 'Rating Text',
				'name' => 'rating_text',
				'type' => 'text',
			),
			
			// About Module Tab
			array(
				'key' => 'field_tab_about',
				'label' => 'About Module',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_about_title',
				'label' => 'About Title',
				'name' => 'about_title',
				'type' => 'text',
			),
			array(
				'key' => 'field_about_content',
				'label' => 'About Content',
				'name' => 'about_content',
				'type' => 'wysiwyg',
				'toolbar' => 'full',
				'media_upload' => 1,
			),
			array(
				'key' => 'field_course_structure_title',
				'label' => 'Course Structure Title',
				'name' => 'course_structure_title',
				'type' => 'text',
			),
			
			// Sidebar Tab
			array(
				'key' => 'field_tab_sidebar',
				'label' => 'Sidebar',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_academy_logo',
				'label' => 'Academy Logo',
				'name' => 'academy_logo',
				'type' => 'image',
				'return_format' => 'url',
				'preview_size' => 'medium',
			),
			array(
				'key' => 'field_module_skills',
				'label' => 'Skills You Will Gain',
				'name' => 'module_skills',
				'type' => 'repeater',
				'layout' => 'table',
				'sub_fields' => array(
					array(
						'key' => 'field_skill_text',
						'label' => 'Skill Text',
						'name' => 'skill_text',
						'type' => 'text',
					),
				),
			),
			
			// Download App Tab
			array(
				'key' => 'field_tab_download',
				'label' => 'Download App',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_download_title',
				'label' => 'Download Title',
				'name' => 'download_title',
				'type' => 'text',
			),
			array(
				'key' => 'field_download_description',
				'label' => 'Download Description',
				'name' => 'download_description',
				'type' => 'textarea',
				'rows' => 3,
			),
			array(
				'key' => 'field_download_buttons',
				'label' => 'Download Buttons',
				'name' => 'download_buttons',
				'type' => 'repeater',
				'layout' => 'table',
				'sub_fields' => array(
					array(
						'key' => 'field_button_icon',
						'label' => 'Button Icon',
						'name' => 'button_icon',
						'type' => 'image',
						'return_format' => 'url',
						'preview_size' => 'thumbnail',
					),
					array(
						'key' => 'field_button_text',
						'label' => 'Button Text',
						'name' => 'button_text',
						'type' => 'text',
					),
					array(
						'key' => 'field_button_url',
						'label' => 'Button URL',
						'name' => 'button_url',
						'type' => 'url',
					),
				),
				'min' => 1,
				'max' => 2,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'academy_module',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	) );
}
add_action( 'acf/init', 'vested_academy_register_module_fields' );
