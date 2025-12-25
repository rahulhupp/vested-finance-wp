<?php
/**
 * Academy Country Restrictions
 * 
 * Root-level server-side country restriction system
 * NO ACF dependency, NO sessions, NO cookies, NO JavaScript dependency
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get user country via server-side IP detection
 * Uses transient cache to avoid repeated API calls
 * 
 * @return string|null Country code (ISO 2-letter) or null if detection fails
 */
function academy_get_user_country() {
	// Check transient cache first (15 minute cache)
	$cache_key = 'academy_user_country_' . md5( $_SERVER['REMOTE_ADDR'] );
	$cached_country = get_transient( $cache_key );
	
	if ( $cached_country !== false ) {
		return $cached_country;
	}
	
	// Get user IP
	$user_ip = $_SERVER['REMOTE_ADDR'];
	
	// Handle proxy/load balancer headers
	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$forwarded_ips = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
		$user_ip = trim( $forwarded_ips[0] );
	} elseif ( ! empty( $_SERVER['HTTP_X_REAL_IP'] ) ) {
		$user_ip = $_SERVER['HTTP_X_REAL_IP'];
	}
	
	// Validate IP
	if ( ! filter_var( $user_ip, FILTER_VALIDATE_IP ) ) {
		return null;
	}
	
	// Skip localhost/private IPs (for development)
	if ( filter_var( $user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) === false ) {
		// For local development, you might want to return a default country
		// return 'US'; // Uncomment and set default for local testing
		return null;
	}
	
	// Try GeoJS API (free, no API key required)
	$geoip_url = 'https://get.geojs.io/v1/ip/country/' . urlencode( $user_ip ) . '.json';
	
	$response = wp_remote_get( $geoip_url, array(
		'timeout' => 3,
		'sslverify' => true,
	) );
	
	if ( is_wp_error( $response ) ) {
		// API request failed, try fallback
	} else {
		$response_code = wp_remote_retrieve_response_code( $response );
		
		if ( $response_code === 200 ) {
			$body = wp_remote_retrieve_body( $response );
			$data = json_decode( $body, true );
			
			if ( isset( $data['country'] ) && ! empty( $data['country'] ) ) {
				$country_code = strtoupper( sanitize_text_field( $data['country'] ) );
				// Cache for 15 minutes
				set_transient( $cache_key, $country_code, 15 * MINUTE_IN_SECONDS );
				return $country_code;
			}
		}
	}
	
	// Fallback: Try ipapi.co (free tier available)
	$fallback_url = 'https://ipapi.co/' . urlencode( $user_ip ) . '/country_code/';
	
	$fallback_response = wp_remote_get( $fallback_url, array(
		'timeout' => 3,
		'sslverify' => true,
	) );
	
	if ( is_wp_error( $fallback_response ) ) {
		// Fallback API failed
	} else {
		$fallback_code = wp_remote_retrieve_response_code( $fallback_response );
		
		if ( $fallback_code === 200 ) {
			$country_code = trim( wp_remote_retrieve_body( $fallback_response ) );
			
			if ( ! empty( $country_code ) && strlen( $country_code ) === 2 ) {
				$country_code = strtoupper( $country_code );
				set_transient( $cache_key, $country_code, 15 * MINUTE_IN_SECONDS );
				return $country_code;
			}
		}
	}
	
	// Cache null result for shorter time (5 minutes) to avoid repeated failed requests
	set_transient( $cache_key, null, 5 * MINUTE_IN_SECONDS );
	return null;
}

/**
 * Get restricted countries for a post (with inheritance)
 * 
 * @param int $post_id Post ID
 * @return array Array of country codes
 */
function academy_get_restricted_countries_for_post( $post_id ) {
	if ( ! $post_id ) {
		return array();
	}
	
	$post = get_post( $post_id );
	if ( ! $post ) {
		return array();
	}
	
	$restricted = array();
	
	// Check post's own restrictions
	$post_restrictions = get_post_meta( $post_id, '_academy_hide_in_countries', true );
	
	if ( is_array( $post_restrictions ) && ! empty( $post_restrictions ) ) {
		$restricted = array_merge( $restricted, $post_restrictions );
	}
	
	// Inheritance: Check parent restrictions based on post type
	$post_type = $post->post_type;
	
	if ( $post_type === 'module' ) {
		// Chapter inherits from Module
		$module_id = get_post_meta( $post_id, 'academy_module', true );
		
		if ( ! $module_id ) {
			// Try ACF relationship field (for migration compatibility)
			if ( function_exists( 'get_field' ) ) {
				$module_field = get_field( 'academy_module', $post_id );
				
				if ( is_array( $module_field ) && ! empty( $module_field ) ) {
					$module_id = $module_field[0];
				} elseif ( is_numeric( $module_field ) ) {
					$module_id = $module_field;
				}
			}
		}
		
		if ( $module_id ) {
			$module_restrictions = get_post_meta( $module_id, '_academy_hide_in_countries', true );
			
			if ( is_array( $module_restrictions ) && ! empty( $module_restrictions ) ) {
				$restricted = array_merge( $restricted, $module_restrictions );
			}
		}
	} elseif ( $post_type === 'chapter_topic' ) {
		// Topic inherits from Chapter, then Module
		$chapter_id = $post->post_parent;
		
		if ( $chapter_id ) {
			$chapter_restrictions = get_post_meta( $chapter_id, '_academy_hide_in_countries', true );
			
			if ( is_array( $chapter_restrictions ) && ! empty( $chapter_restrictions ) ) {
				$restricted = array_merge( $restricted, $chapter_restrictions );
			}
			
			// Get module from chapter
			$module_id = get_post_meta( $chapter_id, 'academy_module', true );
			if ( ! $module_id && function_exists( 'get_field' ) ) {
				$module_field = get_field( 'academy_module', $chapter_id );
				if ( is_array( $module_field ) && ! empty( $module_field ) ) {
					$module_id = $module_field[0];
				} elseif ( is_numeric( $module_field ) ) {
					$module_id = $module_field;
				}
			}
			
			if ( $module_id ) {
				$module_restrictions = get_post_meta( $module_id, '_academy_hide_in_countries', true );
				if ( is_array( $module_restrictions ) && ! empty( $module_restrictions ) ) {
					$restricted = array_merge( $restricted, $module_restrictions );
				}
			}
		}
	}
	
	// Remove duplicates and return
	$final_restricted = array_unique( $restricted );
	return $final_restricted;
}

