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
			<?php
			// Get score percentage (0-100)
			$score_percentage = isset( $previous_attempt->progress_percentage ) ? floatval( $previous_attempt->progress_percentage ) : 0;
			// Ensure score is between 0 and 100
			$score_percentage = max( 0, min( 100, $score_percentage ) );
			// Calculate rotation angle: 0% = 226°, 100% = 406°
			// Formula: 226 + (score/100 * 180)
			$min_angle = 226;
			$max_angle = 406;
			$rotation_angle = $min_angle + ( ( $score_percentage / 100 ) * ( $max_angle - $min_angle ) );
			// Pivot point coordinates
			$pivot_x = 131.298;
			$pivot_y = 120.696;
			?>
			<svg width="260" height="169" viewBox="0 0 260 169" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M10.6035 120.696C10.6035 88.6858 23.3197 57.9862 45.9547 35.3512C68.5897 12.7162 99.2893 3.43425e-06 131.3 0C163.311 -3.43425e-06 194.01 12.7162 216.645 35.3512C239.28 57.9861 251.996 88.6858 251.996 120.696L224.039 120.696C224.039 96.1006 214.268 72.5121 196.876 55.1202C179.484 37.7284 155.896 27.9577 131.3 27.9577C106.704 27.9577 83.1157 37.7284 65.7238 55.1203C48.3319 72.5121 38.5612 96.1006 38.5612 120.696H10.6035Z" fill="url(#paint0_linear_463_12520)"/>
				<g class="quiz-meter-needle" data-target-angle="<?php echo esc_attr( $rotation_angle ); ?>" data-pivot-x="<?php echo esc_attr( $pivot_x ); ?>" data-pivot-y="<?php echo esc_attr( $pivot_y ); ?>" style="--needle-angle: <?php echo esc_attr( $min_angle ); ?>;" transform="rotate(<?php echo esc_attr( $min_angle ); ?>, <?php echo esc_attr( $pivot_x ); ?>, <?php echo esc_attr( $pivot_y ); ?>)">
					<path d="M119.74 130.997L194.705 56.0315L131.359 112.266L119.74 130.997Z" fill="#002852"/>
					<path d="M119.74 130.997L194.705 56.0315L138.471 119.378L119.74 130.997Z" fill="#002852"/>
					<g filter="url(#filter0_d_463_12520)">
					<circle cx="131.298" cy="120.696" r="7.54353" fill="white"/>
					</g>
				</g>
				<path d="M21.5453 142.504V159.219H19.2273L10.731 146.961H10.5759V159.219H8.05393V142.504H10.3882L18.8927 154.78H19.0478V142.504H21.5453ZM29.8493 159.472C28.674 159.472 27.6483 159.203 26.7723 158.664C25.8963 158.126 25.2161 157.372 24.7318 156.404C24.2476 155.435 24.0055 154.303 24.0055 153.008C24.0055 151.708 24.2476 150.571 24.7318 149.597C25.2161 148.623 25.8963 147.867 26.7723 147.328C27.6483 146.789 28.674 146.52 29.8493 146.52C31.0245 146.52 32.0502 146.789 32.9262 147.328C33.8022 147.867 34.4824 148.623 34.9667 149.597C35.4509 150.571 35.693 151.708 35.693 153.008C35.693 154.303 35.4509 155.435 34.9667 156.404C34.4824 157.372 33.8022 158.126 32.9262 158.664C32.0502 159.203 31.0245 159.472 29.8493 159.472ZM29.8574 157.424C30.6192 157.424 31.2503 157.223 31.7509 156.82C32.2515 156.417 32.6215 155.881 32.8609 155.212C33.1058 154.543 33.2282 153.806 33.2282 153C33.2282 152.2 33.1058 151.466 32.8609 150.797C32.6215 150.122 32.2515 149.58 31.7509 149.172C31.2503 148.764 30.6192 148.56 29.8574 148.56C29.0902 148.56 28.4536 148.764 27.9476 149.172C27.447 149.58 27.0743 150.122 26.8294 150.797C26.59 151.466 26.4703 152.2 26.4703 153C26.4703 153.806 26.59 154.543 26.8294 155.212C27.0743 155.881 27.447 156.417 27.9476 156.82C28.4536 157.223 29.0902 157.424 29.8574 157.424ZM48.2554 146.683L43.7093 159.219H41.0976L36.5433 146.683H39.1633L42.3382 156.33H42.4688L45.6355 146.683H48.2554ZM50.0892 159.219V146.683H52.5296V159.219H50.0892ZM51.3216 144.749C50.8972 144.749 50.5326 144.607 50.2279 144.324C49.9287 144.036 49.7791 143.693 49.7791 143.296C49.7791 142.893 49.9287 142.551 50.2279 142.268C50.5326 141.979 50.8972 141.835 51.3216 141.835C51.746 141.835 52.1079 141.979 52.4071 142.268C52.7118 142.551 52.8642 142.893 52.8642 143.296C52.8642 143.693 52.7118 144.036 52.4071 144.324C52.1079 144.607 51.746 144.749 51.3216 144.749ZM60.6336 159.472C59.4202 159.472 58.3755 159.198 57.4995 158.648C56.6289 158.093 55.9596 157.329 55.4917 156.355C55.0237 155.381 54.7898 154.265 54.7898 153.008C54.7898 151.735 55.0292 150.612 55.508 149.638C55.9868 148.658 56.6615 147.894 57.5321 147.344C58.4027 146.795 59.4284 146.52 60.6091 146.52C61.5613 146.52 62.4101 146.697 63.1555 147.05C63.901 147.399 64.5022 147.888 64.9593 148.519C65.4218 149.151 65.6966 149.888 65.7836 150.731H63.4086C63.278 150.144 62.9787 149.638 62.5108 149.213C62.0483 148.789 61.428 148.577 60.6499 148.577C59.9698 148.577 59.3739 148.756 58.8625 149.115C58.3565 149.469 57.962 149.975 57.679 150.633C57.3961 151.286 57.2546 152.059 57.2546 152.951C57.2546 153.865 57.3934 154.654 57.6709 155.318C57.9484 155.982 58.3401 156.496 58.8462 156.861C59.3576 157.225 59.9589 157.408 60.6499 157.408C61.1124 157.408 61.5314 157.323 61.9068 157.155C62.2877 156.98 62.606 156.733 62.8617 156.412C63.1229 156.091 63.3052 155.704 63.4086 155.253H65.7836C65.6966 156.064 65.4327 156.787 64.9919 157.424C64.5512 158.061 63.9608 158.561 63.2208 158.926C62.4863 159.29 61.6239 159.472 60.6336 159.472ZM73.3367 159.472C72.1016 159.472 71.0378 159.209 70.1455 158.681C69.2586 158.148 68.573 157.399 68.0887 156.436C67.6099 155.468 67.3705 154.333 67.3705 153.033C67.3705 151.749 67.6099 150.617 68.0887 149.638C68.573 148.658 69.2477 147.894 70.1129 147.344C70.9834 146.795 72.0009 146.52 73.1653 146.52C73.8727 146.52 74.5583 146.637 75.2221 146.871C75.8859 147.105 76.4817 147.472 77.0095 147.973C77.5373 148.473 77.9536 149.123 78.2583 149.923C78.563 150.718 78.7153 151.683 78.7153 152.821V153.686H68.7498V151.858H76.3239C76.3239 151.216 76.1933 150.647 75.9322 150.152C75.671 149.651 75.3037 149.257 74.8303 148.968C74.3624 148.68 73.8128 148.536 73.1817 148.536C72.4961 148.536 71.8976 148.704 71.3861 149.042C70.8801 149.374 70.4883 149.809 70.2108 150.348C69.9387 150.881 69.8027 151.46 69.8027 152.086V153.514C69.8027 154.352 69.9496 155.065 70.2434 155.653C70.5427 156.24 70.959 156.689 71.4922 156.999C72.0254 157.304 72.6484 157.457 73.3612 157.457C73.8237 157.457 74.2454 157.391 74.6263 157.261C75.0072 157.125 75.3364 156.923 75.6139 156.657C75.8914 156.39 76.1036 156.061 76.2505 155.669L78.5602 156.085C78.3752 156.766 78.0433 157.361 77.5645 157.873C77.0911 158.379 76.4953 158.773 75.7771 159.056C75.0643 159.334 74.2508 159.472 73.3367 159.472Z" fill="black"/>
				<path d="M225.415 159.526V142.811H231.373C232.674 142.811 233.751 143.048 234.605 143.521C235.46 143.994 236.099 144.642 236.523 145.464C236.948 146.28 237.16 147.199 237.16 148.222C237.16 149.251 236.945 150.176 236.515 150.997C236.091 151.813 235.449 152.461 234.589 152.94C233.735 153.413 232.66 153.65 231.365 153.65H227.268V151.511H231.137C231.958 151.511 232.625 151.37 233.136 151.087C233.648 150.799 234.023 150.407 234.263 149.912C234.502 149.417 234.622 148.853 234.622 148.222C234.622 147.591 234.502 147.031 234.263 146.541C234.023 146.051 233.645 145.668 233.128 145.39C232.617 145.113 231.942 144.974 231.104 144.974H227.937V159.526H225.415ZM239.461 159.526V146.99H241.82V148.981H241.95C242.179 148.307 242.582 147.776 243.158 147.39C243.741 146.998 244.399 146.802 245.133 146.802C245.286 146.802 245.465 146.808 245.672 146.818C245.884 146.829 246.05 146.843 246.17 146.859V149.193C246.072 149.166 245.898 149.136 245.648 149.104C245.397 149.066 245.147 149.047 244.897 149.047C244.32 149.047 243.806 149.169 243.354 149.414C242.908 149.653 242.554 149.988 242.293 150.418C242.032 150.842 241.901 151.326 241.901 151.871V159.526H239.461ZM252.654 159.779C251.479 159.779 250.453 159.51 249.577 158.971C248.701 158.433 248.021 157.679 247.537 156.71C247.052 155.742 246.81 154.61 246.81 153.315C246.81 152.015 247.052 150.878 247.537 149.904C248.021 148.93 248.701 148.173 249.577 147.635C250.453 147.096 251.479 146.827 252.654 146.827C253.829 146.827 254.855 147.096 255.731 147.635C256.607 148.173 257.287 148.93 257.771 149.904C258.256 150.878 258.498 152.015 258.498 153.315C258.498 154.61 258.256 155.742 257.771 156.71C257.287 157.679 256.607 158.433 255.731 158.971C254.855 159.51 253.829 159.779 252.654 159.779ZM252.662 157.731C253.424 157.731 254.055 157.529 254.556 157.127C255.056 156.724 255.426 156.188 255.666 155.519C255.91 154.85 256.033 154.112 256.033 153.307C256.033 152.507 255.91 151.773 255.666 151.103C255.426 150.429 255.056 149.887 254.556 149.479C254.055 149.071 253.424 148.867 252.662 148.867C251.895 148.867 251.258 149.071 250.752 149.479C250.252 149.887 249.879 150.429 249.634 151.103C249.395 151.773 249.275 152.507 249.275 153.307C249.275 154.112 249.395 154.85 249.634 155.519C249.879 156.188 250.252 156.724 250.752 157.127C251.258 157.529 251.895 157.731 252.662 157.731Z" fill="black"/>
				<defs>
				<filter id="filter0_d_463_12520" x="113.697" y="103.095" width="35.203" height="35.2031" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
				<feFlood flood-opacity="0" result="BackgroundImageFix"/>
				<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
				<feOffset/>
				<feGaussianBlur stdDeviation="5.02902"/>
				<feComposite in2="hardAlpha" operator="out"/>
				<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.4 0"/>
				<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_463_12520"/>
				<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_463_12520" result="shape"/>
				</filter>
				<linearGradient id="paint0_linear_463_12520" x1="16.2624" y1="120.696" x2="246.34" y2="120.696" gradientUnits="userSpaceOnUse">
				<stop offset="0.00788551" stop-color="#ED7575"/>
				<stop offset="0.54401" stop-color="#E29209"/>
				<stop offset="1" stop-color="#05A86B"/>
				</linearGradient>
				</defs>
			</svg>
		</div>
		<div class="quiz-results-text">
			<h2 class="quiz-congratulations">Congratulations!</h2>
			<p class="quiz-score-text">You have scored <?php echo esc_html( $previous_attempt->progress_percentage ); ?>%</p>
			<?php /*
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
			*/ ?>
			
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
</div>

<script>
(function() {
	function animateNeedle() {
		var needle = document.querySelector('.quiz-meter-needle');
		if (!needle) return;
		
		var targetAngle = parseFloat(needle.getAttribute('data-target-angle')) || 226;
		var pivotX = parseFloat(needle.getAttribute('data-pivot-x')) || 131.298;
		var pivotY = parseFloat(needle.getAttribute('data-pivot-y')) || 120.696;
		var startAngle = 226;
		
		needle.setAttribute('transform', 'rotate(' + startAngle + ', ' + pivotX + ', ' + pivotY + ')');
		
		requestAnimationFrame(function() {
			setTimeout(function() {
				var startTime = null;
				var duration = 1500;
				var angleDiff = targetAngle - startAngle;
				
				function animate(timestamp) {
					if (!startTime) startTime = timestamp;
					var elapsed = timestamp - startTime;
					var progress = Math.min(elapsed / duration, 1);
					
					var eased = 1 - Math.pow(1 - progress, 3);
					
					var currentAngle = startAngle + (angleDiff * eased);
					
					needle.setAttribute('transform', 'rotate(' + currentAngle + ', ' + pivotX + ', ' + pivotY + ')');
					
					if (progress < 1) {
						requestAnimationFrame(animate);
					} else {
						needle.setAttribute('transform', 'rotate(' + targetAngle + ', ' + pivotX + ', ' + pivotY + ')');
					}
				}
				
				requestAnimationFrame(animate);
			}, 200);
		});
	}
	
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', animateNeedle);
	} else {
		animateNeedle();
	}
})();
</script>

