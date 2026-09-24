<?php
/**
 * Full programs catalog: taxonomy seed, query, filter helpers.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Direction + format term definitions for service_cat.
 *
 * @return array{directions: array<string,string>, formats: array<string,string>}
 */
function alba_catalog_term_defs() {
	return array(
		'directions' => array(
			'alcohol'     => 'Алкоголизм / запой',
			'drugs'       => 'Наркомания',
			'psychiatry'  => 'Психиатрия',
			'coding'      => 'Кодирование',
			'detox'       => 'Детокс / стационар',
			'rehab'       => 'Реабилитация',
			'therapy'     => 'Психотерапия / семья',
			'online-dir'  => 'Онлайн',
			'urgent'      => 'Срочная помощь / выезд',
		),
		'formats'    => array(
			'stationary' => 'Стационар',
			'home'       => 'На дому',
			'ambulatory' => 'Амбулаторно',
			'online'     => 'Онлайн',
		),
	);
}

/**
 * Map post slug → direction + format term slugs.
 *
 * @param string $slug Post slug.
 * @param string $title Post title.
 * @return array{0: string[], 1: string[]} Directions, formats.
 */
function alba_catalog_map_slug( $slug, $title = '' ) {
	$slug  = sanitize_title( $slug );
	$title = mb_strtolower( (string) $title );
	$dirs  = array();
	$fmts  = array();

	if ( preg_match( '/^(alcohol|zapoy)/', $slug ) || false !== strpos( $slug, 'zapoy' ) ) {
		$dirs[] = 'alcohol';
	}
	if ( preg_match( '/^(drugs|drugtest)/', $slug ) || in_array( $slug, array( 'withdrawal', 'ubod', 'toxicologist' ), true ) ) {
		$dirs[] = 'drugs';
	}
	if ( preg_match( '/^(psy|psychiatry)/', $slug ) || in_array( $slug, array( 'alzheimer', 'dementia' ), true ) ) {
		$dirs[] = 'psychiatry';
	}
	if ( preg_match( '/^(code|decode)/', $slug ) || 'alcohol-shot' === $slug ) {
		$dirs[] = 'coding';
	}
	if ( in_array( $slug, array( 'detox', 'sober' ), true ) || preg_match( '/^zapoy/', $slug ) ) {
		$dirs[] = 'detox';
	}
	if ( preg_match( '/^rehab/', $slug ) ) {
		$dirs[] = 'rehab';
	}
	if ( in_array( $slug, array( 'family', 'psy-parenting', 'psy-compat', 'psy-counseling', 'psy-growth', 'psy-relatives', 'psy-psychologist', 'psy-emotion' ), true )
		|| false !== strpos( $title, 'психотерап' )
		|| false !== strpos( $title, 'семейн' ) ) {
		$dirs[] = 'therapy';
	}
	if ( 'psy-online' === $slug || false !== strpos( $slug, 'online' ) ) {
		$dirs[] = 'online-dir';
		$fmts[] = 'online';
	}
	if ( in_array( $slug, array( 'visit', 'ambulance', 'help', 'zapoy', 'withdrawal', 'toxicologist', 'ubod', 'sober' ), true )
		|| preg_match( '/^zapoy-/', $slug ) ) {
		$dirs[] = 'urgent';
	}
	if ( in_array( $slug, array( 'consult', 'check', 'betting', 'gambling' ), true ) && ! $dirs ) {
		$dirs[] = 'alcohol';
	}

	// Formats.
	if ( preg_match( '/(-home|^visit$|psy-home)/', $slug ) || false !== strpos( $title, 'на дом' ) ) {
		$fmts[] = 'home';
	}
	if ( in_array( $slug, array( 'detox', 'sober', 'psy-hospital' ), true )
		|| preg_match( '/^(zapoy-|rehab)/', $slug )
		|| false !== strpos( $title, 'стационар' ) ) {
		$fmts[] = 'stationary';
	}
	if ( 'psy-online' === $slug || false !== strpos( $slug, 'online' ) ) {
		$fmts[] = 'online';
	}
	if ( ! $fmts ) {
		$fmts[] = 'ambulatory';
	}

	$dirs = array_values( array_unique( $dirs ) );
	$fmts = array_values( array_unique( $fmts ) );
	if ( ! $dirs ) {
		$dirs[] = 'psychiatry';
	}

	return array( $dirs, $fmts );
}

