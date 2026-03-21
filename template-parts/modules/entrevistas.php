<?php
/**
 * Crónicas section — Swiper slider with posts from the "crónicas" category.
 *
 * @package IRREV-MAG
 * @subpackage Template-Section
 */

$irrev_mag_cronicas = new WP_Query(
	array(
		'category_name'  => 'entrevistas',
		'posts_per_page' => 16,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

if ( ! $irrev_mag_cronicas->have_posts() ) {
	return;
}
?>

<section class="section-entrevistas bg-zinc-100 py-10">
	<div class="container">

		<h2 class="font-display uppercase tracking-wide text-xl font-bold text-zinc-900 mb-8">
			<span class="text-red-700">&#xbb;</span> <?php esc_html_e( 'Entrevistas', 'im' ); ?>
		</h2>

		<div class="grid grid-cols-2 md:grid-cols-6 lg:grid-cols-12 gap-6">

				<?php
				while ( $irrev_mag_cronicas->have_posts() ) :
					$irrev_mag_cronicas->the_post();
					$irrev_mag_category = get_the_category();
					?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-span-2 group relative overflow-hidden' ); ?>>
							<a href="<?php the_permalink(); ?>" class="block relative aspect-[3/4]">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'medium_large',
										array(
											'class'   => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
											'loading' => 'lazy',
											'alt'     => the_title_attribute( array( 'echo' => false ) ),
										)
									);
									?>
								<?php endif; ?>

								<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

								<div class="absolute bottom-0 left-0 right-0 p-4">
									<h3 class="font-display uppercase text-sm lg:text-base font-bold text-white leading-snug line-clamp-3">
										<?php the_title(); ?>
									</h3>

									<?php if ( ! empty( $irrev_mag_category ) ) : ?>
										<span class="text-xs text-zinc-300 mt-1 block">
											<?php
											$irrev_mag_cat_names = array();
											foreach ( $irrev_mag_category as $irrev_mag_cat ) {
												$irrev_mag_cat_names[] = $irrev_mag_cat->name;
											}
											echo esc_html( implode( ', ', $irrev_mag_cat_names ) );
											?>
										</span>
									<?php endif; ?>
								</div>
							</a>
						</article>

				<?php endwhile; ?>

		</div>
	</div>
</section>

<?php
wp_reset_postdata();
