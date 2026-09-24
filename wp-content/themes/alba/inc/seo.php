<?php
/**
 * SEO: titles, meta description, Open Graph, Schema.org.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Per-entity SEO payload.
 *
 * @param int $post_id Post ID.
 * @return array{title:string,description:string,image:string,type:string,url:string}
 */
function alba_seo_data( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : (int) get_queried_object_id();
	$city    = function_exists( 'alba_get_current_city' ) ? alba_get_current_city() : array( 'name' => 'Омск', 'prep' => 'в Омске' );
	$site    = 'Альба';
	$title   = '';
	$desc    = '';
	$image   = home_url( '/images/clinic-hall.jpg' );
	$type    = 'website';
	$url     = function_exists( 'alba_city_url' ) ? alba_city_url() : home_url( '/' );

	if ( $post_id ) {
		$url = get_permalink( $post_id );
		if ( function_exists( 'alba_get_current_city' ) && ! is_admin() ) {
			// Prefer city-prefixed URL when available.
			$req = isset( $_SERVER['REQUEST_URI'] ) ? home_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : $url;
			if ( $req ) {
				$url = $req;
			}
		}

		$acf_title = function_exists( 'get_field' ) ? (string) get_field( 'seo_title', $post_id ) : '';
		$acf_desc  = function_exists( 'get_field' ) ? (string) get_field( 'seo_description', $post_id ) : '';
		$acf_img   = function_exists( 'get_field' ) ? (string) get_field( 'seo_image', $post_id ) : '';
		$hero      = function_exists( 'get_field' ) ? (string) get_field( 'hero_title', $post_id ) : '';
		$lead      = function_exists( 'get_field' ) ? (string) get_field( 'hero_lead', $post_id ) : '';
		if ( ! $lead && function_exists( 'get_field' ) ) {
			$lead = (string) get_field( 'lead', $post_id );
		}

		$title = $acf_title ?: ( $hero ? str_replace( '|', ' ', $hero ) : get_the_title( $post_id ) );
		$desc  = $acf_desc ?: ( $lead ?: (string) get_post_field( 'post_excerpt', $post_id ) );
		if ( ! $desc ) {
			$desc = wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) ), 28 );
		}

		if ( $acf_img ) {
			$image = function_exists( 'alba_media_url' ) ? alba_media_url( $acf_img ) : $acf_img;
		} elseif ( has_post_thumbnail( $post_id ) ) {
			$image = (string) get_the_post_thumbnail_url( $post_id, 'large' );
		} elseif ( function_exists( 'get_field' ) ) {
			$cover = (string) get_field( 'cover_url', $post_id );
			if ( $cover ) {
				$image = function_exists( 'alba_media_url' ) ? alba_media_url( $cover ) : $cover;
			}
		}

		$ptype = get_post_type( $post_id );
		$type  = in_array( $ptype, array( 'post', 'service', 'program', 'doctor' ), true ) ? 'article' : 'website';
	} else {
		$title = get_bloginfo( 'name' );
		$desc  = get_bloginfo( 'description' );
	}

	$title = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $title ) ) );
	$desc  = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $desc ) ) );

	// Enrich title with city for local SEO when not already present.
	$city_name = $city['name'] ?? '';
	if ( $title && $city_name && false === mb_stripos( $title, $city_name ) && false === mb_stripos( $title, $site ) ) {
		$title = $title . ' — ' . $site . ' ' . ( $city['prep'] ?? ( 'в ' . $city_name ) );
	} elseif ( $title && false === mb_stripos( $title, $site ) ) {
		$title = $title . ' — ' . $site;
	}

	if ( ! $desc ) {
		$prep = $city['prep'] ?? 'в регионе';
		$desc = 'Наркологическая клиника «Альба» ' . $prep . ': анонимная помощь 24/7, детокс, кодирование и реабилитация. 18+, добровольно.';
	}
	if ( mb_strlen( $desc ) > 180 ) {
		$desc = mb_substr( $desc, 0, 177 ) . '…';
	}

	return array(
		'title'       => $title,
		'description' => $desc,
		'image'       => $image,
		'type'        => $type,
		'url'         => $url,
	);
}

