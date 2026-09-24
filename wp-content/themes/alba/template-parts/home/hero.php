<?php
/**
 * Home module: hero
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h    = trim( (string) ( $b['heading'] ?? '' ) );
$l    = trim( (string) ( $b['lead'] ?? '' ) );
$tel  = $city['tel'] ?? '+78001001212';
$prep = $city['prep'] ?? 'в Омске';
if ( ! $h ) {
	$h = 'Альба — клиника анонимной наркологической помощи';
}
if ( ! $l ) {
	$l = "7 мобильных бригад сертифицированных врачей. Капельница от алкоголя на дому.\nНаркологическая помощь. Круглосуточный стационар";
}
$lead_html = nl2br( esc_html( $l ), false );
?>
<div class="wrap">
	<section class="hero">
		<div class="hero__content">
			<h1 class="split"><?php echo esc_html( $h ); ?> <span data-city-prep><?php echo esc_html( $prep ); ?></span></h1>
			<p class="hero__lead" data-reveal><?php echo $lead_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<p class="hero__paylater" data-reveal data-delay="40">Лечитесь сейчас — платите потом</p>
			<a class="btn btn--light hero__call-mobile" href="tel:<?php echo esc_attr( $tel ); ?>" data-city-tel data-reveal data-delay="50">Вызвать врача</a>
			<div class="hero-lead-form form" data-reveal data-delay="60">
				<h3 class="hero-lead-form__title">Отправить заявку на отсрочку оплаты за лечение</h3>
				<form data-form data-alba-lead>
					<div class="form__fields">
						<label for="hero-phone">Телефон</label>
						<input id="hero-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
						<p class="hero-lead-form__note">Мы понимаем Ваше состояние и готовы помочь прямо сейчас без оплаты. Отправьте заявку и наш врач перезвонит Вам через 2 минуты</p>
						<div class="hero-lead-form__actions">
							<button class="btn btn--blue" type="submit">Оставить заявку</button>
							<a class="btn btn--ghost" href="#calc">Рассчитать стоимость</a>
						</div>
					</div>
					<div class="form__ok">
						<strong>Спасибо!</strong>
						<p>Заявка принята. Дежурный врач перезвонит в ближайшее время.</p>
					</div>
				</form>
			</div>
			<div class="hero__cta" data-reveal data-delay="80">
				<a class="btn btn--light hero__call-desktop" href="tel:<?php echo esc_attr( $tel ); ?>" data-city-tel>Вызвать врача</a>
				<a class="btn btn--ghost" href="#" data-open-modal>Получить бесплатную консультацию</a>
			</div>
			<div class="hero__rating" data-reveal data-delay="160">
				<div>
					<div class="hero__score"><span data-count="4.9">0</span><i><svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M10 1.6 12.4 7l5.8.5-4.4 3.8 1.4 5.7L10 14.2 4.8 17l1.4-5.7L1.8 7.5 7.6 7 10 1.6Z"/></svg></i></div>
				</div>
				<p>Средняя оценка<br>в Яндекс.Картах</p>
				<div class="hero__faces">
					<img src="<?php echo esc_url( home_url( '/images/avatar-1.jpg' ) ); ?>" alt="">
					<img src="<?php echo esc_url( home_url( '/images/avatar-2.jpg' ) ); ?>" alt="">
					<img src="<?php echo esc_url( home_url( '/images/avatar-3.jpg' ) ); ?>" alt="">
					<span>800+ отзывов</span>
				</div>
			</div>
		</div>
		<div class="hero__visual">
			<div class="hero__orbit" aria-hidden="true">
				<svg viewBox="0 0 100 100">
					<defs>
						<path id="heroOrbitPath" d="M50,50 m-45.5,0 a45.5,45.5 0 1,1 91,0 a45.5,45.5 0 1,1 -91,0"></path>
					</defs>
					<text>
						<textPath href="#heroOrbitPath">Особое отношение к каждому пациенту · Особое отношение к каждому пациенту · Особое отношение к каждому пациенту · </textPath>
					</text>
				</svg>
			</div>
			<img class="hero__photo" src="<?php echo esc_url( home_url( '/images/hero-doctor.webp' ) ); ?>" alt="Врач клиники Альба" fetchpriority="high" decoding="async">
		</div>
	</section>
</div>
