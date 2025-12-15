<?php
/**
 * Handle Quiz Submission
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle quiz form submission
 * Uses saved answers from database (auto-saved as user progresses)
 */
function vested_academy_handle_quiz_submission() {
	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'academy_quiz_answer_nonce' ) ) {
		wp_die( 'Security check failed' );
	}
	
	// Check if user is logged in
	if ( ! is_user_logged_in() ) {
		wp_redirect( wp_login_url() );
		exit;
	}
	
	$user_id = get_current_user_id();
	$quiz_id = isset( $_POST['quiz_id'] ) ? intval( $_POST['quiz_id'] ) : 0;
	$chapter_id = null;
	$module_id = null;
	
	if ( ! $quiz_id ) {
		wp_redirect( home_url( '/academy' ) );
		exit;
	}
	
	// Check if quiz_id is a quiz post type or module post type
	$post_type = get_post_type( $quiz_id );
	
	if ( $post_type === 'quiz' ) {
		// New method: quiz is a separate post type
		// Get quiz questions from quiz post
		$questions = get_field( 'quiz_questions', $quiz_id );
		if ( ! $questions ) {
			$questions = array();
		}
		
		// Try to find the module/chapter that contains this quiz
		// Search for modules that have this quiz in quiz_links
		$modules_with_quiz = get_posts( array(
			'post_type' => 'module',
			'meta_query' => array(
				array(
					'key' => 'quiz_links',
					'value' => $quiz_id,
					'compare' => 'LIKE',
				),
			),
			'posts_per_page' => 1,
		) );
		
		if ( ! empty( $modules_with_quiz ) ) {
			$chapter_id = $modules_with_quiz[0]->ID;
			// Get module ID from chapter's taxonomy
			$terms = get_the_terms( $chapter_id, 'modules' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$module_id = $terms[0]->term_id;
			}
		}
	} elseif ( $post_type === 'module' ) {
		// Old method: quiz is stored on chapter (backward compatibility)
		$chapter_id = $quiz_id;
		
		// Get module ID from chapter
		$terms = get_the_terms( $chapter_id, 'modules' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$module_id = $terms[0]->term_id;
		}
		
		// Try to get quiz from quiz_links first
		$module_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
		if ( ! empty( $module_quizzes ) ) {
			// Use first quiz
			$quiz_post = $module_quizzes[0];
			$quiz_id = $quiz_post['id']; // Update quiz_id to the actual quiz post
			$questions = get_field( 'quiz_questions', $quiz_id );
		} else {
			// Fallback: get quiz questions from chapter (old method)
			$questions = get_field( 'quiz_questions', $chapter_id );
		}
		
		if ( ! $questions ) {
			$questions = array();
		}
	} else {
		// Invalid post type
		wp_redirect( home_url( '/academy' ) );
		exit;
	}
	
	$total_questions = count( $questions );
	$correct_answers = 0;
	$user_answers = array();
	
	// Get saved answers from database (auto-saved as user progressed)
	global $wpdb;
	$answers_table = $wpdb->prefix . 'academy_quiz_answers';
	$saved_answers_db = $wpdb->get_results( $wpdb->prepare(
		"SELECT question_index, user_answer FROM $answers_table WHERE user_id = %d AND quiz_id = %d",
		$user_id,
		$quiz_id
	), ARRAY_A );
	
	// Also check POST data for any last-minute answers
	$post_answers = array();
	foreach ( $_POST as $key => $value ) {
		if ( strpos( $key, 'question_' ) === 0 ) {
			$q_index = intval( str_replace( 'question_', '', $key ) );
			$post_answers[ $q_index ] = sanitize_text_field( $value );
		}
	}
	
	// Merge: POST answers override saved answers (in case user changed answer)
	$all_answers = array();
	foreach ( $saved_answers_db as $saved ) {
		$all_answers[ $saved['question_index'] ] = $saved['user_answer'];
	}
	foreach ( $post_answers as $index => $answer ) {
		$all_answers[ $index ] = $answer;
		// Also save to database
		vested_academy_save_quiz_answer( $user_id, $quiz_id, $index, $answer );
	}
	
	// Check each answer
	foreach ( $questions as $index => $question ) {
		$user_answer = isset( $all_answers[ $index ] ) ? trim( $all_answers[ $index ] ) : '';
		$correct_answer = isset( $question['correct_answer'] ) ? trim( $question['correct_answer'] ) : '';
		
		// Get the correct answer value by matching against options
		// The correct_answer field might contain: full text, option value, or option index
		$correct_answer_value = $correct_answer;
		$options = isset( $question['options'] ) ? $question['options'] : array();
		
		if ( ! empty( $options ) ) {
			// First, check if correct_answer is a numeric index (0, 1, 2, 3)
			if ( is_numeric( $correct_answer ) && isset( $options[ intval( $correct_answer ) ] ) ) {
				$option = $options[ intval( $correct_answer ) ];
				$correct_answer_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : intval( $correct_answer ) ) : $option;
			} else {
				// Check if correct_answer is a letter (A, B, C, D) - map to index
				$letter_to_index = array( 'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5 );
				$correct_answer_upper = strtoupper( trim( $correct_answer ) );
				if ( isset( $letter_to_index[ $correct_answer_upper ] ) && isset( $options[ $letter_to_index[ $correct_answer_upper ] ] ) ) {
					$option = $options[ $letter_to_index[ $correct_answer_upper ] ];
					$correct_answer_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : $letter_to_index[ $correct_answer_upper ] ) : $option;
				} else {
					// Check if correct_answer matches any option value or label
					foreach ( $options as $option_index => $option ) {
						$option_value = is_array( $option ) ? ( isset( $option['value'] ) ? $option['value'] : $option_index ) : $option;
						$option_label = is_array( $option ) ? ( isset( $option['label'] ) ? $option['label'] : $option_value ) : $option;
						
						// Normalize for comparison (trim and case-insensitive for text matching)
						$option_value_trimmed = trim( (string) $option_value );
						$option_label_trimmed = trim( (string) $option_label );
						$correct_answer_trimmed = trim( (string) $correct_answer );
						
						// If correct_answer matches the option value (exact or trimmed)
						if ( $correct_answer === $option_value || $correct_answer_trimmed === $option_value_trimmed ) {
							$correct_answer_value = $option_value;
							break;
						}
						// If correct_answer matches the option label (exact or trimmed, case-insensitive for text)
						if ( $correct_answer === $option_label || 
							 $correct_answer_trimmed === $option_label_trimmed ||
							 strtolower( $correct_answer_trimmed ) === strtolower( $option_label_trimmed ) ) {
							$correct_answer_value = $option_value;
							break;
						}
					}
				}
			}
		}
		
		// Normalize both values for comparison
		$user_answer_normalized = trim( (string) $user_answer );
		$correct_answer_normalized = trim( (string) $correct_answer_value );
		
		// Compare: exact match, trimmed match, or case-insensitive match
		$is_correct = ( 
			$user_answer === $correct_answer_value || 
			$user_answer_normalized === $correct_answer_normalized ||
			strtolower( $user_answer_normalized ) === strtolower( $correct_answer_normalized )
		);
		
		$user_answers[ $index ] = array(
			'user_answer' => $user_answer,
			'correct_answer' => $correct_answer_value,
			'correct_answer_raw' => $correct_answer, // Store original for debugging
			'is_correct' => $is_correct,
		);
		
		if ( $is_correct ) {
			$correct_answers++;
		}
	}
	
	// Track quiz attempt
	$result = vested_academy_track_quiz_attempt( $user_id, $quiz_id, $module_id, $correct_answers, $total_questions );
	
	// Store user answers in transient for results display
	set_transient( 'academy_quiz_results_' . $user_id . '_' . $quiz_id, array(
		'score' => $correct_answers,
		'total' => $total_questions,
		'percentage' => $result['percentage'],
		'status' => $result['status'],
		'answers' => $user_answers,
		'questions' => $questions,
	), 3600 ); // Store for 1 hour
	
	// Redirect to chapter page with quiz results
	// quiz_id is the chapter_id
	$redirect_url = home_url( '/academy' );
	
	if ( $chapter_id ) {
		// Redirect back to the chapter page where quiz was taken
		$redirect_url = get_permalink( $chapter_id );
	} elseif ( $module_id ) {
		// Find the first chapter in the module to redirect to
		$chapters_query = new WP_Query( array(
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
		) );
		
		if ( $chapters_query->have_posts() ) {
			$chapters_query->the_post();
			$redirect_url = get_permalink();
			wp_reset_postdata();
		}
	}
	
	// Add quiz and results parameters
	$redirect_url = add_query_arg( array(
		'quiz' => '1',
		'results' => '1'
	), $redirect_url ) . '#quiz-content';
	
	wp_redirect( $redirect_url );
	exit;
}
add_action( 'admin_post_academy_quiz_submit', 'vested_academy_handle_quiz_submission' );
add_action( 'admin_post_nopriv_academy_quiz_submit', 'vested_academy_handle_quiz_submission' );

