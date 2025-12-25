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
				// Skip restricted topics
				if ( function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $tp->ID ) ) {
					continue;
				}
				
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
    // Fallback to default if no image
    if ( ! $module_image ) {
        $module_image = get_stylesheet_directory_uri() . '/assets/images/app-download-mockup.png';
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
    // Fallback to default if no image
    if ( ! $module_image ) {
        $module_image = get_stylesheet_directory_uri() . '/assets/images/app-download-mockup.png';
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
            // Skip restricted topics
            $topic_id = isset( $topic['topic_id'] ) ? $topic['topic_id'] : null;
            if ( $topic_id && function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $topic_id ) ) {
                continue;
            }
            
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
            $similar_id = get_the_ID();
            
            // Skip restricted modules
            if ( function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $similar_id ) ) {
                continue;
            }
            
            $similar_modules[] = (object) array(
                'ID' => $similar_id,
                'name' => get_the_title(),
                'description' => get_the_excerpt(),
                'term_id' => $similar_id,
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

<div id="academy-module-page" class="academy-module-page">
    <div class="academy-home-bg" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/academy-home-bg.svg');"></div>
    <section class="module-header-section">
        <div class="container">
            <div class="module-header-content">
                <div class="module-header-left">
                    <h1 class="module-title"><?php echo esc_html( $module_name ); ?></h1>
                    <p class="module-description"><?php echo esc_html( $module_description ); ?></p>
                    
                    <div class="module-rating">
                        <div class="rating-avatars">
                            <?php
                            $rating_avatars = get_field( 'rating_avatars', $module_id );
                            if ( $rating_avatars && is_array( $rating_avatars ) ) {
                                foreach ( $rating_avatars as $avatar ) :
                                    $avatar_image = isset( $avatar['avatar_image'] ) ? $avatar['avatar_image'] : '';
                                    ?>
                                    <div class="avatar-circle">
                                        <img src="<?php echo esc_url( $avatar_image ); ?>" alt="Student">
                                    </div>
                                    <?php
                                endforeach;
                            }
                            ?>
                        </div>
                        <div class="rating-wrapper">
                            <div class="rating-info">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/star-icons.svg" alt="Rating">
                                <span class="rating-value"><?php echo esc_html( get_field( 'rating_value', $module_id ) ); ?></span>
                            </div>
                            <span class="rating-text"><?php echo esc_html( get_field( 'rating_text', $module_id ) ); ?></span>
                        </div>
                    </div>
                </div>
                <div class="module-header-right">
                    <div class="module-mobile-mockup">
                        <img src="<?php echo esc_url( $module_image ); ?>" alt="<?php echo esc_attr( $module_name ); ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="module-main-layout">
        <div class="container">
            <div class="module-about-section">
                <div class="module-about-wrapper">
                    <div class="module-about-content">
                        <h2 class="about-title"><?php echo esc_html( get_field( 'about_title', $module_id ) ); ?></h2>
                        <div class="module-about-text">
                            <p>Think about your day. You probably scrolled through Instagram, searched on Google, and maybe even watched something on Netflix. You're one of the best customers for these American companies. <br>But here’s a question—are you one of their owners?</p>

                            <p>For most of us, the answer is no. Our investment world is often limited to India. But what if we told you that by doing this, you're ignoring 60% of the entire world's stock market? <br>That's right. The US market isn't just another country's stock exchange; it's the financial superpower where global growth stories are written. Meanwhile, back home, your hard-earned money is fighting a quiet battle against Rupee depreciation—a silent wealth killer.</p>

                            <p>So, how do you go from being just a consumer to an owner? How do you tap into that massive 60% of the market and potentially turn a weakening Rupee into an advantage?</p>

                            <p>This module is your playbook. We break down the fundamentals of the US market in simple, jargon-free language, specifically for you, the Indian investor. It’s about giving you the knowledge and confidence to navigate the world's largest capital market and finally claim your stake.</p>
                        </div>
                    </div>
                    <div class="module-course-structure">
                        <h2 class="about-title"><?php echo esc_html( get_field( 'course_structure_title', $module_id ) ); ?></h2>
                        <div class="course-structure-list">
                            <?php
                            $chapter_index = 1;
                            if ( $chapters_query->have_posts() ) :
                                while ( $chapters_query->have_posts() ) :
                                    $chapters_query->the_post();
                                    $chapter_id = get_the_ID();
                                    
                                    // Skip restricted chapters
                                    if ( function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $chapter_id ) ) {
                                        continue;
                                    }
                                    
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
                                        // Skip restricted topics
                                        $topic_id = isset( $topic['topic_id'] ) ? $topic['topic_id'] : null;
                                        if ( $topic_id && function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $topic_id ) ) {
                                            continue;
                                        }
                                        
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
                                    // Check if chapter has quiz - use helper function to get quizzes from quiz_links field
                                    $chapter_quizzes = array();
                                    if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                        $chapter_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
                                    }
                                    $has_quiz = ! empty( $chapter_quizzes );
                                    $chapter_url = get_permalink( $chapter_id );
                                    $quiz_url = $has_quiz ? add_query_arg( 'quiz', '1', $chapter_url ) . '#quiz-content' : '';
                                    ?>
                                    <div class="course-structure-item <?php echo $chapter_index === 1 ? 'active expanded' : ''; ?>" data-chapter-id="<?php echo esc_attr( $chapter_id ); ?>">
                                        <div class="structure-item-header">
                                            <div class="structure-item-title-link">
                                                <span class="structure-item-number"><?php echo esc_html( $chapter_index ); ?>.</span>
                                                <h3 class="structure-item-title"><?php the_title(); ?></h3>
                                            </div>
                                            <span class="structure-item-duration"><?php echo esc_html( $chapter_duration_display ); ?></span>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/close-avatar-icon.svg" alt="Arrow down" class="structure-item-arrow">
                                        </div>
                                        
                                        <div class="structure-item-content" style="display: <?php echo $chapter_index === 1 ? 'block' : 'none'; ?>;">
                                            
                                            <div class="structure-sub-items">
                                            <?php
                                            // Display topics for this chapter
                                            if ( ! empty( $chapter_topics ) ) {
                                                foreach ( $chapter_topics as $topic_idx => $topic ) :
                                                    // Skip restricted topics
                                                    $topic_id = isset( $topic['topic_id'] ) ? $topic['topic_id'] : null;
                                                    if ( $topic_id && function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $topic_id ) ) {
                                                        continue;
                                                    }
                                                    
                                                    $topic_title = isset( $topic['topic_title'] ) ? $topic['topic_title'] : ( isset( $topic['title'] ) ? $topic['title'] : 'Topic ' . ( $topic_idx + 1 ) );
                                                    
                                                    if ( isset( $topic['topic_slug'] ) && function_exists( 'vested_academy_get_topic_url' ) ) {
                                                        $topic_url = vested_academy_get_topic_url( $chapter_id, $topic['topic_slug'] );
                                                    } else {
                                                        $topic_url = add_query_arg( 'topic', $topic_idx, $chapter_url );
                                                    }
                                                    
                                                    $topic_completed = false;
                                                    if ( $user_id ) {
                                                        $topic_completed = vested_academy_is_topic_completed( $user_id, $chapter_id, $topic_idx );
                                                    }
                                                    ?>
                                                    <a href="<?php echo esc_url( $topic_url ); ?>" class="structure-sub-item">
                                                        <span class="sub-item-icon">
                                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/play-icon.svg" alt="Book" class="info-icon">
                                                        </span>
                                                        <span class="sub-item-title"><?php echo esc_html( $topic_title ); ?></span>
                                                        <?php if ( $topic_completed ) : ?>
                                                        <span class="sub-item-status completed"></span>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endforeach;
                                            }
                                            
                                            // Display quiz if available
                                            if ( $has_quiz && $quiz_url ) :
                                                $quiz_completed = false;
                                                if ( $user_id && ! empty( $chapter_quizzes ) ) {
                                                    // Get the first quiz ID from the quiz_links relationship
                                                    $quiz_post = $chapter_quizzes[0];
                                                    $quiz_id = isset( $quiz_post['id'] ) ? $quiz_post['id'] : 0;
                                                    
                                                    if ( $quiz_id ) {
                                                        global $wpdb;
                                                        $table_name = $wpdb->prefix . 'academy_progress';
                                                        $quiz_progress = $wpdb->get_row( $wpdb->prepare(
                                                            "SELECT * FROM $table_name WHERE user_id = %d AND quiz_id = %d AND progress_type = 'quiz' AND status = 'completed' ORDER BY id DESC LIMIT 1",
                                                            $user_id,
                                                            $quiz_id
                                                        ) );
                                                        $quiz_completed = ! empty( $quiz_progress );
                                                    }
                                                }
                                                ?>
                                                <a href="<?php echo esc_url( $quiz_url ); ?>" class="structure-sub-item structure-quiz-item">
                                                    <span class="sub-item-icon">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/play-icon.svg" alt="Test" class="info-icon">
                                                    </span>
                                                    <span class="sub-item-title">Quiz</span>
                                                    <?php if ( $quiz_completed ) : ?>
                                                    <span class="sub-item-status completed"></span>
                                                    <?php endif; ?>
                                                </a>
                                            <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $chapter_index++;
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="module-about-sidebar">
                    <div class="sidebar-card">
                        <div class="academy-logo">
                            <img src="<?php echo esc_url( get_field( 'academy_logo', $module_id ) ); ?>" alt="Course information">
                        </div>
                        <div class="course-info-card">
                            <h3 class="course-info-title">Course information</h3>
                            <div class="module-card-attributes">
                                <div class="module-attribute">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chart-icon.svg" alt="Difficulty" class="info-icon">
                                    <span class="attribute-text"><?php echo esc_html( $module_difficulty ); ?></span>
                                </div>
                                <div class="module-attribute">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/book-icon.svg" alt="Chapters" class="info-icon">
                                    <span class="attribute-text"><?php echo esc_html( $total_chapters ); ?> Chapters</span>
                                </div>
                                <div class="module-attribute">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clock-icon2.svg" alt="Duration" class="info-icon">
                                    <span class="attribute-text"><?php echo esc_html( $total_time_display ); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-info">
                            <h3 class="skills-title">Skills you will gain</h3>
                            <ul class="skills-list">
                                <?php
                                $module_skills = get_field( 'module_skills', $module_id );
                                if ( $module_skills && is_array( $module_skills ) ) {
                                    foreach ( $module_skills as $skill ) :
                                        $skill_text = isset( $skill['skill_text'] ) ? $skill['skill_text'] : '';
                                        ?>
                                        <li class="skill-item">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/check-icon.svg" alt="Skill">
                                            <span><?php echo esc_html( $skill_text ); ?></span>
                                        </li>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </ul>
                        </div>
                        <a href="<?php echo esc_url( $start_chapter_url ); ?>" class="course-info-button">
                            Start learning for free →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Similar Modules Section -->
    <?php if ( ! empty( $similar_modules ) ) : ?>
        <?php
        $similar_count = count( $similar_modules );
        $is_similar_slider = $similar_count > 3;
        $similar_slider_class = $is_similar_slider ? 'similar-modules-slider' : 'similar-modules-grid';
        ?>
        <section class="module-similar-section">
            <div class="container">
                <div class="similar-modules-header">
                    <h2 class="section-title">Similar Modules</h2>
                    <p class="section-description">A complete repository of educational content that helps Indian investors understand the nuances of global markets.</p>
                </div>
                
                <div class="<?php echo esc_attr( $similar_slider_class ); ?>" <?php echo $is_similar_slider ? 'data-slider="true"' : ''; ?>>
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
                                                    // Skip restricted topics
                                                    $similar_topic_id = isset( $similar_topic['topic_id'] ) ? $similar_topic['topic_id'] : null;
                                                    if ( $similar_topic_id && function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $similar_topic_id ) ) {
                                                        continue;
                                                    }
                                                    
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
                                                    // Skip restricted topics
                                                    $similar_topic_id = isset( $similar_topic['topic_id'] ) ? $similar_topic['topic_id'] : null;
                                                    if ( $similar_topic_id && function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $similar_topic_id ) ) {
                                                        continue;
                                                    }
                                                    
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
                                    
                                    // Get module tag/category for overlay
                                    $similar_tag = explode( ' ', $similar_name )[0];
                                    if ( strlen( $similar_tag ) > 15 ) {
                                        $similar_tag = substr( $similar_tag, 0, 15 );
                                    }
                                    
                                    // Get difficulty for similar module
                                    $similar_difficulty = 'Beginner';
                                    if ( isset( $similar_module->is_post ) && $similar_module->is_post ) {
                                        $similar_difficulty = get_field( 'difficulty_level', $similar_id ) ?: 'Beginner';
                                    } else {
                                        $similar_difficulty = get_field( 'difficulty_level', $similar_module ) ?: 'Beginner';
                                    }
                                    
                                    // Count chapters
                                    $similar_chapters_count = isset( $similar_chapters ) ? $similar_chapters->post_count : 0;
                                    
                                    // Get continue URL (last visited or next uncompleted item)
                                    $continue_url = $similar_url; // Default to module page
                                    if ( function_exists( 'vested_academy_get_continue_url' ) ) {
                                        $continue_url = vested_academy_get_continue_url( $similar_id );
                                        if ( ! $continue_url ) {
                                            $continue_url = $similar_url; // Fallback to module page
                                        }
                                    }
                                    ?>
                                    <div class="similar-module-item">
                                        <div class="roadmap-module-card">
                                            <?php if ( $similar_image ) : ?>
                                            <div class="module-card-image-wrapper">
                                                <img src="<?php echo esc_url( $similar_image ); ?>" alt="<?php echo esc_attr( $similar_name ); ?>" class="module-card-image">
                                                <div class="module-image-tag"><?php echo esc_html( $similar_tag ); ?></div>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <div class="module-card-content">
                                                <h3 class="module-card-title"><?php echo esc_html( $similar_name ); ?></h3>
                                                
                                                <?php if ( $similar_desc ) : ?>
                                                <p class="module-card-description"><?php echo esc_html( $similar_desc ); ?></p>
                                                <?php endif; ?>
                                                
                                                <div class="module-card-attributes">
                                                    <div class="module-attribute">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chart-icon.svg" alt="Difficulty" class="attribute-icon">
                                                        <span class="attribute-text"><?php echo esc_html( $similar_difficulty ); ?></span>
                                                    </div>
                                                    <div class="module-attribute">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/book-icon.svg" alt="Chapters" class="attribute-icon">
                                                        <span class="attribute-text"><?php echo esc_html( $similar_chapters_count ); ?> Chapter<?php echo $similar_chapters_count > 1 ? 's' : ''; ?></span>
                                                    </div>
                                                    <div class="module-attribute">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clock-icon2.svg" alt="Duration" class="attribute-icon">
                                                        <span class="attribute-text"><?php echo esc_html( $similar_time_display ); ?></span>
                                                    </div>
                                                </div>

                                                <a href="<?php echo esc_url( $continue_url ); ?>" class="module-card-button">
                                                    View course detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                endforeach; ?>
                </div>
                
                <?php if ( $is_similar_slider ) : ?>
                <div class="similar-slider-pagination"></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Download App Section -->
    <section class="academy-download-section">
        <div class="container">
            <div class="download-content-wrapper">
                <div class="download-visual-column">
                    <div class="download-mobile-mockup">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/app-download-mockup.png" alt="Vested App">
                    </div>
                </div>
                
                <div class="download-text-column">
                    <h2 class="download-title"><?php echo esc_html( get_field( 'download_title', $module_id ) ); ?></h2>
                    <p class="download-description">
                        <?php echo esc_html( get_field( 'download_description', $module_id ) ); ?>
                    </p>
                    
                    <div class="download-buttons">
                        <?php
                        $download_buttons = get_field( 'download_buttons', $module_id );
                        if ( $download_buttons && is_array( $download_buttons ) ) {
                            foreach ( $download_buttons as $button ) :
                                $button_icon = isset( $button['button_icon'] ) ? $button['button_icon'] : '';
                                $button_text = isset( $button['button_text'] ) ? $button['button_text'] : '';
                                $button_url = isset( $button['button_url'] ) ? $button['button_url'] : '#';
                                $button_class = strpos( strtolower( $button_text ), 'playstore' ) !== false ? 'download-playstore' : 'download-appstore';
                                ?>
                                <a href="<?php echo esc_url( $button_url ); ?>" class="download-button <?php echo esc_attr( $button_class ); ?>">
                                    <img src="<?php echo esc_url( $button_icon ); ?>" alt="<?php echo esc_attr( $button_text ); ?>">
                                    <?php echo esc_html( $button_text ); ?>
                                </a>
                                <?php
                            endforeach;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Course structure accordion
document.addEventListener('DOMContentLoaded', function() {
    const structureItems = document.querySelectorAll('.course-structure-item');
    
    function toggleChapter(item, expand) {
        const content = item.querySelector('.structure-item-content');
        const toggleIcon = item.querySelector('.toggle-icon');
        const isExpanded = item.classList.contains('expanded');
        
        if (expand === undefined) {
            expand = !isExpanded;
        }
        
        if (expand) {
            // Expand
            item.classList.add('expanded', 'active');
            if (content) {
                content.style.display = 'block';
            }
            if (toggleIcon) {
                toggleIcon.style.transform = 'rotate(180deg)';
            }
        } else {
            // Collapse
            item.classList.remove('expanded', 'active');
            if (content) {
                content.style.display = 'none';
            }
            if (toggleIcon) {
                toggleIcon.style.transform = 'rotate(0deg)';
            }
        }
    }
    
    structureItems.forEach(function(item) {
        const toggle = item.querySelector('.structure-item-toggle');
        const close = item.querySelector('.structure-item-close');
        const header = item.querySelector('.structure-item-header');
        const titleLink = item.querySelector('.structure-item-title-link');
        
        // Toggle button
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleChapter(item);
            });
        }
        
        // Close button
        if (close) {
            close.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleChapter(item, false);
            });
        }
        
        // Title link click to toggle
        if (titleLink) {
            titleLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleChapter(item);
                return false;
            });
        }
        
        // Header click to toggle (but not if clicking on buttons)
        if (header) {
            header.addEventListener('click', function(e) {
                // Don't toggle if clicking on toggle or close buttons
                if (e.target.closest('.structure-item-toggle') || e.target.closest('.structure-item-close')) {
                    return;
                }
                // Don't toggle if clicking on title link (it has its own handler)
                if (e.target.closest('.structure-item-title-link')) {
                    return;
                }
                // Don't toggle if clicking on sub-item links
                if (e.target.closest('.structure-sub-item')) {
                    return;
                }
                e.preventDefault();
                toggleChapter(item);
            });
        }
    });
    
    // Similar Modules Slider
    function initSimilarSlider() {
        const similarSlider = document.querySelector('.similar-modules-slider[data-slider="true"]');
        if (similarSlider && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
            jQuery(similarSlider).slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: true,
                appendDots: jQuery('.similar-slider-pagination'),
                arrows: false,
                infinite: false,
                speed: 300,
                autoplay: false,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        } else if (similarSlider && typeof jQuery === 'undefined') {
            setTimeout(initSimilarSlider, 100);
        }
    }
    
    // Initialize slider
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSimilarSlider);
    } else {
        if (typeof jQuery !== 'undefined') {
            jQuery(document).ready(initSimilarSlider);
        } else {
            window.addEventListener('load', function() {
                setTimeout(initSimilarSlider, 500);
            });
        }
    }
});
</script>

<?php
get_footer();


