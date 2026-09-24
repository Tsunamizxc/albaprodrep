<?php
/**
 * Home module: promos
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="promos wrap">
      <h2 class="section-title split">Программы и условия —<br>заботьтесь о возвращении уже сегодня</h2>
      <div class="promo-grid">
        <article class="promo" data-tilt data-reveal>
          <div class="promo__meta"><span>−30%</span><span>Стационар</span></div>
          <h3>Скидка 30%<br>на программу детокса</h3>
          <p>Инфузия, круглосуточный пост и снятие абстиненции. Место в палате — в день обращения.</p>
          <a class="more more--lead" href="#" data-open-modal>Получить скидку</a>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>icon-detox.webp" alt="">
        </article>
        <article class="promo promo--accent" data-tilt data-reveal data-delay="80">
          <div class="promo__meta"><span>0 ₽</span><span>Сегодня</span></div>
          <h3>Бесплатная<br>первичная консультация</h3>
          <p>Разговор с наркологом, осмотр и план лечения — без оплаты при дальнейшем курсе.</p>
          <a class="more more--lead" href="#" data-open-modal>Записаться бесплатно</a>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>icon-consult.webp" alt="">
        </article>
        <article class="promo" data-tilt data-reveal data-delay="160">
          <div class="promo__meta"><span>4 900 ₽</span><span>План лечения</span></div>
          <h3>Диагностика<br>со скидкой</h3>
          <p>Полный осмотр, анализы и персональный план сопровождения — без лишних процедур.</p>
          <a class="more more--lead" href="#" data-open-modal>Узнать стоимость</a>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>icon-check.webp" alt="">
        </article>
        <article class="promo" data-tilt data-reveal>
          <div class="promo__meta"><span>−10%</span><span>Семья</span></div>
          <h3>Семейная программа<br>сопровождения</h3>
          <p>Скидка каждому члену семьи при совместном обращении. Отдельные консультации для родственников.</p>
          <a class="more more--lead" href="#" data-open-modal>Оставить заявку</a>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>icon-people.webp" alt="">
        </article>
        <article class="promo" data-tilt data-reveal data-delay="80">
          <div class="promo__meta"><span>−40%</span><span>После детокса</span></div>
          <h3>Скидка 40%<br>на курс реабилитации</h3>
          <p>При продлении программы после детокса — выгодные условия каждого следующего этапа.</p>
          <a class="more more--lead" href="#" data-open-modal>Забронировать место</a>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>icon-shield.webp" alt="">
        </article>
      </div>
    </section>
