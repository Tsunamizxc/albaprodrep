<?php
/**
 * Home module: calc
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="calc wrap" id="calc" data-calc>
      <div class="calc__box">
        <div class="calc__intro">
          <h2 class="section-title">Подберите услугу<br>и рассчитайте лечение</h2>
          <p>Ответьте на несколько вопросов — получите ориентир по программе и стоимости до звонка врача.</p>
        </div>
        <div class="calc__panel-wrap" data-reveal data-delay="80">
          <div class="calc__steps" data-calc-dots role="status" aria-label="Шаги опроса"></div>
          <div class="calc__panel" data-calc-panel>
            <h3 data-calc-q>Какая услуга нужна?</h3>
            <div class="calc-opts" data-calc-opts></div>
            <div class="calc-summary" data-calc-summary hidden></div>
            <div class="form" data-calc-form hidden>
              <form data-form>
                <div class="form__fields">
                  <label for="calc-phone">Телефон</label>
                  <input id="calc-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
                  <button class="btn btn--blue" type="submit">Получить расчёт и звонок</button>
                </div>
                <div class="form__ok calc-thanks">
                  <span class="calc-thanks__mark" aria-hidden="true">✓</span>
                  <strong>Спасибо!</strong>
                  <p>Заявка принята. Дежурный врач перезвонит с программой и ориентиром по стоимости.</p>
                </div>
              </form>
            </div>
          </div>
          <div class="calc__nav">
            <button class="btn btn--line" type="button" data-calc-back hidden>Назад</button>
          </div>
        </div>
      </div>
    </section>
