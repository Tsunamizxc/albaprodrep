<?php
/**
 * Block: license_cards
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
<section class="wrap">
	<div class="lic-grid">
		<?php foreach ( $items as $it ) :
			$wide  = ! empty( $it['wide'] );
			$eye   = $it['eyebrow'] ?? '';
			$title = $it['title'] ?? '';
			$text  = $it['text'] ?? '';
			$list  = alba_lines( $it['list'] ?? array() );
			$lic   = ! empty( $it['use_city_license'] );
			?>
			<article class="lic-card<?php echo $wide ? ' lic-card--wide' : ''; ?>" data-reveal>
				<?php if ( $eye ) : ?><span><?php echo esc_html( $eye ); ?></span><?php endif; ?>
				<?php if ( $lic ) : ?>
					<h3>Номер <b data-city-license><?php echo esc_html( $city['license'] ?? $title ); ?></b></h3>
				<?php elseif ( $title ) : ?>
					<h3><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
				<?php if ( $list ) : ?>
					<ul>
						<?php foreach ( $list as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
