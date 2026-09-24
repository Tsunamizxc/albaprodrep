<?php
/**
 * Disable Gutenberg (block editor) — classic + ACF only.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'use_block_editor_for_post', '__return_false', 100 );
add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );

add_action(
	'admin_init',
	static function () {
		remove_post_type_support( 'page', 'editor' );
		// Keep a thin classic editor on posts/CPTs as fallback notes; pages = ACF only.
	}
);

// Hide block widgets screen noise.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	},
	100
);
