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
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="academy-logo-link">
					<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					if ( $custom_logo_id ) {
						$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
						if ( $logo ) {
							echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="academy-logo-img">';
						}
					} else {
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
						'theme_location' => 'primary',
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
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/academy/' ) ) ); ?>" class="academy-logout-link">
						Log Out
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="academy-login-link">
						Log In
					</a>
					<a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>" class="academy-signup-link">
						Sign Up
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
					'theme_location' => 'primary',
					'menu_class'     => 'academy-mobile-menu-list',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
			<div class="academy-mobile-actions">
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wp_logout_url( home_url( '/academy/' ) ) ); ?>" class="academy-logout-link">
						Log Out
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/academy/login' ) ); ?>" class="academy-login-link">
						Log In
					</a>
					<a href="<?php echo esc_url( home_url( '/academy/signup' ) ); ?>" class="academy-signup-link">
						Sign Up
					</a>
				<?php endif; ?>
			</div>
		</nav>
	</div>
</header>

