<?php
/**
 * Crónicas section — Swiper slider with posts from the "crónicas" category.
 *
 * @package IRREV-MAG
 * @subpackage Template-Section
 */

$irrev_mag_cronicas = new WP_Query(
	array(
		'category_name'  => 'destaques',
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

<section class="section-destaques bg-zinc-100 bg-gradient-to-b from-zinc-900 from-[200px] to-zinc-100 to-[200px] py-10">
	<div class="container">

		<h2 class="font-display uppercase tracking-wide text-xl font-bold text-zinc-50 mb-8">
			<span class="text-red-700">&#xbb;</span> <?php esc_html_e( 'Destaques', 'im' ); ?>
		</h2>

		<div class="swiper swiper-cronicas">
			<div class="swiper-wrapper">
				<?php
				while ( $irrev_mag_cronicas->have_posts() ) :
					$irrev_mag_cronicas->the_post();
					$irrev_mag_category = get_the_category();
					?>
					<div class="swiper-slide">
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'group relative overflow-hidden' ); ?>>
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

								<div class="absolute bottom-0 left-0 right-0 p-6">
									<h3 class="font-display uppercase text-sm lg:text-base font-bold text-white leading-snug line-clamp-3">
										<?php the_title(); ?>
									</h3>
								</div>
							</a>
						</article>
					</div>
				<?php endwhile; ?>
			</div>

			<div class="swiper-cronicas-pagination flex justify-center gap-2 mt-8"></div>
		</div>

	</div>
</section>

<?php
wp_reset_postdata();
