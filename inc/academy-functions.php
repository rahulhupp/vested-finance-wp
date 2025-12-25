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

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Register Academy Custom Post Types
 * 
 * - 'academy_module': Custom post type for modules (replaces taxonomy)
 * - 'module': Existing post type used for chapters
 * - Quizzes are stored directly on chapters via ACF fields.
 */
function vested_academy_register_post_types()
{
	// Register Academy Module post type
	$module_labels = array(
		'name' => _x('Academy Modules', 'Post Type General Name', 'vested-finance-wp'),
		'singular_name' => _x('Academy Module', 'Post Type Singular Name', 'vested-finance-wp'),
		'menu_name' => __('Academy Modules', 'vested-finance-wp'),
		'name_admin_bar' => __('Academy Module', 'vested-finance-wp'),
		'archives' => __('Module Archives', 'vested-finance-wp'),
		'attributes' => __('Module Attributes', 'vested-finance-wp'),
		'parent_item_colon' => __('Parent Module:', 'vested-finance-wp'),
		'all_items' => __('Modules', 'vested-finance-wp'),
		'add_new_item' => __('Add New Module', 'vested-finance-wp'),
		'add_new' => __('Add New', 'vested-finance-wp'),
		'new_item' => __('New Module', 'vested-finance-wp'),
		'edit_item' => __('Edit Module', 'vested-finance-wp'),
		'update_item' => __('Update Module', 'vested-finance-wp'),
		'view_item' => __('View Module', 'vested-finance-wp'),
		'view_items' => __('View Modules', 'vested-finance-wp'),
		'search_items' => __('Search Module', 'vested-finance-wp'),
		'not_found' => __('Not found', 'vested-finance-wp'),
		'not_found_in_trash' => __('Not found in Trash', 'vested-finance-wp'),
		'featured_image' => __('Module Image', 'vested-finance-wp'),
		'set_featured_image' => __('Set module image', 'vested-finance-wp'),
		'remove_featured_image' => __('Remove module image', 'vested-finance-wp'),
		'use_featured_image' => __('Use as module image', 'vested-finance-wp'),
		'insert_into_item' => __('Insert into module', 'vested-finance-wp'),
		'uploaded_to_this_item' => __('Uploaded to this module', 'vested-finance-wp'),
		'items_list' => __('Modules list', 'vested-finance-wp'),
		'items_list_navigation' => __('Modules list navigation', 'vested-finance-wp'),
		'filter_items_list' => __('Filter modules list', 'vested-finance-wp'),
	);

	$module_args = array(
		'label' => __('Academy Module', 'vested-finance-wp'),
		'description' => __('Academy learning modules with full ACF support', 'vested-finance-wp'),
		'labels' => $module_labels,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
		'taxonomies' => array(), // We'll use ACF relationship instead
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		// Nest under existing Modules (chapter) menu in admin
		'show_in_menu' => 'edit.php?post_type=module',
		// menu_position/icon not needed when nesting
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false, // We use custom page template
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'show_in_rest' => true,
		'rewrite' => array('slug' => 'academy', 'with_front' => false),
	);

	register_post_type('academy_module', $module_args);
}
add_action('init', 'vested_academy_register_post_types', 0);

/**
 * Register Chapter Topic post type (SEO-friendly, indexable topics)
 */
function vested_academy_register_chapter_topic_cpt()
{
	$labels = array(
		'name' => _x('Chapter Topics', 'post type general name', 'vested-finance-wp'),
		'singular_name' => _x('Chapter Topic', 'post type singular name', 'vested-finance-wp'),
		'menu_name' => _x('Chapter Topics', 'admin menu', 'vested-finance-wp'),
		'name_admin_bar' => _x('Chapter Topic', 'add new on admin bar', 'vested-finance-wp'),
		'add_new' => _x('Add New', 'chapter_topic', 'vested-finance-wp'),
		'add_new_item' => __('Add New Chapter Topic', 'vested-finance-wp'),
		'new_item' => __('New Chapter Topic', 'vested-finance-wp'),
		'edit_item' => __('Edit Chapter Topic', 'vested-finance-wp'),
		'view_item' => __('View Chapter Topic', 'vested-finance-wp'),
		'all_items' => __('Topics', 'vested-finance-wp'),
		'search_items' => __('Search Chapter Topics', 'vested-finance-wp'),
		'not_found' => __('No topics found.', 'vested-finance-wp'),
		'not_found_in_trash' => __('No topics found in Trash.', 'vested-finance-wp'),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		// Place under Modules menu
		'show_in_menu' => 'edit.php?post_type=module',
		'show_in_nav_menus' => false,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		'hierarchical' => true,
		'has_archive' => false,
		'publicly_queryable' => true,
		'show_in_rest' => true,
		'rewrite' => array(
			'slug' => 'academy/%module%/%chapter%',
			'with_front' => false,
		),
		'query_var' => true,
		// menu_position/icon not needed when nested
	);

	register_post_type('chapter_topic', $args);
}
add_action('init', 'vested_academy_register_chapter_topic_cpt');

/**
 * Filter chapter topic permalink to include module and chapter slugs.
 */
function vested_academy_chapter_topic_permalink($permalink, $post)
{
	if ($post->post_type !== 'chapter_topic') {
		return $permalink;
	}

	$chapter_id = $post->post_parent;
	if (!$chapter_id) {
		return $permalink;
	}

	$chapter_slug = get_post_field('post_name', $chapter_id);

	// Get module slug from chapter's modules taxonomy (first term)
	$module_slug = '';
	$terms = get_the_terms($chapter_id, 'modules');
	if ($terms && !is_wp_error($terms)) {
		$module_slug = $terms[0]->slug;
	}

	if (empty($module_slug) || empty($chapter_slug)) {
		return $permalink;
	}

	return home_url('/academy/' . $module_slug . '/' . $chapter_slug . '/' . $post->post_name . '/');
}
add_filter('post_type_link', 'vested_academy_chapter_topic_permalink', 10, 2);

/**
 * Register topic_slug query var.
 */
function vested_academy_add_topic_slug_query_var($vars)
{
	$vars[] = 'topic_slug';
	return $vars;
}
add_filter('query_vars', 'vested_academy_add_topic_slug_query_var');

/**
 * Rewrite rule to resolve chapter topic URLs for chapter pages.
 * Format: /academy/{module-slug}/{chapter-slug}/{topic-slug}/
 */
function vested_academy_chapter_topic_rewrite()
{
	// Add topic slug rewrite tag.
	add_rewrite_tag('%topic_slug%', '([^/]+)');

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
add_action('init', 'vested_academy_chapter_topic_rewrite');

/**
 * Build topic URL using topic slug.
 */
function vested_academy_get_topic_url($chapter_id, $topic_slug)
{
	if (!$chapter_id || !$topic_slug) {
		return get_permalink($chapter_id);
	}

	$chapter_slug = get_post_field('post_name', $chapter_id);
	if (!$chapter_slug) {
		return get_permalink($chapter_id);
	}

	$module_slug = '';

	// Prefer academy_module CPT relationship (keeps URL in sync when module slug changes)
	$related_modules = get_field('academy_module', $chapter_id);
	if ($related_modules) {
		if (is_array($related_modules)) {
			$module_post = is_object($related_modules[0]) ? $related_modules[0] : get_post($related_modules[0]);
		} elseif (is_object($related_modules)) {
			$module_post = $related_modules;
		} elseif (is_numeric($related_modules)) {
			$module_post = get_post($related_modules);
		}
		if (!empty($module_post)) {
			$module_slug = $module_post->post_name;
		}
	}

	// Fallback to taxonomy term only if no CPT relationship slug found
	if (empty($module_slug)) {
		$terms = get_the_terms($chapter_id, 'modules');
		if ($terms && !is_wp_error($terms) && !empty($terms)) {
			$module_slug = $terms[0]->slug;
		}
	}

	if (empty($module_slug)) {
		return get_permalink($chapter_id);
	}

	return home_url('/academy/' . $module_slug . '/' . $chapter_slug . '/' . $topic_slug . '/');
}

/**
 * Prevent external permalink plugins from redirecting Academy topic URLs.
 * Some plugins (e.g., Permalink Manager) may canonicalize to the chapter URL.
 * We explicitly opt-out when a topic slug is present.
 */
function vested_academy_prevent_permalink_manager_redirect()
{
	global $wp_query;

	if (isset($wp_query->query_vars['topic_slug'])) {
		$wp_query->query_vars['do_not_redirect'] = 1;
	}
}
add_action('template_redirect', 'vested_academy_prevent_permalink_manager_redirect', 0);

/**
 * Register Quiz post type
 */
function vested_academy_register_quiz_cpt()
{
	$labels = array(
		'name' => _x('Quizzes', 'post type general name', 'vested-finance-wp'),
		'singular_name' => _x('Quiz', 'post type singular name', 'vested-finance-wp'),
		'menu_name' => _x('Quizzes', 'admin menu', 'vested-finance-wp'),
		'name_admin_bar' => _x('Quiz', 'add new on admin bar', 'vested-finance-wp'),
		'add_new' => _x('Add New', 'quiz', 'vested-finance-wp'),
		'add_new_item' => __('Add New Quiz', 'vested-finance-wp'),
		'new_item' => __('New Quiz', 'vested-finance-wp'),
		'edit_item' => __('Edit Quiz', 'vested-finance-wp'),
		'view_item' => __('View Quiz', 'vested-finance-wp'),
		'all_items' => __('Quiz', 'vested-finance-wp'),
		'search_items' => __('Search Quizzes', 'vested-finance-wp'),
		'not_found' => __('No quizzes found.', 'vested-finance-wp'),
		'not_found_in_trash' => __('No quizzes found in Trash.', 'vested-finance-wp'),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		// Place under Modules menu
		'show_in_menu' => 'edit.php?post_type=module',
		'show_in_nav_menus' => false,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
		'hierarchical' => false,
		'has_archive' => false,
		'publicly_queryable' => true,
		'show_in_rest' => true,
		'rewrite' => array(
			'slug' => 'academy/%module%/%chapter%',
			'with_front' => false,
		),
		'query_var' => true,
	);

	register_post_type('quiz', $args);
}
add_action('init', 'vested_academy_register_quiz_cpt');

/**
 * Filter quiz permalink structure
 */
function vested_academy_quiz_permalink($permalink, $post)
{
	if ($post->post_type !== 'quiz') {
		return $permalink;
	}

	return home_url('/academy/quiz/' . $post->post_name . '/');
}
add_filter('post_type_link', 'vested_academy_quiz_permalink', 10, 2);

/**
 * Rewrite rule to resolve quiz URLs
 */
function vested_academy_quiz_rewrite()
{
	add_rewrite_rule(
		'^academy/quiz/([^/]+)/?$',
		'index.php?post_type=quiz&name=$matches[1]',
		'top'
	);
}
add_action('init', 'vested_academy_quiz_rewrite');

/**
 * Get quizzes for a module using the quiz_links relationship field
 * Similar to how chapter_topic_links works
 */
function vested_academy_get_quizzes_for_module($module_id)
{
	if (!$module_id) {
		return array();
	}

	// Get quizzes from relationship field
	$selected = get_field('quiz_links', $module_id);
	$quizzes = array();

	// Handle both array and single object/ID (ACF can return either depending on field settings)
	if ($selected) {
		// Convert single object/ID to array for consistent processing
		if (!is_array($selected)) {
			$selected = array($selected);
		}

		$selected_posts = array();
		foreach ($selected as $item) {
			if (is_object($item)) {
				$selected_posts[] = $item;
			} elseif (is_numeric($item)) {
				$found = get_post($item);
				if ($found) {
					$selected_posts[] = $found;
				}
			}
		}

		if ($selected_posts) {
			foreach ($selected_posts as $quiz_post) {
				// Get quiz questions from ACF
				$quiz_questions = get_field('quiz_questions', $quiz_post->ID);

				$quizzes[] = array(
					'id' => $quiz_post->ID,
					'title' => get_the_title($quiz_post->ID),
					'questions' => $quiz_questions ?: array(),
					'passing_score' => get_field('passing_score', $quiz_post->ID) ?: 70,
					'time_limit' => get_field('time_limit', $quiz_post->ID) ?: 12,
					'content' => apply_filters('the_content', $quiz_post->post_content),
					'permalink' => get_permalink($quiz_post->ID),
				);
			}
		}
	}

	return $quizzes;
}

/**
 * Ensure modules taxonomy is registered for module post type
 */
function vested_academy_register_quiz_taxonomy()
{
	// Check if modules taxonomy exists
	if (!taxonomy_exists('modules')) {
		// If taxonomy doesn't exist, register it
		$taxonomy_labels = array(
			'name' => _x('Modules', 'taxonomy general name', 'vested-finance-wp'),
			'singular_name' => _x('Module', 'taxonomy singular name', 'vested-finance-wp'),
			'search_items' => __('Search Modules', 'vested-finance-wp'),
			'all_items' => __('All Modules', 'vested-finance-wp'),
			'parent_item' => __('Parent Module', 'vested-finance-wp'),
			'parent_item_colon' => __('Parent Module:', 'vested-finance-wp'),
			'edit_item' => __('Edit Module', 'vested-finance-wp'),
			'update_item' => __('Update Module', 'vested-finance-wp'),
			'add_new_item' => __('Add New Module', 'vested-finance-wp'),
			'new_item_name' => __('New Module Name', 'vested-finance-wp'),
			'menu_name' => __('Modules', 'vested-finance-wp'),
		);

		$taxonomy_args = array(
			'hierarchical' => true,
			'labels' => $taxonomy_labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'modules'),
			'show_in_rest' => true,
		);

		register_taxonomy('modules', array('module'), $taxonomy_args);
	}
}
add_action('init', 'vested_academy_register_quiz_taxonomy', 10);


/**
 * Hide the Modules taxonomy submenu from admin sidebar
 * Uses multiple hooks and methods to ensure it's removed
 */
function vested_academy_hide_modules_taxonomy_submenu()
{
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
	foreach ($possible_slugs as $taxonomy_slug) {
		remove_submenu_page($parent_slug, $taxonomy_slug);
	}

	// Method 2: Directly manipulate the submenu array (more aggressive)
	if (isset($submenu[$parent_slug]) && is_array($submenu[$parent_slug])) {
		foreach ($submenu[$parent_slug] as $key => $item) {
			// Check if this is the taxonomy menu item
			if (isset($item[2])) {
				// Check for any variation containing taxonomy=modules
				if (
					strpos($item[2], 'taxonomy=modules') !== false ||
					strpos($item[2], 'taxonomy%3Dmodules') !== false
				) { // URL encoded
					unset($submenu[$parent_slug][$key]);
				}
			}
		}
		// Re-index array to prevent issues
		$submenu[$parent_slug] = array_values($submenu[$parent_slug]);
	}
}

