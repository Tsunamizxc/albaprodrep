<?php
/**
 * Home module: cta
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="cta wrap">
      <div class="cta__box" data-reveal="scale">
        <div>
          <h2>Нужна помощь сегодня —<br>ответьте за 5 минут</h2>
          <p>Дежурный нарколог на связи 24/7. Можно не называть имя. Перезвоним сами.</p>
        </div>
        <div class="cta__actions"><a class="btn btn--light" href="#" data-open-modal>Оставить заявку <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a><a class="btn btn--ghost-light" href="tel:+78001001212" data-city-tel>Позвонить: <span data-city-phone>8 800 100-12-12</span></a></div>
      </div>
    </section>
