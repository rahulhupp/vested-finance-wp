<?php
/**
 * Academy Functions
 * 
 * Core functions for Academy feature including:
 * - Custom post types registration
 * - Progress tracking
 * - Quiz functionality
 * - Access control
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Academy Custom Post Types
 * 
 * - 'academy_module': Custom post type for modules (replaces taxonomy)
 * - 'module': Existing post type used for chapters
 * - Quizzes are stored directly on chapters via ACF fields.
 */
function vested_academy_register_post_types() {
	// Register Academy Module post type
	$module_labels = array(
		'name'                  => _x( 'Academy Modules', 'Post Type General Name', 'vested-finance-wp' ),
		'singular_name'         => _x( 'Academy Module', 'Post Type Singular Name', 'vested-finance-wp' ),
		'menu_name'             => __( 'Academy Modules', 'vested-finance-wp' ),
		'name_admin_bar'        => __( 'Academy Module', 'vested-finance-wp' ),
		'archives'              => __( 'Module Archives', 'vested-finance-wp' ),
		'attributes'            => __( 'Module Attributes', 'vested-finance-wp' ),
		'parent_item_colon'     => __( 'Parent Module:', 'vested-finance-wp' ),
		'all_items'             => __( 'Modules', 'vested-finance-wp' ),
		'add_new_item'          => __( 'Add New Module', 'vested-finance-wp' ),
		'add_new'               => __( 'Add New', 'vested-finance-wp' ),
		'new_item'              => __( 'New Module', 'vested-finance-wp' ),
		'edit_item'             => __( 'Edit Module', 'vested-finance-wp' ),
		'update_item'           => __( 'Update Module', 'vested-finance-wp' ),
		'view_item'             => __( 'View Module', 'vested-finance-wp' ),
		'view_items'            => __( 'View Modules', 'vested-finance-wp' ),
		'search_items'          => __( 'Search Module', 'vested-finance-wp' ),
		'not_found'             => __( 'Not found', 'vested-finance-wp' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'vested-finance-wp' ),
		'featured_image'        => __( 'Module Image', 'vested-finance-wp' ),
		'set_featured_image'    => __( 'Set module image', 'vested-finance-wp' ),
		'remove_featured_image' => __( 'Remove module image', 'vested-finance-wp' ),
		'use_featured_image'    => __( 'Use as module image', 'vested-finance-wp' ),
		'insert_into_item'      => __( 'Insert into module', 'vested-finance-wp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this module', 'vested-finance-wp' ),
		'items_list'            => __( 'Modules list', 'vested-finance-wp' ),
		'items_list_navigation' => __( 'Modules list navigation', 'vested-finance-wp' ),
		'filter_items_list'     => __( 'Filter modules list', 'vested-finance-wp' ),
	);
	
	$module_args = array(
		'label'                 => __( 'Academy Module', 'vested-finance-wp' ),
		'description'           => __( 'Academy learning modules with full ACF support', 'vested-finance-wp' ),
		'labels'                => $module_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		'taxonomies'            => array(), // We'll use ACF relationship instead
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		// Nest under existing Modules (chapter) menu in admin
		'show_in_menu'          => 'edit.php?post_type=module',
		// menu_position/icon not needed when nesting
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, // We use custom page template
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'academy', 'with_front' => false ),
	);
	
	register_post_type( 'academy_module', $module_args );
}
add_action( 'init', 'vested_academy_register_post_types', 0 );

/**
 * Register Chapter Topic post type (SEO-friendly, indexable topics)
 */