// Try multiple hooks with different priorities to catch it at different stages
add_action('_admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 999);
add_action('admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 999);
add_action('admin_menu', 'vested_academy_hide_modules_taxonomy_submenu', 9999);

/**
 * Remove unwanted submenu items under Modules.
 * - Add New Chapter
 * - Re-Order
 */
function vested_academy_clean_modules_menu()
{
	$parent_slug = 'edit.php?post_type=module';

	// Remove via core helper.
	remove_submenu_page($parent_slug, 'post-new.php?post_type=module');
	remove_submenu_page($parent_slug, 'edit.php?post_type=module&orderby=menu_order&order=asc');
	remove_submenu_page($parent_slug, 'edit.php?post_type=module&amp;orderby=menu_order&amp;order=asc');

	// Extra safety: strip by slug/title if still present.
	global $submenu;
	if (isset($submenu[$parent_slug]) && is_array($submenu[$parent_slug])) {
		foreach ($submenu[$parent_slug] as $key => $item) {
			$slug = isset($item[2]) ? $item[2] : '';
			$title = isset($item[0]) ? strip_tags($item[0]) : '';

			$is_add_new = strpos($slug, 'post-new.php?post_type=module') !== false
				|| stripos($title, 'add new') !== false;
			$is_reorder = stripos($slug, 're-order') !== false
				|| stripos($slug, 'reorder') !== false
				|| stripos($slug, 'orderby=menu_order') !== false
				|| stripos($title, 're-order') !== false
				|| stripos($title, 'reorder') !== false;

			if ($is_add_new || $is_reorder) {
				unset($submenu[$parent_slug][$key]);
			}
		}
		$submenu[$parent_slug] = array_values($submenu[$parent_slug]);
	}
}
add_action('admin_menu', 'vested_academy_clean_modules_menu', 1000);

/**
 * Add CSS to hide the taxonomy menu item as a fallback
 */
function vested_academy_hide_modules_taxonomy_css()
{
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
add_action('admin_head', 'vested_academy_hide_modules_taxonomy_css');

/**
 * Create custom database table for progress tracking
 */
function vested_academy_create_progress_table()
{
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

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

/**
 * Create custom database table for individual quiz question answers
 */
function vested_academy_create_quiz_answers_table()
{
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

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

/**
 * Initialize progress table on theme activation or when needed
 */
function vested_academy_init_progress_table()
{
	vested_academy_create_progress_table();
	vested_academy_create_quiz_answers_table();
}
add_action('after_setup_theme', 'vested_academy_init_progress_table');

// Also create table when admin visits Academy pages
add_action('admin_init', 'vested_academy_init_progress_table');

/**
 * Get all progress for user's chapters/topics in one query (optimized)
 */
function vested_academy_get_batch_progress($user_id, $chapter_ids = array(), $topic_data = array())
{
	if (!$user_id || (empty($chapter_ids) && empty($topic_data))) {
		return array();
	}

	// Check if cache was invalidated (by checking version number)
	$batch_cache_version_key = 'academy_batch_cache_version_' . $user_id;
	$current_cache_version = wp_cache_get($batch_cache_version_key, 'academy');

	// Check cache first (but only if version hasn't changed)
	$cache_key = 'academy_progress_' . $user_id . '_' . md5(serialize(array($chapter_ids, $topic_data)));
	$cached = wp_cache_get($cache_key, 'academy');

	// Check if cached data has a version stored
	$cached_version = ($cached !== false && isset($cached['_cache_version'])) ? $cached['_cache_version'] : null;

	// If we have cached data and versions match (or no invalidation happened), return cached
	if ($cached !== false && ($current_cache_version === false || $cached_version === $current_cache_version)) {
		// Remove the version metadata before returning
		unset($cached['_cache_version']);
		return $cached;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	$results = array(
		'chapters' => array(),
		'topics' => array(),
	);

	// Build query for chapters
	if (!empty($chapter_ids)) {
		$chapter_ids = array_map('intval', $chapter_ids);
		$chapter_ids = array_unique($chapter_ids);
		$placeholders = implode(',', array_fill(0, count($chapter_ids), '%d'));

		$chapter_progress = $wpdb->get_results($wpdb->prepare(
			"SELECT chapter_id, status, progress_percentage 
			FROM $table_name 
			WHERE user_id = %d 
			AND chapter_id IN ($placeholders) 
			AND progress_type = 'chapter'",
			array_merge(array($user_id), $chapter_ids)
		), ARRAY_A);

		foreach ($chapter_progress as $progress) {
			$results['chapters'][$progress['chapter_id']] = array(
				'status' => $progress['status'],
				'progress' => intval($progress['progress_percentage']),
			);
		}
	}

	// Build query for topics
	if (!empty($topic_data)) {
		$topic_conditions = array();
		$topic_params = array($user_id);

		foreach ($topic_data as $topic) {
			$topic_conditions[] = '(chapter_id = %d AND topic_index = %d)';
			$topic_params[] = intval($topic['chapter_id']);
			$topic_params[] = intval($topic['topic_index']);
		}

		if (!empty($topic_conditions)) {
			$topic_query = "SELECT chapter_id, topic_index, status, progress_percentage 
				FROM $table_name 
				WHERE user_id = %d 
				AND progress_type = 'topic' 
				AND (" . implode(' OR ', $topic_conditions) . ")";

			$topic_progress = $wpdb->get_results($wpdb->prepare($topic_query, $topic_params), ARRAY_A);

			foreach ($topic_progress as $progress) {
				$key = $progress['chapter_id'] . '_' . $progress['topic_index'];
				$results['topics'][$key] = array(
					'status' => $progress['status'],
					'progress' => intval($progress['progress_percentage']),
				);
			}
		}
	}

	// Store cache version with the results
	$results['_cache_version'] = $current_cache_version !== false ? $current_cache_version : 0;

	// Cache for 5 minutes
	wp_cache_set($cache_key, $results, 'academy', 300);

	// Remove version metadata before returning
	unset($results['_cache_version']);

	return $results;
}

/**
 * Track chapter progress
 */
function vested_academy_track_chapter_progress($user_id, $chapter_id, $module_id = null, $progress_percentage = 0)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Check if progress already exists
	$existing = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter'",
		$user_id,
		$chapter_id
	));

	// Mark as completed at 90% or higher (to account for scroll calculation edge cases)
	$status = ($progress_percentage >= 90) ? 'completed' : 'in_progress';
	$completed_at = ($progress_percentage >= 90) ? current_time('mysql') : null;

	if ($existing) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'progress_percentage' => $progress_percentage,
				'status' => $status,
				'completed_at' => $completed_at,
			),
			array(
				'user_id' => $user_id,
				'chapter_id' => $chapter_id,
				'progress_type' => 'chapter',
			),
			array('%d', '%s', '%s'),
			array('%d', '%d', '%s')
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'module_id' => $module_id,
				'chapter_id' => $chapter_id,
				'progress_type' => 'chapter',
				'status' => $status,
				'progress_percentage' => $progress_percentage,
				'completed_at' => $completed_at,
			),
			array('%d', '%d', '%d', '%s', '%s', '%d', '%s')
		);
	}

	// Clear cache after update
	wp_cache_delete('academy_progress_' . $user_id, 'academy');
	wp_cache_delete('academy_progress_' . $user_id . '_' . $chapter_id, 'academy');
	wp_cache_delete('academy_topic_completed_' . $user_id . '_' . $chapter_id, 'academy');
	// Note: Batch cache will expire naturally (5 min TTL) or be cleared on next update
}

/**
 * Track topic progress
 * @param int $user_id User ID
 * @param int $chapter_id Chapter ID
 * @param int $topic_index Topic index
 * @param int|null $module_id Module ID
 * @param int $progress_percentage Progress percentage (0-100)
 * @param bool $force_complete If true, explicitly mark as completed (from Next/Quiz buttons). If false, only update progress (from scroll tracking).
 */
function vested_academy_track_topic_progress($user_id, $chapter_id, $topic_index, $module_id = null, $progress_percentage = 0, $force_complete = false)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Check if progress already exists
	$existing = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND topic_index = %d AND progress_type = 'topic'",
		$user_id,
		$chapter_id,
		$topic_index
	));

	// ONLY set status='completed' if explicitly forced (from Next/Quiz buttons)
	// Scroll tracking should NEVER set status to 'completed', regardless of progress percentage
	if ($force_complete) {
		// Explicit completion from Next/Quiz buttons
		$status = 'completed';
		$completed_at = current_time('mysql');
	} elseif ($existing && $existing->status === 'completed') {
		// If already completed, keep it completed (don't downgrade)
		$status = 'completed';
		$completed_at = $existing->completed_at;
	} else {
		// Otherwise, keep as in_progress (scroll tracking updates progress but not status)
		// Even if progress_percentage >= 90 or == 100, don't set status='completed' unless force_complete=true
		$status = 'in_progress';
		$completed_at = null;
	}

	if ($existing) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'progress_percentage' => $progress_percentage,
				'status' => $status,
				'completed_at' => $completed_at,
			),
			array(
				'user_id' => $user_id,
				'chapter_id' => $chapter_id,
				'topic_index' => $topic_index,
				'progress_type' => 'topic',
			),
			array('%d', '%s', '%s'),
			array('%d', '%d', '%d', '%s')
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'module_id' => $module_id,
				'chapter_id' => $chapter_id,
				'topic_index' => $topic_index,
				'progress_type' => 'topic',
				'status' => $status,
				'progress_percentage' => $progress_percentage,
				'completed_at' => $completed_at,
			),
			array('%d', '%d', '%d', '%d', '%s', '%s', '%d', '%s')
		);
	}

	// Clear cache after update
	wp_cache_delete('academy_progress_' . $user_id, 'academy');
	wp_cache_delete('academy_progress_' . $user_id . '_' . $chapter_id . '_' . $topic_index, 'academy');
	wp_cache_delete('academy_topic_completed_' . $user_id . '_' . $chapter_id . '_' . $topic_index, 'academy');

	// Clear batch cache by updating a version number
	// This forces all batch queries to skip cache on next request
	$batch_cache_version_key = 'academy_batch_cache_version_' . $user_id;
	$cache_version = time();
	wp_cache_set($batch_cache_version_key, $cache_version, 'academy', 600); // 10 minute TTL
}

/**
 * Mark topic as completed (simplified - completion only, no progress tracking)
 * Used when user clicks Next Topic or Take Quiz button
 * 
 * @param int $user_id User ID
 * @param int $chapter_id Chapter ID
 * @param int $topic_index Topic index
 * @return bool True if marked as completed, false on error
 */
function vested_academy_mark_topic_completed($user_id, $chapter_id, $topic_index)
{
	if (!$user_id || !$chapter_id || $topic_index === null) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Check if already completed (avoid duplicate updates)
	$existing = $wpdb->get_var($wpdb->prepare(
		"SELECT id FROM $table_name 
		WHERE user_id = %d 
		AND chapter_id = %d 
		AND topic_index = %d 
		AND progress_type = 'topic' 
		AND status = 'completed'
		LIMIT 1",
		$user_id,
		$chapter_id,
		$topic_index
	));

	// Already completed, return true
	if ($existing) {
		return true;
	}

	// Check if record exists (might be in_progress from scroll tracking)
	$existing_record = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name 
		WHERE user_id = %d 
		AND chapter_id = %d 
		AND topic_index = %d 
		AND progress_type = 'topic'",
		$user_id,
		$chapter_id,
		$topic_index
	));

	if ($existing_record) {
		// Update existing record to completed
		$wpdb->update(
			$table_name,
			array(
				'status' => 'completed',
				'completed_at' => current_time('mysql'),
			),
			array(
				'user_id' => $user_id,
				'chapter_id' => $chapter_id,
				'topic_index' => $topic_index,
				'progress_type' => 'topic',
			),
			array('%s', '%s'),
			array('%d', '%d', '%d', '%s')
		);
	} else {
		// Insert new record as completed
		$wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'chapter_id' => $chapter_id,
				'topic_index' => $topic_index,
				'progress_type' => 'topic',
				'status' => 'completed',
				'completed_at' => current_time('mysql'),
			),
			array('%d', '%d', '%d', '%s', '%s', '%s')
		);
	}

	// Clear all related caches
	wp_cache_delete('academy_progress_' . $user_id, 'academy');
	wp_cache_delete('academy_progress_' . $user_id . '_' . $chapter_id . '_' . $topic_index, 'academy');
	wp_cache_delete('academy_topic_completed_' . $user_id . '_' . $chapter_id . '_' . $topic_index, 'academy');
	wp_cache_delete('academy_topic_status_' . $user_id . '_' . $chapter_id, 'academy');

	// Invalidate batch cache by updating version
	$batch_cache_version_key = 'academy_batch_cache_version_' . $user_id;
	$cache_version = time();
	wp_cache_set($batch_cache_version_key, $cache_version, 'academy', 600);

	return true;
}

/**
 * Check if topic is completed (with caching)
 * ONLY returns true if status='completed' in database (not based on progress percentage)
 */
