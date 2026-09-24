<?php
/**
 * Block: funnel
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$title   = $b['title'] ?? '';
$text    = $b['text'] ?? '';
$chips   = is_array( $b['chips'] ?? null ) ? $b['chips'] : array();
$variant = $b['variant'] ?? 'form';
$uid     = 'funnel-' . wp_unique_id();

if ( 'call' === $variant ) :
	?>
<section class="page-funnel wrap page-funnel--mid" data-page-funnel-mid>
	<div class="page-funnel__box">
		<div>
			<?php if ( $title ) : ?><h2><?php echo alba_title_br( $title ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
		</div>
		<div class="page-funnel__actions">
			<a class="btn btn--blue" href="#" data-open-modal>Оставить заявку</a>
			<a class="btn btn--line" href="tel:<?php echo esc_attr( $city['tel'] ?? '' ); ?>" data-city-tel data-no-arr>Позвонить <span data-city-phone><?php echo esc_html( $city['phone'] ?? '' ); ?></span></a>
		</div>
	</div>
</section>
	<?php
	return;
endif;
?>
<section class="page-funnel page-funnel--form wrap" data-page-funnel-top>
	<div class="page-funnel__box page-funnel__box--form form">
		<div class="page-funnel__copy">
			<?php if ( $title ) : ?><h2><?php echo alba_title_br( $title ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
			<?php if ( $chips ) : ?>
				<ul class="page-funnel__chips">
					<?php foreach ( $chips as $c ) : ?><li><?php echo esc_html( is_array( $c ) ? ( $c['text'] ?? '' ) : $c ); ?></li><?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<form data-form data-alba-lead class="page-funnel__form">
			<div class="form__fields page-funnel__fields">
				<label class="visually-hidden" for="<?php echo esc_attr( $uid ); ?>">Телефон</label>
				<input id="<?php echo esc_attr( $uid ); ?>" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
				<button class="btn btn--blue" type="submit">Жду звонка</button>
			</div>
			<p class="page-funnel__legal">Нажимая кнопку, вы соглашаетесь с <a href="<?php echo esc_url( alba_city_url( 'consent' ) ); ?>">обработкой ПДн</a>.</p>
			<div class="form__ok">Заявка принята. Перезвоним в ближайшее время.</div>
		</form>
	</div>
</section>
