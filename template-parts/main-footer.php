<?php
/**
 * The footer for our theme
 *
 * @package IRREV-MAG
 * @subpackage Core-Template
 *
 * @since 1.0.0
 */

?>
<footer id="colophon" class="site-footer bg-zinc-950 text-slate-400 py-4 mt-auto">
	<div class="container">
		<div class="site-info flex flex-wrap items-center justify-between gap-2 text-sm">
			<span>
				<?php
				printf(
					/* translators: 1: Copyright symbol, 2: Current year, 3: Site name. */
					esc_html__( '%1$s %2$s %3$s. Todos os direitos reservados.', 'im' ),
					'&copy;',
					esc_html( date_i18n( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</span>
			<span>
				<?php
				printf(
					/* translators: %s: Developer name/link. */
					esc_html__( 'Desenvolvido por %s', 'im' ),
					'<a href="https://irreversivel.pt">.peter</a>'
				);
				?>
			</span>
		</div><!-- .site-info -->
	</div>
</footer><!-- #colophon -->