function vested_academy_is_topic_completed($user_id, $chapter_id, $topic_index)
{
	if (!$user_id || !$chapter_id || $topic_index === null) {
		return false;
	}

	// Check cache first
	$cache_key = 'academy_topic_completed_' . $user_id . '_' . $chapter_id . '_' . $topic_index;
	$cached = wp_cache_get($cache_key, 'academy');
	if ($cached !== false) {
		return (bool) $cached;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// CRITICAL: Only check status='completed', NOT progress_percentage
	// Scroll tracking can set progress to 100% but should NOT set status='completed'
	$progress = $wpdb->get_row($wpdb->prepare(
		"SELECT id FROM $table_name 
		WHERE user_id = %d 
		AND chapter_id = %d 
		AND topic_index = %d 
		AND progress_type = 'topic' 
		AND status = 'completed'
		LIMIT 1",
		$user_id,
		$chapter_id,
		$topic_index
	));

	$is_completed = !empty($progress);

	// Cache for 5 minutes
	wp_cache_set($cache_key, $is_completed ? 1 : 0, 'academy', 300);

	return $is_completed;
}

/**
 * Check if all topics in a chapter are completed
 */
function vested_academy_are_all_topics_completed($user_id, $chapter_id, $topics)
{
	if (!$user_id || !$chapter_id || empty($topics)) {
		return false;
	}

	foreach ($topics as $index => $topic) {
		if (!vested_academy_is_topic_completed($user_id, $chapter_id, $index)) {
			return false;
		}
	}

	return true;
}

/**
 * Track quiz attempt and score
 */
function vested_academy_track_quiz_attempt($user_id, $quiz_id, $module_id = null, $score = 0, $total_questions = 0)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Calculate percentage
	$progress_percentage = ($total_questions > 0) ? round(($score / $total_questions) * 100) : 0;
	$status = ($progress_percentage >= 70) ? 'completed' : 'in_progress'; // 70% passing score

	// Get existing attempt count
	$existing = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
		$user_id,
		$quiz_id
	));

	$attempts = $existing ? ($existing->quiz_attempts + 1) : 1;
	$completed_at = ($status === 'completed') ? current_time('mysql') : null;

	if ($existing) {
		// Update existing progress
		$wpdb->update(
			$table_name,
			array(
				'quiz_score' => $score,
				'progress_percentage' => $progress_percentage,
				'status' => $status,
				'quiz_attempts' => $attempts,
				'completed_at' => $completed_at,
			),
			array('id' => $existing->id),
			array('%d', '%d', '%s', '%d', '%s'),
			array('%d')
		);
	} else {
		// Insert new progress
		$wpdb->insert(
			$table_name,
			array(
				'user_id' => $user_id,
				'module_id' => $module_id,
				'quiz_id' => $quiz_id,
				'progress_type' => 'quiz',
				'status' => $status,
				'progress_percentage' => $progress_percentage,
				'quiz_score' => $score,
				'quiz_attempts' => $attempts,
				'completed_at' => $completed_at,
			),
			array('%d', '%d', '%d', '%s', '%s', '%d', '%d', '%d', '%s')
		);
	}

	// Clear cache after update
	wp_cache_delete('academy_progress_' . $user_id, 'academy');
	wp_cache_delete('academy_progress_' . $user_id . '_quiz_' . $quiz_id, 'academy');
	// Note: Batch cache will expire naturally (5 min TTL) or be cleared on next update

	return array(
		'score' => $score,
		'percentage' => $progress_percentage,
		'status' => $status,
		'attempts' => $attempts,
	);
}

/**
 * Get quiz result for a user (latest completed attempt)
 * Returns quiz result data if quiz is completed, null otherwise
 * 
 * @param int $user_id User ID
 * @param int $quiz_id Quiz ID
 * @return object|null Quiz result object or null if not completed
 */
function vested_academy_get_quiz_result($user_id, $quiz_id)
{
	if (!$user_id || !$quiz_id) {
		return null;
	}

	// Check cache first
	$cache_key = 'academy_quiz_result_' . $user_id . '_' . $quiz_id;
	$cached = wp_cache_get($cache_key, 'academy');
	if ($cached !== false) {
		return $cached === 'null' ? null : $cached;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Get latest completed quiz attempt
	$result = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name 
		WHERE user_id = %d 
		AND quiz_id = %d 
		AND progress_type = 'quiz' 
		AND status = 'completed'
		ORDER BY completed_at DESC, id DESC 
		LIMIT 1",
		$user_id,
		$quiz_id
	));

	// Cache result (null if not found)
	wp_cache_set($cache_key, $result ? $result : 'null', 'academy', 300);

	return $result ? $result : null;
}

/**
 * Check if quiz is completed for a user
 * 
 * @param int $user_id User ID
 * @param int $quiz_id Quiz ID
 * @return bool True if quiz is completed, false otherwise
 */
function vested_academy_is_quiz_completed($user_id, $quiz_id)
{
	$result = vested_academy_get_quiz_result($user_id, $quiz_id);
	return $result !== null;
}

/**
 * Reset quiz attempt - allows user to retake quiz
 * Clears quiz answers and resets progress status
 * Note: Attempt count is preserved and will increment on next submission
 * 
 * @param int $user_id User ID
 * @param int $quiz_id Quiz ID
 * @return bool True on success, false on error
 */
function vested_academy_reset_quiz_attempt($user_id, $quiz_id)
{
	if (!$user_id || !$quiz_id) {
		return false;
	}

	global $wpdb;
	$progress_table = $wpdb->prefix . 'academy_progress';
	$answers_table = $wpdb->prefix . 'academy_quiz_answers';

	// Get current quiz progress
	$existing = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $progress_table 
		WHERE user_id = %d 
		AND quiz_id = %d 
		AND progress_type = 'quiz' 
		ORDER BY id DESC LIMIT 1",
		$user_id,
		$quiz_id
	));

	if ($existing) {
		// Reset status to in_progress (don't delete, keep attempt count for history)
		// When user submits again, track_quiz_attempt will increment quiz_attempts
		$wpdb->update(
			$progress_table,
			array(
				'status' => 'in_progress',
				'progress_percentage' => 0,
				'quiz_score' => 0,
				'completed_at' => null,
			),
			array('id' => $existing->id),
			array('%s', '%d', '%d', '%s'),
			array('%d')
		);
	}

	// Clear all saved answers for this quiz (fresh start)
	$wpdb->delete(
		$answers_table,
		array(
			'user_id' => $user_id,
			'quiz_id' => $quiz_id,
		),
		array('%d', '%d')
	);

	// Clear all related caches
	wp_cache_delete('academy_progress_' . $user_id, 'academy');
	wp_cache_delete('academy_progress_' . $user_id . '_quiz_' . $quiz_id, 'academy');
	wp_cache_delete('academy_quiz_result_' . $user_id . '_' . $quiz_id, 'academy');
	wp_cache_delete('academy_quiz_results_' . $user_id . '_' . $quiz_id, 'academy');

	// Invalidate batch cache
	$batch_cache_version_key = 'academy_batch_cache_version_' . $user_id;
	$cache_version = time();
	wp_cache_set($batch_cache_version_key, $cache_version, 'academy', 600);

	return true;
}

/**
 * Get user progress for a module
 */
function vested_academy_get_module_progress($user_id, $module_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	$progress = $wpdb->get_results($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND module_id = %d ORDER BY started_at ASC",
		$user_id,
		$module_id
	));

	return $progress;
}

/**
 * Get user's overall Academy progress
 */
function vested_academy_get_user_progress($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	$progress = $wpdb->get_results($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d ORDER BY started_at DESC",
		$user_id
	));

	return $progress;
}

/**
 * Track resume state for logged-in users (NEW - User Meta Only)
 * Stores learning state (module_id, chapter_id, topic_index, is_quiz) - NOT URLs
 * This is the single source of truth for logged-in user resume state
 * 
 * @param int $chapter_id Chapter ID
 * @param int|null $module_id Module ID
 * @param int|null $topic_index Topic index (0-based)
 * @param string|null $topic_slug Topic slug (optional, for reference)
 * @param bool $is_quiz Whether viewing quiz
 * @return array|null Resume state array or null if user not logged in
 */
function vested_academy_track_resume_state($chapter_id, $module_id = null, $topic_index = null, $topic_slug = null, $is_quiz = false)
{
	$user_id = get_current_user_id();
	
	// Only track for logged-in users
	if (!$user_id) {
		return null;
	}
	
	// Build resume state (learning state, not URLs)
	$resume_state = array(
		'module_id' => $module_id ? intval($module_id) : null,
		'chapter_id' => intval($chapter_id),
		'topic_index' => $topic_index !== null ? intval($topic_index) : null,
		'is_quiz' => $is_quiz ? true : false,
		'updated_at' => current_time('mysql'),
	);
	
	// Store in user meta (single source of truth)
	update_user_meta($user_id, 'academy_resume_state', $resume_state);
	
	// Also store per-module for quick lookup (if module_id available)
	if ($module_id) {
		update_user_meta($user_id, 'academy_resume_state_module_' . $module_id, $resume_state);
	}
	
	return $resume_state;
}

/**
 * Get resume state for logged-in user
 * 
 * @param int|null $module_id Optional module ID for module-specific lookup
 * @return array|null Resume state array or null
 */
function vested_academy_get_resume_state($module_id = null)
{
	$user_id = get_current_user_id();
	
	if (!$user_id) {
		return null;
	}
	
	// Try module-specific state first
	if ($module_id) {
		$state = get_user_meta($user_id, 'academy_resume_state_module_' . $module_id, true);
		if ($state && is_array($state)) {
			return $state;
		}
	}
	
	// Fallback to general resume state
	$state = get_user_meta($user_id, 'academy_resume_state', true);
	if ($state && is_array($state)) {
		return $state;
	}
	
	return null;
}

/**
 * Track last visited page/chapter/topic for user
 * Works for both logged-in users (user meta) and non-logged users (session/cookie)
 * @deprecated For logged-in users, use vested_academy_track_resume_state() instead
 */
function vested_academy_track_last_visited($chapter_id, $module_id = null, $topic_index = null, $topic_slug = null, $is_quiz = false)
{
	// Ensure session is started
	if (!session_id() && !headers_sent()) {
		session_start();
	}

	$user_id = get_current_user_id();
	$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$last_visited = array(
		'chapter_id' => intval($chapter_id),
		'module_id' => $module_id ? intval($module_id) : null,
		'topic_index' => $topic_index !== null ? intval($topic_index) : null,
		'topic_slug' => $topic_slug ? sanitize_text_field($topic_slug) : null,
		'is_quiz' => $is_quiz ? 1 : 0,
		'url' => esc_url_raw($current_url),
		'timestamp' => current_time('mysql'),
	);

	if ($user_id) {
		// Store in user meta for logged-in users
		update_user_meta($user_id, 'academy_last_visited', $last_visited);
		// Also store per module for quick lookup
		if ($module_id) {
			update_user_meta($user_id, 'academy_last_visited_module_' . $module_id, $last_visited);
		}
	} else {
		// Store in session for non-logged users
		$_SESSION['academy_last_visited'] = $last_visited;
		// Also store in cookie as backup (30 days)
		setcookie('academy_last_visited', json_encode($last_visited), time() + (86400 * 30), '/');
	}

	return $last_visited;
}

/**
 * Get last visited page for user
 * Returns last visited chapter/topic/quiz URL
 */
function vested_academy_get_last_visited($module_id = null)
{
	$user_id = get_current_user_id();

	if ($user_id) {
		// For logged-in users, check user meta
		if ($module_id) {
			$last_visited = get_user_meta($user_id, 'academy_last_visited_module_' . $module_id, true);
			if ($last_visited && is_array($last_visited)) {
				return $last_visited;
			}
		}

		// Fallback to general last visited
		$last_visited = get_user_meta($user_id, 'academy_last_visited', true);
		if ($last_visited && is_array($last_visited)) {
			return $last_visited;
		}
	} else {
		// For non-logged users, check session first
		if (!session_id() && !headers_sent()) {
			session_start();
		}

		if (isset($_SESSION['academy_last_visited']) && is_array($_SESSION['academy_last_visited'])) {
			return $_SESSION['academy_last_visited'];
		}

		// Fallback to cookie
		if (isset($_COOKIE['academy_last_visited'])) {
			$last_visited = json_decode(stripslashes($_COOKIE['academy_last_visited']), true);
			if ($last_visited && is_array($last_visited)) {
				return $last_visited;
			}
		}
	}

	return null;
}

/**
 * Get last visited URL for guest users (for redirect_to flow)
 * ROOT-LEVEL: Returns the stored URL from session/cookie for WordPress native redirect_to
 * 
 * @return string|null Last visited academy page URL or null
 */
function vested_academy_get_last_visited_url()
{
	if (is_user_logged_in()) {
		// For logged-in users, use the existing resume flow
		return null;
	}

	$last_visited = vested_academy_get_last_visited();
	
	if ($last_visited && is_array($last_visited) && isset($last_visited['url'])) {
		$url = esc_url_raw($last_visited['url']);
		// Ensure it's an academy page
		if (strpos($url, '/academy/') !== false && strpos($url, '/academy/login') === false && strpos($url, '/academy/signup') === false) {
			return $url;
		}
	}

	return null;
}

/**
 * CENTRALIZED RESUME URL FUNCTION (LOGGED-IN USERS ONLY)
 * 
 * This is the SINGLE source of truth for determining where a logged-in user
 * should resume their Academy learning. All resume decisions must go through this function.
 * 
 * Priority Order:
 * 1. Explicit redirect_to (if provided and valid)
 * 2. Stored academy_resume_state (validated)
 * 3. Next uncompleted topic in module
 * 4. First chapter → first topic
 * 
 * @param int $user_id User ID (required for logged-in users)
 * @param array $args Optional arguments:
 *   - module_id (int): Module ID to resume within
 *   - redirect_to (string): Explicit redirect URL (highest priority)
 *   - allow_next_incomplete (bool): Allow fallback to next incomplete (default: true)
 *   - fallback_first (bool): Fallback to first chapter/topic (default: true)
 * @return string|null Resume URL or null if no valid resume point
 */
