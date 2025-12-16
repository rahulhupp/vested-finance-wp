<?php
/**
 * Template Name: Academy Login
 * 
 * Academy-specific login page
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

get_header();
?>

<div id="academy-login-page" class="academy-login-page">
	<div class="container">
		<div class="academy-login-wrapper">
			<div class="academy-login-card">
				<div class="login-header">
					<h1 class="login-title">Welcome to Academy</h1>
					<p class="login-subtitle">Sign in to access quizzes and track your progress</p>
				</div>
				
				<?php
				// Show errors if any
				if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) {
					echo '<div class="academy-error-message">Invalid username or password. Please try again.</div>';
				}
				if ( isset( $_GET['login'] ) && $_GET['login'] === 'empty' ) {
					echo '<div class="academy-error-message">Username and password are required.</div>';
				}
				if ( isset( $_GET['login'] ) && $_GET['login'] === 'invalid_role' ) {
					echo '<div class="academy-error-message">Only Academy Users can access. Please contact support.</div>';
				}
				if ( isset( $_GET['login'] ) && $_GET['login'] === 'email_not_verified' ) {
					$email = isset( $_GET['email'] ) ? sanitize_email( $_GET['email'] ) : '';
					echo '<div class="academy-error-message">';
					echo '<strong>Please verify your email address before logging in. Check your inbox for the verification email.</strong>';
					if ( ! empty( $email ) ) {
						echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin-top: 15px;">';
						echo '<input type="hidden" name="action" value="academy_resend_verification">';
						wp_nonce_field( 'resend_verification', 'resend_verification_nonce' );
						echo '<input type="hidden" name="user_email" value="' . esc_attr( $email ) . '">';
						echo '<button type="submit" class="btn-resend-verification" style="padding: 8px 16px; background: #0073aa; color: white; border: none; cursor: pointer; border-radius: 4px; font-size: 14px;">Resend Verification Email</button>';
						echo '</form>';
					}
					echo '</div>';
				}
				if ( isset( $_GET['verification'] ) && $_GET['verification'] === 'success' ) {
					echo '<div class="academy-success-message">Your email has been verified successfully! You can now log in.</div>';
				}
				if ( isset( $_GET['verification'] ) && $_GET['verification'] === 'already_verified' ) {
					echo '<div class="academy-success-message">Your email is already verified. You can now log in.</div>';
				}
				if ( isset( $_GET['verification'] ) && $_GET['verification'] === 'error' ) {
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
				if ( isset( $_GET['resend'] ) && $_GET['resend'] === 'already_verified' ) {
					echo '<div class="academy-info-message">Your email is already verified. You can log in now.</div>';
				}
				if ( isset( $_GET['resend'] ) && $_GET['resend'] === 'success' ) {
					$email = isset( $_GET['email'] ) ? sanitize_email( $_GET['email'] ) : '';
					echo '<div class="academy-success-message">Verification email has been resent to ' . esc_html( $email ) . '. Please check your inbox.</div>';
				}
				?>
				
				<form name="academy-login-form" id="academy-login-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
					<input type="hidden" name="action" value="academy_login">
					<input type="hidden" name="academy_login" value="1">
					<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/academy/' ) ); ?>">
					<?php wp_nonce_field( 'academy_login', 'academy_login_nonce' ); ?>
					
					<div class="form-group">
						<label for="user_login">Username or Email</label>
						<input type="text" name="log" id="user_login" class="form-control" value="" size="20" required>
					</div>
					
					<div class="form-group">
						<label for="user_pass">Password</label>
						<input type="password" name="pwd" id="user_pass" class="form-control" value="" size="20" required>
					</div>
					
					<div class="form-group form-remember">
						<label>
							<input name="rememberme" type="checkbox" id="rememberme" value="forever">
							Remember me
						</label>
					</div>
					
					<div class="form-group">
						<input type="submit" name="wp-submit" id="wp-submit" class="btn-login" value="Log In">
					</div>
					
					<div class="form-links">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Lost your password?</a>
					</div>
				</form>
				
				<div class="login-divider">
					<span>Don't have an account?</span>
				</div>
				
				<div class="signup-link">
					<a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>" class="btn-signup">Sign Up for Academy</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();

