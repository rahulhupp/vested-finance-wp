<?php
/**
 * Academy Country Restrictions
 * 
 * Handles country-based content restrictions for Academy
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get user country from session or return default
 */
function vested_academy_get_user_country() {
	// Ensure session is started
	if ( ! session_id() && ! headers_sent() ) {
		session_start();
	}
	
	// Check session first
	if ( isset( $_SESSION['user_country'] ) && ! empty( $_SESSION['user_country'] ) ) {
		return sanitize_text_field( $_SESSION['user_country'] );
	}
	
	// Check cookie as fallback
	if ( isset( $_COOKIE['vested_user_country'] ) && ! empty( $_COOKIE['vested_user_country'] ) ) {
		$country = sanitize_text_field( $_COOKIE['vested_user_country'] );
		// Also store in session for faster access
		if ( ! session_id() && ! headers_sent() ) {
			session_start();
		}
		if ( session_id() ) {
			$_SESSION['user_country'] = $country;
		}
		return $country;
	}
	
	// Return null if not set
	return null;
}

/**
 * Store user country in session
 */
function vested_academy_store_user_country( $country ) {
	if ( ! session_id() ) {
		session_start();
	}
	$_SESSION['user_country'] = sanitize_text_field( $country );
	// Also set cookie for persistence
	setcookie( 'vested_user_country', sanitize_text_field( $country ), time() + ( 86400 * 30 ), '/' ); // 30 days
}

/**
 * Get country code from country name or code
 * Maps country names to their ISO codes
 */
function vested_academy_get_country_code( $country_input ) {
	if ( empty( $country_input ) ) {
		return null;
	}
	
	// Country name to code mapping
	$country_map = array(
		'India' => 'IN',
		'United States' => 'US',
		'United Kingdom' => 'GB',
		'Canada' => 'CA',
		'Australia' => 'AU',
		'Germany' => 'DE',
		'France' => 'FR',
		'Japan' => 'JP',
		'China' => 'CN',
		'Brazil' => 'BR',
	);
	
	// If it's already a code (2 letters), return as is
	if ( strlen( $country_input ) === 2 && ctype_upper( $country_input ) ) {
		return $country_input;
	}
	
	// If it's a country name, map it to code
	if ( isset( $country_map[ $country_input ] ) ) {
		return $country_map[ $country_input ];
	}
	
	// Return original if no mapping found
	return $country_input;
}

/**
 * Check if content should be hidden for user's country
 * 
 * @param int|string $post_id Post ID or ACF field array
 * @param string $field_name ACF field name for country restrictions
 * @return bool True if should be hidden, false if should be shown
 */
function vested_academy_is_content_hidden( $post_id, $field_name = 'hide_in_countries' ) {
	$user_country = vested_academy_get_user_country();
	
	// If no country detected, show all content
	if ( empty( $user_country ) ) {
		return false;
	}
	
	// Get restricted countries from ACF field
	$restricted_countries = get_field( $field_name, $post_id );
	
	// If get_field returns null, try alternative methods
	if ( $restricted_countries === null || $restricted_countries === false ) {
		// Try getting field object to find the actual field key
		$field_object = get_field_object( $field_name, $post_id );
		
		if ( $field_object && isset( $field_object['value'] ) ) {
			$restricted_countries = $field_object['value'];
		} else {
			// Try post meta directly (ACF stores with field name as key)
			$restricted_countries = get_post_meta( $post_id, $field_name, true );
			
			// If still empty, try with ACF prefix pattern
			if ( empty( $restricted_countries ) ) {
				// ACF might store as field_key or field_name
				global $wpdb;
				$meta_keys = $wpdb->get_col( $wpdb->prepare(
					"SELECT meta_key FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key LIKE %s",
					$post_id,
					'%' . $wpdb->esc_like( $field_name ) . '%'
				) );
				
				if ( ! empty( $meta_keys ) ) {
					// Try the first matching key
					foreach ( $meta_keys as $meta_key ) {
						$meta_value = get_post_meta( $post_id, $meta_key, true );
						if ( ! empty( $meta_value ) ) {
							$restricted_countries = $meta_value;
							break;
						}
					}
				}
			}
		}
	}
	
	// If no restrictions set, show content
	if ( empty( $restricted_countries ) ) {
		return false;
	}
	
	// Handle different return formats from ACF
	// ACF might return: array, string, or JSON string
	if ( is_string( $restricted_countries ) ) {
		// Try to decode JSON string first (e.g., '["India"]')
		$decoded = json_decode( $restricted_countries, true );
		if ( json_last_error() === JSON_ERROR_NONE && is_array( $decoded ) ) {
			$restricted_countries = $decoded;
		} else {
			// Single string value, convert to array
			$restricted_countries = array( $restricted_countries );
		}
	}
	
	// Ensure it's an array
	if ( ! is_array( $restricted_countries ) ) {
		return false;
	}
	
	// Normalize user country to code
	$user_country_code = vested_academy_get_country_code( $user_country );
	
	// Check each restricted country - handle both codes and names
	foreach ( $restricted_countries as $restricted_country ) {
		$restricted_code = vested_academy_get_country_code( $restricted_country );
		
		// Compare codes
		if ( $user_country_code === $restricted_code ) {
			return true;
		}
	}
	
	return false;
}

/**
 * AJAX handler to store user country
 */
function vested_academy_ajax_store_country() {
	check_ajax_referer( 'vested_country_nonce', 'nonce' );
	
	$country = isset( $_POST['country'] ) ? sanitize_text_field( $_POST['country'] ) : '';
	
	if ( ! empty( $country ) ) {
		vested_academy_store_user_country( $country );
		wp_send_json_success( array( 'country' => $country ) );
	} else {
		wp_send_json_error( array( 'message' => 'Country not provided' ) );
	}
}
add_action( 'wp_ajax_vested_store_user_country', 'vested_academy_ajax_store_country' );
add_action( 'wp_ajax_nopriv_vested_store_user_country', 'vested_academy_ajax_store_country' );

/**
 * Initialize session for country storage
 */
function vested_academy_init_session() {
	if ( ! session_id() && ! headers_sent() ) {
		session_start();
	}
}
add_action( 'init', 'vested_academy_init_session', 1 );

