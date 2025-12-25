<?php
/**
 * Template for displaying Academy Chapter (Module post)
 * 
 * Two-column layout: Left sidebar with course navigation, Right content area
 * 
 * @package Vested Finance WP
 */

// IMPORTANT: Check for redirect BEFORE get_header() to avoid "headers already sent" error
// Get the post ID from queried object (available before the loop)
global $wp_query;
$chapter_id = null;
if (isset($wp_query->queried_object_id)) {
	$chapter_id = $wp_query->queried_object_id;
} elseif (isset($wp_query->post) && $wp_query->post) {
	$chapter_id = $wp_query->post->ID;
}

// Only proceed with redirect check if we have a valid chapter ID
if ($chapter_id) {
	// Helper to fetch topics from CPT
	if (!function_exists('vested_academy_get_topics_for_chapter')) {
		function vested_academy_get_topics_for_chapter($chapter_id)
		{
			$topics = array();
			// Preferred: ACF relationship field ordering
			$selected = get_field('chapter_topic_links', $chapter_id);
			if ($selected && is_array($selected)) {
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
				$topics_posts = $selected_posts;
			} else {
				// Fallback: all chapter_topic posts with this chapter as parent
				$topics_posts = get_posts(array(
					'post_type' => 'chapter_topic',
					'post_parent' => $chapter_id,
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
				));
			}

			if ($topics_posts) {
				$idx = 0;
				foreach ($topics_posts as $tp) {
					// Calculate duration from content dynamically
					$topic_content = $tp->post_content;
					$topic_duration = calculate_reading_time($topic_content);

					$topics[] = array(
						'topic_title' => get_the_title($tp->ID),
						'topic_duration' => $topic_duration,
						'topic_content' => apply_filters('the_content', $topic_content),
						'topic_id' => $tp->ID,
						'topic_slug' => $tp->post_name,
						'index' => $idx,
					);
					$idx++;
				}
			}
			return $topics;
		}
	}

	// Get topics for current chapter (CPT first, fallback to ACF repeater)
	$current_chapter_topics = vested_academy_get_topics_for_chapter($chapter_id);
	if (empty($current_chapter_topics)) {
		$current_chapter_topics = get_field('chapter_topics', $chapter_id);
		if (!$current_chapter_topics || !is_array($current_chapter_topics)) {
			$current_chapter_topics = array();
		}
	}

	// Check if showing quiz (from URL parameter or anchor) - check this BEFORE processing topics
	$show_quiz = isset($_GET['quiz']) && $_GET['quiz'] == '1';
	$show_quiz_results = isset($_GET['results']) && $_GET['results'] == '1';

	// Get current topic from URL - prefer topic_slug query var (rewrite) and fallback to ?topic=
	// Note: $current_topic_index and $current_topic_slug may already be set above
	if (!isset($current_topic_index)) {
		$current_topic_index = null;
	}
	if (!isset($current_topic_slug)) {
		$current_topic_slug = isset($wp_query->query_vars['topic_slug']) ? $wp_query->query_vars['topic_slug'] : null;
	}
	$current_topic = null;

	if ($current_topic_slug && !empty($current_chapter_topics)) {
		foreach ($current_chapter_topics as $idx => $topic) {
			if (isset($topic['topic_slug']) && $topic['topic_slug'] === $current_topic_slug) {
				$current_topic_index = $idx;
				$current_topic = $topic;
				$current_topic['index'] = $idx;
				break;
			}
		}
	} elseif (isset($_GET['topic'])) {
		// Backward compatibility: redirect old ?topic=N to slug URL if available
		$old_idx = intval($_GET['topic']);
		if (isset($current_chapter_topics[$old_idx])) {
			$old_topic = $current_chapter_topics[$old_idx];
			if (isset($old_topic['topic_slug']) && function_exists('vested_academy_get_topic_url')) {
				$new_url = vested_academy_get_topic_url($chapter_id, $old_topic['topic_slug']);
				wp_safe_redirect($new_url, 301);
				exit;
			} else {
				$current_topic_index = $old_idx;
				$current_topic = $old_topic;
				$current_topic['index'] = $old_idx;
			}
		}
	}

	// Check if URL has quiz anchor but no quiz parameter (fix malformed URLs from anchor-only links)
	$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	$has_quiz_anchor = strpos($request_uri, '#quiz-content') !== false || (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '#quiz-content') !== false);
	if ($has_quiz_anchor && !$show_quiz && !$show_quiz_results) {
		// Redirect to proper quiz URL with quiz parameter
		$clean_quiz_url = get_permalink($chapter_id);
		$clean_quiz_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), $clean_quiz_url);
		$clean_quiz_url = add_query_arg('quiz', '1', $clean_quiz_url);
		wp_safe_redirect($clean_quiz_url . '#quiz-content', 302);
		exit;
	}

	// If quiz is being accessed, ensure topic parameter is removed from URL and redirect to clean quiz URL
	if ($show_quiz && $current_topic_index !== null) {
		// Build clean URL without topic parameter
		$clean_quiz_url = get_permalink($chapter_id);
		$clean_quiz_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), $clean_quiz_url);
		$clean_quiz_url = add_query_arg('quiz', '1', $clean_quiz_url);
		if (isset($_GET['q']) && $_GET['q'] > 0) {
			$clean_quiz_url = add_query_arg('q', intval($_GET['q']), $clean_quiz_url);
		}
		wp_safe_redirect($clean_quiz_url . '#quiz-content');
		exit;
	}

	// Also check if URL has both topic and quiz parameters (shouldn't happen, but fix it if it does)
	if ($show_quiz && isset($_GET['topic'])) {
		$clean_quiz_url = get_permalink($chapter_id);
		$clean_quiz_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), $clean_quiz_url);
		$clean_quiz_url = add_query_arg('quiz', '1', $clean_quiz_url);
		if (isset($_GET['q']) && $_GET['q'] > 0) {
			$clean_quiz_url = add_query_arg('q', intval($_GET['q']), $clean_quiz_url);
		}
		wp_safe_redirect($clean_quiz_url . '#quiz-content');
		exit;
	}

	// If no topic selected and chapter has topics, redirect to first topic (unless viewing quiz)
	if ($current_topic_index === null && !empty($current_chapter_topics) && !$show_quiz && !$show_quiz_results && !isset($_GET['no_redirect'])) {
		$first_topic = $current_chapter_topics[0];
		if (isset($first_topic['topic_slug']) && function_exists('vested_academy_get_topic_url')) {
			$redirect_url = vested_academy_get_topic_url($chapter_id, $first_topic['topic_slug']);
		} else {
			// Fallback to old query param
			$redirect_url = get_permalink($chapter_id);
			$redirect_url = remove_query_arg('topic', $redirect_url);
			$redirect_url = add_query_arg('topic', 0, $redirect_url);
		}
		wp_safe_redirect($redirect_url, 302);
		exit;
	}

	// FLAG-BASED COMPLETION: Process mark_completed flag from Next/Quiz buttons
	// This runs early before get_header() to avoid "headers already sent" errors
	if (isset($_GET['mark_completed']) && $_GET['mark_completed'] == '1' && is_user_logged_in()) {
		$user_id = get_current_user_id();
		$prev_topic_index = isset($_GET['prev_topic']) ? intval($_GET['prev_topic']) : null;

		// Only process if we have a valid previous topic index
		if ($prev_topic_index !== null && $prev_topic_index >= 0) {
			// Mark previous topic as completed
			if (function_exists('vested_academy_mark_topic_completed')) {
				vested_academy_mark_topic_completed($user_id, $chapter_id, $prev_topic_index);
			}
		}

		// Clean URL by removing mark_completed and prev_topic parameters
		$clean_url = remove_query_arg(array('mark_completed', 'prev_topic'));
		
		// Preserve other query parameters (quiz, q, results, etc.)
		$preserved_params = array();
		if (isset($_GET['quiz'])) {
			$preserved_params['quiz'] = $_GET['quiz'];
		}
		if (isset($_GET['q'])) {
			$preserved_params['q'] = intval($_GET['q']);
		}
		if (isset($_GET['results'])) {
			$preserved_params['results'] = $_GET['results'];
		}

		// Build clean URL with preserved parameters
		$clean_url = remove_query_arg(array('mark_completed', 'prev_topic', 'quiz', 'q', 'results'), $clean_url);
		if (!empty($preserved_params)) {
			$clean_url = add_query_arg($preserved_params, $clean_url);
		}

		// Add anchor if it was a quiz URL
		if (isset($preserved_params['quiz']) && $preserved_params['quiz'] == '1') {
			$clean_url .= '#quiz-content';
		}

		// Redirect to clean URL
		wp_safe_redirect($clean_url, 302);
		exit;
	}
}

get_header();

