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

<?php
$bg_image = get_field( 'academy_home_bg_image' );
$bg_image_url = $bg_image;
?>
<div id="academy-home-page" class="academy-home-page">
    <div class="academy-home-bg" style="background-image: url('<?php echo esc_url( $bg_image_url ); ?>');"></div>
    <section class="academy-hero-section">
        <div class="academy-trust-bar">
            <p class="trust-text"><?php echo get_field('trust_bar_text'); ?></p>
        </div>
        <div class="container">
            <div class="academy-hero-content">
                <div class="hero-text-content">
                    <h1 class="hero-title">
                        <?php echo get_field('hero_title'); ?>
                    </h1>
                    <div class="hero-interactive-learning-badge">
                        <div class="badge-icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/polygon.svg" alt="Badge">
                        </div>
                        <span class="badge-text">let’s learn</span>
                    </div>
                    <div class="hero-interactive-badge">
                        <div class="badge-icon">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/users.svg" alt="Badge">
                        </div>
                        <span class="badge-text"><?php echo wp_kses_post( get_field('badge_text') ); ?></span>
                    </div>
                    <div class="hero-subtitle-wrapper">
                        <?php echo esc_html( get_field('hero_title_highlight') ); ?>
                    </div>
                    <a href="<?php echo esc_url( get_field('hero_cta_link') ); ?>" class="hero-cta-button">
                        <?php echo esc_html( get_field('hero_cta_text') ); ?> →
                    </a>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo esc_html( get_field('stat_chapters') ); ?></div>
                            <div class="stat-label"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/play-icon.svg" alt="Chapters"> Chapters</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo esc_html( get_field('stat_hours') ); ?></div>
                            <div class="stat-label"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clock-icon.svg" alt="Hours of Content"> Hours of Content</div>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo esc_html( get_field('stat_rating') ); ?></div>
                            <div class="stat-label"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/star-icon.svg" alt="Average Rating"> Average Rating</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="academy-transition-section">
        <div class="container">
            <h2 class="transition-title"><?php echo esc_html( get_field('novice_title') ); ?></h2>
            <p class="transition-subtitle"><?php echo esc_html( get_field('novice_subtitle') ); ?></p>
            <div class="features-grid">
                <?php while ( have_rows('novice_features') ) : the_row(); ?>
                <div class="feature-card">
                    <div class="feature-visual">
                        <img src="<?php echo esc_url( get_sub_field('feature_image') ); ?>" alt="<?php echo esc_attr( get_sub_field('feature_title') ); ?>">
                    </div>
                    <h3 class="feature-title"><?php echo esc_html( get_sub_field('feature_title') ); ?></h3>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Step-by-Step Roadmap Section -->
    <section class="academy-roadmap-section">
        <div class="container">
            <div class="roadmap-header">
                <h2 class="roadmap-title"><?php echo esc_html( get_field('roadmap_title') ); ?></h2>
                <p class="roadmap-subtitle"><?php echo esc_html( get_field('roadmap_subtitle') ); ?></p>
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
                    $module_id = get_the_ID();
                    
                    // Skip restricted modules
                    if ( function_exists( 'academy_is_content_restricted' ) && academy_is_content_restricted( $module_id ) ) {
                        continue;
                    }
                    
                    $all_modules[] = (object) array(
                        'ID' => $module_id,
                        'name' => get_the_title(),
                        'description' => get_the_excerpt(),
                        'term_id' => $module_id,
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
                $modules_count = count( $all_modules );
                $is_slider = $modules_count > 3;
                $slider_class = $is_slider ? 'roadmap-modules-slider' : 'roadmap-modules-grid';
                ?>
                <div class="<?php echo esc_attr( $slider_class ); ?>" <?php echo $is_slider ? 'data-slider="true"' : ''; ?>>
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
                        
                        // Get continue URL (last visited or next uncompleted item)
                        $continue_url = $module_link; // Default to module page
                        $user_id = get_current_user_id();
                        
                        // If user is not logged in, use module page
                        if ( ! $user_id ) {
                            $continue_url = $module_link;
                        } elseif ( function_exists( 'vested_academy_get_continue_url' ) ) {
                            // Check if user has started reading (has resume state or progress)
                            $has_started = false;
                            
                            // Check for resume state
                            if ( function_exists( 'vested_academy_get_resume_state' ) ) {
                                $resume_state = vested_academy_get_resume_state( $module_id );
                                if ( $resume_state && isset( $resume_state['chapter_id'] ) ) {
                                    $has_started = true;
                                }
                            }
                            
                            // Check for module progress if no resume state
                            if ( ! $has_started && function_exists( 'vested_academy_get_module_progress' ) ) {
                                $module_progress = vested_academy_get_module_progress( $user_id, $module_id );
                                if ( ! empty( $module_progress ) ) {
                                    $has_started = true;
                                }
                            }
                            
                            // If user has started, check if module is fully completed
                            if ( $has_started ) {
                                // Check if all topics and quizzes are completed
                                $is_module_completed = false;
                                if ( function_exists( 'vested_academy_get_next_incomplete_url' ) ) {
                                    $next_incomplete = vested_academy_get_next_incomplete_url( $module_id, $user_id );
                                    // If no incomplete items found, module is fully completed
                                    if ( $next_incomplete === null ) {
                                        $is_module_completed = true;
                                    }
                                }
                                
                                // If module is fully completed, use module page; otherwise get continue URL
                                if ( $is_module_completed ) {
                                    $continue_url = $module_link; // All completed, use module page
                                } else {
                                    $continue_url = vested_academy_get_continue_url( $module_id );
                                    if ( ! $continue_url ) {
                                        $continue_url = $module_link; // Fallback to module page
                                    }
                                }
                            } else {
                                $continue_url = $module_link; // User hasn't started, use module page
                            }
                        }
                        ?>
                        <div class="roadmap-module-item">
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
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/chart-icon.svg" alt="Difficulty" class="attribute-icon">
                                            <span class="attribute-text"><?php echo esc_html( $module_difficulty ); ?></span>
                                        </div>
                                        <div class="module-attribute">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/book-icon.svg" alt="Chapters" class="attribute-icon">
                                            <span class="attribute-text"><?php echo esc_html( $chapters_count ); ?> Chapter<?php echo $chapters_count > 1 ? 's' : ''; ?></span>
                                        </div>
                                        <div class="module-attribute">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/clock-icon2.svg" alt="Duration" class="attribute-icon">
                                            <span class="attribute-text"><?php echo esc_html( $duration ); ?></span>
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
                    endforeach; 
                    ?>
                </div>
                
                <?php if ( $is_slider ) : ?>
                    <div class="roadmap-slider-pagination"></div>
                <?php endif; ?>
            <?php endif; ?>
            
            <!--             <div class="roadmap-view-all">
                <a href="<?php echo esc_url( get_field('view_all_link') ); ?>" class="view-all-courses-button">
                    <?php echo esc_html( get_field('view_all_text') ); ?> →
                </a>
            </div> -->
        </div>
    </section>

    <!-- The Vested Advantage Section -->
    <section class="academy-advantage-section">
        <div class="container">
            <div class="advantage-header">
                <h2 class="advantage-title"><?php echo esc_html( get_field('advantage_title') ); ?></h2>
                <p class="advantage-subtitle"><?php echo esc_html( get_field('advantage_subtitle') ); ?></p>
            </div>
            
            <div class="advantage-features-grid">
                <?php while ( have_rows('advantage_features') ) : the_row(); ?>
                <div class="advantage-feature-card">
                    <div class="advantage-feature-icon">
                        <img src="<?php echo esc_url( get_sub_field('feature_icon') ); ?>" alt="<?php echo esc_attr( get_sub_field('feature_title') ); ?>">
                    </div>
                    <div class="advantage-feature-content">
                        <h3 class="advantage-feature-title"><?php echo esc_html( get_sub_field('feature_title') ); ?></h3>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="advantage-cta">
                <a href="<?php echo esc_url( get_field('advantage_cta_link') ); ?>" class="advantage-cta-button">
                    <?php echo esc_html( get_field('advantage_cta_text') ); ?> →
                </a>
            </div>
        </div>
    </section>

    <!-- Ready to Put Your Knowledge to Work Section -->
    <section class="academy-knowledge-section">
        <div class="container">
            <div class="knowledge-content-wrapper">
                <div class="knowledge-text-column">
                    <h2 class="knowledge-title"><?php echo esc_html( get_field('knowledge_title') ); ?></h2>
                    <p class="knowledge-description">
                        <?php echo esc_html( get_field('knowledge_description') ); ?>
                    </p>
                    
                    <div class="knowledge-features-list">
                        <?php $index = 0; while ( have_rows('knowledge_features') ) : the_row(); $index++; ?>
                        <div class="knowledge-feature-item">
                            <div class="knowledge-feature-number"><?php echo esc_html( $index ); ?></div>
                            <div class="knowledge-feature-text">
                                <?php echo esc_html( get_sub_field('feature_text') ); ?>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <a href="<?php echo esc_url( get_field('knowledge_cta_link') ); ?>" class="knowledge-cta-button">
                        <?php echo esc_html( get_field('knowledge_cta_text') ); ?> →
                    </a>
                </div>
                
                <div class="knowledge-visual-column">
                    <div class="knowledge-mobile-mockup">
                        <img src="<?php echo esc_url( get_field('knowledge_image') ); ?>" alt="Vested Finance App">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Earn a Certificate Section -->
    <section class="academy-certificate-section">
        <div class="container">
            <div class="certificate-content-wrapper">
                <div class="certificate-text-column">
                    <h2 class="certificate-title"><?php echo esc_html( get_field('certificate_title') ); ?></h2>
                    <p class="certificate-description">
                        <?php echo esc_html( get_field('certificate_description') ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_field('certificate_cta_link') ); ?>" class="certificate-cta-button">
                        <?php echo esc_html( get_field('certificate_cta_text') ); ?> →
                    </a>
                </div>
                
                <div class="certificate-visual-column">
                    <div class="certificate-placeholder">
                        <img src="<?php echo esc_url( get_field('certificate_image') ); ?>" alt="Certificate">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="academy-faq-section">
        <div class="container">
            <div class="faq-header">
                <h2 class="faq-title"><?php echo esc_html( get_field('faq_title') ); ?></h2>
                <p class="faq-subtitle"><?php echo esc_html( get_field('faq_subtitle') ); ?></p>
            </div>
            
            <div class="faq-accordion">
                <?php $index = 0; while ( have_rows('faq_items') ) : the_row(); ?>
                <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="faq-question">
                        <span class="faq-question-text"><?php echo esc_html( get_sub_field('faq_question') ); ?></span>
                        <span class="faq-toggle-icon"><?php echo $index === 0 ? '−' : '+'; ?></span>
                    </div>
                    <div class="faq-answer" <?php echo $index === 0 ? '' : 'style="display: none;"'; ?>>
                        <p><?php echo esc_html( get_sub_field('faq_answer') ); ?></p>
                    </div>
                </div>
                <?php $index++; endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Download App Section -->
    <section class="academy-download-section">
        <div class="container">
            <div class="download-content-wrapper">
                <div class="download-visual-column">
                    <div class="download-mobile-mockup">
                        <img src="<?php echo esc_url( get_field('download_image') ); ?>" alt="Vested App">
                    </div>
                </div>
                
                <div class="download-text-column">
                    <h2 class="download-title"><?php echo esc_html( get_field('download_title') ); ?></h2>
                    <p class="download-description">
                        <?php echo esc_html( get_field('download_description') ); ?>
                    </p>
                    
                    <div class="download-buttons">
                        <?php while ( have_rows('download_buttons') ) : the_row(); ?>
                        <a href="<?php echo esc_url( get_sub_field('button_link') ); ?>" class="download-button">
                            <img src="<?php echo esc_url( get_sub_field('button_icon') ); ?>" alt="<?php echo esc_attr( get_sub_field('button_text') ); ?>">
                            <?php echo esc_html( get_sub_field('button_text') ); ?>
                        </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const toggleIcon = item.querySelector('.faq-toggle-icon');
        
        question.addEventListener('click', function() {
            const isActive = item.classList.contains('active');
            
            // Close all items
            faqItems.forEach(otherItem => {
                otherItem.classList.remove('active');
                const otherAnswer = otherItem.querySelector('.faq-answer');
                const otherIcon = otherItem.querySelector('.faq-toggle-icon');
                otherAnswer.style.display = 'none';
                otherIcon.textContent = '+';
            });
            
            // Toggle current item
            if (!isActive) {
                item.classList.add('active');
                answer.style.display = 'block';
                toggleIcon.textContent = '−';
            }
        });
    });
    
    // Roadmap Slider
    function initRoadmapSlider() {
        const roadmapSlider = document.querySelector('.roadmap-modules-slider[data-slider="true"]');
        if (roadmapSlider && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
            jQuery(roadmapSlider).slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: true,
                appendDots: jQuery('.roadmap-slider-pagination'),
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
        } else if (roadmapSlider && typeof jQuery === 'undefined') {
            // Retry after a short delay if jQuery isn't loaded yet
            setTimeout(initRoadmapSlider, 100);
        }
    }
    
    // Initialize slider
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRoadmapSlider);
    } else {
        // If DOM is already loaded, wait for jQuery
        if (typeof jQuery !== 'undefined') {
            jQuery(document).ready(initRoadmapSlider);
        } else {
            window.addEventListener('load', function() {
                setTimeout(initRoadmapSlider, 500);
            });
        }
    }
});
</script>

<?php
get_footer();