function vested_academy_register_chapter_topic_cpt() {
	$labels = array(
		'name'               => _x( 'Chapter Topics', 'post type general name', 'vested-finance-wp' ),
		'singular_name'      => _x( 'Chapter Topic', 'post type singular name', 'vested-finance-wp' ),
		'menu_name'          => _x( 'Chapter Topics', 'admin menu', 'vested-finance-wp' ),
		'name_admin_bar'     => _x( 'Chapter Topic', 'add new on admin bar', 'vested-finance-wp' ),
		'add_new'            => _x( 'Add New', 'chapter_topic', 'vested-finance-wp' ),
		'add_new_item'       => __( 'Add New Chapter Topic', 'vested-finance-wp' ),
		'new_item'           => __( 'New Chapter Topic', 'vested-finance-wp' ),
		'edit_item'          => __( 'Edit Chapter Topic', 'vested-finance-wp' ),
		'view_item'          => __( 'View Chapter Topic', 'vested-finance-wp' ),
		'all_items'          => __( 'Topics', 'vested-finance-wp' ),
		'search_items'       => __( 'Search Chapter Topics', 'vested-finance-wp' ),
		'not_found'          => __( 'No topics found.', 'vested-finance-wp' ),
		'not_found_in_trash' => __( 'No topics found in Trash.', 'vested-finance-wp' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		// Place under Modules menu
		'show_in_menu'       => 'edit.php?post_type=module',
		'show_in_nav_menus'  => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'hierarchical'       => true,
		'has_archive'        => false,
		'publicly_queryable' => true,
		'show_in_rest'       => true,
		'rewrite'            => array(
			'slug'       => 'academy/%module%/%chapter%',
			'with_front' => false,
		),
		'query_var'          => true,
		// menu_position/icon not needed when nested
	);

	register_post_type( 'chapter_topic', $args );
}
add_action( 'init', 'vested_academy_register_chapter_topic_cpt' );

/**
 * Filter chapter topic permalink to include module and chapter slugs.
 */
function vested_academy_chapter_topic_permalink( $permalink, $post ) {
	if ( $post->post_type !== 'chapter_topic' ) {
		return $permalink;
	}

	$chapter_id = $post->post_parent;
	if ( ! $chapter_id ) {
		return $permalink;
	}

	$chapter_slug = get_post_field( 'post_name', $chapter_id );

	// Get module slug from chapter's modules taxonomy (first term)
	$module_slug = '';
	$terms       = get_the_terms( $chapter_id, 'modules' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$module_slug = $terms[0]->slug;
	}

	if ( empty( $module_slug ) || empty( $chapter_slug ) ) {
		return $permalink;
	}

	return home_url( '/academy/' . $module_slug . '/' . $chapter_slug . '/' . $post->post_name . '/' );
}
add_filter( 'post_type_link', 'vested_academy_chapter_topic_permalink', 10, 2 );

/**
 * Register topic_slug query var.
 */
function vested_academy_add_topic_slug_query_var( $vars ) {
	$vars[] = 'topic_slug';
	return $vars;
}
add_filter( 'query_vars', 'vested_academy_add_topic_slug_query_var' );

/**
 * Rewrite rule to resolve chapter topic URLs for chapter pages.
 * Format: /academy/{module-slug}/{chapter-slug}/{topic-slug}/
 */
function vested_academy_chapter_topic_rewrite() {
	// Add topic slug rewrite tag.
	add_rewrite_tag( '%topic_slug%', '([^/]+)' );

	// Route topic slug requests to the chapter (module post type) and pass topic_slug.
	add_rewrite_rule(
		'^academy/([^/]+)/([^/]+)/([^/]+)/?$',
		'index.php?post_type=module&name=$matches[2]&topic_slug=$matches[3]',
		'top'
	);

	// Chapter URL without topic slug (backward compatibility).
	add_rewrite_rule(
		'^academy/([^/]+)/([^/]+)/?$',
		'index.php?post_type=module&name=$matches[2]',
		'top'
	);
}
add_action( 'init', 'vested_academy_chapter_topic_rewrite' );

/**
 * Build topic URL using topic slug.
 */
function vested_academy_get_topic_url( $chapter_id, $topic_slug ) {
	if ( ! $chapter_id || ! $topic_slug ) {
		return get_permalink( $chapter_id );
	}

	$chapter_slug = get_post_field( 'post_name', $chapter_id );
	if ( ! $chapter_slug ) {
		return get_permalink( $chapter_id );
	}

	$module_slug = '';
	$terms = get_the_terms( $chapter_id, 'modules' );
	if ( $terms && ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$module_slug = $terms[0]->slug;
	} else {
		// Try ACF relationship to academy_module CPT.
		$related_modules = get_field( 'academy_module', $chapter_id );
		if ( $related_modules ) {
			if ( is_array( $related_modules ) ) {
				$module_post = is_object( $related_modules[0] ) ? $related_modules[0] : get_post( $related_modules[0] );
			} elseif ( is_object( $related_modules ) ) {
				$module_post = $related_modules;
			} elseif ( is_numeric( $related_modules ) ) {
				$module_post = get_post( $related_modules );
			}
			if ( ! empty( $module_post ) ) {
				$module_slug = $module_post->post_name;
			}
		}
	}

	if ( empty( $module_slug ) ) {
		return get_permalink( $chapter_id );
	}

	return home_url( '/academy/' . $module_slug . '/' . $chapter_slug . '/' . $topic_slug . '/' );
}

/**
 * Prevent external permalink plugins from redirecting Academy topic URLs.
 * Some plugins (e.g., Permalink Manager) may canonicalize to the chapter URL.
 * We explicitly opt-out when a topic slug is present.
 */
function vested_academy_prevent_permalink_manager_redirect() {
	global $wp_query;

	if ( isset( $wp_query->query_vars['topic_slug'] ) ) {
		$wp_query->query_vars['do_not_redirect'] = 1;
	}
}
add_action( 'template_redirect', 'vested_academy_prevent_permalink_manager_redirect', 0 );

/**
 * Register Quiz post type
 */
function vested_academy_register_quiz_cpt() {
	$labels = array(
		'name'               => _x( 'Quizzes', 'post type general name', 'vested-finance-wp' ),
		'singular_name'      => _x( 'Quiz', 'post type singular name', 'vested-finance-wp' ),
		'menu_name'          => _x( 'Quizzes', 'admin menu', 'vested-finance-wp' ),
		'name_admin_bar'     => _x( 'Quiz', 'add new on admin bar', 'vested-finance-wp' ),
		'add_new'            => _x( 'Add New', 'quiz', 'vested-finance-wp' ),
		'add_new_item'       => __( 'Add New Quiz', 'vested-finance-wp' ),
		'new_item'           => __( 'New Quiz', 'vested-finance-wp' ),
		'edit_item'          => __( 'Edit Quiz', 'vested-finance-wp' ),
		'view_item'          => __( 'View Quiz', 'vested-finance-wp' ),
		'all_items'          => __( 'Quiz', 'vested-finance-wp' ),
		'search_items'       => __( 'Search Quizzes', 'vested-finance-wp' ),
		'not_found'          => __( 'No quizzes found.', 'vested-finance-wp' ),
		'not_found_in_trash' => __( 'No quizzes found in Trash.', 'vested-finance-wp' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		// Place under Modules menu
		'show_in_menu'       => 'edit.php?post_type=module',
		'show_in_nav_menus'  => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'hierarchical'       => false,
		'has_archive'        => false,
		'publicly_queryable' => true,
		'show_in_rest'       => true,
		'rewrite'            => array(
			'slug'       => 'academy/%module%/%chapter%',
			'with_front' => false,
		),
		'query_var'          => true,
	);

	register_post_type( 'quiz', $args );
}
add_action( 'init', 'vested_academy_register_quiz_cpt' );

/**
 * Filter quiz permalink structure
 */
function vested_academy_quiz_permalink( $permalink, $post ) {
	if ( $post->post_type !== 'quiz' ) {
		return $permalink;
	}

	return home_url( '/academy/quiz/' . $post->post_name . '/' );
}
add_filter( 'post_type_link', 'vested_academy_quiz_permalink', 10, 2 );

/**
 * Rewrite rule to resolve quiz URLs
 */
function vested_academy_quiz_rewrite() {
	add_rewrite_rule(
		'^academy/quiz/([^/]+)/?$',
		'index.php?post_type=quiz&name=$matches[1]',
		'top'
	);
}
add_action( 'init', 'vested_academy_quiz_rewrite' );

/**
 * Get quizzes for a module using the quiz_links relationship field
 * Similar to how chapter_topic_links works
 */
function vested_academy_get_quizzes_for_module( $module_id ) {
	if ( ! $module_id ) {
		return array();
	}

	// Get quizzes from relationship field
	$selected = get_field( 'quiz_links', $module_id );
	$quizzes = array();

	// Handle both array and single object/ID (ACF can return either depending on field settings)
	if ( $selected ) {
		// Convert single object/ID to array for consistent processing
		if ( ! is_array( $selected ) ) {
			$selected = array( $selected );
		}
		
		$selected_posts = array();
		foreach ( $selected as $item ) {
			if ( is_object( $item ) ) {
				$selected_posts[] = $item;
			} elseif ( is_numeric( $item ) ) {
				$found = get_post( $item );
				if ( $found ) {
					$selected_posts[] = $found;
				}
			}
		}

		if ( $selected_posts ) {
			foreach ( $selected_posts as $quiz_post ) {
				// Get quiz questions from ACF
				$quiz_questions = get_field( 'quiz_questions', $quiz_post->ID );
				
				$quizzes[] = array(
					'id'            => $quiz_post->ID,
					'title'         => get_the_title( $quiz_post->ID ),
					'questions'     => $quiz_questions ?: array(),
					'passing_score' => get_field( 'passing_score', $quiz_post->ID ) ?: 70,
					'time_limit'    => get_field( 'time_limit', $quiz_post->ID ) ?: 12,
					'content'       => apply_filters( 'the_content', $quiz_post->post_content ),
					'permalink'     => get_permalink( $quiz_post->ID ),
				);
			}
		}
	}

	return $quizzes;
}

/**
 * Ensure modules taxonomy is registered for module post type
 */
function vested_academy_register_quiz_taxonomy() {
	// Check if modules taxonomy exists
	if ( ! taxonomy_exists( 'modules' ) ) {
		// If taxonomy doesn't exist, register it
		$taxonomy_labels = array(
			'name'              => _x( 'Modules', 'taxonomy general name', 'vested-finance-wp' ),
			'singular_name'     => _x( 'Module', 'taxonomy singular name', 'vested-finance-wp' ),
			'search_items'      => __( 'Search Modules', 'vested-finance-wp' ),
			'all_items'         => __( 'All Modules', 'vested-finance-wp' ),
			'parent_item'       => __( 'Parent Module', 'vested-finance-wp' ),
			'parent_item_colon' => __( 'Parent Module:', 'vested-finance-wp' ),
			'edit_item'         => __( 'Edit Module', 'vested-finance-wp' ),
			'update_item'       => __( 'Update Module', 'vested-finance-wp' ),
			'add_new_item'      => __( 'Add New Module', 'vested-finance-wp' ),
			'new_item_name'     => __( 'New Module Name', 'vested-finance-wp' ),
			'menu_name'         => __( 'Modules', 'vested-finance-wp' ),
		);
		
		$taxonomy_args = array(
			'hierarchical'      => true,
			'labels'            => $taxonomy_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'modules' ),
			'show_in_rest'      => true,
		);
		
		register_taxonomy( 'modules', array( 'module' ), $taxonomy_args );
	}
}
add_action( 'init', 'vested_academy_register_quiz_taxonomy', 10 );


/**
 * Hide the Modules taxonomy submenu from admin sidebar
 * Uses multiple hooks and methods to ensure it's removed
 */
function vested_academy_hide_modules_taxonomy_submenu() {
	global $submenu;
	
	// Remove the taxonomy submenu item using multiple methods
	$parent_slug = 'edit.php?post_type=module';
	
	// Try multiple possible taxonomy slug formats
	$possible_slugs = array(
		'edit-tags.php?taxonomy=modules&post_type=module',
		'edit-tags.php?taxonomy=modules',
		'edit-tags.php?taxonomy=modules&amp;post_type=module', // HTML entity version
	);
	
	// Method 1: Use remove_submenu_page for each possible slug
	foreach ( $possible_slugs as $taxonomy_slug ) {
		remove_submenu_page( $parent_slug, $taxonomy_slug );
	}
	
	// Method 2: Directly manipulate the submenu array (more aggressive)
	if ( isset( $submenu[ $parent_slug ] ) && is_array( $submenu[ $parent_slug ] ) ) {
		foreach ( $submenu[ $parent_slug ] as $key => $item ) {
			// Check if this is the taxonomy menu item
			if ( isset( $item[2] ) ) {
				// Check for any variation containing taxonomy=modules
				if ( strpos( $item[2], 'taxonomy=modules' ) !== false || 
					 strpos( $item[2], 'taxonomy%3Dmodules' ) !== false ) { // URL encoded
					unset( $submenu[ $parent_slug ][ $key ] );
				}
			}
		}
		// Re-index array to prevent issues
		$submenu[ $parent_slug ] = array_values( $submenu[ $parent_slug ] );
	}
}

// Try multiple hooks with different priorities to catch it at different stages
add_action( '_admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 999 );
add_action( 'admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 999 );
add_action( 'admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 9999 );

/**
 * Remove unwanted submenu items under Modules.
 * - Add New Chapter
 * - Re-Order
 */
function vested_academy_clean_modules_menu() {
	$parent_slug = 'edit.php?post_type=module';

	// Remove via core helper.
	remove_submenu_page( $parent_slug, 'post-new.php?post_type=module' );
	remove_submenu_page( $parent_slug, 'edit.php?post_type=module&orderby=menu_order&order=asc' );
	remove_submenu_page( $parent_slug, 'edit.php?post_type=module&amp;orderby=menu_order&amp;order=asc' );

	// Extra safety: strip by slug/title if still present.
	global $submenu;
	if ( isset( $submenu[ $parent_slug ] ) && is_array( $submenu[ $parent_slug ] ) ) {
		foreach ( $submenu[ $parent_slug ] as $key => $item ) {
			$slug  = isset( $item[2] ) ? $item[2] : '';
			$title = isset( $item[0] ) ? strip_tags( $item[0] ) : '';

			$is_add_new = strpos( $slug, 'post-new.php?post_type=module' ) !== false
				|| stripos( $title, 'add new' ) !== false;
			$is_reorder = stripos( $slug, 're-order' ) !== false
				|| stripos( $slug, 'reorder' ) !== false
				|| stripos( $slug, 'orderby=menu_order' ) !== false
				|| stripos( $title, 're-order' ) !== false
				|| stripos( $title, 'reorder' ) !== false;

			if ( $is_add_new || $is_reorder ) {
				unset( $submenu[ $parent_slug ][ $key ] );
			}
		}
		$submenu[ $parent_slug ] = array_values( $submenu[ $parent_slug ] );
	}
}
add_action( 'admin_menu', 'vested_academy_clean_modules_menu', 1000 );

/**
 * Add CSS to hide the taxonomy menu item as a fallback
 */
function vested_academy_hide_modules_taxonomy_css() {
	?>
	<style type="text/css">
		/* Hide Modules taxonomy submenu item */
		#adminmenu a[href*="taxonomy=modules"],
		#adminmenu a[href*="taxonomy%3Dmodules"],
		#adminmenu li.wp-submenu a[href*="taxonomy=modules"],
		#adminmenu li.wp-submenu a[href*="taxonomy%3Dmodules"] {
			display: none !important;
		}
		/* Also hide parent li if it only contains the taxonomy link */
		#adminmenu li.wp-has-submenu ul.wp-submenu li:has(a[href*="taxonomy=modules"]) {
			display: none !important;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'vested_academy_hide_modules_taxonomy_css' );

/**
 * Create custom database table for progress tracking
 */
function vested_academy_create_progress_table() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'academy_progress';
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id BIGINT(20) UNSIGNED NOT NULL,
		module_id BIGINT(20) UNSIGNED,
		chapter_id BIGINT(20) UNSIGNED,
		topic_index INT(3) UNSIGNED DEFAULT NULL,
		quiz_id BIGINT(20) UNSIGNED,
		progress_type ENUM('chapter', 'topic', 'quiz', 'module') NOT NULL,
		status ENUM('in_progress', 'completed') DEFAULT 'in_progress',
		progress_percentage INT(3) DEFAULT 0,
		quiz_score INT(3),
		quiz_attempts INT(3) DEFAULT 0,
		started_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		completed_at DATETIME NULL,
		PRIMARY KEY (id),
		KEY user_id (user_id),
		KEY module_id (module_id),
		KEY chapter_id (chapter_id),
		KEY topic_index (topic_index),
		KEY quiz_id (quiz_id),
		KEY user_module (user_id, module_id),
		KEY user_chapter_topic (user_id, chapter_id, topic_index)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

/**
 * Create custom database table for individual quiz question answers
 */
function vested_academy_create_quiz_answers_table() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'academy_quiz_answers';
	$charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id BIGINT(20) UNSIGNED NOT NULL,
		quiz_id BIGINT(20) UNSIGNED NOT NULL,
		question_index INT(3) NOT NULL,
		user_answer TEXT,
		correct_answer TEXT,
		is_correct TINYINT(1) DEFAULT 0,
		answered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (id),
		UNIQUE KEY user_quiz_question (user_id, quiz_id, question_index),
		KEY user_id (user_id),
		KEY quiz_id (quiz_id),
		KEY user_quiz (user_id, quiz_id)
	) $charset_collate;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

/**
 * Initialize progress table on theme activation or when needed
 */
function vested_academy_init_progress_table() {
	vested_academy_create_progress_table();
	vested_academy_create_quiz_answers_table();
}
add_action( 'after_setup_theme', 'vested_academy_init_progress_table' );

// Also create table when admin visits Academy pages
add_action( 'admin_init', 'vested_academy_init_progress_table' );

/**
 * Track chapter progress
 */
function vested_academy_track_chapter_progress( $user_id, $chapter_id, $module_id = null, $progress_percentage = 0 ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	// Check if progress already exists
	$existing = $wpdb->get_row( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter'",
		$user_id,
		$chapter_id
	) );
	
	// Mark as completed at 90% or higher (to account for scroll calculation edge cases)
	$status = ( $progress_percentage >= 90 ) ? 'completed' : 'in_progress';
	$completed_at = ( $progress_percentage >= 90 ) ? current_time( 'mysql' ) : null;
	
	if ( $existing ) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'progress_percentage' => $progress_percentage,
				'status'              => $status,
				'completed_at'        => $completed_at,
			),
			array(
				'user_id'     => $user_id,
				'chapter_id'  => $chapter_id,
				'progress_type' => 'chapter',
			),
			array( '%d', '%s', '%s' ),
			array( '%d', '%d', '%s' )
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id'            => $user_id,
				'module_id'          => $module_id,
				'chapter_id'         => $chapter_id,
				'progress_type'      => 'chapter',
				'status'             => $status,
				'progress_percentage' => $progress_percentage,
				'completed_at'       => $completed_at,
			),
			array( '%d', '%d', '%d', '%s', '%s', '%d', '%s' )
		);
	}
}