function vested_academy_get_resume_url($user_id, $args = array())
{
	if (!$user_id) {
		return null;
	}
	
	$module_id = isset($args['module_id']) ? intval($args['module_id']) : null;
	$redirect_to = isset($args['redirect_to']) ? esc_url_raw($args['redirect_to']) : null;
	$allow_next_incomplete = isset($args['allow_next_incomplete']) ? (bool)$args['allow_next_incomplete'] : true;
	$fallback_first = isset($args['fallback_first']) ? (bool)$args['fallback_first'] : true;
	
	// PRIORITY 1: Explicit redirect_to (if provided and valid Academy page)
	if ($redirect_to && strpos($redirect_to, '/academy/') !== false) {
		// Validate it's a real Academy page
		$parsed = parse_url($redirect_to);
		if ($parsed && isset($parsed['path'])) {
			// Basic validation - if it contains /academy/, allow it
			return $redirect_to;
		}
	}
	
	// PRIORITY 2: Stored academy_resume_state (validated)
	if ($module_id) {
		$resume_state = vested_academy_get_resume_state($module_id);
	} else {
		$resume_state = vested_academy_get_resume_state();
	}
	
	if ($resume_state && isset($resume_state['chapter_id'])) {
		$chapter_id = intval($resume_state['chapter_id']);
		$state_module_id = isset($resume_state['module_id']) ? intval($resume_state['module_id']) : null;
		$topic_index = isset($resume_state['topic_index']) ? intval($resume_state['topic_index']) : null;
		$is_quiz = isset($resume_state['is_quiz']) ? (bool)$resume_state['is_quiz'] : false;
		
		// Validate chapter exists
		$chapter = get_post($chapter_id);
		if ($chapter && $chapter->post_type === 'module') {
			// Validate module consistency (if module_id provided)
			if ($module_id && $state_module_id && $state_module_id != $module_id) {
				// State is for different module, skip it
				$resume_state = null;
			} else {
				// Validate chapter belongs to module (if module_id provided)
				if ($module_id) {
					$chapter_belongs_to_module = false;
					
					// Check taxonomy
					$terms = get_the_terms($chapter_id, 'modules');
					if ($terms && !is_wp_error($terms)) {
						foreach ($terms as $term) {
							if ($term->term_id == $module_id) {
								$chapter_belongs_to_module = true;
								break;
							}
						}
					}
					
					// Check ACF relationship
					if (!$chapter_belongs_to_module) {
						$related_modules = get_field('academy_module', $chapter_id);
						if ($related_modules) {
							if (is_array($related_modules)) {
								foreach ($related_modules as $rel_module) {
									$rel_id = is_object($rel_module) ? $rel_module->ID : (is_numeric($rel_module) ? $rel_module : null);
									if ($rel_id == $module_id) {
										$chapter_belongs_to_module = true;
										break;
									}
								}
							} elseif (is_numeric($related_modules) && $related_modules == $module_id) {
								$chapter_belongs_to_module = true;
							}
						}
					}
					
					if (!$chapter_belongs_to_module) {
						// Chapter doesn't belong to this module, skip state
						$resume_state = null;
					}
				}
				
				// If state is valid, generate URL from IDs
				if ($resume_state) {
					// Generate URL from state (never use stored URLs)
					if ($is_quiz) {
						$quiz_url = get_permalink($chapter_id);
						$quiz_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), $quiz_url);
						$quiz_url = add_query_arg('quiz', '1', $quiz_url) . '#quiz-content';
						return $quiz_url;
					} elseif ($topic_index !== null) {
						// Get topics to validate index
						$topics = vested_academy_get_topics_for_chapter($chapter_id);
						if (empty($topics)) {
							$topics = get_field('chapter_topics', $chapter_id);
							if (!$topics || !is_array($topics)) {
								$topics = array();
							}
						}
						
						// Validate topic index
						if (isset($topics[$topic_index])) {
							$topic = $topics[$topic_index];
							// Try slug-based URL first
							if (isset($topic['topic_slug']) && function_exists('vested_academy_get_topic_url')) {
								$topic_url = vested_academy_get_topic_url($chapter_id, $topic['topic_slug']);
								if ($topic_url) {
									return $topic_url;
								}
							}
							// Fallback to index-based URL
							$topic_url = get_permalink($chapter_id);
							$topic_url = remove_query_arg('topic', $topic_url);
							$topic_url = add_query_arg('topic', $topic_index, $topic_url);
							return $topic_url;
						}
						// Topic index invalid, fall through to next priority
					} else {
						// Just chapter, no topic
						return get_permalink($chapter_id);
					}
				}
			}
		}
	}
	
	// PRIORITY 3: Next uncompleted topic in module
	if ($allow_next_incomplete && $module_id) {
		$next_url = vested_academy_get_next_incomplete_url($module_id, $user_id);
		if ($next_url) {
			return $next_url;
		}
	}
	
	// PRIORITY 4: First chapter → first topic
	if ($fallback_first && $module_id) {
		return vested_academy_get_first_chapter_url($module_id);
	}
	
	return null;
}

/**
 * Get URL for next uncompleted topic in a module
 * Helper function for resume URL priority 3
 * 
 * @param int $module_id Module ID
 * @param int $user_id User ID
 * @return string|null URL to next uncompleted topic or null
 */
function vested_academy_get_next_incomplete_url($module_id, $user_id)
{
	if (!$module_id || !$user_id) {
		return null;
	}
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';
	
	// Determine if module_id is a post type or taxonomy term
	$module_post = get_post($module_id);
	$is_post_type = ($module_post && $module_post->post_type === 'academy_module');
	
	// Get all chapters for this module
	if ($is_post_type) {
		$chapters_query = new WP_Query(array(
			'post_type' => 'module',
			'meta_query' => array(
				array(
					'key' => 'academy_module',
					'value' => $module_id,
					'compare' => 'LIKE',
				),
			),
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'no_found_rows' => true,
		));
	} else {
		$chapters_query = new WP_Query(array(
			'post_type' => 'module',
			'tax_query' => array(
				array(
					'taxonomy' => 'modules',
					'field' => 'term_id',
					'terms' => $module_id,
				),
			),
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'no_found_rows' => true,
		));
	}
	
	if ($chapters_query->have_posts()) {
		while ($chapters_query->have_posts()) {
			$chapters_query->the_post();
			$chapter_id = get_the_ID();
			
			// Check if chapter is completed
			$chapter_completed = $wpdb->get_var($wpdb->prepare(
				"SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter' AND status = 'completed'",
				$user_id,
				$chapter_id
			));
			
			if (!$chapter_completed) {
				// Chapter not completed, check topics
				$topics = vested_academy_get_topics_for_chapter($chapter_id);
				if (empty($topics)) {
					$topics = get_field('chapter_topics', $chapter_id);
					if (!$topics || !is_array($topics)) {
						$topics = array();
					}
				}
				
				if (!empty($topics)) {
					// Find first uncompleted topic
					foreach ($topics as $idx => $topic) {
						$topic_completed = $wpdb->get_var($wpdb->prepare(
							"SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND chapter_id = %d AND topic_index = %d AND progress_type = 'topic' AND status = 'completed'",
							$user_id,
							$chapter_id,
							$idx
						));
						
						if (!$topic_completed) {
							// Found uncompleted topic
							if (isset($topic['topic_slug']) && function_exists('vested_academy_get_topic_url')) {
								return vested_academy_get_topic_url($chapter_id, $topic['topic_slug']);
							} else {
								$topic_url = get_permalink($chapter_id);
								$topic_url = remove_query_arg('topic', $topic_url);
								$topic_url = add_query_arg('topic', $idx, $topic_url);
								return $topic_url;
							}
						}
					}
					
					// All topics completed, check quiz
					$module_quizzes = vested_academy_get_quizzes_for_module($chapter_id);
					if (!empty($module_quizzes)) {
						$quiz_url = get_permalink($chapter_id);
						$quiz_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), $quiz_url);
						$quiz_url = add_query_arg('quiz', '1', $quiz_url) . '#quiz-content';
						return $quiz_url;
					}
				}
				
				// No topics or all completed, return chapter
				return get_permalink($chapter_id);
			}
		}
		wp_reset_postdata();
	}
	
	return null;
}

/**
 * Get next uncompleted item (chapter/topic/quiz) for a module
 * Returns URL to continue from where user left off
 * @deprecated For logged-in users, use vested_academy_get_resume_url() instead
 */
function vested_academy_get_continue_url($module_id, $user_id = null)
{
	if (!$module_id) {
		return null;
	}

	if (!$user_id) {
		$user_id = get_current_user_id();
	}

	// For logged-in users, use centralized resume function
	if ($user_id) {
		return vested_academy_get_resume_url($user_id, array(
			'module_id' => $module_id,
			'allow_next_incomplete' => true,
			'fallback_first' => true,
		));
	}
	
	// For non-logged users, check last visited (legacy support)
	$last_visited = vested_academy_get_last_visited($module_id);
	if ($last_visited && isset($last_visited['url'])) {
		return $last_visited['url'];
	}
	
	// Return first chapter if no last visited
	return vested_academy_get_first_chapter_url($module_id);
}

/**
 * Get first chapter URL for a module
 */
function vested_academy_get_first_chapter_url($module_id)
{
	if (!$module_id) {
		return home_url('/academy/');
	}

	// Determine if module_id is a post type or taxonomy term
	$module_post = get_post($module_id);
	$is_post_type = ($module_post && $module_post->post_type === 'academy_module');

	// Get first chapter
	if ($is_post_type) {
		// New structure: ACF relationship
		$chapters_query = new WP_Query(array(
			'post_type' => 'module',
			'meta_query' => array(
				array(
					'key' => 'academy_module',
					'value' => $module_id,
					'compare' => 'LIKE',
				),
			),
			'posts_per_page' => 1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		));
	} else {
		// Legacy: Taxonomy term
		$chapters_query = new WP_Query(array(
			'post_type' => 'module',
			'tax_query' => array(
				array(
					'taxonomy' => 'modules',
					'field' => 'term_id',
					'terms' => $module_id,
				),
			),
			'posts_per_page' => 1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		));
	}

	if ($chapters_query->have_posts()) {
		$chapters_query->the_post();
		$first_chapter_url = get_permalink();
		wp_reset_postdata();
		return $first_chapter_url;
	}

	return home_url('/academy/');
}

/**
 * Check if user has access to quiz (must be logged in)
 * Returns true/false instead of redirecting
 */
function vested_academy_check_quiz_access($quiz_id)
{
	return is_user_logged_in();
}

/**
 * Restrict quiz access to logged-in users only
 * Note: This is handled by vested_academy_restrict_access() now
 * Keeping for backward compatibility but it won't redirect since vested_academy_restrict_access runs first
 */
function vested_academy_restrict_quiz_access()
{
	// This is now handled by vested_academy_restrict_access()
	// Only quizzes require login, all other pages are public
}
// Removed action hook - handled by vested_academy_restrict_access() instead
// add_action( 'template_redirect', 'vested_academy_restrict_quiz_access' );

/**
 * Get chapter reading time
 */
function vested_academy_get_chapter_reading_time($chapter_id)
{
	$content = get_post_field('post_content', $chapter_id);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 250); // 250 words per minute
	return $reading_time;
}

/**
 * Check if Academy page
 */
function vested_academy_is_academy_page()
{
	if (is_singular('module')) {
		return true;
	}

	if (is_tax('modules')) {
		return true;
	}

	$page_template = get_page_template_slug();
	if (
		$page_template === 'templates/page-vested-academy.php' ||
		$page_template === 'templates/page-academy-home.php' ||
		$page_template === 'templates/page-academy-module.php' ||
		$page_template === 'templates/page-academy-login.php' ||
		$page_template === 'templates/page-academy-signup.php'
	) {
		return true;
	}

	if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/academy/') !== false) {
		return true;
	}

	return false;
}

/**
 * Get all completed topic indices for a chapter
 * Uses batch progress query + last visited topic as fallback
 */
function vested_academy_get_completed_topics_for_chapter($user_id, $chapter_id, $total_topics = 0)
{
	if (!$user_id || !$chapter_id) {
		return array();
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_progress';

	// Get all completed topics from database - ONLY check status='completed' (not progress >= 90)
	// Scroll tracking can set progress without setting status to 'completed'
	$completed_topics = $wpdb->get_col($wpdb->prepare(
		"SELECT topic_index 
		FROM $table_name 
		WHERE user_id = %d 
		AND chapter_id = %d 
		AND progress_type = 'topic' 
		AND status = 'completed'
		ORDER BY topic_index ASC",
		$user_id,
		$chapter_id
	));

	// Convert to integers
	$completed_indices = array_map('intval', $completed_topics);

	// Also check last visited topic - mark all topics before it as completed
	$last_visited = vested_academy_get_last_visited();
	if (
		$last_visited &&
		isset($last_visited['chapter_id']) &&
		intval($last_visited['chapter_id']) === $chapter_id &&
		isset($last_visited['topic_index']) &&
		$last_visited['topic_index'] !== null
	) {

		$last_visited_index = intval($last_visited['topic_index']);

		// Mark all topics before the last visited as completed
		for ($i = 0; $i < $last_visited_index; $i++) {
			if (!in_array($i, $completed_indices, true)) {
				$completed_indices[] = $i;
			}
		}
	}

	// Sort and return unique indices
	$completed_indices = array_unique($completed_indices);
	sort($completed_indices);

	return $completed_indices;
}

/**
 * AJAX handler for getting topic completion state for a chapter
 */
function vested_academy_ajax_get_topic_completion()
{
	check_ajax_referer('academy_progress_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$chapter_id = isset($_POST['chapter_id']) ? intval($_POST['chapter_id']) : 0;

	if (!$chapter_id) {
		wp_send_json_error(array('message' => 'Invalid chapter ID'));
	}

	// Get total topics count
	$topics = get_field('chapter_topics', $chapter_id);
	$total_topics = is_array($topics) ? count($topics) : 0;

	// Get completed topics
	$completed_indices = vested_academy_get_completed_topics_for_chapter($user_id, $chapter_id, $total_topics);

	wp_send_json_success(array(
		'completed_topics' => $completed_indices,
		'chapter_id' => $chapter_id
	));
}
add_action('wp_ajax_academy_get_topic_completion', 'vested_academy_ajax_get_topic_completion');

/**
 * AJAX handler for updating chapter progress
 */
function vested_academy_ajax_update_progress()
{
	check_ajax_referer('academy_progress_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$chapter_id = isset($_POST['chapter_id']) ? intval($_POST['chapter_id']) : 0;
	$module_id = isset($_POST['module_id']) ? intval($_POST['module_id']) : null;
	$progress = isset($_POST['progress']) ? intval($_POST['progress']) : 0;
	$topic_index = isset($_POST['topic_index']) ? intval($_POST['topic_index']) : null;

	if (!$chapter_id) {
		wp_send_json_error(array('message' => 'Invalid chapter ID'));
	}

	// Track topic progress if topic_index is provided, otherwise track chapter progress
	if ($topic_index !== null) {
		// If progress is exactly 100, this is explicit completion from Next/Quiz buttons - force complete
		// Scroll tracking sends progress < 100, so it won't trigger completion
		$force_complete = ($progress == 100);
		vested_academy_track_topic_progress($user_id, $chapter_id, $topic_index, $module_id, $progress, $force_complete);
	} else {
		vested_academy_track_chapter_progress($user_id, $chapter_id, $module_id, $progress);
	}

	wp_send_json_success(array('message' => 'Progress updated', 'progress' => $progress));
}
add_action('wp_ajax_academy_update_progress', 'vested_academy_ajax_update_progress');

/**
 * Save individual quiz question answer
 */
function vested_academy_save_quiz_answer($user_id, $quiz_id, $question_index, $user_answer, $correct_answer = null)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_quiz_answers';

	// Get correct answer if not provided
	if ($correct_answer === null) {
		$questions = get_field('quiz_questions', $quiz_id);
		if (isset($questions[$question_index]['correct_answer'])) {
			$correct_answer = $questions[$question_index]['correct_answer'];
		}
	}

	$is_correct = ($user_answer === $correct_answer) ? 1 : 0;

	// Check if answer already exists
	$existing = $wpdb->get_row($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND question_index = %d",
		$user_id,
		$quiz_id,
		$question_index
	));

	if ($existing) {
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
			array('%s', '%s', '%d'),
			array('%d', '%d', '%d')
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
			array('%d', '%d', '%d', '%s', '%s', '%d')
		);
	}

	return $is_correct;
}

