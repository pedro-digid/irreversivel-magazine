<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package testing
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-zinc-100' ); ?>>
	<header class="entry-header bg-zinc-900 text-zinc-100 py-16">
		<div class="container flex gap-8">
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta flex flex-col gap-1 text-xs uppercase text-zinc-400">
					<?php
					irrev_mag_reading_time();
					irrev_mag_posted_on();
					irrev_mag_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-meta-separator border-l border-zinc-700 self-stretch"></div>

			<div class="article-single-title">
				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-categories text-sm uppercase tracking-wider text-zinc-400 mb-4">
						<?php irrev_mag_post_categories(); ?>
					</div>
				<?php endif; ?>

				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title font-display font-bold uppercase text-4xl tracking-wide">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title font-display font-bold uppercase text-2xl tracking-wide"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				the_excerpt();
				?>
			</div>

		</div>

	</header><!-- .entry-header -->

	<?php irrev_mag_post_thumbnail(); ?>

	<div class="entry-content py-16">
		<div class="container">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'testing' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'testing' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="container">
			<?php irrev_mag_entry_footer(); ?>
		</div>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