/**
 * Full pool of catalog illustrations (transparent webp icons).
 *
 * @return string[]
 */
function alba_catalog_icon_pool() {
	return array(
		'images/icon-detox.webp',
		'images/icon-consult.webp',
		'images/icon-family.webp',
		'images/icon-rehab.webp',
		'images/icon-shield.webp',
		'images/icon-check.webp',
		'images/icon-people.webp',
		'images/icon-pills.webp',
		'images/icon-clipboard.webp',
		'images/icon-monitor.webp',
		'images/icon-capsule.webp',
	);
}

/**
 * Direction → preferred icon subset (rotated by post id for variety).
 *
 * @param string $direction_slug Direction term slug.
 * @return string[]
 */
function alba_catalog_icons_for_direction( $direction_slug ) {
	$map = array(
		'alcohol'    => array( 'images/icon-detox.webp', 'images/icon-pills.webp', 'images/icon-capsule.webp', 'images/icon-check.webp' ),
		'drugs'      => array( 'images/icon-shield.webp', 'images/icon-pills.webp', 'images/icon-capsule.webp', 'images/icon-people.webp' ),
		'psychiatry' => array( 'images/icon-consult.webp', 'images/icon-clipboard.webp', 'images/icon-monitor.webp', 'images/icon-people.webp' ),
		'coding'     => array( 'images/icon-capsule.webp', 'images/icon-check.webp', 'images/icon-pills.webp', 'images/icon-shield.webp' ),
		'detox'      => array( 'images/icon-detox.webp', 'images/icon-rehab.webp', 'images/icon-consult.webp', 'images/icon-pills.webp' ),
		'rehab'      => array( 'images/icon-rehab.webp', 'images/icon-family.webp', 'images/icon-people.webp', 'images/icon-clipboard.webp' ),
		'therapy'    => array( 'images/icon-family.webp', 'images/icon-people.webp', 'images/icon-consult.webp', 'images/icon-clipboard.webp' ),
		'online-dir' => array( 'images/icon-monitor.webp', 'images/icon-consult.webp', 'images/icon-clipboard.webp' ),
		'urgent'     => array( 'images/icon-detox.webp', 'images/icon-shield.webp', 'images/icon-monitor.webp', 'images/icon-people.webp' ),
	);
	return $map[ $direction_slug ] ?? alba_catalog_icon_pool();
}

/**
 * Stable icon for a post — varies within direction so neighbours differ.
 *
 * @param int    $post_id Post ID.
 * @param string $direction_slug Primary direction.
 * @param string $slug Post slug.
 * @return string
 */
function alba_catalog_icon_for_post( $post_id, $direction_slug = '', $slug = '' ) {
	if ( 'psy-online' === $slug ) {
		return 'images/icon-monitor.webp';
	}
	$pool = alba_catalog_icons_for_direction( $direction_slug );
	if ( ! $pool ) {
		$pool = alba_catalog_icon_pool();
	}
	$idx = abs( (int) $post_id ) % count( $pool );
	return $pool[ $idx ];
}

/**
 * Icon path by primary direction slug (legacy helper).
 *
 * @param string $direction_slug Direction term slug.
 * @return string
 */
function alba_catalog_icon_for_direction( $direction_slug ) {
	$pool = alba_catalog_icons_for_direction( $direction_slug );
	return $pool[0] ?? 'images/icon-consult.webp';
}