add_filter(
	'pre_get_document_title',
	static function ( $title ) {
		if ( is_admin() ) {
			return $title;
		}
		$data = alba_seo_data();
		return $data['title'] ?: $title;
	},
	20
);

add_action(
	'wp_head',
	static function () {
		if ( is_admin() ) {
			return;
		}
		$data = alba_seo_data();
		$city = function_exists( 'alba_get_current_city' ) ? alba_get_current_city() : array();

		echo '<meta name="description" content="' . esc_attr( $data['description'] ) . '">' . "\n";
		echo '<link rel="canonical" href="' . esc_url( $data['url'] ) . '">' . "\n";

		// Open Graph.
		echo '<meta property="og:locale" content="ru_RU">' . "\n";
		echo '<meta property="og:type" content="' . esc_attr( $data['type'] ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $data['title'] ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $data['description'] ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $data['url'] ) . '">' . "\n";
		echo '<meta property="og:site_name" content="Альба">' . "\n";
		echo '<meta property="og:image" content="' . esc_url( $data['image'] ) . '">' . "\n";
		echo '<meta property="og:image:alt" content="' . esc_attr( $data['title'] ) . '">' . "\n";

		// Twitter.
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $data['title'] ) . '">' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( $data['description'] ) . '">' . "\n";
		echo '<meta name="twitter:image" content="' . esc_url( $data['image'] ) . '">' . "\n";

		// Schema.org JSON-LD.
		$graphs = array();

		$org = array(
			'@type' => 'MedicalClinic',
			'@id'   => home_url( '/#clinic' ),
			'name'  => 'Клиника Альба',
			'url'   => home_url( '/' ),
			'image' => home_url( '/images/clinic-hall.jpg' ),
			'telephone' => $city['phone'] ?? '',
			'address'   => array(
				'@type'         => 'PostalAddress',
				'streetAddress' => $city['address'] ?? '',
				'addressLocality' => $city['name'] ?? '',
				'addressCountry'  => 'RU',
			),
			'medicalSpecialty' => 'Narcology',
			'availableService' => array(
				array( '@type' => 'MedicalTherapy', 'name' => 'Детоксикация' ),
				array( '@type' => 'MedicalTherapy', 'name' => 'Кодирование' ),
				array( '@type' => 'MedicalTherapy', 'name' => 'Реабилитация' ),
			),
		);
		if ( ! empty( $city['license'] ) ) {
			$org['identifier'] = $city['license'];
		}
		$graphs[] = $org;

		$graphs[] = array(
			'@type' => 'WebSite',
			'@id'   => home_url( '/#website' ),
			'url'   => home_url( '/' ),
			'name'  => 'Альба',
			'publisher' => array( '@id' => home_url( '/#clinic' ) ),
			'inLanguage' => 'ru-RU',
		);

		$crumbs = array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'Главная',
				'item'     => function_exists( 'alba_city_url' ) ? alba_city_url() : home_url( '/' ),
			),
		);
		$pos = 2;
		if ( is_singular() ) {
			$post_id = get_queried_object_id();
			$ptype   = get_post_type( $post_id );
			if ( 'post' === $ptype ) {
				$crumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $pos++,
					'name'     => 'Статьи',
					'item'     => function_exists( 'alba_city_url' ) ? alba_city_url( 'articles' ) : home_url( '/articles/' ),
				);
			} elseif ( in_array( $ptype, array( 'service', 'program' ), true ) ) {
				$crumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $pos++,
					'name'     => 'Программы',
					'item'     => function_exists( 'alba_city_url' ) ? alba_city_url( 'programs' ) : home_url( '/programs/' ),
				);
			} elseif ( 'doctor' === $ptype ) {
				$crumbs[] = array(
					'@type'    => 'ListItem',
					'position' => $pos++,
					'name'     => 'Врачи',
					'item'     => function_exists( 'alba_city_url' ) ? alba_city_url( 'doctors' ) : home_url( '/doctors/' ),
				);
			}
			$crumbs[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'name'     => get_the_title( $post_id ),
				'item'     => $data['url'],
			);

			if ( 'post' === $ptype || 'service' === $ptype || 'program' === $ptype ) {
				$graphs[] = array(
					'@type'            => ( 'post' === $ptype ? 'Article' : 'MedicalWebPage' ),
					'headline'         => $data['title'],
					'description'      => $data['description'],
					'image'            => $data['image'],
					'mainEntityOfPage' => $data['url'],
					'author'           => array( '@id' => home_url( '/#clinic' ) ),
					'publisher'        => array( '@id' => home_url( '/#clinic' ) ),
					'datePublished'    => get_the_date( 'c', $post_id ),
					'dateModified'     => get_the_modified_date( 'c', $post_id ),
					'inLanguage'       => 'ru-RU',
				);
			}
		} elseif ( is_page() ) {
			$crumbs[] = array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => get_the_title(),
				'item'     => $data['url'],
			);
			$graphs[] = array(
				'@type'       => 'WebPage',
				'name'        => $data['title'],
				'description' => $data['description'],
				'url'         => $data['url'],
				'isPartOf'    => array( '@id' => home_url( '/#website' ) ),
				'about'       => array( '@id' => home_url( '/#clinic' ) ),
				'inLanguage'  => 'ru-RU',
			);
		}

		$graphs[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $crumbs,
		);

		// FAQPage schema when ACF faq block / field exists.
		$faq_items = array();
		if ( is_singular( array( 'service', 'program' ) ) && function_exists( 'get_field' ) ) {
			$faq_items = get_field( 'faq', get_queried_object_id() );
		} elseif ( is_page() && function_exists( 'get_field' ) ) {
			$blocks = get_field( 'page_blocks', get_queried_object_id() );
			if ( is_array( $blocks ) ) {
				foreach ( $blocks as $block ) {
					if ( ( $block['acf_fc_layout'] ?? '' ) === 'faq' && ! empty( $block['items'] ) ) {
						$faq_items = $block['items'];
						break;
					}
				}
			}
		}
		if ( is_array( $faq_items ) && $faq_items ) {
			$main = array();
			foreach ( $faq_items as $it ) {
				$q = $it['q'] ?? $it['question'] ?? '';
				$a = $it['a'] ?? $it['answer'] ?? '';
				if ( ! $q || ! $a ) {
					continue;
				}
				$main[] = array(
					'@type'          => 'Question',
					'name'           => wp_strip_all_tags( $q ),
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $a ),
					),
				);
			}
			if ( $main ) {
				$graphs[] = array(
					'@type'      => 'FAQPage',
					'mainEntity' => $main,
				);
			}
		}

		$payload = array(
			'@context' => 'https://schema.org',
			'@graph'   => $graphs,
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	},
	5
);

/**
 * Register SEO fields on pages/posts/CPT (plain text, no HTML).
 */
add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}
		$locations = array();
		foreach ( array( 'page', 'post', 'service', 'program', 'doctor' ) as $pt ) {
			$locations[] = array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => $pt,
				),
			);
		}
		acf_add_local_field_group(
			array(
				'key'      => 'group_alba_seo',
				'title'    => 'SEO',
				'fields'   => array(
					array(
						'key'   => 'field_seo_title',
						'label' => 'SEO Title',
						'name'  => 'seo_title',
						'type'  => 'text',
						'instructions' => 'Если пусто — берётся H1 / заголовок записи',
					),
					array(
						'key'   => 'field_seo_desc',
						'label' => 'Meta Description',
						'name'  => 'seo_description',
						'type'  => 'textarea',
						'rows'  => 3,
						'instructions' => 'До ~160 символов. Если пусто — лид / excerpt',
					),
					array(
						'key'   => 'field_seo_img',
						'label' => 'OG Image URL',
						'name'  => 'seo_image',
						'type'  => 'text',
						'instructions' => '/images/… или полный URL',
					),
				),
				'location' => $locations,
				'menu_order' => 30,
				'position'   => 'side',
				'active'     => true,
			)
		);
	},
	25
);
