<?php
/**
 * Doctors CPT: ACF detail fields + seed from doctors.html and doctor-*.html.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parse people cards from doctors.html.
 *
 * @param string $html Full HTML or main.
 * @return array{heading:string,lead:string,doctors:array}
 */
function alba_parse_doctors_list( $html ) {
	$out = array(
		'heading' => 'Наши специалисты',
		'lead'    => '',
		'doctors' => array(),
	);
	if ( preg_match( '/people__intro[\s\S]*?<h2[^>]*>([\s\S]*?)<\/h2>/i', $html, $m ) ) {
		$out['heading'] = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $m[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
	}
	if ( preg_match( '/people__lead[^>]*>([\s\S]*?)<\//i', $html, $m ) ) {
		$out['lead'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( ! preg_match_all( '/<article[^>]*class="[^"]*person[^"]*"[^>]*data-spec=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/article>/i', $html, $cards, PREG_SET_ORDER ) ) {
		preg_match_all( '/<article[^>]*data-docs-card[^>]*data-spec=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/article>/i', $html, $cards, PREG_SET_ORDER );
	}
	foreach ( $cards as $c ) {
		$filter = $c[1];
		$inner  = $c[2];
		$name = $spec = $exp = $desc = $photo = $url = '';
		if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $hm ) ) {
			$name = trim( wp_strip_all_tags( $hm[1] ) );
		}
		if ( preg_match( '/person__spec[^>]*>([\s\S]*?)<\//i', $inner, $sm ) ) {
			$spec = trim( wp_strip_all_tags( $sm[1] ) );
		}
		if ( preg_match( '/person__exp[^>]*>([\s\S]*?)<\//i', $inner, $em ) ) {
			$exp = trim( wp_strip_all_tags( $em[1] ) );
		}
		if ( preg_match( '/person__desc[^>]*>([\s\S]*?)<\//i', $inner, $dm ) ) {
			$desc = trim( wp_strip_all_tags( $dm[1] ) );
		}
		if ( preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $inner, $im ) ) {
			$photo = $im[1];
		}
		if ( preg_match( '/person__more[^>]*href=["\']([^"\']+)["\']/i', $inner, $um ) ) {
			$url = $um[1];
			if ( preg_match( '/doctor-([a-z0-9\-]+)\.html/i', $url, $um2 ) ) {
				$url = $um2[1];
			} elseif ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um2 ) ) {
				$url = preg_replace( '/^doctor-/', '', $um2[1] );
			}
		}
		if ( ! $name ) {
			continue;
		}
		$out['doctors'][] = array(
			'name'        => $name,
			'spec'        => $spec,
			'experience'  => $exp,
			'short_desc'  => $desc,
			'photo_url'   => $photo,
			'docs_filter' => $filter ?: 'field',
			'slug'        => $url ?: sanitize_title( $name ),
		);
	}
	return $out;
}

/**
 * Parse doctor-*.html detail page into ACF values.
 *
 * @param string $html Full HTML.
 * @return array
 */
