<?php
/**
 * Template Name: Testing
 * Description: A page template for testing things out.
 *
 * @package Irrev_Mag
 */

get_header();

$landscape_id = get_field( 'hero_section_landscape' );
$portrait_id  = get_field( 'hero_section_portrait' );

if ( $landscape_id ) {
	irrev_mag_hero_picture( $landscape_id, $portrait_id );
}

get_footer();
