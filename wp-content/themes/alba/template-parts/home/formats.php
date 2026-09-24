<?php
/**
 * Home module: formats
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="svc-tariffs wrap home-formats" data-reveal>
      <h2 class="section-title">Форматы помощи</h2>
      <p class="svc-tariffs__lead">Приём, онлайн, выезд или сопровождение — подбираем после разбора состояния. Ориентиры до осмотра, 18+, добровольно.</p>
      <div class="svc-tariffs__grid">
        <article class="svc-tariff">
          <h3>Первичная консультация психиатра</h3>
          <b class="svc-tariff__price">от 4 500 ₽</b>
          <ul>
            <li>Подробный разбор состояния и жалоб</li>
            <li>История заболевания</li>
            <li>Тактика дальнейшей помощи</li>
            <li>Понятные рекомендации</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-first' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Повторная консультация</h3>
          <b class="svc-tariff__price">от 2 500 ₽</b>
          <ul>
            <li>Оценка динамики</li>
            <li>Ответы на вопросы</li>
            <li>Корректировка лечения</li>
            <li>Дальнейшие рекомендации</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-followup' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Онлайн-консультация</h3>
          <b class="svc-tariff__price">от 4 500 ₽</b>
          <ul>
            <li>Наблюдение в динамике</li>
            <li>Сопровождение после первичного приёма</li>
            <li>Удобный формат без визита</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-online' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Консультация для родственников</h3>
          <b class="svc-tariff__price">от 4 500 ₽</b>
          <ul>
            <li>Когда помощь нужна близкому</li>
            <li>С чего начать и как действовать</li>
            <li>Без давления и ультиматумов</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-relatives' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Выезд врача на дом</h3>
          <b class="svc-tariff__price">от 7 000 ₽</b>
          <ul>
            <li>Когда сложно приехать в клинику</li>
            <li>Осмотр и рекомендации на месте</li>
            <li>Анонимно, 18+</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-home' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Второе мнение психиатра</h3>
          <b class="svc-tariff__price">индивидуально</b>
          <ul>
            <li>Перепроверка диагноза</li>
            <li>Оценка тактики и назначений</li>
            <li>Независимое заключение</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-second-opinion' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Подбор и коррекция терапии</h3>
          <b class="svc-tariff__price">индивидуально</b>
          <ul>
            <li>Лечебная тактика по диагнозу</li>
            <li>Медикаментозная коррекция</li>
            <li>Учёт текущего состояния и динамики</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-meds' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff svc-tariff--feat">
          <h3>Психиатрическое сопровождение</h3>
          <b class="svc-tariff__price">от 7 000 ₽ / месяц</b>
          <ul>
            <li>Регулярное наблюдение между приёмами</li>
            <li>Контакт с врачом</li>
            <li>Коррекция рекомендаций</li>
          </ul>
          <a class="btn btn--blue" href="<?php echo esc_url( alba_city_url( 'service-psy-support' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
        <article class="svc-tariff">
          <h3>Наблюдение при хронических состояниях</h3>
          <b class="svc-tariff__price">индивидуально</b>
          <ul>
            <li>Поддерживающее сопровождение</li>
            <li>Коррекция терапии</li>
            <li>Контроль изменений состояния</li>
          </ul>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'service-psy-chronic-care' ) ); ?>">Подробнее <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        </article>
      </div>
      <p class="home-formats__more"><a class="more" href="<?php echo esc_url( alba_city_url( 'service-psychiatry' ) ); ?>">Все форматы психиатрии</a></p>
    </section>