function alba_parse_doctor_detail( $html ) {
	$out = array(
		'title'                 => '',
		'hero_subtitle'         => '',
		'doctor_lead'           => '',
		'photo_url'             => '',
		'bio_paragraphs'        => array(),
		'specializations'       => array(),
		'education_heading'     => 'Образование и опыт',
		'education_paragraphs'  => array(),
		'disclaimer'            => '',
		'cta_title'             => 'Нужна консультация именно этого специалиста?',
		'cta_text'              => 'Оставьте номер — администратор подскажет ближайшее окно и подготовит визит анонимно.',
		'seo_description'       => '',
	);

	if ( preg_match( '/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $mm ) ) {
		$out['seo_description'] = trim( html_entity_decode( $mm[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	}

	if ( preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
		$main = $m[1];
	} else {
		$main = $html;
	}

	if ( preg_match( '/page-hero__box[\s\S]*?<h1[^>]*>([\s\S]*?)<\/h1>/i', $main, $hm ) ) {
		$title = preg_replace( '/<br\s*\/?>/i', ' ', $hm[1] );
		$out['title'] = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $title ) ) );
	}
	if ( preg_match( '/page-hero__box[\s\S]*?<p>([\s\S]*?)<\/p>/i', $main, $pm ) ) {
		$out['hero_subtitle'] = trim( wp_strip_all_tags( $pm[1] ) );
	}

	if ( preg_match( '/doctor__photo[\s\S]*?<img[^>]+src=["\']([^"\']+)["\']/i', $main, $im ) ) {
		$out['photo_url'] = $im[1];
	}

	$body = '';
	if ( preg_match( '/doctor__body[^>]*>([\s\S]*?)(?:<\/div>\s*<\/section>|<section[^>]*class="[^"]*cta)/i', $main, $bm ) ) {
		$body = $bm[1];
	} elseif ( preg_match( '/<section[^>]*class="[^"]*doctor[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $main, $bm ) ) {
		$body = $bm[1];
	}

	if ( preg_match( '/doctor__lead[^>]*>([\s\S]*?)<\//i', $body, $lm ) ) {
		$out['doctor_lead'] = trim( wp_strip_all_tags( $lm[1] ) );
	}

	// Bio paragraphs: <p> before first <h2>, excluding lead.
	$before_h2 = $body;
	if ( preg_match( '/^([\s\S]*?)(?=<h2\b)/i', $body, $bh ) ) {
		$before_h2 = $bh[1];
	}
	$before_h2 = preg_replace( '/<p[^>]*class="[^"]*doctor__lead[^"]*"[^>]*>[\s\S]*?<\/p>/i', '', $before_h2 );
	if ( preg_match_all( '/<p(?:\s[^>]*)?>([\s\S]*?)<\/p>/i', $before_h2, $pm ) ) {
		foreach ( $pm[1] as $p ) {
			$t = trim( wp_strip_all_tags( $p ) );
			if ( $t ) {
				$out['bio_paragraphs'][] = array( 'text' => $t );
			}
		}
	}

	// Specialization tags.
	if ( preg_match( '/doctor__tags[^>]*>([\s\S]*?)<\/ul>/i', $body, $tm ) ) {
		if ( preg_match_all( '/<li[^>]*>([\s\S]*?)<\/li>/i', $tm[1], $lim ) ) {
			foreach ( $lim[1] as $li ) {
				$t = trim( wp_strip_all_tags( $li ) );
				if ( $t ) {
					$out['specializations'][] = array( 'text' => $t );
				}
			}
		}
	}

	// Education section: last h2 block typically.
	if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>([\s\S]*?)(?=<div[^>]*class="[^"]*doctor__actions|doctor__note|<h2\b|$)/i', $body, $em ) ) {
		// Prefer the education heading (not "Специализация").
		if ( preg_match_all( '/<h2[^>]*>([\s\S]*?)<\/h2>([\s\S]*?)(?=<h2\b|<div[^>]*class="[^"]*doctor__actions|doctor__note|$)/i', $body, $sections, PREG_SET_ORDER ) ) {
			foreach ( $sections as $sec ) {
				$h = trim( wp_strip_all_tags( $sec[1] ) );
				if ( false !== mb_stripos( $h, 'Специализа' ) ) {
					continue;
				}
				$out['education_heading'] = $h ?: 'Образование и опыт';
				if ( preg_match_all( '/<p(?:\s[^>]*)?>([\s\S]*?)<\/p>/i', $sec[2], $epm ) ) {
					foreach ( $epm[1] as $p ) {
						$t = trim( wp_strip_all_tags( $p ) );
						if ( $t ) {
							$out['education_paragraphs'][] = array( 'text' => $t );
						}
					}
				}
			}
		}
	}

	if ( preg_match( '/doctor__note[^>]*>([\s\S]*?)<\//i', $body, $nm ) ) {
		$out['disclaimer'] = trim( wp_strip_all_tags( $nm[1] ) );
	}

	if ( preg_match( '/<section[^>]*class="[^"]*cta[^"]*"[^>]*>[\s\S]*?<h2[^>]*>([\s\S]*?)<\/h2>[\s\S]*?<p>([\s\S]*?)<\/p>/i', $main, $cm ) ) {
		$out['cta_title'] = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', ' ', $cm[1] ) ) ) );
		$out['cta_text']  = trim( wp_strip_all_tags( $cm[2] ) );
	}

	return $out;
}

