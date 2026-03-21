<?php
/**
 * Template Name: Home
 * Description: A page template for the home page.
 *
 * @package IRREV-MAG
 * @subpackage Custom-Templates
 */

get_header();
do_action( 'before_main_content' );
get_template_part( 'template-parts/pages/home/hero' );
get_template_part( 'template-parts/modules/destaques' );
get_template_part( 'template-parts/modules/entrevistas' );
get_template_part( 'template-parts/pages/home/content' );
do_action( 'after_main_content' );
get_footer();
