<?php
/**
 * Template Name: Academy Module Page
 * 
 * Module detail page with course structure, sidebar, and chapters list
 * 
 * @package Vested Finance WP
 */

get_header();

// Define helper function if not already defined (from single-module-academy.php)
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

// Support both new post type (academy_module) and old taxonomy (modules)
$module_post = null;
$module_term = null;
$module_id = null;
$module_name = '';
$module_description = '';
$module_image = '';
$module_difficulty = 'Beginner';
$module_slug = '';

// Check if this is a module post type
$queried_object = get_queried_object();
if ( $queried_object && isset( $queried_object->post_type ) && $queried_object->post_type === 'academy_module' ) {
    // New structure: Using custom post type
    $module_post = $queried_object;
    $module_id = $module_post->ID;
    $module_name = get_the_title( $module_post->ID );
    $module_description = get_the_content( null, false, $module_post->ID );
    if ( empty( $module_description ) ) {
        $module_description = get_the_excerpt( $module_post->ID );
    }
    $module_image = get_the_post_thumbnail_url( $module_post->ID, 'full' );
    if ( ! $module_image ) {
        $module_image = get_field( 'module_image', $module_post->ID );
    }
    $module_difficulty = get_field( 'difficulty_level', $module_post->ID ) ?: 'Beginner';
    $module_slug = $module_post->post_name;
    
    // Get chapters via ACF relationship field
    $chapters_query = new WP_Query( array(
        'post_type' => 'module',
        'meta_query' => array(
            array(
                'key' => 'academy_module', // ACF relationship field name
                'value' => $module_id,
                'compare' => 'LIKE',
            ),
        ),
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => false,
    ) );
    
    // Fallback: If no ACF relationship, try taxonomy (for migration period)
    if ( ! $chapters_query->have_posts() ) {
        $module_term = get_term_by( 'slug', $queried_object->post_name, 'modules' );
        if ( $module_term ) {
            $chapters_query = new WP_Query( array(
                'post_type' => 'module',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'modules',
                        'field' => 'term_id',
                        'terms' => $module_term->term_id,
                    ),
                ),
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'no_found_rows' => false,
            ) );
        }
    }
} elseif ( $queried_object && isset( $queried_object->taxonomy ) && $queried_object->taxonomy === 'modules' ) {
    // Old structure: Using taxonomy (backward compatibility)
    $module_term = $queried_object;
    $module_id = $module_term->term_id;
    $module_name = $module_term->name;
    $module_description = $module_term->description;
    $module_image = get_field( 'module_image', $module_term );
    $module_difficulty = get_field( 'difficulty_level', $module_term ) ?: 'Beginner';
    $module_slug = $module_term->slug;
    // Fallback: if no image on term, try matching academy_module CPT by slug
    if ( empty( $module_image ) ) {
        $linked_cpt = get_page_by_path( $module_slug, OBJECT, 'academy_module' );
        if ( $linked_cpt ) {
            $module_image = get_the_post_thumbnail_url( $linked_cpt->ID, 'full' );
            if ( ! $module_image ) {
                $module_image = get_field( 'module_image', $linked_cpt->ID );
            }
        }
    }
    
    // Get chapters via taxonomy
    $chapters_query = new WP_Query( array(
        'post_type' => 'module',
        'tax_query' => array(
            array(
                'taxonomy' => 'modules',
                'field' => 'term_id',
                'terms' => $module_id,
                'operator' => 'IN',
            ),
        ),
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'no_found_rows' => false,
    ) );
} else {
    // Invalid - redirect to academy home
    wp_redirect( home_url( '/academy' ) );
    exit;
}

// Quizzes are now stored directly on chapters, not as separate posts
// Count chapters that have quizzes
$total_chapters = $chapters_query->post_count; // Use post_count since we're getting all posts
$total_quizzes = 0; // Will be calculated from chapters if needed

// Calculate total time: chapters + topics + quizzes (same logic as home page and single page)
$total_reading_time_minutes = 0;

// Find next uncompleted chapter for logged-in users
$next_uncompleted_chapter = null;
$user_id = get_current_user_id();
$first_chapter_url = null;

