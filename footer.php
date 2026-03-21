<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IRREV-MAG
 * @subpackage Core-Template
 */

?>

	<footer id="colophon" class="site-footer bg-slate-950 text-slate-400 py-4 mt-auto">
		<div class="container">
			<div class="site-info">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'im' ) ); ?>">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'im' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
					<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'im' ), 'Irreversível Magazine', '<a href="http://underscores.me/">.peter</a>' );
					?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