/**
 * Track topic progress
 */
function vested_academy_track_topic_progress( $user_id, $chapter_id, $topic_index, $module_id = null, $progress_percentage = 0 ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	// Check if progress already exists
	$existing = $wpdb->get_row( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND topic_index = %d AND progress_type = 'topic'",
		$user_id,
		$chapter_id,
		$topic_index
	) );
	
	$status = ( $progress_percentage >= 90 ) ? 'completed' : 'in_progress';
	$completed_at = ( $progress_percentage >= 90 ) ? current_time( 'mysql' ) : null;
	
	if ( $existing ) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'progress_percentage' => $progress_percentage,
				'status'              => $status,
				'completed_at'        => $completed_at,
			),
			array(
				'user_id'     => $user_id,
				'chapter_id'  => $chapter_id,
				'topic_index' => $topic_index,
				'progress_type' => 'topic',
			),
			array( '%d', '%s', '%s' ),
			array( '%d', '%d', '%d', '%s' )
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id'            => $user_id,
				'module_id'          => $module_id,
				'chapter_id'         => $chapter_id,
				'topic_index'        => $topic_index,
				'progress_type'      => 'topic',
				'status'             => $status,
				'progress_percentage' => $progress_percentage,
				'completed_at'       => $completed_at,
			),
			array( '%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s' )
		);
	}
}

/**
 * Check if topic is completed
 */
function vested_academy_is_topic_completed( $user_id, $chapter_id, $topic_index ) {
	if ( ! $user_id || ! $chapter_id || $topic_index === null ) {
		return false;
	}
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	$progress = $wpdb->get_row( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND topic_index = %d AND progress_type = 'topic' AND status = 'completed'",
		$user_id,
		$chapter_id,
		$topic_index
	) );
	
	return ! empty( $progress );
}

/**
 * Check if all topics in a chapter are completed
 */
function vested_academy_are_all_topics_completed( $user_id, $chapter_id, $topics ) {
	if ( ! $user_id || ! $chapter_id || empty( $topics ) ) {
		return false;
	}
	
	foreach ( $topics as $index => $topic ) {
		if ( ! vested_academy_is_topic_completed( $user_id, $chapter_id, $index ) ) {
			return false;
		}
	}
	
	return true;
}

/**
 * Track quiz attempt and score
 */
