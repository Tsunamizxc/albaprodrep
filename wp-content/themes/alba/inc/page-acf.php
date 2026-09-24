<?php
/**
 * Page ACF extras: test page fields + seed into page_blocks (no HTML in admin).
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'    => 'group_alba_page_test',
				'title'  => 'Страница теста',
				'fields' => array(
					array( 'key' => 'field_test_title', 'label' => 'H1', 'name' => 'test_hero_title', 'type' => 'text', 'default_value' => 'Пройдите тест‑бриф|для врача', 'instructions' => 'Перенос: |' ),
					array( 'key' => 'field_test_lead', 'label' => 'Лид', 'name' => 'test_hero_lead', 'type' => 'textarea', 'rows' => 3 ),
					array(
						'key'          => 'field_test_badges',
						'label'        => 'Бейджи',
						'name'         => 'test_badges',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Бейдж',
						'sub_fields'   => array(
							array( 'key' => 'field_test_badge_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
						),
					),
					array( 'key' => 'field_test_side_title', 'label' => 'Сайдбар — заголовок', 'name' => 'test_side_title', 'type' => 'text', 'default_value' => 'Обсудить с врачом' ),
					array( 'key' => 'field_test_side_text', 'label' => 'Сайдбар — текст', 'name' => 'test_side_text', 'type' => 'textarea', 'rows' => 2 ),
					array( 'key' => 'field_test_cta_title', 'label' => 'CTA — заголовок', 'name' => 'test_cta_title', 'type' => 'text', 'default_value' => 'Нужна помощь без теста?' ),
					array( 'key' => 'field_test_cta_text', 'label' => 'CTA — текст', 'name' => 'test_cta_text', 'type' => 'textarea', 'rows' => 2 ),
				),
				'location' => array(
					array(
						array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-test.php' ),
					),
				),
			)
		);
	},
	25
);

/**
 * Hide classic content box on pages — everything via ACF blocks.
 */
add_action(
	'admin_init',
	static function () {
		remove_post_type_support( 'page', 'editor' );
	}
);

/**
 * Seed ACF page_blocks from legacy-html (structured fields only).
 *
 * @param bool $force Overwrite existing blocks.
 * @return array Stats.
 */
