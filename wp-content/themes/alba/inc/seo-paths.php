<?php
/**
 * Human-readable transliterated SEO paths for services/programs.
 *
 * Example: /omsk/vyvod-iz-zapoya/kapelnitsa-ot-zapoya/
 * instead of /omsk/service/zapoy/
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Primary SEO path overrides by internal post_name.
 *
 * @return array<string,string>
 */
function alba_seo_path_overrides() {
	return array(
		// Examples from the brief.
		'alcohol-home'       => 'prokapatsya-ot-alcogolya-na-domu',
		'zapoy'              => 'vyvod-iz-zapoya/vyvod-iz-zapoya-na-domu',
		'visit'              => 'narkolog-na-dom',
		'help'               => 'narkologicheskaya-pomosh/kruglosutochno',
		'detox'              => 'vyvod-iz-zapoya/vyvod-iz-zapoya-v-statsionare',
		'alcohol-hangover'   => 'vyvod-iz-zapoya/snyatie-pohmelnogo-sindroma',
		'sober'              => 'vyvod-iz-zapoya/medicinskiy-vytrezvitel',
		'ambulance'          => 'vyvod-iz-zapoya/pomosh-narkologa',
		'toxicologist'       => 'kapelnitsa-pri-otravlenii-alkogolem',
		// Zapoy drip sibling.
		'alcohol'            => 'lechenie-alkogolizma',
		// Common groups.
		'code'               => 'kodirovanie',
		'code-home'          => 'kodirovanie/kodirovanie-na-domu',
		'code-torpedo'       => 'kodirovanie/torpedo',
		'code-esperal'       => 'kodirovanie/esperal',
		'code-double'        => 'kodirovanie/dvoynoy-blok',
		'code-dovzhenko'     => 'kodirovanie/metod-dovzhenko',
		'code-vivitrol'      => 'kodirovanie/vivitrol',
		'code-implant'       => 'kodirovanie/vshivanie-ampuly',
		'code-hypnosis'      => 'kodirovanie/gipnoz',
		'code-shot'          => 'kodirovanie/ukol',
		'code-needle'        => 'kodirovanie/igloukalyvanie',
		'code-aquilong'      => 'kodirovanie/akvilong',
		'code-naltrexone'    => 'kodirovanie/naltrekson',
		'code-disulfiram'    => 'kodirovanie/disulfiram',
		'code-algominal'     => 'kodirovanie/algominal',
		'code-sit'           => 'kodirovanie/sit',
		'decode'             => 'kodirovanie/raskodirovanie',
		'drugs'              => 'lechenie-narkomanii',
		'withdrawal'         => 'snyatie-lomki',
		'ubod'               => 'ubod',
		'rehab'              => 'reabilitatsiya',
		'rehab-alcohol'      => 'reabilitatsiya/alkogolizm',
		'rehab-12'           => 'reabilitatsiya/12-shagov',
		'rehab-daytop'       => 'reabilitatsiya/day-top',
		'psychiatry'         => 'psihiatriya',
		'gambling'           => 'lechenie-igrovoy-zavisimosti',
		'betting'            => 'lechenie-zavisimosti-ot-stavok',
		'consult'            => 'konsultatsiya-narkologa',
		'check'              => 'diagnostika',
		'family'             => 'semeynaya-programma',
		'drugtest'           => 'test-na-narkotiki',
		// Programs (courses).
		'zapoy-1day'         => 'vyvod-iz-zapoya/kurs-1-den',
		'zapoy-2days'        => 'vyvod-iz-zapoya/kurs-2-dnya',
		'zapoy-3days'        => 'vyvod-iz-zapoya/kurs-3-dnya',
		'zapoy-5days'        => 'vyvod-iz-zapoya/kurs-5-dney',
		'zapoy-7days'        => 'vyvod-iz-zapoya/kurs-7-dney',
	);
}

/**
 * Extra SEO aliases → primary SEO path (301).
 *
 * @return array<string,string>
 */