function vested_academy_track_quiz_attempt( $user_id, $quiz_id, $module_id = null, $score = 0, $total_questions = 0 ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	// Calculate percentage
	$progress_percentage = ( $total_questions > 0 ) ? round( ( $score / $total_questions ) * 100 ) : 0;
	$status = ( $progress_percentage >= 70 ) ? 'completed' : 'in_progress'; // 70% passing score
	
	// Get existing attempt count
	$existing = $wpdb->get_row( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
		$user_id,
		$quiz_id
	) );
	
	$attempts = $existing ? ( $existing->quiz_attempts + 1 ) : 1;
	$completed_at = ( $status === 'completed' ) ? current_time( 'mysql' ) : null;
	
	if ( $existing ) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'quiz_score'         => $score,
				'progress_percentage' => $progress_percentage,
				'status'             => $status,
				'quiz_attempts'      => $attempts,
				'completed_at'       => $completed_at,
			),
			array( 'id' => $existing->id ),
			array( '%d', '%d', '%s', '%d', '%s' ),
			array( '%d' )
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id'            => $user_id,
				'module_id'          => $module_id,
				'quiz_id'            => $quiz_id,
				'progress_type'      => 'quiz',
				'status'             => $status,
				'progress_percentage' => $progress_percentage,
				'quiz_score'         => $score,
				'quiz_attempts'      => $attempts,
				'completed_at'       => $completed_at,
			),
			array( '%d', '%d', '%d', '%s', '%s', '%d', '%d', '%d', '%s' )
		);
	}
	
	return array(
		'score' => $score,
		'percentage' => $progress_percentage,
		'status' => $status,
		'attempts' => $attempts,
	);
}

/**
 * Get user progress for a module
 */
function vested_academy_get_module_progress( $user_id, $module_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	$progress = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND module_id = %d ORDER BY started_at ASC",
		$user_id,
		$module_id
	) );
	
	return $progress;
}

/**
 * Get user's overall Academy progress
 */
function vested_academy_get_user_progress( $user_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	$progress = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d ORDER BY started_at DESC",
		$user_id
	) );
	
	return $progress;
}

/**
 * Check if user has access to quiz (must be logged in)
 * Returns true/false instead of redirecting
 */
function vested_academy_check_quiz_access( $quiz_id ) {
	return is_user_logged_in();
}

/**
 * Restrict quiz access to logged-in users only
 * Note: This is handled by vested_academy_restrict_access() now
 * Keeping for backward compatibility but it won't redirect since vested_academy_restrict_access runs first
 */
function vested_academy_restrict_quiz_access() {
	// This is now handled by vested_academy_restrict_access()
	// Only quizzes require login, all other pages are public
}
// Removed action hook - handled by vested_academy_restrict_access() instead
// add_action( 'template_redirect', 'vested_academy_restrict_quiz_access' );

/**
 * Get chapter reading time
 */
function vested_academy_get_chapter_reading_time( $chapter_id ) {
	$content = get_post_field( 'post_content', $chapter_id );
	$word_count = str_word_count( strip_tags( $content ) );
	$reading_time = ceil( $word_count / 250 ); // 250 words per minute
	return $reading_time;
}

/**
 * Check if Academy page
 */
function vested_academy_is_academy_page() {
	if ( is_singular( 'module' ) ) {
		return true;
	}
	
	if ( is_tax( 'modules' ) ) {
		return true;
	}
	
	$page_template = get_page_template_slug();
	if ( $page_template === 'templates/page-vested-academy.php' || 
		 $page_template === 'templates/page-academy-home.php' ||
		 $page_template === 'templates/page-academy-module.php' ||
		 $page_template === 'templates/page-academy-login.php' ||
		 $page_template === 'templates/page-academy-signup.php' ) {
		return true;
	}
	
	if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( $_SERVER['REQUEST_URI'], '/academy/' ) !== false ) {
		return true;
	}
	
	return false;
}

/**
 * AJAX handler for updating chapter progress
 */
function vested_academy_ajax_update_progress() {
	check_ajax_referer( 'academy_progress_nonce', 'nonce' );
	
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => 'User not logged in' ) );
	}
	
	$user_id = get_current_user_id();
	$chapter_id = isset( $_POST['chapter_id'] ) ? intval( $_POST['chapter_id'] ) : 0;
	$module_id = isset( $_POST['module_id'] ) ? intval( $_POST['module_id'] ) : null;
	$progress = isset( $_POST['progress'] ) ? intval( $_POST['progress'] ) : 0;
	$topic_index = isset( $_POST['topic_index'] ) ? intval( $_POST['topic_index'] ) : null;
	
	if ( ! $chapter_id ) {
		wp_send_json_error( array( 'message' => 'Invalid chapter ID' ) );
	}
	
	// Track topic progress if topic_index is provided, otherwise track chapter progress
	if ( $topic_index !== null ) {
		vested_academy_track_topic_progress( $user_id, $chapter_id, $topic_index, $module_id, $progress );
	} else {
		vested_academy_track_chapter_progress( $user_id, $chapter_id, $module_id, $progress );
	}
	
	wp_send_json_success( array( 'message' => 'Progress updated', 'progress' => $progress ) );
}
add_action( 'wp_ajax_academy_update_progress', 'vested_academy_ajax_update_progress' );

/**
 * Save individual quiz question answer
 */
function vested_academy_save_quiz_answer( $user_id, $quiz_id, $question_index, $user_answer, $correct_answer = null ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_quiz_answers';
	
	// Get correct answer if not provided
	if ( $correct_answer === null ) {
		$questions = get_field( 'quiz_questions', $quiz_id );
		if ( isset( $questions[ $question_index ]['correct_answer'] ) ) {
			$correct_answer = $questions[ $question_index ]['correct_answer'];
		}
	}
	
	$is_correct = ( $user_answer === $correct_answer ) ? 1 : 0;
	
	// Check if answer already exists
	$existing = $wpdb->get_row( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND question_index = %d",
		$user_id,
		$quiz_id,
		$question_index
	) );
	
	if ( $existing ) {
		// Update existing answer
		$wpdb->update(
			$table_name,
			array(
				'user_answer' => $user_answer,
				'correct_answer' => $correct_answer,
				'is_correct' => $is_correct,
			),
			array(
				'user_id' => $user_id,
				'quiz_id' => $quiz_id,
				'question_index' => $question_index,
			),
			array( '%s', '%s', '%d' ),
			array( '%d', '%d', '%d' )
		);
	} else {
		// Insert new answer
		$wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'quiz_id' => $quiz_id,
				'question_index' => $question_index,
				'user_answer' => $user_answer,
				'correct_answer' => $correct_answer,
				'is_correct' => $is_correct,
			),
			array( '%d', '%d', '%d', '%s', '%s', '%d' )
		);
	}
	
	return $is_correct;
}

/**
 * Get user's saved answers for a quiz
 */
function vested_academy_get_user_quiz_answers( $user_id, $quiz_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_quiz_answers';
	
	$answers = $wpdb->get_results( $wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d ORDER BY question_index ASC",
		$user_id,
		$quiz_id
	), ARRAY_A );
	
	$answers_array = array();
	foreach ( $answers as $answer ) {
		$answers_array[ $answer['question_index'] ] = $answer['user_answer'];
	}
	
	return $answers_array;
}

/**
 * AJAX handler for saving individual quiz answer
 */
function vested_academy_ajax_save_quiz_answer() {
	check_ajax_referer( 'academy_quiz_answer_nonce', 'nonce' );
	
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => 'User not logged in' ) );
	}
	
	$user_id = get_current_user_id();
	$quiz_id = isset( $_POST['quiz_id'] ) ? intval( $_POST['quiz_id'] ) : 0;
	$question_index = isset( $_POST['question_index'] ) ? intval( $_POST['question_index'] ) : 0;
	$user_answer = isset( $_POST['user_answer'] ) ? sanitize_text_field( $_POST['user_answer'] ) : '';
	
	if ( ! $quiz_id || $user_answer === '' ) {
		wp_send_json_error( array( 'message' => 'Invalid data' ) );
	}
	
	vested_academy_save_quiz_answer( $user_id, $quiz_id, $question_index, $user_answer );
	
	wp_send_json_success( array( 'message' => 'Answer saved' ) );
}
add_action( 'wp_ajax_academy_save_quiz_answer', 'vested_academy_ajax_save_quiz_answer' );

/**
 * AJAX handler for loading quiz question HTML
 */
