<?php
/**
 * Academy Country Restriction ACF Fields
 * 
 * Registers ACF fields for country-based content restrictions
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register ACF fields for country restrictions
 */
function vested_academy_register_country_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// Field group for Chapters (module post type)
	acf_add_local_field_group( array(
		'key' => 'group_chapter_country_restrictions',
		'title' => 'Country Restrictions',
		'fields' => array(
			array(
				'key' => 'field_chapter_hide_countries',
				'label' => 'Hide this Chapter in Countries',
				'name' => 'hide_in_countries',
				'type' => 'select',
				'instructions' => 'Select countries where this chapter should be hidden. If a chapter is hidden, all its modules, topics, and quizzes will also be hidden.',
				'choices' => array(
					'IN' => 'India',
					'US' => 'United States',
					'GB' => 'United Kingdom',
					'CA' => 'Canada',
					'AU' => 'Australia',
					'DE' => 'Germany',
					'FR' => 'France',
					'JP' => 'Japan',
					'CN' => 'China',
					'BR' => 'Brazil',
					// Add more countries as needed
				),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'module',
				),
			),
		),
		'menu_order' => 100,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	) );

	// Field group for Academy Modules (academy_module post type)
	acf_add_local_field_group( array(
		'key' => 'group_module_country_restrictions',
		'title' => 'Country Restrictions',
		'fields' => array(
			array(
				'key' => 'field_module_hide_countries',
				'label' => 'Hide this Module in Countries',
				'name' => 'hide_in_countries',
				'type' => 'select',
				'instructions' => 'Select countries where this module should be hidden. If a module is hidden, all its topics and quizzes will also be hidden.',
				'choices' => array(
					'IN' => 'India',
					'US' => 'United States',
					'GB' => 'United Kingdom',
					'CA' => 'Canada',
					'AU' => 'Australia',
					'DE' => 'Germany',
					'FR' => 'France',
					'JP' => 'Japan',
					'CN' => 'China',
					'BR' => 'Brazil',
				),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
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
		'menu_order' => 100,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	) );

	// Field group for Topics (chapter_topic post type)
	acf_add_local_field_group( array(
		'key' => 'group_topic_country_restrictions',
		'title' => 'Country Restrictions',
		'fields' => array(
			array(
				'key' => 'field_topic_hide_countries',
				'label' => 'Hide this Topic in Countries',
				'name' => 'hide_in_countries',
				'type' => 'select',
				'instructions' => 'Select countries where this topic should be hidden. If a topic is hidden, all its quizzes will also be hidden.',
				'choices' => array(
					'IN' => 'India',
					'US' => 'United States',
					'GB' => 'United Kingdom',
					'CA' => 'Canada',
					'AU' => 'Australia',
					'DE' => 'Germany',
					'FR' => 'France',
					'JP' => 'Japan',
					'CN' => 'China',
					'BR' => 'Brazil',
				),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'chapter_topic',
				),
			),
		),
		'menu_order' => 100,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	) );

	// Field group for Quizzes (quiz post type)
	acf_add_local_field_group( array(
		'key' => 'group_quiz_country_restrictions',
		'title' => 'Country Restrictions',
		'fields' => array(
			array(
				'key' => 'field_quiz_hide_countries',
				'label' => 'Hide this Quiz in Countries',
				'name' => 'hide_in_countries',
				'type' => 'select',
				'instructions' => 'Select countries where this quiz should be hidden.',
				'choices' => array(
					'IN' => 'India',
					'US' => 'United States',
					'GB' => 'United Kingdom',
					'CA' => 'Canada',
					'AU' => 'Australia',
					'DE' => 'Germany',
					'FR' => 'France',
					'JP' => 'Japan',
					'CN' => 'China',
					'BR' => 'Brazil',
				),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'quiz',
				),
			),
		),
		'menu_order' => 100,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
	) );
}
add_action( 'acf/init', 'vested_academy_register_country_fields' );