while (have_posts()):
	the_post();

	$chapter_id = get_the_ID();
	$user_id = get_current_user_id();

	// Track last visited page (works for both logged and non-logged users)
	$is_quiz = isset($_GET['quiz']) && $_GET['quiz'] == '1';
	$current_topic_slug = isset($wp_query->query_vars['topic_slug']) ? $wp_query->query_vars['topic_slug'] : null;
	$current_topic_index = isset($_GET['topic']) ? intval($_GET['topic']) : null;

	// Get module info first (needed for tracking)
	$terms = get_the_terms($chapter_id, 'modules');
	$module_term = null; // Legacy taxonomy term
	$module_post = null; // New CPT object
	$module_id = null;
	$module_slug = '';
	$module_name = '';
	$module_difficulty = 'Beginner';
	$module_link = '';
	$module_source = null; // 'term' or 'post'

	if ($terms && !is_wp_error($terms) && !empty($terms)) {
		// Get the first module term (chapters should belong to one module)
		$module_term = $terms[0];
		$module_id = $module_term->term_id;
		$module_slug = $module_term->slug;
		$module_name = $module_term->name;
		$module_difficulty = get_field('difficulty_level', $module_term) ?: 'Beginner';
		$module_source = 'term';
		$module_link = get_term_link($module_term);
	} else {
		// Primary (new): find linked Academy Module CPT via ACF relationship on chapter
		$related_modules = get_field('academy_module', $chapter_id);
		if ($related_modules) {
			// Relationship may return array or single object/ID
			if (is_array($related_modules)) {
				$module_post = is_object($related_modules[0]) ? $related_modules[0] : get_post($related_modules[0]);
			} elseif (is_object($related_modules)) {
				$module_post = $related_modules;
			} elseif (is_numeric($related_modules)) {
				$module_post = get_post($related_modules);
			}
		}

		if ($module_post) {
			$module_id = $module_post->ID;
			$module_slug = $module_post->post_name;
			$module_name = get_the_title($module_id);
			$module_difficulty = get_field('difficulty_level', $module_id) ?: 'Beginner';
			$module_source = 'post';
			$module_link = get_permalink($module_id);
		} else {
			// Legacy fallback: try to derive term from URL slug (e.g. /academy/{term}/{postname})
			$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
			$slug = '';
			if ($request_uri) {
				$parts = explode('/', trim($request_uri, '/'));
				// Find 'academy' in path and take the next segment as term slug
				$academy_index = array_search('academy', $parts, true);
				if ($academy_index !== false && isset($parts[$academy_index + 1])) {
					$slug = sanitize_title($parts[$academy_index + 1]);
				}
			}
			if ($slug) {
				$fallback_term = get_term_by('slug', $slug, 'modules');
				if ($fallback_term && !is_wp_error($fallback_term)) {
					$module_term = $fallback_term;
					$module_id = $fallback_term->term_id;
					$module_slug = $fallback_term->slug;
					$module_name = $fallback_term->name;
					$module_difficulty = get_field('difficulty_level', $fallback_term) ?: 'Beginner';
					$module_source = 'term';
					$module_link = get_term_link($module_term);
				}
			}
		}
	}

	// Get all chapters in this module for sidebar
	// IMPORTANT: Only show chapters from the SAME module category
	$all_chapters = array();
	if ($module_id) {
		if ($module_source === 'post') {
			// New structure: link chapters to Academy Module CPT via ACF relationship
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
				'no_found_rows' => true, // Optimize query
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			));
		} else {
			// Legacy taxonomy-based grouping
			$chapters_query = new WP_Query(array(
				'post_type' => 'module',
				'tax_query' => array(
					array(
						'taxonomy' => 'modules',
						'field' => 'term_id',
						'terms' => $module_id,
						'operator' => 'IN', // Explicitly set operator
					),
				),
				'posts_per_page' => -1,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'no_found_rows' => true, // Optimize query
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			));
		}

		if ($chapters_query->have_posts()) {
			while ($chapters_query->have_posts()) {
				$chapters_query->the_post();
				$chapter_post_id = get_the_ID();
				$chapter_url = get_permalink($chapter_post_id);

				// Get topics for this chapter from CPT (fallback to ACF)
				$topics = vested_academy_get_topics_for_chapter($chapter_post_id);
				if (empty($topics)) {
					$topics = get_field('chapter_topics', $chapter_post_id);
					if (!$topics || !is_array($topics)) {
						$topics = array();
					}
				}

				$all_chapters[] = array(
					'id' => $chapter_post_id,
					'title' => get_the_title(),
					'url' => $chapter_url,
					'reading_time' => calculate_reading_time(get_the_content()),
					'topics' => $topics, // Add topics array
				);
			}
			wp_reset_postdata();
		} else {
			// No chapters found
		}
	} else {
		// If taxonomy/module term is intentionally removed, fall back to a single-chapter sidebar
		$topics = get_field('chapter_topics', $chapter_id);
		if (!$topics || !is_array($topics)) {
			$topics = array();
		}
		$all_chapters[] = array(
			'id' => $chapter_id,
			'title' => get_the_title(),
			'url' => get_permalink($chapter_id),
			'reading_time' => calculate_reading_time(get_the_content()),
			'topics' => $topics,
		);
	}

	// Get quiz for THIS MODULE/CHAPTER
	// Quiz is now stored as a separate post type and linked via quiz_links relationship field
	$quiz = null;
	$quiz_data = null;

	// Get quizzes for THIS CHAPTER
	// quiz_links field is on the chapter (module post type)
	$module_quizzes = vested_academy_get_quizzes_for_module($chapter_id);

	// Use the first quiz if multiple exist
	if (!empty($module_quizzes)) {
		$quiz_post = $module_quizzes[0];

		// Use questions from helper function (already retrieved)
		$quiz_questions = isset($quiz_post['questions']) ? $quiz_post['questions'] : array();

		// If questions array is empty, try fetching directly (fallback)
		if (empty($quiz_questions)) {
			$quiz_questions = get_field('quiz_questions', $quiz_post['id']);
			if (!$quiz_questions) {
				$quiz_questions = array();
			}
		}

		if (!empty($quiz_questions)) {
			// Module has a quiz
			$quiz = array(
				'id' => $quiz_post['id'],
				'title' => $quiz_post['title'],
				'url' => $quiz_post['permalink'],
				'time_limit' => $quiz_post['time_limit'],
			);

			$quiz_data = array(
				'id' => $quiz_post['id'],
				'questions' => $quiz_questions,
				'total_questions' => count($quiz_questions),
				'passing_score' => $quiz_post['passing_score'],
				'time_limit' => $quiz_post['time_limit'],
				'allow_retake' => get_field('allow_retake', $quiz_post['id']) !== false,
			);

			// Get user's saved answers and previous attempts
			// Use quiz_post ID as quiz_id
			$quiz_saved_answers = array();
			$quiz_previous_attempt = null;
			if ($user_id) {
				$quiz_saved_answers = vested_academy_get_user_quiz_answers($user_id, $quiz_post['id']);
				global $wpdb;
				$table_name = $wpdb->prefix . 'academy_progress';
				$quiz_previous_attempt = $wpdb->get_row($wpdb->prepare(
					"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
					$user_id,
					$quiz_post['id']
				));
			}

			$quiz_data['saved_answers'] = $quiz_saved_answers;
			$quiz_data['previous_attempt'] = $quiz_previous_attempt;
		}
	}

	// Keep previously loaded topics (CPT via helper) - only fallback to ACF repeater if empty
	if (empty($current_chapter_topics)) {
		$current_chapter_topics = get_field('chapter_topics', $chapter_id);
		if (!$current_chapter_topics || !is_array($current_chapter_topics)) {
			$current_chapter_topics = array();
		}
	}

	// Check if showing quiz (from URL parameter or anchor) - check this BEFORE processing topics
	$show_quiz = isset($_GET['quiz']) && $_GET['quiz'] == '1';
	$quiz_current_question = isset($_GET['q']) ? intval($_GET['q']) : 0;
	$show_quiz_results = isset($_GET['results']) && $_GET['results'] == '1';

	// current_topic_index and current_topic are already set above using slug fallback
	// If current_topic is set but index is null, try to find the index
	if ($current_topic && $current_topic_index === null) {
		if (isset($current_topic['index'])) {
			$current_topic_index = $current_topic['index'];
		} elseif (!empty($current_chapter_topics)) {
			// Find the topic in the array to get its index
			foreach ($current_chapter_topics as $idx => $topic) {
				if (isset($topic['topic_slug']) && isset($current_topic['topic_slug']) && $topic['topic_slug'] === $current_topic['topic_slug']) {
					$current_topic_index = $idx;
					break;
				} elseif (isset($topic['topic_title']) && isset($current_topic['topic_title']) && $topic['topic_title'] === $current_topic['topic_title']) {
					$current_topic_index = $idx;
					break;
				}
			}
		}
	}

	// Get next and previous topics (only within same chapter)
	$next_topic = null;
	$prev_topic = null;
	if ($current_topic_index !== null && !empty($current_chapter_topics)) {
		// Next topic in same chapter
		if (isset($current_chapter_topics[$current_topic_index + 1])) {
			$next_topic_data = $current_chapter_topics[$current_topic_index + 1];
			$next_topic_url = (isset($next_topic_data['topic_slug']) && function_exists('vested_academy_get_topic_url'))
				? vested_academy_get_topic_url($chapter_id, $next_topic_data['topic_slug'])
				: add_query_arg('topic', $current_topic_index + 1, get_permalink($chapter_id));
			$next_topic = array(
				'index' => $current_topic_index + 1,
				'data' => $next_topic_data,
				'chapter_id' => $chapter_id,
				'url' => $next_topic_url,
			);
		}

		// Previous topic in same chapter
		if ($current_topic_index > 0 && isset($current_chapter_topics[$current_topic_index - 1])) {
			$prev_topic_data = $current_chapter_topics[$current_topic_index - 1];
			$prev_topic_url = (isset($prev_topic_data['topic_slug']) && function_exists('vested_academy_get_topic_url'))
				? vested_academy_get_topic_url($chapter_id, $prev_topic_data['topic_slug'])
				: add_query_arg('topic', $current_topic_index - 1, get_permalink($chapter_id));
			$prev_topic = array(
				'index' => $current_topic_index - 1,
				'data' => $prev_topic_data,
				'chapter_id' => $chapter_id,
				'url' => $prev_topic_url,
			);
		}
	}

	// Ensure question index is valid (will be validated again when displaying questions)
	// Note: $show_quiz, $quiz_current_question, and $show_quiz_results are already defined above

	// Validate question index bounds (will be set after quiz_data is loaded)

	// Get current chapter index
	$current_chapter_index = 0;
	foreach ($all_chapters as $index => $chapter) {
		if ($chapter['id'] == $chapter_id) {
			$current_chapter_index = $index;
			break;
		}
	}

	// Get next and previous chapters
	$next_chapter = isset($all_chapters[$current_chapter_index + 1]) ? $all_chapters[$current_chapter_index + 1] : null;
	$prev_chapter = isset($all_chapters[$current_chapter_index - 1]) ? $all_chapters[$current_chapter_index - 1] : null;

	// Check chapter completion (for display purposes only - no redirect)
	$chapter_completed = false;
	if ($user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'academy_progress';
		$progress = $wpdb->get_row($wpdb->prepare(
			"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter' AND status = 'completed'",
			$user_id,
			$chapter_id
		));
		$chapter_completed = !empty($progress);

		// REMOVED: Auto-redirect from completed chapters
		// Users can now access any chapter they want, regardless of completion status
	}

	// Track resume state for logged-in users (NEW - User Meta Only)
	// For logged-in users, track learning state (not URLs) using centralized function
	if ($user_id && function_exists('vested_academy_track_resume_state')) {
		$track_topic_index = null;

		// If viewing quiz, try to preserve the last topic index from previous visit or from URL
		if ($is_quiz && $current_topic_index === null) {
			// Check if there's a topic parameter in URL (might be from previous navigation)
			if (isset($_GET['topic'])) {
				$track_topic_index = intval($_GET['topic']);
			} else {
				// Get resume state to preserve topic index
				$resume_state = vested_academy_get_resume_state($module_id);
				if (
					$resume_state &&
					isset($resume_state['chapter_id']) &&
					intval($resume_state['chapter_id']) === $chapter_id &&
					isset($resume_state['topic_index']) &&
					$resume_state['topic_index'] !== null
				) {
					$track_topic_index = intval($resume_state['topic_index']);
				} elseif (!empty($current_chapter_topics)) {
					// If no resume state topic, assume last topic (since quiz comes after last topic)
					$track_topic_index = count($current_chapter_topics) - 1;
				}
			}
		} elseif ($current_topic_index !== null) {
			$track_topic_index = $current_topic_index;
		}

		// Track resume state (logged-in users only - user meta)
		vested_academy_track_resume_state(
			$chapter_id,
			$module_id,
			$track_topic_index,
			$current_topic_slug, // Keep for reference but not used in state
			$is_quiz
		);
	}
	
	// Legacy: Track last visited for non-logged users (session/cookie)
	// Keep this for backward compatibility with non-logged users
	if (!$user_id && function_exists('vested_academy_track_last_visited')) {
		$track_topic_index = null;
		$track_topic_slug = null;

		if ($is_quiz && $current_topic_index === null) {
			if (isset($_GET['topic'])) {
				$track_topic_index = intval($_GET['topic']);
			} elseif (!empty($current_chapter_topics)) {
				$track_topic_index = count($current_chapter_topics) - 1;
			}
		} elseif ($current_topic_index !== null) {
			$track_topic_index = $current_topic_index;
		} elseif ($current_topic_slug) {
			$track_topic_slug = $current_topic_slug;
		}

		vested_academy_track_last_visited(
			$chapter_id,
			$module_id,
			$track_topic_index,
			$track_topic_slug,
			$is_quiz
		);
	}

	$reading_time = calculate_reading_time(get_the_content());
	// Already set earlier; keep fallback for safety
	if (!$module_difficulty) {
		$module_difficulty = get_field('difficulty_level', $module_term) ?: 'Beginner';
	}

	// Count total chapters
	$total_chapters = count($all_chapters);
	$total_minutes = 0;
	foreach ($all_chapters as $ch) {
		// Add chapter reading time
		$total_minutes += $ch['reading_time'];

		// Add all topics duration for this chapter
		if (isset($ch['topics']) && is_array($ch['topics'])) {
			foreach ($ch['topics'] as $topic) {
				// Get topic duration (calculated from content)
				$topic_duration = isset($topic['topic_duration']) ? intval($topic['topic_duration']) : 0;
				// If duration not set, calculate from content
				if ($topic_duration <= 0 && isset($topic['topic_content'])) {
					$topic_duration = calculate_reading_time($topic['topic_content']);
				}
				// If still 0, try calculating from topic_id if it's a CPT
				if ($topic_duration <= 0 && isset($topic['topic_id'])) {
					$topic_post = get_post($topic['topic_id']);
					if ($topic_post) {
						$topic_duration = calculate_reading_time($topic_post->post_content);
					}
				}
				$total_minutes += $topic_duration;
			}
		}

		// Add quiz time for this chapter
		$chapter_quizzes = vested_academy_get_quizzes_for_module($ch['id']);
		if (!empty($chapter_quizzes)) {
			foreach ($chapter_quizzes as $quiz) {
				$quiz_time = isset($quiz['time_limit']) ? intval($quiz['time_limit']) : 0;
				$total_minutes += $quiz_time;
			}
		}
	}

	// Format display: show minutes if less than 1 hour, otherwise show hours
	if ($total_minutes < 60) {
		$total_time_display = $total_minutes . ' Minutes';
	} else {
		$total_hours = round($total_minutes / 60, 1);
		$total_time_display = $total_hours . ' Hours';
	}
	?>

	<div id="academy-chapter-page" class="academy-chapter-page">
		<div class="social-overlay"></div>
		<!-- Green Header Banner -->
		<section class="chapter-header-banner">
			<!-- Breadcrumbs -->
			<div class="chapter-breadcrumb">
				<div class="container">
					<ul>
						<li><a href="<?php echo esc_url(home_url('/academy')); ?>">Home</a></li>
						<?php if ($module_link): ?>
							<li><a
									href="<?php echo esc_url($module_link); ?>"><?php echo esc_html($module_name ? $module_name : 'Module'); ?></a>
							</li>
						<?php elseif ($module_name): ?>
							<li><span><?php echo esc_html($module_name); ?></span></li>
						<?php endif; ?>
						<li><span><?php the_title(); ?></span></li>
					</ul>
				</div>
			</div>
			<div class="chapter-header-content">
				<div class="container">
					<div class="chapter-header-content-inner">
						<!-- Course Title -->
						<h1 class="chapter-course-title">
							<?php echo esc_html($module_name ? $module_name : get_the_title()); ?></h1>

						<!-- Course Meta -->
						<div class="chapter-meta">
							<div class="meta-item">
								<svg width="14" height="13" viewBox="0 0 14 13" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M14 13H10V0H14V13ZM11 12H13V1H11V12ZM9 13H5V4H9V13ZM6 12H8V5H6V12ZM4 13H0V7H4V13ZM1 12H3V8H1V12Z"
										fill="white" />
								</svg>
								<span><?php echo esc_html($module_difficulty); ?></span>
							</div>
							<div class="meta-item">
								<svg width="10" height="14" viewBox="0 0 10 14" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M9 14H1C0.734784 14 0.48043 13.8946 0.292893 13.7071C0.105357 13.5196 0 13.2652 0 13V1C0 0.734784 0.105357 0.48043 0.292893 0.292893C0.48043 0.105357 0.734784 0 1 0H9C9.26522 0 9.51957 0.105357 9.70711 0.292893C9.89464 0.48043 10 0.734784 10 1V9.309L7.5 8.059L5 9.309V1H1V13H9V11H10V13C9.9996 13.2651 9.89412 13.5192 9.70667 13.7067C9.51922 13.8941 9.26509 13.9996 9 14ZM7.5 6.941L9 7.691V1H6V7.691L7.5 6.941Z"
										fill="white" />
								</svg>
								<span><?php echo esc_html($total_chapters); ?> Chapters</span>
							</div>
							<div class="meta-item">
								<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M8 15C4.14 15 1 11.86 1 8C1 4.14 4.14 1 8 1C11.86 1 15 4.14 15 8C15 11.86 11.86 15 8 15ZM8 2C4.69 2 2 4.69 2 8C2 11.31 4.69 14 8 14C11.31 14 14 11.31 14 8C14 4.69 11.31 2 8 2Z"
										fill="white" />
									<path
										d="M10 10.5C9.91001 10.5 9.82001 10.48 9.74001 10.43L7.24001 8.93C7.1663 8.88513 7.10546 8.82195 7.0634 8.74659C7.02134 8.67124 6.99951 8.58629 7.00001 8.5V4.5C7.00001 4.22 7.22001 4 7.50001 4C7.78001 4 8.00001 4.22 8.00001 4.5V8.22L10.26 9.57C10.3531 9.62705 10.425 9.7129 10.4649 9.81453C10.5049 9.91615 10.5105 10.028 10.4811 10.1332C10.4517 10.2383 10.3889 10.331 10.302 10.3972C10.2152 10.4634 10.1092 10.4995 10 10.5Z"
										fill="white" />
								</svg>
								<span><?php echo esc_html($total_time_display); ?></span>
							</div>
						</div>

						<!-- Tags -->
						<!-- <div class="chapter-tags">
							<span class="tag-item">Stock market</span>
							<span class="tag-item">Intraday Trading</span>
						</div> -->

						<!-- Share Button -->
						<div class="social-share-block">
							<button class="sharing-icon blog_share_mw">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.webp"
									alt="link" />
							</button>
							<button class="share-btn"><img
									src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/share-icon.webp"
									alt="Share Icon" /><span>Share</span></button>
							<ul>
								<?php
								$current_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								?>

								<li>
									<a id="copyLink" href="" class="blog_share_copylink">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link.webp"
											alt="link" />
										<span>Copy link</span>
									</a>
								</li>
								<li class="share_whatsapp">
									<a href="javascript:void(0);" target="_blank" class="blog_share_whatsapp">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/whatsapp.webp"
											alt="whatsapp" />
										<span>Share on Whatsapp</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Main Content Layout -->
		<div class="chapter-main-layout">
			<div class="container">
				<div class="chapter-layout-wrapper">
					<!-- Left Sidebar: Course Navigation -->
					<aside class="chapter-sidebar">
						<!-- <div class="sidebar-course-header">
							<div class="course-icon-small">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4 19.5C4 18.6716 4.67157 18 5.5 18H18.5C19.3284 18 20 18.6716 20 19.5C20 20.3284 19.3284 21 18.5 21H5.5C4.67157 21 4 20.3284 4 19.5Z" fill="#00A651"/>
									<path d="M4 4.5C4 3.67157 4.67157 3 5.5 3H18.5C19.3284 3 20 3.67157 20 4.5C20 5.32843 19.3284 6 18.5 6H5.5C4.67157 6 4 5.32843 4 4.5Z" fill="#00A651"/>
									<path d="M4 12C4 11.1716 4.67157 10.5 5.5 10.5H18.5C19.3284 10.5 20 11.1716 20 12C20 12.8284 19.3284 13.5 18.5 13.5H5.5C4.67157 13.5 4 12.8284 4 12Z" fill="#00A651"/>
								</svg>
							</div>
							<h3 class="sidebar-course-title"><?php echo esc_html($module_name ? $module_name : 'Course'); ?></h3>
						</div> -->

						<div class="sidebar-chapters-list">
							<?php
							// Optimized: Get all progress in one batch query
							$all_chapter_ids = array();
							$all_topic_data = array();
							foreach ($all_chapters as $chapter) {
								$all_chapter_ids[] = $chapter['id'];
								if (isset($chapter['topics']) && is_array($chapter['topics'])) {
									foreach ($chapter['topics'] as $idx => $topic) {
										$all_topic_data[] = array(
											'chapter_id' => $chapter['id'],
											'topic_index' => $idx,
										);
									}
								}
							}

							// Get all progress in one query (optimized)
							$batch_progress = array();
							if ($user_id && (!empty($all_chapter_ids) || !empty($all_topic_data))) {
								$batch_progress = vested_academy_get_batch_progress($user_id, $all_chapter_ids, $all_topic_data);
							}

							$chapter_num = 1;
							foreach ($all_chapters as $index => $chapter):
								// Check if chapter should be hidden based on country
								if (function_exists('academy_is_content_restricted') && academy_is_content_restricted($chapter['id'])) {
									continue; // Skip this chapter and all its content
								}

								$is_current = ($chapter['id'] == $chapter_id);
								// Only expand the current chapter (the one containing the current topic/viewing)
								// All other chapters should be collapsed
								$is_expanded = $is_current;

								// Check if completed (from batch data - optimized)
								$is_completed = false;
								if ($user_id && isset($batch_progress['chapters'][$chapter['id']])) {
									$is_completed = ($batch_progress['chapters'][$chapter['id']]['status'] === 'completed');
								}

								// Check if THIS chapter/module has quizzes (from quiz_links field only)
								$module_quizzes = vested_academy_get_quizzes_for_module($chapter['id']);
								$chapter_quiz = null;

								if (!empty($module_quizzes)) {
									// Chapter has quizzes linked via quiz_links - use first one for display
									$quiz_post = $module_quizzes[0];
									$chapter_quiz = array(
										'id' => $quiz_post['id'],
										'title' => $quiz_post['title'],
										'time_limit' => $quiz_post['time_limit'],
									);
								}
								// No fallback - quizzes only show if explicitly selected via quiz_links field
								?>
								<div class="sidebar-chapter-item <?php echo $is_current ? 'active' : ''; ?> <?php echo $is_expanded ? 'expanded' : ''; ?>"
									data-chapter-id="<?php echo esc_attr($chapter['id']); ?>">
									<div class="sidebar-chapter-header">
										<a href="<?php echo esc_url($chapter['url']); ?>" class="chapter-label-link">
											<span class="chapter-label">Chapter <?php echo esc_html($chapter_num); ?>:
												<?php echo esc_html($chapter['title']); ?></span>
										</a>
										<button class="chapter-toggle" aria-label="Toggle chapter" type="button">
											<svg width="13" height="8" viewBox="0 0 13 8" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" clip-rule="evenodd"
													d="M5.65703 7.071L2.67029e-05 1.414L1.41403 0L6.36403 4.95L11.314 0L12.728 1.414L7.07103 7.071C6.8835 7.25847 6.62919 7.36379 6.36403 7.36379C6.09886 7.36379 5.84455 7.25847 5.65703 7.071Z"
													fill="#9095A1" />
											</svg>
										</button>
									</div>

									<div class="sidebar-chapter-content"
										style="display: <?php echo $is_expanded ? 'block' : 'none'; ?>;">
										<?php
										// Display topics for this chapter
										$chapter_topics = isset($chapter['topics']) ? $chapter['topics'] : array();

										if (!empty($chapter_topics)) {
											foreach ($chapter_topics as $topic_idx => $topic):
												// Check if topic should be hidden based on country
												$topic_id = isset($topic['topic_id']) ? $topic['topic_id'] : null;
												if ($topic_id && function_exists('academy_is_content_restricted') && academy_is_content_restricted($topic_id)) {
													continue; // Skip this topic and its quizzes
												}

												$topic_title = isset($topic['topic_title']) ? $topic['topic_title'] : 'Topic ' . ($topic_idx + 1);
												// Get duration from topic data (calculated from content)
												$topic_duration = isset($topic['topic_duration']) ? intval($topic['topic_duration']) : 0;
												// If duration is 0 or not set, calculate from content
												if ($topic_duration <= 0 && isset($topic['topic_content'])) {
													$topic_duration = calculate_reading_time($topic['topic_content']);
												}
												// Minimum 1 minute if content exists
												if ($topic_duration <= 0) {
													$topic_duration = 1;
												}
												if (isset($topic['topic_slug']) && function_exists('vested_academy_get_topic_url')) {
													$topic_url = vested_academy_get_topic_url($chapter['id'], $topic['topic_slug']);
												} else {
													$topic_url = add_query_arg('topic', $topic_idx, $chapter['url']);
												}

												// Add completion flag for forward navigation in sidebar
												// Only mark previous topic as completed if:
												// 1. User is logged in
												// 2. We're viewing the same chapter (is_current)
												// 3. Current topic index is set
												// 4. Clicked topic index is greater than current (forward navigation)
												// 5. Clicked topic is not already completed
												if (
													$user_id &&
													$is_current &&
													$current_topic_index !== null &&
													$topic_idx > $current_topic_index &&
													$chapter['id'] == $chapter_id
												) {
													// This is forward navigation - add flag to mark current topic as completed
													$topic_url = add_query_arg(
														array(
															'mark_completed' => '1',
															'prev_topic' => $current_topic_index
														),
														$topic_url
													);
												}

												// Check if this topic is current
												$is_current_topic = ($is_current && $current_topic_index === $topic_idx);

												$topic_completed = false;
												if ($user_id && !$is_current_topic) { // Never mark current topic as completed
													$topic_key = $chapter['id'] . '_' . $topic_idx;

													if (isset($batch_progress['topics'][$topic_key])) {
														$topic_status = $batch_progress['topics'][$topic_key]['status'];
														$topic_completed = ($topic_status === 'completed');
													}

													if (!$topic_completed) {
														$topic_completed = vested_academy_is_topic_completed($user_id, $chapter['id'], $topic_idx);
													}
												}

												// No topic locking - users can access any topic
												$topic_locked = false;
												?>
												<a href="<?php echo esc_url($topic_url); ?>"
													class="sidebar-chapter-sub-item <?php echo $is_current_topic ? 'current' : ''; ?> <?php echo $topic_completed ? 'completed' : ''; ?>"
													data-chapter-id="<?php echo esc_attr($chapter['id']); ?>"
													data-topic-index="<?php echo esc_attr($topic_idx); ?>">
													<span class="sub-item-icon <?php echo $topic_completed ? 'completed-icon' : ''; ?>">
														<?php if ($topic_completed): ?>
															<!-- Completed icon (highlighted) -->
															<svg width="19" height="22" viewBox="0 0 19 22" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<path
																	d="M4.73055 2.23889C3.18224 2.28566 2.25982 2.4578 1.62099 3.09663C0.746338 3.97228 0.746338 5.38029 0.746338 8.1973V14.6712C0.746338 17.4892 0.746338 18.8972 1.62099 19.7728C2.49466 20.6475 3.90266 20.6475 6.71669 20.6475H11.692C14.507 20.6475 15.914 20.6475 16.7877 19.7718C17.6633 18.8972 17.6633 17.4892 17.6633 14.6712V8.1973C17.6633 5.38129 17.6633 3.97228 16.7877 3.09663C16.1498 2.4578 15.2264 2.28566 13.6781 2.23889"
																	stroke="#002852" stroke-width="1.49259" fill="#002852"
																	fill-opacity="0.1" />
																<path
																	d="M4.72681 2.48769C4.72681 1.52646 5.50693 0.746338 6.46816 0.746338H11.941C12.4028 0.746338 12.8457 0.929801 13.1723 1.25637C13.4989 1.58294 13.6823 2.02586 13.6823 2.48769C13.6823 2.94953 13.4989 3.39245 13.1723 3.71901C12.8457 4.04558 12.4028 4.22904 11.941 4.22904H6.46816C6.00632 4.22904 5.5634 4.04558 5.23684 3.71901C4.91027 3.39245 4.72681 2.94953 4.72681 2.48769Z"
																	stroke="#002852" stroke-width="1.49259" stroke-linejoin="round"
																	fill="#002852" fill-opacity="0.1" />
																<path d="M3.7356 8.7074H7.71583" stroke="#002852" stroke-width="1.49259"
																	stroke-linecap="round" />
																<path
																	d="M10.7004 9.7013C10.7004 9.7013 11.198 9.7013 11.6955 10.6964C11.6955 10.6964 13.2757 8.20871 14.6807 7.71118"
																	stroke="#002852" stroke-width="1.49259" stroke-linecap="round"
																	stroke-linejoin="round" />
																<path d="M3.7356 14.6777H7.71583" stroke="#002852" stroke-width="1.49259"
																	stroke-linecap="round" />
																<path
																	d="M10.7004 15.6716C10.7004 15.6716 11.198 15.6716 11.6955 16.6667C11.6955 16.6667 13.2757 14.179 14.6807 13.6815"
																	stroke="#002852" stroke-width="1.49259" stroke-linecap="round"
																	stroke-linejoin="round" />
															</svg>
														<?php else: ?>
															<!-- Default icon -->
															<svg width="19" height="22" viewBox="0 0 19 22" fill="none"
																xmlns="http://www.w3.org/2000/svg">
																<path
																	d="M4.73055 2.23889C3.18224 2.28566 2.25982 2.4578 1.62099 3.09663C0.746338 3.97228 0.746338 5.38029 0.746338 8.1973V14.6712C0.746338 17.4892 0.746338 18.8972 1.62099 19.7728C2.49466 20.6475 3.90266 20.6475 6.71669 20.6475H11.692C14.507 20.6475 15.914 20.6475 16.7877 19.7718C17.6633 18.8972 17.6633 17.4892 17.6633 14.6712V8.1973C17.6633 5.38129 17.6633 3.97228 16.7877 3.09663C16.1498 2.4578 15.2264 2.28566 13.6781 2.23889"
																	stroke="black" stroke-width="1.49259" />
																<path
																	d="M4.72681 2.48769C4.72681 1.52646 5.50693 0.746338 6.46816 0.746338H11.941C12.4028 0.746338 12.8457 0.929801 13.1723 1.25637C13.4989 1.58294 13.6823 2.02586 13.6823 2.48769C13.6823 2.94953 13.4989 3.39245 13.1723 3.71901C12.8457 4.04558 12.4028 4.22904 11.941 4.22904H6.46816C6.00632 4.22904 5.5634 4.04558 5.23684 3.71901C4.91027 3.39245 4.72681 2.94953 4.72681 2.48769Z"
																	stroke="black" stroke-width="1.49259" stroke-linejoin="round" />
																<path d="M3.7356 8.7074H7.71583" stroke="black" stroke-width="1.49259"
																	stroke-linecap="round" />
																<path
																	d="M10.7004 9.7013C10.7004 9.7013 11.198 9.7013 11.6955 10.6964C11.6955 10.6964 13.2757 8.20871 14.6807 7.71118"
																	stroke="black" stroke-width="1.49259" stroke-linecap="round"
																	stroke-linejoin="round" />
																<path d="M3.7356 14.6777H7.71583" stroke="black" stroke-width="1.49259"
																	stroke-linecap="round" />
																<path
																	d="M10.7004 15.6716C10.7004 15.6716 11.198 15.6716 11.6955 16.6667C11.6955 16.6667 13.2757 14.179 14.6807 13.6815"
																	stroke="black" stroke-width="1.49259" stroke-linecap="round"
																	stroke-linejoin="round" />
															</svg>
														<?php endif; ?>
													</span>
													<div class="sidebar-chapter-sub-item-content">
														<span
															class="sub-item-number"><?php echo str_pad($topic_idx + 1, 2, '0', STR_PAD_LEFT); ?>:
															<?php echo esc_html($topic_title); ?></span>
														<span class="sub-item-duration"><?php echo esc_html($topic_duration); ?>
															Minutes</span>
													</div>
													<?php if ($topic_completed): ?>
														<span class="sub-item-check"
															style="display: block !important; visibility: visible !important;">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg" style="display: block;">
																<path
																	d="M18.3334 9.2333V9.99997C18.3324 11.797 17.7505 13.5455 16.6745 14.9848C15.5986 16.4241 14.0862 17.477 12.3629 17.9866C10.6396 18.4961 8.7978 18.4349 7.11214 17.8121C5.42648 17.1894 3.98729 16.0384 3.00922 14.5309C2.03114 13.0233 1.56657 11.24 1.68481 9.4469C1.80305 7.65377 2.49775 5.94691 3.66531 4.58086C4.83288 3.21482 6.41074 2.26279 8.16357 1.86676C9.91641 1.47073 11.7503 1.65192 13.3918 2.3833M18.3334 3.33331L10.0001 11.675L7.50008 9.17498"
																	stroke="#002852" stroke-width="2" stroke-linecap="round"
																	stroke-linejoin="round" fill="none" />
															</svg>
														</span>
													<?php endif; ?>
												</a>
											<?php endforeach;
										} else {
											// Debug helper: surface empty topics state when WP_DEBUG is on
											if (defined('WP_DEBUG') && WP_DEBUG) {
												echo '<p class="academy-debug-notice">No topics found for this chapter. Check the ACF repeater field "chapter_topics" on the module post.</p>';
											}
											// Fallback: Show chapter as single item if no topics (from batch data - optimized)
											$sub_completed = false;
											if ($user_id && isset($batch_progress['chapters'][$chapter['id']])) {
												$sub_completed = ($batch_progress['chapters'][$chapter['id']]['status'] === 'completed');
											}
											?>
											<a href="<?php echo esc_url($chapter['url']); ?>"
												class="sidebar-chapter-sub-item <?php echo $is_current ? 'current' : ''; ?>">
												<span
													class="sub-item-number"><?php echo str_pad($chapter_num, 2, '0', STR_PAD_LEFT); ?>:
													<?php echo esc_html($chapter['title']); ?></span>
												<span class="sub-item-duration"><?php echo esc_html($chapter['reading_time']); ?>
													Minutes</span>
												<?php if ($sub_completed): ?>
													<span class="sub-item-check">✓</span>
												<?php endif; ?>
											</a>
										<?php } ?>

										<?php
										// Add Quiz for THIS chapter (each chapter has its own quiz)
										if ($chapter_quiz):
											// Check if quiz should be hidden based on country
											$quiz_restricted = function_exists('academy_is_content_restricted') && academy_is_content_restricted($chapter_quiz['id']);
											if (!function_exists('academy_is_content_restricted') || !$quiz_restricted):
												// Quiz is locked if user is not logged in OR if all topics in chapter are not completed
												$quiz_locked = !is_user_logged_in();
												if ($user_id && !empty($chapter_topics)) {
													$all_topics_completed = vested_academy_are_all_topics_completed($user_id, $chapter['id'], $chapter_topics);
													$quiz_locked = !$all_topics_completed;
												}
												$quiz_active = ($is_current && $show_quiz);

												// Build quiz URL - remove topic parameter and add quiz parameter
												$quiz_base_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake', 'mark_completed', 'prev_topic'), get_permalink($chapter['id']));
												$quiz_url = add_query_arg('quiz', '1', $quiz_base_url);
												
												// Add completion flag if user is viewing a topic in this chapter
												// Mark current topic as completed when clicking quiz from sidebar
												if (
													$user_id &&
													$is_current &&
													$current_topic_index !== null &&
													$chapter['id'] == $chapter_id
												) {
													$quiz_url = add_query_arg(
														array(
															'mark_completed' => '1',
															'prev_topic' => $current_topic_index
														),
														$quiz_url
													);
												}
												
												$quiz_url .= '#quiz-content';

												// Check if quiz is completed
												$quiz_completed = false;
												if ($user_id && function_exists('vested_academy_is_quiz_completed')) {
													$quiz_completed = vested_academy_is_quiz_completed($user_id, $chapter_quiz['id']);
												}

												// Always show quiz link (don't redirect to login)
												// Don't show lock icon if user is logged in (even if quiz is locked, they can see it)
												?>
												<a href="<?php echo esc_url($quiz_url); ?>"
													class="sidebar-chapter-sub-item quiz-item <?php echo $quiz_active ? 'active' : ''; ?> <?php echo ($quiz_locked && !is_user_logged_in()) ? 'locked' : ''; ?>">
													<span class="sub-item-icon">
														<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
															xmlns="http://www.w3.org/2000/svg">
															<path
																d="M8.43839 1.2751C8.62404 1.08885 8.84462 0.94107 9.08749 0.840237C9.33036 0.739404 9.59075 0.6875 9.85372 0.6875C10.1167 0.6875 10.3771 0.739404 10.62 0.840237C10.8628 0.94107 11.0834 1.08885 11.2691 1.2751L12.194 2.20185C12.5698 2.57768 13.0795 2.78852 13.6102 2.78852H14.9201C15.183 2.78816 15.4433 2.83964 15.6861 2.94002C15.929 3.04039 16.1497 3.1877 16.3356 3.37349C16.5215 3.55928 16.6689 3.77992 16.7694 4.02276C16.8699 4.2656 16.9215 4.52587 16.9212 4.78868L16.9203 6.0986C16.9203 6.63027 17.1311 7.13902 17.507 7.51485L18.4328 8.44068C18.6189 8.62631 18.7666 8.84684 18.8673 9.08963C18.9681 9.33241 19.0199 9.59269 19.0199 9.85556C19.0199 10.1184 18.9681 10.3787 18.8673 10.6215C18.7666 10.8643 18.6189 11.0848 18.4328 11.2704L17.507 12.1954C17.1311 12.5712 16.9203 13.0808 16.9203 13.6116V14.9215C16.9207 15.1843 16.8692 15.4446 16.7688 15.6875C16.6684 15.9304 16.5211 16.1511 16.3353 16.337C16.1495 16.5229 15.9289 16.6703 15.6861 16.7707C15.4432 16.8712 15.183 16.9228 14.9201 16.9226L13.6102 16.9217C13.0786 16.9217 12.5698 17.1325 12.194 17.5084L11.2681 18.4342C11.0825 18.6203 10.862 18.768 10.6192 18.8687C10.3764 18.9695 10.1161 19.0213 9.85327 19.0213C9.5904 19.0213 9.33012 18.9695 9.08733 18.8687C8.84455 18.768 8.62402 18.6203 8.43839 18.4342L7.51347 17.5084C7.32764 17.3222 7.10688 17.1745 6.86384 17.0738C6.62081 16.9731 6.36029 16.9214 6.09722 16.9217H4.78731C4.5245 16.922 4.2642 16.8706 4.02131 16.7702C3.77842 16.6698 3.55772 16.5225 3.37185 16.3367C3.18597 16.1509 3.03856 15.9303 2.93807 15.6874C2.83758 15.4446 2.78598 15.1843 2.78622 14.9215L2.78714 13.6116C2.78714 13.0799 2.57631 12.5712 2.20047 12.1954L1.27464 11.2695C1.08853 11.0839 0.940864 10.8634 0.840113 10.6206C0.739361 10.3778 0.6875 10.1175 0.6875 9.85464C0.6875 9.59178 0.739361 9.3315 0.840113 9.08871C0.940864 8.84592 1.08853 8.6254 1.27464 8.43977L2.20047 7.51485C2.57631 7.13902 2.78714 6.62935 2.78714 6.0986V4.78868C2.78678 4.52595 2.83823 4.26572 2.93855 4.0229C3.03887 3.78007 3.18609 3.55941 3.37179 3.37355C3.55748 3.18768 3.77801 3.04026 4.02074 2.93971C4.26348 2.83917 4.52366 2.78748 4.78639 2.7876L6.09631 2.78852C6.62797 2.78852 7.13672 2.57768 7.51256 2.20185L8.43839 1.2751Z"
																stroke="#010202" stroke-width="1.375" />
															<path
																d="M8.021 7.10468C8.02092 6.8198 8.08724 6.53882 8.21469 6.28404C8.34213 6.02926 8.5272 5.80768 8.7552 5.63689C8.98321 5.46609 9.24788 5.35079 9.52822 5.30011C9.80855 5.24944 10.0968 5.26479 10.3702 5.34495C10.6436 5.42512 10.8945 5.56788 11.1031 5.76192C11.3117 5.95597 11.4721 6.19595 11.5718 6.46283C11.6715 6.7297 11.7076 7.01614 11.6772 7.2994C11.6469 7.58266 11.551 7.85495 11.3971 8.09468C10.8489 8.94718 9.85433 9.75935 9.85433 10.7713V11.2297"
																stroke="#010202" stroke-width="1.375" stroke-linecap="round" />
															<path d="M9.84619 14.4393H9.85519" stroke="#010202" stroke-width="1.83333"
																stroke-linecap="round" stroke-linejoin="round" />
														</svg>
													</span>
													<div class="sidebar-chapter-sub-item-content">
														<span class="sub-item-title">Quiz</span>
														<?php if ($quiz_locked && !is_user_logged_in()): ?>
															<span class="sub-item-lock">
																<svg width="16" height="21" viewBox="0 0 16 21" fill="none"
																	xmlns="http://www.w3.org/2000/svg">
																	<path
																		d="M2 21C1.45 21 0.979333 20.8043 0.588 20.413C0.196666 20.0217 0.000666667 19.5507 0 19V9C0 8.45 0.196 7.97933 0.588 7.588C0.98 7.19667 1.45067 7.00067 2 7H3V5C3 3.61667 3.48767 2.43767 4.463 1.463C5.43833 0.488334 6.61733 0.000667349 8 6.82594e-07C9.38267 -0.000665984 10.562 0.487001 11.538 1.463C12.514 2.439 13.0013 3.618 13 5V7H14C14.55 7 15.021 7.196 15.413 7.588C15.805 7.98 16.0007 8.45067 16 9V19C16 19.55 15.8043 20.021 15.413 20.413C15.0217 20.805 14.5507 21.0007 14 21H2ZM2 19H14V9H2V19ZM8 16C8.55 16 9.021 15.8043 9.413 15.413C9.805 15.0217 10.0007 14.5507 10 14C9.99933 13.4493 9.80367 12.9787 9.413 12.588C9.02233 12.1973 8.55133 12.0013 8 12C7.44867 11.9987 6.978 12.1947 6.588 12.588C6.198 12.9813 6.002 13.452 6 14C5.998 14.548 6.194 15.019 6.588 15.413C6.982 15.807 7.45267 16.0027 8 16ZM5 7H11V5C11 4.16667 10.7083 3.45833 10.125 2.875C9.54167 2.29167 8.83333 2 8 2C7.16667 2 6.45833 2.29167 5.875 2.875C5.29167 3.45833 5 4.16667 5 5V7Z"
																		fill="black" />
																</svg>
															</span>
														<?php endif; ?>
													</div>
													<?php if ($quiz_completed): ?>
														<span class="sub-item-check"
															style="display: block !important; visibility: visible !important;">
															<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
																xmlns="http://www.w3.org/2000/svg" style="display: block;">
																<path
																	d="M18.3334 9.2333V9.99997C18.3324 11.797 17.7505 13.5455 16.6745 14.9848C15.5986 16.4241 14.0862 17.477 12.3629 17.9866C10.6396 18.4961 8.7978 18.4349 7.11214 17.8121C5.42648 17.1894 3.98729 16.0384 3.00922 14.5309C2.03114 13.0233 1.56657 11.24 1.68481 9.4469C1.80305 7.65377 2.49775 5.94691 3.66531 4.58086C4.83288 3.21482 6.41074 2.26279 8.16357 1.86676C9.91641 1.47073 11.7503 1.65192 13.3918 2.3833M18.3334 3.33331L10.0001 11.675L7.50008 9.17498"
																	stroke="#002852" stroke-width="2" stroke-linecap="round"
																	stroke-linejoin="round" fill="none" />
															</svg>
														</span>
													<?php endif; ?>
												</a>
											<?php endif; // End quiz country check ?>
										<?php endif; // End if chapter_quiz ?>
									</div>
								</div>
								<?php
								$chapter_num++;
							endforeach;
							// Removed standalone quiz at bottom - quiz now appears within each chapter
							?>
						</div>
					</aside>

					<!-- Right Content: Chapter Content or Quiz -->
					<main class="chapter-main-content">
						<?php if ($show_quiz && $quiz_data && is_user_logged_in()): ?>
							<!-- Quiz Content Inline -->
							<div id="quiz-content" class="quiz-content-inline">
								<?php
								// Include quiz display logic
								$quiz_id = $quiz_data['id'];
								$questions = $quiz_data['questions'];
								$total_questions = $quiz_data['total_questions'];
								$passing_score = $quiz_data['passing_score'];
								$time_limit = $quiz_data['time_limit'];
								$allow_retake = $quiz_data['allow_retake'];
								$saved_answers = $quiz_data['saved_answers'];
								$previous_attempt = $quiz_data['previous_attempt'];

								// Check if retaking - if so, reset quiz state
								$is_retaking = isset($_GET['retake']) && $_GET['retake'] == '1';
								if ($is_retaking && $user_id && function_exists('vested_academy_reset_quiz_attempt')) {
									vested_academy_reset_quiz_attempt($user_id, $quiz_id);
									// Clear previous_attempt to allow quiz to be shown
									$previous_attempt = null;
									// Clear saved answers
									$saved_answers = array();
									// Remove retake parameter and redirect to clean quiz URL
									$clean_quiz_url = remove_query_arg(array('retake', 'results'), get_permalink($chapter_id));
									$clean_quiz_url = add_query_arg('quiz', '1', $clean_quiz_url) . '#quiz-content';
									wp_safe_redirect($clean_quiz_url, 302);
									exit;
								}

								// PRIORITY CHECK: If quiz is completed, show results (persist across reloads)
								// Check database for completed quiz (not just URL parameter)
								if (!$is_retaking && $user_id && function_exists('vested_academy_get_quiz_result')) {
									$quiz_result = vested_academy_get_quiz_result($user_id, $quiz_id);
									if ($quiz_result && $quiz_result->status === 'completed') {
										// Quiz is completed - show results view
										$previous_attempt = $quiz_result;
										$show_quiz_results = true;
									}
								}

								// Check if showing results (from URL or from database check above)
								if ($show_quiz_results) {
									// Get latest attempt if not already loaded
									if (!$previous_attempt && $user_id) {
										global $wpdb;
										$table_name = $wpdb->prefix . 'academy_progress';
										$previous_attempt = $wpdb->get_row($wpdb->prepare(
											"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
											$user_id,
											$quiz_id
										));
									}

									if ($previous_attempt) {
										// Show quiz results - set variables for template
										$quiz_id_for_results = $quiz_id;
										$chapter_id_for_results = $chapter_id; // Pass chapter_id for retake URL
										$previous_attempt_for_results = $previous_attempt;
										$passing_score_for_results = $passing_score;
										$total_questions_for_results = $total_questions;
										$module_id_for_results = $module_id;
										$allow_retake_for_results = $allow_retake;
										include locate_template('template-parts/quiz/quiz-results.php');
									} else {
										// No attempt found, show quiz questions
										// Validate question index bounds
										if ($quiz_current_question < 0) {
											$quiz_current_question = 0;
										}
										if ($quiz_current_question >= $total_questions && $total_questions > 0) {
											$quiz_current_question = $total_questions - 1;
										}

										// Get the current question - use the index from URL
										$current_q = null;
										if (isset($questions[$quiz_current_question])) {
											$current_q = $questions[$quiz_current_question];
										} elseif (!empty($questions)) {
											// Fallback to first question if index is invalid
											$current_q = $questions[0];
											$quiz_current_question = 0; // Reset to first question
										}
										if ($current_q) {
											$question_text = isset($current_q['question']) ? $current_q['question'] : '';
											$options = isset($current_q['options']) ? $current_q['options'] : array();
											$saved_answer = isset($saved_answers[$quiz_current_question]) ? $saved_answers[$quiz_current_question] : '';
											?>
											<div class="quiz-questions-container">
												<div class="quiz-question-wrapper"
													data-question-index="<?php echo esc_attr($quiz_current_question); ?>">
													<div class="quiz-question-header">
														<h2 class="quiz-title">Quiz <?php echo esc_html($quiz_current_question + 1); ?>
														</h2>
													</div>

													<div class="quiz-question-content">
														<h3 class="question-text"><?php echo esc_html($question_text); ?></h3>
														<p class="question-instruction">Choose only 1 answer</p>

														<div class="question-options">
															<?php
															if (!empty($options)) {
																foreach ($options as $option_index => $option):
																	$option_value = is_array($option) ? (isset($option['value']) ? $option['value'] : $option_index) : $option;
																	$option_label = is_array($option) ? (isset($option['label']) ? $option['label'] : $option_value) : $option;
																	$is_selected = ($saved_answer === $option_value);
																	?>
																	<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>"
																		data-option-value="<?php echo esc_attr($option_value); ?>">
																		<input type="radio"
																			name="question_<?php echo esc_attr($quiz_current_question); ?>"
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
																class="progress-text"><?php echo esc_html($quiz_current_question + 1); ?>/<?php echo esc_html($total_questions); ?></span>
															<div class="progress-bar">
																<div class="progress-fill"
																	style="width: <?php echo esc_attr((($quiz_current_question + 1) / $total_questions) * 100); ?>%">
																</div>
															</div>
														</div>

														<div class="quiz-buttons">
															<?php
															// Build navigation URLs - remove topic parameter and preserve quiz parameters
															$base_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), get_permalink($chapter_id));
															$prev_q = max(0, $quiz_current_question - 1);
															$next_q = min($total_questions - 1, $quiz_current_question + 1);

															$prev_url = add_query_arg(array('quiz' => '1', 'q' => $prev_q), $base_url) . '#quiz-content';
															$next_url = add_query_arg(array('quiz' => '1', 'q' => $next_q), $base_url) . '#quiz-content';
															$skip_url = add_query_arg(array('quiz' => '1', 'q' => $next_q), $base_url) . '#quiz-content';
															?>
															<?php if ($quiz_current_question > 0): ?>
																<a href="<?php echo esc_url($prev_url); ?>" class="quiz-btn quiz-prev-btn"
																	data-question-index="<?php echo esc_attr($prev_q); ?>">Previous</a>
															<?php endif; ?>

															<!-- Hidden Skip button (kept for future use) -->
															<a href="<?php echo esc_url($skip_url); ?>" class="quiz-btn quiz-skip-btn"
																style="display:none;"
																data-question-index="<?php echo esc_attr($next_q); ?>">Skip</a>

															<?php if ($quiz_current_question < $total_questions - 1): ?>
																<a href="<?php echo esc_url($next_url); ?>" class="quiz-btn quiz-next-btn"
																	data-question-index="<?php echo esc_attr($next_q); ?>">Next</a>
															<?php else: ?>
																<button type="button" class="quiz-btn quiz-submit-btn"
																	id="quiz-final-submit">Submit Quiz</button>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
											<?php
										}
									}
								} elseif ($previous_attempt && $previous_attempt->status === 'completed' && !$allow_retake) {
									// Quiz completed, no retake allowed - set variables for template
									$module_id_for_completed = $module_id;
									include locate_template('template-parts/quiz/quiz-completed.php');
								} elseif (!empty($questions)) {
									// Check if quiz is completed (persist check - even without URL parameter)
									// This ensures results show on page reload
									$should_show_results = false;
									if (!$is_retaking && $user_id && function_exists('vested_academy_is_quiz_completed')) {
										$is_quiz_completed = vested_academy_is_quiz_completed($user_id, $quiz_id);
										if ($is_quiz_completed) {
											// Quiz is completed - get result and show results view
											$quiz_result = vested_academy_get_quiz_result($user_id, $quiz_id);
											if ($quiz_result) {
												$should_show_results = true;
												$quiz_id_for_results = $quiz_id;
												$chapter_id_for_results = $chapter_id;
												$previous_attempt_for_results = $quiz_result;
												$passing_score_for_results = $passing_score;
												$total_questions_for_results = $total_questions;
												$module_id_for_results = $module_id;
												$allow_retake_for_results = $allow_retake;
											}
										}
									}

									// Show results if quiz is completed, otherwise show questions
									if ($should_show_results) {
										// Quiz is completed - show results view (blocks access to questions)
										include locate_template('template-parts/quiz/quiz-results.php');
									} else {
										// Quiz not completed - show questions
										// Validate question index bounds
										if ($quiz_current_question < 0) {
											$quiz_current_question = 0;
										}
										if ($quiz_current_question >= $total_questions && $total_questions > 0) {
											$quiz_current_question = $total_questions - 1;
										}

										// Show quiz questions - use the index from URL
										$current_q = null;
										if (isset($questions[$quiz_current_question])) {
											$current_q = $questions[$quiz_current_question];
										} elseif (!empty($questions)) {
											// Fallback to first question if index is invalid
											$current_q = $questions[0];
											$quiz_current_question = 0; // Reset to first question
										}
										
										if ($current_q) {
											$question_text = isset($current_q['question']) ? $current_q['question'] : '';
											$options = isset($current_q['options']) ? $current_q['options'] : array();
											$saved_answer = isset($saved_answers[$quiz_current_question]) ? $saved_answers[$quiz_current_question] : '';
											?>
											<div class="quiz-questions-container">
												<div class="quiz-question-wrapper"
													data-question-index="<?php echo esc_attr($quiz_current_question); ?>">
													<div class="quiz-question-header">
														<h2 class="quiz-title">Quiz <?php echo esc_html($quiz_current_question + 1); ?>
														</h2>
													</div>

													<div class="quiz-question-content">
														<h3 class="question-text"><?php echo esc_html($question_text); ?></h3>
														<p class="question-instruction">Choose only 1 answer</p>

														<div class="question-options">
															<?php
															if (!empty($options)) {
																foreach ($options as $option_index => $option):
																	$option_value = is_array($option) ? (isset($option['value']) ? $option['value'] : $option_index) : $option;
																	$option_label = is_array($option) ? (isset($option['label']) ? $option['label'] : $option_value) : $option;
																	$is_selected = ($saved_answer === $option_value);
																	?>
																	<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>"
																		data-option-value="<?php echo esc_attr($option_value); ?>">
																		<input type="radio"
																			name="question_<?php echo esc_attr($quiz_current_question); ?>"
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
																class="progress-text"><?php echo esc_html($quiz_current_question + 1); ?>/<?php echo esc_html($total_questions); ?></span>
															<div class="progress-bar">
																<div class="progress-fill"
																	style="width: <?php echo esc_attr((($quiz_current_question + 1) / $total_questions) * 100); ?>%">
																</div>
															</div>
														</div>

														<div class="quiz-buttons">
															<?php
															// Build navigation URLs - remove topic parameter and preserve quiz parameters
															$base_url_2 = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), get_permalink($chapter_id));
															$prev_q_2 = max(0, $quiz_current_question - 1);
															$next_q_2 = min($total_questions - 1, $quiz_current_question + 1);

															$prev_url_2 = add_query_arg(array('quiz' => '1', 'q' => $prev_q_2), $base_url_2) . '#quiz-content';
															$next_url_2 = add_query_arg(array('quiz' => '1', 'q' => $next_q_2), $base_url_2) . '#quiz-content';
															$skip_url_2 = add_query_arg(array('quiz' => '1', 'q' => $next_q_2), $base_url_2) . '#quiz-content';
															?>
															<?php if ($quiz_current_question > 0): ?>
																<a href="<?php echo esc_url($prev_url_2); ?>" class="quiz-btn quiz-prev-btn"
																	data-question-index="<?php echo esc_attr($prev_q_2); ?>">Previous</a>
															<?php endif; ?>

															<!-- Hidden Skip button (kept for future use) -->
															<a href="<?php echo esc_url($skip_url_2); ?>" class="quiz-btn quiz-skip-btn"
																style="display:none;"
																data-question-index="<?php echo esc_attr($next_q_2); ?>">Skip</a>

															<?php if ($quiz_current_question < $total_questions - 1): ?>
																<a href="<?php echo esc_url($next_url_2); ?>" class="quiz-btn quiz-next-btn"
																	data-question-index="<?php echo esc_attr($next_q_2); ?>">Next</a>
															<?php else: ?>
																<button type="button" class="quiz-btn quiz-submit-btn"
																	id="quiz-final-submit">Submit Quiz</button>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
											<?php
										} else { ?>
											<div class="quiz-no-questions">
												<p>No questions have been configured for this quiz yet. Please contact the administrator.
												</p>
											</div>
										<?php }
									} // End else block for showing questions
								} // End elseif (!empty($questions))
							?>
							</div>
						<?php elseif ($show_quiz && (!is_user_logged_in() || ($user_id && !empty($current_chapter_topics) && !vested_academy_are_all_topics_completed($user_id, $chapter_id, $current_chapter_topics)))): ?>
							<!-- Quiz Locked -->
							<div id="quiz-content" class="quiz-locked-inline">
								<div class="quiz-locked-card">
									<div class="lock-icon-large">
										<svg width="101" height="101" viewBox="0 0 101 101" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M73.6114 68.2086C70.9677 68.2086 68.8245 66.0654 68.8245 63.4217V35.5471C68.8245 26.1524 61.1812 18.5089 51.7863 18.5089C42.3916 18.5089 34.7482 26.1522 34.7482 35.5471V51.7595C34.7482 54.4033 32.605 56.5465 29.9612 56.5465C27.3175 56.5465 25.1743 54.4033 25.1743 51.7595V35.5471C25.1743 20.8731 37.1123 8.93506 51.7863 8.93506C66.4603 8.93506 78.3984 20.8731 78.3984 35.5471V63.4217C78.3984 66.0654 76.2552 68.2086 73.6114 68.2086Z"
												fill="#B1B4B5" />
											<path
												d="M80.9091 97.1957H22.6575C17.2189 97.1957 12.8101 92.7868 12.8101 87.3483V53.6702C12.8101 48.2316 17.2189 43.8228 22.6575 43.8228H80.9091C86.3477 43.8228 90.7566 48.2316 90.7566 53.6702V87.3481C90.7566 92.7868 86.3477 97.1957 80.9091 97.1957Z"
												fill="#FFB636" />
											<path
												d="M21.3557 89.2602H20.8624C19.3085 89.2602 18.0488 88.0005 18.0488 86.4466V54.5731C18.0488 53.0192 19.3085 51.7595 20.8624 51.7595H21.3557C22.9096 51.7595 24.1693 53.0192 24.1693 54.5731V86.4466C24.1693 88.0005 22.9096 89.2602 21.3557 89.2602Z"
												fill="#FFD469" />
										</svg>
									</div>
									<h2 class="quiz-locked-title">This quiz is locked</h2>
									<?php if (!is_user_logged_in()): ?>
										<div class="quiz-locked-actions">
											<a href="<?php echo esc_url(home_url('/academy/login')); ?>"
												class="btn-login-link">Login to take quiz</a>
										</div>
									<?php else: ?>
										<p class="quiz-locked-message">Please complete all topics in this chapter to unlock the
											quiz.</p>
									<?php endif; ?>
								</div>
							</div>
						<?php else: ?>
							<!-- Chapter Content or Topic Content -->
							<div class="chapter-content-card">
								<?php if ($current_topic): ?>
									<!-- Display Topic Content -->
									<h2 class="chapter-content-title">
										<?php echo esc_html(isset($current_topic['topic_title']) ? $current_topic['topic_title'] : 'Topic'); ?>
									</h2>

									<div class="chapter-content-body single-module-post-content">
										<?php
										// Display topic content
										if (isset($current_topic['topic_content'])) {
											echo wp_kses_post($current_topic['topic_content']);
										} else {
											echo '<p>Topic content not available.</p>';
										}
										?>
									</div>
								<?php else: ?>
									<!-- Display Chapter Content (fallback if no topics or no topic selected) -->
									<h2 class="chapter-content-title"><?php the_title(); ?></h2>

									<div class="chapter-content-body single-module-post-content">
										<?php if (get_field('heading_notes')): ?>
											<div class="heading-note">
												<?php the_field('heading_notes'); ?>
											</div>
										<?php endif; ?>

										<?php the_content(); ?>

										<?php if (get_field('takeaways')): ?>
											<div class="chapter-takeaways">
												<h3>Key Takeaways</h3>
												<?php the_field('takeaways'); ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<!-- Navigation Buttons -->
								<div class="chapter-navigation">
									<?php if ($current_topic): ?>
										<!-- Topic-based navigation -->
										<?php if ($prev_topic): ?>
											<a href="<?php echo esc_url($prev_topic['url']); ?>" class="chapter-nav-btn prev-btn">
												Previous Topic
											</a>
										<?php else: ?>
											<span class="chapter-nav-spacer"></span>
										<?php endif; ?>

										<?php
										// Check if this is the last topic in the chapter
										$is_last_topic = false;
										if ($current_topic_index !== null && !empty($current_chapter_topics)) {
											$is_last_topic = ($current_topic_index === count($current_chapter_topics) - 1);
										} elseif ($current_topic && !empty($current_chapter_topics)) {
											// Fallback: check if current topic is the last one by comparing
											$last_topic = end($current_chapter_topics);
											if (isset($current_topic['topic_slug']) && isset($last_topic['topic_slug'])) {
												$is_last_topic = ($current_topic['topic_slug'] === $last_topic['topic_slug']);
											} elseif (isset($current_topic['topic_title']) && isset($last_topic['topic_title'])) {
												$is_last_topic = ($current_topic['topic_title'] === $last_topic['topic_title']);
											}
										}

										// Check if chapter has quiz
										$chapter_has_quiz = ($quiz && !empty($quiz));

										// Priority: If last topic, go to quiz; otherwise go to next topic
										if ($is_last_topic && $chapter_has_quiz):
											// Build quiz URL - remove topic parameter and add quiz parameter
											$quiz_base_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake', 'mark_completed', 'prev_topic'), get_permalink($chapter_id));
											$quiz_url = add_query_arg('quiz', '1', $quiz_base_url);
											// Add flag for completion tracking
											$quiz_url = add_query_arg(array('mark_completed' => '1', 'prev_topic' => $current_topic_index), $quiz_url);
											$quiz_url .= '#quiz-content';
											?>
											<a href="<?php echo esc_url($quiz_url); ?>" class="chapter-nav-btn next-btn quiz-btn">
												Take Quiz
											</a>
										<?php elseif ($next_topic): ?>
											<?php
											// Add flag to next topic URL for completion tracking
											$next_topic_url_with_flag = add_query_arg(array('mark_completed' => '1', 'prev_topic' => $current_topic_index), $next_topic['url']);
											?>
											<a href="<?php echo esc_url($next_topic_url_with_flag); ?>" class="chapter-nav-btn next-btn">
												Next Topic
											</a>
										<?php else: ?>
											<span class="chapter-nav-spacer"></span>
										<?php endif; ?>
									<?php else: ?>
										<!-- Chapter-based navigation (fallback) -->
										<?php if ($prev_chapter): ?>
											<a href="<?php echo esc_url($prev_chapter['url']); ?>" class="chapter-nav-btn prev-btn">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2"
														stroke-linecap="round" stroke-linejoin="round" />
												</svg>
												Previous Chapter
											</a>
										<?php else: ?>
											<span class="chapter-nav-spacer"></span>
										<?php endif; ?>

										<?php
										// Check if current chapter has a quiz
										$current_chapter_quiz = null;
										if ($quiz && is_user_logged_in()) {
											// Build quiz URL - remove topic parameter and add quiz parameter
											$quiz_base_url = remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake', 'mark_completed', 'prev_topic'), get_permalink($chapter_id));
											$quiz_url_with_flag = add_query_arg('quiz', '1', $quiz_base_url);
											// Add flag for completion tracking (if we have a current topic)
											if ($current_topic_index !== null) {
												$quiz_url_with_flag = add_query_arg(array('mark_completed' => '1', 'prev_topic' => $current_topic_index), $quiz_url_with_flag);
											}
											$current_chapter_quiz = array(
												'url' => $quiz_url_with_flag . '#quiz-content',
											);
										}

										// Priority: If quiz exists, go to quiz; otherwise go to next chapter
										if ($current_chapter_quiz): ?>
											<a href="<?php echo esc_url($current_chapter_quiz['url']); ?>"
												class="chapter-nav-btn next-btn quiz-btn">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2"
														stroke-linecap="round" stroke-linejoin="round" />
												</svg>
											</a>
										<?php elseif ($next_chapter): ?>
											<?php
											// Add flag to next chapter URL if we have a current topic
											$next_chapter_url = $next_chapter['url'];
											if ($current_topic_index !== null) {
												$next_chapter_url = add_query_arg(array('mark_completed' => '1', 'prev_topic' => $current_topic_index), $next_chapter_url);
											}
											?>
											<a href="<?php echo esc_url($next_chapter_url); ?>" class="chapter-nav-btn next-btn">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none"
													xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2"
														stroke-linecap="round" stroke-linejoin="round" />
												</svg>
											</a>
										<?php else: ?>
											<span class="chapter-nav-spacer"></span>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</main>
				</div>
			</div>
		</div>

		<!-- FAQ Section -->
		<section class="academy-faq-section">
			<div class="container">
				<div class="faq-header">
					<h2 class="faq-title">FAQ's</h2>
					<p class="faq-subtitle">Have questions about studying stock market?</p>
				</div>

				<div class="faq-accordion">
					<div class="faq-item active">
						<div class="faq-question">
							<span class="faq-question-text">Is this software scalable for growing businesses?</span>
							<span class="faq-toggle-icon">−</span>
						</div>
						<div class="faq-answer">
							<p>Absolutely. This software is designed to grow with your business. You can easily upgrade your
								plan as your needs change at your own observation.</p>
						</div>
					</div>

					<div class="faq-item">
						<div class="faq-question">
							<span class="faq-question-text">Is this software scalable for growing businesses?</span>
							<span class="faq-toggle-icon">+</span>
						</div>
						<div class="faq-answer" style="display: none;">
							<p>Absolutely. This software is designed to grow with your business. You can easily upgrade your
								plan as your needs change at your own observation.</p>
						</div>
					</div>

					<div class="faq-item">
						<div class="faq-question">
							<span class="faq-question-text">Is this software scalable for growing businesses?</span>
							<span class="faq-toggle-icon">+</span>
						</div>
						<div class="faq-answer" style="display: none;">
							<p>Absolutely. This software is designed to grow with your business. You can easily upgrade your
								plan as your needs change at your own observation.</p>
						</div>
					</div>

					<div class="faq-item">
						<div class="faq-question">
							<span class="faq-question-text">Is this software scalable for growing businesses?</span>
							<span class="faq-toggle-icon">+</span>
						</div>
						<div class="faq-answer" style="display: none;">
							<p>Absolutely. This software is designed to grow with your business. You can easily upgrade your
								plan as your needs change at your own observation.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Download App Section -->
		<section class="academy-download-section">
			<div class="container">
				<div class="download-content-wrapper">
					<div class="download-visual-column">
						<div class="download-mobile-mockup">
							<img src="<?php echo esc_url(content_url('/uploads/2025/12/app-download-mockup.png')); ?>"
								alt="Vested App">
						</div>
					</div>

					<div class="download-text-column">
						<h2 class="download-title">Download the vested app to get started</h2>
						<p class="download-description">
							Sign up to our regular newsletter for news, insights, new product releases & more.
						</p>

						<div class="download-buttons">
							<a href="https://play.google.com/store/apps" target="_blank" class="download-button">
								<img src="<?php echo esc_url(content_url('/uploads/2025/12/playstore-icon.svg')); ?>"
									alt="Get on Playstore">
								Get on Playstore
							</a>
							<a href="https://apps.apple.com" target="_blank" class="download-button">
								<img src="<?php echo esc_url(content_url('/uploads/2025/12/appstore-icon.svg')); ?>"
									alt="Get on Appstore">
								Get on Appstore
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script>
		// Global variables for topic completion management
		var academyModuleId = <?php echo esc_js($module_id); ?>;
		var academyChapterId = <?php echo esc_js($chapter_id); ?>;
		var academyCurrentTopicIndex = <?php echo $current_topic_index !== null ? esc_js($current_topic_index) : 'null'; ?>;

		// Track chapter/topic progress on scroll (optimized with throttling and debouncing)
		<?php if ($user_id && !$show_quiz): ?>
			document.addEventListener('DOMContentLoaded', function () {
				var chapterId = <?php echo esc_js($chapter_id); ?>;
				var moduleId = <?php echo esc_js($module_id); ?>;
				var topicIndex = <?php echo $current_topic_index !== null ? esc_js($current_topic_index) : 'null'; ?>;

				// Note: Completion state is only set when user clicks "Next Topic" or "Take Quiz"
				// Not automatically on page load - user must explicitly navigate forward

				var scrollProgress = 0;
				var lastProgress = 0;
				var lastUpdateTime = 0;
				var updateThrottle = 2000; // Only update every 2 seconds max
				var pendingUpdate = null;
				var isUpdating = false;

				// Throttled scroll handler
				function handleScroll() {
					var windowHeight = window.innerHeight;
					var documentHeight = document.documentElement.scrollHeight;
					var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

					scrollProgress = Math.round((scrollTop / (documentHeight - windowHeight)) * 100);

					// Clamp progress between 0 and 100
					scrollProgress = Math.max(0, Math.min(100, scrollProgress));

					var now = Date.now();
					var shouldUpdate = false;
					var forceCompletion = false;

					// Update if progress changed by 10% OR if 2 seconds passed since last update
					if (Math.abs(scrollProgress - lastProgress) >= 10) {
						shouldUpdate = true;
					} else if (now - lastUpdateTime >= updateThrottle && scrollProgress !== lastProgress) {
						shouldUpdate = true;
					}

					// Mark completion at 90%+ (only once, consolidate logic)
					if (scrollProgress >= 90 && lastProgress < 90) {
						shouldUpdate = true;
						forceCompletion = true;
						scrollProgress = 100; // Force to 100% for completion
					}

					if (shouldUpdate && !isUpdating) {
						// Clear any pending update
						if (pendingUpdate) {
							clearTimeout(pendingUpdate);
							pendingUpdate = null;
						}

						// Debounce: wait 500ms before sending (in case user is still scrolling)
						pendingUpdate = setTimeout(function () {
							if (isUpdating) return; // Prevent duplicate calls

							isUpdating = true;
							lastProgress = scrollProgress;
							lastUpdateTime = Date.now();

							var ajaxData = {
								action: 'academy_update_progress',
								chapter_id: chapterId,
								module_id: moduleId,
								progress: scrollProgress,
								nonce: academyAjax.nonce
							};

							if (topicIndex !== null) {
								ajaxData.topic_index = topicIndex;
							}

							jQuery.ajax({
								url: academyAjax.ajaxurl,
								type: 'POST',
								data: ajaxData,
								timeout: 5000,
								success: function (response) {
									isUpdating = false;
								},
								error: function (xhr, status, error) {
									isUpdating = false;

									// Retry once after 1 second if not a timeout
									if (status !== 'timeout') {
										setTimeout(function () {
											if (!isUpdating) {
												jQuery.ajax({
													url: academyAjax.ajaxurl,
													type: 'POST',
													data: ajaxData,
													timeout: 5000
												});
											}
										}, 1000);
									}
								}
							});

							pendingUpdate = null;
						}, 500);
					}
				}

				// Use requestAnimationFrame for smooth performance
				var ticking = false;
				window.addEventListener('scroll', function () {
					if (!ticking) {
						window.requestAnimationFrame(function () {
							handleScroll();
							ticking = false;
						});
						ticking = true;
					}
				});

				// Send final update on page unload (beacon API if available, otherwise sync AJAX)
				window.addEventListener('beforeunload', function () {
					if (pendingUpdate || (scrollProgress > lastProgress && scrollProgress > 0)) {
						// Use sendBeacon if available (more reliable for unload)
						if (navigator.sendBeacon) {
							var formData = new FormData();
							formData.append('action', 'academy_update_progress');
							formData.append('chapter_id', chapterId);
							formData.append('module_id', moduleId);
							formData.append('progress', scrollProgress);
							formData.append('nonce', academyAjax.nonce);
							if (topicIndex !== null) {
								formData.append('topic_index', topicIndex);
							}
							navigator.sendBeacon(academyAjax.ajaxurl, formData);
						} else {
							// Fallback to synchronous AJAX
							jQuery.ajax({
								url: academyAjax.ajaxurl,
								type: 'POST',
								async: false,
								data: {
									action: 'academy_update_progress',
									chapter_id: chapterId,
									module_id: moduleId,
									progress: scrollProgress,
									topic_index: topicIndex,
									nonce: academyAjax.nonce
								}
							});
						}
					}
				});
			});
		<?php endif; ?>

		// Function to mark chapter as complete (called when user clicks Next button)
		function vestedAcademyMarkChapterComplete(chapterId, moduleId) {
			if (typeof academyAjax !== 'undefined') {
				jQuery.ajax({
					url: academyAjax.ajaxurl,
					type: 'POST',
					data: {
						action: 'academy_update_progress',
						chapter_id: chapterId,
						module_id: moduleId,
						progress: 100, // Mark as 100% complete
						nonce: academyAjax.nonce
					},
					success: function (response) {
						// Chapter marked as completed
					},
					error: function (xhr, status, error) {
						// Error marking chapter complete
					}
				});
			}
		}

		// Function to update topic completion state in sidebar (instant UI update)
		function vestedAcademyUpdateTopicCompletion(chapterId, topicIndex, isCompleted) {
			// Find the specific topic item by data attributes (most reliable)
			var $topicItem = jQuery('.sidebar-chapter-sub-item[data-chapter-id="' + chapterId + '"][data-topic-index="' + topicIndex + '"]');

			if ($topicItem.length) {
				if (isCompleted) {
					$topicItem.addClass('completed');
					$topicItem.find('.sub-item-icon').addClass('completed-icon');

					// Add completed icon if not present
					if ($topicItem.find('.sub-item-check').length === 0) {
						var checkIcon = '<span class="sub-item-check" style="display: block !important; visibility: visible !important;"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: block;"><path d="M18.3334 9.2333V9.99997C18.3324 11.797 17.7505 13.5455 16.6745 14.9848C15.5986 16.4241 14.0862 17.477 12.3629 17.9866C10.6396 18.4961 8.7978 18.4349 7.11214 17.8121C5.42648 17.1894 3.98729 16.0384 3.00922 14.5309C2.03114 13.0233 1.56657 11.24 1.68481 9.4469C1.80305 7.65377 2.49775 5.94691 3.66531 4.58086C4.83288 3.21482 6.41074 2.26279 8.16357 1.86676C9.91641 1.47073 11.7503 1.65192 13.3918 2.3833M18.3334 3.33331L10.0001 11.675L7.50008 9.17498" stroke="#002852" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg></span>';
						$topicItem.append(checkIcon);
					}

					// Update icon to completed version
					var $icon = $topicItem.find('.sub-item-icon');
					if ($icon.length && !$icon.find('path[fill="#002852"]').length) {
						// Replace icon SVG with completed version
						var completedIcon = '<svg width="19" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.73055 2.23889C3.18224 2.28566 2.25982 2.4578 1.62099 3.09663C0.746338 3.97228 0.746338 5.38029 0.746338 8.1973V14.6712C0.746338 17.4892 0.746338 18.8972 1.62099 19.7728C2.49466 20.6475 3.90266 20.6475 6.71669 20.6475H11.692C14.507 20.6475 15.914 20.6475 16.7877 19.7718C17.6633 18.8972 17.6633 17.4892 17.6633 14.6712V8.1973C17.6633 5.38129 17.6633 3.97228 16.7877 3.09663C16.1498 2.4578 15.2264 2.28566 13.6781 2.23889" stroke="#002852" stroke-width="1.49259" fill="#002852" fill-opacity="0.1"/><path d="M4.72681 2.48769C4.72681 1.52646 5.50693 0.746338 6.46816 0.746338H11.941C12.4028 0.746338 12.8457 0.929801 13.1723 1.25637C13.4989 1.58294 13.6823 2.02586 13.6823 2.48769C13.6823 2.94953 13.4989 3.39245 13.1723 3.71901C12.8457 4.04558 12.4028 4.22904 11.941 4.22904H6.46816C6.00632 4.22904 5.5634 4.04558 5.23684 3.71901C4.91027 3.39245 4.72681 2.94953 4.72681 2.48769Z" stroke="#002852" stroke-width="1.49259" stroke-linejoin="round" fill="#002852" fill-opacity="0.1"/><path d="M3.7356 8.7074H7.71583" stroke="#002852" stroke-width="1.49259" stroke-linecap="round"/><path d="M10.7004 9.7013C10.7004 9.7013 11.198 9.7013 11.6955 10.6964C11.6955 10.6964 13.2757 8.20871 14.6807 7.71118" stroke="#002852" stroke-width="1.49259" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.7356 14.6777H7.71583" stroke="#002852" stroke-width="1.49259" stroke-linecap="round"/><path d="M10.7004 15.6716C10.7004 15.6716 11.198 15.6716 11.6955 16.6667C11.6955 16.6667 13.2757 14.179 14.6807 13.6815" stroke="#002852" stroke-width="1.49259" stroke-linecap="round" stroke-linejoin="round"/></svg>';
						$icon.html(completedIcon);
					}
				} else {
					$topicItem.removeClass('completed');
					$topicItem.find('.sub-item-icon').removeClass('completed-icon');
					$topicItem.find('.sub-item-check').remove();
				}
			}
		}

		// Function to mark topic as complete (called when user clicks Next Topic button)
		// Uses optimistic UI updates for instant feedback
		function vestedAcademyMarkTopicComplete(chapterId, topicIndex, moduleId, event) {
			if (!event) {
				return true;
			}

			event.preventDefault();
			event.stopPropagation();

			var targetUrl = event.target.href || (event.target.closest('a') ? event.target.closest('a').href : null);

			// INSTANT UI UPDATE - Mark current topic as completed immediately
			vestedAcademyUpdateTopicCompletion(chapterId, topicIndex, true);

			// Check if this is a quiz button (navigating to quiz)
			var isQuizButton = event.target.closest('a.quiz-btn') !== null;

			// Fire AJAX to save completion state
			// For quiz navigation, we want to ensure it's saved before navigating
			if (typeof academyAjax !== 'undefined') {
				// Use sendBeacon for quiz navigation to ensure it's sent even if page unloads
				if (isQuizButton && navigator.sendBeacon) {
					var formData = new FormData();
					formData.append('action', 'academy_update_progress');
					formData.append('chapter_id', chapterId);
					formData.append('topic_index', topicIndex);
					if (moduleId) {
						formData.append('module_id', moduleId);
					}
					formData.append('progress', 100);
					formData.append('nonce', academyAjax.nonce);

					// Send via beacon to ensure it completes even during page unload
					navigator.sendBeacon(academyAjax.ajaxurl, formData);

					// Also send regular AJAX as backup
					jQuery.ajax({
						url: academyAjax.ajaxurl,
						type: 'POST',
						data: {
							action: 'academy_update_progress',
							chapter_id: chapterId,
							topic_index: topicIndex,
							module_id: moduleId,
							progress: 100,
							nonce: academyAjax.nonce
						},
						async: false // Synchronous for quiz to ensure it completes
					});
				} else {
					// Regular AJAX for non-quiz navigation
					jQuery.ajax({
						url: academyAjax.ajaxurl,
						type: 'POST',
						data: {
							action: 'academy_update_progress',
							chapter_id: chapterId,
							topic_index: topicIndex,
							module_id: moduleId,
							progress: 100,
							nonce: academyAjax.nonce
						},
						success: function (response) {
							// Success - state already updated optimistically
						},
						error: function (xhr, status, error) {
							// On error, revert the optimistic update
							vestedAcademyUpdateTopicCompletion(chapterId, topicIndex, false);
						}
					});
				}
			}

			// Small delay for quiz to ensure UI update is visible and state is saved
			if (isQuizButton) {
				setTimeout(function () {
					if (targetUrl) {
						window.location.href = targetUrl;
					}
				}, 100); // 100ms delay to ensure state is saved
			} else {
				// Navigate immediately for regular topic navigation
				if (targetUrl) {
					window.location.href = targetUrl;
				}
			}

			return false; // Prevent default navigation
		}

		// Chapter sidebar toggle functionality
		document.addEventListener('DOMContentLoaded', function () {
			// Reusable function to toggle chapter expand/collapse
			function toggleChapter(chapterItem) {
				const chapterContent = chapterItem.querySelector('.sidebar-chapter-content');
				const isCurrentlyExpanded = chapterItem.classList.contains('expanded');

				// Close all other chapters first (only one open at a time)
				document.querySelectorAll('.sidebar-chapter-item').forEach(function (item) {
					if (item !== chapterItem) {
						item.classList.remove('expanded');
						const content = item.querySelector('.sidebar-chapter-content');
						if (content) {
							content.style.display = 'none';
						}
					}
				});

				// Toggle current chapter
				if (isCurrentlyExpanded) {
					// Collapse
					chapterItem.classList.remove('expanded');
					if (chapterContent) {
						chapterContent.style.display = 'none';
					}
				} else {
					// Expand
					chapterItem.classList.add('expanded');
					if (chapterContent) {
						chapterContent.style.display = 'block';
					}
				}
			}

			// Toggle button functionality
			const chapterToggles = document.querySelectorAll('.chapter-toggle');
			chapterToggles.forEach(function (toggle) {
				toggle.addEventListener('click', function (e) {
					e.preventDefault();
					e.stopPropagation();

					const chapterItem = this.closest('.sidebar-chapter-item');
					if (chapterItem) {
						toggleChapter(chapterItem);
					}
				});
			});

			// Chapter label link functionality - toggle instead of navigate
			const chapterLabelLinks = document.querySelectorAll('.chapter-label-link');
			chapterLabelLinks.forEach(function (link) {
				link.addEventListener('click', function (e) {
					e.preventDefault();
					e.stopPropagation();

					const chapterItem = this.closest('.sidebar-chapter-item');
					if (chapterItem) {
						toggleChapter(chapterItem);
					}
				});
			});

			// Note: Sidebar topic clicks do NOT automatically mark topics as completed
			// Completion is only set when user explicitly clicks "Next Topic" or "Take Quiz"

		});

		// Quiz functionality
		<?php if ($show_quiz && $quiz_data && is_user_logged_in() && !$show_quiz_results): ?>
			var academyQuizData = {
				quizId: <?php echo esc_js($quiz_data['id']); ?>,
				chapterId: <?php echo esc_js($chapter_id); ?>,
				totalQuestions: <?php echo esc_js($quiz_data['total_questions']); ?>,
				currentQuestion: <?php echo esc_js($quiz_current_question); ?>,
				ajaxUrl: '<?php echo esc_js(admin_url('admin-ajax.php')); ?>',
				nonce: '<?php echo wp_create_nonce('academy_quiz_answer_nonce'); ?>',
				quizUrl: '<?php echo esc_js(remove_query_arg(array('topic', 'quiz', 'q', 'results', 'retake'), get_permalink($chapter_id))); ?>' // Base URL without quiz params
			};

			// Auto-save answer when user selects an option
			jQuery(document).ready(function ($) {

				// AJAX-based quiz navigation - prevent full page reload
				$(document).on('click', '.quiz-next-btn, .quiz-prev-btn', function (e) {
					e.preventDefault();

					var $button = $(this);
					var $container = $('.quiz-questions-container');

					// Prevent multiple clicks while loading
					if ($container.css('pointer-events') === 'none') {
						return false;
					}

					var questionIndex = parseInt($button.data('question-index'));

					// If data attribute not found, try to extract from href
					if (isNaN(questionIndex)) {
						var href = $button.attr('href');
						if (href) {
							var urlParams = new URLSearchParams(href.split('?')[1]);
							questionIndex = parseInt(urlParams.get('q')) || 0;
						}
					}

					if (isNaN(questionIndex)) {
						return false;
					}

					// Show loading state
					var $container = $('.quiz-questions-container');
					$container.css('opacity', '0.6').css('pointer-events', 'none');

					// Load question via AJAX
					$.ajax({
						url: academyQuizData.ajaxUrl,
						type: 'POST',
						data: {
							action: 'academy_load_quiz_question',
							nonce: academyQuizData.nonce,
							quiz_id: academyQuizData.quizId,
							chapter_id: academyQuizData.chapterId,
							question_index: questionIndex
						},
						success: function (response) {
							if (response.success) {
								// Update the question wrapper
								$container.html(response.data.html);

								// Update URL without reloading
								// Use the appropriate URL based on direction
								var newUrl = $button.hasClass('quiz-next-btn') ? response.data.next_url : response.data.prev_url;
								if (newUrl) {
									// Extract just the query string part
									var urlParts = newUrl.split('#');
									var queryPart = urlParts[0];
									window.history.pushState({ questionIndex: questionIndex }, '', queryPart + '#quiz-content');
								}

								// Scroll to top of quiz content
								var $quizContent = $('#quiz-content');
								if ($quizContent.length) {
									$('html, body').animate({
										scrollTop: $quizContent.offset().top - 100
									}, 300);
								}

								// Re-initialize radio button handlers for the new question
								initQuizHandlers();
							} else {
								// Fallback to full page reload
								window.location.href = $button.attr('href');
							}
						},
						error: function () {
							// Fallback to full page reload
							window.location.href = $button.attr('href');
						},
						complete: function () {
							// Remove loading state
							$container.css('opacity', '1').css('pointer-events', 'auto');
						}
					});

					return false;
				});

				// Handle browser back/forward buttons
				window.addEventListener('popstate', function (e) {
					if (e.state && typeof e.state.questionIndex !== 'undefined') {
						var questionIndex = e.state.questionIndex;
						// Load question via AJAX
						loadQuestion(questionIndex);
					}
				});

				// Function to load question (reusable)
				function loadQuestion(questionIndex) {
					var $container = $('.quiz-questions-container');
					$container.css('opacity', '0.6').css('pointer-events', 'none');

					$.ajax({
						url: academyQuizData.ajaxUrl,
						type: 'POST',
						data: {
							action: 'academy_load_quiz_question',
							nonce: academyQuizData.nonce,
							quiz_id: academyQuizData.quizId,
							chapter_id: academyQuizData.chapterId,
							question_index: questionIndex
						},
						success: function (response) {
							if (response.success) {
								$container.html(response.data.html);
								initQuizHandlers();
							}
						},
						complete: function () {
							$container.css('opacity', '1').css('pointer-events', 'auto');
						}
					});
				}

				// Initialize quiz handlers (for radio buttons)
				function initQuizHandlers() {
					// Remove existing handlers to avoid duplicates
					$('.option-label input[type="radio"]').off('change');

					// Re-attach handlers
					$('.option-label input[type="radio"]').on('change', function () {
						var questionIndex = $(this).closest('.quiz-question-wrapper').data('question-index');
						var selectedValue = $(this).val();
						var optionLabel = $(this).closest('.option-label');

						// Update UI
						$('.option-label').removeClass('selected');
						optionLabel.addClass('selected');

						// Auto-save answer via AJAX
						$.ajax({
							url: academyQuizData.ajaxUrl,
							type: 'POST',
							data: {
								action: 'academy_save_quiz_answer',
								nonce: academyQuizData.nonce,
								quiz_id: academyQuizData.quizId,
								question_index: questionIndex,
								user_answer: selectedValue
							},
							success: function (response) {
								// Answer saved
							},
							error: function () {
								// Failed to save answer
							}
						});
					});
				}

				// Initialize handlers on page load
				initQuizHandlers();

				// Submit quiz - use event delegation to work with dynamically loaded buttons
				$(document).on('click', '#quiz-final-submit', function (e) {
					e.preventDefault();

					// Safety check: prevent submission if quiz is already completed
					if (typeof academyQuizData !== 'undefined') {
						$.ajax({
							url: academyQuizData.ajaxUrl,
							type: 'POST',
							data: {
								action: 'academy_get_quiz_result',
								nonce: academyQuizData.nonce,
								quiz_id: academyQuizData.quizId
							},
							async: false, // Synchronous check
							success: function(response) {
								if (response.success && response.data && response.data.completed) {
									// Quiz already completed - reload page to show results
									window.location.reload();
									return false;
								}
							}
						});
					}

					var $button = $(this);

					// Disable button to prevent double submission
					$button.prop('disabled', true).text('Submitting...');

					// Collect all answers (submit directly without confirmation)
					var allAnswers = {};
					for (var i = 0; i < academyQuizData.totalQuestions; i++) {
						var answer = $('input[name="question_' + i + '"]:checked').val();
						if (answer) {
							allAnswers[i] = answer;
						}
					}

					// Submit form
					var form = $('<form>', {
						'method': 'POST',
						'action': '<?php echo esc_js(admin_url('admin-post.php')); ?>'
					});

					form.append($('<input>', {
						'type': 'hidden',
						'name': 'action',
						'value': 'academy_quiz_submit'
					}));

					form.append($('<input>', {
						'type': 'hidden',
						'name': 'nonce',
						'value': academyQuizData.nonce
					}));

					form.append($('<input>', {
						'type': 'hidden',
						'name': 'quiz_id',
						'value': academyQuizData.quizId
					}));

					form.append($('<input>', {
						'type': 'hidden',
						'name': 'chapter_id',
						'value': <?php echo esc_js($chapter_id); ?>
					}));

					$.each(allAnswers, function (index, answer) {
						form.append($('<input>', {
							'type': 'hidden',
							'name': 'question_' + index,
							'value': answer
						}));
					});

					$('body').append(form);
					form.submit();
				});
			});
		<?php endif; ?>

		// Scroll to quiz content when quiz parameter is present
		<?php if ($show_quiz): ?>
			document.addEventListener('DOMContentLoaded', function () {
				var quizContent = document.getElementById('quiz-content');
				if (quizContent) {
					setTimeout(function () {
						quizContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
					}, 100);
				}
			});
		<?php endif; ?>

		// Retake Quiz button handler (works on results page)
		jQuery(document).ready(function ($) {
			$('.quiz-retake-btn').on('click', function (e) {
				var href = $(this).attr('href');
				if (href && href !== '#' && href !== '') {
					// Navigate directly
					window.location.href = href;
					return false; // Prevent any other handlers
				}
			});
		});

		// FAQ Accordion
		document.addEventListener('DOMContentLoaded', function () {
			const faqItems = document.querySelectorAll('.faq-item');

			faqItems.forEach(item => {
				const question = item.querySelector('.faq-question');
				const answer = item.querySelector('.faq-answer');
				const toggleIcon = item.querySelector('.faq-toggle-icon');

				if (question && answer && toggleIcon) {
					question.addEventListener('click', function () {
						const isActive = item.classList.contains('active');

						// Close all items
						faqItems.forEach(otherItem => {
							otherItem.classList.remove('active');
							const otherAnswer = otherItem.querySelector('.faq-answer');
							const otherIcon = otherItem.querySelector('.faq-toggle-icon');
							if (otherAnswer && otherIcon) {
								otherAnswer.style.display = 'none';
								otherIcon.textContent = '+';
							}
						});

						// Toggle current item
						if (!isActive) {
							item.classList.add('active');
							answer.style.display = 'block';
							toggleIcon.textContent = '−';
						}
					});
				}
			});
		});

		// Share button functionality
		var shareButton = document.querySelector(".share-btn");
		var shareOverlay = document.querySelector(".social-overlay");

		if (shareButton && shareOverlay) {
			shareButton.addEventListener("click", function () {
				shareButton.classList.add("show");
				document.querySelector('html').classList.add('social-open');
			});

			shareOverlay.addEventListener("click", function () {
				shareButton.classList.remove("show");
				document.querySelector('html').classList.remove('social-open');
			});
		}

		// Copy link functionality
		document.addEventListener("DOMContentLoaded", function () {
			var copyButton = document.getElementById("copyLink");
			if (copyButton) {
				var spanElement = copyButton.querySelector("span");

				copyButton.addEventListener("click", function (event) {
					event.preventDefault();
					// Get the current URL
					var currentURL = window.location.href;

					// Create a temporary input element to copy the URL to the clipboard
					var tempInput = document.createElement("input");
					tempInput.value = currentURL;
					document.body.appendChild(tempInput);

					// Select and copy the text
					tempInput.select();
					document.execCommand("copy");

					// Remove the temporary input element
					document.body.removeChild(tempInput);

					// Provide feedback to the user
					if (spanElement) {
						spanElement.innerHTML = "Copied";
						setTimeout(function () {
							document.querySelector('html').classList.remove('social-open');
							spanElement.innerHTML = "Copy link";
						}, 1000);
					}
				});
			}

			// WhatsApp share functionality
			var whatsappShare = document.querySelector(".share_whatsapp");
			if (whatsappShare) {
				var whatsappLink = whatsappShare.querySelector("a");
				if (whatsappLink) {
					whatsappLink.addEventListener("click", function () {
						var current_text = document.querySelector(".chapter-course-title") ? document.querySelector(".chapter-course-title").textContent : document.title;
						var current_page_url = window.location.href;
						window.open('https://wa.me/?text=' + encodeURIComponent(current_text + " , " + current_page_url) + '&utm-medium=social&utm-source=WhatsApp&utm-campaign=Academy', "_blank");
					});
				}
			}
		});

		// Close share menu on scroll
		window.onscroll = function () {
			document.querySelector('html').classList.remove('social-open');
		};

		// Native share API (for mobile devices)
		const BlogData = {
			title: '<?php the_title(); ?>',
			url: '<?php the_permalink(); ?>',
		}

		const btn = document.querySelector('.sharing-icon');

		if (btn) {
			// Share must be triggered by "user activation"
			btn.addEventListener('click', async () => {
				try {
					if (navigator.canShare &&
						typeof navigator.canShare === 'function' &&
						navigator.canShare(BlogData)) {
						let result = await navigator.share(BlogData);
						document.getElementById("status").innerText = result || '';
					} else {
						document.getElementById("status").innerText = "Sharing selected data not supported.";
					}
				} catch (err) {
					document.getElementById("status").innerText = "Share not complete";
				}
			});
		}
	</script>

	<?php
endwhile;
get_footer();

