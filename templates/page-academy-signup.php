<?php
/**
 * Template Name: Academy Signup
 * 
 * Academy-specific registration page
 * 
 * @package Vested Finance WP
 */

// Redirect if already logged in
if ( is_user_logged_in() ) {
	$user = wp_get_current_user();
	if ( in_array( 'academy_user', (array) $user->roles ) || current_user_can( 'administrator' ) ) {
		wp_redirect( home_url( '/academy/' ) );
		exit;
	}
}

// Don't show header/footer for this page
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="academy-signup-page" class="academy-auth-page">
	<div class="academy-auth-container">
		<!-- Left Column: Features -->
		<div class="academy-auth-left">
			<div class="academy-auth-left-content">
				<div class="academy-auth-logo">
					<?php
					$logo_image = get_field( 'academy_auth_logo_image', 'option' );
					if ( $logo_image && is_array( $logo_image ) ) {
						echo '<img src="' . esc_url( $logo_image['url'] ) . '" alt="' . esc_attr( $logo_image['alt'] ?: 'Academy Logo' ) . '" />';
					} else {
						// Fallback to default SVG if no image is set
						?>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white"/>
							<path d="M2 17L12 22L22 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M2 12L12 17L22 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
						<span>Academy</span>
						<?php
					}
					?>
				</div>
				<div class="academy-auth-content">
					<h2 class="academy-auth-title"><?php echo esc_html( get_field( 'academy_auth_left_title', 'option' ) ?: 'Why Partner With Vested?' ); ?></h2>
					<div class="academy-auth-features">
						<?php
						$features = get_field( 'academy_auth_features', 'option' );
						if ( $features && is_array( $features ) ) {
							foreach ( $features as $feature ) {
								$icon_image = isset( $feature['icon_image'] ) ? $feature['icon_image'] : '';
								$title = isset( $feature['title'] ) ? $feature['title'] : '';
								$description = isset( $feature['description'] ) ? $feature['description'] : '';
								?>
								<div class="academy-auth-feature">
									<div class="academy-auth-feature-icon">
										<?php if ( $icon_image && is_array( $icon_image ) ) : ?>
											<img src="<?php echo esc_url( $icon_image['url'] ); ?>" alt="<?php echo esc_attr( $icon_image['alt'] ?: $title ); ?>" />
										<?php else : ?>
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/>
											</svg>
										<?php endif; ?>
									</div>
									<div class="academy-auth-feature-text">
										<?php if ( ! empty( $title ) ) : ?>
											<h3><?php echo esc_html( $title ); ?></h3>
										<?php endif; ?>
										<?php if ( ! empty( $description ) ) : ?>
											<p><?php echo esc_html( $description ); ?></p>
										<?php endif; ?>
									</div>
								</div>
								<?php
							}
						} else {
							// Default features if no ACF data
							$default_features = array(
								array(
									'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13H8" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 17H8" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M10 9H9H8" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>',
									'title' => 'Global Product Suite',
									'description' => 'US Stocks & ETFs, Global Funds, Managed Portfolios, Private Markets, GIFT City Funds',
								),
								array(
									'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45768C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
									'title' => 'Dedicated Relationship Manager',
									'description' => 'Personalised support throughout your partnership journey',
								),
								array(
									'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12L11 14L15 10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
									'title' => 'Compliant & Regulated',
									'description' => 'FINRA-regulated, SEC-registered; secure, globally compliant platform',
								),
								array(
									'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="3" width="20" height="14" rx="2" stroke="white" stroke-width="2"/><path d="M8 21H16" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M12 17V21" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>',
									'title' => 'Partner Portal Access',
									'description' => 'Track clients, view commissions, and manage activity in one place',
								),
							);
							foreach ( $default_features as $feature ) {
								?>
								<div class="academy-auth-feature">
									<div class="academy-auth-feature-icon">
										<?php echo $feature['icon']; ?>
									</div>
									<div class="academy-auth-feature-text">
										<h3><?php echo esc_html( $feature['title'] ); ?></h3>
										<p><?php echo esc_html( $feature['description'] ); ?></p>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Right Column: Signup Form -->
		<div class="academy-auth-right">
			<div class="academy-auth-form-wrapper">
				<?php
				// Only show header if NOT showing OTP verification
				$show_verification_message = isset( $_GET['registration'] ) && $_GET['registration'] === 'verify_otp';
				if ( ! $show_verification_message ) :
				?>
				<div class="academy-auth-form-header">
					<h1 class="academy-auth-form-title"><?php echo esc_html( get_field( 'academy_auth_signup_title', 'option' ) ?: 'Join Academy' ); ?></h1>
					<button type="button" class="academy-auth-vested-btn">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/union-logo.svg" alt="union-logo" />
						<?php echo esc_html( get_field( 'academy_auth_button_text', 'option' ) ?: 'Continue with Vested Account' ); ?>
					</button>
				</div>
				<?php endif; ?>
				
				<div class="academy-auth-form-content <?php echo $show_verification_message ? 'academy-auth-form-content-verification' : ''; ?>">
					<?php
					// Show errors if any
					if ( isset( $_GET['registration'] ) && $_GET['registration'] === 'error' ) {
						$error_msg = isset( $_GET['msg'] ) ? sanitize_text_field( $_GET['msg'] ) : 'unknown';
						
						$error_messages = array(
							'empty' => 'Please fill in all required fields.',
							'email_exists' => 'This email is already registered. Please use a different email or try logging in.',
							'unknown' => 'Registration failed. Please try again.'
						);
						
						$message = isset( $error_messages[ $error_msg ] ) ? $error_messages[ $error_msg ] : $error_messages['unknown'];
						echo '<div class="academy-error-message">' . esc_html( $message ) . '</div>';
					}
					
					// Show OTP verification message
					if ( isset( $_GET['registration'] ) && $_GET['registration'] === 'verify_otp' ) {
						$email = isset( $_GET['email'] ) ? sanitize_email( $_GET['email'] ) : '';
						
						// Mask email address
						$masked_email = '';
						if ( ! empty( $email ) ) {
							$email_parts = explode( '@', $email );
							if ( count( $email_parts ) === 2 ) {
								$local = $email_parts[0];
								$domain = $email_parts[1];
								$domain_parts = explode( '.', $domain );
								$masked_local = substr( $local, 0, 3 ) . str_repeat( '*', max( 0, strlen( $local ) - 3 ) );
								$masked_domain = substr( $domain_parts[0], 0, 3 ) . str_repeat( '*', max( 0, strlen( $domain_parts[0] ) - 3 ) ) . '.' . ( isset( $domain_parts[1] ) ? $domain_parts[1] : '' );
								$masked_email = $masked_local . '@' . $masked_domain;
							} else {
								$masked_email = $email;
							}
						}
						?>
						
						<div class="academy-otp-container">
							<h2 class="academy-otp-title">Enter authentication code</h2>
							<p class="academy-otp-instruction">Enter the 4-digit that we have sent via the email to <b><?php echo esc_html( $masked_email ); ?></b></p>
							<div class="academy-otp-form-wrapper">
								<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="academy-otp-form">
									<input type="hidden" name="action" value="academy_verify_otp">
									<?php wp_nonce_field( 'academy_verify_otp', 'academy_verify_otp_nonce' ); ?>
									<input type="hidden" name="user_email" value="<?php echo esc_attr( $email ); ?>">
									
									<div class="academy-otp-inputs">
										<input type="text" name="otp_1" id="otp_1" class="academy-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" required>
										<input type="text" name="otp_2" id="otp_2" class="academy-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" required>
										<input type="text" name="otp_3" id="otp_3" class="academy-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" required>
										<input type="text" name="otp_4" id="otp_4" class="academy-otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off" required>
										<input type="hidden" name="verification_otp" id="verification_otp" value="">
									</div>
									
									<div class="academy-auth-form-group academy-auth-submit-btn-wrapper">
										<button type="submit" class="academy-auth-submit-btn" id="otp-submit-btn" disabled>Continue</button>
									</div>
								</form>
								
								<div class="academy-otp-resend">
									<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="academy-resend-form">
										<input type="hidden" name="action" value="academy_resend_verification">
										<?php wp_nonce_field( 'resend_verification', 'resend_verification_nonce' ); ?>
										<input type="hidden" name="user_email" value="<?php echo esc_attr( $email ); ?>">
										<button type="submit" class="academy-otp-resend-link">Resend code</button>
									</form>
								</div>
							</div>
						</div>
						
						<script>
						document.addEventListener('DOMContentLoaded', function() {
							const otpInputs = document.querySelectorAll('.academy-otp-input');
							const hiddenInput = document.getElementById('verification_otp');
							const submitBtn = document.getElementById('otp-submit-btn');
							const form = document.querySelector('.academy-otp-form');
							
							// Combine OTP inputs into hidden field and check if all filled
							function updateOTP() {
								let otp = '';
								otpInputs.forEach(input => {
									otp += input.value || '';
								});
								hiddenInput.value = otp;
								
								// Enable/disable submit button based on whether all 4 digits are entered
								if (otp.length === 4) {
									submitBtn.disabled = false;
								} else {
									submitBtn.disabled = true;
								}
							}
							
							// Auto-advance to next field
							otpInputs.forEach((input, index) => {
								input.addEventListener('input', function(e) {
									// Only allow numbers
									this.value = this.value.replace(/[^0-9]/g, '');
									
									if (this.value.length === 1 && index < otpInputs.length - 1) {
										otpInputs[index + 1].focus();
									}
									
									updateOTP();
								});
								
								input.addEventListener('keydown', function(e) {
									// Handle backspace
									if (e.key === 'Backspace' && !this.value && index > 0) {
										otpInputs[index - 1].focus();
									}
									// Update button state after backspace
									if (e.key === 'Backspace') {
										setTimeout(updateOTP, 0);
									}
								});
								
								input.addEventListener('paste', function(e) {
									e.preventDefault();
									const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 4);
									
									for (let i = 0; i < pastedData.length && (index + i) < otpInputs.length; i++) {
										otpInputs[index + i].value = pastedData[i];
									}
									
									if (index + pastedData.length < otpInputs.length) {
										otpInputs[index + pastedData.length].focus();
									} else {
										otpInputs[otpInputs.length - 1].focus();
									}
									
									updateOTP();
								});
							});
							
							// Update on form submit
							form.addEventListener('submit', function() {
								updateOTP();
							});
							
							// Initial button state check
							updateOTP();
							
							// Focus first input on load
							if (otpInputs.length > 0) {
								otpInputs[0].focus();
							}
						});
						</script>
						<?php
					}
					
					// Show verification status messages
					if ( isset( $_GET['verification'] ) ) {
						if ( $_GET['verification'] === 'error' ) {
							$error_msg = isset( $_GET['msg'] ) ? sanitize_text_field( $_GET['msg'] ) : 'unknown';
							$verification_errors = array(
								'invalid_otp' => 'Invalid verification code. Please try again.',
								'expired' => 'This verification code has expired. Please request a new one.',
								'user_not_found' => 'User not found. Please contact support if you continue to have issues.',
								'unknown' => 'Verification failed. Please try again or contact support.'
							);
							$message = isset( $verification_errors[ $error_msg ] ) ? $verification_errors[ $error_msg ] : $verification_errors['unknown'];
							echo '<div class="academy-error-message">' . esc_html( $message ) . '</div>';
						}
					}
					
					// Show resend verification status
					if ( isset( $_GET['resend'] ) ) {
						if ( $_GET['resend'] === 'success' ) {
							$email = isset( $_GET['email'] ) ? sanitize_email( $_GET['email'] ) : '';
							echo '<div class="academy-success-message">Verification email has been resent to ' . esc_html( $email ) . '. Please check your inbox.</div>';
						} elseif ( $_GET['resend'] === 'error' ) {
							$error_msg = isset( $_GET['msg'] ) ? sanitize_text_field( $_GET['msg'] ) : 'unknown';
							$resend_errors = array(
								'empty' => 'Email address is required.',
								'user_not_found' => 'No account found with this email address.',
								'unknown' => 'Failed to resend verification email. Please try again.'
							);
							$message = isset( $resend_errors[ $error_msg ] ) ? $resend_errors[ $error_msg ] : $resend_errors['unknown'];
							echo '<div class="academy-error-message">' . esc_html( $message ) . '</div>';
						}
					}
					
					// Only show signup form if not showing verification message
					if ( ! $show_verification_message ) :
					?>
					
					<form name="academy-signup-form" id="academy-signup-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate="novalidate">
						<input type="hidden" name="action" value="academy_register">
						<input type="hidden" name="academy_registration" value="1">
						<?php wp_nonce_field( 'academy_register', 'academy_register_nonce' ); ?>
						
						<div class="academy-auth-form-group">
							<label for="user_name">NAME</label>
							<input type="text" name="user_name" id="user_name" class="academy-auth-input" placeholder="Enter your name" value="" required>
						</div>
						
						<div class="academy-auth-form-group">
							<label for="user_email">EMAIL</label>
							<input type="email" name="user_email" id="user_email" class="academy-auth-input" placeholder="Enter your email" value="" required>
						</div>
						
						<div class="academy-auth-form-group">
							<label for="user_pass">PASSWORD</label>
							<div class="academy-password-input-wrapper">
								<input type="password" name="user_pass" id="user_pass" class="academy-auth-input" placeholder="Create your password" value="" required>
								<button type="button" class="academy-password-toggle" aria-label="Toggle password visibility">
									<img class="academy-password-icon-closed" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye-closed.svg" alt="eye-icon" />
									<img class="academy-password-icon-open" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye-open.svg" alt="eye-icon-open" style="display: none;" />
								</button>
							</div>
						</div>
						
						<div class="academy-auth-form-group">
							<button type="submit" name="wp-submit" id="wp-submit" class="academy-auth-submit-btn">Create Account</button>
						</div>
					</form>
					
					<div class="academy-auth-switch">
						<p>Already have an account? <a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>">Sign In</a></p>
					</div>
					<?php endif; // End form display condition ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
// Password visibility toggle
(function() {
    const passwordToggle = document.querySelector('#academy-signup-page .academy-password-toggle');
    const passwordInput = document.getElementById('user_pass');
    const closedIcon = document.querySelector('#academy-signup-page .academy-password-icon-closed');
    const openIcon = document.querySelector('#academy-signup-page .academy-password-icon-open');
    
    if (passwordToggle && passwordInput && closedIcon && openIcon) {
        passwordToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            if (isPassword) {
                closedIcon.style.display = 'none';
                openIcon.style.display = 'block';
            } else {
                closedIcon.style.display = 'block';
                openIcon.style.display = 'none';
            }
        });
    }
})();
</script>

<?php wp_footer(); ?>
</body>
</html>

