<?php
/**
 * City URL rewrites: /{city}/about, /{city}/service/zapoy
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'query_vars',
	function ( $vars ) {
		$vars[] = 'alba_city';
		return $vars;
	}
);

add_action(
	'init',
	function () {
		$slugs = alba_get_city_slugs();
		if ( ! $slugs ) {
			return;
		}
		$group = implode( '|', array_map( 'preg_quote', $slugs ) );

		// Broader rules first (each 'top' prepends — last registered wins).
		// Nested pages /omsk/parent/child
		add_rewrite_rule( '^(' . $group . ')/(.+?)/?$', 'index.php?alba_city=$matches[1]&pagename=$matches[2]', 'top' );
		// /omsk/page-slug/
		add_rewrite_rule( '^(' . $group . ')/([^/]+)/?$', 'index.php?alba_city=$matches[1]&pagename=$matches[2]', 'top' );
		// /omsk/
		add_rewrite_rule( '^(' . $group . ')/?$', 'index.php?alba_city=$matches[1]', 'top' );
		// CPT + article — registered last so they beat the catch-all above.
		add_rewrite_rule( '^(' . $group . ')/service/([^/]+)/?$', 'index.php?alba_city=$matches[1]&service=$matches[2]', 'top' );
		add_rewrite_rule( '^(' . $group . ')/program/([^/]+)/?$', 'index.php?alba_city=$matches[1]&program=$matches[2]', 'top' );
		// Safety: plural /programs/slug → program CPT (catalog page is /programs/, singles are /program/).
		add_rewrite_rule( '^(' . $group . ')/programs/([^/]+)/?$', 'index.php?alba_city=$matches[1]&program=$matches[2]', 'top' );
		add_rewrite_rule( '^(' . $group . ')/doctor/([^/]+)/?$', 'index.php?alba_city=$matches[1]&doctor=$matches[2]', 'top' );
		add_rewrite_rule( '^(' . $group . ')/article/([^/]+)/?$', 'index.php?alba_city=$matches[1]&name=$matches[2]', 'top' );
	},
	20
);

add_action(
	'template_redirect',
	'alba_city_template_redirect',
	1
);

/**
 * Request path relative to WP home (handles subdirectory installs like /alba/).
 *
 * @param string $path Raw request path.
 * @return string Path starting with /.
 */
function alba_request_path( $path = '' ) {
	if ( '' === $path ) {
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
		$path        = (string) wp_parse_url( $request_uri, PHP_URL_PATH );
	}
	$path = $path ? $path : '/';

	$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$home_path = untrailingslashit( $home_path ? $home_path : '' );
	if ( $home_path && 0 === strpos( $path, $home_path . '/' ) ) {
		$path = substr( $path, strlen( $home_path ) ) ?: '/';
	} elseif ( $home_path && $path === $home_path ) {
		$path = '/';
	}
	return $path ? $path : '/';
}

/**
 * Resolve legacy filename stem to pretty city URL.
 *
 * @param string $stem      e.g. service-zapoy, doctor-volkov, about.
 * @param string $city_slug City.
 * @return string
 */
function alba_legacy_stem_url( $stem, $city_slug = '' ) {
	$stem = preg_replace( '/\.(html?)$/i', '', (string) $stem );
	$stem = ltrim( $stem, '/' );
	if ( ! $stem || 'index' === $stem ) {
		return alba_city_url( '', $city_slug );
	}
	if ( 0 === strpos( $stem, 'service-' ) || 0 === strpos( $stem, 'program-' ) ) {
		if ( function_exists( 'alba_service_permalink' ) ) {
			$url = alba_service_permalink( $stem );
			// Ensure city prefix when permalink helper returned absolute without city in admin context.
			if ( $city_slug && false === strpos( $url, '/' . $city_slug . '/' ) ) {
				$bucket = preg_match( '/^program-/i', $stem ) || preg_match( '/zapoy-\d/i', $stem ) ? 'program' : 'service';
				$slug   = preg_replace( '/^(service|program)-/', '', $stem );
				return home_url( '/' . $city_slug . '/' . $bucket . '/' . $slug . '/' );
			}
			return $url;
		}
		$bucket = 0 === strpos( $stem, 'program-' ) ? 'program' : 'service';
		$slug   = preg_replace( '/^(service|program)-/', '', $stem );
		return home_url( '/' . ( $city_slug ?: alba_get_current_city()['slug'] ) . '/' . $bucket . '/' . $slug . '/' );
	}
	if ( 0 === strpos( $stem, 'doctor-' ) ) {
		return home_url( '/' . ( $city_slug ?: alba_get_current_city()['slug'] ) . '/doctor/' . preg_replace( '/^doctor-/', '', $stem ) . '/' );
	}
	if ( 0 === strpos( $stem, 'article-' ) ) {
		return home_url( '/' . ( $city_slug ?: alba_get_current_city()['slug'] ) . '/article/' . $stem . '/' );
	}
	return alba_city_url( $stem, $city_slug );
}