/**
 * CENTRAL RESTRICTION API - Single source of truth
 * 
 * Check if content is restricted for current user's country
 * 
 * @param int $post_id Post ID
 * @return bool True if restricted (should block), false if allowed
 */
function academy_is_content_restricted( $post_id ) {
	if ( ! $post_id ) {
		return false;
	}
	
	// Get user country
	$user_country = academy_get_user_country();
	
	// If country detection fails, allow access (fail-open for now)
	// Change to return true if you want fail-closed behavior
	if ( empty( $user_country ) ) {
		return false;
	}
	
	// Get restricted countries (with inheritance)
	$restricted_countries = academy_get_restricted_countries_for_post( $post_id );
	
	// If no restrictions, allow access
	if ( empty( $restricted_countries ) ) {
		return false;
	}
	
	// Check if user's country is in restricted list
	$is_restricted = in_array( $user_country, $restricted_countries, true );
	
	return $is_restricted;
}

/**
 * Block access to restricted content via template_redirect
 */
function academy_block_restricted_content() {
	// Only check on frontend
	if ( is_admin() ) {
		return;
	}
	
	// Get current post
	global $post;
	if ( ! $post ) {
		return;
	}
	
	// Only check Academy post types
	$academy_post_types = array( 'academy_module', 'module', 'chapter_topic' );
	if ( ! in_array( $post->post_type, $academy_post_types, true ) ) {
		return;
	}
	
	// Check if content is restricted
	$is_restricted = academy_is_content_restricted( $post->ID );
	
	if ( $is_restricted ) {
		// Redirect to Academy home or show 404
		$academy_home = home_url( '/academy/' );
		if ( $academy_home ) {
			wp_safe_redirect( $academy_home, 302 );
			exit;
		} else {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
		}
	}
}
add_action( 'template_redirect', 'academy_block_restricted_content', 1 );

/**
 * Exclude restricted content from queries
 * Uses caching to avoid repeated checks
 */
function academy_exclude_restricted_from_queries( $query ) {
	// Only on frontend, main query
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	
	// Get user country once
	$user_country = academy_get_user_country();
	
	if ( empty( $user_country ) ) {
		return; // No restrictions if country unknown
	}
	
	// Get restricted post IDs
	$academy_post_types = array( 'academy_module', 'module', 'chapter_topic' );
	$post_types = $query->get( 'post_type' );
	
	// Check if query includes Academy post types
	$should_filter = false;
	if ( is_array( $post_types ) ) {
		$should_filter = ! empty( array_intersect( $post_types, $academy_post_types ) );
	} elseif ( in_array( $post_types, $academy_post_types, true ) || empty( $post_types ) ) {
		$should_filter = true;
	}
	
	if ( ! $should_filter ) {
		return;
	}
	
	// Cache restricted IDs per country (5 minute cache)
	$cache_key = 'academy_restricted_ids_' . $user_country;
	$restricted_ids = get_transient( $cache_key );
	
	if ( false === $restricted_ids ) {
		// Get directly restricted posts
		global $wpdb;
		$direct_restricted = $wpdb->get_col( $wpdb->prepare(
			"SELECT DISTINCT post_id 
			FROM {$wpdb->postmeta} 
			WHERE meta_key = %s 
			AND meta_value LIKE %s",
			'_academy_hide_in_countries',
			'%' . $wpdb->esc_like( $user_country ) . '%'
		) );
		
		$restricted_ids = array_map( 'intval', $direct_restricted );
		
		// Check inherited restrictions for all Academy posts
		// This is cached, so performance impact is minimal
		$all_academy_posts = $wpdb->get_col( $wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} 
			WHERE post_type IN ('academy_module', 'module', 'chapter_topic') 
			AND post_status = 'publish'"
		) );
		
		foreach ( $all_academy_posts as $post_id ) {
			if ( academy_is_content_restricted( $post_id ) ) {
				$restricted_ids[] = (int) $post_id;
			}
		}
		
		$restricted_ids = array_unique( $restricted_ids );
		
		// Cache for 5 minutes
		set_transient( $cache_key, $restricted_ids, 5 * MINUTE_IN_SECONDS );
	}
	
	if ( ! empty( $restricted_ids ) ) {
		$post__not_in = $query->get( 'post__not_in' );
		if ( ! is_array( $post__not_in ) ) {
			$post__not_in = array();
		}
		$merged = array_merge( $post__not_in, $restricted_ids );
		$query->set( 'post__not_in', $merged );
	}
}
add_action( 'pre_get_posts', 'academy_exclude_restricted_from_queries', 10 );

/**
 * Legacy function for backward compatibility
 * Maps to new central API
 * 
 * @deprecated Use academy_is_content_restricted() instead
 */
function vested_academy_is_content_hidden( $post_id, $field_name = 'hide_in_countries' ) {
	return academy_is_content_restricted( $post_id );
}
