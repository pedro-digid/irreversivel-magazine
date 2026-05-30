<?php
/**
 * Displays the main navigation (desktop + mobile).
 *
 * @package IRREV-MAG
 * @subpackage Template-Parts
 */

?>
<div class="flex items-center gap-4">
	<nav id="site-navigation" class="main-navigation hidden lg:flex items-center gap-4">
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

	<button
		class="mobile-menu-toggle lg:hidden"
		data-mobile-menu-toggle
		type="button"
		aria-controls="mobile-menu-panel"
		aria-expanded="false"
		aria-label="<?php esc_attr_e( 'Open menu', 'im' ); ?>"
	>
		<span class="mobile-menu-toggle__bar" aria-hidden="true"></span>
		<span class="mobile-menu-toggle__bar" aria-hidden="true"></span>
		<span class="mobile-menu-toggle__bar" aria-hidden="true"></span>
	</button>
</div>

<div
	id="mobile-menu-panel"
	class="mobile-menu"
	role="dialog"
	aria-modal="true"
	aria-label="<?php esc_attr_e( 'Navigation menu', 'im' ); ?>"
	hidden
>
	<div class="mobile-menu__overlay" data-mobile-menu-overlay></div>

	<div class="mobile-menu__panel">
		<div class="mobile-menu__header">
			<button
				class="mobile-menu__close"
				data-mobile-menu-close
				type="button"
				aria-label="<?php esc_attr_e( 'Close menu', 'im' ); ?>"
			>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<nav class="mobile-menu__nav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'mobile-menu',
					'container'      => false,
				)
			);
			?>
		</nav>
	</div>
</div>
