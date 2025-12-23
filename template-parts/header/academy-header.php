<?php
/**
 * Academy-specific header template
 * 
 * @package Vested Finance WP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<header id="masthead" class="academy-header site-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
	<div class="academy-header-container inner-header">
		<div class="academy-header-inner site-primary-header-wrap">
			<!-- Logo Section -->
			<div class="academy-logo">
				<a href="<?php echo esc_url( home_url( '/academy' ) ); ?>" class="academy-logo-link">
					<?php
					// Get custom logo from ACF options, fallback to theme custom logo
					$academy_logo = get_field( 'academy_header_logo', 'option' );
					$logo_displayed = false;
					
					if ( $academy_logo && isset( $academy_logo['url'] ) ) {
						$logo_url = $academy_logo['url'];
						$logo_alt = isset( $academy_logo['alt'] ) ? $academy_logo['alt'] : esc_attr( get_bloginfo( 'name' ) );
						echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_alt ) . '" class="academy-logo-img">';
						$logo_displayed = true;
					}
					
					// Fallback to theme custom logo
					if ( ! $logo_displayed ) {
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						if ( $custom_logo_id ) {
							$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
							if ( $logo ) {
								echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="academy-logo-img">';
								$logo_displayed = true;
							}
						}
					}
					
					if ( ! $logo_displayed ) {
						echo '<span class="academy-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
					}
					?>
				</a>
			</div>

			<!-- Navigation Menu -->
			<nav class="academy-navigation logo-menu" role="navigation" aria-label="<?php esc_attr_e( 'Academy Menu', 'vested-finance-wp' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'academy_menu',
						'menu_class'     => 'academy-menu',
						'container'      => false,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>

			<!-- Right Side Actions -->
			<div class="academy-header-actions">
				<?php if ( is_user_logged_in() ) : ?>
					<?php
					$logout_text = get_field( 'academy_header_logout_text', 'option' ) ?: 'Log Out';
					?>
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/academy/' ) ) ); ?>" class="academy-logout-link">
						<?php echo esc_html( $logout_text ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! is_user_logged_in() ) : ?>
					<?php
					$login_text = get_field( 'academy_header_login_text', 'option' ) ?: 'Log In';
					$signup_text = get_field( 'academy_header_signup_text', 'option' ) ?: 'Sign Up';
					?>
					<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="academy-login-link">
						<?php echo esc_html( $login_text ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>" class="academy-signup-link">
						<?php echo esc_html( $signup_text ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Mobile Menu Toggle -->
			<button class="academy-mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'vested-finance-wp' ); ?>" aria-expanded="false">
				<span class="academy-menu-icon">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</button>
		</div>
	</div>

	<!-- Mobile Menu -->
	<div class="academy-mobile-menu">
		<nav class="academy-mobile-navigation" role="navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'academy_menu',
					'menu_class'     => 'academy-mobile-menu-list',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
			<div class="academy-mobile-actions">
				<?php if ( is_user_logged_in() ) : ?>
					<?php
					$logout_text_mobile = get_field( 'academy_header_logout_text', 'option' ) ?: 'Log Out';
					?>
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/academy/' ) ) ); ?>" class="academy-logout-link">
						<?php echo esc_html( $logout_text_mobile ); ?>
					</a>
				<?php endif; ?>
				<?php if ( ! is_user_logged_in() ) : ?>
					<?php
					$login_text_mobile = get_field( 'academy_header_login_text', 'option' ) ?: 'Log In';
					$signup_text_mobile = get_field( 'academy_header_signup_text', 'option' ) ?: 'Sign Up';
					?>
					<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="academy-login-link">
						<?php echo esc_html( $login_text_mobile ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>" class="academy-signup-link">
						<?php echo esc_html( $signup_text_mobile ); ?>
					</a>
				<?php endif; ?>
			</div>
		</nav>
	</div>
</header>

