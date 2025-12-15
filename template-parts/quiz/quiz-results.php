<?php
/**
 * Quiz Results Template Part
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get quiz data from parent scope (with fallback variable names)
$quiz_id = isset( $quiz_id ) ? $quiz_id : ( isset( $quiz_id_for_results ) ? $quiz_id_for_results : 0 );
$previous_attempt = isset( $previous_attempt ) ? $previous_attempt : ( isset( $previous_attempt_for_results ) ? $previous_attempt_for_results : null );
$passing_score = isset( $passing_score ) ? $passing_score : ( isset( $passing_score_for_results ) ? $passing_score_for_results : 70 );
$total_questions = isset( $total_questions ) ? $total_questions : ( isset( $total_questions_for_results ) ? $total_questions_for_results : 0 );
$module_id = isset( $module_id ) ? $module_id : ( isset( $module_id_for_results ) ? $module_id_for_results : null );
$allow_retake = isset( $allow_retake ) ? $allow_retake : ( isset( $allow_retake_for_results ) ? $allow_retake_for_results : true );
?>

<div class="quiz-results-view">
	<div class="quiz-results-content">
		<div class="quiz-trophy-icon">
			<svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M60 20L70 40H90L75 52L80 72L60 62L40 72L45 52L30 40H50L60 20Z" fill="#FFD700" stroke="#FFA500" stroke-width="2"/>
				<path d="M50 80H70V100H50V80Z" fill="#FFD700"/>
				<rect x="45" y="100" width="30" height="10" rx="5" fill="#FFD700"/>
			</svg>
		</div>
		<h2 class="quiz-congratulations">Congratulations!</h2>
		<p class="quiz-score-text">You have scored <?php echo esc_html( $previous_attempt->progress_percentage ); ?>%</p>
		<p class="quiz-score-details">You answered <?php echo esc_html( $previous_attempt->quiz_score ); ?> out of <?php echo esc_html( $total_questions ); ?> questions correctly</p>
		
		<?php if ( $previous_attempt->progress_percentage >= $passing_score ) : ?>
			<div class="quiz-passed-badge">
				<span class="badge-icon">✓</span>
				<span class="badge-text">Passed</span>
			</div>
		<?php else : ?>
			<div class="quiz-failed-badge">
				<span class="badge-icon">✗</span>
				<span class="badge-text">Failed</span>
				<p class="badge-message">You need <?php echo esc_html( $passing_score ); ?>% to pass. Keep learning!</p>
			</div>
		<?php endif; ?>
		
		<?php
		// Get next chapter or module
		$next_chapter = null;
		$current_chapter_id = isset( $chapter_id_for_results ) ? $chapter_id_for_results : ( isset( $chapter_id ) ? $chapter_id : get_the_ID() );
		
		if ( $module_id && $current_chapter_id ) {
			// Get all chapters in the module
			$all_chapters_query = new WP_Query( array(
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
			) );
			
			// Find current chapter index and get next one
			$current_index = -1;
			$chapters_list = array();
			
			if ( $all_chapters_query->have_posts() ) {
				$index = 0;
				while ( $all_chapters_query->have_posts() ) {
					$all_chapters_query->the_post();
					$chapter_post_id = get_the_ID();
					$chapters_list[] = array(
						'id' => $chapter_post_id,
						'title' => get_the_title(),
						'url' => get_permalink( $chapter_post_id ),
					);
					
					if ( $chapter_post_id == $current_chapter_id ) {
						$current_index = $index;
					}
					$index++;
				}
				wp_reset_postdata();
				
				// Get next chapter if exists
				if ( $current_index >= 0 && isset( $chapters_list[ $current_index + 1 ] ) ) {
					$next_chapter = $chapters_list[ $current_index + 1 ];
				}
			}
		}
		?>
		
		<div class="quiz-results-actions">
			<?php if ( $allow_retake ) : ?>
				<?php
				// Get chapter ID (quiz is stored on chapter)
				$chapter_id_for_retake = isset( $chapter_id_for_results ) ? $chapter_id_for_results : ( isset( $quiz_id_for_results ) ? $quiz_id_for_results : get_the_ID() );
				
				// Build retake URL - remove existing query params and add retake
				$retake_url = remove_query_arg( array( 'quiz', 'q', 'results', 'retake' ), get_permalink( $chapter_id_for_retake ) );
				$retake_url = add_query_arg( array( 'quiz' => '1', 'retake' => '1' ), $retake_url );
				$retake_url = $retake_url . '#quiz-content';
				?>
				<a href="<?php echo esc_url( $retake_url ); ?>" class="quiz-retake-btn" onclick="return true;">Retake Quiz</a>
			<?php endif; ?>
			
			<?php if ( $next_chapter ) : 
				// Get topics for next chapter (CPT helper preferred)
				$next_chapter_topics = array();
				if ( function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
					$next_chapter_topics = vested_academy_get_topics_for_chapter( $next_chapter['id'] );
				}
				if ( empty( $next_chapter_topics ) ) {
					$next_chapter_topics = get_field( 'chapter_topics', $next_chapter['id'] );
					if ( ! $next_chapter_topics || ! is_array( $next_chapter_topics ) ) {
						$next_chapter_topics = array();
					}
				}

				if ( ! empty( $next_chapter_topics ) ) {
					$first_topic = $next_chapter_topics[0];
					if ( isset( $first_topic['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) ) {
						$next_chapter_url = vested_academy_get_topic_url( $next_chapter['id'], $first_topic['topic_slug'] );
					} else {
						$next_chapter_url = add_query_arg( 'topic', 0, $next_chapter['url'] );
					}
				} else {
					// No topics, just go to chapter
					$next_chapter_url = $next_chapter['url'];
				}
			?>
				<a href="<?php echo esc_url( $next_chapter_url ); ?>" class="quiz-proceed-btn">Proceed to Next Chapter</a>
			<?php endif; ?>
		</div>
	</div>
</div>