/**
 * Whether service is hidden for current city.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function alba_catalog_is_hidden( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}
	$city      = alba_get_current_city();
	$overrides = get_field( 'city_overrides', $post_id );
	if ( ! is_array( $overrides ) ) {
		return false;
	}
	foreach ( $overrides as $row ) {
		$row_slug = sanitize_title( $row['city_slug'] ?? ( $row['slug'] ?? '' ) );
		if ( $row_slug && $row_slug === $city['slug'] && ! empty( $row['ov_hide'] ) ) {
			return true;
		}
	}
	return false;
}

/**
 * IDs hidden in the current city.
 *
 * @return int[]
 */
function alba_catalog_hidden_ids() {
	static $ids = null;
	if ( null !== $ids ) {
		return $ids;
	}
	$ids   = array();
	$posts = get_posts(
		array(
			'post_type'      => array( 'service', 'program' ),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);
	foreach ( $posts as $id ) {
		if ( alba_catalog_is_hidden( (int) $id ) ) {
			$ids[] = (int) $id;
		}
	}
	return $ids;
}

/**
 * Parse filter request from GET.
 *
 * @return array{q: string, directions: string[], formats: string[], paged: int}
 */
function alba_catalog_parse_request() {
	$defs = alba_catalog_term_defs();
	$src  = array_merge( $_GET, $_POST ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended,WordPress.Security.NonceVerification.Missing
	$q    = isset( $src['q'] ) ? sanitize_text_field( wp_unslash( $src['q'] ) ) : '';

	$directions = array();
	if ( isset( $src['direction'] ) ) {
		$raw = wp_unslash( $src['direction'] );
		if ( ! is_array( $raw ) ) {
			$raw = array( $raw );
		}
		foreach ( $raw as $slug ) {
			$slug = sanitize_title( $slug );
			if ( isset( $defs['directions'][ $slug ] ) ) {
				$directions[] = $slug;
			}
		}
	}

	$formats = array();
	if ( isset( $src['format'] ) ) {
		$raw = wp_unslash( $src['format'] );
		if ( ! is_array( $raw ) ) {
			$raw = array( $raw );
		}
		foreach ( $raw as $slug ) {
			$slug = sanitize_title( $slug );
			if ( isset( $defs['formats'][ $slug ] ) ) {
				$formats[] = $slug;
			}
		}
	}

	$paged = 1;
	if ( isset( $src['paged'] ) ) {
		$paged = max( 1, (int) $src['paged'] );
	}

	return array(
		'q'          => $q,
		'directions' => array_values( array_unique( $directions ) ),
		'formats'    => array_values( array_unique( $formats ) ),
		'paged'      => $paged,
	);
}

/**
 * Base query args without pagination (for filtered ID sets).
 *
 * @param array $req Parsed request.
 * @return array
 */
function alba_catalog_base_args( $req ) {
	$tax    = array();
	$hidden = alba_catalog_hidden_ids();

	if ( ! empty( $req['directions'] ) ) {
		$tax[] = array(
			'taxonomy' => 'service_cat',
			'field'    => 'slug',
			'terms'    => $req['directions'],
			'operator' => 'IN',
		);
	}
	if ( ! empty( $req['formats'] ) ) {
		$tax[] = array(
			'taxonomy' => 'service_cat',
			'field'    => 'slug',
			'terms'    => $req['formats'],
			'operator' => 'IN',
		);
	}

	$args = array(
		'post_type'           => array( 'service', 'program' ),
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'fields'              => 'ids',
		'orderby'             => 'title',
		'order'               => 'ASC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $hidden ) {
		$args['post__not_in'] = $hidden;
	}

	if ( count( $tax ) > 1 ) {
		$args['tax_query'] = array_merge( array( 'relation' => 'AND' ), $tax ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	} elseif ( 1 === count( $tax ) ) {
		$args['tax_query'] = $tax; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	return $args;
}

/**
 * Primary direction slug for a post.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function alba_catalog_primary_direction( $post_id ) {
	$defs  = alba_catalog_term_defs();
	$terms = get_the_terms( $post_id, 'service_cat' );
	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( isset( $defs['directions'][ $term->slug ] ) ) {
				return $term->slug;
			}
		}
	}
	return '';
}

/**
 * Interleave post IDs so neighbouring cards rarely share the same icon.
 *
 * @param int[] $ids Post IDs.
 * @return int[]
 */
function alba_catalog_interleave_ids( $ids ) {
	if ( count( $ids ) < 2 ) {
		return $ids;
	}
	$buckets = array();
	foreach ( $ids as $id ) {
		$id   = (int) $id;
		$dir  = alba_catalog_primary_direction( $id );
		$slug = (string) get_post_field( 'post_name', $id );
		$icon = alba_catalog_icon_for_post( $id, $dir, $slug );
		if ( ! isset( $buckets[ $icon ] ) ) {
			$buckets[ $icon ] = array();
		}
		$buckets[ $icon ][] = $id;
	}

	$out   = array();
	$prev  = '';
	$total = count( $ids );
	while ( count( $out ) < $total ) {
		$progress = false;
		foreach ( $buckets as $icon => &$list ) {
			if ( ! $list ) {
				continue;
			}
			if ( $icon === $prev && count( array_filter( $buckets ) ) > 1 ) {
				continue;
			}
			$out[] = array_shift( $list );
			$prev  = $icon;
			$progress = true;
		}
		unset( $list );
		if ( ! $progress ) {
			foreach ( $buckets as $icon => &$list ) {
				if ( $list ) {
					$out[] = array_shift( $list );
					$prev  = $icon;
					break;
				}
			}
			unset( $list );
		}
	}
	return $out;
}

/**
 * Matching post IDs for request, interleaved by icon.
 *
 * @param array $req Parsed request.
 * @return int[]
 */
function alba_catalog_matching_ids( $req ) {
	$args  = alba_catalog_base_args( $req );
	$q_str = trim( (string) ( $req['q'] ?? '' ) );
	if ( $q_str ) {
		$args['alba_title_search'] = $q_str;
		$filter                    = function ( $where, $query ) use ( $q_str ) {
			global $wpdb;
			if ( empty( $query->query_vars['alba_title_search'] ) ) {
				return $where;
			}
			$like = '%' . $wpdb->esc_like( $q_str ) . '%';
			$where .= $wpdb->prepare( " AND {$wpdb->posts}.post_title LIKE %s ", $like );
			return $where;
		};
		add_filter( 'posts_where', $filter, 10, 2 );
		$query = new WP_Query( $args );
		remove_filter( 'posts_where', $filter, 10 );
	} else {
		$query = new WP_Query( $args );
	}
	$ids = array_map( 'intval', $query->posts );
	return alba_catalog_interleave_ids( $ids );
}

/**
 * Build catalog WP_Query from request (interleaved icons, paginated).
 *
 * @param array|null $req Parsed request or null to parse GET.
 * @return WP_Query
 */
function alba_catalog_query( $req = null ) {
	$req   = is_array( $req ) ? $req : alba_catalog_parse_request();
	$per   = 24;
	$paged = max( 1, (int) $req['paged'] );
	$ids   = alba_catalog_matching_ids( $req );
	$total = count( $ids );
	$slice = array_slice( $ids, ( $paged - 1 ) * $per, $per );

	if ( ! $slice ) {
		$empty                = new WP_Query( array( 'post__in' => array( 0 ), 'posts_per_page' => 1 ) );
		$empty->posts         = array();
		$empty->post_count    = 0;
		$empty->found_posts   = $total;
		$empty->max_num_pages = $total ? (int) ceil( $total / $per ) : 0;
		return $empty;
	}

	$query                = new WP_Query(
		array(
			'post_type'           => array( 'service', 'program' ),
			'post_status'         => 'publish',
			'post__in'            => $slice,
			'orderby'             => 'post__in',
			'posts_per_page'      => count( $slice ),
			'ignore_sticky_posts' => true,
		)
	);
	$query->found_posts   = $total;
	$query->max_num_pages = (int) ceil( $total / $per );
	return $query;
}

/**
 * Ensure taxonomy terms exist and assign all services/programs once.
 *
 * @param bool $force Re-assign even if already seeded.
 * @return array{terms: int, posts: int}
 */
function alba_catalog_seed( $force = false ) {
	$option = 'alba_catalog_seeded_v1';
	if ( ! $force && get_option( $option ) ) {
		return array(
			'terms' => 0,
			'posts' => 0,
		);
	}

	$defs = alba_catalog_term_defs();
	foreach ( array_merge( $defs['directions'], $defs['formats'] ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'service_cat' ) ) {
			wp_insert_term( $name, 'service_cat', array( 'slug' => $slug ) );
		} else {
			$term = get_term_by( 'slug', $slug, 'service_cat' );
			if ( $term && ! is_wp_error( $term ) && $term->name !== $name ) {
				wp_update_term( (int) $term->term_id, 'service_cat', array( 'name' => $name ) );
			}
		}
	}

	$posts = get_posts(
		array(
			'post_type'      => array( 'service', 'program' ),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		)
	);
	$count = 0;
	foreach ( $posts as $post ) {
		list( $dirs, $fmts ) = alba_catalog_map_slug( $post->post_name, $post->post_title );
		$slugs               = array_merge( $dirs, $fmts );
		wp_set_object_terms( (int) $post->ID, $slugs, 'service_cat', false );
		++$count;
	}

	update_option( $option, time(), false );

	return array(
		'terms' => count( $defs['directions'] ) + count( $defs['formats'] ),
		'posts' => $count,
	);
}

/**
 * Auto-seed on init if not done.
 */
add_action(
	'init',
	function () {
		alba_catalog_seed( false );
	},
	30
);

/**
 * Build catalog action URL (current programs page without filter query).
 *
 * @return string
 */
function alba_catalog_form_action() {
	return alba_city_url( 'programs' );
}

/**
 * Card data for a service/program post.
 *
 * @param int $post_id Post ID.
 * @return array{badge: string, title: string, text: string, price: string, url: string, icon: string, accent: bool}
 */
function alba_catalog_card_from_post( $post_id ) {
	$post_id = (int) $post_id;
	$lead    = '';
	if ( function_exists( 'get_field' ) ) {
		$lead = (string) ( get_field( 'lead', $post_id ) ?: '' );
	}
	if ( ! $lead ) {
		$lead = (string) get_the_excerpt( $post_id );
	}
	if ( mb_strlen( $lead ) > 140 ) {
		$lead = mb_substr( $lead, 0, 137 ) . '…';
	}

	$price = function_exists( 'alba_field' ) ? (string) alba_field( 'price_label', $post_id, '' ) : '';
	$terms = get_the_terms( $post_id, 'service_cat' );
	$badge = '';
	$dir   = '';
	$defs  = alba_catalog_term_defs();
	if ( is_array( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( isset( $defs['directions'][ $term->slug ] ) ) {
				$badge = $term->name;
				$dir   = $term->slug;
				break;
			}
		}
	}
	if ( ! $badge ) {
		$badge = '18+, добровольно';
	}

	$slug = get_post_field( 'post_name', $post_id );
	$icon = alba_catalog_icon_for_post( $post_id, $dir, $slug );
	$type = get_post_type( $post_id );
	$city = alba_get_current_city()['slug'];
	$url  = home_url( '/' . $city . '/' . ( 'program' === $type ? 'program' : 'service' ) . '/' . $slug . '/' );

	return array(
		'badge'  => $badge,
		'title'  => get_the_title( $post_id ),
		'text'   => $lead,
		'price'  => $price,
		'url'    => $url,
		'icon'   => $icon,
		'accent' => false,
	);
}

/**
 * Render catalog grid + pager HTML.
 *
 * @param WP_Query $query Query.
 * @param array    $req Parsed request.
 * @param string   $form_action Base URL.
 */
function alba_catalog_render_results( $query, $req, $form_action = '' ) {
	$form_action = $form_action ? $form_action : alba_catalog_form_action();
	$items       = array();
	while ( $query->have_posts() ) {
		$query->the_post();
		$items[] = alba_catalog_card_from_post( get_the_ID() );
	}
	wp_reset_postdata();

	$total     = (int) $query->found_posts;
	$max_pages = max( 1, (int) $query->max_num_pages );
	$paged     = max( 1, (int) ( $req['paged'] ?? 1 ) );

	if ( ! $items || $total < 1 ) {
		echo '<p class="catalog-empty">Ничего не найдено. Измените фильтры или <a href="' . esc_url( $form_action ) . '#catalog">сбросьте поиск</a>.</p>';
		return;
	}
	?>
	<div class="catalog">
		<?php foreach ( $items as $card ) :
			$href   = $card['url'] ?? '#';
			$accent = ! empty( $card['accent'] ) ? ' cat-card--accent' : '';
			$icon   = function_exists( 'alba_media_url' ) ? alba_media_url( $card['icon'] ?? '' ) : ( $card['icon'] ?? '' );
			?>
			<a class="cat-card<?php echo esc_attr( $accent ); ?>" href="<?php echo esc_url( $href ); ?>">
				<?php if ( ! empty( $card['badge'] ) ) : ?><span><?php echo esc_html( $card['badge'] ); ?></span><?php endif; ?>
				<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $card['text'] ) ) : ?><p><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
				<?php if ( ! empty( $card['price'] ) ) : ?><b><?php echo esc_html( $card['price'] ); ?></b><?php endif; ?>
				<?php if ( $icon ) : ?><img src="<?php echo esc_url( $icon ); ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
	<?php if ( $max_pages > 1 ) : ?>
		<nav class="catalog-pager" aria-label="Страницы каталога">
			<?php
			$base_args = array();
			if ( ! empty( $req['q'] ) ) {
				$base_args['q'] = $req['q'];
			}
			foreach ( $req['directions'] as $d ) {
				$base_args['direction'][] = $d;
			}
			foreach ( $req['formats'] as $f ) {
				$base_args['format'][] = $f;
			}
			for ( $i = 1; $i <= $max_pages; $i++ ) :
				$args = $base_args;
				if ( $i > 1 ) {
					$args['paged'] = $i;
				}
				$link = add_query_arg( $args, $form_action ) . '#catalog';
				$cls  = $i === $paged ? ' is-current' : '';
				?>
				<a class="catalog-pager__link<?php echo esc_attr( $cls ); ?>" href="<?php echo esc_url( $link ); ?>" data-catalog-page="<?php echo esc_attr( (string) $i ); ?>"<?php echo $i === $paged ? ' aria-current="page"' : ''; ?>><?php echo esc_html( (string) $i ); ?></a>
			<?php endfor; ?>
		</nav>
	<?php endif;
}

/**
 * AJAX: filter catalog without full page reload.
 */
function alba_catalog_ajax() {
	if ( isset( $_REQUEST['city'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$slug = sanitize_title( wp_unslash( $_REQUEST['city'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $slug && alba_get_city_by_slug( $slug ) ) {
			set_query_var( 'alba_city', $slug );
			// Reset static cache in alba_get_current_city via filter workaround:
			$GLOBALS['alba_force_city_slug'] = $slug;
		}
	}
	$req = alba_catalog_parse_request();
	$query = alba_catalog_query( $req );
	ob_start();
	alba_catalog_render_results( $query, $req );
	$html = ob_get_clean();
	wp_send_json_success(
		array(
			'html'  => $html,
			'total' => (int) $query->found_posts,
			'paged' => (int) $req['paged'],
			'pages' => (int) $query->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_alba_catalog', 'alba_catalog_ajax' );
add_action( 'wp_ajax_nopriv_alba_catalog', 'alba_catalog_ajax' );
