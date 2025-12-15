<?php
/**
 * Template Name: Academy Dashboard
 * 
 * User dashboard for Academy progress tracking
 * 
 * @package Vested Finance WP
 */

get_header();

if ( ! is_user_logged_in() ) {
	wp_redirect( wp_login_url( get_permalink() ) );
	exit;
}

$user_id = get_current_user_id();
$user_progress = vested_academy_get_user_progress( $user_id );

// Get all modules
$modules = get_terms( array(
	'taxonomy' => 'modules',
	'hide_empty' => false,
	'exclude' => array(), // Exclude glossary if needed
) );

// Organize progress by module
$progress_by_module = array();
foreach ( $user_progress as $progress ) {
	if ( $progress->module_id ) {
		if ( ! isset( $progress_by_module[ $progress->module_id ] ) ) {
			$progress_by_module[ $progress->module_id ] = array(
				'chapters_completed' => 0,
				'chapters_total' => 0,
				'quizzes_completed' => 0,
				'quizzes_total' => 0,
				'overall_progress' => 0,
			);
		}
		
		if ( $progress->progress_type === 'chapter' && $progress->status === 'completed' ) {
			$progress_by_module[ $progress->module_id ]['chapters_completed']++;
		}
		if ( $progress->progress_type === 'quiz' && $progress->status === 'completed' ) {
			$progress_by_module[ $progress->module_id ]['quizzes_completed']++;
		}
	}
}

// Calculate total chapters and quizzes per module
foreach ( $modules as $module ) {
	$module_id = $module->term_id;
	
		// Count chapters in module
		$chapters_query = new WP_Query( array(
			'post_type' => 'module',
			'tax_query' => array(
				array(
					'taxonomy' => 'modules',
					'field' => 'term_id',
					'terms' => $module_id,
				),
			),
			'posts_per_page' => -1,
		) );
	
	// Count chapters with quizzes in module
	// Quizzes are now stored directly on chapters via ACF fields
	$quizzes_query = new WP_Query( array(
		'post_type' => 'module',
		'tax_query' => array(
			array(
				'taxonomy' => 'modules',
				'field' => 'term_id',
				'terms' => $module_id,
			),
		),
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'quiz_questions',
				'compare' => 'EXISTS',
			),
		),
	) );
	
	if ( ! isset( $progress_by_module[ $module_id ] ) ) {
		$progress_by_module[ $module_id ] = array(
			'chapters_completed' => 0,
			'chapters_total' => $chapters_query->found_posts,
			'quizzes_completed' => 0,
			'quizzes_total' => $quizzes_query->found_posts,
			'overall_progress' => 0,
		);
	} else {
		$progress_by_module[ $module_id ]['chapters_total'] = $chapters_query->found_posts;
		$progress_by_module[ $module_id ]['quizzes_total'] = $quizzes_query->found_posts;
	}
	
	// Calculate overall progress
	$total_items = $progress_by_module[ $module_id ]['chapters_total'] + $progress_by_module[ $module_id ]['quizzes_total'];
	$completed_items = $progress_by_module[ $module_id ]['chapters_completed'] + $progress_by_module[ $module_id ]['quizzes_completed'];
	
	if ( $total_items > 0 ) {
		$progress_by_module[ $module_id ]['overall_progress'] = round( ( $completed_items / $total_items ) * 100 );
	}
	
	wp_reset_postdata();
}
?>