// Store all chapters in an array for reuse and calculate total time
$all_chapters_list = array();
if ( $chapters_query->have_posts() ) {
    while ( $chapters_query->have_posts() ) {
        $chapters_query->the_post();
        $chapter_post_id = get_the_ID();
        $chapter_slug = get_post_field( 'post_name', $chapter_post_id );
        // Build chapter URL using the current module slug to avoid cross-module slugs
        if ( $module_slug ) {
            $chapter_url = home_url( '/academy/' . $module_slug . '/' . $chapter_slug . '/' );
        } else {
            $chapter_url = get_permalink( $chapter_post_id );
        }
        $all_chapters_list[] = array(
            'id' => $chapter_post_id,
            'url' => $chapter_url,
            'title' => get_the_title(),
        );
        
        // Store first chapter URL for fallback
        if ( $first_chapter_url === null ) {
            $first_chapter_url = $chapter_url;
        }
        
        // Calculate total time: add chapter reading time
        $chapter_content = get_post_field( 'post_content', $chapter_post_id );
        $total_reading_time_minutes += calculate_reading_time( $chapter_content );
        
        // Add topics duration for this chapter
        $chapter_topics = array();
        if ( function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
            $chapter_topics = vested_academy_get_topics_for_chapter( $chapter_post_id );
        }
        if ( empty( $chapter_topics ) ) {
            $chapter_topics = get_field( 'chapter_topics', $chapter_post_id );
            if ( ! $chapter_topics || ! is_array( $chapter_topics ) ) {
                $chapter_topics = array();
            }
        }
        
        foreach ( $chapter_topics as $topic ) {
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
            $total_reading_time_minutes += $topic_duration;
        }
        
        // Add quiz time for this chapter
        $chapter_quizzes = array();
        if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
            $chapter_quizzes = vested_academy_get_quizzes_for_module( $chapter_post_id );
        }
        if ( ! empty( $chapter_quizzes ) ) {
            foreach ( $chapter_quizzes as $quiz ) {
                $quiz_time = isset( $quiz['time_limit'] ) ? intval( $quiz['time_limit'] ) : 0;
                $total_reading_time_minutes += $quiz_time;
            }
        }
    }
    wp_reset_postdata();
}

// Format display: show minutes if less than 1 hour, otherwise show hours (match single page format)
if ( $total_reading_time_minutes < 60 ) {
    $total_time_display = $total_reading_time_minutes . ' Minutes';
    $total_hours = round( $total_reading_time_minutes / 60, 1 );
} else {
    $total_hours = round( $total_reading_time_minutes / 60, 1 );
    $total_time_display = $total_hours . ' Hours';
}

// Find next uncompleted chapter for logged-in users
if ( $user_id && ! empty( $all_chapters_list ) ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'academy_progress';
    
    // Get all completed chapters for this user in this module
    $completed_chapters = array();
    $completed_results = $wpdb->get_results( $wpdb->prepare(
        "SELECT chapter_id, completed_at FROM $table_name WHERE user_id = %d AND progress_type = 'chapter' AND status = 'completed'",
        $user_id
    ) );
    
    foreach ( $completed_results as $result ) {
        // Ensure chapter_id is stored as integer for proper comparison
        $completed_chapters[] = (int) $result->chapter_id;
    }
    
    // Find first uncompleted chapter
    foreach ( $all_chapters_list as $chapter ) {
        // Ensure chapter ID is integer for comparison
        $chapter_id_int = (int) $chapter['id'];
        if ( ! in_array( $chapter_id_int, $completed_chapters ) ) {
            $next_uncompleted_chapter = $chapter;
            break;
        }
    }
}

// Debug console - show if ?debug=1 is in URL
$debug_mode = isset( $_GET['debug'] ) && $_GET['debug'] == '1';
if ( $debug_mode ) {
    $debug_user = get_user_by( 'login', 'rahulupadhyayvested' );
    if ( ! $debug_user ) {
        $debug_user = get_user_by( 'email', 'rahulupadhyayvested@example.com' );
    }
    
    if ( $debug_user ) {
        $debug_user_id = $debug_user->ID;
        global $wpdb;
        $table_name = $wpdb->prefix . 'academy_progress';
        
        // Get all completed chapters for debug user
        $debug_completed = $wpdb->get_results( $wpdb->prepare(
            "SELECT chapter_id, module_id, completed_at FROM $table_name WHERE user_id = %d AND progress_type = 'chapter' AND status = 'completed' ORDER BY completed_at ASC",
            $debug_user_id
        ) );
        
        $debug_completed_ids = array();
        foreach ( $debug_completed as $comp ) {
            $debug_completed_ids[] = $comp->chapter_id;
        }
        
        // Get current user's completed chapters
        $current_user_completed = array();
        if ( $user_id ) {
            $current_completed = $wpdb->get_results( $wpdb->prepare(
                "SELECT chapter_id, completed_at FROM $table_name WHERE user_id = %d AND progress_type = 'chapter' AND status = 'completed' ORDER BY completed_at ASC",
                $user_id
            ) );
            foreach ( $current_completed as $comp ) {
                $current_user_completed[] = $comp->chapter_id;
            }
        }
    }
}