function vested_academy_ajax_load_quiz_question() {
	check_ajax_referer( 'academy_quiz_answer_nonce', 'nonce' );
	
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => 'User not logged in' ) );
	}
	
	$user_id = get_current_user_id();
	$quiz_id = isset( $_POST['quiz_id'] ) ? intval( $_POST['quiz_id'] ) : 0;
	$chapter_id = isset( $_POST['chapter_id'] ) ? intval( $_POST['chapter_id'] ) : 0;
	$question_index = isset( $_POST['question_index'] ) ? intval( $_POST['question_index'] ) : 0;
	
	if ( ! $quiz_id || ! $chapter_id ) {
		wp_send_json_error( array( 'message' => 'Invalid data' ) );
	}
	
	// Get quiz data
	$module_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
	if ( empty( $module_quizzes ) ) {
		wp_send_json_error( array( 'message' => 'Quiz not found' ) );
	}
	
	$quiz_post = $module_quizzes[0];
	$quiz_questions = isset( $quiz_post['questions'] ) ? $quiz_post['questions'] : array();
	
	if ( empty( $quiz_questions ) ) {
		$quiz_questions = get_field( 'quiz_questions', $quiz_post['id'] );
		if ( ! $quiz_questions ) {
			$quiz_questions = array();
		}
	}
	
	$total_questions = count( $quiz_questions );
	
	// Validate question index
	if ( $question_index < 0 || $question_index >= $total_questions ) {
		wp_send_json_error( array( 'message' => 'Invalid question index' ) );
	}
	
	// Get saved answers
	$saved_answers = vested_academy_get_user_quiz_answers( $user_id, $quiz_id );
	
	// Get current question
	$current_q = $quiz_questions[ $question_index ];
	$question_text = isset( $current_q['question'] ) ? $current_q['question'] : '';
	$options = isset( $current_q['options'] ) ? $current_q['options'] : array();
	$saved_answer = isset( $saved_answers[ $question_index ] ) ? $saved_answers[ $question_index ] : '';
	
	// Build navigation URLs
	$base_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) );
	$prev_q = max( 0, $question_index - 1 );
	$next_q = min( $total_questions - 1, $question_index + 1 );
	$prev_url = add_query_arg( array( 'quiz' => '1', 'q' => $prev_q ), $base_url ) . '#quiz-content';
	$next_url = add_query_arg( array( 'quiz' => '1', 'q' => $next_q ), $base_url ) . '#quiz-content';
	
	// Generate HTML
	ob_start();
	?>
	<div class="quiz-question-wrapper" data-question-index="<?php echo esc_attr( $question_index ); ?>">
		<div class="quiz-question-header">
			<h2 class="quiz-title">Quiz <?php echo esc_html( $question_index + 1 ); ?></h2>
		</div>
		
		<div class="quiz-question-content">
			<h3 class="question-text"><?php echo esc_html( $question_text ); ?></h3>
			<p class="question-instruction">Choose only 1 answer</p>
			
			<div class="question-options">
				<?php
				if ( ! empty( $options ) ) {
					foreach ( $options as $option_idx => $option ) :
						$option_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : $option_idx ) : $option;
						$option_label = is_array( $option ) ? ( isset( $option['label'] ) ? $option['label'] : $option_value ) : $option;
						$is_selected = ( $saved_answer === $option_value );
						?>
						<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>" data-option-value="<?php echo esc_attr( $option_value ); ?>">
							<input 
								type="radio" 
								name="question_<?php echo esc_attr( $question_index ); ?>" 
								value="<?php echo esc_attr( $option_value ); ?>"
								<?php echo $is_selected ? 'checked' : ''; ?>
							>
							<span class="radio-custom"></span>
							<span class="option-text"><?php echo esc_html( $option_label ); ?></span>
						</label>
					<?php
					endforeach;
				}
				?>
			</div>
		</div>
		
		<div class="quiz-navigation">
			<div class="quiz-progress">
				<span class="progress-text"><?php echo esc_html( $question_index + 1 ); ?>/<?php echo esc_html( $total_questions ); ?></span>
				<div class="progress-bar">
					<div class="progress-fill" style="width: <?php echo esc_attr( ( ( $question_index + 1 ) / $total_questions ) * 100 ); ?>%"></div>
				</div>
			</div>
			
			<div class="quiz-buttons">
				<?php if ( $question_index > 0 ) : ?>
					<a href="<?php echo esc_url( $prev_url ); ?>" class="quiz-btn quiz-prev-btn" data-question-index="<?php echo esc_attr( $prev_q ); ?>">Previous</a>
				<?php endif; ?>
				
				<?php if ( $question_index < $total_questions - 1 ) : ?>
					<a href="<?php echo esc_url( $next_url ); ?>" class="quiz-btn quiz-next-btn" data-question-index="<?php echo esc_attr( $next_q ); ?>">Next</a>
				<?php else : ?>
					<button type="button" class="quiz-btn quiz-submit-btn" id="quiz-final-submit">Submit Quiz</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();
	
	wp_send_json_success( array(
		'html' => $html,
		'question_index' => $question_index,
		'total_questions' => $total_questions,
		'prev_url' => $prev_url,
		'next_url' => $next_url
	) );
}
add_action( 'wp_ajax_academy_load_quiz_question', 'vested_academy_ajax_load_quiz_question' );

/**
 * Register Academy User Role
 */
function vested_academy_register_user_role() {
	add_role(
		'academy_user',
		__( 'Academy User', 'vested-finance-wp' ),
		array(
			'read' => true, // Can read posts
		)
	);
}
add_action( 'init', 'vested_academy_register_user_role' );

/**
 * Prevent WordPress from redirecting Academy pages to login
 * All Academy pages should be accessible without login
 */
function vested_academy_prevent_login_redirect( $redirect_to, $requested_redirect_to, $user ) {
	// If login came from Academy login page and there's an error, redirect back to Academy login
	if ( isset( $_POST['academy_login'] ) && $_POST['academy_login'] === '1' ) {
		if ( is_wp_error( $user ) ) {
			$error_code = $user->get_error_code();
			
			if ( $error_code === 'email_not_verified' ) {
				// Get user email if available
				$username = isset( $_POST['log'] ) ? sanitize_text_field( $_POST['log'] ) : '';
				$user_obj = get_user_by( 'login', $username );
				if ( ! $user_obj ) {
					$user_obj = get_user_by( 'email', $username );
				}
				$email = $user_obj ? $user_obj->user_email : '';
				
				// Redirect back to Academy login page with error
				$redirect_url = add_query_arg( array(
					'login' => 'email_not_verified',
					'email' => urlencode( $email ),
				), home_url( '/academy/login' ) );
				return $redirect_url;
			} elseif ( $error_code === 'invalid_role' ) {
				// Redirect back to Academy login page with error
				return home_url( '/academy/login?login=invalid_role' );
			} elseif ( in_array( $error_code, array( 'incorrect_password', 'empty_password', 'empty_username' ) ) ) {
				// Redirect back to Academy login page with error
				return home_url( '/academy/login?login=failed' );
			}
		}
	}
	
	// If user is trying to access an Academy page, don't redirect to login
	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$request_uri = $_SERVER['REQUEST_URI'];
		// Check if it's an Academy page (but not login/signup)
		if ( strpos( $request_uri, '/academy/' ) !== false && 
			 strpos( $request_uri, '/academy/login' ) === false &&
			 strpos( $request_uri, '/academy/signup' ) === false ) {
			// Return the original URL instead of login page
			return $requested_redirect_to ? $requested_redirect_to : home_url( $request_uri );
		}
	}
	
	// For Academy users, redirect to academy page after successful login
	if ( $user && is_a( $user, 'WP_User' ) && ! is_wp_error( $user ) ) {
		$user_roles = $user->roles;
		if ( in_array( 'academy_user', $user_roles ) || in_array( 'administrator', $user_roles ) ) {
			// If no specific redirect requested, go to academy page
			if ( empty( $requested_redirect_to ) || strpos( $requested_redirect_to, '/academy/dashboard' ) !== false ) {
				return home_url( '/academy/' );
			}
		}
	}
	
	return $redirect_to;
}
add_filter( 'login_redirect', 'vested_academy_prevent_login_redirect', 10, 3 );

/**
 * Prevent auth_redirect on Academy pages
 * This stops WordPress from redirecting to login
 */
function vested_academy_prevent_auth_redirect() {
	if ( vested_academy_is_academy_page() ) {
		// Don't redirect Academy pages to login
		// Remove WordPress default redirect actions
		remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
		// Prevent any auth redirects - allow page to load normally
		return;
	}
}
add_action( 'template_redirect', 'vested_academy_prevent_auth_redirect', 1 );

/**
 * Override WordPress login requirement for Academy pages
 * Prevents WordPress from requiring login on Academy pages
 */