<div id="academy-dashboard" class="academy-dashboard-page">
	<div class="container">
		<div class="academy-dashboard-header">
			<h1>My Academy Dashboard</h1>
			<p class="dashboard-subtitle">Track your learning progress and achievements</p>
		</div>
		
		<div class="academy-dashboard-content">
			<?php if ( ! empty( $modules ) ) : ?>
				<div class="academy-modules-grid">
					<?php foreach ( $modules as $module ) : 
						$module_id = $module->term_id;
						$module_link = get_term_link( $module );
						$module_progress = isset( $progress_by_module[ $module_id ] ) ? $progress_by_module[ $module_id ] : array(
							'chapters_completed' => 0,
							'chapters_total' => 0,
							'quizzes_completed' => 0,
							'quizzes_total' => 0,
							'overall_progress' => 0,
						);
						
						$module_image = get_field( 'module_image', $module );
						$module_description = $module->description;
						if ( strlen( $module_description ) > 150 ) {
							$module_description = substr( $module_description, 0, 150 ) . '...';
						}
						?>
						<div class="academy-module-card">
							<?php if ( $module_image ) : ?>
								<div class="module-card-image">
									<img src="<?php echo esc_url( $module_image ); ?>" alt="<?php echo esc_attr( $module->name ); ?>">
								</div>
							<?php endif; ?>
							
							<div class="module-card-content">
								<h3 class="module-card-title">
									<a href="<?php echo esc_url( $module_link ); ?>"><?php echo esc_html( $module->name ); ?></a>
								</h3>
								
								<?php if ( $module_description ) : ?>
									<p class="module-card-description"><?php echo esc_html( $module_description ); ?></p>
								<?php endif; ?>
								
								<div class="module-card-progress">
									<div class="progress-bar-container">
										<div class="progress-bar" style="width: <?php echo esc_attr( $module_progress['overall_progress'] ); ?>%"></div>
									</div>
									<div class="progress-stats">
										<span class="progress-percentage"><?php echo esc_html( $module_progress['overall_progress'] ); ?>% Complete</span>
										<span class="progress-details">
											<?php echo esc_html( $module_progress['chapters_completed'] ); ?>/<?php echo esc_html( $module_progress['chapters_total'] ); ?> Chapters
											<?php if ( $module_progress['quizzes_total'] > 0 ) : ?>
												• <?php echo esc_html( $module_progress['quizzes_completed'] ); ?>/<?php echo esc_html( $module_progress['quizzes_total'] ); ?> Quizzes
											<?php endif; ?>
										</span>
									</div>
								</div>
								
								<div class="module-card-actions">
									<a href="<?php echo esc_url( $module_link ); ?>" class="module-card-button">
										<?php echo $module_progress['overall_progress'] > 0 ? 'Continue Learning' : 'Start Learning'; ?>
									</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="academy-no-modules">
					<p>No modules available yet. Check back soon!</p>
				</div>
			<?php endif; ?>
		</div>
		
		<!-- Recent Activity -->
		<?php if ( ! empty( $user_progress ) ) : ?>
			<div class="academy-recent-activity">
				<h2>Recent Activity</h2>
				<div class="activity-list">
					<?php
					$recent_progress = array_slice( $user_progress, 0, 5 );
					foreach ( $recent_progress as $progress ) :
						$item_title = '';
						$item_link = '';
						
						if ( $progress->progress_type === 'chapter' && $progress->chapter_id ) {
							$item_title = get_the_title( $progress->chapter_id );
							$item_link = get_permalink( $progress->chapter_id );
						} elseif ( $progress->progress_type === 'quiz' && $progress->quiz_id ) {
							$item_title = get_the_title( $progress->quiz_id );
							$item_link = get_permalink( $progress->quiz_id );
						}
						
						if ( ! $item_title ) continue;
						?>
						<div class="activity-item">
							<div class="activity-icon">
								<?php if ( $progress->progress_type === 'quiz' ) : ?>
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M10 2.5L12.5 7.5L18.5 8.5L14.5 12.5L15.5 18.5L10 15.5L4.5 18.5L5.5 12.5L1.5 8.5L7.5 7.5L10 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								<?php else : ?>
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M2.5 5.83333H17.5M2.5 10H17.5M2.5 14.1667H17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
									</svg>
								<?php endif; ?>
							</div>
							<div class="activity-content">
								<h4>
									<a href="<?php echo esc_url( $item_link ); ?>"><?php echo esc_html( $item_title ); ?></a>
								</h4>
								<p class="activity-meta">
									<?php
									if ( $progress->progress_type === 'quiz' ) {
										echo 'Quiz Score: ' . esc_html( $progress->progress_percentage ) . '%';
									} else {
										echo 'Chapter Completed';
									}
									?>
									<span class="activity-date"><?php echo esc_html( human_time_diff( strtotime( $progress->completed_at ?: $progress->started_at ), current_time( 'timestamp' ) ) . ' ago' ); ?></span>
								</p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();

