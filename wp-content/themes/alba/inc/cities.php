<?php
/**
 * Cities / regionality helpers.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default cities (seed). Overridden by ACF options / alba_cities option.
 */
function alba_default_cities() {
	return array(
		array(
			'slug'    => 'omsk',
			'name'    => 'Омск',
			'prep'    => 'в Омске',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Омск, ул. Ленина, 12',
			'extra'   => 'Отдельный вход. Трансфер по городу и области.',
			'license' => 'ЛО-55-01-002891',
			'map'     => 'https://yandex.ru/map-widget/v1/?ll=73.368227%2C54.989342&z=16',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 1,
		),
		array(
			'slug'    => 'nsk',
			'name'    => 'Новосибирск',
			'prep'    => 'в Новосибирске',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Новосибирск, Красный проспект, 52',
			'extra'   => 'Отдельный вход, закрытая парковка.',
			'license' => 'ЛО-54-01-005412',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'tomsk',
			'name'    => 'Томск',
			'prep'    => 'в Томске',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Томск, пр. Ленина, 54',
			'extra'   => 'Тихий двор, трансфер по городу.',
			'license' => 'ЛО-70-01-001904',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'tyumen',
			'name'    => 'Тюмень',
			'prep'    => 'в Тюмени',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Тюмень, ул. Республики, 83',
			'extra'   => 'Центр, анонимный подъезд.',
			'license' => 'ЛО-72-01-003215',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'barnaul',
			'name'    => 'Барнаул',
			'prep'    => 'в Барнауле',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Барнаул, пр. Ленина, 24',
			'extra'   => 'Отдельный вход со двора.',
			'license' => 'ЛО-22-01-004118',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'kemerovo',
			'name'    => 'Кемерово',
			'prep'    => 'в Кемерове',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Кемерово, пр. Советский, 54',
			'extra'   => 'Стационар 24/7, трансфер.',
			'license' => 'ЛО-42-01-002671',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'nkz',
			'name'    => 'Новокузнецк',
			'prep'    => 'в Новокузнецке',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Новокузнецк, пр. Металлургов, 19',
			'extra'   => 'Закрытая территория.',
			'license' => 'ЛО-42-01-002688',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'krsk',
			'name'    => 'Красноярск',
			'prep'    => 'в Красноярске',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Красноярск, ул. Карла Маркса, 78',
			'extra'   => 'Центр, анонимный въезд.',
			'license' => 'ЛО-24-01-003901',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'surgut',
			'name'    => 'Сургут',
			'prep'    => 'в Сургуте',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Сургут, ул. Энтузиастов, 8',
			'extra'   => 'Круглосуточный приём.',
			'license' => 'ЛО-86-01-001744',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'moscow',
			'name'    => 'Москва',
			'prep'    => 'в Москве',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Москва, Пресненская наб., 10с2',
			'extra'   => 'Внутренний двор, закрытая парковка.',
			'license' => 'ЛО-77-01-021458',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
		array(
			'slug'    => 'spb',
			'name'    => 'Санкт-Петербург',
			'prep'    => 'в Санкт-Петербурге',
			'phone'   => '8 800 100-12-12',
			'tel'     => '+78001001212',
			'address' => 'Санкт-Петербург, Невский пр., 88',
			'extra'   => 'Отдельный вход со двора.',
			'license' => 'ЛО-78-01-011203',
			'map'     => '',
			'tg'      => 'https://t.me/+78001001212',
			'max'     => 'https://max.ru/',
			'default' => 0,
		),
	);
}

function alba_get_cities() {
	$saved = get_option( 'alba_cities', array() );
	if ( is_array( $saved ) && ! empty( $saved ) ) {
		return $saved;
	}
	if ( function_exists( 'get_field' ) ) {
		$rows = get_field( 'alba_cities', 'option' );
		if ( is_array( $rows ) && $rows ) {
			$out = array();
			foreach ( $rows as $row ) {
				$out[] = array(
					'slug'    => sanitize_title( $row['slug'] ?? '' ),
					'name'    => $row['name'] ?? '',
					'prep'    => $row['prep'] ?? '',
					'phone'   => $row['phone'] ?? '',
					'tel'     => $row['tel'] ?? '',
					'address' => $row['address'] ?? '',
					'extra'   => $row['extra'] ?? '',
					'license' => $row['license'] ?? '',
					'map'     => $row['map'] ?? '',
					'tg'      => $row['tg'] ?? '',
					'max'     => $row['max'] ?? 'https://max.ru/',
					'default' => ! empty( $row['default'] ) ? 1 : 0,
				);
			}
			if ( $out ) {
				return $out;
			}
		}
	}
	return alba_default_cities();
}

function alba_get_cities_public() {
	return array_map(
		function ( $c ) {
			return array(
				'id'      => $c['slug'],
				'name'    => $c['name'],
				'prep'    => $c['prep'],
				'phone'   => $c['phone'],
				'tel'     => $c['tel'],
				'address' => $c['address'],
				'extra'   => $c['extra'],
				'license' => $c['license'],
				'map'     => $c['map'],
				'tg'      => $c['tg'],
				'max'     => $c['max'],
			);
		},
		alba_get_cities()
	);
}

function alba_get_city_slugs() {
	return wp_list_pluck( alba_get_cities(), 'slug' );
}

function alba_get_default_city() {
	foreach ( alba_get_cities() as $c ) {
		if ( ! empty( $c['default'] ) ) {
			return $c;
		}
	}
	$all = alba_get_cities();
	return $all[0];
}

function alba_get_city_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	foreach ( alba_get_cities() as $c ) {
		if ( $c['slug'] === $slug ) {
			return $c;
		}
	}
	return null;
}

