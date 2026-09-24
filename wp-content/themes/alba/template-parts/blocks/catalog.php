<?php
/**
 * Block: catalog (cat-card grid)
 *
 * @var array $b
 * @package Alba
 */
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="wrap">
	<div class="catalog">
		<?php foreach ( $items as $card ) :
			$url  = trim( (string) ( $card['url'] ?? '' ) );
			$href = '#';
			if ( $url ) {
				if ( preg_match( '#^https?://#', $url ) ) {
					$href = $url;
				} elseif ( 0 === strpos( $url, 'service-' ) || get_page_by_path( preg_replace( '/^service-/', '', $url ), OBJECT, array( 'service', 'program' ) ) ) {
					$href = function_exists( 'alba_service_permalink' ) ? alba_service_permalink( $url ) : alba_city_url( $url );
				} else {
					$href = alba_city_url( ltrim( $url, '/' ) );
				}
			}
			$accent = ! empty( $card['accent'] ) ? ' cat-card--accent' : '';
			$icon   = function_exists( 'alba_media_url' ) ? alba_media_url( $card['icon'] ?? '' ) : ( $card['icon'] ?? '' );
			?>
			<a class="cat-card<?php echo esc_attr( $accent ); ?>" href="<?php echo esc_url( $href ); ?>" data-reveal>
				<?php if ( ! empty( $card['badge'] ) ) : ?><span><?php echo esc_html( $card['badge'] ); ?></span><?php endif; ?>
				<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $card['text'] ) ) : ?><p><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
				<?php if ( ! empty( $card['price'] ) ) : ?><b><?php echo esc_html( $card['price'] ); ?></b><?php endif; ?>
				<?php if ( $icon ) : ?><img src="<?php echo esc_url( $icon ); ?>" alt=""><?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</section>
