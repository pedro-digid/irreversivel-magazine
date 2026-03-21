<?php
/**
 * Homepage hero — featured posts grid.
 *
 * Displays sticky posts first, falls back to most recent.
 * Layout: 1 large post (7 cols) + sidebar list (5 cols).
 *
 * @package IRREV-MAG
 * @subpackage Template-Section
 */

$irrev_mag_sticky_ids = get_option( 'sticky_posts' );
$irrev_mag_hero_count = 5;

$irrev_mag_hero_args = array(
	'posts_per_page'      => $irrev_mag_hero_count,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);

// Prioritize sticky posts, fill remaining spots with recent posts.
if ( ! empty( $irrev_mag_sticky_ids ) ) {
	$irrev_mag_hero_args['post__in'] = $irrev_mag_sticky_ids;
	$irrev_mag_hero_args['orderby']  = 'post__in';
}

$irrev_mag_hero_query = new WP_Query( $irrev_mag_hero_args );

// If we got fewer stickies than needed, backfill with recent posts.
if ( $irrev_mag_hero_query->post_count < $irrev_mag_hero_count && ! empty( $irrev_mag_sticky_ids ) ) {
	$irrev_mag_existing_ids = wp_list_pluck( $irrev_mag_hero_query->posts, 'ID' );

	$irrev_mag_backfill = new WP_Query(
		array(
			'posts_per_page' => $irrev_mag_hero_count - $irrev_mag_hero_query->post_count,
			'post_status'    => 'publish',
			'post__not_in'   => $irrev_mag_existing_ids,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	$irrev_mag_hero_query->posts      = array_merge( $irrev_mag_hero_query->posts, $irrev_mag_backfill->posts );
	$irrev_mag_hero_query->post_count = count( $irrev_mag_hero_query->posts );
}

if ( ! $irrev_mag_hero_query->have_posts() ) {
	return;
}
?>

<section class="hero-home bg-zinc-900 text-slate-50 pt-16 pb-20">
	<div class="container">
		<div class="grid grid-cols-12 gap-6">

			<?php
			$irrev_mag_hero_query->the_post();
			$irrev_mag_category = get_the_category();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'hero-home__featured col-span-12 lg:col-span-7 relative overflow-hidden group' ); ?>>
				<a href="<?php the_permalink(); ?>" class="block relative aspect-[4/3] lg:aspect-auto lg:h-full">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php
						the_post_thumbnail(
							'large',
							array(
								'class'         => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
								'loading'       => 'eager',
								'fetchpriority' => 'high',
								'alt'           => the_title_attribute( array( 'echo' => false ) ),
							)
						);
						?>
					<?php endif; ?>

					<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

					<div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
						<?php if ( ! empty( $irrev_mag_category ) ) : ?>
							<span class="article__cat">
								<?php echo esc_html( $irrev_mag_category[0]->name ); ?>
							</span>
						<?php endif; ?>

						<h2 class="font-display uppercase text-2xl lg:text-4xl font-bold text-zinc-50 leading-tight mb-2">
							<?php the_title(); ?>
						</h2>

						<div class="text-sm uppercase text-zinc-300">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</div>
					</div>
				</a>
			</article>

			<?php if ( $irrev_mag_hero_query->post_count > 1 ) : ?>
				<div class="hero-home__sidebar col-span-12 lg:col-span-5 flex flex-col gap-4">
					<?php
					while ( $irrev_mag_hero_query->have_posts() ) :
						$irrev_mag_hero_query->the_post();
						$irrev_mag_category = get_the_category();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'hero-home__sidebar-item group' ); ?>>
							<a href="<?php the_permalink(); ?>" class="flex gap-4 items-center">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="shrink-0 w-24 h-24 lg:w-28 lg:h-28 overflow-hidden">
										<?php
										the_post_thumbnail(
											'thumbnail',
											array(
												'class'   => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105',
												'loading' => 'lazy',
												'alt'     => the_title_attribute( array( 'echo' => false ) ),
											)
										);
										?>
									</div>
								<?php endif; ?>

								<div class="flex-1 min-w-0">
									<?php if ( ! empty( $irrev_mag_category ) ) : ?>
										<span class="article__cat">
											<?php echo esc_html( $irrev_mag_category[0]->name ); ?>
										</span>
									<?php endif; ?>

									<h3 class="font-display text-base lg:text-lg font-semibold leading-snug mt-1 line-clamp-2">
										<?php the_title(); ?>
									</h3>

									<time class="text-xs uppercase text-zinc-400 mt-1 block" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
										<?php echo esc_html( get_the_date() ); ?>
									</time>
								</div>
							</a>
						</article>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<?php
wp_reset_postdata();