function alba_seed_pages_acf( $force = false ) {
	if ( ! function_exists( 'update_field' ) ) {
		return array( 'error' => 'ACF missing' );
	}

	$stats = array( 'updated' => 0, 'skipped' => 0 );

	$map = array(
		'home'     => 'index.html',
		'about'    => 'about.html',
		'contacts' => 'contacts.html',
		'prices'   => 'prices.html',
		'programs' => 'programs.html',
		'doctors'  => 'doctors.html',
		'articles' => 'articles.html',
		'gallery'  => 'gallery.html',
		'licenses' => 'licenses.html',
		'reviews'  => 'reviews.html',
		'methods'  => 'methods.html',
		'privacy'  => 'privacy.html',
		'consent'  => 'consent.html',
		'terms'    => 'terms.html',
		'legal'    => 'legal.html',
		'links'    => 'links.html',
		'sitemap'  => 'sitemap.html',
		'test'     => 'test.html',
	);

	foreach ( $map as $slug => $file ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			$stats['skipped']++;
			continue;
		}
		$id = (int) $page->ID;

		$has_blocks = get_field( 'page_blocks', $id );
		if ( ! $force && is_array( $has_blocks ) && count( $has_blocks ) > 0 ) {
			$stats['skipped']++;
			continue;
		}
		if ( ! $force && 'test' === $slug && get_field( 'test_hero_title', $id ) ) {
			$stats['skipped']++;
			continue;
		}

		// Clear HTML leftovers.
		wp_update_post(
			array(
				'ID'           => $id,
				'post_content' => '',
			)
		);
		delete_field( 'page_body', $id );
		delete_field( 'home_main_html', $id );
		delete_field( 'page_mode', $id );

		// Premium hub pages: curated structured layouts (not fragile HTML flatten).
		if ( in_array( $slug, array( 'about', 'links', 'licenses', 'reviews', 'methods', 'sitemap', 'gallery', 'articles' ), true ) ) {
			if ( function_exists( 'alba_seed_hub_page' ) && alba_seed_hub_page( $id, $slug ) ) {
				$stats['updated']++;
				continue;
			}
		}

		// Doctors page is assembled by alba_seed_doctors_acf() (CPT grid).
		if ( 'doctors' === $slug ) {
			if ( function_exists( 'alba_seed_doctors_acf' ) ) {
				alba_seed_doctors_acf( true );
				$stats['updated']++;
			} else {
				$stats['skipped']++;
			}
			continue;
		}

		if ( 'home' === $slug || (int) get_option( 'page_on_front' ) === $id ) {
			$mods = array( 'hero', 'dirs', 'calc', 'test_strip', 'promos', 'offers', 'trust', 'formats', 'steps', 'station', 'ward', 'rooms', 'licenses', 'people', 'funnel', 'guarantee', 'reviews', 'price', 'essay', 'seo_funnel', 'faq', 'cta' );
			$blocks = array();
			foreach ( $mods as $mod ) {
				$blocks[] = array(
					'acf_fc_layout' => 'home_module',
					'module'        => $mod,
					'heading'       => '',
					'lead'          => '',
					'paragraphs'    => array(),
					'items'         => array(),
				);
			}
			update_field( 'page_blocks', $blocks, $id );
			update_field( 'hero_title', 'Альба — клиника анонимной наркологической помощи', $id );
			alba_seed_page_seo(
				$id,
				'Наркологическая клиника Альба — анонимная помощь 24/7',
				'Анонимный детокс, кодирование и реабилитация. Дежурный врач на связи круглосуточно. 18+, добровольно.',
				'images/clinic-hall.jpg'
			);
			$stats['updated']++;
			continue;
		}

		if ( 'test' === $slug ) {
			update_field( 'test_hero_title', 'Пройдите тест‑бриф|для врача', $id );
			update_field( 'test_hero_lead', 'Выберите категорию и ответьте на короткие вопросы. Результат — ориентир для дежурного нарколога, а не диагноз. Анонимно, 2–3 минуты.', $id );
			update_field(
				'test_badges',
				array(
					array( 'text' => 'Анонимно' ),
					array( 'text' => 'Без регистрации' ),
					array( 'text' => '18+' ),
				),
				$id
			);
			update_field( 'test_side_title', 'Обсудить с врачом', $id );
			update_field( 'test_side_text', 'Оставьте телефон — перезвоним и разберём бриф. Можно без имени.', $id );
			update_field( 'test_cta_title', 'Нужна помощь без теста?', $id );
			update_field( 'test_cta_text', 'Дежурный врач на связи 24/7.', $id );
			update_field( 'hero_title', 'Пройдите тест‑бриф|для врача', $id );
			update_field( 'page_blocks', array(), $id );
			alba_seed_page_seo(
				$id,
				'Тест-бриф для нарколога — клиника Альба',
				'Короткий анонимный тест-бриф: ориентир для дежурного врача, не диагноз. 2–3 минуты, без регистрации, 18+.',
				'images/clinic-consult.jpg'
			);
			$stats['updated']++;
			continue;
		}

		$path = trailingslashit( ABSPATH ) . 'legacy-html/' . $file;
		$html = file_exists( $path ) ? (string) file_get_contents( $path ) : '';
		$main = '';
		if ( $html && preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
			$main = trim( $m[1] );
		}
		if ( ! $main ) {
			$stats['skipped']++;
			continue;
		}

		$parsed = alba_parse_main_to_blocks( $main, $slug );
		update_field( 'hero_title', $parsed['hero_title'], $id );
		update_field( 'hero_lead', $parsed['hero_lead'], $id );
		update_field( 'page_chips', $parsed['chips'], $id );
		update_field( 'page_blocks', $parsed['blocks'], $id );
		alba_seed_page_seo_from_hero( $id, $slug, $parsed['hero_title'], $parsed['hero_lead'] );
		$stats['updated']++;
	}

	return $stats;
}

/**
 * SEO defaults map for common pages.
 *
 * @param string $slug Slug.
 * @return array{0:string,1:string}|null [title, image]
 */
function alba_page_seo_defaults( $slug ) {
	$map = array(
		'home'     => array( 'Наркологическая клиника Альба — анонимная помощь 24/7', 'images/clinic-hall.jpg' ),
		'programs' => array( 'Программы лечения зависимости — клиника Альба', 'images/clinic-room.jpg' ),
		'contacts' => array( 'Контакты наркологической клиники Альба', 'images/clinic-hall.jpg' ),
		'prices'   => array( 'Цены на лечение зависимости — клиника Альба', 'images/clinic-bright.jpg' ),
		'doctors'  => array( 'Врачи наркологической клиники Альба', 'images/doctor-1.jpg' ),
		'privacy'  => array( 'Политика конфиденциальности — клиника Альба', 'images/clinic-hall.jpg' ),
		'consent'  => array( 'Согласие на обработку персональных данных — Альба', 'images/clinic-hall.jpg' ),
		'terms'    => array( 'Пользовательское соглашение — клиника Альба', 'images/clinic-hall.jpg' ),
		'legal'    => array( 'Правовая информация — клиника Альба', 'images/clinic-hall.jpg' ),
		'test'     => array( 'Тест-бриф для нарколога — клиника Альба', 'images/clinic-consult.jpg' ),
	);
	return $map[ $slug ] ?? null;
}

