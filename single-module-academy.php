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
if ( isset( $wp_query->queried_object_id ) ) {
	$chapter_id = $wp_query->queried_object_id;
} elseif ( isset( $wp_query->post ) && $wp_query->post ) {
	$chapter_id = $wp_query->post->ID;
}

// Only proceed with redirect check if we have a valid chapter ID
if ( $chapter_id ) {
	// Helper to fetch topics from CPT
	if ( ! function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
		function vested_academy_get_topics_for_chapter( $chapter_id ) {
			$topics = array();
			// Preferred: ACF relationship field ordering
			$selected = get_field( 'chapter_topic_links', $chapter_id );
			if ( $selected && is_array( $selected ) ) {
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
				$topics_posts = $selected_posts;
			} else {
				// Fallback: all chapter_topic posts with this chapter as parent
				$topics_posts = get_posts( array(
					'post_type'      => 'chapter_topic',
					'post_parent'    => $chapter_id,
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) );
			}

			if ( $topics_posts ) {
				$idx = 0;
				foreach ( $topics_posts as $tp ) {
					// Calculate duration from content dynamically
					$topic_content = $tp->post_content;
					$topic_duration = calculate_reading_time( $topic_content );
					
					$topics[] = array(
						'topic_title'    => get_the_title( $tp->ID ),
						'topic_duration' => $topic_duration,
						'topic_content'  => apply_filters( 'the_content', $topic_content ),
						'topic_id'       => $tp->ID,
						'topic_slug'     => $tp->post_name,
						'index'          => $idx,
					);
					$idx++;
				}
			}
			return $topics;
		}
	}

	// Get topics for current chapter (CPT first, fallback to ACF repeater)
	$current_chapter_topics = vested_academy_get_topics_for_chapter( $chapter_id );
	if ( empty( $current_chapter_topics ) ) {
		$current_chapter_topics = get_field( 'chapter_topics', $chapter_id );
		if ( ! $current_chapter_topics || ! is_array( $current_chapter_topics ) ) {
			$current_chapter_topics = array();
		}
	}
	
	// Check if showing quiz (from URL parameter or anchor) - check this BEFORE processing topics
	$show_quiz = isset( $_GET['quiz'] ) && $_GET['quiz'] == '1';
	$show_quiz_results = isset( $_GET['results'] ) && $_GET['results'] == '1';
	
	// Get current topic from URL - prefer topic_slug query var (rewrite) and fallback to ?topic=
	$current_topic_index = null;
	$current_topic = null;
	$current_topic_slug = isset( $wp_query->query_vars['topic_slug'] ) ? $wp_query->query_vars['topic_slug'] : null;
	
	if ( $current_topic_slug && ! empty( $current_chapter_topics ) ) {
		foreach ( $current_chapter_topics as $idx => $topic ) {
			if ( isset( $topic['topic_slug'] ) && $topic['topic_slug'] === $current_topic_slug ) {
				$current_topic_index = $idx;
				$current_topic = $topic;
				$current_topic['index'] = $idx;
				break;
			}
		}
	} elseif ( isset( $_GET['topic'] ) ) {
		// Backward compatibility: redirect old ?topic=N to slug URL if available
		$old_idx = intval( $_GET['topic'] );
		if ( isset( $current_chapter_topics[ $old_idx ] ) ) {
			$old_topic = $current_chapter_topics[ $old_idx ];
			if ( isset( $old_topic['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) ) {
				$new_url = vested_academy_get_topic_url( $chapter_id, $old_topic['topic_slug'] );
				wp_safe_redirect( $new_url, 301 );
				exit;
			} else {
				$current_topic_index = $old_idx;
				$current_topic = $old_topic;
				$current_topic['index'] = $old_idx;
			}
		}
	}
	
	// Check if URL has quiz anchor but no quiz parameter (fix malformed URLs from anchor-only links)
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$has_quiz_anchor = strpos( $request_uri, '#quiz-content' ) !== false || ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], '#quiz-content' ) !== false );
	if ( $has_quiz_anchor && ! $show_quiz && ! $show_quiz_results ) {
		// Redirect to proper quiz URL with quiz parameter
		$clean_quiz_url = get_permalink( $chapter_id );
		$clean_quiz_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), $clean_quiz_url );
		$clean_quiz_url = add_query_arg( 'quiz', '1', $clean_quiz_url );
		wp_safe_redirect( $clean_quiz_url . '#quiz-content', 302 );
		exit;
	}
	
	// If quiz is being accessed, ensure topic parameter is removed from URL and redirect to clean quiz URL
	if ( $show_quiz && $current_topic_index !== null ) {
		// Build clean URL without topic parameter
		$clean_quiz_url = get_permalink( $chapter_id );
		$clean_quiz_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), $clean_quiz_url );
		$clean_quiz_url = add_query_arg( 'quiz', '1', $clean_quiz_url );
		if ( isset( $_GET['q'] ) && $_GET['q'] > 0 ) {
			$clean_quiz_url = add_query_arg( 'q', intval( $_GET['q'] ), $clean_quiz_url );
		}
		wp_safe_redirect( $clean_quiz_url . '#quiz-content' );
		exit;
	}
	
	// Also check if URL has both topic and quiz parameters (shouldn't happen, but fix it if it does)
	if ( $show_quiz && isset( $_GET['topic'] ) ) {
		$clean_quiz_url = get_permalink( $chapter_id );
		$clean_quiz_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), $clean_quiz_url );
		$clean_quiz_url = add_query_arg( 'quiz', '1', $clean_quiz_url );
		if ( isset( $_GET['q'] ) && $_GET['q'] > 0 ) {
			$clean_quiz_url = add_query_arg( 'q', intval( $_GET['q'] ), $clean_quiz_url );
		}
		wp_safe_redirect( $clean_quiz_url . '#quiz-content' );
		exit;
	}
	
	// If no topic selected and chapter has topics, redirect to first topic (unless viewing quiz)
	if ( $current_topic_index === null && ! empty( $current_chapter_topics ) && ! $show_quiz && ! $show_quiz_results && ! isset( $_GET['no_redirect'] ) ) {
		$first_topic = $current_chapter_topics[0];
		if ( isset( $first_topic['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) ) {
			$redirect_url = vested_academy_get_topic_url( $chapter_id, $first_topic['topic_slug'] );
		} else {
			// Fallback to old query param
			$redirect_url = get_permalink( $chapter_id );
			$redirect_url = remove_query_arg( 'topic', $redirect_url );
			$redirect_url = add_query_arg( 'topic', 0, $redirect_url );
		}
		wp_safe_redirect( $redirect_url, 302 );
		exit;
	}
}

get_header();

while ( have_posts() ) :
	the_post();
	
	$chapter_id = get_the_ID();
	$user_id = get_current_user_id();
	$terms = get_the_terms( $chapter_id, 'modules' );
	$module_term = null; // Legacy taxonomy term
	$module_post = null; // New CPT object
	$module_id = null;
	$module_slug = '';
	$module_name = '';
	$module_difficulty = 'Beginner';
	$module_link = '';
	$module_source = null; // 'term' or 'post'
	
	if ( $terms && ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		// Get the first module term (chapters should belong to one module)
		$module_term = $terms[0];
		$module_id = $module_term->term_id;
		$module_slug = $module_term->slug;
		$module_name = $module_term->name;
		$module_difficulty = get_field( 'difficulty_level', $module_term ) ?: 'Beginner';
		$module_source = 'term';
		$module_link = get_term_link( $module_term );
	} else {
		// Primary (new): find linked Academy Module CPT via ACF relationship on chapter
		$related_modules = get_field( 'academy_module', $chapter_id );
		if ( $related_modules ) {
			// Relationship may return array or single object/ID
			if ( is_array( $related_modules ) ) {
				$module_post = is_object( $related_modules[0] ) ? $related_modules[0] : get_post( $related_modules[0] );
			} elseif ( is_object( $related_modules ) ) {
				$module_post = $related_modules;
			} elseif ( is_numeric( $related_modules ) ) {
				$module_post = get_post( $related_modules );
			}
		}
		
		if ( $module_post ) {
			$module_id = $module_post->ID;
			$module_slug = $module_post->post_name;
			$module_name = get_the_title( $module_id );
			$module_difficulty = get_field( 'difficulty_level', $module_id ) ?: 'Beginner';
			$module_source = 'post';
			$module_link = get_permalink( $module_id );
		} else {
			// Legacy fallback: try to derive term from URL slug (e.g. /academy/{term}/{postname})
			$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
			$slug = '';
			if ( $request_uri ) {
				$parts = explode( '/', trim( $request_uri, '/' ) );
				// Find 'academy' in path and take the next segment as term slug
				$academy_index = array_search( 'academy', $parts, true );
				if ( $academy_index !== false && isset( $parts[ $academy_index + 1 ] ) ) {
					$slug = sanitize_title( $parts[ $academy_index + 1 ] );
				}
			}
			if ( $slug ) {
				$fallback_term = get_term_by( 'slug', $slug, 'modules' );
				if ( $fallback_term && ! is_wp_error( $fallback_term ) ) {
					$module_term = $fallback_term;
					$module_id = $fallback_term->term_id;
					$module_slug = $fallback_term->slug;
					$module_name = $fallback_term->name;
					$module_difficulty = get_field( 'difficulty_level', $fallback_term ) ?: 'Beginner';
					$module_source = 'term';
					$module_link = get_term_link( $module_term );
				}
			}
		}
	}
	
	// Get all chapters in this module for sidebar
	// IMPORTANT: Only show chapters from the SAME module category
	$all_chapters = array();
	if ( $module_id ) {
		if ( $module_source === 'post' ) {
			// New structure: link chapters to Academy Module CPT via ACF relationship
			$chapters_query = new WP_Query( array(
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
			) );
		} else {
			// Legacy taxonomy-based grouping
			$chapters_query = new WP_Query( array(
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
			) );
		}
		
		if ( $chapters_query->have_posts() ) {
			while ( $chapters_query->have_posts() ) {
				$chapters_query->the_post();
				$chapter_post_id = get_the_ID();
				$chapter_url = get_permalink( $chapter_post_id );
				
				// Get topics for this chapter from CPT (fallback to ACF)
				$topics = vested_academy_get_topics_for_chapter( $chapter_post_id );
				if ( empty( $topics ) ) {
					$topics = get_field( 'chapter_topics', $chapter_post_id );
					if ( ! $topics || ! is_array( $topics ) ) {
						$topics = array();
					}
				}
				
				$all_chapters[] = array(
					'id' => $chapter_post_id,
					'title' => get_the_title(),
					'url' => $chapter_url,
					'reading_time' => calculate_reading_time( get_the_content() ),
					'topics' => $topics, // Add topics array
				);
			}
			wp_reset_postdata();
		} else {
			// No chapters found
		}
	} else {
		// If taxonomy/module term is intentionally removed, fall back to a single-chapter sidebar
		$topics = get_field( 'chapter_topics', $chapter_id );
		if ( ! $topics || ! is_array( $topics ) ) {
			$topics = array();
		}
		$all_chapters[] = array(
			'id' => $chapter_id,
			'title' => get_the_title(),
			'url' => get_permalink( $chapter_id ),
			'reading_time' => calculate_reading_time( get_the_content() ),
			'topics' => $topics,
		);
	}
	
	// Get quiz for THIS MODULE/CHAPTER
	// Quiz is now stored as a separate post type and linked via quiz_links relationship field
	$quiz = null;
	$quiz_data = null;
	
	// Get quizzes for THIS CHAPTER
	// quiz_links field is on the chapter (module post type)
	$module_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
	
	// Use the first quiz if multiple exist
	if ( ! empty( $module_quizzes ) ) {
		$quiz_post = $module_quizzes[0];
		
		// Use questions from helper function (already retrieved)
		$quiz_questions = isset( $quiz_post['questions'] ) ? $quiz_post['questions'] : array();
		
		// If questions array is empty, try fetching directly (fallback)
		if ( empty( $quiz_questions ) ) {
			$quiz_questions = get_field( 'quiz_questions', $quiz_post['id'] );
			if ( ! $quiz_questions ) {
				$quiz_questions = array();
			}
		}
		
		if ( ! empty( $quiz_questions ) ) {
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
				'total_questions' => count( $quiz_questions ),
				'passing_score' => $quiz_post['passing_score'],
				'time_limit' => $quiz_post['time_limit'],
				'allow_retake' => get_field( 'allow_retake', $quiz_post['id'] ) !== false,
			);
			
			// Get user's saved answers and previous attempts
			// Use quiz_post ID as quiz_id
			$quiz_saved_answers = array();
			$quiz_previous_attempt = null;
			if ( $user_id ) {
				$quiz_saved_answers = vested_academy_get_user_quiz_answers( $user_id, $quiz_post['id'] );
				global $wpdb;
				$table_name = $wpdb->prefix . 'academy_progress';
				$quiz_previous_attempt = $wpdb->get_row( $wpdb->prepare(
					"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
					$user_id,
					$quiz_post['id']
				) );
			}
			
			$quiz_data['saved_answers'] = $quiz_saved_answers;
			$quiz_data['previous_attempt'] = $quiz_previous_attempt;
		}
	}
	
	// Keep previously loaded topics (CPT via helper) - only fallback to ACF repeater if empty
	if ( empty( $current_chapter_topics ) ) {
		$current_chapter_topics = get_field( 'chapter_topics', $chapter_id );
		if ( ! $current_chapter_topics || ! is_array( $current_chapter_topics ) ) {
			$current_chapter_topics = array();
		}
	}
	
	// Check if showing quiz (from URL parameter or anchor) - check this BEFORE processing topics
	$show_quiz = isset( $_GET['quiz'] ) && $_GET['quiz'] == '1';
	$quiz_current_question = isset( $_GET['q'] ) ? intval( $_GET['q'] ) : 0;
	$show_quiz_results = isset( $_GET['results'] ) && $_GET['results'] == '1';
	
	// current_topic_index and current_topic are already set above using slug fallback
	// Get next and previous topics (only within same chapter)
	$next_topic = null;
	$prev_topic = null;
	if ( $current_topic_index !== null ) {
		// Next topic in same chapter
		if ( isset( $current_chapter_topics[ $current_topic_index + 1 ] ) ) {
			$next_topic_data = $current_chapter_topics[ $current_topic_index + 1 ];
			$next_topic_url = ( isset( $next_topic_data['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) )
				? vested_academy_get_topic_url( $chapter_id, $next_topic_data['topic_slug'] )
				: add_query_arg( 'topic', $current_topic_index + 1, get_permalink( $chapter_id ) );
			$next_topic = array(
				'index' => $current_topic_index + 1,
				'data' => $next_topic_data,
				'chapter_id' => $chapter_id,
				'url' => $next_topic_url,
			);
		}
		
		// Previous topic in same chapter
		if ( $current_topic_index > 0 && isset( $current_chapter_topics[ $current_topic_index - 1 ] ) ) {
			$prev_topic_data = $current_chapter_topics[ $current_topic_index - 1 ];
			$prev_topic_url = ( isset( $prev_topic_data['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) )
				? vested_academy_get_topic_url( $chapter_id, $prev_topic_data['topic_slug'] )
				: add_query_arg( 'topic', $current_topic_index - 1, get_permalink( $chapter_id ) );
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
	foreach ( $all_chapters as $index => $chapter ) {
		if ( $chapter['id'] == $chapter_id ) {
			$current_chapter_index = $index;
			break;
		}
	}
	
	// Get next and previous chapters
	$next_chapter = isset( $all_chapters[ $current_chapter_index + 1 ] ) ? $all_chapters[ $current_chapter_index + 1 ] : null;
	$prev_chapter = isset( $all_chapters[ $current_chapter_index - 1 ] ) ? $all_chapters[ $current_chapter_index - 1 ] : null;
	
	// Check chapter completion (for display purposes only - no redirect)
	$chapter_completed = false;
	if ( $user_id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'academy_progress';
		$progress = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter' AND status = 'completed'",
			$user_id,
			$chapter_id
		) );
		$chapter_completed = ! empty( $progress );
		
		// REMOVED: Auto-redirect from completed chapters
		// Users can now access any chapter they want, regardless of completion status
	}
	
	$reading_time = calculate_reading_time( get_the_content() );
	// Already set earlier; keep fallback for safety
	if ( ! $module_difficulty ) {
		$module_difficulty = get_field( 'difficulty_level', $module_term ) ?: 'Beginner';
	}
	
	// Count total chapters
	$total_chapters = count( $all_chapters );
	$total_minutes = 0;
	foreach ( $all_chapters as $ch ) {
		// Add chapter reading time
		$total_minutes += $ch['reading_time'];
		
		// Add all topics duration for this chapter
		if ( isset( $ch['topics'] ) && is_array( $ch['topics'] ) ) {
			foreach ( $ch['topics'] as $topic ) {
				// Get topic duration (calculated from content)
				$topic_duration = isset( $topic['topic_duration'] ) ? intval( $topic['topic_duration'] ) : 0;
				// If duration not set, calculate from content
				if ( $topic_duration <= 0 && isset( $topic['topic_content'] ) ) {
					$topic_duration = calculate_reading_time( $topic['topic_content'] );
				}
				// If still 0, try calculating from topic_id if it's a CPT
				if ( $topic_duration <= 0 && isset( $topic['topic_id'] ) ) {
					$topic_post = get_post( $topic['topic_id'] );
					if ( $topic_post ) {
						$topic_duration = calculate_reading_time( $topic_post->post_content );
					}
				}
				$total_minutes += $topic_duration;
			}
		}
		
		// Add quiz time for this chapter
		$chapter_quizzes = vested_academy_get_quizzes_for_module( $ch['id'] );
		if ( ! empty( $chapter_quizzes ) ) {
			foreach ( $chapter_quizzes as $quiz ) {
				$quiz_time = isset( $quiz['time_limit'] ) ? intval( $quiz['time_limit'] ) : 0;
				$total_minutes += $quiz_time;
			}
		}
	}
	
	// Format display: show minutes if less than 1 hour, otherwise show hours
	if ( $total_minutes < 60 ) {
		$total_time_display = $total_minutes . ' Minutes';
	} else {
		$total_hours = round( $total_minutes / 60, 1 );
		$total_time_display = $total_hours . ' Hours';
	}
	?>

	<div id="academy-chapter-page" class="academy-chapter-page">
		<!-- Green Header Banner -->
		<section class="chapter-header-banner">
			<div class="container">
				<!-- Breadcrumbs -->
				<div class="chapter-breadcrumb">
					<ul>
						<li><a href="<?php echo esc_url( home_url() ); ?>">Home</a></li>
						<?php if ( $module_link ) : ?>
							<li><a href="<?php echo esc_url( $module_link ); ?>"><?php echo esc_html( $module_name ? $module_name : 'Module' ); ?></a></li>
						<?php elseif ( $module_name ) : ?>
							<li><span><?php echo esc_html( $module_name ); ?></span></li>
						<?php endif; ?>
						<li><span><?php the_title(); ?></span></li>
					</ul>
				</div>
				
				<!-- Course Title -->
				<h1 class="chapter-course-title"><?php echo esc_html( $module_name ? $module_name : get_the_title() ); ?></h1>
				
				<!-- Course Meta -->
				<div class="chapter-meta">
					<span class="meta-item">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 15.75V14.25C12 13.4544 11.6839 12.6913 11.1213 12.1287C10.5587 11.5661 9.79565 11.25 9 11.25H4.5C3.70435 11.25 2.94129 11.5661 2.37868 12.1287C1.81607 12.6913 1.5 13.4544 1.5 14.25V15.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?php echo esc_html( $module_difficulty ); ?>
					</span>
					<span class="meta-item">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3 4.5H15M3 9H15M3 13.5H15" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
						</svg>
						<?php echo esc_html( $total_chapters ); ?> Chapters
					</span>
					<span class="meta-item">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M9 4.5V9L12 10.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<?php echo esc_html( $total_time_display ); ?>
					</span>
				</div>
				
				<!-- Tags -->
				<div class="chapter-tags">
					<span class="tag-item">Stock market</span>
					<span class="tag-item">Intraday Trading</span>
				</div>
				
				<!-- Share Button -->
				<button class="chapter-share-btn">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M15 6.66667C16.3807 6.66667 17.5 5.54738 17.5 4.16667C17.5 2.78595 16.3807 1.66667 15 1.66667C13.6193 1.66667 12.5 2.78595 12.5 4.16667C12.5 4.53018 12.5853 4.87452 12.7375 5.18229L7.7625 8.18229C7.28595 7.61905 6.58333 7.29167 5.83333 7.29167C4.45262 7.29167 3.33333 8.41095 3.33333 9.79167C3.33333 11.1724 4.45262 12.2917 5.83333 12.2917C6.58333 12.2917 7.28595 11.9643 7.7625 11.401L12.7375 14.401C12.5853 14.7088 12.5 15.0531 12.5 15.4167C12.5 16.7974 13.6193 17.9167 15 17.9167C16.3807 17.9167 17.5 16.7974 17.5 15.4167C17.5 14.036 16.3807 12.9167 15 12.9167C14.25 12.9167 13.5474 13.244 13.0708 13.8073L8.09583 10.8073C8.24792 10.4995 8.33333 10.1552 8.33333 9.79167C8.33333 9.42815 8.24792 9.08381 8.09583 8.77604L13.0708 5.77604C13.5474 6.33929 14.25 6.66667 15 6.66667Z" fill="white"/>
					</svg>
					Share
				</button>
			</div>
		</section>

		<!-- Main Content Layout -->
		<div class="chapter-main-layout">
			<div class="container">
				<div class="chapter-layout-wrapper">
					<!-- Left Sidebar: Course Navigation -->
					<aside class="chapter-sidebar">
						<div class="sidebar-course-header">
							<div class="course-icon-small">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4 19.5C4 18.6716 4.67157 18 5.5 18H18.5C19.3284 18 20 18.6716 20 19.5C20 20.3284 19.3284 21 18.5 21H5.5C4.67157 21 4 20.3284 4 19.5Z" fill="#00A651"/>
									<path d="M4 4.5C4 3.67157 4.67157 3 5.5 3H18.5C19.3284 3 20 3.67157 20 4.5C20 5.32843 19.3284 6 18.5 6H5.5C4.67157 6 4 5.32843 4 4.5Z" fill="#00A651"/>
									<path d="M4 12C4 11.1716 4.67157 10.5 5.5 10.5H18.5C19.3284 10.5 20 11.1716 20 12C20 12.8284 19.3284 13.5 18.5 13.5H5.5C4.67157 13.5 4 12.8284 4 12Z" fill="#00A651"/>
								</svg>
							</div>
							<h3 class="sidebar-course-title"><?php echo esc_html( $module_name ? $module_name : 'Course' ); ?></h3>
						</div>
						
						<div class="sidebar-chapters-list">
							<?php
							$chapter_num = 1;
							foreach ( $all_chapters as $index => $chapter ) :
								$is_current = ( $chapter['id'] == $chapter_id );
								// Only expand the current chapter (the one containing the current topic/viewing)
								// All other chapters should be collapsed
								$is_expanded = $is_current;
								
								// Check if completed
								$is_completed = false;
								if ( $user_id ) {
									global $wpdb;
									$table_name = $wpdb->prefix . 'academy_progress';
									$progress = $wpdb->get_row( $wpdb->prepare(
										"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter' AND status = 'completed'",
										$user_id,
										$chapter['id']
									) );
									$is_completed = ! empty( $progress );
								}
								
								// Check if THIS chapter/module has quizzes (from quiz_links field only)
								$module_quizzes = vested_academy_get_quizzes_for_module( $chapter['id'] );
								$chapter_quiz = null;
								
								if ( ! empty( $module_quizzes ) ) {
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
								<div class="sidebar-chapter-item <?php echo $is_current ? 'active' : ''; ?> <?php echo $is_expanded ? 'expanded' : ''; ?>" data-chapter-id="<?php echo esc_attr( $chapter['id'] ); ?>">
									<div class="sidebar-chapter-header">
										<a href="<?php echo esc_url( $chapter['url'] ); ?>" class="chapter-label-link">
											<span class="chapter-label">Chapter <?php echo esc_html( $chapter_num ); ?>: <?php echo esc_html( $chapter['title'] ); ?></span>
										</a>
										<button class="chapter-toggle" aria-label="Toggle chapter" type="button">
											<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="toggle-icon">
												<path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</button>
									</div>
									
									<div class="sidebar-chapter-content" style="display: <?php echo $is_expanded ? 'block' : 'none'; ?>;">
										<?php
										// Display topics for this chapter
										$chapter_topics = isset( $chapter['topics'] ) ? $chapter['topics'] : array();
										
										if ( ! empty( $chapter_topics ) ) {
											foreach ( $chapter_topics as $topic_idx => $topic ) :
												$topic_title = isset( $topic['topic_title'] ) ? $topic['topic_title'] : 'Topic ' . ( $topic_idx + 1 );
												// Get duration from topic data (calculated from content)
												$topic_duration = isset( $topic['topic_duration'] ) ? intval( $topic['topic_duration'] ) : 0;
												// If duration is 0 or not set, calculate from content
												if ( $topic_duration <= 0 && isset( $topic['topic_content'] ) ) {
													$topic_duration = calculate_reading_time( $topic['topic_content'] );
												}
												// Minimum 1 minute if content exists
												if ( $topic_duration <= 0 ) {
													$topic_duration = 1;
												}
												if ( isset( $topic['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) ) {
													$topic_url = vested_academy_get_topic_url( $chapter['id'], $topic['topic_slug'] );
												} else {
													$topic_url = add_query_arg( 'topic', $topic_idx, $chapter['url'] );
												}
												
												// Check if this topic is current
												$is_current_topic = ( $is_current && $current_topic_index === $topic_idx );
												
												// Check if topic is completed
												$topic_completed = false;
												if ( $user_id ) {
													$topic_completed = vested_academy_is_topic_completed( $user_id, $chapter['id'], $topic_idx );
												}
												
												// No topic locking - users can access any topic
												$topic_locked = false;
												?>
												<a href="<?php echo esc_url( $topic_url ); ?>" 
												   class="sidebar-chapter-sub-item <?php echo $is_current_topic ? 'current' : ''; ?>">
													<span class="sub-item-icon">
														<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M2 3C2 2.44772 2.44772 2 3 2H13C13.5523 2 14 2.44772 14 3V13C14 13.5523 13.5523 14 13 14H3C2.44772 14 2 13.5523 2 13V3Z" stroke="currentColor" stroke-width="1.5"/>
														</svg>
													</span>
													<span class="sub-item-number"><?php echo str_pad( $topic_idx + 1, 2, '0', STR_PAD_LEFT ); ?>: <?php echo esc_html( $topic_title ); ?></span>
													<span class="sub-item-duration"><?php echo esc_html( $topic_duration ); ?> Minutes</span>
													<?php if ( $topic_completed ) : ?>
														<span class="sub-item-check">✓</span>
													<?php endif; ?>
												</a>
											<?php endforeach;
										} else {
											// Debug helper: surface empty topics state when WP_DEBUG is on
											if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
												echo '<p class="academy-debug-notice">No topics found for this chapter. Check the ACF repeater field "chapter_topics" on the module post.</p>';
											}
											// Fallback: Show chapter as single item if no topics
											$sub_completed = false;
											if ( $user_id ) {
												$sub_progress = $wpdb->get_row( $wpdb->prepare(
													"SELECT * FROM $table_name WHERE user_id = %d AND chapter_id = %d AND progress_type = 'chapter' AND status = 'completed'",
													$user_id,
													$chapter['id']
												) );
												$sub_completed = ! empty( $sub_progress );
											}
											?>
											<a href="<?php echo esc_url( $chapter['url'] ); ?>" class="sidebar-chapter-sub-item <?php echo $is_current ? 'current' : ''; ?>">
												<span class="sub-item-number"><?php echo str_pad( $chapter_num, 2, '0', STR_PAD_LEFT ); ?>: <?php echo esc_html( $chapter['title'] ); ?></span>
												<span class="sub-item-duration"><?php echo esc_html( $chapter['reading_time'] ); ?> Minutes</span>
												<?php if ( $sub_completed ) : ?>
													<span class="sub-item-check">✓</span>
												<?php endif; ?>
											</a>
										<?php } ?>
										
										<?php
										// Add Quiz for THIS chapter (each chapter has its own quiz)
										if ( $chapter_quiz ) :
											// Quiz is locked if user is not logged in OR if all topics in chapter are not completed
											$quiz_locked = ! is_user_logged_in();
											if ( $user_id && ! empty( $chapter_topics ) ) {
												$all_topics_completed = vested_academy_are_all_topics_completed( $user_id, $chapter['id'], $chapter_topics );
												$quiz_locked = ! $all_topics_completed;
											}
											$quiz_active = ( $is_current && $show_quiz );
											
											// Build quiz URL - remove topic parameter and add quiz parameter
											$quiz_base_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter['id'] ) );
											$quiz_url = add_query_arg( 'quiz', '1', $quiz_base_url ) . '#quiz-content';
											
											// Always show quiz link (don't redirect to login)
											// Don't show lock icon if user is logged in (even if quiz is locked, they can see it)
											?>
											<a href="<?php echo esc_url( $quiz_url ); ?>" class="sidebar-chapter-sub-item quiz-item <?php echo $quiz_active ? 'active' : ''; ?> <?php echo ( $quiz_locked && ! is_user_logged_in() ) ? 'locked' : ''; ?>">
												<span class="sub-item-icon">📋</span>
												<span class="sub-item-title">Quiz</span>
												<?php if ( $quiz_locked && ! is_user_logged_in() ) : ?>
													<span class="sub-item-lock">🔒</span>
												<?php endif; ?>
											</a>
										<?php endif; ?>
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
						<?php if ( $show_quiz && $quiz_data && is_user_logged_in() ) : ?>
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
								
								// Check if showing results (from URL or from recent submission)
								if ( $show_quiz_results ) {
									// Get latest attempt if not already loaded
									if ( ! $previous_attempt && $user_id ) {
										global $wpdb;
										$table_name = $wpdb->prefix . 'academy_progress';
										$previous_attempt = $wpdb->get_row( $wpdb->prepare(
											"SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' ORDER BY id DESC LIMIT 1",
											$user_id,
											$quiz_id
										) );
									}
									
									if ( $previous_attempt ) {
										// Show quiz results - set variables for template
										$quiz_id_for_results = $quiz_id;
										$chapter_id_for_results = $chapter_id; // Pass chapter_id for retake URL
										$previous_attempt_for_results = $previous_attempt;
										$passing_score_for_results = $passing_score;
										$total_questions_for_results = $total_questions;
										$module_id_for_results = $module_id;
										$allow_retake_for_results = $allow_retake;
										include locate_template( 'template-parts/quiz/quiz-results.php' );
									} else {
										// No attempt found, show quiz questions
										// Validate question index bounds
										if ( $quiz_current_question < 0 ) {
											$quiz_current_question = 0;
										}
										if ( $quiz_current_question >= $total_questions && $total_questions > 0 ) {
											$quiz_current_question = $total_questions - 1;
										}
										
										// Get the current question - use the index from URL
										$current_q = null;
										if ( isset( $questions[ $quiz_current_question ] ) ) {
											$current_q = $questions[ $quiz_current_question ];
										} elseif ( ! empty( $questions ) ) {
											// Fallback to first question if index is invalid
											$current_q = $questions[0];
											$quiz_current_question = 0; // Reset to first question
										}
										if ( $current_q ) {
											$question_text = isset( $current_q['question'] ) ? $current_q['question'] : '';
											$options = isset( $current_q['options'] ) ? $current_q['options'] : array();
											$saved_answer = isset( $saved_answers[ $quiz_current_question ] ) ? $saved_answers[ $quiz_current_question ] : '';
											?>
											<div class="quiz-questions-container">
												<div class="quiz-question-wrapper" data-question-index="<?php echo esc_attr( $quiz_current_question ); ?>">
													<div class="quiz-question-header">
														<h2 class="quiz-title">Quiz <?php echo esc_html( $quiz_current_question + 1 ); ?></h2>
													</div>
													
													<div class="quiz-question-content">
														<h3 class="question-text"><?php echo esc_html( $question_text ); ?></h3>
														<p class="question-instruction">Choose only 1 answer</p>
														
														<div class="question-options">
															<?php
															if ( ! empty( $options ) ) {
																foreach ( $options as $option_index => $option ) :
																	$option_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : $option_index ) : $option;
																	$option_label = is_array( $option ) ? ( isset( $option['label'] ) ? $option['label'] : $option_value ) : $option;
																	$is_selected = ( $saved_answer === $option_value );
																	?>
																	<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>" data-option-value="<?php echo esc_attr( $option_value ); ?>">
																		<input 
																			type="radio" 
																			name="question_<?php echo esc_attr( $quiz_current_question ); ?>" 
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
															<span class="progress-text"><?php echo esc_html( $quiz_current_question + 1 ); ?>/<?php echo esc_html( $total_questions ); ?></span>
															<div class="progress-bar">
																<div class="progress-fill" style="width: <?php echo esc_attr( ( ( $quiz_current_question + 1 ) / $total_questions ) * 100 ); ?>%"></div>
															</div>
														</div>
														
												<div class="quiz-buttons">
													<?php 
													// Build navigation URLs - remove topic parameter and preserve quiz parameters
													$base_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) );
													$prev_q = max( 0, $quiz_current_question - 1 );
													$next_q = min( $total_questions - 1, $quiz_current_question + 1 );
													
													$prev_url = add_query_arg( array( 'quiz' => '1', 'q' => $prev_q ), $base_url ) . '#quiz-content';
													$next_url = add_query_arg( array( 'quiz' => '1', 'q' => $next_q ), $base_url ) . '#quiz-content';
													$skip_url = add_query_arg( array( 'quiz' => '1', 'q' => $next_q ), $base_url ) . '#quiz-content';
															?>
															<?php if ( $quiz_current_question > 0 ) : ?>
																<a href="<?php echo esc_url( $prev_url ); ?>" class="quiz-btn quiz-prev-btn" onclick="return true;">Previous</a>
															<?php endif; ?>
															
															<!-- Hidden Skip button (kept for future use) -->
															<a href="<?php echo esc_url( $skip_url ); ?>" class="quiz-btn quiz-skip-btn" style="display:none;" onclick="return true;">Skip</a>
															
															<?php if ( $quiz_current_question < $total_questions - 1 ) : ?>
																<a href="<?php echo esc_url( $next_url ); ?>" class="quiz-btn quiz-next-btn" onclick="return true;">Next</a>
															<?php else : ?>
																<button type="button" class="quiz-btn quiz-submit-btn" id="quiz-final-submit">Submit Quiz</button>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
											<?php
										}
									}
								} elseif ( $previous_attempt && $previous_attempt->status === 'completed' && ! $allow_retake ) {
									// Quiz completed, no retake allowed - set variables for template
									$module_id_for_completed = $module_id;
									include locate_template( 'template-parts/quiz/quiz-completed.php' );
								} elseif ( ! empty( $questions ) ) {
									// Check if retaking - if so, clear saved answers for fresh start
									$is_retaking = isset( $_GET['retake'] ) && $_GET['retake'] == '1';
									if ( $is_retaking && $user_id ) {
										// Clear saved answers when retaking - quiz_id is actually chapter_id
										global $wpdb;
										$answers_table = $wpdb->prefix . 'academy_quiz_answers';
										$wpdb->delete(
											$answers_table,
											array(
												'user_id' => $user_id,
												'quiz_id' => $quiz_id, // quiz_id is chapter_id in this context
											),
											array( '%d', '%d' )
										);
										
										// Also clear progress status for this quiz attempt
										$progress_table = $wpdb->prefix . 'academy_progress';
										$wpdb->update(
											$progress_table,
											array( 
												'status' => 'in_progress', 
												'progress_percentage' => 0, 
												'quiz_score' => 0, 
												'completed_at' => null 
											),
											array( 
												'user_id' => $user_id, 
												'quiz_id' => $quiz_id, 
												'progress_type' => 'quiz' 
											),
											array( '%s', '%d', '%d', '%s' ),
											array( '%d', '%d', '%s' )
										);
										
										// Reload saved answers (should be empty now)
										$saved_answers = array();
										// Reset question index
										$quiz_current_question = 0;
									}
									
									// Validate question index bounds
									if ( $quiz_current_question < 0 ) {
										$quiz_current_question = 0;
									}
									if ( $quiz_current_question >= $total_questions && $total_questions > 0 ) {
										$quiz_current_question = $total_questions - 1;
									}
									
									// Show quiz questions - use the index from URL
									$current_q = null;
									if ( isset( $questions[ $quiz_current_question ] ) ) {
										$current_q = $questions[ $quiz_current_question ];
									} elseif ( ! empty( $questions ) ) {
										// Fallback to first question if index is invalid
										$current_q = $questions[0];
										$quiz_current_question = 0; // Reset to first question
									}
									$question_text = isset( $current_q['question'] ) ? $current_q['question'] : '';
									$options = isset( $current_q['options'] ) ? $current_q['options'] : array();
									$saved_answer = isset( $saved_answers[ $quiz_current_question ] ) ? $saved_answers[ $quiz_current_question ] : '';
									?>
									<div class="quiz-questions-container">
										<div class="quiz-question-wrapper" data-question-index="<?php echo esc_attr( $quiz_current_question ); ?>">
											<div class="quiz-question-header">
												<h2 class="quiz-title">Quiz <?php echo esc_html( $quiz_current_question + 1 ); ?></h2>
											</div>
											
											<div class="quiz-question-content">
												<h3 class="question-text"><?php echo esc_html( $question_text ); ?></h3>
												<p class="question-instruction">Choose only 1 answer</p>
												
												<div class="question-options">
													<?php
													if ( ! empty( $options ) ) {
														foreach ( $options as $option_index => $option ) :
															$option_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : $option_index ) : $option;
															$option_label = is_array( $option ) ? ( isset( $option['label'] ) ? $option['label'] : $option_value ) : $option;
															$is_selected = ( $saved_answer === $option_value );
															?>
															<label class="option-label <?php echo $is_selected ? 'selected' : ''; ?>" data-option-value="<?php echo esc_attr( $option_value ); ?>">
																<input 
																	type="radio" 
																	name="question_<?php echo esc_attr( $quiz_current_question ); ?>" 
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
													<span class="progress-text"><?php echo esc_html( $quiz_current_question + 1 ); ?>/<?php echo esc_html( $total_questions ); ?></span>
													<div class="progress-bar">
														<div class="progress-fill" style="width: <?php echo esc_attr( ( ( $quiz_current_question + 1 ) / $total_questions ) * 100 ); ?>%"></div>
													</div>
												</div>
												
												<div class="quiz-buttons">
													<?php 
													// Build navigation URLs - remove topic parameter and preserve quiz parameters
													$base_url_2 = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) );
													$prev_q_2 = max( 0, $quiz_current_question - 1 );
													$next_q_2 = min( $total_questions - 1, $quiz_current_question + 1 );
													
													$prev_url_2 = add_query_arg( array( 'quiz' => '1', 'q' => $prev_q_2 ), $base_url_2 ) . '#quiz-content';
													$next_url_2 = add_query_arg( array( 'quiz' => '1', 'q' => $next_q_2 ), $base_url_2 ) . '#quiz-content';
													$skip_url_2 = add_query_arg( array( 'quiz' => '1', 'q' => $next_q_2 ), $base_url_2 ) . '#quiz-content';
													?>
													<?php if ( $quiz_current_question > 0 ) : ?>
														<a href="<?php echo esc_url( $prev_url_2 ); ?>" class="quiz-btn quiz-prev-btn" onclick="return true;">Previous</a>
													<?php endif; ?>
													
													<!-- Hidden Skip button (kept for future use) -->
													<a href="<?php echo esc_url( $skip_url_2 ); ?>" class="quiz-btn quiz-skip-btn" style="display:none;" onclick="return true;">Skip</a>
													
													<?php if ( $quiz_current_question < $total_questions - 1 ) : ?>
														<a href="<?php echo esc_url( $next_url_2 ); ?>" class="quiz-btn quiz-next-btn" onclick="return true;">Next</a>
													<?php else : ?>
														<button type="button" class="quiz-btn quiz-submit-btn" id="quiz-final-submit">Submit Quiz</button>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="quiz-no-questions">
										<p>No questions have been configured for this quiz yet. Please contact the administrator.</p>
									</div>
								<?php } ?>
							</div>
						<?php elseif ( $show_quiz && ( ! is_user_logged_in() || ( $user_id && ! empty( $current_chapter_topics ) && ! vested_academy_are_all_topics_completed( $user_id, $chapter_id, $current_chapter_topics ) ) ) ) : ?>
							<!-- Quiz Locked -->
							<div id="quiz-content" class="quiz-locked-inline">
								<div class="quiz-locked-card">
									<div class="lock-icon-large">🔒</div>
									<h2 class="quiz-locked-title">This quiz is locked</h2>
									<?php if ( ! is_user_logged_in() ) : ?>
										<p class="quiz-locked-message">You need to be logged in as an Academy User to take this quiz.</p>
										<div class="quiz-locked-actions">
											<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="btn-login-link">Login to take quiz</a>
										</div>
									<?php else : ?>
										<p class="quiz-locked-message">Please complete all topics in this chapter to unlock the quiz.</p>
									<?php endif; ?>
								</div>
							</div>
						<?php else : ?>
							<!-- Chapter Content or Topic Content -->
							<div class="chapter-content-card">
								<?php if ( $current_topic ) : ?>
									<!-- Display Topic Content -->
									<h2 class="chapter-content-title"><?php echo esc_html( isset( $current_topic['topic_title'] ) ? $current_topic['topic_title'] : 'Topic' ); ?></h2>
									
									<div class="chapter-content-body single-module-post-content">
										<?php 
										// Display topic content
										if ( isset( $current_topic['topic_content'] ) ) {
											echo wp_kses_post( $current_topic['topic_content'] );
										} else {
											echo '<p>Topic content not available.</p>';
										}
										?>
									</div>
								<?php else : ?>
									<!-- Display Chapter Content (fallback if no topics or no topic selected) -->
									<h2 class="chapter-content-title"><?php the_title(); ?></h2>
									
									<div class="chapter-content-body single-module-post-content">
										<?php if ( get_field( 'heading_notes' ) ) : ?>
											<div class="heading-note">
												<?php the_field( 'heading_notes' ); ?>
											</div>
										<?php endif; ?>
										
										<?php the_content(); ?>
										
										<?php if ( get_field( 'takeaways' ) ) : ?>
											<div class="chapter-takeaways">
												<h3>Key Takeaways</h3>
												<?php the_field( 'takeaways' ); ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								
								<!-- Navigation Buttons -->
								<div class="chapter-navigation">
									<?php if ( $current_topic ) : ?>
										<!-- Topic-based navigation -->
										<?php if ( $prev_topic ) : ?>
											<a href="<?php echo esc_url( $prev_topic['url'] ); ?>" class="chapter-nav-btn prev-btn">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
												Previous Topic
											</a>
										<?php endif; ?>
										
										<?php 
										// Check if this is the last topic in the chapter
										$is_last_topic = ( $current_topic_index !== null && $current_topic_index === count( $current_chapter_topics ) - 1 );
										
										// Check if chapter has quiz
										$chapter_has_quiz = ( $quiz && ! empty( $quiz ) );
										
										// Priority: If last topic, go to quiz; otherwise go to next topic
										if ( $is_last_topic && $chapter_has_quiz ) : 
											// Build quiz URL - remove topic parameter and add quiz parameter
											$quiz_base_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) );
											$quiz_url = add_query_arg( 'quiz', '1', $quiz_base_url ) . '#quiz-content';
										?>
											<a href="<?php echo esc_url( $quiz_url ); ?>" class="chapter-nav-btn next-btn quiz-btn" onclick="vestedAcademyMarkTopicComplete(<?php echo esc_js( $chapter_id ); ?>, <?php echo esc_js( $current_topic_index ); ?>, <?php echo esc_js( $module_id ); ?>); return true;">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</a>
										<?php elseif ( $next_topic ) : ?>
											<a href="<?php echo esc_url( $next_topic['url'] ); ?>" class="chapter-nav-btn next-btn" onclick="vestedAcademyMarkTopicComplete(<?php echo esc_js( $chapter_id ); ?>, <?php echo esc_js( $current_topic_index ); ?>, <?php echo esc_js( $module_id ); ?>); return true;">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</a>
										<?php endif; ?>
									<?php else : ?>
										<!-- Chapter-based navigation (fallback) -->
										<?php if ( $prev_chapter ) : ?>
											<a href="<?php echo esc_url( $prev_chapter['url'] ); ?>" class="chapter-nav-btn prev-btn">
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
												Previous Chapter
											</a>
										<?php endif; ?>
										
										<?php 
										// Check if current chapter has a quiz
										$current_chapter_quiz = null;
										if ( $quiz && is_user_logged_in() ) {
											// Build quiz URL - remove topic parameter and add quiz parameter
											$quiz_base_url = remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) );
											$current_chapter_quiz = array(
												'url' => add_query_arg( 'quiz', '1', $quiz_base_url ) . '#quiz-content',
											);
										}
										
										// Priority: If quiz exists, go to quiz; otherwise go to next chapter
										if ( $current_chapter_quiz ) : ?>
											<a href="<?php echo esc_url( $current_chapter_quiz['url'] ); ?>" class="chapter-nav-btn next-btn quiz-btn" onclick="vestedAcademyMarkChapterComplete(<?php echo esc_js( $chapter_id ); ?>, <?php echo esc_js( $module_id ); ?>); return true;">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</a>
										<?php elseif ( $next_chapter ) : ?>
											<a href="<?php echo esc_url( $next_chapter['url'] ); ?>" class="chapter-nav-btn next-btn" onclick="vestedAcademyMarkChapterComplete(<?php echo esc_js( $chapter_id ); ?>, <?php echo esc_js( $module_id ); ?>); return true;">
												Next topic/ Take Quiz
												<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>
											</a>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</main>
				</div>
			</div>
		</div>
	</div>

	<script>
	// Track chapter/topic progress on scroll
	<?php if ( $user_id && ! $show_quiz ) : ?>
	document.addEventListener('DOMContentLoaded', function() {
		var chapterId = <?php echo esc_js( $chapter_id ); ?>;
		var moduleId = <?php echo esc_js( $module_id ); ?>;
		var topicIndex = <?php echo $current_topic_index !== null ? esc_js( $current_topic_index ) : 'null'; ?>;
		var scrollProgress = 0;
		var lastProgress = 0;
		
		window.addEventListener('scroll', function() {
			var windowHeight = window.innerHeight;
			var documentHeight = document.documentElement.scrollHeight;
			var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
			
			scrollProgress = Math.round((scrollTop / (documentHeight - windowHeight)) * 100);
			
			// Update progress every 10%
			if (Math.abs(scrollProgress - lastProgress) >= 10) {
				lastProgress = scrollProgress;
				
					// Send progress update via AJAX
					var ajaxData = {
						action: 'academy_update_progress',
						chapter_id: chapterId,
						module_id: moduleId,
						progress: scrollProgress,
						nonce: academyAjax.nonce
					};
					
					// Add topic_index if viewing a topic
					if (topicIndex !== null) {
						ajaxData.topic_index = topicIndex;
					}
					
					jQuery.ajax({
						url: academyAjax.ajaxurl,
						type: 'POST',
						data: ajaxData
					});
			}
			
			// Mark as completed at 90% - send explicit completion request
			if (scrollProgress >= 90 && lastProgress < 90) {
				// Send completion request to ensure chapter is marked as completed
				jQuery.ajax({
					url: academyAjax.ajaxurl,
					type: 'POST',
					data: {
						action: 'academy_update_progress',
						chapter_id: chapterId,
						module_id: moduleId,
						progress: 100, // Force 100% to ensure completion
						nonce: academyAjax.nonce
					},
					success: function(response) {
						console.log('Chapter marked as completed:', response);
					}
				});
			}
			
			// Also mark as completed when user reaches the bottom (100%)
			if (scrollProgress >= 100 && lastProgress < 100) {
				var completeData = {
					action: 'academy_update_progress',
					chapter_id: chapterId,
					module_id: moduleId,
					progress: 100,
					nonce: academyAjax.nonce
				};
				
				if (topicIndex !== null) {
					completeData.topic_index = topicIndex;
				}
				
				jQuery.ajax({
					url: academyAjax.ajaxurl,
					type: 'POST',
					data: completeData,
					success: function(response) {
						console.log((topicIndex !== null ? 'Topic' : 'Chapter') + ' completed at 100%:', response);
					}
				});
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
				success: function(response) {
					console.log('Chapter marked as completed via Next button:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error marking chapter complete:', error);
				}
			});
		}
	}
	
	// Function to mark topic as complete (called when user clicks Next Topic button)
	function vestedAcademyMarkTopicComplete(chapterId, topicIndex, moduleId) {
		if (typeof academyAjax !== 'undefined') {
			jQuery.ajax({
				url: academyAjax.ajaxurl,
				type: 'POST',
				data: {
					action: 'academy_update_progress',
					chapter_id: chapterId,
					topic_index: topicIndex,
					module_id: moduleId,
					progress: 100, // Mark as 100% complete
					nonce: academyAjax.nonce
				},
				success: function(response) {
					console.log('Topic marked as completed via Next button:', response);
				},
				error: function(xhr, status, error) {
					console.error('Error marking topic complete:', error);
				}
			});
		}
	}
	
	// Chapter sidebar toggle functionality
	document.addEventListener('DOMContentLoaded', function() {
		const chapterToggles = document.querySelectorAll('.chapter-toggle');
		
		chapterToggles.forEach(function(toggle) {
			toggle.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				const chapterItem = this.closest('.sidebar-chapter-item');
				const chapterContent = chapterItem.querySelector('.sidebar-chapter-content');
				const toggleIcon = this.querySelector('.toggle-icon');
				const isCurrentlyExpanded = chapterItem.classList.contains('expanded');
				
				// Close all other chapters first (only one open at a time)
				document.querySelectorAll('.sidebar-chapter-item').forEach(function(item) {
					if (item !== chapterItem) {
						item.classList.remove('expanded');
						const content = item.querySelector('.sidebar-chapter-content');
						const icon = item.querySelector('.toggle-icon');
						if (content) {
							content.style.display = 'none';
						}
						if (icon) {
							icon.style.transform = 'rotate(0deg)';
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
					if (toggleIcon) {
						toggleIcon.style.transform = 'rotate(0deg)';
					}
				} else {
					// Expand
					chapterItem.classList.add('expanded');
					if (chapterContent) {
						chapterContent.style.display = 'block';
					}
					if (toggleIcon) {
						toggleIcon.style.transform = 'rotate(180deg)';
					}
				}
			});
		});
		
		// Prevent chapter header link from triggering when clicking toggle
		const chapterHeaders = document.querySelectorAll('.sidebar-chapter-header');
		chapterHeaders.forEach(function(header) {
			header.addEventListener('click', function(e) {
				// If clicking on the toggle button, don't navigate
				if (e.target.closest('.chapter-toggle')) {
					return;
				}
				// Otherwise, allow navigation via the link
			});
		});
		
	});
	
	// Quiz functionality
	<?php if ( $show_quiz && $quiz_data && is_user_logged_in() && ! $show_quiz_results ) : ?>
	var academyQuizData = {
		quizId: <?php echo esc_js( $quiz_data['id'] ); ?>,
		chapterId: <?php echo esc_js( $chapter_id ); ?>,
		totalQuestions: <?php echo esc_js( $quiz_data['total_questions'] ); ?>,
		currentQuestion: <?php echo esc_js( $quiz_current_question ); ?>,
		ajaxUrl: '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>',
		nonce: '<?php echo wp_create_nonce( 'academy_quiz_answer_nonce' ); ?>',
		quizUrl: '<?php echo esc_js( remove_query_arg( array( 'topic', 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id ) ) ); ?>' // Base URL without quiz params
	};
	
	// Auto-save answer when user selects an option
	jQuery(document).ready(function($) {
		
		// Ensure navigation buttons work - explicitly allow navigation
		$('.quiz-next-btn, .quiz-prev-btn, .quiz-skip-btn, .quiz-retake-btn').on('click', function(e) {
			var href = $(this).attr('href');
			if (href && href !== '#' && href !== '') {
				// Allow navigation to proceed
				window.location.href = href;
				return false; // Prevent any other handlers
			}
		});
		
		$('.option-label input[type="radio"]').on('change', function() {
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
				success: function(response) {
					if (response.success) {
						console.log('Answer saved for question ' + (questionIndex + 1));
					}
				},
				error: function() {
					console.error('Failed to save answer');
				}
			});
		});
		
		// Submit quiz
		$('#quiz-final-submit').on('click', function(e) {
			e.preventDefault();
			
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
				'action': '<?php echo esc_js( admin_url( 'admin-post.php' ) ); ?>'
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
				'value': <?php echo esc_js( $chapter_id ); ?>
			}));
			
			$.each(allAnswers, function(index, answer) {
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
	<?php if ( $show_quiz ) : ?>
	document.addEventListener('DOMContentLoaded', function() {
		var quizContent = document.getElementById('quiz-content');
		if (quizContent) {
			setTimeout(function() {
				quizContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}, 100);
		}
	});
	<?php endif; ?>
	
	// Retake Quiz button handler (works on results page)
	jQuery(document).ready(function($) {
		$('.quiz-retake-btn').on('click', function(e) {
			var href = $(this).attr('href');
			if (href && href !== '#' && href !== '') {
				// Navigate directly
				window.location.href = href;
				return false; // Prevent any other handlers
			}
		});
	});
	</script>

<?php
endwhile;
get_footer();

