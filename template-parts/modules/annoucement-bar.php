<?php
/**
 * Template part for displaying an announcement bar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IRREV-MAG
 * @subpackage Module-Template
 */

?>

<div class="announcement-bar bg-zinc-950 text-zinc-300 text-xs uppercase tracking-widest py-2 overflow-hidden" role="marquee" aria-label="<?php esc_attr_e( 'Anúncios', 'im' ); ?>">
		<div class="announcement-bar__track">
			<?php
			$irrev_mag_items = '';
			for ( $i = 0; $i < 6; $i++ ) {
				$irrev_mag_items .= sprintf(
					'<span class="announcement-bar__item"><span class="text-zinc-300 font-bold mr-1">%1$s</span> %2$s <span class="announcement-bar__separator" aria-hidden="true">&#x2022;</span></span>',
					esc_html__( 'Brevemente:', 'im' ),
					esc_html__( 'Uma Noite Irreversível 2026, 14 Outubro', 'im' )
				);
			}

			// Two identical groups — animation slides exactly one group out.
			?>
			<span class="announcement-bar__group"><?php echo wp_kses_post( $irrev_mag_items ); ?></span>
			<span class="announcement-bar__group" aria-hidden="true"><?php echo wp_kses_post( $irrev_mag_items ); ?></span>
		</div>
	</div>