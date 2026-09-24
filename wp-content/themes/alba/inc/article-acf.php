<?php
/**
 * Articles (posts): ACF body + seed from legacy-html, no WYSIWYG required.
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
				'key'    => 'group_alba_article',
				'title'  => 'Статья (ACF)',
				'fields' => array(
					array(
						'key'   => 'field_art_lead',
						'label' => 'Лид',
						'name'  => 'lead',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_art_cover',
						'label' => 'Обложка URL',
						'name'  => 'cover_url',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_art_body',
						'label'        => 'Блоки текста',
						'name'         => 'body_blocks',
						'type'         => 'flexible_content',
						'button_label' => 'Блок',
						'layouts'      => array(
							'layout_art_text' => array(
								'key'        => 'layout_art_text',
								'name'       => 'text',
								'label'      => 'Текст',
								'display'    => 'block',
								'sub_fields' => array(
									array(
										'key'   => 'fld_art_h',
										'label' => 'Заголовок',
										'name'  => 'heading',
										'type'  => 'text',
									),
									array(
										'key'          => 'fld_art_p',
										'label'        => 'Абзацы',
										'name'         => 'paragraphs',
										'type'         => 'repeater',
										'layout'       => 'table',
										'button_label' => 'Абзац',
										'sub_fields'   => array(
											array(
												'key'  => 'fld_art_pt',
												'label'=> 'Текст',
												'name' => 'text',
												'type' => 'textarea',
												'rows' => 3,
											),
										),
									),
									array(
										'key'          => 'fld_art_l',
										'label'        => 'Список',
										'name'         => 'list',
										'type'         => 'repeater',
										'layout'       => 'table',
										'button_label' => 'Пункт',
										'sub_fields'   => array(
											array(
												'key'  => 'fld_art_lt',
												'label'=> 'Текст',
												'name' => 'text',
												'type' => 'text',
											),
										),
									),
								),
							),
						),
					),
					array(
						'key'   => 'field_art_cta_h',
						'label' => 'CTA заголовок',
						'name'  => 'cta_title',
						'type'  => 'text',
						'default_value' => 'Нужна консультация врача?',
					),
					array(
						'key'   => 'field_art_cta_t',
						'label' => 'CTA текст',
						'name'  => 'cta_text',
						'type'  => 'textarea',
						'rows'  => 2,
						'default_value' => 'Дежурный специалист на связи 24/7. Можно без имени. 18+.',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'post',
						),
					),
				),
				'menu_order' => 0,
				'position'   => 'normal',
				'active'     => true,
			)
		);
	},
	20
);

add_action(
	'admin_init',
	static function () {
		remove_post_type_support( 'post', 'editor' );
	}
);

/**
 * Render article from ACF.
 *
 * @param int $post_id ID.
 */
