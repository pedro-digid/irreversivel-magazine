<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up until <div id
 *
 * @package IRREV-MAG
 * @subpackage Core-Template
 *
 * @since 1.0.0
 */

?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'im' ); ?></a>
<?php get_template_part( 'template-parts/modules/annoucement-bar' ); ?>
<header id="masthead" class="site-header bg-zinc-900 text-white py-6">
	<div class="container flex justify-between items-center">
		<?php get_template_part( 'template-parts/site-branding' ); ?>
		<?php get_template_part( 'template-parts/main-navigation' ); ?>
	</div>
</header><!-- #masthead -->