/**
 * Write SEO ACF fields.
 *
 * @param int    $id    Post ID.
 * @param string $title Title.
 * @param string $desc  Description.
 * @param string $image Image path.
 */
function alba_seed_page_seo( $id, $title, $desc, $image = 'images/clinic-hall.jpg' ) {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}
	update_field( 'seo_title', $title, $id );
	update_field( 'seo_description', mb_substr( trim( (string) $desc ), 0, 180 ), $id );
	update_field( 'seo_image', $image, $id );
}

/**
 * SEO from hero + optional slug defaults.
 *
 * @param int    $id         ID.
 * @param string $slug       Slug.
 * @param string $hero_title Hero.
 * @param string $hero_lead  Lead.
 */
function alba_seed_page_seo_from_hero( $id, $slug, $hero_title, $hero_lead ) {
	$def   = alba_page_seo_defaults( $slug );
	$title = $def ? $def[0] : ( str_replace( '|', ' ', (string) $hero_title ) . ' — Альба' );
	$img   = $def ? $def[1] : 'images/clinic-hall.jpg';
	$desc  = (string) $hero_lead;
	if ( ! $desc ) {
		$desc = 'Наркологическая клиника «Альба»: анонимная помощь 24/7, детокс, кодирование и реабилитация. 18+, добровольно.';
	}
	alba_seed_page_seo( $id, $title, $desc, $img );
}

/**
 * Parse legacy &lt;main&gt; into hero + structured page_blocks.
 *
 * @param string $main Inner main HTML.
 * @param string $slug Page slug.
 * @return array
 */