/**
 * City cookie + legacy HTML redirects + root → default city.
 */
function alba_city_template_redirect() {
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'WP_ADMIN' ) && WP_ADMIN ) || ( function_exists( 'is_login' ) && is_login() ) ) {
			return;
		}

		$path = alba_request_path();

		// Never touch WP core / API paths (also /wp-admin without leading issues).
		if ( preg_match( '#(^|/)(wp-admin|wp-login\.php|wp-cron\.php|wp-json|xmlrpc\.php)(/|$)#i', $path ) ) {
			return;
		}

		$city = get_query_var( 'alba_city' );
		if ( $city && alba_get_city_by_slug( $city ) ) {
			if ( ! isset( $_COOKIE['alba_city'] ) || $_COOKIE['alba_city'] !== $city ) {
				setcookie( 'alba_city', $city, time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), false );
			}
		}

		// Legacy *.html → pretty /{city}/… URLs (works under /alba/ subdirectory).
		if ( preg_match( '#^/([^/]+)/([^/]+\.html)/?$#i', $path, $m ) && alba_get_city_by_slug( $m[1] ) ) {
			$target = alba_legacy_stem_url( basename( $m[2] ), $m[1] );
			if ( $target ) {
				wp_safe_redirect( trailingslashit( $target ), 301 );
				exit;
			}
		}
		// Bare /service-zapoy.html → /{default}/service/zapoy/
		if ( preg_match( '#^/([^/]+\.html)/?$#i', $path, $m ) ) {
			$def = alba_get_default_city();
			wp_safe_redirect( trailingslashit( alba_legacy_stem_url( basename( $m[1] ), $def['slug'] ) ), 301 );
			exit;
		}

		// Wrong bucket: /service/zapoy-1day/ when CPT is program → fix.
		if ( preg_match( '#^/([^/]+)/(service|program)/([^/]+)/?$#i', $path, $m ) && alba_get_city_by_slug( $m[1] ) ) {
			$want = strtolower( $m[2] );
			$slug = sanitize_title( $m[3] );
			$post = get_page_by_path( $slug, OBJECT, array( 'service', 'program' ) );
			if ( $post && $post->post_type !== $want ) {
				wp_safe_redirect( trailingslashit( home_url( '/' . $m[1] . '/' . $post->post_type . '/' . $slug ) ), 301 );
				exit;
			}
		}

		// Fix stacked city URLs: /kemerovo/alba/spb → /spb/ (or /kemerovo/about/).
		$city_slugs = alba_get_city_slugs();
		$home_seg   = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		$stack      = array_values( array_filter( explode( '/', trim( $path, '/' ) ) ) );
		if ( count( $stack ) >= 2 ) {
			$cities_in_path = array();
			$rest_parts     = array();
			foreach ( $stack as $seg ) {
				if ( $home_seg && $seg === $home_seg ) {
					continue;
				}
				if ( in_array( $seg, $city_slugs, true ) ) {
					$cities_in_path[] = $seg;
					continue;
				}
				$rest_parts[] = $seg;
			}
			if ( count( $cities_in_path ) > 1 ) {
				$keep = end( $cities_in_path );
				wp_safe_redirect( alba_city_url( implode( '/', $rest_parts ), $keep ), 301 );
				exit;
			}
		}

		// Root / → default city.
		if ( is_front_page() && ! $city ) {
			$path_trim = trim( $path, '/' );
			if ( '' === $path_trim || 'index.php' === $path_trim ) {
				$def = alba_get_default_city();
				wp_safe_redirect( alba_city_url( '', $def['slug'] ), 302 );
				exit;
			}
		}
}

/**
 * Bare /{city}/ loads the front page.
 */
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() ) {
			return;
		}
		$city = $q->get( 'alba_city' );
		if ( ! $city ) {
			return;
		}
		if ( $q->get( 'pagename' ) || $q->get( 'name' ) || $q->get( 'service' ) || $q->get( 'program' ) || $q->get( 'doctor' ) || $q->get( 'page_id' ) ) {
			return;
		}
		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id ) {
			$q->set( 'page_id', $front_id );
			$q->is_page     = true;
			$q->is_singular = true;
			$q->is_home     = false;
			$q->is_archive  = false;
		}
	}
);