// Get similar modules
$similar_modules = array();
if ( $module_post ) {
    // New structure: Get other module posts
    $similar_posts = new WP_Query( array(
        'post_type' => 'academy_module',
        'post__not_in' => array( $module_id ),
        'posts_per_page' => 3,
        'orderby' => 'rand',
    ) );
    if ( $similar_posts->have_posts() ) {
        while ( $similar_posts->have_posts() ) {
            $similar_posts->the_post();
            $similar_modules[] = (object) array(
                'ID' => get_the_ID(),
                'name' => get_the_title(),
                'description' => get_the_excerpt(),
                'term_id' => get_the_ID(),
                'slug' => get_post_field( 'post_name' ),
                'is_post' => true,
            );
        }
        wp_reset_postdata();
    }
} else {
    // Old structure: Get taxonomy terms
    $similar_terms = get_terms( array(
        'taxonomy' => 'modules',
        'hide_empty' => false,
        'exclude' => array( $module_id ),
        'number' => 3,
    ) );
    if ( ! is_wp_error( $similar_terms ) ) {
        $similar_modules = $similar_terms;
    }
}

// DO NOT auto-redirect from module page - let users view the module overview
// The "Start learning" / "Continue Learning" button will take them to the right chapter
?>

<?php if ( $debug_mode ) : ?>
<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 2px solid #333; font-family: monospace; font-size: 12px;">
    <h2 style="color: #d00;">🔍 DEBUG CONSOLE - Module Progress Tracking</h2>
    
    <h3>Current User Info:</h3>
    <ul>
        <li><strong>User ID:</strong> <?php echo $user_id ? esc_html( $user_id ) : 'Not logged in'; ?></li>
        <li><strong>Username:</strong> <?php echo $user_id ? esc_html( wp_get_current_user()->user_login ) : 'N/A'; ?></li>
        <li><strong>Module ID:</strong> <?php echo esc_html( $module_id ); ?></li>
        <li><strong>Module Name:</strong> <?php echo esc_html( $module_name ); ?></li>
    </ul>
    
    <h3>All Chapters in Module (<?php echo count( $all_chapters_list ); ?> total):</h3>
    <ol>
        <?php foreach ( $all_chapters_list as $index => $chapter ) : 
            $is_completed = in_array( $chapter['id'], $completed_chapters );
            $is_next = ( $next_uncompleted_chapter && $next_uncompleted_chapter['id'] == $chapter['id'] );
        ?>
        <li style="margin: 5px 0; padding: 5px; background: <?php echo $is_next ? '#90EE90' : ( $is_completed ? '#FFE4B5' : '#fff' ); ?>;">
            <strong>ID:</strong> <?php echo esc_html( $chapter['id'] ); ?> | 
            <strong>Title:</strong> <?php echo esc_html( $chapter['title'] ); ?> | 
            <strong>Status:</strong> 
            <?php if ( $is_completed ) : ?>
                <span style="color: green;">✓ COMPLETED</span>
            <?php elseif ( $is_next ) : ?>
                <span style="color: blue; font-weight: bold;">→ NEXT UNCOMPLETED (Will redirect here)</span>
            <?php else : ?>
                <span style="color: gray;">Not started</span>
            <?php endif; ?>
            <br>
            <small>URL: <?php echo esc_html( $chapter['url'] ); ?></small>
        </li>
        <?php endforeach; ?>
    </ol>
    
    <h3>Completed Chapters (<?php echo count( $completed_chapters ); ?>):</h3>
    <ul>
        <?php if ( ! empty( $completed_chapters ) ) : ?>
            <?php foreach ( $completed_chapters as $comp_id ) : 
                $comp_chapter = null;
                foreach ( $all_chapters_list as $ch ) {
                    if ( $ch['id'] == $comp_id ) {
                        $comp_chapter = $ch;
                        break;
                    }
                }
            ?>
            <li>
                <strong>Chapter ID:</strong> <?php echo esc_html( $comp_id ); ?> | 
                <strong>Title:</strong> <?php echo $comp_chapter ? esc_html( $comp_chapter['title'] ) : 'Unknown'; ?>
            </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li style="color: gray;">No chapters completed yet</li>
        <?php endif; ?>
    </ul>
    
    <h3>Next Uncompleted Chapter:</h3>
    <?php if ( $next_uncompleted_chapter ) : ?>
        <div style="background: #90EE90; padding: 10px; border: 2px solid #00AA00;">
            <strong>ID:</strong> <?php echo esc_html( $next_uncompleted_chapter['id'] ); ?><br>
            <strong>Title:</strong> <?php echo esc_html( $next_uncompleted_chapter['title'] ); ?><br>
            <strong>URL:</strong> <?php echo esc_html( $next_uncompleted_chapter['url'] ); ?><br>
            <strong>Button will link to:</strong> <?php echo esc_html( $next_uncompleted_chapter['url'] ); ?>
        </div>
    <?php else : ?>
        <div style="background: #FFE4B5; padding: 10px;">
            <strong>All chapters completed!</strong> Or no chapters found.
        </div>
    <?php endif; ?>
    
    <?php if ( isset( $debug_user ) && $debug_user ) : ?>
    <h3>Debug User "rahulupadhyayvested" Progress:</h3>
    <ul>
        <li><strong>User ID:</strong> <?php echo esc_html( $debug_user_id ); ?></li>
        <li><strong>Completed Chapters:</strong> <?php echo count( $debug_completed_ids ); ?></li>
        <li><strong>Chapter IDs:</strong> <?php echo esc_html( implode( ', ', $debug_completed_ids ) ); ?></li>
    </ul>
    <?php endif; ?>
    
    <h3>Database Query Used:</h3>
    <code style="background: #fff; padding: 5px; display: block;">
        SELECT chapter_id FROM <?php echo esc_html( $table_name ); ?> 
        WHERE user_id = <?php echo $user_id ? esc_html( $user_id ) : 'NULL'; ?> 
        AND progress_type = 'chapter' 
        AND status = 'completed'
    </code>
    
    <h3>Raw Database Results:</h3>
    <?php if ( $user_id ) : 
        $raw_results = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d AND progress_type = 'chapter' ORDER BY completed_at DESC",
            $user_id
        ) );
    ?>
        <table style="width: 100%; border-collapse: collapse; background: #fff; margin-top: 10px;">
            <thead>
                <tr style="background: #333; color: #fff;">
                    <th style="padding: 8px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Chapter ID</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Module ID</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Progress %</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Completed At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( ! empty( $raw_results ) ) : ?>
                    <?php foreach ( $raw_results as $row ) : ?>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo esc_html( $row->id ); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo esc_html( $row->chapter_id ); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo esc_html( $row->module_id ); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; color: <?php echo $row->status === 'completed' ? 'green' : 'orange'; ?>;">
                            <?php echo esc_html( $row->status ); ?>
                        </td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo esc_html( $row->progress_percentage ); ?>%</td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo esc_html( $row->completed_at ?: 'Not completed' ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" style="padding: 8px; border: 1px solid #ddd; text-align: center; color: gray;">
                            No progress records found in database
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p style="color: gray;">User not logged in</p>
    <?php endif; ?>
    
    <p style="margin-top: 20px; color: #666;">
        <small>Add <code>?debug=1</code> to URL to see this console. Remove parameter to hide.</small>
    </p>
</div>
<?php endif; ?>

<div id="academy-module-page" class="academy-module-page">
    <!-- Module Header Section -->
    <section class="module-header-section">
        <div class="container">
            <div class="module-header-content">
                <div class="module-header-left">
                    <h1 class="module-title"><?php echo esc_html( $module_name ); ?></h1>
                    <p class="module-description"><?php echo esc_html( $module_description ); ?></p>
                    
                    <div class="module-rating">
                        <div class="rating-stars">
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                        </div>
                        <span class="rating-value">5.0</span>
                        <span class="rating-text">Trusted by 23k+ Students</span>
                    </div>
                    
                    <?php
                    // Determine which chapter to link to
                    $start_chapter_url = $first_chapter_url ?: '#';
                    if ( $next_uncompleted_chapter ) {
                        // User has progress - redirect to next uncompleted chapter
                        $start_chapter_url = $next_uncompleted_chapter['url'];
                    }
                    ?>
                    <a href="<?php echo esc_url( $start_chapter_url ); ?>" class="module-start-button">
                        <?php echo $next_uncompleted_chapter ? 'Continue Learning →' : 'Start learning for free →'; ?>
                    </a>
                </div>
                
                <div class="module-header-right">
                    <?php if ( $module_image ) : ?>
                        <div class="module-header-image">
                            <img src="<?php echo esc_url( $module_image ); ?>" alt="<?php echo esc_attr( $module_name ); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="module-main-layout">
        <div class="container">
            <div class="module-content-wrapper">
                <!-- Left Column: Main Content -->
                <div class="module-main-content">
                    <!-- About This Module -->
                    <section class="module-about-section">
                        <h2 class="section-title">About this Module</h2>
                        <div class="module-about-content">
                            <?php echo wp_kses_post( wpautop( $module_description ) ); ?>
                        </div>
                    </section>

                    <!-- Course Structure -->
                    <section class="module-course-structure">
                        <h2 class="section-title">Course structure</h2>
                        <div class="course-structure-list">
                            <?php
                            $chapter_index = 1;
                            if ( $chapters_query->have_posts() ) :
                                while ( $chapters_query->have_posts() ) :
                                    $chapters_query->the_post();
                                    $chapter_id = get_the_ID();
                                    
                                    // Calculate chapter total time: chapter + topics + quiz
                                    $chapter_content = get_post_field( 'post_content', $chapter_id );
                                    $chapter_total_minutes = calculate_reading_time( $chapter_content );
                                    
                                    // Add topics duration for this chapter
                                    $chapter_topics = array();
                                    if ( function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
                                        $chapter_topics = vested_academy_get_topics_for_chapter( $chapter_id );
                                    }
                                    if ( empty( $chapter_topics ) ) {
                                        $chapter_topics = get_field( 'chapter_topics', $chapter_id );
                                        if ( ! $chapter_topics || ! is_array( $chapter_topics ) ) {
                                            $chapter_topics = array();
                                        }
                                    }
                                    
                                    foreach ( $chapter_topics as $topic ) {
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
                                        $chapter_total_minutes += $topic_duration;
                                    }
                                    
                                    // Add quiz time for this chapter
                                    $chapter_quizzes = array();
                                    if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                        $chapter_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
                                    }
                                    if ( ! empty( $chapter_quizzes ) ) {
                                        foreach ( $chapter_quizzes as $quiz ) {
                                            $quiz_time = isset( $quiz['time_limit'] ) ? intval( $quiz['time_limit'] ) : 0;
                                            $chapter_total_minutes += $quiz_time;
                                        }
                                    }
                                    
                                    // Format chapter duration display
                                    if ( $chapter_total_minutes < 60 ) {
                                        $chapter_duration_display = $chapter_total_minutes . ' mins';
                                    } else {
                                        $chapter_hours = round( $chapter_total_minutes / 60, 1 );
                                        $chapter_duration_display = $chapter_hours . ' hrs';
                                    }
                                    
                                    // Check if chapter is completed
                                    $user_id = get_current_user_id();
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
                                    }
                                    ?>
                                    <?php
                                    // Check if chapter has quiz
                                    $chapter_quiz_questions = get_field( 'quiz_questions', $chapter_id );
                                    $has_quiz = ! empty( $chapter_quiz_questions );
                                    $chapter_url = get_permalink( $chapter_id );
                                    $quiz_url = $has_quiz ? add_query_arg( 'quiz', '1', $chapter_url ) . '#quiz-content' : '';
                                    ?>
                                    <div class="course-structure-item <?php echo $chapter_index === 1 ? 'active expanded' : ''; ?>" data-chapter-id="<?php echo esc_attr( $chapter_id ); ?>">
                                        <div class="structure-item-header">
                                            <a href="<?php echo esc_url( $chapter_url ); ?>" class="structure-item-title-link">
                                            <span class="structure-item-number"><?php echo esc_html( $chapter_index ); ?>.</span>
                                            <h3 class="structure-item-title"><?php the_title(); ?></h3>
                                            </a>
                                            <span class="structure-item-duration"><?php echo esc_html( $chapter_duration_display ); ?></span>
                                            <button class="structure-item-toggle" aria-label="Toggle chapter" type="button">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="toggle-icon">
                                                    <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="structure-item-content" style="display: <?php echo $chapter_index === 1 ? 'block' : 'none'; ?>;">
                                            <a href="<?php echo esc_url( $chapter_url ); ?>" class="structure-sub-item">
                                                    <span class="sub-item-icon">📄</span>
                                                <span class="sub-item-title"><?php the_title(); ?></span>
                                                    <span class="sub-item-status <?php echo $chapter_completed ? 'completed' : ''; ?>">
                                                        <?php echo $chapter_completed ? '✓' : ''; ?>
                                                    </span>
                                            </a>
                                            <!-- <?php if ( $has_quiz ) : ?>
                                                <a href="<?php echo esc_url( $quiz_url ); ?>" class="structure-sub-item quiz-item <?php echo ! is_user_logged_in() ? 'locked' : ''; ?>">
                                                    <span class="sub-item-icon">❓</span>
                                                    <span class="sub-item-title">Quiz</span>
                                                    <?php if ( ! is_user_logged_in() ) : ?>
                                                        <span class="sub-item-lock">🔒</span>
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?> -->
                                            </div>
                                    </div>
                                    <?php
                                    $chapter_index++;
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </section>

                    <!-- Similar Modules -->
                    <?php if ( ! empty( $similar_modules ) ) : ?>
                        <section class="module-similar-section">
                            <h2 class="section-title">Similar Modules</h2>
                            <p class="section-description">A complete repository of educational content that helps Indian investors understand the nuances of global markets.</p>
                            
                            <div class="similar-modules-grid">
                                <?php foreach ( $similar_modules as $similar_module ) :
                                    // Support both post type and taxonomy
                                    $similar_image = '';
                                    $similar_desc = '';
                                    $similar_id = 0;
                                    $similar_slug = '';
                                    $similar_name = '';
                                    $similar_url = '';
                                    
                                    if ( isset( $similar_module->is_post ) && $similar_module->is_post ) {
                                        // New structure: Post type
                                        $similar_id = $similar_module->ID;
                                        $similar_name = $similar_module->name;
                                        $similar_desc = $similar_module->description;
                                        $similar_slug = $similar_module->slug;
                                        $similar_image = get_the_post_thumbnail_url( $similar_id, 'full' );
                                        if ( ! $similar_image ) {
                                            $similar_image = get_field( 'module_image', $similar_id );
                                        }
                                        $similar_url = get_permalink( $similar_id );
                                        
                                        // Count chapters and calculate total time
                                        $similar_chapters = new WP_Query( array(
                                            'post_type' => 'module',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'academy_module',
                                                    'value' => $similar_id,
                                                    'compare' => 'LIKE',
                                                ),
                                            ),
                                            'posts_per_page' => -1,
                                            'orderby' => 'menu_order',
                                            'order' => 'ASC',
                                        ) );
                                        
                                        // Calculate total time: chapters + topics + quizzes
                                        $similar_total_minutes = 0;
                                        if ( $similar_chapters->have_posts() ) {
                                            while ( $similar_chapters->have_posts() ) {
                                                $similar_chapters->the_post();
                                                $similar_chapter_id = get_the_ID();
                                                
                                                // Add chapter reading time
                                                $similar_chapter_content = get_post_field( 'post_content', $similar_chapter_id );
                                                $similar_total_minutes += calculate_reading_time( $similar_chapter_content );
                                                
                                                // Add topics duration for this chapter
                                                $similar_chapter_topics = array();
                                                if ( function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
                                                    $similar_chapter_topics = vested_academy_get_topics_for_chapter( $similar_chapter_id );
                                                }
                                                if ( empty( $similar_chapter_topics ) ) {
                                                    $similar_chapter_topics = get_field( 'chapter_topics', $similar_chapter_id );
                                                    if ( ! $similar_chapter_topics || ! is_array( $similar_chapter_topics ) ) {
                                                        $similar_chapter_topics = array();
                                                    }
                                                }
                                                
                                                foreach ( $similar_chapter_topics as $similar_topic ) {
                                                    $similar_topic_duration = isset( $similar_topic['topic_duration'] ) ? intval( $similar_topic['topic_duration'] ) : 0;
                                                    if ( $similar_topic_duration <= 0 && isset( $similar_topic['topic_content'] ) ) {
                                                        $similar_topic_duration = calculate_reading_time( $similar_topic['topic_content'] );
                                                    }
                                                    if ( $similar_topic_duration <= 0 && isset( $similar_topic['topic_id'] ) ) {
                                                        $similar_topic_post = get_post( $similar_topic['topic_id'] );
                                                        if ( $similar_topic_post ) {
                                                            $similar_topic_duration = calculate_reading_time( $similar_topic_post->post_content );
                                                        }
                                                    }
                                                    $similar_total_minutes += $similar_topic_duration;
                                                }
                                                
                                                // Add quiz time for this chapter
                                                $similar_chapter_quizzes = array();
                                                if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                                    $similar_chapter_quizzes = vested_academy_get_quizzes_for_module( $similar_chapter_id );
                                                }
                                                if ( ! empty( $similar_chapter_quizzes ) ) {
                                                    foreach ( $similar_chapter_quizzes as $similar_quiz ) {
                                                        $similar_quiz_time = isset( $similar_quiz['time_limit'] ) ? intval( $similar_quiz['time_limit'] ) : 0;
                                                        $similar_total_minutes += $similar_quiz_time;
                                                    }
                                                }
                                            }
                                            wp_reset_postdata();
                                        }
                                        
                                        // Format display
                                        if ( $similar_total_minutes < 60 ) {
                                            $similar_time_display = $similar_total_minutes . ' Minutes';
                                            $similar_hours = round( $similar_total_minutes / 60, 1 );
                                        } else {
                                            $similar_hours = round( $similar_total_minutes / 60, 1 );
                                            $similar_time_display = $similar_hours . ' Hours';
                                        }
                                    } else {
                                        // Old structure: Taxonomy
                                        $similar_id = $similar_module->term_id;
                                        $similar_name = $similar_module->name;
                                        $similar_desc = $similar_module->description;
                                        $similar_slug = $similar_module->slug;
                                        $similar_image = get_field( 'module_image', $similar_module );
                                        $similar_url = get_term_link( $similar_module );
                                        
                                        // Count chapters and calculate total time
                                        $similar_chapters = new WP_Query( array(
                                            'post_type' => 'module',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'modules',
                                                    'field' => 'term_id',
                                                    'terms' => $similar_id,
                                                ),
                                            ),
                                            'posts_per_page' => -1,
                                            'orderby' => 'menu_order',
                                            'order' => 'ASC',
                                        ) );
                                        
                                        // Calculate total time: chapters + topics + quizzes
                                        $similar_total_minutes = 0;
                                        if ( $similar_chapters->have_posts() ) {
                                            while ( $similar_chapters->have_posts() ) {
                                                $similar_chapters->the_post();
                                                $similar_chapter_id = get_the_ID();
                                                
                                                // Add chapter reading time
                                                $similar_chapter_content = get_post_field( 'post_content', $similar_chapter_id );
                                                $similar_total_minutes += calculate_reading_time( $similar_chapter_content );
                                                
                                                // Add topics duration for this chapter
                                                $similar_chapter_topics = array();
                                                if ( function_exists( 'vested_academy_get_topics_for_chapter' ) ) {
                                                    $similar_chapter_topics = vested_academy_get_topics_for_chapter( $similar_chapter_id );
                                                }
                                                if ( empty( $similar_chapter_topics ) ) {
                                                    $similar_chapter_topics = get_field( 'chapter_topics', $similar_chapter_id );
                                                    if ( ! $similar_chapter_topics || ! is_array( $similar_chapter_topics ) ) {
                                                        $similar_chapter_topics = array();
                                                    }
                                                }
                                                
                                                foreach ( $similar_chapter_topics as $similar_topic ) {
                                                    $similar_topic_duration = isset( $similar_topic['topic_duration'] ) ? intval( $similar_topic['topic_duration'] ) : 0;
                                                    if ( $similar_topic_duration <= 0 && isset( $similar_topic['topic_content'] ) ) {
                                                        $similar_topic_duration = calculate_reading_time( $similar_topic['topic_content'] );
                                                    }
                                                    if ( $similar_topic_duration <= 0 && isset( $similar_topic['topic_id'] ) ) {
                                                        $similar_topic_post = get_post( $similar_topic['topic_id'] );
                                                        if ( $similar_topic_post ) {
                                                            $similar_topic_duration = calculate_reading_time( $similar_topic_post->post_content );
                                                        }
                                                    }
                                                    $similar_total_minutes += $similar_topic_duration;
                                                }
                                                
                                                // Add quiz time for this chapter
                                                $similar_chapter_quizzes = array();
                                                if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                                    $similar_chapter_quizzes = vested_academy_get_quizzes_for_module( $similar_chapter_id );
                                                }
                                                if ( ! empty( $similar_chapter_quizzes ) ) {
                                                    foreach ( $similar_chapter_quizzes as $similar_quiz ) {
                                                        $similar_quiz_time = isset( $similar_quiz['time_limit'] ) ? intval( $similar_quiz['time_limit'] ) : 0;
                                                        $similar_total_minutes += $similar_quiz_time;
                                                    }
                                                }
                                            }
                                            wp_reset_postdata();
                                        }
                                        
                                        // Format display
                                        if ( $similar_total_minutes < 60 ) {
                                            $similar_time_display = $similar_total_minutes . ' Minutes';
                                            $similar_hours = round( $similar_total_minutes / 60, 1 );
                                        } else {
                                            $similar_hours = round( $similar_total_minutes / 60, 1 );
                                            $similar_time_display = $similar_hours . ' Hours';
                                        }
                                    }
                                    
                                    if ( strlen( $similar_desc ) > 150 ) {
                                        $similar_desc = substr( $similar_desc, 0, 150 ) . '...';
                                    }
                                    ?>
                                    <div class="similar-module-card">
                                        <?php if ( $similar_image ) : ?>
                                            <div class="similar-module-image">
                                                <img src="<?php echo esc_url( $similar_image ); ?>" alt="<?php echo esc_attr( $similar_name ); ?>">
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="similar-module-content">
                                            <h3 class="similar-module-title"><?php echo esc_html( $similar_name ); ?></h3>
                                            <p class="similar-module-description"><?php echo esc_html( $similar_desc ); ?></p>
                                            
                                            <!-- <div class="similar-module-meta">
                                                <span class="meta-item"><?php echo esc_html( $module_difficulty ); ?></span>
                                                <span class="meta-item"><?php echo esc_html( $similar_chapters->post_count ); ?> Chapters</span>
                                                <span class="meta-item"><?php echo esc_html( $similar_time_display ); ?></span>
                                            </div> -->
                                            
                                            <a href="<?php echo esc_url( $similar_url ); ?>" class="similar-module-button">
                                                View course detail
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>

                <!-- Right Sidebar: Course Information -->
                <div class="module-sidebar">
                    <!-- Course Information Card -->
                    <div class="sidebar-card course-info-card">
                        <div class="card-header">
                            <div class="card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#00A651"/>
                                    <path d="M2 17L12 22L22 17" stroke="#00A651" stroke-width="2"/>
                                    <path d="M2 12L12 17L22 12" stroke="#00A651" stroke-width="2"/>
                                </svg>
                            </div>
                            <h3 class="card-title">Course information</h3>
                        </div>
                        <div class="card-content">
                            <div class="info-item">
                                <span class="info-icon">👤</span>
                                <span class="info-text"><?php echo esc_html( $module_difficulty ); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-icon">📚</span>
                                <span class="info-text"><?php echo esc_html( $total_chapters ); ?> Chapters</span>
                            </div>
                            <div class="info-item">
                                <span class="info-icon">⏱️</span>
                                <span class="info-text"><?php echo esc_html( $total_time_display ); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Course structure accordion
document.addEventListener('DOMContentLoaded', function() {
    const structureItems = document.querySelectorAll('.course-structure-item');
    
    structureItems.forEach(function(item) {
        const toggle = item.querySelector('.structure-item-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isExpanded = item.classList.contains('expanded');
                const content = item.querySelector('.structure-item-content');
                const toggleIcon = toggle.querySelector('.toggle-icon');
                
                if (isExpanded) {
                    // Collapse
                    item.classList.remove('expanded', 'active');
                    if (content) {
                        content.style.display = 'none';
                    }
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                } else {
                    // Expand
                    item.classList.add('expanded', 'active');
                    if (content) {
                        content.style.display = 'block';
                    }
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(180deg)';
                    }
                }
            });
        }
    });
    
    // Prevent navigation when clicking toggle
    const structureHeaders = document.querySelectorAll('.structure-item-header');
    structureHeaders.forEach(function(header) {
        header.addEventListener('click', function(e) {
            if (e.target.closest('.structure-item-toggle')) {
                e.preventDefault();
            }
        });
    });
});
</script>

<?php
get_footer();