/**
 * Get user's saved answers for a quiz
 */
function vested_academy_get_user_quiz_answers($user_id, $quiz_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'academy_quiz_answers';

	$answers = $wpdb->get_results($wpdb->prepare(
		"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d ORDER BY question_index ASC",
		$user_id,
		$quiz_id
	), ARRAY_A);

	$answers_array = array();
	foreach ($answers as $answer) {
		$answers_array[$answer['question_index']] = $answer['user_answer'];
	}

	return $answers_array;
}

/**
 * AJAX handler for saving individual quiz answer
 */
function vested_academy_ajax_save_quiz_answer()
{
	check_ajax_referer('academy_quiz_answer_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
	$question_index = isset($_POST['question_index']) ? intval($_POST['question_index']) : 0;
	$user_answer = isset($_POST['user_answer']) ? sanitize_text_field($_POST['user_answer']) : '';

	if (!$quiz_id || $user_answer === '') {
		wp_send_json_error(array('message' => 'Invalid data'));
	}

	vested_academy_save_quiz_answer($user_id, $quiz_id, $question_index, $user_answer);

	wp_send_json_success(array('message' => 'Answer saved'));
}
add_action('wp_ajax_academy_save_quiz_answer', 'vested_academy_ajax_save_quiz_answer');

/**
 * AJAX handler for loading quiz question HTML
 */
function vested_academy_ajax_load_quiz_question()
{
	check_ajax_referer('academy_quiz_answer_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;
	$chapter_id = isset($_POST['chapter_id']) ? intval($_POST['chapter_id']) : 0;
	$question_index = isset($_POST['question_index']) ? intval($_POST['question_index']) : 0;

	if (!$quiz_id || !$chapter_id) {
		wp_send_json_error(array('message' => 'Invalid data'));
	}

	// Get quiz data
	$module_quizzes = vested_academy_get_quizzes_for_module($chapter_id);
	if (empty($module_quizzes)) {
		wp_send_json_error(array('message' => 'Quiz not found'));
	}

	$quiz_post = $module_quizzes[0];
	$quiz_questions = isset($quiz_post['questions']) ? $quiz_post['questions'] : array();

	if (empty($quiz_questions)) {
		$quiz_questions = get_field('quiz_questions', $quiz_post['id']);
		if (!$quiz_questions) {
			$quiz_questions = array();
		}
	}

	$total_questions = count($quiz_questions);

	// Validate question index
	if ($question_index < 0 || $question_index >= $total_questions) {
		wp_send_json_error(array('message' => 'Invalid question index'));
	}

	// Get saved answers
	$saved_answers = vested_academy_get_user_quiz_answers($user_id, $quiz_id);

	// Get current question
	$current_q = $quiz_questions[$question_index];
	$question_text = isset($current_q['question']) ? $current_q['question'] : '';
	$options = isset($current_q['options']) ? $current_q['options'] : array();
	$saved_answer = isset($saved_answers[$question_index]) ? $saved_answers[$question_index] : '';

	// Build navigation URLs
	$base_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), get_permalink($chapter_id));
	$prev_q = max(0, $question_index - 1);
	$next_q = min($total_questions - 1, $question_index + 1);
	$prev_url = add_query_arg(array('quiz' => '1', 'q' => $prev_q), $base_url) . '#quiz-content';
	$next_url = add_query_arg(array('quiz' => '1', 'q' => $next_q), $base_url) . '#quiz-content';

	// Generate HTML
	ob_start();
	?>
	<div class="quiz-question-wrapper" data-question-index="<?php echo esc_attr($question_index); ?>">
		<div class="quiz-question-header">
			<h2 class="quiz-title">Quiz <?php echo esc_html($question_index + 1); ?></h2>
		</div>

		<div class="quiz-question-content">
			<h3 class="question-text"><?php echo esc_html($question_text); ?></h3>
			<p class="question-instruction">Choose only 1 answer</p>

			<div class="question-options">
				<?php
				if (!empty($options)) {
					foreach ($options as $option_idx => $option):
						$option_value = is_array($option) ? (isset($option['value']) ? $option['value'] : $option_idx) : $option;
						$option_label = is_array($option) ? (isset($option['label']) ? $option['label'] : $option_value) : $option;
						$is_selected = ($saved_answer === $option_value);
						?>
						<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>"
							data-option-value="<?php echo esc_attr($option_value); ?>">
							<input type="radio" name="question_<?php echo esc_attr($question_index); ?>"
								value="<?php echo esc_attr($option_value); ?>" <?php echo $is_selected ? 'checked' : ''; ?>>
							<span class="radio-custom"></span>
							<span class="option-text"><?php echo esc_html($option_label); ?></span>
						</label>
						<?php
					endforeach;
				}
				?>
			</div>
		</div>

		<div class="quiz-navigation">
			<div class="quiz-progress">
				<span
					class="progress-text"><?php echo esc_html($question_index + 1); ?>/<?php echo esc_html($total_questions); ?></span>
				<div class="progress-bar">
					<div class="progress-fill"
						style="width: <?php echo esc_attr((($question_index + 1) / $total_questions) * 100); ?>%">
					</div>
				</div>
			</div>

			<div class="quiz-buttons">
				<?php if ($question_index > 0): ?>
					<a href="<?php echo esc_url($prev_url); ?>" class="quiz-btn quiz-prev-btn"
						data-question-index="<?php echo esc_attr($prev_q); ?>">Previous</a>
				<?php endif; ?>

				<?php if ($question_index < $total_questions - 1): ?>
					<a href="<?php echo esc_url($next_url); ?>" class="quiz-btn quiz-next-btn"
						data-question-index="<?php echo esc_attr($next_q); ?>">Next</a>
				<?php else: ?>
					<button type="button" class="quiz-btn quiz-submit-btn" id="quiz-final-submit">Submit Quiz</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	wp_send_json_success(array(
		'html' => $html,
		'question_index' => $question_index,
		'total_questions' => $total_questions,
		'prev_url' => $prev_url,
		'next_url' => $next_url
	));
}
add_action('wp_ajax_academy_load_quiz_question', 'vested_academy_ajax_load_quiz_question');

/**
 * AJAX handler for getting quiz result
 */
