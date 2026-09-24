<?php
/**
 * Template helpers.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function alba_city_attr( $key ) {
	$city = alba_get_current_city();
	$map  = array(
		'name'    => 'data-city-name',
		'prep'    => 'data-city-prep',
		'phone'   => 'data-city-phone',
		'address' => 'data-city-address',
		'extra'   => 'data-city-extra',
		'license' => 'data-city-license',
	);
	$attr = $map[ $key ] ?? '';
	$val  = $city[ $key ] ?? '';
	if ( $attr ) {
		echo ' ' . esc_attr( $attr );
	}
	echo '>' . esc_html( $val );
}

function alba_icon_svg() {
	return "<svg class=\"logo__mark\" viewBox=\"0 0 32 32\"><path fill=\"currentColor\" d=\"M16 1.8c1.7 5.6 5.8 9.7 11.4 11.4C21.8 15 17.7 19.1 16 24.7 14.3 19.1 10.2 15 4.6 13.2 10.2 11.5 14.3 7.4 16 1.8Z\"/></svg>";
}

function alba_arr() {
	return '<span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
}

/**
 * Rewrite .html links + absolutize images/css/js for /{city}/… URLs.
 *
 * @param string $html HTML chunk.
 * @return string
 */
function alba_fix_legacy_html( $html ) {
	if ( ! $html ) {
		return $html;
	}
	$city = alba_get_current_city()['slug'];
	$base = trailingslashit( home_url( '/' ) );

	$html = preg_replace_callback(
		'/href="([^"]+)\.html(#[^"]*)?"/i',
		function ( $mm ) use ( $city ) {
			$file = $mm[1];
			$hash = isset( $mm[2] ) ? $mm[2] : '';
			if ( 0 === strpos( $file, 'service-' ) ) {
				$slug = preg_replace( '/^service-/', '', $file );
				return 'href="' . esc_url( home_url( '/' . $city . '/service/' . $slug . '/' ) ) . $hash . '"';
			}
			if ( 0 === strpos( $file, 'doctor-' ) ) {
				$slug = preg_replace( '/^doctor-/', '', $file );
				return 'href="' . esc_url( home_url( '/' . $city . '/doctor/' . $slug . '/' ) ) . $hash . '"';
			}
			if ( 0 === strpos( $file, 'article-' ) ) {
				return 'href="' . esc_url( home_url( '/' . $city . '/article/' . $file . '/' ) ) . $hash . '"';
			}
			if ( 'index' === $file ) {
				return 'href="' . esc_url( alba_city_url( '' ) ) . $hash . '"';
			}
			return 'href="' . esc_url( alba_city_url( $file ) ) . $hash . '"';
		},
		$html
	);

	$html = preg_replace(
		'/\b(src|href|poster)=(["\'])(?!https?:|\/\/|data:|tel:|mailto:|#)\/?(images|css|js)\//i',
		'$1=$2' . esc_url( $base ) . '$3/',
		$html
	);
	$html = preg_replace(
		'/\burl\((["\']?)\/?(images|css|js)\//i',
		'url($1' . esc_url( $base ) . '$2/',
		$html
	);

	return $html;
}

/**
 * Load <main> from legacy-html file, rewritten for WP city URLs.
 *
 * @param string $file Filename like service-zapoy.html.
 * @return string|false
 */
function alba_get_legacy_main( $file ) {
	$file = basename( $file );
	$path = trailingslashit( ABSPATH ) . 'legacy-html/' . $file;
	if ( ! file_exists( $path ) ) {
		return false;
	}
	$html = file_get_contents( $path );
	if ( ! preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
		return false;
	}
	return alba_fix_legacy_html( $m[1] );
}

add_filter(
	'the_content',
	function ( $content ) {
		return alba_fix_legacy_html( $content );
	},
	20
);
