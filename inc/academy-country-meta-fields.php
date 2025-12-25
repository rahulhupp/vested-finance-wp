<?php
/**
 * Academy Country Restriction Meta Fields
 * 
 * PHP-based meta field system for country restrictions (NO ACF dependency)
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get country choices for meta field dropdown
 * Returns array in format: 'CODE' => 'Country Name'
 * 
 * @return array Country choices
 */
function academy_get_country_choices() {
	return array(
		'AF' => 'Afghanistan',
		'AX' => 'Åland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua and Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BQ' => 'Bonaire, Sint Eustatius and Saba',
		'BA' => 'Bosnia and Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'CV' => 'Cabo Verde',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic of the',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Côte d\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CW' => 'Curaçao',
		'CY' => 'Cyprus',
		'CZ' => 'Czechia',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'SZ' => 'Eswatini',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island and McDonald Islands',
		'VA' => 'Holy See',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KP' => 'Korea, Democratic People\'s Republic of',
		'KR' => 'Korea, Republic of',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MK' => 'North Macedonia',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestine, State of',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Réunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthélemy',
		'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
		'KN' => 'Saint Kitts and Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin (French part)',
		'PM' => 'Saint Pierre and Miquelon',
		'VC' => 'Saint Vincent and the Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome and Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SX' => 'Sint Maarten (Dutch part)',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia and the South Sandwich Islands',
		'SS' => 'South Sudan',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard and Jan Mayen',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks and Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Minor Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis and Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
}

/**
 * Render country restriction meta box
 */
function academy_country_restriction_meta_box_callback( $post ) {
	wp_nonce_field( 'academy_country_restriction_save', 'academy_country_restriction_nonce' );
	
	$restricted_countries = get_post_meta( $post->ID, '_academy_hide_in_countries', true );
	if ( ! is_array( $restricted_countries ) ) {
		$restricted_countries = array();
	}
	
	$country_choices = academy_get_country_choices();
	
	?>
	<div class="academy-country-restriction-meta-box">
		<p class="description">
			Select countries where this content should be hidden. If content is hidden, all its children will also be hidden.
		</p>
		<select 
			name="academy_hide_in_countries[]" 
			id="academy_hide_in_countries" 
			multiple 
			size="10"
			style="width: 100%; min-height: 200px;"
		>
			<?php foreach ( $country_choices as $code => $name ) : ?>
				<option value="<?php echo esc_attr( $code ); ?>" <?php selected( in_array( $code, $restricted_countries ), true ); ?>>
					<?php echo esc_html( $name ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description">
			<strong>Tip:</strong> Hold Ctrl (Windows) or Cmd (Mac) to select multiple countries.
		</p>
		<script>
		jQuery(document).ready(function($) {
			// Make select searchable with Select2 if available, otherwise use native search
			if (typeof $.fn.select2 !== 'undefined') {
				$('#academy_hide_in_countries').select2({
					placeholder: 'Select countries to restrict...',
					allowClear: true,
					width: '100%'
				});
			}
		});
		</script>
	</div>
	<?php
}

/**
 * Register meta boxes for country restrictions
 */
function academy_register_country_restriction_meta_boxes() {
	$post_types = array( 'academy_module', 'module', 'chapter_topic' );
	
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'academy_country_restriction',
			'Country Restrictions',
			'academy_country_restriction_meta_box_callback',
			$post_type,
			'side',
			'default'
		);
	}
}
add_action( 'add_meta_boxes', 'academy_register_country_restriction_meta_boxes' );

/**
 * Save country restriction meta data
 */
function academy_save_country_restriction_meta( $post_id ) {
	// Check nonce
	if ( ! isset( $_POST['academy_country_restriction_nonce'] ) ) {
		return;
	}
	
	if ( ! wp_verify_nonce( $_POST['academy_country_restriction_nonce'], 'academy_country_restriction_save' ) ) {
		return;
	}
	
	// Check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	// Get and sanitize selected countries
	$selected_countries = array();
	if ( isset( $_POST['academy_hide_in_countries'] ) && is_array( $_POST['academy_hide_in_countries'] ) ) {
		$country_choices = academy_get_country_choices();
		foreach ( $_POST['academy_hide_in_countries'] as $country_code ) {
			$country_code = sanitize_text_field( $country_code );
			// Validate country code exists in our list
			if ( isset( $country_choices[ $country_code ] ) ) {
				$selected_countries[] = $country_code;
			}
		}
	}
	
	// Save meta data
	if ( ! empty( $selected_countries ) ) {
		update_post_meta( $post_id, '_academy_hide_in_countries', $selected_countries );
	} else {
		delete_post_meta( $post_id, '_academy_hide_in_countries' );
	}
}
add_action( 'save_post', 'academy_save_country_restriction_meta' );

/**
 * Get restricted countries for a post
 * 
 * @param int $post_id Post ID
 * @return array Array of country codes
 */
function academy_get_restricted_countries( $post_id ) {
	$restricted = get_post_meta( $post_id, '_academy_hide_in_countries', true );
	if ( ! is_array( $restricted ) ) {
		return array();
	}
	return $restricted;
}

