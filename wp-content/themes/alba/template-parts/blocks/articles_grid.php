<?php
/**
 * Block: articles_grid
 *
 * @var array $b
 * @package Alba
 */
$h       = $b['heading'] ?? '';
$lead    = $b['lead'] ?? '';
$from_db = ! empty( $b['from_posts'] );
$items   = is_array( $b['items'] ?? null ) ? $b['items'] : array();

if ( $from_db || ! $items ) {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 24,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post__not_in'   => array( (int) get_option( 'page_on_front' ) ),
		)
	);
	$items = array();
	foreach ( $posts as $p ) {
		if ( 'hello-world' === $p->post_name ) {
			continue;
		}
		$img = get_the_post_thumbnail_url( $p, 'large' );
		if ( ! $img ) {
			$cover = (string) get_field( 'cover_url', $p->ID );
			$img   = $cover ? alba_media_url( $cover ) : home_url( '/images/clinic-room.jpg' );
		}
		$items[] = array(
			'title' => get_the_title( $p ),
			'text'  => $p->post_excerpt ? $p->post_excerpt : wp_trim_words( wp_strip_all_tags( $p->post_content ), 24 ),
			'url'   => get_permalink( $p ),
			'image' => $img,
			'date'  => get_the_date( 'j F Y', $p ),
		);
	}
}

if ( ! $items ) {
	return;
}
?>
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p class="about-lead" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<div class="articles">
		<?php foreach ( $items as $i => $it ) :
			$href = ! empty( $it['url'] ) && preg_match( '#^https?://#i', $it['url'] ) ? $it['url'] : alba_block_href( $it['url'] ?? '#' );
			$img  = alba_media_url( $it['image'] ?? '' );
			?>
			<a class="article" href="<?php echo esc_url( $href ); ?>" data-reveal<?php echo $i ? ' data-delay="' . esc_attr( (string) ( $i * 80 ) ) . '"' : ''; ?>>
				<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"><?php endif; ?>
				<div>
					<?php if ( ! empty( $it['date'] ) ) : ?><time><?php echo esc_html( $it['date'] ); ?></time><?php endif; ?>
					<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
					<?php if ( ! empty( $it['text'] ) ) : ?><p><?php echo esc_html( $it['text'] ); ?></p><?php endif; ?>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
</section>