function alba_parse_main_to_blocks( $main, $slug = '' ) {
	$out = array(
		'hero_title' => '',
		'hero_lead'  => '',
		'chips'      => array(),
		'blocks'     => array(),
	);

	if ( preg_match( '/<h1[^>]*>([\s\S]*?)<\/h1>/i', $main, $m ) ) {
		$title = preg_replace( '/<br\s*\/?>/i', '|', $m[1] );
		$title = html_entity_decode( wp_strip_all_tags( $title ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$out['hero_title'] = trim( preg_replace( '/\s+/u', ' ', $title ) );
	}

	if ( preg_match( '/page-intro__inner[\s\S]*?<p>([\s\S]*?)<\/p>/i', $main, $m ) ) {
		$out['hero_lead'] = trim( wp_strip_all_tags( $m[1] ) );
	} elseif ( preg_match( '/page-hero__box[\s\S]*?<p>([\s\S]*?)<\/p>/i', $main, $m ) ) {
		$out['hero_lead'] = trim( wp_strip_all_tags( $m[1] ) );
	}

	if ( preg_match_all( '/<li>\s*<b>([\s\S]*?)<\/b>\s*<span>([\s\S]*?)<\/span>\s*<\/li>/i', $main, $mm, PREG_SET_ORDER ) ) {
		foreach ( $mm as $row ) {
			$out['chips'][] = array(
				'title' => trim( wp_strip_all_tags( $row[1] ) ),
				'text'  => trim( wp_strip_all_tags( $row[2] ) ),
			);
		}
	}

	// Stats.
	if ( preg_match( '/<section[^>]*class="[^"]*about-stats[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$items = array();
		if ( preg_match_all( '/<div>\s*<b([^>]*)>([\s\S]*?)<\/b>\s*<span([^>]*)>([\s\S]*?)<\/span>\s*<\/div>/i', $m[1], $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $row ) {
				$battr = $row[1];
				$bval  = trim( wp_strip_all_tags( $row[2] ) );
				$sattr = $row[3];
				$slab  = trim( wp_strip_all_tags( $row[4] ) );
				$type  = 'text';
				$val   = $bval;
				if ( false !== strpos( $battr, 'data-count' ) && preg_match( '/data-count=["\'](\d+)/', $battr, $c ) ) {
					$type = 'count';
					$val  = $c[1];
				} elseif ( false !== strpos( $battr, 'data-city-name' ) ) {
					$type = 'city_name';
					$val  = '';
				} elseif ( false !== strpos( $battr, 'data-city-license' ) ) {
					$type = 'city_license';
					$val  = '';
				}
				if ( false !== strpos( $sattr, 'data-city-address' ) ) {
					$type = 'city_address';
					$slab = 'Адрес';
					$val  = '';
				}
				$items[] = array(
					'value_type' => $type,
					'value'      => $val,
					'label'      => $slab,
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'stats',
				'items'         => $items,
			);
		}
	}

	// Text + image (about).
	if ( preg_match_all( '/<section[^>]*class="[^"]*\babout\b[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $secs, PREG_SET_ORDER ) ) {
		foreach ( $secs as $sec ) {
			$chunk = $sec[1];
			if ( false !== strpos( $chunk, 'about-team' ) || false !== strpos( $sec[0], 'about-team' ) ) {
				continue;
			}
			$h = '';
			$ps = array();
			$ls = array();
			$img = '';
			$alt = '';
			if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $chunk, $hm ) ) {
				$h = trim( preg_replace( '/\s+/u', ' ', str_replace( '|', '|', preg_replace( '/<br\s*\/?>/i', '|', wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ) ) ) ) );
				$h = html_entity_decode( $h, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
			}
			if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $chunk, $pm ) ) {
				foreach ( $pm[1] as $p ) {
					$t = trim( wp_strip_all_tags( $p ) );
					if ( $t ) {
						$ps[] = array( 'text' => $t );
					}
				}
			}
			if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $chunk, $lm ) ) {
				foreach ( $lm[1] as $li ) {
					$t = trim( wp_strip_all_tags( $li ) );
					if ( $t ) {
						$ls[] = array( 'text' => $t );
					}
				}
			}
			if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\'][^>]*(?:alt=["\']([^"\']*)["\'])?/i', $chunk, $im ) ) {
				$img = $im[1];
				$alt = isset( $im[2] ) ? $im[2] : '';
			}
			if ( $img ) {
				$out['blocks'][] = array(
					'acf_fc_layout' => 'text_image',
					'heading'       => $h,
					'paragraphs'    => $ps,
					'list'          => $ls,
					'image_url'     => $img,
					'image_alt'     => $alt,
					'image_right'   => 1,
				);
			} elseif ( $h || $ps || $ls ) {
				$out['blocks'][] = array(
					'acf_fc_layout' => 'text',
					'heading'       => $h,
					'paragraphs'    => $ps,
					'list'          => $ls,
					'anchor'        => '',
				);
			}
		}
	}

	// Hub lead strip.
	if ( preg_match( '/<section[^>]*class="[^"]*hub-lead[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$ht = '';
		$hx = '';
		$hb = 'Оставить заявку';
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$ht = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$hx = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match( '/hub-lead__actions[\s\S]*?<a[^>]*class="[^"]*btn--blue[^"]*"[^>]*>([\s\S]*?)<\/a>/i', $m[1], $bm ) ) {
			$hb = trim( wp_strip_all_tags( $bm[1] ) );
		}
		$out['blocks'][] = array(
			'acf_fc_layout' => 'hub_lead',
			'title'         => $ht,
			'text'          => $hx,
			'button'        => $hb ?: 'Оставить заявку',
		);
	}

	// Alcohol program cards grid.
	if ( preg_match( '/<section[^>]*class="[^"]*alko-progs[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h = '';
		$l = '';
		$items = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/alko-progs__head[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$l = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match_all( '/<a class="alko-prog([^"]*)"[^>]*href=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>/i', $m[1], $cards, PREG_SET_ORDER ) ) {
			foreach ( $cards as $c ) {
				$inner = $c[3];
				$badge = $title = $text = $price = $more = '';
				if ( preg_match( '/<em>([\s\S]*?)<\/em>/i', $inner, $em ) ) {
					$badge = trim( wp_strip_all_tags( $em[1] ) );
				}
				if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $h3 ) ) {
					$title = trim( wp_strip_all_tags( $h3[1] ) );
				}
				if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $inner, $p ) ) {
					$text = trim( wp_strip_all_tags( $p[1] ) );
				}
				if ( preg_match( '/<b>([\s\S]*?)<\/b>/i', $inner, $b ) ) {
					$price = trim( wp_strip_all_tags( $b[1] ) );
				}
				if ( preg_match( '/class="more"[^>]*>([\s\S]*?)<\//i', $inner, $mo ) ) {
					$more = trim( wp_strip_all_tags( $mo[1] ) );
				}
				$url = $c[2];
				if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
					$url = $um[1];
				}
				$items[] = array(
					'badge'    => $badge,
					'title'    => $title,
					'text'     => $text,
					'price'    => $price,
					'more'     => $more ?: 'Подробнее',
					'url'      => $url,
					'featured' => ( false !== strpos( $c[1], 'feat' ) ) ? 1 : 0,
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'program_cards',
				'heading'       => $h,
				'lead'          => $l,
				'items'         => $items,
			);
		}
	}

	// Catalog cat-cards.
	if ( preg_match( '/<div class="catalog">([\s\S]*?)<\/div>/i', $main, $m ) ) {
		$items = array();
		if ( preg_match_all( '/<a class="cat-card([^"]*)"[^>]*href=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>/i', $m[1], $cards, PREG_SET_ORDER ) ) {
			foreach ( $cards as $c ) {
				$inner = $c[3];
				$badge = $title = $text = $price = $icon = '';
				if ( preg_match( '/<span>([\s\S]*?)<\/span>/i', $inner, $sp ) ) {
					$badge = trim( wp_strip_all_tags( $sp[1] ) );
				}
				if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $h3 ) ) {
					$title = trim( wp_strip_all_tags( $h3[1] ) );
				}
				if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $inner, $p ) ) {
					$text = trim( wp_strip_all_tags( $p[1] ) );
				}
				if ( preg_match( '/<b>([\s\S]*?)<\/b>/i', $inner, $b ) ) {
					$price = trim( wp_strip_all_tags( $b[1] ) );
				}
				if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $inner, $im ) ) {
					$icon = $im[1];
				}
				$url = $c[2];
				if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
					$url = $um[1];
				}
				$items[] = array(
					'badge'  => $badge,
					'title'  => $title,
					'text'   => $text,
					'price'  => $price,
					'url'    => $url,
					'icon'   => $icon,
					'accent' => ( false !== strpos( $c[1], 'accent' ) ) ? 1 : 0,
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'catalog',
				'items'         => $items,
			);
		}
	}

	// Ward fund.
	if ( preg_match( '/<section[^>]*class="[^"]*ward-fund[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h = '';
		$l = '';
		$btn = 'Забронировать палату';
		$items = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/ward-fund__head[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$l = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match( '/ward-fund__cta[\s\S]*?btn--blue[^>]*>([\s\S]*?)<\/a>/i', $m[1], $bm ) ) {
			$btn = trim( wp_strip_all_tags( $bm[1] ) );
		}
		if ( preg_match_all( '/<article([^>]*)>([\s\S]*?)<\/article>/i', $m[1], $arts, PREG_SET_ORDER ) ) {
			foreach ( $arts as $art ) {
				$attrs = $art[1];
				$inner = $art[2];
				$badge = $title = '';
				$list  = array();
				if ( preg_match( '/ward-fund__badge[^>]*>([\s\S]*?)<\//i', $inner, $bg ) ) {
					$badge = trim( wp_strip_all_tags( $bg[1] ) );
				}
				if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $h3 ) ) {
					$title = trim( wp_strip_all_tags( $h3[1] ) );
				}
				if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $inner, $lis ) ) {
					foreach ( $lis[1] as $li ) {
						$t = trim( wp_strip_all_tags( $li ) );
						if ( $t ) {
							$list[] = array( 'text' => $t );
						}
					}
				}
				if ( $title || $list ) {
					$items[] = array(
						'badge'    => $badge,
						'title'    => $title,
						'list'     => $list,
						'featured' => ( false !== strpos( $attrs, 'feat' ) ) ? 1 : 0,
					);
				}
			}
		}
		if ( $items || $h ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'ward_fund',
				'heading'       => $h,
				'lead'          => $l,
				'items'         => $items,
				'button'        => $btn ?: 'Забронировать палату',
			);
		}
	}

	// Anon / pillars cards.
	if ( preg_match( '/<section[^>]*id=["\']anon["\'][^>]*>([\s\S]*?)<\/section>/i', $main, $m )
		|| preg_match( '/<section[^>]*class="[^"]*anon[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$items = array();
		if ( preg_match_all( '/<(?:article|div)[^>]*class="[^"]*(?:anon-card|pillar|card)[^"]*"[^>]*>[\s\S]*?<h3[^>]*>([\s\S]*?)<\/h3>[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $row ) {
				$items[] = array(
					'title' => trim( wp_strip_all_tags( $row[1] ) ),
					'text'  => trim( wp_strip_all_tags( $row[2] ) ),
				);
			}
		}
		$h = '';
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'cards',
				'heading'       => $h,
				'style'         => 'anon',
				'items'         => $items,
			);
		}
	}

	// Funnel form.
	if ( preg_match( '/<section[^>]*class="[^"]*page-funnel[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h = '';
		$t = '';
		$chips = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( wp_strip_all_tags( $hm[1] ) );
		}
		if ( preg_match( '/page-funnel__copy[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$t = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match_all( '/page-funnel__chips[\s\S]*?<li>([\s\S]*?)<\/li>/i', $m[1], $cm ) ) {
			foreach ( $cm[1] as $c ) {
				$chips[] = array( 'text' => trim( wp_strip_all_tags( $c ) ) );
			}
		}
		$out['blocks'][] = array(
			'acf_fc_layout' => 'funnel',
			'title'         => $h ?: 'Перезвоним за 2 минуты',
			'text'          => $t,
			'chips'         => $chips,
		);
	}

	// Gallery.
	if ( preg_match_all( '/<figure[^>]*>\s*<img[^>]+src=["\']([^"\']+)["\'][^>]*(?:alt=["\']([^"\']*)["\'])?[^>]*>\s*(?:<figcaption>([\s\S]*?)<\/figcaption>)?\s*<\/figure>/i', $main, $mm, PREG_SET_ORDER ) ) {
		$items = array();
		foreach ( $mm as $row ) {
			$items[] = array(
				'image_url' => $row[1],
				'alt'       => isset( $row[2] ) ? $row[2] : '',
				'caption'   => isset( $row[3] ) ? trim( wp_strip_all_tags( $row[3] ) ) : '',
			);
		}
		if ( $items && ( 'gallery' === $slug || count( $items ) >= 2 ) ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'gallery',
				'items'         => $items,
			);
		}
	}

	// Steps.
	if ( preg_match( '/<section[^>]*class="[^"]*(?:steps|about-steps)[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h = '';
		$lead = '';
		$items = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/<p[^>]*class="[^"]*lead[^"]*"[^>]*>([\s\S]*?)<\/p>/i', $m[1], $pm ) || preg_match( '/<\/h2>\s*<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$lead = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match_all( '/<(?:article|li|div)[^>]*>[\s\S]*?<h3[^>]*>([\s\S]*?)<\/h3>[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $row ) {
				$items[] = array(
					'title' => trim( wp_strip_all_tags( $row[1] ) ),
					'text'  => trim( wp_strip_all_tags( $row[2] ) ),
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'steps',
				'heading'       => $h,
				'lead'          => $lead,
				'items'         => $items,
			);
		}
	}

	// FAQ parsed later (before CTA) so order matches the page.

	// Prices tables.
	if ( preg_match_all( '/<(?:article|section|div)[^>]*class="[^"]*price-card[^"]*"[^>]*>([\s\S]*?)<\/(?:article|section|div)>/i', $main, $mm, PREG_SET_ORDER )
		|| ( 'prices' === $slug && preg_match_all( '/<table[^>]*class="[^"]*price-table[^"]*"[^>]*>([\s\S]*?)<\/table>/i', $main, $tm, PREG_SET_ORDER ) ) ) {
		$groups = array();
		if ( ! empty( $mm ) ) {
			foreach ( $mm as $card ) {
				$gt = '';
				if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $card[1], $hm ) ) {
					$gt = trim( wp_strip_all_tags( $hm[1] ) );
				}
				$rows = array();
				if ( preg_match_all( '/<tr>\s*<td>([\s\S]*?)<\/td>\s*<td>([\s\S]*?)<\/td>\s*<\/tr>/i', $card[1], $rr, PREG_SET_ORDER ) ) {
					foreach ( $rr as $r ) {
						$name = trim( wp_strip_all_tags( $r[1] ) );
						$link = '';
						if ( preg_match( '/href=["\']([^"\']+)["\']/', $r[1], $lm ) ) {
							$link = preg_replace( '/\.html$/i', '', basename( parse_url( $lm[1], PHP_URL_PATH ) ?: $lm[1] ) );
						}
						$rows[] = array(
							'name'  => $name,
							'price' => trim( wp_strip_all_tags( $r[2] ) ),
							'link'  => $link,
						);
					}
				}
				if ( $rows ) {
					$groups[] = array( 'title' => $gt, 'rows' => $rows );
				}
			}
		} elseif ( ! empty( $tm ) ) {
			foreach ( $tm as $ti => $table ) {
				$rows = array();
				if ( preg_match_all( '/<tr>\s*<td>([\s\S]*?)<\/td>\s*<td>([\s\S]*?)<\/td>\s*<\/tr>/i', $table[1], $rr, PREG_SET_ORDER ) ) {
					foreach ( $rr as $r ) {
						$rows[] = array(
							'name'  => trim( wp_strip_all_tags( $r[1] ) ),
							'price' => trim( wp_strip_all_tags( $r[2] ) ),
							'link'  => '',
						);
					}
				}
				if ( $rows ) {
					$groups[] = array( 'title' => 'Прайс ' . ( $ti + 1 ), 'rows' => $rows );
				}
			}
		}
		$note = '';
		if ( preg_match( '/class="[^"]*price-note[^"]*"[^>]*>([\s\S]*?)<\//i', $main, $nm ) ) {
			$note = trim( wp_strip_all_tags( $nm[1] ) );
		}
		if ( $groups ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'prices',
				'groups'        => $groups,
				'note'          => $note,
			);
		}
	}

	// Contacts.
	if ( 'contacts' === $slug || preg_match( '/<section[^>]*class="[^"]*contacts[^"]*"/i', $main ) ) {
		$out['blocks'][] = array(
			'acf_fc_layout' => 'contacts',
			'cards'         => array(
				array( 'label' => 'Телефон', 'value_type' => 'phone', 'value' => '', 'text' => 'Круглосуточно' ),
				array( 'label' => 'Мессенджеры', 'value_type' => 'messengers', 'value' => '', 'text' => 'Напишите в удобный канал' ),
				array( 'label' => 'Адрес', 'value_type' => 'address', 'value' => '', 'text' => '' ),
				array( 'label' => 'Лицензия', 'value_type' => 'license', 'value' => '', 'text' => '' ),
			),
			'show_map'      => 1,
			'show_form'     => 1,
			'form_title'    => 'Оставить номер',
			'form_text'     => 'Дежурный врач перезвонит с номера клиники.',
		);
	}

	// Team teaser.
	if ( preg_match( '/<section[^>]*class="[^"]*about-team[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h = '';
		$l = '';
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$l = trim( wp_strip_all_tags( $pm[1] ) );
		}
		$out['blocks'][] = array(
			'acf_fc_layout' => 'team',
			'heading'       => $h,
			'lead'          => $l,
			'button'        => 'Смотреть врачей',
			'button_url'    => 'doctors',
		);
	}

	// Links list.
	if ( 'links' === $slug || preg_match( '/class="[^"]*links-list[^"]*"/i', $main ) ) {
		$items = array();
		if ( preg_match_all( '/<li[^>]*>\s*<a[^>]+href=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>\s*(?:<p>([\s\S]*?)<\/p>)?/i', $main, $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $row ) {
				$url = $row[1];
				if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
					$url = $um[1];
				}
				$items[] = array(
					'label' => trim( wp_strip_all_tags( $row[2] ) ),
					'url'   => $url,
					'text'  => isset( $row[3] ) ? trim( wp_strip_all_tags( $row[3] ) ) : '',
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'links',
				'heading'       => '',
				'items'         => $items,
			);
		}
	}

	// Legal / text pages: collect remaining h2+p sections as text blocks.
	if ( in_array( $slug, array( 'privacy', 'consent', 'terms', 'legal' ), true ) ) {
		$body = $main;
		$body = preg_replace( '/<section class="page-intro wrap">[\s\S]*?<\/section>/i', '', $body, 1 );
		$body = preg_replace( '/<section class="page-hero wrap">[\s\S]*?<\/section>/i', '', $body, 1 );
		$body = preg_replace( '/<section class="cta wrap">[\s\S]*?<\/section>/i', '', $body );
		$body = preg_replace( '/<section[^>]*class="[^"]*faq[^"]*"[^>]*>[\s\S]*?<\/section>/i', '', $body );
		$body = preg_replace( '/<section[^>]*class="[^"]*page-funnel[^"]*"[^>]*>[\s\S]*?<\/section>/i', '', $body );
		$body = preg_replace( '/<section[^>]*class="[^"]*contacts[^"]*"[^>]*>[\s\S]*?<\/section>/i', '', $body );
		if ( preg_match_all( '/<section([^>]*)>([\s\S]*?)<\/section>/i', $body, $secs, PREG_SET_ORDER ) ) {
			foreach ( $secs as $sec ) {
				$attrs = $sec[1];
				$chunk = $sec[2];
				if ( preg_match( '/class="[^"]*(?:faq|cta|page-funnel|contacts|gallery|price|hub-lead|alko-progs|ward-fund|catalog)[^"]*"/i', $attrs ) ) {
					continue;
				}
				// Skip empty wrapper sections around catalog.
				if ( ! trim( wp_strip_all_tags( $chunk ) ) ) {
					continue;
				}
				if ( false !== strpos( $chunk, 'class="catalog"' ) || false !== strpos( $chunk, 'alko-prog' ) ) {
					continue;
				}
				$h = '';
				$ps = array();
				$ls = array();
				if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $chunk, $hm ) ) {
					$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
				}
				// Skip leftover FAQ heading without items.
				if ( $h && ( false !== mb_stripos( $h, 'Часто задаваемые' ) || false !== mb_stripos( $h, 'FAQ' ) ) ) {
					continue;
				}
				if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $chunk, $pm ) ) {
					foreach ( $pm[1] as $p ) {
						$t = trim( wp_strip_all_tags( $p ) );
						if ( $t ) {
							$ps[] = array( 'text' => $t );
						}
					}
				}
				if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $chunk, $lm ) ) {
					foreach ( $lm[1] as $li ) {
						$t = trim( wp_strip_all_tags( $li ) );
						if ( $t ) {
							$ls[] = array( 'text' => $t );
						}
					}
				}
				if ( $h || $ps || $ls ) {
					$out['blocks'][] = array(
						'acf_fc_layout' => 'text',
						'heading'       => $h,
						'paragraphs'    => $ps,
						'list'          => $ls,
						'anchor'        => '',
					);
				}
			}
		} else {
			// Flat content without sections.
			$ps = array();
			if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $body, $pm ) ) {
				foreach ( $pm[1] as $p ) {
					$t = trim( wp_strip_all_tags( $p ) );
					if ( $t ) {
						$ps[] = array( 'text' => $t );
					}
				}
			}
			if ( $ps ) {
				$out['blocks'][] = array(
					'acf_fc_layout' => 'text',
					'heading'       => '',
					'paragraphs'    => $ps,
					'list'          => array(),
					'anchor'        => '',
				);
			}
		}
	}

	// FAQ (details OR accordion) — after content blocks, before CTA.
	if ( preg_match( '/<section[^>]*class="[^"]*faq[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$h     = '';
		$items = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$h = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match_all( '/<details[^>]*>\s*<summary>([\s\S]*?)<\/summary>\s*<div[^>]*>([\s\S]*?)<\/div>\s*<\/details>/i', $m[1], $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $row ) {
				$items[] = array(
					'q' => trim( wp_strip_all_tags( $row[1] ) ),
					'a' => trim( wp_strip_all_tags( $row[2] ) ),
				);
			}
		}
		if ( ! $items && preg_match_all( '/<article class="acc__item[^"]*">\s*<button class="acc__btn"[^>]*>([\s\S]*?)<i>/i', $m[1], $qs ) ) {
			preg_match_all( '/<div class="acc__panel"><div><p>([\s\S]*?)<\/p>/i', $m[1], $as );
			foreach ( $qs[1] as $i => $q ) {
				$items[] = array(
					'q' => trim( wp_strip_all_tags( $q ) ),
					'a' => isset( $as[1][ $i ] ) ? trim( wp_strip_all_tags( $as[1][ $i ] ) ) : '',
				);
			}
		}
		if ( $items ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'faq',
				'heading'       => $h ?: 'Часто задаваемые|вопросы',
				'items'         => $items,
			);
		}
	}

	// CTA.
	if ( preg_match( '/<section class="cta wrap">([\s\S]*?)<\/section>/i', $main, $m ) ) {
		$ct = '';
		$cx = '';
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $h ) ) {
			$ct = trim( wp_strip_all_tags( $h[1] ) );
		}
		if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $m[1], $p ) ) {
			$cx = trim( wp_strip_all_tags( $p[1] ) );
		}
		if ( $ct || $cx ) {
			$out['blocks'][] = array(
				'acf_fc_layout' => 'cta',
				'title'         => $ct,
				'text'          => $cx,
			);
		}
	}

	return $out;
}
