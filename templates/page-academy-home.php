<?php
/**
 * Template Name: Academy Home
 * 
 * Landing page for Academy with hero section, stats, and feature cards
 * 
 * @package Vested Finance WP
 */

get_header();

// Ensure we're in the loop for page content
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
	}
	rewind_posts();
}

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
?>

<div id="academy-home-page" class="academy-home-page">
    <!-- Trust Indicator Bar -->
    <div class="academy-trust-bar">
        <div class="container">
            <p class="trust-text">
                <span class="trust-icon">❤️</span>
                Trusted by <strong>196,045</strong> traders & investors
                <span class="dropdown-arrow">▼</span>
            </p>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="academy-hero-section">
        <div class="container">
            <div class="academy-hero-content">
                <div class="hero-text-content">
                    <h1 class="hero-title">
                        US Investing, <span class="highlight-green">Demystified</span>
                        <span class="hero-tooltip" data-tooltip="let's learn">💬</span>
                    </h1>
                    <p class="hero-subtitle">
                        Your step-by-step blueprint to confidently navigate the US market, specifically designed for Indian investors.
                    </p>
                    
                    <div class="hero-interactive-badge">
                        <div class="badge-icon">👥</div>
                        <span class="badge-text">Hands on Stock analysis</span>
                    </div>
                    
                    <a href="<?php echo esc_url( home_url( '/academy' ) ); ?>" class="hero-cta-button">
                        Start learning for free →
                    </a>
                    
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">40+</div>
                            <div class="stat-label">Chapters</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number">25+</div>
                            <div class="stat-label">Hours of Content</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number">4.8/5</div>
                            <div class="stat-label">Average Rating</div>
                            <span class="stat-star">⭐</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Step-by-Step Roadmap Section -->
    <section class="academy-roadmap-section">
        <div class="container">
            <div class="roadmap-header">
                <h2 class="roadmap-title">Your Step-by-Step Roadmap</h2>
                <p class="roadmap-subtitle">Four modules designed to make you a skilled global investor.</p>
        </div>

            <?php
            // Get modules - prefer new post type, fallback to taxonomy
            $all_modules = array();
            
            // First, try to get from new post type
            $module_posts = new WP_Query( array(
                'post_type' => 'academy_module',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ) );
            
            if ( $module_posts->have_posts() ) {
                while ( $module_posts->have_posts() ) {
                    $module_posts->the_post();
                    $all_modules[] = (object) array(
                        'ID' => get_the_ID(),
                        'name' => get_the_title(),
                        'description' => get_the_excerpt(),
                        'term_id' => get_the_ID(),
                        'slug' => get_post_field( 'post_name' ),
                        'is_post' => true,
                        'link' => get_permalink(),
                    );
                }
                wp_reset_postdata();
            }
            
            // Fallback to taxonomy if no posts found
            if ( empty( $all_modules ) ) {
                $taxonomy = 'modules';
                $exclude_term_slug = 'glossary';
                $modules = get_terms( array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                ) );
                
                if ( ! empty( $modules ) && ! is_wp_error( $modules ) ) {
                    // Filter out glossary
                    $modules = array_filter( $modules, function( $term ) use ( $exclude_term_slug ) {
                        return $term->slug !== $exclude_term_slug;
                    } );
                    
                    foreach ( $modules as $module_term ) {
                        $all_modules[] = (object) array(
                            'ID' => $module_term->term_id,
                            'name' => $module_term->name,
                            'description' => $module_term->description,
                            'term_id' => $module_term->term_id,
                            'slug' => $module_term->slug,
                            'is_post' => false,
                            'link' => get_term_link( $module_term ),
                        );
                    }
                }
            }

            if ( ! empty( $all_modules ) ) :
                ?>
                <div class="roadmap-modules-grid">
                    <?php foreach ( $all_modules as $module_item ) :
                        $module_id = $module_item->term_id;
                        $module_name = $module_item->name;
                        $module_description = $module_item->description;
                        $module_link = $module_item->link;
                        $module_image = '';
                        $module_difficulty = 'Beginner';
                        
                        if ( isset( $module_item->is_post ) && $module_item->is_post ) {
                            // New structure: Post type
                            $module_image = get_the_post_thumbnail_url( $module_id, 'full' );
                            if ( ! $module_image ) {
                                $module_image = get_field( 'module_image', $module_id );
                            }
                            $module_difficulty = get_field( 'difficulty_level', $module_id ) ?: 'Beginner';
                            
                            // Count chapters via ACF relationship
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
                                'no_found_rows' => false,
                            ) );
                            $chapters_count = $chapters_query->post_count;
                            
                            // Calculate total time: chapters + topics + quizzes
                            $total_reading_time_minutes = 0;
                            if ( $chapters_query->have_posts() ) {
                                while ( $chapters_query->have_posts() ) {
                                    $chapters_query->the_post();
                                    $chapter_id = get_the_ID();
                                    
                                    // Add chapter reading time (use raw post content)
                                    $chapter_content = get_post_field( 'post_content', $chapter_id );
                                    $total_reading_time_minutes += calculate_reading_time( $chapter_content );
                                    
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
                                        $total_reading_time_minutes += $topic_duration;
                                    }
                                    
                                    // Add quiz time for this chapter
                                    $chapter_quizzes = array();
                                    if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                        $chapter_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
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
                        } else {
                            // Old structure: Taxonomy
                            $module_image = get_field( 'module_image', $module_item );
                            $module_difficulty = get_field( 'difficulty_level', $module_item ) ?: 'Beginner';
                            
                            // Count chapters in this module
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
                                'orderby' => 'menu_order',
                                'order' => 'ASC',
                                'no_found_rows' => false,
                            ) );
                            $chapters_count = $chapters_query->post_count;
                            
                            // Calculate total time: chapters + topics + quizzes
                            $total_reading_time_minutes = 0;
                            if ( $chapters_query->have_posts() ) {
                                while ( $chapters_query->have_posts() ) {
                                    $chapters_query->the_post();
                                    $chapter_id = get_the_ID();
                                    
                                    // Add chapter reading time (use raw post content)
                                    $chapter_content = get_post_field( 'post_content', $chapter_id );
                                    $total_reading_time_minutes += calculate_reading_time( $chapter_content );
                                    
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
                                        $total_reading_time_minutes += $topic_duration;
                                    }
                                    
                                    // Add quiz time for this chapter
                                    $chapter_quizzes = array();
                                    if ( function_exists( 'vested_academy_get_quizzes_for_module' ) ) {
                                        $chapter_quizzes = vested_academy_get_quizzes_for_module( $chapter_id );
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
                        }
                        
                        // Format display: show minutes if less than 1 hour, otherwise show hours (match single page format)
                        if ( $total_reading_time_minutes < 60 ) {
                            $duration = $total_reading_time_minutes . ' Minutes';
                        } else {
                            $total_hours = round( $total_reading_time_minutes / 60, 1 );
                            $duration = $total_hours . ' Hours';
                        }
                        
                        // Truncate description
                        if ( strlen( $module_description ) > 150 ) {
                            $module_description = substr( $module_description, 0, 150 ) . '...';
                        }
                        
                        // Get module tag/category for overlay (using first word of module name or a default)
                        $module_tag = explode( ' ', $module_name )[0];
                        if ( strlen( $module_tag ) > 15 ) {
                            $module_tag = substr( $module_tag, 0, 15 );
                        }
                        ?>
                        <div class="roadmap-module-card">
                            <?php if ( $module_image ) : ?>
                                <div class="module-card-image-wrapper">
                                    <img src="<?php echo esc_url( $module_image ); ?>" alt="<?php echo esc_attr( $module_name ); ?>" class="module-card-image">
                                    <div class="module-image-tag"><?php echo esc_html( $module_tag ); ?></div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="module-card-content">
                                <h3 class="module-card-title"><?php echo esc_html( $module_name ); ?></h3>
                                
                                <?php if ( $module_description ) : ?>
                                    <p class="module-card-description"><?php echo esc_html( $module_description ); ?></p>
                                <?php endif; ?>
                                
                                <div class="module-card-attributes">
                                    <div class="module-attribute">
                                        <span class="attribute-icon">📊</span>
                                        <span class="attribute-text"><?php echo esc_html( $module_difficulty ); ?></span>
                                    </div>
                                    <div class="module-attribute">
                                        <span class="attribute-icon">📚</span>
                                        <span class="attribute-text"><?php echo esc_html( $chapters_count ); ?> Chapter<?php echo $chapters_count > 1 ? 's' : ''; ?></span>
                                </div>
                                    <div class="module-attribute">
                                        <span class="attribute-icon">⏱️</span>
                                        <span class="attribute-text"><?php echo esc_html( $duration ); ?></span>
                    </div>
                </div>

                                <a href="<?php echo esc_url( $module_link ); ?>" class="module-card-button">
                                    View course detail
                                </a>
                            </div>
                        </div>
                    <?php 
                    wp_reset_postdata();
                    endforeach; 
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
get_footer();

