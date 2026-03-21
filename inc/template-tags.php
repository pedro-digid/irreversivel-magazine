<?php
/**
 * Custom template tags for this theme
 *
 * @package IRREV-MAG
 * @subpackage Template-Tags
 */

if ( ! function_exists( 'irrev_mag_before_main_content' ) ) :
	/**
	 * Open the main content wrapper.
	 */
	function irrev_mag_before_main_content() {
		?>
		<main id="main-content" class="main-content overflow-hidden mt-auto">
		<?php
	}
	add_action( 'before_main_content', 'irrev_mag_before_main_content' );
endif;

if ( ! function_exists( 'irrev_mag_after_main_content' ) ) :
	/**
	 * Close the main content wrapper.
	 */
	function irrev_mag_after_main_content() {
		?>
		</main><!-- #main-content -->
		<?php
	}
	add_action( 'after_main_content', 'irrev_mag_after_main_content' );
endif;

if ( ! function_exists( 'irrev_mag_before_post_content' ) ) :
	/**
	 * Open the post article wrapper.
	 */
	function irrev_mag_before_post_content() {
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
	}
	add_action( 'before_post_content', 'irrev_mag_before_post_content' );
endif;

if ( ! function_exists( 'irrev_mag_after_post_content' ) ) :
	/**
	 * Close the post article wrapper.
	 */
	function irrev_mag_after_post_content() {
		?>
		</article><!-- .post -->
		<?php
	}
	add_action( 'after_post_content', 'irrev_mag_after_post_content' );
endif;

if ( ! function_exists( 'irrev_mag_posted_on' ) ) :
	/**
	 * Print HTML with meta information for the current post-date/time.
	 */
	function irrev_mag_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'im' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'irrev_mag_posted_by' ) ) :
	/**
	 * Print HTML with meta information for the current author.
	 */
	function irrev_mag_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'im' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'irrev_mag_entry_footer' ) ) :
	/**
	 * Print HTML with meta information for the categories, tags and comments.
	 */
	function irrev_mag_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( esc_html__( ', ', 'im' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'im' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'im' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'im' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title. */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'im' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'im' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'irrev_mag_post_thumbnail' ) ) :
	/**
	 * Display an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function irrev_mag_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->
		<?php else : ?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>
			<?php
			endif;
	}
endif;

if ( ! function_exists( 'irrev_mag_hero_picture' ) ) :
	/**
	 * Output a responsive <picture> hero with art direction.
	 *
	 * Upload 2 images: one landscape (desktop) and one portrait (mobile/tablet).
	 * WordPress generates the intermediate sizes automatically.
	 *
	 * @param int $landscape_id Attachment ID for the landscape image.
	 * @param int $portrait_id  Attachment ID for the portrait image.
	 */
	function irrev_mag_hero_picture( $landscape_id, $portrait_id ) {
		$landscape_srcset = wp_get_attachment_image_srcset( $landscape_id, 'full' );
		$landscape_src    = wp_get_attachment_image_url( $landscape_id, 'full' );
		$alt              = get_post_meta( $landscape_id, '_wp_attachment_image_alt', true );

		if ( ! $landscape_src ) {
			return;
		}

		$portrait_srcset = wp_get_attachment_image_srcset( $portrait_id, 'irrev-hero-portrait' );
		?>
		<section class="irrev-hero">
			<picture>
				<?php if ( $portrait_srcset ) : ?>
					<source
						media="(max-width: 1023px)"
						sizes="100vw"
						srcset="<?php echo esc_attr( $portrait_srcset ); ?>"
					/>
				<?php endif; ?>

				<img
					src="<?php echo esc_url( $landscape_src ); ?>"
					srcset="<?php echo esc_attr( $landscape_srcset ); ?>"
					sizes="100vw"
					alt="<?php echo esc_attr( $alt ); ?>"
					class="irrev-hero__img"
					loading="eager"
					fetchpriority="high"
					decoding="async"
				/>
			</picture>
			<div style="font-size: 5vw" id="data"></div>
			<script>
				window.addEventListener( 'resize', updateText );
				updateText();

				function updateText() {
					const data = document.querySelector( '#data' );
					data.textContent = `Width: ${ window.innerWidth }, Ratio: ${ window.devicePixelRatio }`;
				}
			</script>
		</section>
		<?php
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
