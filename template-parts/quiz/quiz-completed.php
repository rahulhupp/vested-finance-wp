<?php
/**
 * Quiz Completed (No Retake) Template Part
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$module_id = isset( $module_id ) ? $module_id : ( isset( $module_id_for_completed ) ? $module_id_for_completed : null );
?>

<div class="quiz-completed-view">
	<div class="quiz-completed-content">
		<div class="quiz-completed-icon">✓</div>
		<h2 class="quiz-completed-title">Quiz Completed</h2>
		<p class="quiz-completed-message">You have already completed this quiz. Retakes are not allowed for this quiz.</p>
		
		<?php if ( $module_id ) : ?>
			<a href="<?php echo esc_url( get_term_link( $module_id ) ); ?>" class="quiz-back-btn">Back to Module</a>
		<?php endif; ?>
	</div>
</div>

