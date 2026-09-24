<?php
/**
 * Block: program_cards (alko-progs grid)
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$l     = $b['lead'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="alko-progs wrap" data-reveal>
	<div class="alko-progs__head">
		<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
		<?php if ( $l ) : ?><p><?php echo esc_html( $l ); ?></p><?php endif; ?>
	</div>
	<div class="alko-progs__grid">
		<?php foreach ( $items as $card ) :
			$href = function_exists( 'alba_service_permalink' ) ? alba_service_permalink( $card['url'] ?? '' ) : '#';
			$feat = ! empty( $card['featured'] ) ? ' alko-prog--feat' : '';
			?>
			<a class="alko-prog<?php echo esc_attr( $feat ); ?>" href="<?php echo esc_url( $href ); ?>">
				<?php if ( ! empty( $card['badge'] ) ) : ?><em><?php echo esc_html( $card['badge'] ); ?></em><?php endif; ?>
				<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $card['text'] ) ) : ?><p><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
				<?php if ( ! empty( $card['price'] ) ) : ?><b><?php echo esc_html( $card['price'] ); ?></b><?php endif; ?>
				<span class="more"><?php echo esc_html( $card['more'] ?? 'Подробнее' ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