function alba_seo_path_aliases() {
	return array(
		'vyvod-iz-zapoya-na-domu'                         => 'vyvod-iz-zapoya/vyvod-iz-zapoya-na-domu',
		'vyvod-iz-zapoya/kapelnitsa-ot-zapoya'            => 'vyvod-iz-zapoya/snyatie-pohmelnogo-sindroma',
		'narkology/narkologicheskaya-pomoshh/na-domu'     => 'narkolog-na-dom',
		'narkologicheskaya-pomoshh/na-domu'               => 'narkolog-na-dom',
		'vyvod-iz-zapoya/narkolog-na-dom'                 => 'narkolog-na-dom',
		'service/zapoy'                                   => 'vyvod-iz-zapoya/vyvod-iz-zapoya-na-domu',
		'service/visit'                                   => 'narkolog-na-dom',
		'service/help'                                    => 'narkologicheskaya-pomosh/kruglosutochno',
		'service/detox'                                   => 'vyvod-iz-zapoya/vyvod-iz-zapoya-v-statsionare',
		'service/alcohol-hangover'                        => 'vyvod-iz-zapoya/snyatie-pohmelnogo-sindroma',
		'service/sober'                                   => 'vyvod-iz-zapoya/medicinskiy-vytrezvitel',
		'service/alcohol-home'                            => 'prokapatsya-ot-alcogolya-na-domu',
		'service/ambulance'                               => 'vyvod-iz-zapoya/pomosh-narkologa',
		'service/toxicologist'                            => 'kapelnitsa-pri-otravlenii-alkogolem',
	);
}

/**
 * Transliterate Russian text to a URL slug segment.
 *
 * @param string $text Text.
 * @return string
 */
function alba_translit_slug( $text ) {
	$map = array(
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e',
		'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
		'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
		'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
		'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
		'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'e',
		'Ж' => 'zh', 'З' => 'z', 'И' => 'i', 'Й' => 'y', 'К' => 'k', 'Л' => 'l', 'М' => 'm',
		'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
		'Ф' => 'f', 'Х' => 'h', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
		'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
	);
	$text = strtr( (string) $text, $map );
	$text = strtolower( $text );
	$text = preg_replace( '/[^a-z0-9]+/u', '-', $text );
	$text = trim( (string) $text, '-' );
	$text = preg_replace( '/-+/', '-', $text );
	return $text ? $text : 'usluga';
}

/**
 * Build default SEO path from post title / slug.
 *
 * @param WP_Post|int $post Post.
 * @return string
 */
function alba_seo_path_from_post( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	$overrides = alba_seo_path_overrides();
	if ( isset( $overrides[ $post->post_name ] ) ) {
		return trim( $overrides[ $post->post_name ], '/' );
	}

	$title = get_the_title( $post );
	$path  = alba_translit_slug( $title );

	// Soft grouping by prefix.
	$name = $post->post_name;
	if ( 0 === strpos( $name, 'code-' ) || 'code' === $name || 'decode' === $name ) {
		$leaf = alba_translit_slug( preg_replace( '/^Кодирование\s*/ui', '', $title ) );
		$path = 'kodirovanie/' . ( $leaf ? $leaf : $path );
	} elseif ( 0 === strpos( $name, 'drugs-' ) || 'drugs' === $name ) {
		$leaf = alba_translit_slug( preg_replace( '/^Лечение\s*(зависимости\s*от\s*)?/ui', '', $title ) );
		$path = 'lechenie-narkomanii/' . ( $leaf ? $leaf : $path );
	} elseif ( 0 === strpos( $name, 'alcohol-' ) || 'alcohol' === $name ) {
		$leaf = alba_translit_slug( preg_replace( '/^Лечение\s*/ui', '', $title ) );
		$path = 'lechenie-alkogolizma/' . ( $leaf ? $leaf : $path );
	} elseif ( 0 === strpos( $name, 'rehab-' ) || 'rehab' === $name ) {
		$leaf = alba_translit_slug( preg_replace( '/^Реабилитация\s*/ui', '', $title ) );
		$path = 'reabilitatsiya/' . ( $leaf ? $leaf : $path );
	} elseif ( 0 === strpos( $name, 'psy-' ) || 'psychiatry' === $name ) {
		$leaf = alba_translit_slug( preg_replace( '/^Лечение\s*/ui', '', $title ) );
		$path = 'psihiatriya/' . ( $leaf ? $leaf : $path );
	} elseif ( 0 === strpos( $name, 'zapoy-' ) ) {
		$path = 'vyvod-iz-zapoya/' . alba_translit_slug( $title );
	}

	$path = trim( preg_replace( '#/+#', '/', $path ), '/' );
	return $path ? $path : $name;
}

/**
 * Get stored or computed SEO path for a service/program.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function alba_get_seo_path( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return '';
	}
	$stored = get_post_meta( $post_id, 'alba_seo_path', true );
	if ( is_string( $stored ) && $stored !== '' ) {
		return trim( $stored, '/' );
	}
	$path = alba_seo_path_from_post( $post_id );
	if ( $path ) {
		update_post_meta( $post_id, 'alba_seo_path', $path );
	}
	return $path;
}

/**
 * Pretty city URL for a service/program post.
 *
 * @param int    $post_id   Post ID.
 * @param string $city_slug City.
 * @return string
 */