function vested_academy_override_login_requirement() {
	if ( vested_academy_is_academy_page() ) {
		// Check if it's a page (not post type)
		if ( is_page() ) {
			$page_id = get_the_ID();
			$page_template = get_page_template_slug( $page_id );
			
			// Allow these Academy pages without login
			$public_academy_templates = array(
				'templates/page-vested-academy.php',
				'templates/page-academy-home.php',
				'templates/page-academy-module.php',
				'templates/page-academy-login.php',
				'templates/page-academy-signup.php',
			);
			
			if ( in_array( $page_template, $public_academy_templates ) ) {
				// Force page to be public - prevent any login requirements
				add_filter( 'post_password_required', '__return_false', 999 );
				return;
			}
		}
		
		// For module posts and taxonomy pages - always public
		if ( is_singular( 'module' ) || is_tax( 'modules' ) ) {
			add_filter( 'post_password_required', '__return_false', 999 );
			return;
		}
	}
}
add_action( 'wp', 'vested_academy_override_login_requirement', 1 );

/**
 * Prevent redirects on Academy pages
 * Hook into template_redirect to ensure no redirects happen
 */
function vested_academy_prevent_redirects() {
	// Only on Academy pages
	if ( ! vested_academy_is_academy_page() ) {
		return;
	}
	
	// Don't remove actions if we're processing email verification
	if ( isset( $_GET['action'] ) && $_GET['action'] === 'verify_email' ) {
		return;
	}
	
	// Remove any redirect filters that might be active
	remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
	// Prevent MemberPress or other plugins from redirecting
	remove_all_actions( 'template_redirect' );
	// Re-add our prevent function
	add_action( 'template_redirect', 'vested_academy_prevent_auth_redirect', 1 );
}
add_action( 'template_redirect', 'vested_academy_prevent_redirects', 1 );

/**
 * Force Academy pages to be public - prevent any login redirects
 * This runs very early to catch all redirect attempts
 */
function vested_academy_force_public_access() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}
	
	$request_uri = $_SERVER['REQUEST_URI'];
	
	// Check if it's an Academy page (but not login/signup/quiz)
	if ( strpos( $request_uri, '/academy/' ) !== false && 
		 strpos( $request_uri, '/academy/login' ) === false &&
		 strpos( $request_uri, '/academy/signup' ) === false &&
		 strpos( $request_uri, '/academy/quiz/' ) === false ) {
		
		// Prevent any redirects to login
		add_filter( 'auth_redirect', '__return_false', 999 );
		add_filter( 'wp_redirect', 'vested_academy_prevent_login_redirects', 999, 2 );
		
		// Prevent MemberPress or other membership plugins from locking pages
		if ( class_exists( 'MeprRule' ) ) {
			add_filter( 'mepr_is_uri_locked', '__return_false', 999 );
		}
	}
}
add_action( 'init', 'vested_academy_force_public_access', 1 );

/**
 * Prevent redirects to login page for Academy pages
 */
function vested_academy_prevent_login_redirects( $location, $status ) {
	if ( strpos( $location, 'wp-login.php' ) !== false ) {
		// If trying to redirect to login, check if it's an Academy page
		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$request_uri = $_SERVER['REQUEST_URI'];
			if ( strpos( $request_uri, '/academy/' ) !== false && 
				 strpos( $request_uri, '/academy/login' ) === false &&
				 strpos( $request_uri, '/academy/signup' ) === false &&
				 strpos( $request_uri, '/academy/quiz/' ) === false ) {
				// Don't redirect - return false to cancel redirect
				return false;
			}
		}
	}
	return $location;
}

/**
 * Restrict Academy access - NO REDIRECTS
 * All Academy pages are public, quizzes show lock icon if not logged in
 */
function vested_academy_restrict_access() {
	// NO REDIRECTS - All pages are accessible
	// Quiz pages will show lock icon if user is not logged in
	// This function is kept for future use but doesn't redirect
	return;
}
// Removed redirect - quizzes will show lock icon instead
// add_action( 'template_redirect', 'vested_academy_restrict_access' );

/**
 * Check if we're on localhost/development environment
 */
function vested_academy_is_localhost() {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
	$localhost_patterns = array( 'localhost', '127.0.0.1', '::1', '.local', '.test', '.dev' );
	
	foreach ( $localhost_patterns as $pattern ) {
		if ( strpos( $host, $pattern ) !== false ) {
			return true;
		}
	}
	
	// Also check if WP_DEBUG is enabled (common in development)
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		return true;
	}
	
	return false;
}

/**
 * Check if user email is verified
 * Administrators are always considered verified
 * Email verification is required for all Academy Users
 */
function vested_academy_is_email_verified( $user_id ) {
	$user = get_userdata( $user_id );
	if ( ! $user ) {
		return false;
	}
	
	// Administrators are always verified
	if ( in_array( 'administrator', $user->roles ) ) {
		return true;
	}
	
	// Clear cache to ensure we get fresh data
	wp_cache_delete( $user_id, 'user_meta' );
	
	// Check verification status - get_user_meta returns empty string if not found
	$is_verified = get_user_meta( $user_id, 'academy_email_verified', true );
	
	// Handle different possible values
	// '1' or 1 means verified
	if ( $is_verified === '1' || $is_verified === 1 || $is_verified === true ) {
		return true;
	}
	
	// '0', 0, false, or empty string means not verified
	// If meta doesn't exist (empty string), check if user was created before verification was implemented
	// For backward compatibility, mark existing users as verified
	if ( $is_verified === '' ) {
		// User was created before email verification was implemented
		// Mark as verified for backward compatibility
		update_user_meta( $user_id, 'academy_email_verified', '1' );
		wp_cache_delete( $user_id, 'user_meta' );
		return true;
	}
	
	// Explicitly not verified ('0', 0, false)
	return false;
}

/**
 * Send email verification email
 */
// Deprecated: old link-based verification helper (kept for reference)
function vested_academy_send_verification_email( $user_email, $user_login, $verification_token ) {}

/**
 * Handle email verification
 */
// Deprecated link-based verification handler (replaced by OTP flow)
function vested_academy_handle_email_verification() {}

/**
 * Resend verification email
 */
function vested_academy_resend_verification_email() {
	// Verify nonce
	if ( ! isset( $_POST['resend_verification_nonce'] ) || ! wp_verify_nonce( $_POST['resend_verification_nonce'], 'resend_verification' ) ) {
		wp_die( 'Security check failed' );
	}
	
	$user_email = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
	
	if ( empty( $user_email ) ) {
		wp_redirect( home_url( '/academy/signup?resend=error&msg=empty' ) );
		exit;
	}
	
	// Check pending signup transient first
	$pending_key = 'academy_pending_' . md5( $user_email );
	$pending     = get_transient( $pending_key );

	if ( $pending && isset( $pending['user_login'] ) ) {
		$otp_code   = random_int( 1000, 9999 );
		$otp_expiry = time() + ( 10 * 60 );

		$pending['otp_code']   = $otp_code;
		$pending['otp_expiry'] = $otp_expiry;
		set_transient( $pending_key, $pending, 15 * MINUTE_IN_SECONDS );

		$subject = 'Your Academy Email Verification Code';
		$message  = "Hello,\n\n";
		$message .= "Your Academy verification code is: " . $otp_code . "\n";
		$message .= "This code will expire in 10 minutes.\n\n";
		$message .= "If you did not request this, please ignore this email.\n\n";
		$message .= "Best regards,\n";
		$message .= "Academy Team";
		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		wp_mail( $user_email, $subject, $message, $headers );

		wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $user_email ) . '&resend=success' ) );
		exit;
	}

	// If pending not found, check existing user (unverified)
	$user = get_user_by( 'email', $user_email );
	if ( $user ) {
		$is_verified = get_user_meta( $user->ID, 'academy_email_verified', true );
		if ( $is_verified === '1' ) {
			wp_redirect( home_url( '/academy/login?resend=already_verified' ) );
			exit;
		}

		$otp_code   = random_int( 1000, 9999 );
		$otp_expiry = time() + ( 10 * 60 );

		update_user_meta( $user->ID, 'academy_verification_otp', $otp_code );
		update_user_meta( $user->ID, 'academy_verification_otp_expiry', $otp_expiry );

		clean_user_cache( $user->ID );
		wp_cache_delete( $user->ID, 'user_meta' );
		wp_cache_delete( $user->ID, 'users' );

		$subject = 'Your Academy Email Verification Code';
		$message  = "Hello " . esc_html( $user->user_login ) . ",\n\n";
		$message .= "Your Academy verification code is: " . $otp_code . "\n";
		$message .= "This code will expire in 10 minutes.\n\n";
		$message .= "If you did not request this, please ignore this email.\n\n";
		$message .= "Best regards,\n";
		$message .= "Academy Team";
		$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
		wp_mail( $user_email, $subject, $message, $headers );

		wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $user_email ) . '&resend=success' ) );
		exit;
	}

	wp_redirect( home_url( '/academy/signup?resend=error&msg=user_not_found' ) );
	exit;
}
add_action( 'admin_post_academy_resend_verification', 'vested_academy_resend_verification_email' );
add_action( 'admin_post_nopriv_academy_resend_verification', 'vested_academy_resend_verification_email' );