function vested_academy_ajax_get_quiz_result()
{
	check_ajax_referer('academy_quiz_answer_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;

	if (!$quiz_id) {
		wp_send_json_error(array('message' => 'Invalid quiz ID'));
	}

	$result = vested_academy_get_quiz_result($user_id, $quiz_id);

	if ($result) {
		wp_send_json_success(array(
			'completed' => true,
			'score' => intval($result->quiz_score),
			'percentage' => intval($result->progress_percentage),
			'status' => $result->status,
			'attempts' => intval($result->quiz_attempts),
			'completed_at' => $result->completed_at,
		));
	} else {
		wp_send_json_success(array(
			'completed' => false,
		));
	}
}
add_action('wp_ajax_academy_get_quiz_result', 'vested_academy_ajax_get_quiz_result');

/**
 * AJAX handler for retaking quiz
 */
function vested_academy_ajax_retake_quiz()
{
	check_ajax_referer('academy_quiz_answer_nonce', 'nonce');

	if (!is_user_logged_in()) {
		wp_send_json_error(array('message' => 'User not logged in'));
	}

	$user_id = get_current_user_id();
	$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;

	if (!$quiz_id) {
		wp_send_json_error(array('message' => 'Invalid quiz ID'));
	}

	$success = vested_academy_reset_quiz_attempt($user_id, $quiz_id);

	if ($success) {
		wp_send_json_success(array('message' => 'Quiz reset successfully'));
	} else {
		wp_send_json_error(array('message' => 'Failed to reset quiz'));
	}
}
add_action('wp_ajax_academy_retake_quiz', 'vested_academy_ajax_retake_quiz');

/**
 * Register Academy User Role
 */
function vested_academy_register_user_role()
{
	add_role(
		'academy_user',
		__('Academy User', 'vested-finance-wp'),
		array(
			'read' => true, // Can read posts
		)
	);
}
add_action('init', 'vested_academy_register_user_role');

/**
 * Prevent WordPress from redirecting Academy pages to login
 * All Academy pages should be accessible without login
 */
function vested_academy_prevent_login_redirect($redirect_to, $requested_redirect_to, $user)
{
	// If login came from Academy login page and there's an error, redirect back to Academy login
	if (isset($_POST['academy_login']) && $_POST['academy_login'] === '1') {
		if (is_wp_error($user)) {
			$error_code = $user->get_error_code();

			if ($error_code === 'email_not_verified') {
				// Get user email if available
				$username = isset($_POST['log']) ? sanitize_text_field($_POST['log']) : '';
				$user_obj = get_user_by('login', $username);
				if (!$user_obj) {
					$user_obj = get_user_by('email', $username);
				}
				$email = $user_obj ? $user_obj->user_email : '';

				// Redirect back to Academy login page with error
				$redirect_url = add_query_arg(array(
					'login' => 'email_not_verified',
					'email' => urlencode($email),
				), home_url('/academy/login'));
				return $redirect_url;
			} elseif ($error_code === 'invalid_role') {
				// Redirect back to Academy login page with error
				return home_url('/academy/login?login=invalid_role');
			} elseif (in_array($error_code, array('incorrect_password', 'empty_password', 'empty_username'))) {
				// Redirect back to Academy login page with error
				return home_url('/academy/login?login=failed');
			}
		}
	}

	// If user is trying to access an Academy page, don't redirect to login
	if (isset($_SERVER['REQUEST_URI'])) {
		$request_uri = $_SERVER['REQUEST_URI'];
		// Check if it's an Academy page (but not login/signup)
		if (
			strpos($request_uri, '/academy/') !== false &&
			strpos($request_uri, '/academy/login') === false &&
			strpos($request_uri, '/academy/signup') === false
		) {
			// Return the original URL instead of login page
			return $requested_redirect_to ? $requested_redirect_to : home_url($request_uri);
		}
	}

	// For Academy users, redirect to academy page after successful login
	if ($user && is_a($user, 'WP_User') && !is_wp_error($user)) {
		$user_roles = $user->roles;
		if (in_array('academy_user', $user_roles) || in_array('administrator', $user_roles)) {
			// Use centralized resume function for logged-in users
			// Priority: redirect_to > resume_state > default
			$resume_url = null;
			
			// Check for explicit redirect_to (highest priority)
			if (!empty($requested_redirect_to) && strpos($requested_redirect_to, '/academy/') !== false) {
				$resume_url = vested_academy_get_resume_url($user->ID, array(
					'redirect_to' => $requested_redirect_to,
					'allow_next_incomplete' => false,
					'fallback_first' => false,
				));
			}
			
			// If no explicit redirect, use resume state
			if (!$resume_url) {
				// Try to get module_id from session/cookie (if user was browsing before login)
				$module_id = null;
				if (!session_id() && !headers_sent()) {
					session_start();
				}
				if (isset($_SESSION['academy_last_visited']) && is_array($_SESSION['academy_last_visited']) && isset($_SESSION['academy_last_visited']['module_id'])) {
					$module_id = intval($_SESSION['academy_last_visited']['module_id']);
					// Transfer to resume state (convert old format to new)
					if (isset($_SESSION['academy_last_visited']['chapter_id'])) {
						vested_academy_track_resume_state(
							intval($_SESSION['academy_last_visited']['chapter_id']),
							$module_id,
							isset($_SESSION['academy_last_visited']['topic_index']) ? intval($_SESSION['academy_last_visited']['topic_index']) : null,
							isset($_SESSION['academy_last_visited']['topic_slug']) ? $_SESSION['academy_last_visited']['topic_slug'] : null,
							isset($_SESSION['academy_last_visited']['is_quiz']) && $_SESSION['academy_last_visited']['is_quiz'] == 1
						);
						unset($_SESSION['academy_last_visited']);
					}
				} elseif (isset($_COOKIE['academy_last_visited'])) {
					$last_visited = json_decode(stripslashes($_COOKIE['academy_last_visited']), true);
					if ($last_visited && is_array($last_visited) && isset($last_visited['module_id'])) {
						$module_id = intval($last_visited['module_id']);
						// Transfer to resume state
						if (isset($last_visited['chapter_id'])) {
							vested_academy_track_resume_state(
								intval($last_visited['chapter_id']),
								$module_id,
								isset($last_visited['topic_index']) ? intval($last_visited['topic_index']) : null,
								isset($last_visited['topic_slug']) ? $last_visited['topic_slug'] : null,
								isset($last_visited['is_quiz']) && $last_visited['is_quiz'] == 1
							);
						}
					}
				}
				
				// Get resume URL using centralized function
				$resume_url = vested_academy_get_resume_url($user->ID, array(
					'module_id' => $module_id,
					'allow_next_incomplete' => true,
					'fallback_first' => true,
				));
			}
			
			// Use resume URL if found, otherwise default to academy home
			if ($resume_url) {
				return esc_url_raw($resume_url);
			}
			
			// Default to academy home
			return home_url('/academy/');
		}
	}

	return $redirect_to;
}
add_filter('login_redirect', 'vested_academy_prevent_login_redirect', 10, 3);

/**
 * Track last visited page for non-logged users on academy pages
 * This runs early to capture the page before any redirects
 * ROOT-LEVEL: Tracks ALL academy pages (not just chapters) to enable redirect_to flow
 */
function vested_academy_track_page_visit()
{
	if (!is_user_logged_in() && vested_academy_is_academy_page()) {
		// Track all academy pages except login/signup
		$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

		if (
			strpos($request_uri, '/academy/login') === false &&
			strpos($request_uri, '/academy/signup') === false &&
			strpos($request_uri, '/academy/') !== false
		) {
			$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			// Check if it's a chapter page (module post type) - use detailed tracking
			if (is_singular('module')) {
				$chapter_id = get_the_ID();
				$module_id = null;

				// Get module ID
				$terms = get_the_terms($chapter_id, 'modules');
				if ($terms && !is_wp_error($terms) && !empty($terms)) {
					$module_id = $terms[0]->term_id;
				} else {
					$related_modules = get_field('academy_module', $chapter_id);
					if ($related_modules) {
						if (is_array($related_modules)) {
							$module_post = is_object($related_modules[0]) ? $related_modules[0] : get_post($related_modules[0]);
						} elseif (is_object($related_modules)) {
							$module_post = $related_modules;
						} elseif (is_numeric($related_modules)) {
							$module_post = get_post($related_modules);
						}
						if ($module_post) {
							$module_id = $module_post->ID;
						}
					}
				}

				if ($chapter_id) {
					global $wp_query;
					$is_quiz = isset($_GET['quiz']) && $_GET['quiz'] == '1';
					$topic_slug = isset($wp_query->query_vars['topic_slug']) ? $wp_query->query_vars['topic_slug'] : null;
					$topic_index = isset($_GET['topic']) ? intval($_GET['topic']) : null;

					vested_academy_track_last_visited($chapter_id, $module_id, $topic_index, $topic_slug, $is_quiz);
				}
			} else {
				// For all other academy pages (home, module pages, etc.), store just the URL
				// This enables redirect_to flow for any academy page
				if (!session_id() && !headers_sent()) {
					session_start();
				}
				
				// Store URL in session and cookie for guest users
				$last_visited = array(
					'url' => esc_url_raw($current_url),
					'timestamp' => current_time('mysql'),
				);
				
				$_SESSION['academy_last_visited'] = $last_visited;
				setcookie('academy_last_visited', json_encode($last_visited), time() + (86400 * 30), '/');
			}
		}
	}
}
add_action('template_redirect', 'vested_academy_track_page_visit', 5);

/**
 * Prevent auth_redirect on Academy pages
 * This stops WordPress from redirecting to login
 */
function vested_academy_prevent_auth_redirect()
{
	if (vested_academy_is_academy_page()) {
		// Don't redirect Academy pages to login
		// Remove WordPress default redirect actions
		remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
		// Prevent any auth redirects - allow page to load normally
		return;
	}
}
add_action('template_redirect', 'vested_academy_prevent_auth_redirect', 1);

/**
 * Override WordPress login requirement for Academy pages
 * Prevents WordPress from requiring login on Academy pages
 */
function vested_academy_override_login_requirement()
{
	if (vested_academy_is_academy_page()) {
		// Check if it's a page (not post type)
		if (is_page()) {
			$page_id = get_the_ID();
			$page_template = get_page_template_slug($page_id);

			// Allow these Academy pages without login
			$public_academy_templates = array(
				'templates/page-vested-academy.php',
				'templates/page-academy-home.php',
				'templates/page-academy-module.php',
				'templates/page-academy-login.php',
				'templates/page-academy-signup.php',
			);

			if (in_array($page_template, $public_academy_templates)) {
				// Force page to be public - prevent any login requirements
				add_filter('post_password_required', '__return_false', 999);
				return;
			}
		}

		// For module posts and taxonomy pages - always public
		if (is_singular('module') || is_tax('modules')) {
			add_filter('post_password_required', '__return_false', 999);
			return;
		}
	}
}
add_action('wp', 'vested_academy_override_login_requirement', 1);

/**
 * Prevent redirects on Academy pages
 * Hook into template_redirect to ensure no redirects happen
 */
function vested_academy_prevent_redirects()
{
	// Only on Academy pages
	if (!vested_academy_is_academy_page()) {
		return;
	}

	// Don't remove actions if we're processing email verification
	if (isset($_GET['action']) && $_GET['action'] === 'verify_email') {
		return;
	}

	// Remove any redirect filters that might be active
	remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
	// Prevent MemberPress or other plugins from redirecting
	remove_all_actions('template_redirect');
	// Re-add our prevent function
	add_action('template_redirect', 'vested_academy_prevent_auth_redirect', 1);
}
add_action('template_redirect', 'vested_academy_prevent_redirects', 1);

/**
 * Force Academy pages to be public - prevent any login redirects
 * This runs very early to catch all redirect attempts
 */
function vested_academy_force_public_access()
{
	if (!isset($_SERVER['REQUEST_URI'])) {
		return;
	}

	$request_uri = $_SERVER['REQUEST_URI'];

	// Check if it's an Academy page (but not login/signup/quiz)
	if (
		strpos($request_uri, '/academy/') !== false &&
		strpos($request_uri, '/academy/login') === false &&
		strpos($request_uri, '/academy/signup') === false &&
		strpos($request_uri, '/academy/quiz/') === false
	) {

		// Prevent any redirects to login
		add_filter('auth_redirect', '__return_false', 999);
		add_filter('wp_redirect', 'vested_academy_prevent_login_redirects', 999, 2);

		// Prevent MemberPress or other membership plugins from locking pages
		if (class_exists('MeprRule')) {
			add_filter('mepr_is_uri_locked', '__return_false', 999);
		}
	}
}
add_action('init', 'vested_academy_force_public_access', 1);

/**
 * Prevent redirects to login page for Academy pages
 */
function vested_academy_prevent_login_redirects($location, $status)
{
	if (strpos($location, 'wp-login.php') !== false) {
		// If trying to redirect to login, check if it's an Academy page
		if (isset($_SERVER['REQUEST_URI'])) {
			$request_uri = $_SERVER['REQUEST_URI'];
			if (
				strpos($request_uri, '/academy/') !== false &&
				strpos($request_uri, '/academy/login') === false &&
				strpos($request_uri, '/academy/signup') === false &&
				strpos($request_uri, '/academy/quiz/') === false
			) {
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
function vested_academy_restrict_access()
{
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
function vested_academy_is_localhost()
{
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
	$localhost_patterns = array('localhost', '127.0.0.1', '::1', '.local', '.test', '.dev');

	foreach ($localhost_patterns as $pattern) {
		if (strpos($host, $pattern) !== false) {
			return true;
		}
	}

	// Also check if WP_DEBUG is enabled (common in development)
	if (defined('WP_DEBUG') && WP_DEBUG) {
		return true;
	}

	return false;
}

/**
 * Check if user email is verified
 * Administrators are always considered verified
 * Email verification is required for all Academy Users
 */
function vested_academy_is_email_verified($user_id)
{
	$user = get_userdata($user_id);
	if (!$user) {
		return false;
	}

	// Administrators are always verified
	if (in_array('administrator', $user->roles)) {
		return true;
	}

	// Clear cache to ensure we get fresh data
	wp_cache_delete($user_id, 'user_meta');

	// Check verification status - get_user_meta returns empty string if not found
	$is_verified = get_user_meta($user_id, 'academy_email_verified', true);

	// Handle different possible values
	// '1' or 1 means verified
	if ($is_verified === '1' || $is_verified === 1 || $is_verified === true) {
		return true;
	}

	// '0', 0, false, or empty string means not verified
	// If meta doesn't exist (empty string), check if user was created before verification was implemented
	// For backward compatibility, mark existing users as verified
	if ($is_verified === '') {
		// User was created before email verification was implemented
		// Mark as verified for backward compatibility
		update_user_meta($user_id, 'academy_email_verified', '1');
		wp_cache_delete($user_id, 'user_meta');
		return true;
	}

	// Explicitly not verified ('0', 0, false)
	return false;
}

/**
 * Send email verification email
 */
// Deprecated: old link-based verification helper (kept for reference)
function vested_academy_send_verification_email($user_email, $user_login, $verification_token)
{
}

/**
 * Handle email verification
 */
// Deprecated link-based verification handler (replaced by OTP flow)
function vested_academy_handle_email_verification()
{
}

/**
 * Get Academy email sender email address
 * Can be configured via ACF option 'academy_email_sender' or filter
 */
function vested_academy_get_sender_email()
{
	// Check ACF option first
	if (function_exists('get_field')) {
		$sender_email = get_field('academy_email_sender', 'option');
		if (!empty($sender_email)) {
			return sanitize_email($sender_email);
		}
	}
	
	// Allow filter override
	$sender_email = apply_filters('vested_academy_sender_email', 'akash.gupta@vestedfinance.co');
	
	return sanitize_email($sender_email);
}

/**
 * Get Academy email sender name
 * Can be configured via ACF option 'academy_email_sender_name' or filter
 */
function vested_academy_get_sender_name()
{
	// Check ACF option first
	if (function_exists('get_field')) {
		$sender_name = get_field('academy_email_sender_name', 'option');
		if (!empty($sender_name)) {
			return sanitize_text_field($sender_name);
		}
	}
	
	// Allow filter override
	$sender_name = apply_filters('vested_academy_sender_name', 'Vested Academy');
	
	return sanitize_text_field($sender_name);
}

/**
 * Generate HTML email template for Academy OTP verification
 * Uses exact template structure with only user name and OTP code as dynamic values
 */
function vested_academy_get_otp_email_template($otp_code, $user_name = 'Investor')
{
	$sender_name = vested_academy_get_sender_name();
	$home_url = home_url();
	
	// Clean up user name - use provided name or default to 'Investor'
	$display_name = !empty($user_name) && $user_name !== 'Investor' ? esc_html($user_name) : 'Investor';
	
	// Get header image URL - can be configured via ACF
	$header_image_url = 'https://vestedfinance.com/wp-content/uploads/2024/04/Header.png';
	if (function_exists('get_field')) {
		$custom_header = get_field('academy_email_header_image', 'option');
		if (!empty($custom_header) && isset($custom_header['url'])) {
			$header_image_url = $custom_header['url'];
		}
	}
	
	$html = '<!DOCTYPE html>
<head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <!--[if gte mso 9]>
<xml>
 <o:OfficeDocumentSettings>
  <o:AllowPNG/>
  <o:PixelsPerInch>96</o:PixelsPerInch>
 </o:OfficeDocumentSettings>
</xml>
<![endif]-->
    <title>Vested Finance</title>
    <meta name="viewport" content="initial-scale=1.0,width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
    <meta name="referrer" content="no-referrer" />
    <style type="text/css">
        span.MsoHyperlink {
            mso-style-priority: 99;
            color: inherit;
        }

        span.MsoHyperlinkFollowed {
            mso-style-priority: 99;
            color: inherit;
        }

        a[href^=tel] {
            color: inherit;
            text-decoration: none;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        #MessageViewBody a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit;
        }

        #outlook a {
            padding: 0;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
        }

        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        p {
            margin: 1em 0;
        }

        table td {
            border-collapse: collapse;
        }

        table th {
            margin: 0 !important;
            padding: 0 !important;
            vertical-align: top;
            font-weight: normal;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        #backgroundTable {
            margin: 0;
            padding: 0;
            width: 100% !important;
            line-height: 100% !important;
        }

        [owa] .foo {
            background: none !important;
        }

        td a {
            color: inherit;
            text-decoration: underline;
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 1024px) {

            a[href^="tel"],
            a[href^="sms"],
            a {
                color: inherit;
                cursor: default;
                text-decoration: none;
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            body {
                min-width: 100% !important;
            }
        }

        @media only screen and (max-width:480px),
        (max-device-width:480px) {
            .h {
                display: none !important;
            }

            .wFull {
                width: 320px !important;
                height: auto !important;
                max-width: 100% !important;
            }

            .noBG {
                background: none !important;
            }

            .mob-img {
                width: 100% !important;
                max-width: 100% !important;
            }

            .mob-img92 {
                width: 92% !important;
                max-width: 100% !important;
            }

            .mob-img35 {
                width: 35% !important;
                max-width: 100% !important;
            }

            .mob-img25 {
                width: 25% !important;
                max-width: 100% !important;
            }

            .mob-img-90 {
                width: 90% !important;
                max-width: 100% !important;
            }

            .mob-img-70 {
                width: 70% !important;
                max-width: 100% !important;
            }

            .mob-img-85 {
                width: 85% !important;
                max-width: 100% !important;
            }

            .mob-img-60 {
                width: 60% !important;
                max-width: 100% !important;
            }

            .mob-img65 {
                width: 65% !important;
                max-width: 100% !important;
            }

            .mob-logo {
                width: 185px !important;
                height: 88px !important;
            }

            .mob-f9 {
                font-size: 9px !important;
            }

            .mob-f10 {
                font-size: 10px !important;
            }

            .mob-f13 {
                font-size: 13px !important;
            }

            .mob-f22 {
                font-size: 22px !important;
            }

            .mob-pl2 {
                padding-left: 2px !important;
            }

            .mob-pl4 {
                padding: 0 4px !important;
            }

            .mob-pr40 {
                padding: 0 40px 0 0 !important;
            }

            .mob-flr2 {
                padding: 0 0px !important;
            }

            .mob-width12 {
                width: 12px !important;
            }

            .mob-img-h30 {
                height: 30px !important;
            }

            .mob-lborder1 {
                border-left: 1px solid #ffffff !important;
            }

            .font-size12 {
                font-size: 12px !important;
            }

            @media only screen and (max-width: 950px) {
                .cf7_custom_style_1 {
                    padding-left: 10%;
                    padding-right: 10%;
                }
            }

            @media only screen and (max-width: 600px) {
                .cf7_custom_style_1 {
                    padding-left: 0;
                    padding-right: 0;
                }
            }

            .my-left-padding {
                padding-left: 0px !important;
            }

            @media (max-width:600px) {
                .my-left-padding {
                    padding-left: 10px !important;
                }
            }
        }
    </style>
</head>


<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#ffffff" style="background-color:#f9f9f9;">

    <!-- End of DoubleClick Floodlight Tag: Please do not remove -->
    <!-- framework start -->
    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0"
        style="table-layout: fixed; margin: 0 auto; max-width: 600px;" bgcolor="#ffffff">
        <tbody>
            <!--Header Starts-->
            <tr>
                <td width="100%" align="left" valign="middle" style="background-color: #ffffff;"><a
                        href="https://vestedfinance.com/in"
                        target="_blank"><img class="mob-img" align="center" alt="" src="' . esc_url($header_image_url) . '" width="600" style="padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;"></a>
                </td>
            </tr>

            <!--Header Ends-->
            <!--Body Starts-->

            <tr>
                <td align="left"
                    style="font-family: sans-serif; font-size:15px; color:#000000; line-height:1.5;padding: 30px 20px 0px 20px"
                    valign="middle">Hi ' . $display_name . ',
                    <br><br>
                    We received a request to verify your email address for Vested Academy. For your security, please use the verification code below to confirm your email address.<br>
                    <br>
                    ' . esc_html($otp_code) . '
                    <br><br>
                    This code is valid for 10 minutes. If you did not request this verification, please ignore this email.
                    <br><br>
                    Thank you for helping us keep your account secure.
                    <br>
                </td>
            </tr>
            <tr>
                <td align="left"
                    style="font-family: sans-serif; font-size:15px; color:#000000; line-height:1.5;padding: 25px 20px 0px 20px"
                    valign="middle">
                    Regards, <br>
                    ' . esc_html($sender_name) . ' <br>
                </td>
            </tr>
            <tr>
                <td width="100%">
                    <table align="center" width="96%" style="padding: 25px 0 0px 0;">
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" style="padding: 0px 20px 0px 20px;">
                    <table align="center">
                        <tr>
                            <td valign="top" width="550px" align="top"
                                style="border-top: solid 2px #F1F1F1;vertical-align: top"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" style="padding: 5px 20px 20px 20px;">
                    <table class="mob-f9" width="100%" align="center"
                        style="color: #002957; font-family: arial; font-size: 11px;">
                        <tr>
                            <td align="center"
                                style="font-family: sans-serif; font-size:15px; color:#000000; line-height:1.5;letter-spacing: 1px;"
                                valign="middle">Download the Vested App</td>
                        </tr>
                        <tr>
                            <td align="center" style="width:auto; padding-right: 0px;" valign="top"><a
                                    href="https://apps.apple.com/us/app/vested-us-stocks-investing/id1478145933?ls=1"
                                    style="display:inline-block;"
                                    target="_blank"><img class="mob-img-h30" alt="" src="https://vestedfinance.com/wp-content/uploads/2024/04/App-Store.png" style="vertical-align:middle;padding:0px 1px 0px 0px; height: 30px" /></a>&nbsp;&nbsp;
                                <a href="https://play.google.com/store/apps/details?id=com.vested.investing.android&hl=en&gl=US"
                                    style="display:inline-block;"
                                    target="_blank"><img class="mob-img-h30" alt="" src="https://vestedfinance.com/wp-content/uploads/2024/04/Google-Play.png" style="vertical-align:middle;padding:0px 1px 0px 0; height: 30px" /></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" style="padding: 0px 20px 0px 20px;">
                    <table align="center">
                        <tr>
                            <td valign="top" width="550px" align="top"
                                style="border-top: solid 2px #F1F1F1;vertical-align: top"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="100%" align="center"
                    style="font-family: sans-serif; font-size:13px; color:#000000;padding: 20px 20px 0px 20px"
                    valign="middle">
                    <table width="100%"
                        style="padding: 15px 0px 20px 40px;background-color: #F3F4F6;border-radius: 5px;">
                        <tr>
                            <td class="my-left-padding" align="left" width="100%"
                                style="font-size:18px; font-weight: bold;letter-spacing: 0px;color: #000000;line-height:1.5;padding: 5px 0px 0px 40px;">
                                Need Support?</td>
                        </tr>
                        <tr>
                            <td class="my-left-padding" align="left" width="100%"
                                style="font-size:15px; font-weight: normal;letter-spacing: 0px;color: #595959;line-height:1.5;padding: 10px 5px 0px 40px;">
                                Find answers on our support portal or reach out to us directly</td>
                        </tr>
                        <td width="100%" align="center"
                            style="font-family: sans-serif; font-size:13px; color:#000000;padding: 10px 0px 0px 0px"
                            valign="middle">
                            <table align="left">
                                <tr>
                                    <td class="my-left-padding" align="left" "><img alt="" src="https://vestedfinance.com/wp-content/uploads/2024/07/center_13654111-1.png" style="vertical-align:middle;padding:0px 0px 3px 0px; width: 16px;" />
                                        <a class="font-size12" href="https://support.vestedfinance.com/portal/en/home"
                                            target="_blank"
                                            style="text-decoration: underline; color: #4B7BEC;font-weight: bold;font-size:13px;">Support
                                            Portal</a>
                                    </td>
                                    <td class="my-left-padding" align="left" style="padding-left: 5px;"><img alt="" src="https://vestedfinance.com/wp-content/uploads/2024/07/chat-oval-speech-bubbles-symbol_55009-1.png" style="vertical-align:middle;padding:0px 0px 3px 0px; width: 16px;" />
                                        <a class="font-size12" href="https://vested.app.link/home" target="_blank"
                                            style="text-decoration: underline; color: #4B7BEC;font-weight: bold;font-size:13px;">In
                                            app chat</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="my-left-padding" align="left"
                                        style="padding-top: 10px;"><img alt="" src="https://vestedfinance.com/wp-content/uploads/2024/07/mail.png" style="vertical-align:middle;padding:0px 0px 3px 0px; width: 15px;" />
                                        <a class="font-size12" href="mailto:help@vestedfinance.co" target="_blank"
                                            style="text-decoration: underline; color: #4B7BEC;font-weight: bold;font-size:13px;">help@vestedfinance.co</a>
                                    </td>
                                    <td class="my-left-padding" align="left"
                                        style="padding-top: 10px;padding-left: 5px;"><img alt="" src="https://vestedfinance.com/wp-content/uploads/2024/07/phone-call.png" style="vertical-align:middle;padding:0px 0px 3px 0px; width: 15px;" />
                                        <a class="font-size12" href="tel:+919513375607" target="_blank"
                                            style="text-decoration: underline; color: #4B7BEC;font-weight: bold;font-size:13px;">+91
                                            9513375607</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- framework end --><!--android gmail zoom fix-->
    <!--/android gmail zoom fix--><!-- android yahoo fix-->
    <table class="h" cellSpacing="0" cellPadding="0" width="100%" border="0">
        <tbody>
            <tr>
                <td align="center" style="FONT-SIZE: 1px; LINE-HEIGHT: 1px" height="1">
                    <unsubscribe><!--[if !mso 9]><!--><img
      style="DISPLAY: block;" border="0" src="https://mcusercontent.com/4be6dced2f8f027c9d1b68acc/images/3fd93179-53a2-84dc-8349-f3e994749ed3.png" alt="" width="600"
      height="1"><!--<![endif]--></unsubscribe>
                </td>
            </tr>
        </tbody>
    </table>
    <!--/android yahoo fix-->
</body>

</html>';
	
	return $html;
}

/**
 * Send Academy OTP verification email
 */
function vested_academy_send_otp_email($user_email, $otp_code, $user_name = '')
{
	$subject = 'Your Academy Email Verification Code';
	$message = vested_academy_get_otp_email_template($otp_code, $user_name);
	
	$sender_name = vested_academy_get_sender_name();
	$sender_email = vested_academy_get_sender_email();
	
	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . $sender_name . ' <' . $sender_email . '>',
		'Reply-To: ' . $sender_email
	);
	
	wp_mail($user_email, $subject, $message, $headers);
}

/**
 * Resend verification email
 */
function vested_academy_resend_verification_email()
{
	// Verify nonce
	if (!isset($_POST['resend_verification_nonce']) || !wp_verify_nonce($_POST['resend_verification_nonce'], 'resend_verification')) {
		wp_die('Security check failed');
	}

	$user_email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';

	if (empty($user_email)) {
		wp_redirect(home_url('/academy/signup?resend=error&msg=empty'));
		exit;
	}

	// Check pending signup transient first
	$pending_key = 'academy_pending_' . md5($user_email);
	$pending = get_transient($pending_key);

	if ($pending && isset($pending['user_login'])) {
		$otp_code = random_int(1000, 9999);
		$otp_expiry = time() + (10 * 60);

		$pending['otp_code'] = $otp_code;
		$pending['otp_expiry'] = $otp_expiry;
		set_transient($pending_key, $pending, 15 * MINUTE_IN_SECONDS);

		// Send OTP email using HTML template
		$user_name = isset($pending['user_name']) ? $pending['user_name'] : '';
		vested_academy_send_otp_email($user_email, $otp_code, $user_name);

		wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($user_email) . '&resend=success'));
		exit;
	}

	// If pending not found, check existing user (unverified)
	$user = get_user_by('email', $user_email);
	if ($user) {
		$is_verified = get_user_meta($user->ID, 'academy_email_verified', true);
		if ($is_verified === '1') {
			wp_redirect(home_url('/academy/login?resend=already_verified'));
			exit;
		}

		$otp_code = random_int(1000, 9999);
		$otp_expiry = time() + (10 * 60);

		update_user_meta($user->ID, 'academy_verification_otp', $otp_code);
		update_user_meta($user->ID, 'academy_verification_otp_expiry', $otp_expiry);

		clean_user_cache($user->ID);
		wp_cache_delete($user->ID, 'user_meta');
		wp_cache_delete($user->ID, 'users');

		// Send OTP email using HTML template
		$user_name = !empty($user->display_name) ? $user->display_name : $user->user_login;
		vested_academy_send_otp_email($user_email, $otp_code, $user_name);

		wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($user_email) . '&resend=success'));
		exit;
	}

	wp_redirect(home_url('/academy/signup?resend=error&msg=user_not_found'));
	exit;
}
add_action('admin_post_academy_resend_verification', 'vested_academy_resend_verification_email');
add_action('admin_post_nopriv_academy_resend_verification', 'vested_academy_resend_verification_email');

/**
 * Custom Academy Registration Handler
 */
function vested_academy_handle_registration()
{
	// Verify nonce
	if (!isset($_POST['academy_register_nonce']) || !wp_verify_nonce($_POST['academy_register_nonce'], 'academy_register')) {
		wp_die('Security check failed');
	}

	// Get form data
	$user_name = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : '';
	$user_email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';
	$user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : '';

	// Validate
	if (empty($user_name) || empty($user_email) || empty($user_pass)) {
		wp_redirect(home_url('/academy/signup?registration=error&msg=empty'));
		exit;
	}

	// Check if email already exists
	if (email_exists($user_email)) {
		wp_redirect(home_url('/academy/signup?registration=error&msg=email_exists'));
		exit;
	}

	// Generate username from email (use email address as username)
	// Extract the part before @ symbol and sanitize it
	$email_parts = explode('@', $user_email);
	$base_username = sanitize_user($email_parts[0], true);

	// Ensure username is valid (WordPress requires at least 4 characters)
	if (strlen($base_username) < 4) {
		// If too short, use the full email (sanitized)
		$base_username = sanitize_user($user_email, true);
	}

	// If username already exists, append numbers until we find an available one
	$user_login = $base_username;
	$counter = 1;
	while (username_exists($user_login)) {
		$user_login = $base_username . $counter;
		$counter++;
	}

	// Generate OTP (4-digit)
	$otp_code = random_int(1000, 9999);
	$otp_expiry = time() + (10 * 60); // 10 minutes

	// Store pending signup in transient (15 minutes)
	$pending_key = 'academy_pending_' . md5($user_email);
	$pending_data = array(
		'user_login' => $user_login,
		'user_name' => $user_name,
		'user_email' => $user_email,
		'user_pass' => $user_pass,
		'otp_code' => $otp_code,
		'otp_expiry' => $otp_expiry,
		'created_at' => time(),
	);
	set_transient($pending_key, $pending_data, 15 * MINUTE_IN_SECONDS);

	// Send OTP email using HTML template
	vested_academy_send_otp_email($user_email, $otp_code, $user_name);

	// Redirect to signup page with OTP verification prompt
	wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($user_email)));
	exit;
}
add_action('admin_post_academy_register', 'vested_academy_handle_registration');
add_action('admin_post_nopriv_academy_register', 'vested_academy_handle_registration');

