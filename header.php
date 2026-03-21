<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IRREV-MAG
 * @subpackage Core-Template
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<script>
		(function() {
			var theme = localStorage.getItem('theme');
			if ( theme === 'dark' || ( ! theme && window.matchMedia('(prefers-color-scheme: dark)').matches ) ) {
				document.documentElement.classList.add('dark');
			}
		})();
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'im' ); ?></a>

		<header id="masthead" class="site-header bg-slate-900 text-white py-4">
			<div class="container flex justify-between items-center">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$irrev_mag_description = get_bloginfo( 'description', 'display' );
					if ( $irrev_mag_description || is_customize_preview() ) :
						?>
						<p class="site-description screen-reader-text"><?php echo esc_html( $irrev_mag_description ); ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<div class="flex items-center gap-4">
					<nav id="site-navigation" class="main-navigation flex items-center gap-4">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'testing' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->

					<button data-theme-toggle type="button" class="theme-toggle" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'im' ); ?>">
						<span class="theme-toggle__icon theme-toggle__icon--light" aria-hidden="true">&#9788;</span>
						<span class="theme-toggle__icon theme-toggle__icon--dark" aria-hidden="true">&#9790;</span>
					</button>
				</div>

			</div>

		</header><!-- #masthead -->