/**
 * Custom Academy Registration Handler
 */
function vested_academy_handle_registration() {
	// Verify nonce
	if ( ! isset( $_POST['academy_register_nonce'] ) || ! wp_verify_nonce( $_POST['academy_register_nonce'], 'academy_register' ) ) {
		wp_die( 'Security check failed' );
	}
	
	// Get form data
	$user_name = isset( $_POST['user_name'] ) ? sanitize_text_field( $_POST['user_name'] ) : '';
	$user_email = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
	$user_pass = isset( $_POST['user_pass'] ) ? $_POST['user_pass'] : '';
	
	// Validate
	if ( empty( $user_name ) || empty( $user_email ) || empty( $user_pass ) ) {
		wp_redirect( home_url( '/academy/signup?registration=error&msg=empty' ) );
		exit;
	}
	
	// Check if email already exists
	if ( email_exists( $user_email ) ) {
		wp_redirect( home_url( '/academy/signup?registration=error&msg=email_exists' ) );
		exit;
	}
	
	// Generate username from email (use email address as username)
	// Extract the part before @ symbol and sanitize it
	$email_parts = explode( '@', $user_email );
	$base_username = sanitize_user( $email_parts[0], true );
	
	// Ensure username is valid (WordPress requires at least 4 characters)
	if ( strlen( $base_username ) < 4 ) {
		// If too short, use the full email (sanitized)
		$base_username = sanitize_user( $user_email, true );
	}
	
	// If username already exists, append numbers until we find an available one
	$user_login = $base_username;
	$counter = 1;
	while ( username_exists( $user_login ) ) {
		$user_login = $base_username . $counter;
		$counter++;
	}
	
	// Generate OTP (4-digit)
	$otp_code    = random_int( 1000, 9999 );
	$otp_expiry  = time() + ( 10 * 60 ); // 10 minutes

	// Store pending signup in transient (15 minutes)
	$pending_key = 'academy_pending_' . md5( $user_email );
	$pending_data = array(
		'user_login' => $user_login,
		'user_name'  => $user_name,
		'user_email' => $user_email,
		'user_pass'  => $user_pass,
		'otp_code'   => $otp_code,
		'otp_expiry' => $otp_expiry,
		'created_at' => time(),
	);
	set_transient( $pending_key, $pending_data, 15 * MINUTE_IN_SECONDS );
	
	// Send OTP email
	$subject = 'Your Academy Email Verification Code';
	$message  = "Hello,\n\n";
	$message .= "Your Academy verification code is: " . $otp_code . "\n";
	$message .= "This 4-digit code will expire in 10 minutes.\n\n";
	$message .= "If you did not request this, please ignore this email.\n\n";
	$message .= "Best regards,\n";
	$message .= "Academy Team";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	wp_mail( $user_email, $subject, $message, $headers );
	
	// Redirect to signup page with OTP verification prompt
	wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $user_email ) ) );
	exit;
}
add_action( 'admin_post_academy_register', 'vested_academy_handle_registration' );
add_action( 'admin_post_nopriv_academy_register', 'vested_academy_handle_registration' );

/**
 * Verify OTP submission
 */
function vested_academy_verify_otp() {
	// Verify nonce
	if ( ! isset( $_POST['academy_verify_otp_nonce'] ) || ! wp_verify_nonce( $_POST['academy_verify_otp_nonce'], 'academy_verify_otp' ) ) {
		wp_die( 'Security check failed' );
	}

	$email = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
	$otp   = isset( $_POST['verification_otp'] ) ? sanitize_text_field( $_POST['verification_otp'] ) : '';

	if ( empty( $email ) || empty( $otp ) ) {
		wp_redirect( home_url( '/academy/signup?verification=error&msg=invalid_otp' ) );
		exit;
	}

	// Check pending signup transient
	$pending_key = 'academy_pending_' . md5( $email );
	$pending     = get_transient( $pending_key );

	if ( $pending && isset( $pending['otp_code'] ) ) {
		// Validate OTP from pending data
		if ( time() > intval( $pending['otp_expiry'] ) ) {
			wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $email ) . '&verification=error&msg=expired' ) );
			exit;
		}

		// Compare as strings to handle type mismatch
		if ( (string) $pending['otp_code'] !== (string) $otp ) {
			wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $email ) . '&verification=error&msg=invalid_otp' ) );
			exit;
		}

		// Create user now
		$user_id = wp_create_user( $pending['user_login'], $pending['user_pass'], $pending['user_email'] );
		if ( is_wp_error( $user_id ) ) {
			wp_redirect( home_url( '/academy/signup?verification=error&msg=' . urlencode( $user_id->get_error_message() ) ) );
			exit;
		}

		$user = new WP_User( $user_id );
		$user->set_role( 'academy_user' );

		// Update user display name and first name
		if ( ! empty( $pending['user_name'] ) ) {
			$name_parts = explode( ' ', $pending['user_name'], 2 );
			wp_update_user( array(
				'ID'           => $user_id,
				'display_name' => $pending['user_name'],
				'first_name'   => $name_parts[0],
				'last_name'    => isset( $name_parts[1] ) ? $name_parts[1] : '',
			) );
		}

		// Mark verified
		update_user_meta( $user_id, 'academy_email_verified', '1' );

		// Clear pending data
		delete_transient( $pending_key );

		wp_redirect( home_url( '/academy/login?verification=success' ) );
		exit;
	}

	// If no pending, fallback to existing user (unverified) flow
	$user = get_user_by( 'email', $email );
	if ( ! $user ) {
		wp_redirect( home_url( '/academy/signup?verification=error&msg=user_not_found' ) );
		exit;
	}

	// Refresh cache
	clean_user_cache( $user->ID );
	wp_cache_delete( $user->ID, 'user_meta' );
	wp_cache_delete( $user->ID, 'users' );

	$is_verified = get_user_meta( $user->ID, 'academy_email_verified', true );
	if ( $is_verified === '1' ) {
		wp_redirect( home_url( '/academy/login?verification=already_verified' ) );
		exit;
	}

	$stored_otp    = get_user_meta( $user->ID, 'academy_verification_otp', true );
	$otp_expiry    = intval( get_user_meta( $user->ID, 'academy_verification_otp_expiry', true ) );

	if ( empty( $stored_otp ) || empty( $otp_expiry ) ) {
		wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $email ) . '&verification=error&msg=invalid_otp' ) );
		exit;
	}

	if ( time() > $otp_expiry ) {
		wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $email ) . '&verification=error&msg=expired' ) );
		exit;
	}

	// Compare as strings to handle type mismatch (OTP might be stored as int or string)
	if ( (string) $stored_otp !== (string) $otp ) {
		wp_redirect( home_url( '/academy/signup?registration=verify_otp&email=' . urlencode( $email ) . '&verification=error&msg=invalid_otp' ) );
		exit;
	}

	// Mark verified
	update_user_meta( $user->ID, 'academy_email_verified', '1' );
	delete_user_meta( $user->ID, 'academy_verification_otp' );
	delete_user_meta( $user->ID, 'academy_verification_otp_expiry' );

	// Clear caches
	clean_user_cache( $user->ID );
	wp_cache_delete( $user->ID, 'user_meta' );
	wp_cache_delete( $user->ID, 'users' );

	wp_redirect( home_url( '/academy/login?verification=success' ) );
	exit;
}
add_action( 'admin_post_academy_verify_otp', 'vested_academy_verify_otp' );
add_action( 'admin_post_nopriv_academy_verify_otp', 'vested_academy_verify_otp' );

/**
 * Restrict login to Academy User role only and check email verification
 * This applies to ALL login attempts, not just Academy login page
 */