/**
 * Render single doctor from ACF only.
 *
 * @param int $post_id ID.
 */
function alba_render_doctor( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$city    = function_exists( 'alba_get_current_city' ) ? alba_get_current_city() : array();

	$spec     = (string) get_field( 'field_doc_spec', $post_id );
	$exp      = (string) get_field( 'field_doc_exp', $post_id );
	$photo    = (string) get_field( 'field_doc_photo', $post_id );
	$hero     = (string) get_field( 'field_doc_hero', $post_id );
	$lead     = (string) get_field( 'field_doc_lead', $post_id );
	$bio      = get_field( 'field_doc_bio', $post_id );
	$tags     = get_field( 'field_doc_tags', $post_id );
	$edu_h    = (string) ( get_field( 'field_doc_edu_h', $post_id ) ?: 'Образование и опыт' );
	$edu      = get_field( 'field_doc_edu', $post_id );
	$note     = (string) get_field( 'field_doc_note', $post_id );
	$cta_h    = (string) ( get_field( 'field_doc_cta_h', $post_id ) ?: 'Нужна консультация именно этого специалиста?' );
	$cta_t    = (string) ( get_field( 'field_doc_cta_t', $post_id ) ?: 'Оставьте номер — администратор подскажет ближайшее окно и подготовит визит анонимно.' );

	if ( ! $hero ) {
		$hero = trim( $spec . ( $exp ? ' · ' . $exp : '' ) );
	}
	if ( $photo && function_exists( 'alba_media_url' ) ) {
		$photo = alba_media_url( $photo );
	}

	$bio_lines = function_exists( 'alba_lines' ) ? alba_lines( is_array( $bio ) ? $bio : array() ) : array();
	$tag_lines = function_exists( 'alba_lines' ) ? alba_lines( is_array( $tags ) ? $tags : array() ) : array();
	$edu_lines = function_exists( 'alba_lines' ) ? alba_lines( is_array( $edu ) ? $edu : array() ) : array();

	$title = get_the_title( $post_id );
	$h1    = $title;
	if ( false === strpos( $title, '|' ) ) {
		$parts = preg_split( '/\s+/u', trim( $title ), 2 );
		if ( is_array( $parts ) && count( $parts ) === 2 ) {
			$h1 = $parts[0] . '|' . $parts[1];
		}
	}
	?>
	<section class="page-hero wrap">
		<div class="page-hero__box">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / <a href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Врачи</a> / <?php echo esc_html( $title ); ?></div>
				<h1 class="split"><?php echo function_exists( 'alba_title_br' ) ? alba_title_br( $h1 ) : esc_html( $title ); // phpcs:ignore ?></h1>
			</div>
			<?php if ( $hero ) : ?><p><?php echo esc_html( $hero ); ?></p><?php endif; ?>
		</div>
	</section>

	<section class="doctor wrap" data-reveal>
		<?php if ( $photo ) : ?>
			<div class="doctor__photo">
				<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" decoding="async">
			</div>
		<?php endif; ?>
		<div class="doctor__body">
			<?php if ( $lead ) : ?><p class="doctor__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
			<?php foreach ( $bio_lines as $p ) : ?>
				<p><?php echo esc_html( $p ); ?></p>
			<?php endforeach; ?>
			<?php if ( $tag_lines ) : ?>
				<h2>Специализация</h2>
				<ul class="doctor__tags">
					<?php foreach ( $tag_lines as $t ) : ?>
						<li><?php echo esc_html( $t ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( $edu_lines ) : ?>
				<h2><?php echo esc_html( $edu_h ); ?></h2>
				<?php foreach ( $edu_lines as $p ) : ?>
					<p><?php echo esc_html( $p ); ?></p>
				<?php endforeach; ?>
			<?php endif; ?>
			<div class="doctor__actions">
				<a class="btn btn--blue" href="#" data-open-modal>Записаться к специалисту <?php echo alba_arr(); // phpcs:ignore ?></a>
				<a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Все врачи</a>
			</div>
			<?php if ( $note ) : ?><p class="doctor__note"><?php echo esc_html( $note ); ?></p><?php endif; ?>
		</div>
	</section>

	<section class="cta wrap">
		<div class="cta__box" data-reveal="scale">
			<div>
				<h2><?php echo esc_html( $cta_h ); ?></h2>
				<?php if ( $cta_t ) : ?><p><?php echo esc_html( $cta_t ); ?></p><?php endif; ?>
			</div>
			<div class="cta__actions">
				<a class="btn btn--light" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( $city['tel'] ?? '' ); ?>" data-city-tel>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ?? '' ); ?></span></a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Upsert doctors CPT from doctors.html + doctor-*.html detail pages.
 *
 * @param bool $force Overwrite.
 * @return array Stats.
 */
function alba_seed_doctors_acf( $force = true ) {
	if ( ! function_exists( 'update_field' ) ) {
		return array( 'error' => 'ACF missing' );
	}
	$path = trailingslashit( ABSPATH ) . 'legacy-html/doctors.html';
	if ( ! file_exists( $path ) ) {
		return array( 'error' => 'doctors.html missing' );
	}
	$html  = (string) file_get_contents( $path );
	$data  = alba_parse_doctors_list( $html );
	$stats = array( 'doctors' => 0, 'details' => 0, 'page' => 0 );
	$upd   = function_exists( 'alba_update_field_key' ) ? 'alba_update_field_key' : 'update_field';

	foreach ( $data['doctors'] as $doc ) {
		$slug = sanitize_title( $doc['slug'] );
		$post = get_page_by_path( $slug, OBJECT, 'doctor' );
		$args = array(
			'post_type'    => 'doctor',
			'post_name'    => $slug,
			'post_title'   => $doc['name'],
			'post_excerpt' => $doc['short_desc'],
			'post_content' => '',
			'post_status'  => 'publish',
		);
		if ( $post ) {
			$args['ID'] = $post->ID;
			$id         = wp_update_post( $args, true );
		} else {
			$id = wp_insert_post( $args, true );
		}
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		delete_post_meta( $id, '_alba_legacy_file' );
		call_user_func( $upd, 'field_doc_spec', $doc['spec'], $id );
		call_user_func( $upd, 'field_doc_exp', $doc['experience'], $id );
		call_user_func( $upd, 'field_doc_type', $doc['docs_filter'], $id );
		call_user_func( $upd, 'field_doc_photo', $doc['photo_url'], $id );
		call_user_func( $upd, 'field_doc_desc', $doc['short_desc'], $id );

		// Detail page from doctor-{slug}.html.
		$detail_path = trailingslashit( ABSPATH ) . 'legacy-html/doctor-' . $slug . '.html';
		if ( file_exists( $detail_path ) && ( $force || ! get_field( 'field_doc_lead', $id ) ) ) {
			$detail = alba_parse_doctor_detail( (string) file_get_contents( $detail_path ) );
			if ( ! empty( $detail['title'] ) ) {
				wp_update_post(
					array(
						'ID'         => $id,
						'post_title' => $detail['title'],
					)
				);
			}
			if ( ! empty( $detail['photo_url'] ) ) {
				call_user_func( $upd, 'field_doc_photo', $detail['photo_url'], $id );
			}
			call_user_func( $upd, 'field_doc_hero', $detail['hero_subtitle'], $id );
			call_user_func( $upd, 'field_doc_lead', $detail['doctor_lead'], $id );
			call_user_func( $upd, 'field_doc_bio', $detail['bio_paragraphs'], $id );
			call_user_func( $upd, 'field_doc_tags', $detail['specializations'], $id );
			call_user_func( $upd, 'field_doc_edu_h', $detail['education_heading'], $id );
			call_user_func( $upd, 'field_doc_edu', $detail['education_paragraphs'], $id );
			call_user_func( $upd, 'field_doc_note', $detail['disclaimer'], $id );
			call_user_func( $upd, 'field_doc_cta_h', $detail['cta_title'], $id );
			call_user_func( $upd, 'field_doc_cta_t', $detail['cta_text'], $id );

			$seo_desc = $detail['seo_description'] ?: $detail['doctor_lead'] ?: $doc['short_desc'];
			call_user_func( $upd, 'field_seo_title', ( $detail['title'] ?: $doc['name'] ) . ' — врач клиники Альба', $id );
			call_user_func( $upd, 'field_seo_desc', mb_substr( (string) $seo_desc, 0, 180 ), $id );
			call_user_func( $upd, 'field_seo_img', $detail['photo_url'] ?: $doc['photo_url'] ?: 'images/doctor-1.jpg', $id );
			$stats['details']++;
		} else {
			call_user_func( $upd, 'field_seo_title', $doc['name'] . ' — врач клиники Альба', $id );
			call_user_func( $upd, 'field_seo_desc', mb_substr( (string) $doc['short_desc'], 0, 180 ), $id );
			call_user_func( $upd, 'field_seo_img', $doc['photo_url'] ?: 'images/doctor-1.jpg', $id );
		}
		$stats['doctors']++;
	}

	$page = get_page_by_path( 'doctors' );
	if ( $page ) {
		$main = '';
		if ( preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
			$main = $m[1];
		}
		$parsed = function_exists( 'alba_parse_main_to_blocks' ) ? alba_parse_main_to_blocks( $main, 'doctors' ) : array(
			'hero_title' => 'Медицинская команда|экспертного уровня',
			'hero_lead'  => '',
			'chips'      => array(),
			'blocks'     => array(),
		);

		$blocks   = array();
		$blocks[] = array(
			'acf_fc_layout' => 'doctors_grid',
			'heading'       => $data['heading'] ?: 'Наши специалисты',
			'lead'          => $data['lead'],
			'from_cpt'      => 1,
			'items'         => array(),
		);
		foreach ( $parsed['blocks'] as $b ) {
			$layout = $b['acf_fc_layout'] ?? '';
			if ( in_array( $layout, array( 'faq', 'cta', 'hub_lead' ), true ) ) {
				$blocks[] = $b;
			}
		}
		$has_faq = false;
		$has_cta = false;
		foreach ( $blocks as $b ) {
			if ( 'faq' === ( $b['acf_fc_layout'] ?? '' ) ) {
				$has_faq = true;
			}
			if ( 'cta' === ( $b['acf_fc_layout'] ?? '' ) ) {
				$has_cta = true;
			}
		}
		if ( ! $has_cta ) {
			$blocks[] = array(
				'acf_fc_layout' => 'cta',
				'title'         => 'Нужна помощь врача?',
				'text'          => 'Дежурный врач на связи 24/7.',
			);
		}

		update_field( 'hero_title', $parsed['hero_title'] ?: 'Медицинская команда|экспертного уровня', $page->ID );
		update_field( 'hero_lead', $parsed['hero_lead'] ?: 'Наркологи, психиатры и психотерапевты работают в одной смене. Решение по протоколу принимается вместе.', $page->ID );
		update_field( 'page_chips', $parsed['chips'], $page->ID );
		update_field( 'page_blocks', $blocks, $page->ID );
		if ( function_exists( 'alba_seed_page_seo' ) ) {
			alba_seed_page_seo(
				$page->ID,
				'Врачи наркологической клиники Альба',
				$parsed['hero_lead'] ?: 'Наркологи, психиатры и психотерапевты клиники Альба. Анонимный приём, 18+.',
				'images/doctor-1.jpg'
			);
		}
		wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => '',
			)
		);
		$stats['page']       = 1;
		$stats['unused_faq'] = $has_faq ? 1 : 0;
	}

	return $stats;
}

add_action(
	'admin_init',
	static function () {
		remove_post_type_support( 'doctor', 'editor' );
	}
);