/**
 * Verify OTP submission
 */
function vested_academy_verify_otp()
{
	// Verify nonce
	if (!isset($_POST['academy_verify_otp_nonce']) || !wp_verify_nonce($_POST['academy_verify_otp_nonce'], 'academy_verify_otp')) {
		wp_die('Security check failed');
	}

	$email = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';
	$otp = isset($_POST['verification_otp']) ? sanitize_text_field($_POST['verification_otp']) : '';

	if (empty($email) || empty($otp)) {
		wp_redirect(home_url('/academy/signup?verification=error&msg=invalid_otp'));
		exit;
	}

	// Check pending signup transient
	$pending_key = 'academy_pending_' . md5($email);
	$pending = get_transient($pending_key);

	if ($pending && isset($pending['otp_code'])) {
		// Validate OTP from pending data
		if (time() > intval($pending['otp_expiry'])) {
			wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($email) . '&verification=error&msg=expired'));
			exit;
		}

		// Compare as strings to handle type mismatch
		if ((string) $pending['otp_code'] !== (string) $otp) {
			wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($email) . '&verification=error&msg=invalid_otp'));
			exit;
		}

		// Create user now
		$user_id = wp_create_user($pending['user_login'], $pending['user_pass'], $pending['user_email']);
		if (is_wp_error($user_id)) {
			wp_redirect(home_url('/academy/signup?verification=error&msg=' . urlencode($user_id->get_error_message())));
			exit;
		}

		$user = new WP_User($user_id);
		$user->set_role('academy_user');

		// Update user display name and first name
		if (!empty($pending['user_name'])) {
			$name_parts = explode(' ', $pending['user_name'], 2);
			wp_update_user(array(
				'ID' => $user_id,
				'display_name' => $pending['user_name'],
				'first_name' => $name_parts[0],
				'last_name' => isset($name_parts[1]) ? $name_parts[1] : '',
			));
		}

		// Mark verified
		update_user_meta($user_id, 'academy_email_verified', '1');

		// Clear pending data
		delete_transient($pending_key);

		// Check for last visited page to redirect after login
		$redirect_url = home_url('/academy/login?verification=success');
		if (!session_id() && !headers_sent()) {
			session_start();
		}
		if (isset($_SESSION['academy_last_visited']) && is_array($_SESSION['academy_last_visited']) && isset($_SESSION['academy_last_visited']['url'])) {
			// Store in user meta for when they login
			update_user_meta($user_id, 'academy_last_visited', $_SESSION['academy_last_visited']);
			if (isset($_SESSION['academy_last_visited']['module_id']) && $_SESSION['academy_last_visited']['module_id']) {
				update_user_meta($user_id, 'academy_last_visited_module_' . $_SESSION['academy_last_visited']['module_id'], $_SESSION['academy_last_visited']);
			}
			$redirect_url = add_query_arg('redirect_to', urlencode($_SESSION['academy_last_visited']['url']), $redirect_url);
		} elseif (isset($_COOKIE['academy_last_visited'])) {
			$last_visited = json_decode(stripslashes($_COOKIE['academy_last_visited']), true);
			if ($last_visited && is_array($last_visited) && isset($last_visited['url'])) {
				update_user_meta($user_id, 'academy_last_visited', $last_visited);
				if (isset($last_visited['module_id']) && $last_visited['module_id']) {
					update_user_meta($user_id, 'academy_last_visited_module_' . $last_visited['module_id'], $last_visited);
				}
				$redirect_url = add_query_arg('redirect_to', urlencode($last_visited['url']), $redirect_url);
			}
		}

		wp_redirect($redirect_url);
		exit;
	}

	// If no pending, fallback to existing user (unverified) flow
	$user = get_user_by('email', $email);
	if (!$user) {
		wp_redirect(home_url('/academy/signup?verification=error&msg=user_not_found'));
		exit;
	}

	// Refresh cache
	clean_user_cache($user->ID);
	wp_cache_delete($user->ID, 'user_meta');
	wp_cache_delete($user->ID, 'users');

	$is_verified = get_user_meta($user->ID, 'academy_email_verified', true);
	if ($is_verified === '1') {
		wp_redirect(home_url('/academy/login?verification=already_verified'));
		exit;
	}

	$stored_otp = get_user_meta($user->ID, 'academy_verification_otp', true);
	$otp_expiry = intval(get_user_meta($user->ID, 'academy_verification_otp_expiry', true));

	if (empty($stored_otp) || empty($otp_expiry)) {
		wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($email) . '&verification=error&msg=invalid_otp'));
		exit;
	}

	if (time() > $otp_expiry) {
		wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($email) . '&verification=error&msg=expired'));
		exit;
	}

	// Compare as strings to handle type mismatch (OTP might be stored as int or string)
	if ((string) $stored_otp !== (string) $otp) {
		wp_redirect(home_url('/academy/signup?registration=verify_otp&email=' . urlencode($email) . '&verification=error&msg=invalid_otp'));
		exit;
	}

	// Mark verified
	update_user_meta($user->ID, 'academy_email_verified', '1');
	delete_user_meta($user->ID, 'academy_verification_otp');
	delete_user_meta($user->ID, 'academy_verification_otp_expiry');

	// Clear caches
	clean_user_cache($user->ID);
	wp_cache_delete($user->ID, 'user_meta');
	wp_cache_delete($user->ID, 'users');

	// Transfer session/cookie data to resume state and redirect
	$module_id = null;
	$redirect_to = null;
	if (!session_id() && !headers_sent()) {
		session_start();
	}
	if (isset($_SESSION['academy_last_visited']) && is_array($_SESSION['academy_last_visited'])) {
		$last_visited = $_SESSION['academy_last_visited'];
		if (isset($last_visited['module_id'])) {
			$module_id = intval($last_visited['module_id']);
		}
		// Transfer to resume state
		if (isset($last_visited['chapter_id'])) {
			vested_academy_track_resume_state(
				intval($last_visited['chapter_id']),
				$module_id,
				isset($last_visited['topic_index']) ? intval($last_visited['topic_index']) : null,
				isset($last_visited['topic_slug']) ? $last_visited['topic_slug'] : null,
				isset($last_visited['is_quiz']) && $last_visited['is_quiz'] == 1
			);
		}
		if (isset($last_visited['url'])) {
			$redirect_to = $last_visited['url'];
		}
		unset($_SESSION['academy_last_visited']);
	} elseif (isset($_COOKIE['academy_last_visited'])) {
		$last_visited = json_decode(stripslashes($_COOKIE['academy_last_visited']), true);
		if ($last_visited && is_array($last_visited)) {
			if (isset($last_visited['module_id'])) {
				$module_id = intval($last_visited['module_id']);
			}
			// Transfer to resume state
			if (isset($last_visited['chapter_id'])) {
				vested_academy_track_resume_state(
					intval($last_visited['chapter_id']),
					$module_id,
					isset($last_visited['topic_index']) ? intval($last_visited['topic_index']) : null,
					isset($last_visited['topic_slug']) ? $last_visited['topic_slug'] : null,
					isset($last_visited['is_quiz']) && $last_visited['is_quiz'] == 1
				);
			}
			if (isset($last_visited['url'])) {
				$redirect_to = $last_visited['url'];
			}
		}
	}

	// Use centralized resume function
	$resume_url = vested_academy_get_resume_url($user->ID, array(
		'redirect_to' => $redirect_to,
		'module_id' => $module_id,
		'allow_next_incomplete' => true,
		'fallback_first' => true,
	));
	
	// Redirect to login page with resume URL or default
	if ($resume_url) {
		$redirect_url = add_query_arg('redirect_to', urlencode($resume_url), home_url('/academy/login?verification=success'));
	} else {
		$redirect_url = home_url('/academy/login?verification=success');
	}

	wp_redirect($redirect_url);
	exit;
}
add_action('admin_post_academy_verify_otp', 'vested_academy_verify_otp');
add_action('admin_post_nopriv_academy_verify_otp', 'vested_academy_verify_otp');

