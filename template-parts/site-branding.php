<?php
/**
 * Displays the site branding
 *
 * @package IRREV-MAG
 * @subpackage Template-Parts
 */

?>

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
