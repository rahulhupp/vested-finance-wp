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

// Note: We handle Academy registration ourselves, so we don't need to check WordPress registration setting

get_header();
?>

<div id="academy-signup-page" class="academy-signup-page">
	<div class="container">
		<div class="academy-signup-wrapper">
			<div class="academy-signup-card">
				<div class="signup-header">
					<h1 class="signup-title">Join Academy</h1>
					<p class="signup-subtitle">Create your account to start learning</p>
				</div>
				
				<?php
				// Show errors if any
				if ( isset( $_GET['registration'] ) && $_GET['registration'] === 'error' ) {
					$error_msg = isset( $_GET['msg'] ) ? sanitize_text_field( $_GET['msg'] ) : 'unknown';
					
					$error_messages = array(
						'empty' => 'Please fill in all required fields.',
						'password_mismatch' => 'Passwords do not match. Please try again.',
						'email_exists' => 'This email is already registered. Please use a different email or try logging in.',
						'unknown' => 'Registration failed. Please try again.'
					);
					
					$message = isset( $error_messages[ $error_msg ] ) ? $error_messages[ $error_msg ] : $error_messages['unknown'];
					echo '<div class="academy-error-message">' . esc_html( $message ) . '</div>';
				}
				
				// Show email verification message
				if ( isset( $_GET['registration'] ) && $_GET['registration'] === 'verify_email' ) {
					$email = isset( $_GET['email'] ) ? sanitize_email( $_GET['email'] ) : '';
					echo '<div class="academy-info-message">';
					echo '<h3>Check Your Email</h3>';
					echo '<p>We\'ve sent a verification email to <strong>' . esc_html( $email ) . '</strong></p>';
					echo '<p>Please click the verification link in the email to activate your account. The link will expire in 24 hours.</p>';
					echo '<p>Didn\'t receive the email? Check your spam folder or resend it below.</p>';
					
					// Resend verification form
					echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin-top: 20px;">';
					echo '<input type="hidden" name="action" value="academy_resend_verification">';
					wp_nonce_field( 'resend_verification', 'resend_verification_nonce' );
					echo '<input type="hidden" name="user_email" value="' . esc_attr( $email ) . '">';
					echo '<button type="submit" class="btn-resend-verification" style="padding: 10px 20px; background: #0073aa; color: white; border: none; cursor: pointer; border-radius: 4px;">Resend Verification Email</button>';
					echo '</form>';
					echo '</div>';
				}
				
				// Show verification status messages
				if ( isset( $_GET['verification'] ) ) {
					if ( $_GET['verification'] === 'error' ) {
						$error_msg = isset( $_GET['msg'] ) ? sanitize_text_field( $_GET['msg'] ) : 'unknown';
						$verification_errors = array(
							'invalid_link' => 'Invalid verification link. Please check the link and try again.',
							'invalid_token' => 'Invalid verification token. The link may have been used already.',
							'expired' => 'This verification link has expired. Please request a new one.',
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
				$show_verification_message = isset( $_GET['registration'] ) && $_GET['registration'] === 'verify_email';
				if ( ! $show_verification_message ) :
				?>
				
				<form name="academy-signup-form" id="academy-signup-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate="novalidate">
					<input type="hidden" name="action" value="academy_register">
					<input type="hidden" name="academy_registration" value="1">
					<?php wp_nonce_field( 'academy_register', 'academy_register_nonce' ); ?>
					
					<div class="form-group">
						<label for="user_email">Email</label>
						<input type="email" name="user_email" id="user_email" class="form-control" value="" size="25" required>
					</div>
					
					<div class="form-group">
						<label for="user_pass">Password</label>
						<input type="password" name="user_pass" id="user_pass" class="form-control" value="" size="20" required>
						<small class="form-help">Use a strong password with at least 8 characters</small>
					</div>
					
					<div class="form-group">
						<label for="user_pass_confirm">Confirm Password</label>
						<input type="password" name="user_pass_confirm" id="user_pass_confirm" class="form-control" value="" size="20" required>
					</div>
					
					<div class="form-group">
						<input type="submit" name="wp-submit" id="wp-submit" class="btn-signup-submit" value="Create Account">
					</div>
				</form>
				
				<div class="signup-divider">
					<span>Already have an account?</span>
				</div>
				
				<div class="login-link">
					<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="btn-login-link">Log In</a>
				</div>
				<?php endif; // End form display condition ?>
			</div>
		</div>
	</div>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
	const form = document.getElementById('academy-signup-form');
	const password = document.getElementById('user_pass');
	const passwordConfirm = document.getElementById('user_pass_confirm');
	
	form.addEventListener('submit', function(e) {
		if (password.value !== passwordConfirm.value) {
			e.preventDefault();
			alert('Passwords do not match. Please try again.');
			return false;
		}
	});
});
</script>

<?php
get_footer();

