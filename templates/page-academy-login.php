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

<div id="academy-login-page" class="academy-auth-page">
	<div class="academy-auth-container">
		<!-- Left Column: Features -->
		<div class="academy-auth-left">
			<div class="academy-auth-left-content">
				<div class="academy-auth-logo">
					<?php
					$logo_image = get_field( 'academy_auth_logo_image', 'option' );
					if ( $logo_image && is_array( $logo_image ) ) {
						echo '<img src="' . esc_url( $logo_image['url'] ) . '" alt="' . esc_attr( $logo_image['alt'] ?: 'Academy Logo' ) . '" />';
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
						}
						?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Right Column: Login Form -->
		<div class="academy-auth-right">
			<div class="academy-auth-form-wrapper">
				<div class="academy-auth-form-header">
					<h1 class="academy-auth-form-title"><?php echo esc_html( get_field( 'academy_auth_login_title', 'option' ) ?: 'Welcome Back' ); ?></h1>
					
					<button type="button" class="academy-auth-vested-btn">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/union-logo.svg" alt="union-logo" />
						<?php echo esc_html( get_field( 'academy_auth_button_text', 'option' ) ?: 'Continue with Vested Account' ); ?>
					</button>
				</div>
				<div class="academy-auth-form-content">
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
					?>
					
					<form name="academy-login-form" id="academy-login-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
						<input type="hidden" name="action" value="academy_login">
						<input type="hidden" name="academy_login" value="1">
						<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( '/academy/' ) ); ?>">
						<?php wp_nonce_field( 'academy_login', 'academy_login_nonce' ); ?>
						
						<div class="academy-auth-form-group">
							<label for="user_login">EMAIL</label>
							<input type="text" name="log" id="user_login" class="academy-auth-input" placeholder="Enter Your Email" value="" required>
						</div>
						
						<div class="academy-auth-form-group">
							<label for="user_pass">PASSWORD</label>
							<div class="academy-password-input-wrapper">
								<input type="password" name="pwd" id="user_pass" class="academy-auth-input" placeholder="Enter your password" value="" required>
								<button type="button" class="academy-password-toggle" aria-label="Toggle password visibility">
									<img class="academy-password-icon-closed" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye-closed.svg" alt="eye-icon" />
									<img class="academy-password-icon-open" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/eye-open.svg" alt="eye-icon-open" style="display: none;" />
								</button>
							</div>
						</div>
						
						<div class="academy-auth-form-group academy-auth-remember">
							<label>
								<input name="rememberme" type="checkbox" id="rememberme" value="forever" checked>
								<span>Remember me</span>
							</label>
						</div>
						
						<div class="academy-auth-form-group academy-auth-submit-btn-wrapper">
							<button type="submit" name="wp-submit" id="wp-submit" class="academy-auth-submit-btn">Sign In</button>
						</div>
						
						<!-- <div class="academy-auth-form-links">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Lost your password?</a>
						</div> -->
					</form>
					
					<div class="academy-auth-switch">
						<p>Don't have an account? <a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>">Sign Up</a></p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<script>
(function() {
    const passwordToggle = document.querySelector('.academy-password-toggle');
    const passwordInput = document.getElementById('user_pass');
    const closedIcon = document.querySelector('.academy-password-icon-closed');
    const openIcon = document.querySelector('.academy-password-icon-open');
    
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
</body>
</html>