/**
 * Current city from query var / cookie / default.
 */
function alba_get_current_city() {
	static $current = null;
	if ( null !== $current ) {
		return $current;
	}
	$slug = get_query_var( 'alba_city' );
	if ( ! $slug && isset( $_COOKIE['alba_city'] ) ) {
		$slug = sanitize_title( wp_unslash( $_COOKIE['alba_city'] ) );
	}
	$city = $slug ? alba_get_city_by_slug( $slug ) : null;
	$current = $city ? $city : alba_get_default_city();
	return $current;
}

/**
 * Field with optional city override from post meta JSON or ACF repeater.
 *
 * @param string $key Field key.
 * @param int    $post_id Post ID.
 * @param mixed  $fallback Fallback.
 */
function alba_field( $key, $post_id = 0, $fallback = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$city    = alba_get_current_city();
	$base    = function_exists( 'get_field' ) ? get_field( $key, $post_id ) : get_post_meta( $post_id, $key, true );
	if ( '' === $base || null === $base ) {
		$base = $fallback;
	}

	$overrides = function_exists( 'get_field' ) ? get_field( 'city_overrides', $post_id ) : get_post_meta( $post_id, 'city_overrides', true );
	if ( is_array( $overrides ) ) {
		foreach ( $overrides as $row ) {
			$row_slug = sanitize_title( $row['city_slug'] ?? ( $row['slug'] ?? '' ) );
			if ( ! $row_slug || $row_slug !== $city['slug'] ) {
				continue;
			}
			// Prefer ov_* names (no collision with top-level fields).
			$ov_key = 'ov_' . $key;
			if ( isset( $row[ $ov_key ] ) && $row[ $ov_key ] !== '' && $row[ $ov_key ] !== null ) {
				return $row[ $ov_key ];
			}
			if ( isset( $row[ $key ] ) && $row[ $key ] !== '' && $row[ $key ] !== null ) {
				return $row[ $key ];
			}
		}
	}
	return $base;
}

function alba_city_url( $path = '', $city_slug = '' ) {
	$city_slug = $city_slug ? sanitize_title( $city_slug ) : alba_get_current_city()['slug'];
	$path      = ltrim( (string) $path, '/' );
	$path      = preg_replace( '/\.(html?)$/i', '', $path );

	// Legacy stems → correct CPT bucket (program vs service).
	if ( preg_match( '/^(service|program)-(.+)$/i', $path, $m ) ) {
		$stem  = $m[2];
		$post  = get_page_by_path( $stem, OBJECT, array( 'service', 'program' ) );
		$bucket = $post ? $post->post_type : ( preg_match( '/^zapoy-\d/i', $stem ) ? 'program' : strtolower( $m[1] ) );
		return trailingslashit( home_url( '/' . $city_slug . '/' . $bucket . '/' . $stem ) );
	}
	if ( preg_match( '/^doctor-(.+)$/i', $path, $m ) ) {
		$path = 'doctor/' . $m[1];
	} elseif ( preg_match( '/^article-(.+)$/i', $path ) ) {
		$path = 'article/' . $path;
	}

	$base = trailingslashit( home_url( '/' . $city_slug ) );
	if ( ! $path ) {
		return untrailingslashit( $base ) . '/';
	}
	// Keep trailing slash for CPT-like paths.
	if ( preg_match( '#^(service|program|doctor|article)/#', $path ) ) {
		return $base . trailingslashit( $path );
	}
	return $base . $path;
}
