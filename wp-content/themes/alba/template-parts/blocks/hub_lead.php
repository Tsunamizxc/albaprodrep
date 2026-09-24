<?php
/**
 * Block: hub_lead
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$title = $b['title'] ?? '';
$text  = $b['text'] ?? '';
$btn   = $b['button'] ?? 'Оставить заявку';
?>
<section class="hub-lead wrap">
	<div class="hub-lead__box" data-reveal>
		<div>
			<?php if ( $title ) : ?><h2><?php echo alba_title_br( $title ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
		</div>
		<div class="hub-lead__actions">
			<a class="btn btn--blue" href="#" data-open-modal><?php echo esc_html( $btn ); ?></a>
			<a class="btn btn--line" href="tel:<?php echo esc_attr( $city['tel'] ?? '' ); ?>" data-city-tel>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ?? '' ); ?></span></a>
		</div>
	</div>
</section>