function alba_service_pretty_url( $post_id, $city_slug = '' ) {
	$post_id   = (int) $post_id;
	$city_slug = $city_slug ? sanitize_title( $city_slug ) : alba_get_current_city()['slug'];
	$path      = alba_get_seo_path( $post_id );
	if ( ! $path ) {
		$post = get_post( $post_id );
		$path = $post ? $post->post_name : '';
	}
	return trailingslashit( home_url( '/' . $city_slug . '/' . $path ) );
}

/**
 * Reserved first segments that are not SEO services.
 *
 * @return string[]
 */
function alba_seo_reserved_roots() {
	$pages = array( 'about', 'prices', 'contacts', 'programs', 'articles', 'doctors', 'gallery', 'reviews', 'licenses', 'methods', 'links', 'sitemap', 'privacy', 'consent', 'terms', 'legal', 'test', 'home' );
	$sys   = array( 'service', 'program', 'programs', 'doctor', 'article', 'wp-admin', 'wp-json', 'wp-content', 'wp-includes', 'wp-login.php', 'feed', 'comments', 'page' );
	return array_values( array_unique( array_merge( $pages, $sys, alba_get_city_slugs() ) ) );
}

/**
 * Find service/program by SEO path.
 *
 * @param string $path Path without city.
 * @return WP_Post|null
 */
function alba_find_by_seo_path( $path ) {
	$path = trim( (string) $path, '/' );
	if ( '' === $path ) {
		return null;
	}

	$q = new WP_Query(
		array(
			'post_type'              => array( 'service', 'program' ),
			'post_status'            => 'publish',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => 'alba_seo_path',
			'meta_value'             => $path,
		)
	);
	if ( $q->have_posts() ) {
		return $q->posts[0];
	}

	// Fallback: compute from overrides / titles without meta yet.
	$overrides = alba_seo_path_overrides();
	$slug      = array_search( $path, $overrides, true );
	if ( false !== $slug ) {
		$post = get_page_by_path( $slug, OBJECT, array( 'service', 'program' ) );
		if ( $post ) {
			update_post_meta( $post->ID, 'alba_seo_path', $path );
			return $post;
		}
	}

	$all = get_posts(
		array(
			'post_type'      => array( 'service', 'program' ),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $all as $id ) {
		$computed = alba_seo_path_from_post( $id );
		if ( $computed === $path ) {
			update_post_meta( $id, 'alba_seo_path', $path );
			return get_post( $id );
		}
	}
	return null;
}

/**
 * Resolve alias path to canonical SEO path.
 *
 * @param string $path Path.
 * @return string Empty if not alias.
 */
function alba_seo_resolve_alias( $path ) {
	$path    = trim( (string) $path, '/' );
	$aliases = alba_seo_path_aliases();
	if ( isset( $aliases[ $path ] ) ) {
		return trim( $aliases[ $path ], '/' );
	}
	// Old /service/{slug} and /program/{slug}.
	if ( preg_match( '#^(service|program)/([^/]+)$#', $path, $m ) ) {
		$post = get_page_by_path( $m[2], OBJECT, array( 'service', 'program' ) );
		if ( $post ) {
			return alba_get_seo_path( $post->ID );
		}
	}
	return '';
}

/**
 * Seed alba_seo_path meta for all services/programs (unique paths).
 *
 * @param bool $force Recompute.
 * @return array{updated:int,skipped:int}
 */
function alba_seed_seo_paths( $force = false ) {
	$option = 'alba_seo_paths_seeded_v2';
	if ( ! $force && get_option( $option ) ) {
		return array( 'updated' => 0, 'skipped' => 0 );
	}

	$posts = get_posts(
		array(
			'post_type'      => array( 'service', 'program' ),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		)
	);

	$used    = array();
	$updated = 0;
	$skipped = 0;

	foreach ( $posts as $post ) {
		$path = alba_seo_path_from_post( $post );
		$base = $path;
		$n    = 2;
		while ( isset( $used[ $path ] ) ) {
			$path = $base . '-' . $n;
			$n++;
		}
		$used[ $path ] = $post->ID;
		$prev          = get_post_meta( $post->ID, 'alba_seo_path', true );
		if ( ! $force && $prev === $path ) {
			$skipped++;
			continue;
		}
		update_post_meta( $post->ID, 'alba_seo_path', $path );
		$updated++;
	}

	update_option( $option, time(), false );
	return array( 'updated' => $updated, 'skipped' => $skipped );
}

add_action(
	'init',
	static function () {
		alba_seed_seo_paths( false );
	},
	25
);

add_action(
	'save_post_service',
	static function ( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, 'alba_seo_path', alba_seo_path_from_post( $post_id ) );
	}
);
add_action(
	'save_post_program',
	static function ( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		update_post_meta( $post_id, 'alba_seo_path', alba_seo_path_from_post( $post_id ) );
	}
);