function vested_academy_restrict_login( $user, $username, $password ) {
	// Only proceed if we have a valid user (authentication succeeded)
	// If $user is null or WP_Error, WordPress will handle it (wrong password, user doesn't exist, etc.)
	if ( $user && ! is_wp_error( $user ) ) {
		$user_obj = $user;
		
		// Ensure we have the correct user object
		// WordPress allows login with username or email, so we need to handle both
		if ( ! empty( $username ) ) {
			// Try to get user by login (username)
			$user_by_login = get_user_by( 'login', $username );
			if ( $user_by_login ) {
				$user_obj = $user_by_login;
			} else {
				// If not found by login, try by email
				$user_by_email = get_user_by( 'email', $username );
				if ( $user_by_email ) {
					$user_obj = $user_by_email;
				}
			}
		}
		
		if ( $user_obj && is_a( $user_obj, 'WP_User' ) ) {
			$user_roles = $user_obj->roles;
			
			// Check if this is an Academy User (not administrator)
			if ( in_array( 'academy_user', $user_roles ) && ! in_array( 'administrator', $user_roles ) ) {
				// Check if email is verified - use the user ID from the authenticated user object
				$user_id_to_check = $user_obj->ID;
				$is_verified = vested_academy_is_email_verified( $user_id_to_check );
				
				if ( ! $is_verified ) {
					// Return error to prevent login
					return new WP_Error( 'email_not_verified', 'Please verify email first after you can login.' );
				}
			}
			
			// If this is an Academy login attempt, also check role restriction
			if ( isset( $_POST['academy_login'] ) && $_POST['academy_login'] === '1' ) {
				// Allow administrators and academy_user role
				if ( ! in_array( 'academy_user', $user_roles ) && ! in_array( 'administrator', $user_roles ) ) {
					return new WP_Error( 'invalid_role', 'Only Academy Users can access the Academy. Please contact support.' );
				}
			}
		}
	}
	// Return the user (or error) as-is if no restrictions apply
	return $user;
}
add_filter( 'authenticate', 'vested_academy_restrict_login', 30, 3 );

/**
 * Handle login errors for Academy login page only
 * For wp-login.php, errors are displayed automatically by WordPress
 */
function vested_academy_handle_login_errors( $user, $username ) {
	// Only handle redirects for Academy login page
	// For wp-login.php, let WordPress display the error naturally
	if ( isset( $_POST['academy_login'] ) && $_POST['academy_login'] === '1' ) {
		if ( is_wp_error( $user ) ) {
			$error_code = $user->get_error_code();
			
			if ( $error_code === 'email_not_verified' ) {
				// Get user email if available - try both login and email
				$user_obj = get_user_by( 'login', $username );
				if ( ! $user_obj ) {
					$user_obj = get_user_by( 'email', $username );
				}
				$email = $user_obj ? $user_obj->user_email : '';
				
				// Redirect to Academy login page with error
				$redirect_url = add_query_arg( array(
					'login' => 'email_not_verified',
					'email' => urlencode( $email ),
				), home_url( '/academy/login' ) );
				wp_redirect( $redirect_url );
				exit;
			} elseif ( $error_code === 'invalid_role' ) {
				wp_redirect( home_url( '/academy/login?login=invalid_role' ) );
				exit;
			}
		}
	}
	// For wp-login.php, return the error so WordPress displays it on the login page
	return $user;
}
add_filter( 'wp_authenticate_user', 'vested_academy_handle_login_errors', 10, 2 );

/**
 * Intercept login failures and redirect Academy login attempts back to Academy login page
 * This checks if the failure was due to email verification or actual authentication failure
 */
function vested_academy_handle_login_failure( $username ) {
	// Check if this login attempt came from Academy login page
	if ( isset( $_POST['academy_login'] ) && $_POST['academy_login'] === '1' ) {
		// Try to find the user to check verification status
		$user_obj = get_user_by( 'login', $username );
		if ( ! $user_obj ) {
			$user_obj = get_user_by( 'email', $username );
		}
		
		// If user exists, check if it's a verification issue
		if ( $user_obj && is_a( $user_obj, 'WP_User' ) ) {
			$user_roles = $user_obj->roles;
			
			// Check if this is an Academy User (not administrator)
			if ( in_array( 'academy_user', $user_roles ) && ! in_array( 'administrator', $user_roles ) ) {
				// Clear cache and check verification status
				wp_cache_delete( $user_obj->ID, 'user_meta' );
				$is_verified = vested_academy_is_email_verified( $user_obj->ID );
				
				if ( ! $is_verified ) {
					// This is an email verification issue, not a password issue
					$email = $user_obj->user_email;
					$redirect_url = add_query_arg( array(
						'login' => 'email_not_verified',
						'email' => urlencode( $email ),
					), home_url( '/academy/login' ) );
					wp_redirect( $redirect_url );
					exit;
				}
			}
		}
		
		// For any other Academy login failure (wrong password, user doesn't exist, etc.)
		$redirect_url = add_query_arg( 'login', 'failed', home_url( '/academy/login' ) );
		wp_redirect( $redirect_url );
		exit;
	}
}
add_action( 'wp_login_failed', 'vested_academy_handle_login_failure', 10, 1 );

/**
 * Custom Academy Login Handler
 * Handles login directly from Academy login page
 */
function vested_academy_handle_login() {
	// Verify nonce
	if ( ! isset( $_POST['academy_login_nonce'] ) || ! wp_verify_nonce( $_POST['academy_login_nonce'], 'academy_login' ) ) {
		wp_die( 'Security check failed' );
	}
	
	$username = isset( $_POST['log'] ) ? sanitize_text_field( $_POST['log'] ) : '';
	$password = isset( $_POST['pwd'] ) ? $_POST['pwd'] : '';
	$remember = isset( $_POST['rememberme'] ) ? true : false;
	$redirect_to = isset( $_POST['redirect_to'] ) ? esc_url_raw( $_POST['redirect_to'] ) : home_url( '/academy/' );
	
	// Validate input
	if ( empty( $username ) || empty( $password ) ) {
		wp_redirect( home_url( '/academy/login?login=empty' ) );
		exit;
	}
	
	// Try to find user by email or username
	$user = null;
	if ( is_email( $username ) ) {
		$user = get_user_by( 'email', $username );
	}
	
	if ( ! $user ) {
		$user = get_user_by( 'login', $username );
	}
	
	if ( ! $user ) {
		wp_redirect( home_url( '/academy/login?login=failed' ) );
		exit;
	}
	
	// Check password
	if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
		wp_redirect( home_url( '/academy/login?login=failed' ) );
		exit;
	}
	
	// Check if user is Academy User or Administrator
	$user_roles = $user->roles;
	if ( ! in_array( 'academy_user', $user_roles ) && ! in_array( 'administrator', $user_roles ) ) {
		wp_redirect( home_url( '/academy/login?login=invalid_role' ) );
		exit;
	}
	
	// Check email verification for Academy Users (not administrators)
	if ( in_array( 'academy_user', $user_roles ) && ! in_array( 'administrator', $user_roles ) ) {
		$is_verified = vested_academy_is_email_verified( $user->ID );
		if ( ! $is_verified ) {
			$email = $user->user_email;
			wp_redirect( home_url( '/academy/login?login=email_not_verified&email=' . urlencode( $email ) ) );
			exit;
		}
	}
	
	// Login successful - set auth cookie and redirect
	wp_set_auth_cookie( $user->ID, $remember );
	wp_set_current_user( $user->ID );
	do_action( 'wp_login', $user->user_login, $user );
	
	wp_safe_redirect( $redirect_to );
	exit;
}
add_action( 'admin_post_academy_login', 'vested_academy_handle_login' );
add_action( 'admin_post_nopriv_academy_login', 'vested_academy_handle_login' );

/**
 * Localize Academy script
 */
function vested_academy_localize_script() {
	if ( vested_academy_is_academy_page() ) {
		wp_localize_script( 'academy-js', 'academyAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'academy_progress_nonce' ),
			'quiz_nonce' => wp_create_nonce( 'academy_quiz_answer_nonce' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'vested_academy_localize_script' );

/**
 * Redirect to academy page on logout
 */
function vested_academy_logout_redirect( $redirect_to, $requested_redirect_to, $user ) {
	// If user is an Academy User, redirect to academy page
	if ( $user && is_a( $user, 'WP_User' ) ) {
		$user_roles = $user->roles;
		if ( in_array( 'academy_user', $user_roles ) || in_array( 'administrator', $user_roles ) ) {
			return home_url( '/academy/' );
		}
	}
	
	// If a specific redirect was requested, use it; otherwise redirect to academy
	return ! empty( $requested_redirect_to ) ? $requested_redirect_to : home_url( '/academy/' );
}
add_filter( 'logout_redirect', 'vested_academy_logout_redirect', 10, 3 );

// Quiz duplication prevention removed - quizzes are now stored on chapters

