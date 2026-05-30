<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IRREV-MAG
 * @subpackage Core-Template
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		(function() {
			var theme = localStorage.getItem('theme');
			if ( theme === 'dark' || ( ! theme && window.matchMedia('(prefers-color-scheme: dark)').matches ) ) {
				document.documentElement.classList.add('dark');
			}
		})();
	</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'wp_body_open' ); ?>

	<?php get_template_part( 'template-parts/main-header' ); ?>
