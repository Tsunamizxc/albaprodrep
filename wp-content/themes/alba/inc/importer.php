<?php
/**
 * Import legacy HTML into CPT / pages.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function alba_import_legacy_html() {
	$dir = trailingslashit( ABSPATH ) . 'legacy-html';
	if ( ! is_dir( $dir ) ) {
		return array( 'error' => 'legacy-html missing' );
	}

	$stats = array(
		'pages'    => 0,
		'services' => 0,
		'programs' => 0,
		'doctors'  => 0,
		'posts'    => 0,
		'skipped'  => 0,
	);

	$pages_map = array(
		'index.html'     => array( 'title' => 'Главная', 'front' => true ),
		'about.html'     => array( 'title' => 'О нас' ),
		'contacts.html'  => array( 'title' => 'Контакты' ),
		'prices.html'    => array( 'title' => 'Цены' ),
		'programs.html'  => array( 'title' => 'Программы', 'template' => '' ),
		'doctors.html'   => array( 'title' => 'Врачи' ),
		'articles.html'  => array( 'title' => 'Статьи' ),
		'gallery.html'   => array( 'title' => 'Галерея' ),
		'licenses.html'  => array( 'title' => 'Лицензии' ),
		'reviews.html'   => array( 'title' => 'Отзывы' ),
		'methods.html'   => array( 'title' => 'Методы' ),
		'privacy.html'   => array( 'title' => 'Политика ПДн' ),
		'consent.html'   => array( 'title' => 'Согласие' ),
		'terms.html'     => array( 'title' => 'Условия' ),
		'legal.html'     => array( 'title' => 'Реквизиты' ),
		'links.html'     => array( 'title' => 'Полезные ссылки' ),
		'sitemap.html'   => array( 'title' => 'Карта сайта' ),
	);

	foreach ( $pages_map as $file => $meta ) {
		$path = $dir . '/' . $file;
		if ( ! file_exists( $path ) ) {
			continue;
		}
		$html  = file_get_contents( $path );
		$slug  = basename( $file, '.html' );
		if ( 'index' === $slug ) {
			$slug = 'home';
		}
		$parsed = alba_parse_legacy_page( $html );
		$id     = alba_upsert_post(
			array(
				'post_type'    => 'page',
				'post_name'    => $slug === 'home' ? 'home' : $slug,
				'post_title'   => $meta['title'],
				'post_content' => $parsed['content'],
				'post_excerpt' => $parsed['description'],
				'post_status'  => 'publish',
			)
		);
		if ( $id && ! empty( $meta['front'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
		if ( $id ) {
			$stats['pages']++;
			update_post_meta( $id, '_alba_legacy_file', $file );
			if ( $parsed['lead'] ) {
				update_post_meta( $id, 'lead', $parsed['lead'] );
			}
		}
	}

	foreach ( glob( $dir . '/service-*.html' ) as $path ) {
		$file = basename( $path );
		$html = file_get_contents( $path );
		$parsed = alba_parse_legacy_page( $html );
		$slug = basename( $file, '.html' );
		$is_program = (bool) preg_match( '/zapoy-\d|program/i', $slug );
		$type = $is_program ? 'program' : 'service';
		$id = alba_upsert_post(
			array(
				'post_type'    => $type,
				'post_name'    => preg_replace( '/^(service|program)-/', '', $slug ),
				'post_title'   => '',
				'post_content' => '',
				'post_excerpt' => $parsed['description'],
				'post_status'  => 'publish',
			)
		);
		if ( ! $id ) {
			$stats['skipped']++;
			continue;
		}
		// Prefer H1-based title (keeps "курс 2 дня" etc.).
		if ( function_exists( 'alba_parse_service_to_acf' ) ) {
			$data  = alba_parse_service_to_acf( $html );
			$title = function_exists( 'alba_service_admin_title' ) ? alba_service_admin_title( $data ) : '';
			if ( ! $title ) {
				$title = $parsed['title'] ?: $slug;
			}
			wp_update_post(
				array(
					'ID'         => $id,
					'post_title' => $title,
				)
			);
		} else {
			wp_update_post(
				array(
					'ID'         => $id,
					'post_title' => $parsed['title'] ?: $slug,
				)
			);
		}
		$stats[ $type === 'program' ? 'programs' : 'services' ]++;
		// Structured ACF only — no legacy HTML meta / post_content.
		delete_post_meta( $id, '_alba_legacy_file' );
		if ( function_exists( 'alba_parse_service_to_acf' ) && function_exists( 'alba_update_field_key' ) ) {
			$data = alba_parse_service_to_acf( $html );
			alba_update_field_key( 'field_svc_hero', $data['hero_title'], $id );
			alba_update_field_key( 'field_svc_lead', $data['lead'], $id );
			alba_update_field_key( 'field_svc_cover_url', $data['cover_url'], $id );
			alba_update_field_key( 'field_svc_intro', $data['intro'], $id );
			alba_update_field_key( 'field_svc_price', $data['price'], $id );
			alba_update_field_key( 'field_svc_price_note', $data['price_note'], $id );
			alba_update_field_key( 'field_svc_includes', $data['includes'], $id );
			alba_update_field_key( 'field_svc_doctor_name', $data['help_doctor_name'], $id );
			alba_update_field_key( 'field_svc_doctor_role', $data['help_doctor_role'], $id );
			alba_update_field_key( 'field_svc_doctor_photo', $data['help_doctor_photo'], $id );
			alba_update_field_key( 'field_svc_rel_h', $data['related_heading'], $id );
			alba_update_field_key( 'field_svc_rel_l', $data['related_lead'], $id );
			alba_update_field_key( 'field_svc_related', $data['related'], $id );
			alba_update_field_key( 'field_svc_funnel_h', $data['funnel_title'], $id );
			alba_update_field_key( 'field_svc_funnel_t', $data['funnel_text'], $id );
			alba_update_field_key( 'field_svc_funnel_c', $data['funnel_chips'], $id );
			alba_update_field_key( 'field_svc_benefits', $data['benefits'], $id );
			alba_update_field_key( 'field_svc_body', $data['body_blocks'], $id );
			alba_update_field_key( 'field_svc_faq', $data['faq'], $id );
			alba_update_field_key( 'field_svc_cta_h', $data['cta_title'], $id );
			alba_update_field_key( 'field_svc_cta_t', $data['cta_text'], $id );
			alba_update_field_key( 'field_svc_schedule_h', $data['schedule_heading'], $id );
			alba_update_field_key( 'field_svc_schedule_l', $data['schedule_lead'], $id );
			alba_update_field_key( 'field_svc_schedule', $data['schedule_days'], $id );
			alba_update_field_key( 'field_svc_schedule_note', $data['schedule_note'], $id );
		} elseif ( function_exists( 'alba_parse_service_to_acf' ) && function_exists( 'update_field' ) ) {
			$data = alba_parse_service_to_acf( $html );
			update_field( 'field_svc_hero', $data['hero_title'], $id );
			update_field( 'field_svc_lead', $data['lead'], $id );
			update_field( 'field_svc_price', $data['price'], $id );
			update_field( 'field_svc_includes', $data['includes'], $id );
			update_field( 'field_svc_body', $data['body_blocks'], $id );
			update_field( 'field_svc_faq', $data['faq'], $id );
		} else {
			if ( $parsed['lead'] && function_exists( 'update_field' ) ) {
				update_field( 'field_svc_lead', $parsed['lead'], $id );
			}
			if ( $parsed['price'] && function_exists( 'update_field' ) ) {
				update_field( 'field_svc_price', $parsed['price'], $id );
			}
			if ( $parsed['includes'] && function_exists( 'update_field' ) ) {
				$rows = array();
				foreach ( $parsed['includes'] as $item ) {
					$rows[] = array( 'item' => $item );
				}
				update_field( 'field_svc_includes', $rows, $id );
			}
			if ( $parsed['faq'] && function_exists( 'update_field' ) ) {
				update_field( 'field_svc_faq', $parsed['faq'], $id );
			}
			if ( $parsed['hero_title'] && function_exists( 'update_field' ) ) {
				$ht = preg_replace( '/<br\s*\/?>/i', '|', $parsed['hero_title'] );
				update_field( 'field_svc_hero', trim( wp_strip_all_tags( $ht ) ), $id );
			}
		}
	}

	foreach ( glob( $dir . '/doctor-*.html' ) as $path ) {
		$html = file_get_contents( $path );
		$parsed = alba_parse_legacy_page( $html );
		$slug = basename( $path, '.html' );
		$slug = preg_replace( '/^doctor-/', '', $slug );
		$id = alba_upsert_post(
			array(
				'post_type'    => 'doctor',
				'post_name'    => $slug,
				'post_title'   => $parsed['title'] ?: $slug,
				'post_content' => $parsed['content'],
				'post_excerpt' => $parsed['description'],
				'post_status'  => 'publish',
			)
		);
		if ( $id ) {
			$stats['doctors']++;
			update_post_meta( $id, '_alba_legacy_file', basename( $path ) );
		}
	}

	foreach ( glob( $dir . '/article-*.html' ) as $path ) {
		$html = file_get_contents( $path );
		$parsed = alba_parse_legacy_page( $html );
		$slug = basename( $path, '.html' );
		$id = alba_upsert_post(
			array(
				'post_type'    => 'post',
				'post_name'    => $slug,
				'post_title'   => $parsed['title'] ?: $slug,
				'post_content' => $parsed['content'],
				'post_excerpt' => $parsed['description'],
				'post_status'  => 'publish',
			)
		);
		if ( $id ) {
			$stats['posts']++;
			update_post_meta( $id, '_alba_legacy_file', basename( $path ) );
		}
	}

	flush_rewrite_rules( false );
	return $stats;
}

function alba_upsert_post( $args ) {
	$existing = get_page_by_path( $args['post_name'], OBJECT, $args['post_type'] );
	if ( $existing ) {
		$args['ID'] = $existing->ID;
		return wp_update_post( $args, true );
	}
	return wp_insert_post( $args, true );
}

function alba_parse_legacy_page( $html ) {
	$out = array(
		'title'       => '',
		'description' => '',
		'hero_title'  => '',
		'lead'        => '',
		'content'     => '',
		'price'       => '',
		'includes'    => array(),
		'faq'         => array(),
	);
	if ( preg_match( '/<title>(.*?)<\/title>/is', $html, $m ) ) {
		$out['title'] = trim( html_entity_decode( wp_strip_all_tags( $m[1] ) ) );
		// Strip only brand suffix: "… — Альба" / "… | Альба", keep course length etc.
		$out['title'] = preg_replace( '/\s*[—\-|]\s*Альба\s*$/u', '', $out['title'] );
		$out['title'] = trim( $out['title'] );
	}
	if ( preg_match( '/name="description"\s+content="([^"]*)"/i', $html, $m ) ) {
		$out['description'] = html_entity_decode( $m[1] );
	}
	if ( preg_match( '/<h1[^>]*>([\s\S]*?)<\/h1>/i', $html, $m ) ) {
		$out['hero_title'] = trim( $m[1] );
	}
	if ( preg_match( '/<section class="page-hero[\s\S]*?<p>([\s\S]*?)<\/p>/i', $html, $m ) ) {
		$out['lead'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/<aside class="svc-side"[\s\S]*?<b>([\s\S]*?)<\/b>/i', $html, $m ) ) {
		$out['price'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/<h2>\s*Что входит\s*<\/h2>\s*<ul>([\s\S]*?)<\/ul>/i', $html, $m ) ) {
		if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $m[1], $lis ) ) {
			foreach ( $lis[1] as $li ) {
				$out['includes'][] = trim( wp_strip_all_tags( $li ) );
			}
		}
	}
	if ( preg_match( '/<div class="svc-article">([\s\S]*?)<\/div>\s*<aside/i', $html, $m ) ) {
		$out['content'] = trim( $m[1] );
	} elseif ( preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
		// Keep layout markup for pages; front/page templates can also fall back to legacy-html.
		$out['content'] = trim( $m[1] );
	}
	if ( preg_match_all( '/<article class="acc__item[^"]*">\s*<button class="acc__btn"[^>]*>([\s\S]*?)<i>/i', $html, $qs ) ) {
		if ( preg_match_all( '/<div class="acc__panel"><div><p>([\s\S]*?)<\/p>/i', $html, $as ) ) {
			foreach ( $qs[1] as $i => $q ) {
				$out['faq'][] = array(
					'q' => trim( wp_strip_all_tags( $q ) ),
					'a' => isset( $as[1][ $i ] ) ? trim( wp_strip_all_tags( $as[1][ $i ] ) ) : '',
				);
			}
		}
	}
	return $out;
}
