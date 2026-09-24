<?php
/**
 * Home module: funnel
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="funnel wrap">
      <div class="funnel__box" data-reveal>
        <div>
          <h2>Не знаете, с чего начать?</h2>
          <p>Опишите ситуацию за 1 минуту — дежурный врач подскажет формат: дом, стационар или консультация. Без обязательств.</p>
          <ul class="funnel__checks">
            <li>Отвечает врач, не колл-центр</li>
            <li>Анонимно — можно без фамилии</li>
            <li>План помощи за несколько минут</li>
          </ul>
        </div>
        <div class="funnel__side form">
          <form data-form class="funnel__form">
            <div class="form__fields funnel__fields">
              <label class="visually-hidden" for="funnel-phone">Телефон</label>
              <input id="funnel-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
              <button class="btn btn--blue" type="submit">Получить план помощи</button>
            </div>
            <p class="funnel__legal">Согласие на <a href="<?php echo esc_url( alba_city_url( 'consent' ) ); ?>">обработку ПДн</a></p>
            <div class="form__ok"><strong>Заявка принята.</strong> Дежурный врач перезвонит.</div>
          </form>
          <div class="funnel__actions">
            <a class="btn btn--line" href="tel:+78001001212" data-city-tel>8 800 100-12-12</a>
            <a class="btn btn--ghost funnel__ghost" href="#calc">Рассчитать стоимость</a>
          </div>
        </div>
      </div>
    </section>
