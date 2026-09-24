<?php
/**
 * Block: contacts
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$cards = is_array( $b['cards'] ?? null ) ? $b['cards'] : array();
$show_map  = ! isset( $b['show_map'] ) || $b['show_map'];
$show_form = ! isset( $b['show_form'] ) || $b['show_form'];
$form_title = $b['form_title'] ?? 'Оставить номер';
$form_text  = $b['form_text'] ?? '';
?>
<section class="contacts wrap">
	<div data-reveal>
		<?php if ( $cards ) : ?>
			<div class="info-list">
				<?php foreach ( $cards as $card ) :
					$label = $card['label'] ?? '';
					$type  = $card['value_type'] ?? 'text';
					$val   = $card['value'] ?? '';
					$desc  = $card['text'] ?? '';
					?>
					<article class="info">
						<span><?php echo esc_html( $label ); ?></span>
						<b>
						<?php
						if ( 'phone' === $type ) {
							echo '<a href="tel:' . esc_attr( $city['tel'] ?? '' ) . '" data-city-tel><span data-city-phone>' . esc_html( $city['phone'] ?? $val ) . '</span></a>';
						} elseif ( 'messengers' === $type ) {
							echo '<a href="' . esc_url( $city['max'] ?? 'https://max.ru/' ) . '" data-city-max target="_blank" rel="noopener">Max</a> · <a href="' . esc_url( $city['tg'] ?? '#' ) . '" data-city-tg target="_blank" rel="noopener">Telegram</a>';
						} elseif ( 'address' === $type ) {
							echo '<span data-city-address>' . esc_html( $city['address'] ?? $val ) . '</span>';
						} elseif ( 'license' === $type ) {
							echo 'Лицензия <span data-city-license>' . esc_html( $city['license'] ?? $val ) . '</span>';
						} else {
							echo esc_html( $val );
						}
						?>
						</b>
						<?php if ( $desc ) : ?><p><?php echo esc_html( $desc ); ?></p><?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php if ( $show_map ) : ?>
			<div class="map">
				<iframe title="Карта клиники" data-city-map src="<?php echo esc_url( $city['map'] ?? '' ); ?>" loading="lazy"></iframe>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( $show_form ) : ?>
		<div class="form" data-reveal>
			<h2><?php echo esc_html( $form_title ); ?></h2>
			<?php if ( $form_text ) : ?><p><?php echo esc_html( $form_text ); ?></p><?php endif; ?>
			<form data-form data-alba-lead>
				<div class="form__fields">
					<label for="c-name">Как к вам обращаться</label>
					<input id="c-name" name="name" type="text" placeholder="Имя или псевдоним" autocomplete="name">
					<label for="c-phone">Телефон</label>
					<input id="c-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
					<label for="c-msg">Ситуация в двух фразах</label>
					<textarea id="c-msg" name="message" placeholder="Можно коротко"></textarea>
					<button class="btn btn--blue" type="submit">Отправить <?php echo alba_arr(); // phpcs:ignore ?></button>
				</div>
				<div class="form__ok">Заявка принята. Дежурный врач перезвонит с номера клиники.</div>
			</form>
		</div>
	<?php endif; ?>
</section>
