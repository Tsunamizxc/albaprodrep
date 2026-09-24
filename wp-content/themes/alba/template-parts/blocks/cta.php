<?php
/**
 * Block: cta
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$title = $b['title'] ?? '';
$text  = $b['text'] ?? '';
if ( ! $title && ! $text ) {
	return;
}
?>
<section class="cta wrap">
	<div class="cta__box" data-reveal="scale">
		<div>
			<?php if ( $title ) : ?><h2><?php echo alba_title_br( $title ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
		</div>
		<div class="cta__actions">
			<a class="btn btn--light" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
			<a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( $city['tel'] ?? '' ); ?>" data-city-tel data-no-arr>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ?? '' ); ?></span></a>
		</div>
	</div>
</section>
