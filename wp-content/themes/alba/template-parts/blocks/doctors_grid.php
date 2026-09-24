<?php
/**
 * Block: doctors_grid — people swiper from CPT or ACF cards.
 *
 * @var array $b
 * @package Alba
 */
$h        = $b['heading'] ?? 'Наши специалисты';
$l        = $b['lead'] ?? '';
$from_cpt = ! isset( $b['from_cpt'] ) || $b['from_cpt'];
$items    = array();

if ( $from_cpt ) {
	$q = new WP_Query(
		array(
			'post_type'      => 'doctor',
			'posts_per_page' => 50,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);
	while ( $q->have_posts() ) {
		$q->the_post();
		$id    = get_the_ID();
		$photo = (string) get_field( 'photo_url', $id );
		if ( ! $photo && has_post_thumbnail( $id ) ) {
			$photo = get_the_post_thumbnail_url( $id, 'large' );
		}
		$items[] = array(
			'name'        => get_the_title( $id ),
			'spec'        => (string) get_field( 'spec', $id ),
			'experience'  => (string) get_field( 'experience', $id ),
			'short_desc'  => (string) ( get_field( 'short_desc', $id ) ?: get_the_excerpt( $id ) ),
			'photo_url'   => $photo,
			'docs_filter' => (string) ( get_field( 'docs_filter', $id ) ?: 'field' ),
			'url'         => get_permalink( $id ),
		);
	}
	wp_reset_postdata();
} else {
	$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
}

if ( ! $items ) {
	return;
}
?>
<section class="people wrap people--page" data-doctors>
	<div class="people__head">
		<div class="people__intro">
			<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $l ) : ?><p class="people__lead" data-reveal><?php echo esc_html( $l ); ?></p><?php endif; ?>
			<a class="pd-badge" href="https://prodoctorov.ru/" target="_blank" rel="noopener" data-reveal>
				<img src="<?php echo esc_url( home_url( '/images/prodoctorov-logo.png' ) ); ?>" alt="ПроДокторов" width="120" height="24">
				<span class="pd-badge__score">4.8 <i>★</i></span>
				<span class="pd-badge__text">Рекомендуют пациенты</span>
			</a>
		</div>
		<div class="people__tools">
			<div class="people__nav">
				<button type="button" class="people__btn" data-docs-prev aria-label="Предыдущий">←</button>
				<button type="button" class="people__btn" data-docs-next aria-label="Следующий">→</button>
			</div>
		</div>
	</div>
	<div class="people__switch" data-docs-switch role="tablist" aria-label="Тип приёма" data-reveal>
		<button type="button" class="is-on" data-docs-filter="field" role="tab" aria-selected="true">Выездные врачи / фельдшера</button>
		<button type="button" data-docs-filter="ambulatory" role="tab" aria-selected="false">Амбулаторная служба</button>
		<button type="button" data-docs-filter="stationary" role="tab" aria-selected="false">Стационарное отделение</button>
	</div>
	<div class="people__viewport swiper" data-reveal data-docs-swiper>
		<div class="swiper-wrapper" data-docs-track>
			<?php foreach ( $items as $doc ) :
				$filter = $doc['docs_filter'] ?? 'field';
				$photo  = function_exists( 'alba_media_url' ) ? alba_media_url( $doc['photo_url'] ?? '' ) : ( $doc['photo_url'] ?? '' );
				$name   = $doc['name'] ?? '';
				$url    = $doc['url'] ?? '';
				if ( $url && ! preg_match( '#^https?://#', $url ) ) {
					$slug = preg_replace( '/^doctor-/', '', $url );
					$post = get_page_by_path( $slug, OBJECT, 'doctor' );
					$url  = $post ? get_permalink( $post ) : home_url( '/' . alba_get_current_city()['slug'] . '/doctor/' . $slug . '/' );
				}
				if ( ! $url ) {
					$url = '#';
				}
				?>
				<article class="swiper-slide person" data-docs-card data-spec="<?php echo esc_attr( $filter ); ?>">
					<div class="person__photo">
						<?php if ( $photo ) : ?>
							<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" decoding="async">
						<?php endif; ?>
					</div>
					<div class="person__meta">
						<h3><?php echo esc_html( $name ); ?></h3>
						<?php if ( ! empty( $doc['spec'] ) ) : ?><p class="person__spec"><?php echo esc_html( $doc['spec'] ); ?></p><?php endif; ?>
						<?php if ( ! empty( $doc['experience'] ) ) : ?><p class="person__exp"><?php echo esc_html( $doc['experience'] ); ?></p><?php endif; ?>
						<?php if ( ! empty( $doc['short_desc'] ) ) : ?><p class="person__desc"><?php echo esc_html( $doc['short_desc'] ); ?></p><?php endif; ?>
						<div class="person__actions">
							<a class="person__more" href="<?php echo esc_url( $url ); ?>">Подробнее</a>
							<a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="people__dots swiper-pagination" data-docs-dots aria-label="Врачи"></div>
</section>