/**
 * Restrict login to Academy User role only and check email verification
 * This applies to ALL login attempts, not just Academy login page
 */
function vested_academy_restrict_login($user, $username, $password)
{
	// Only proceed if we have a valid user (authentication succeeded)
	// If $user is null or WP_Error, WordPress will handle it (wrong password, user doesn't exist, etc.)
	if ($user && !is_wp_error($user)) {
		$user_obj = $user;

		// Ensure we have the correct user object
		// WordPress allows login with username or email, so we need to handle both
		if (!empty($username)) {
			// Try to get user by login (username)
			$user_by_login = get_user_by('login', $username);
			if ($user_by_login) {
				$user_obj = $user_by_login;
			} else {
				// If not found by login, try by email
				$user_by_email = get_user_by('email', $username);
				if ($user_by_email) {
					$user_obj = $user_by_email;
				}
			}
		}

		if ($user_obj && is_a($user_obj, 'WP_User')) {
			$user_roles = $user_obj->roles;

			// Check if this is an Academy User (not administrator)
			if (in_array('academy_user', $user_roles) && !in_array('administrator', $user_roles)) {
				// Check if email is verified - use the user ID from the authenticated user object
				$user_id_to_check = $user_obj->ID;
				$is_verified = vested_academy_is_email_verified($user_id_to_check);

				if (!$is_verified) {
					// Return error to prevent login
					return new WP_Error('email_not_verified', 'Please verify email first after you can login.');
				}
			}

			// If this is an Academy login attempt, also check role restriction
			if (isset($_POST['academy_login']) && $_POST['academy_login'] === '1') {
				// Allow administrators and academy_user role
				if (!in_array('academy_user', $user_roles) && !in_array('administrator', $user_roles)) {
					return new WP_Error('invalid_role', 'Only Academy Users can access the Academy. Please contact support.');
				}
			}
		}
	}
	// Return the user (or error) as-is if no restrictions apply
	return $user;
}
add_filter('authenticate', 'vested_academy_restrict_login', 30, 3);

/**
 * Handle login errors for Academy login page only
 * For wp-login.php, errors are displayed automatically by WordPress
 */
function vested_academy_handle_login_errors($user, $username)
{
	// Only handle redirects for Academy login page
	// For wp-login.php, let WordPress display the error naturally
	if (isset($_POST['academy_login']) && $_POST['academy_login'] === '1') {
		if (is_wp_error($user)) {
			$error_code = $user->get_error_code();

			if ($error_code === 'email_not_verified') {
				// Get user email if available - try both login and email
				$user_obj = get_user_by('login', $username);
				if (!$user_obj) {
					$user_obj = get_user_by('email', $username);
				}
				$email = $user_obj ? $user_obj->user_email : '';

				// Redirect to Academy login page with error
				$redirect_url = add_query_arg(array(
					'login' => 'email_not_verified',
					'email' => urlencode($email),
				), home_url('/academy/login'));
				wp_redirect($redirect_url);
				exit;
			} elseif ($error_code === 'invalid_role') {
				wp_redirect(home_url('/academy/login?login=invalid_role'));
				exit;
			}
		}
	}
	// For wp-login.php, return the error so WordPress displays it on the login page
	return $user;
}
add_filter('wp_authenticate_user', 'vested_academy_handle_login_errors', 10, 2);

/**
 * Intercept login failures and redirect Academy login attempts back to Academy login page
 * This checks if the failure was due to email verification or actual authentication failure
 */
function vested_academy_handle_login_failure($username)
{
	// Check if this login attempt came from Academy login page
	if (isset($_POST['academy_login']) && $_POST['academy_login'] === '1') {
		// Preserve redirect_to if present
		$redirect_to = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : '';
		
		// Try to find the user to check verification status
		$user_obj = get_user_by('login', $username);
		if (!$user_obj) {
			$user_obj = get_user_by('email', $username);
		}

		// If user exists, check if it's a verification issue
		if ($user_obj && is_a($user_obj, 'WP_User')) {
			$user_roles = $user_obj->roles;

			// Check if this is an Academy User (not administrator)
			if (in_array('academy_user', $user_roles) && !in_array('administrator', $user_roles)) {
				// Clear cache and check verification status
				wp_cache_delete($user_obj->ID, 'user_meta');
				$is_verified = vested_academy_is_email_verified($user_obj->ID);

				if (!$is_verified) {
					// This is an email verification issue, not a password issue
					$email = $user_obj->user_email;
					$redirect_url = add_query_arg(array(
						'login' => 'email_not_verified',
						'email' => urlencode($email),
					), home_url('/academy/login'));
					if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
						$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
					}
					wp_redirect($redirect_url);
					exit;
				}
			}
		}

		// For any other Academy login failure (wrong password, user doesn't exist, etc.)
		$redirect_url = add_query_arg('login', 'failed', home_url('/academy/login'));
		if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
			$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
		}
		wp_redirect($redirect_url);
		exit;
	}
}
add_action('wp_login_failed', 'vested_academy_handle_login_failure', 10, 1);

/**
 * Custom Academy Login Handler
 * Handles login directly from Academy login page
 */
function vested_academy_handle_login()
{
	// Verify nonce
	if (!isset($_POST['academy_login_nonce']) || !wp_verify_nonce($_POST['academy_login_nonce'], 'academy_login')) {
		wp_die('Security check failed');
	}

	$username = isset($_POST['log']) ? sanitize_text_field($_POST['log']) : '';
	$password = isset($_POST['pwd']) ? $_POST['pwd'] : '';
	$remember = isset($_POST['rememberme']) ? true : false;
	$redirect_to = isset($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url('/academy/');

	// Validate input
	if (empty($username) || empty($password)) {
		$redirect_url = add_query_arg('login', 'empty', home_url('/academy/login'));
		if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
			$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
		}
		wp_redirect($redirect_url);
		exit;
	}

	// Try to find user by email or username
	$user = null;
	if (is_email($username)) {
		$user = get_user_by('email', $username);
	}

	if (!$user) {
		$user = get_user_by('login', $username);
	}

	if (!$user) {
		$redirect_url = add_query_arg('login', 'failed', home_url('/academy/login'));
		if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
			$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
		}
		wp_redirect($redirect_url);
		exit;
	}

	// Check password
	if (!wp_check_password($password, $user->user_pass, $user->ID)) {
		$redirect_url = add_query_arg('login', 'failed', home_url('/academy/login'));
		if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
			$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
		}
		wp_redirect($redirect_url);
		exit;
	}

	// Check if user is Academy User or Administrator
	$user_roles = $user->roles;
	if (!in_array('academy_user', $user_roles) && !in_array('administrator', $user_roles)) {
		$redirect_url = add_query_arg('login', 'invalid_role', home_url('/academy/login'));
		if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
			$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
		}
		wp_redirect($redirect_url);
		exit;
	}

	// Check email verification for Academy Users (not administrators)
	if (in_array('academy_user', $user_roles) && !in_array('administrator', $user_roles)) {
		$is_verified = vested_academy_is_email_verified($user->ID);
		if (!$is_verified) {
			$email = $user->user_email;
			$redirect_url = add_query_arg(array(
				'login' => 'email_not_verified',
				'email' => urlencode($email),
			), home_url('/academy/login'));
			if (!empty($redirect_to) && $redirect_to !== home_url('/academy/')) {
				$redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
			}
			wp_redirect($redirect_url);
			exit;
		}
	}

	// Login successful - set auth cookie and redirect
	wp_set_auth_cookie($user->ID, $remember);
	wp_set_current_user($user->ID);
	do_action('wp_login', $user->user_login, $user);

	// Transfer session/cookie data to resume state (if exists)
	$module_id = null;
	if (!session_id() && !headers_sent()) {
		session_start();
	}
	if (isset($_SESSION['academy_last_visited']) && is_array($_SESSION['academy_last_visited'])) {
		$last_visited = $_SESSION['academy_last_visited'];
		if (isset($last_visited['module_id'])) {
			$module_id = intval($last_visited['module_id']);
		}
		// Transfer to resume state (convert old format to new)
		if (isset($last_visited['chapter_id'])) {
			vested_academy_track_resume_state(
				intval($last_visited['chapter_id']),
				$module_id,
				isset($last_visited['topic_index']) ? intval($last_visited['topic_index']) : null,
				isset($last_visited['topic_slug']) ? $last_visited['topic_slug'] : null,
				isset($last_visited['is_quiz']) && $last_visited['is_quiz'] == 1
			);
			unset($_SESSION['academy_last_visited']);
		}
	} elseif (isset($_COOKIE['academy_last_visited'])) {
		$last_visited = json_decode(stripslashes($_COOKIE['academy_last_visited']), true);
		if ($last_visited && is_array($last_visited) && isset($last_visited['module_id'])) {
			$module_id = intval($last_visited['module_id']);
			// Transfer to resume state
			if (isset($last_visited['chapter_id'])) {
				vested_academy_track_resume_state(
					intval($last_visited['chapter_id']),
					$module_id,
					isset($last_visited['topic_index']) ? intval($last_visited['topic_index']) : null,
					isset($last_visited['topic_slug']) ? $last_visited['topic_slug'] : null,
					isset($last_visited['is_quiz']) && $last_visited['is_quiz'] == 1
				);
			}
		}
	}

	// Use centralized resume function for redirect
	$resume_url = vested_academy_get_resume_url($user->ID, array(
		'redirect_to' => $redirect_to,
		'module_id' => $module_id,
		'allow_next_incomplete' => true,
		'fallback_first' => true,
	));
	
	if ($resume_url) {
		wp_safe_redirect(esc_url_raw($resume_url));
		exit;
	}

	wp_safe_redirect($redirect_to);
	exit;
}
add_action('admin_post_academy_login', 'vested_academy_handle_login');
add_action('admin_post_nopriv_academy_login', 'vested_academy_handle_login');

/**
 * Localize Academy script
 */
function vested_academy_localize_script()
{
	if (vested_academy_is_academy_page()) {
		wp_localize_script('academy-js', 'academyAjax', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('academy_progress_nonce'),
			'quiz_nonce' => wp_create_nonce('academy_quiz_answer_nonce'),
		));
	}
}
add_action('wp_enqueue_scripts', 'vested_academy_localize_script');

/**
 * Redirect to academy page on logout
 */
function vested_academy_logout_redirect($redirect_to, $requested_redirect_to, $user)
{
	// If user is an Academy User, redirect to academy page
	if ($user && is_a($user, 'WP_User')) {
		$user_roles = $user->roles;
		if (in_array('academy_user', $user_roles) || in_array('administrator', $user_roles)) {
			return home_url('/academy/');
		}
	}

	// If a specific redirect was requested, use it; otherwise redirect to academy
	return !empty($requested_redirect_to) ? $requested_redirect_to : home_url('/academy/');
}
add_filter('logout_redirect', 'vested_academy_logout_redirect', 10, 3);

// Quiz duplication prevention removed - quizzes are now stored on chapters

