<?php
/**
 * Block: stats
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="about-stats wrap" data-reveal>
	<div class="about-stats__grid">
		<?php foreach ( $items as $it ) :
			$type    = $it['value_type'] ?? 'text';
			$val     = $it['value'] ?? '';
			$lab     = $it['label'] ?? '';
			$attrs   = '';
			$lattrs  = '';
			$content = esc_html( $val );
			if ( 'city_name' === $type ) {
				$attrs   = ' data-city-name';
				$content = esc_html( $city['name'] ?? $val );
				if ( '' === $lab ) {
					$lab    = $city['address'] ?? '';
					$lattrs = ' data-city-address';
				}
			} elseif ( 'city_address' === $type ) {
				$attrs   = ' data-city-address';
				$content = esc_html( $city['address'] ?? $val );
			} elseif ( 'city_license' === $type ) {
				$attrs   = ' data-city-license';
				$content = esc_html( $city['license'] ?? $val );
			} elseif ( 'count' === $type ) {
				$attrs   = ' data-count="' . esc_attr( preg_replace( '/\D+/', '', $val ) ) . '"';
				$content = '0';
			}
			?>
			<div><b<?php echo $attrs; // phpcs:ignore ?>><?php echo $content; // phpcs:ignore ?></b><span<?php echo $lattrs; // phpcs:ignore ?>><?php echo esc_html( $lab ); ?></span></div>
		<?php endforeach; ?>
	</div>
</section>