function alba_render_article( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$lead    = (string) ( get_field( 'field_art_lead', $post_id ) ?: get_field( 'lead', $post_id ) ?: get_the_excerpt( $post_id ) );
	$cover   = (string) ( get_field( 'field_art_cover', $post_id ) ?: get_field( 'cover_url', $post_id ) );
	if ( ! $cover && has_post_thumbnail( $post_id ) ) {
		$cover = get_the_post_thumbnail_url( $post_id, 'large' );
	}
	if ( $cover && function_exists( 'alba_media_url' ) ) {
		$cover = alba_media_url( $cover );
	}
	$blocks = get_field( 'field_art_body', $post_id );
	if ( ! is_array( $blocks ) || ! $blocks ) {
		$blocks = get_field( 'body_blocks', $post_id );
	}
	$cta_h = (string) ( get_field( 'field_art_cta_h', $post_id ) ?: get_field( 'cta_title', $post_id ) ?: 'Нужна консультация врача?' );
	$cta_t = (string) ( get_field( 'field_art_cta_t', $post_id ) ?: get_field( 'cta_text', $post_id ) ?: 'Дежурный специалист на связи 24/7. Можно без имени. 18+.' );

	// Short meta under H1 (not the long SEO lead — that goes into the article body).
	$meta_line = get_the_date( 'j F Y', $post_id );
	$title     = get_the_title( $post_id );
	?>
	<section class="article-hero wrap">
		<div class="article-hero__inner">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / <a href="<?php echo esc_url( alba_city_url( 'articles' ) ); ?>">Статьи</a> / <?php echo esc_html( $title ); ?></div>
				<h1 class="split"><?php echo function_exists( 'alba_title_br' ) ? alba_title_br( $title ) : esc_html( $title ); // phpcs:ignore ?></h1>
			</div>
			<?php if ( $meta_line ) : ?><p><?php echo esc_html( $meta_line ); ?></p><?php endif; ?>
		</div>
	</section>

	<article class="article-body wrap" data-reveal>
		<?php if ( $cover ) : ?>
			<img class="article-cover" src="<?php echo esc_url( $cover ); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<?php if ( $lead ) : ?>
			<p><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>
		<?php
		if ( is_array( $blocks ) && $blocks ) {
			foreach ( $blocks as $b ) {
				$h  = $b['heading'] ?? '';
				$ps = function_exists( 'alba_lines' ) ? alba_lines( $b['paragraphs'] ?? array() ) : array();
				$ls = function_exists( 'alba_lines' ) ? alba_lines( $b['list'] ?? array() ) : array();
				if ( $h ) {
					echo '<h2>' . esc_html( $h ) . '</h2>';
				}
				foreach ( $ps as $p ) {
					// Skip duplicate of lead if parser put the same text as first paragraph.
					if ( $lead && 0 === strcasecmp( trim( $p ), trim( $lead ) ) ) {
						continue;
					}
					echo '<p>' . esc_html( $p ) . '</p>';
				}
				if ( $ls ) {
					echo '<ul>';
					foreach ( $ls as $li ) {
						echo '<li>' . esc_html( $li ) . '</li>';
					}
					echo '</ul>';
				}
			}
		}
		?>
	</article>

	<section class="cta wrap">
		<div class="cta__box" data-reveal="scale">
			<div>
				<h2><?php echo esc_html( $cta_h ); ?></h2>
				<?php if ( $cta_t ) : ?><p><?php echo esc_html( $cta_t ); ?></p><?php endif; ?>
			</div>
			<div class="cta__actions">
				<a class="btn btn--light" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( alba_get_current_city()['tel'] ?? '' ); ?>" data-city-tel>Позвонить: <span data-city-phone><?php echo esc_html( alba_get_current_city()['phone'] ?? '' ); ?></span></a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Seed articles from legacy-html/article-*.html into ACF.
 *
 * @param bool $force Force.
 * @return array
 */
function alba_seed_articles_acf( $force = true ) {
	if ( ! function_exists( 'update_field' ) ) {
		return array( 'error' => 'ACF missing' );
	}
	$dir   = trailingslashit( ABSPATH ) . 'legacy-html/';
	$files = glob( $dir . 'article-*.html' ) ?: array();
	$stats = array( 'updated' => 0, 'skipped' => 0 );

	$catalog = array(
		'article-detox'  => array(
			'title' => 'Как проходит детокс в первые трое суток',
			'date'  => '2026-08-12',
			'cover' => 'images/clinic-room.jpg',
			'seo'   => 'Детокс в клинике Альба: первые трое суток, капельница, наблюдение врача. Анонимно, 18+.',
		),
		'article-anon'   => array(
			'title' => 'Анонимность: что клиника может обещать юридически',
			'date'  => '2026-07-28',
			'cover' => 'images/clinic-consult.jpg',
			'seo'   => 'Анонимное лечение зависимости: псевдоним, врачебная тайна, работодатель и родственники.',
		),
		'article-family' => array(
			'title' => 'Если пьёт близкий: что говорить и чего не делать',
			'date'  => '2026-06-04',
			'cover' => 'images/clinic-bright.jpg',
			'seo'   => 'Как помочь близкому с зависимостью без давления и ультиматумов. Советы семейного терапевта.',
		),
	);

	foreach ( $files as $file ) {
		$slug = basename( $file, '.html' );
		$html = (string) file_get_contents( $file );
		$meta = $catalog[ $slug ] ?? array(
			'title' => $slug,
			'date'  => current_time( 'Y-m-d' ),
			'cover' => 'images/clinic-hall.jpg',
			'seo'   => '',
		);

		$post = get_page_by_path( $slug, OBJECT, 'post' );
		$args = array(
			'post_type'    => 'post',
			'post_name'    => $slug,
			'post_title'   => $meta['title'],
			'post_status'  => 'publish',
			'post_content' => '',
			'post_date'    => $meta['date'] . ' 10:00:00',
		);

		// Extract description / lead.
		$lead = '';
		if ( preg_match( '/<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $mm ) ) {
			$lead = trim( html_entity_decode( $mm[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
		}
		if ( preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
			$main = $m[1];
		} else {
			$main = $html;
		}
		if ( ! $lead && preg_match( '/<p>([\s\S]*?)<\/p>/i', $main, $pm ) ) {
			$lead = trim( wp_strip_all_tags( $pm[1] ) );
		}
		$args['post_excerpt'] = $lead;

		if ( $post ) {
			// Skip only when body has real paragraphs (not empty layout shells).
			if ( ! $force ) {
				$existing = get_field( 'field_art_body', $post->ID );
				$has_text = false;
				if ( is_array( $existing ) ) {
					foreach ( $existing as $row ) {
						if ( ! empty( $row['paragraphs'] ) || ! empty( $row['heading'] ) ) {
							$has_text = true;
							break;
						}
					}
				}
				if ( $has_text ) {
					$stats['skipped']++;
					continue;
				}
			}
			$args['ID'] = $post->ID;
			$id         = wp_update_post( $args, true );
		} else {
			$id = wp_insert_post( $args, true );
		}
		if ( is_wp_error( $id ) || ! $id ) {
			$stats['skipped']++;
			continue;
		}

		delete_post_meta( $id, '_alba_legacy_file' );
		wp_update_post( array( 'ID' => $id, 'post_content' => '' ) );

		// Clear wrong field-key references from name collisions (service/home).
		foreach ( array( 'lead', 'cover_url', 'body_blocks', 'cta_title', 'cta_text' ) as $broken ) {
			delete_post_meta( $id, '_' . $broken );
			delete_post_meta( $id, $broken );
		}

		$blocks = alba_parse_article_html_blocks( $main );
		if ( function_exists( 'alba_update_field_key' ) ) {
			alba_update_field_key( 'field_art_lead', $lead, $id );
			alba_update_field_key( 'field_art_cover', $meta['cover'], $id );
			alba_update_field_key( 'field_art_body', $blocks, $id );
			alba_update_field_key( 'field_art_cta_h', 'Нужна консультация врача?', $id );
			alba_update_field_key( 'field_art_cta_t', 'Дежурный специалист на связи 24/7. Можно без имени. 18+.', $id );
			alba_update_field_key( 'field_seo_title', $meta['title'] . ' — клиника Альба', $id );
			alba_update_field_key( 'field_seo_desc', $meta['seo'] ?: $lead, $id );
			alba_update_field_key( 'field_seo_img', $meta['cover'], $id );
		} else {
			update_field( 'field_art_lead', $lead, $id );
			update_field( 'field_art_cover', $meta['cover'], $id );
			update_field( 'field_art_body', $blocks, $id );
			update_field( 'field_art_cta_h', 'Нужна консультация врача?', $id );
			update_field( 'field_art_cta_t', 'Дежурный специалист на связи 24/7. Можно без имени. 18+.', $id );
			update_field( 'field_seo_title', $meta['title'] . ' — клиника Альба', $id );
			update_field( 'field_seo_desc', $meta['seo'] ?: $lead, $id );
			update_field( 'field_seo_img', $meta['cover'], $id );
		}
		$stats['updated']++;
	}

	// Trash hello world.
	$hello = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $hello ) {
		wp_trash_post( $hello->ID );
	}

	return $stats;
}

/**
 * Parse article main HTML into body_blocks.
 *
 * @param string $main HTML.
 * @return array
 */
function alba_parse_article_html_blocks( $main ) {
	$blocks = array();
	// Prefer svc-article / article body.
	if ( preg_match( '/<(?:article|div)[^>]*class="[^"]*(?:svc-article|article-body|entry)[^"]*"[^>]*>([\s\S]*?)<\/(?:article|div)>/i', $main, $m ) ) {
		$chunk = $m[1];
	} else {
		$chunk = $main;
		$chunk = preg_replace( '/<section[^>]*class="[^"]*page-(?:intro|hero)[^"]*"[^>]*>[\s\S]*?<\/section>/i', '', $chunk );
		$chunk = preg_replace( '/<section[^>]*class="[^"]*cta[^"]*"[^>]*>[\s\S]*?<\/section>/i', '', $chunk );
	}

	$parts = preg_split( '/(?=<h2\b)/i', $chunk );
	foreach ( $parts as $part ) {
		$part = trim( $part );
		if ( ! $part || ! trim( wp_strip_all_tags( $part ) ) ) {
			continue;
		}
		$h  = '';
		$ps = array();
		$ls = array();
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $part, $hm ) ) {
			$h = trim( wp_strip_all_tags( $hm[1] ) );
		}
		if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $part, $pm ) ) {
			foreach ( $pm[1] as $p ) {
				$t = trim( wp_strip_all_tags( $p ) );
				if ( $t ) {
					$ps[] = array( 'text' => $t );
				}
			}
		}
		if ( preg_match_all( '/<li[^>]*>([\s\S]*?)<\/li>/i', $part, $lm ) ) {
			foreach ( $lm[1] as $li ) {
				$t = trim( wp_strip_all_tags( $li ) );
				if ( $t ) {
					$ls[] = array( 'text' => $t );
				}
			}
		}
		if ( ! $h && ! $ps && ! $ls ) {
			continue;
		}
		$blocks[] = array(
			'acf_fc_layout' => 'text',
			'heading'       => $h,
			'paragraphs'    => $ps,
			'list'          => $ls,
		);
	}

	if ( ! $blocks ) {
		$t = trim( wp_strip_all_tags( $chunk ) );
		if ( $t ) {
			$blocks[] = array(
				'acf_fc_layout' => 'text',
				'heading'       => '',
				'paragraphs'    => array( array( 'text' => wp_trim_words( $t, 80 ) ) ),
				'list'          => array(),
			);
		}
	}
	return $blocks;
}
