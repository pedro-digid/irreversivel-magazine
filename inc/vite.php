<?php
/**
 * Vite integration for WordPress
 *
 * Handles loading Vite assets in development (HMR) and production (manifest).
 *
 * @package IRREV-MAG
 * @subpackage Vite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Vite dev server is running.
 *
 * @return bool True if dev server is detected.
 */
function irrev_mag_is_vite_dev() {
	if ( defined( 'IRREV_VITE_DEV' ) ) {
		return IRREV_VITE_DEV;
	}

	return file_exists( get_template_directory() . '/dist/hot' );
}

/**
 * Get the Vite dev server URL.
 *
 * @return string Dev server URL.
 */
function irrev_mag_vite_dev_url() {
	$hot_file = get_template_directory() . '/dist/hot';

	if ( file_exists( $hot_file ) ) {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$contents = $wp_filesystem->get_contents( $hot_file );

		return $contents ? trim( $contents ) : 'https://localhost:5173';
	}

	return 'https://localhost:5173';
}

/**
 * Enqueue Vite assets.
 *
 * In development: loads from Vite dev server with HMR.
 * In production: reads manifest.json and enqueues compiled files.
 *
 * @param string $entry The entry point relative to src (e.g. 'src/js/main.js').
 */
function irrev_mag_vite_enqueue( $entry = 'src/js/main.js' ) {
	if ( irrev_mag_is_vite_dev() ) {
		irrev_mag_vite_enqueue_dev( $entry );
	} else {
		irrev_mag_vite_enqueue_production( $entry );
	}
}

/**
 * Enqueue assets from Vite dev server.
 *
 * @param string $entry Entry point path.
 */
function irrev_mag_vite_enqueue_dev( $entry ) {
	$dev_url = irrev_mag_vite_dev_url();

	// Vite client for HMR.
	// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Vite dev server has no version.
	wp_enqueue_script( 'vite-client', $dev_url . '/@vite/client', array(), null, false );

	// Entry point.
	// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Vite dev server has no version.
	wp_enqueue_script( 'irrev-mag-main', $dev_url . '/' . $entry, array(), null, true );
}

/**
 * Add type="module" to Vite script tags.
 *
 * @param string $tag    The script tag HTML.
 * @param string $handle The script handle.
 * @return string Modified script tag.
 */
function irrev_mag_vite_script_type_module( $tag, $handle ) {
	$vite_handles = array( 'vite-client', 'irrev-mag-main' );

	if ( in_array( $handle, $vite_handles, true ) ) {
		$tag = str_replace( '<script ', '<script type="module" crossorigin ', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'irrev_mag_vite_script_type_module', 10, 2 );

/**
 * Enqueue assets from production build manifest.
 *
 * @param string $entry Entry point path.
 */
function irrev_mag_vite_enqueue_production( $entry ) {
	$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

	if ( ! file_exists( $manifest_path ) ) {
		return;
	}

	global $wp_filesystem;

	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$contents = $wp_filesystem->get_contents( $manifest_path );

	if ( ! $contents ) {
		return;
	}

	$manifest = json_decode( $contents, true );

	if ( ! isset( $manifest[ $entry ] ) ) {
		return;
	}

	$entry_data = $manifest[ $entry ];
	$dist_uri   = get_template_directory_uri() . '/dist';

	// Enqueue CSS files.
	if ( ! empty( $entry_data['css'] ) ) {
		foreach ( $entry_data['css'] as $index => $css_file ) {
			wp_enqueue_style(
				'irrev-mag-style-' . $index,
				$dist_uri . '/' . $css_file,
				array(),
				IRREV_VERSION
			);
		}
	}

	// Enqueue JS file.
	if ( ! empty( $entry_data['file'] ) ) {
		wp_enqueue_script(
			'irrev-mag-main',
			$dist_uri . '/' . $entry_data['file'],
			array(),
			IRREV_VERSION,
			true
		);
	}
}