/**
 * Keep /{city}/… URLs — do not let redirect_canonical strip the city prefix.
 */
add_filter(
	'redirect_canonical',
	function ( $redirect_url, $requested_url ) {
		$city = get_query_var( 'alba_city' );
		if ( $city ) {
			return false;
		}
		$path = wp_parse_url( $requested_url, PHP_URL_PATH );
		$parts = array_values( array_filter( explode( '/', trim( (string) $path, '/' ) ) ) );
		if ( $parts && in_array( $parts[0], alba_get_city_slugs(), true ) ) {
			return false;
		}
		return $redirect_url;
	},
	10,
	2
);

/**
 * Prefixed permalinks when city context is active.
 */
add_filter(
	'post_type_link',
	function ( $permalink, $post ) {
		if ( is_admin() || wp_doing_ajax() ) {
			return $permalink;
		}
		$city = alba_get_current_city();
		if ( empty( $city['slug'] ) ) {
			return $permalink;
		}
		$home = trailingslashit( home_url( '/' ) );
		if ( 0 === strpos( $permalink, $home ) ) {
			$path = substr( $permalink, strlen( $home ) );
			return home_url( '/' . $city['slug'] . '/' . ltrim( $path, '/' ) );
		}
		return $permalink;
	},
	20,
	2
);

add_filter(
	'page_link',
	function ( $link, $post_id ) {
		if ( is_admin() ) {
			return $link;
		}
		$city = alba_get_current_city();
		$home = trailingslashit( home_url( '/' ) );
		if ( 0 === strpos( $link, $home ) ) {
			$path = substr( $link, strlen( $home ) );
			return home_url( '/' . $city['slug'] . '/' . ltrim( $path, '/' ) );
		}
		return $link;
	},
	20,
	2
);

/**
 * City-prefixed post (article) permalinks: /{city}/article/{post_name}/
 */
add_filter(
	'post_link',
	function ( $permalink, $post ) {
		if ( is_admin() || wp_doing_ajax() || ! ( $post instanceof WP_Post ) || 'post' !== $post->post_type ) {
			return $permalink;
		}
		$city = alba_get_current_city();
		if ( empty( $city['slug'] ) ) {
			return $permalink;
		}
		return home_url( '/' . $city['slug'] . '/article/' . $post->post_name . '/' );
	},
	20,
	2
);

add_action(
	'wp_ajax_alba_set_city',
	'alba_ajax_set_city'
);
add_action(
	'wp_ajax_nopriv_alba_set_city',
	'alba_ajax_set_city'
);

function alba_ajax_set_city() {
	check_ajax_referer( 'alba_city', 'nonce' );
	$slug = isset( $_POST['city'] ) ? sanitize_title( wp_unslash( $_POST['city'] ) ) : '';
	$city = alba_get_city_by_slug( $slug );
	if ( ! $city ) {
		wp_send_json_error( array( 'message' => 'City not found' ), 404 );
	}
	setcookie( 'alba_city', $slug, time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), false );

	$raw  = isset( $_POST['path'] ) ? wp_unslash( $_POST['path'] ) : '/';
	$path = (string) wp_parse_url( $raw, PHP_URL_PATH );
	$path = alba_request_path( $path ? $path : '/' );
	// Never rewrite admin/login into /{city}/…
	if ( preg_match( '#(^|/)(wp-admin|wp-login\.php|wp-json)(/|$)#i', $path ) ) {
		wp_send_json_success( array( 'redirect' => home_url( '/' ), 'city' => $city ) );
	}
	// Strip one or more leading city prefixes (also cleans stacked broken URLs).
	$parts     = array_values( array_filter( explode( '/', trim( $path, '/' ) ) ) );
	$city_slugs = alba_get_city_slugs();
	while ( $parts && in_array( $parts[0], $city_slugs, true ) ) {
		array_shift( $parts );
	}
	// Drop accidental home-subdir segment if it leaked in.
	$home_seg = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	while ( $parts && $home_seg && $parts[0] === $home_seg ) {
		array_shift( $parts );
		while ( $parts && in_array( $parts[0], $city_slugs, true ) ) {
			array_shift( $parts );
		}
	}
	$rest = implode( '/', $parts );
	$url  = alba_city_url( $rest, $slug );
	wp_send_json_success( array( 'redirect' => $url, 'city' => $city ) );
}
