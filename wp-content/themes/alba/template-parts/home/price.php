<?php
/**
 * Home module: price
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="home-price wrap">
      <h2 class="section-title split">Цены без «от и до»<br>в мелком шрифте</h2>
      <div class="home-price__grid">
        <div class="price-wrap" data-reveal>
          <table class="price-table">
            <thead><tr><th>Алкоголь и запой</th><th>Цена</th></tr></thead>
            <tbody>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>">Лечение алкоголизма, старт</a></td><td>от 18 900 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Капельница на дому</a></td><td>9 900 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Вывод из запоя дома</a></td><td>14 900 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-hangover' ) ); ?>">Капельница от похмелья</a></td><td>9 900 ₽</td></tr>
            </tbody>
          </table>
        </div>
        <div class="price-wrap" data-reveal data-delay="80">
          <table class="price-table">
            <thead><tr><th>Кодирование</th><th>Цена</th></tr></thead>
            <tbody>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-code-torpedo' ) ); ?>">Торпедо, до 1 года</a></td><td>12 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-code-double' ) ); ?>">Двойной блок</a></td><td>16 800 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-code-vivitrol' ) ); ?>">Вивитрол</a></td><td>от 28 000 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-code-implant' ) ); ?>">Вшивание ампулы</a></td><td>14 500 ₽</td></tr>
            </tbody>
          </table>
        </div>
        <div class="price-wrap" data-reveal>
          <table class="price-table">
            <thead><tr><th>Наркомания и реабилитация</th><th>Цена</th></tr></thead>
            <tbody>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-withdrawal' ) ); ?>">Снятие ломки</a></td><td>от 18 900 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Реабилитация 21 день</a></td><td>210 000 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Сутки в центре</a></td><td>10 000 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-sober' ) ); ?>">Поддержка трезвости</a></td><td>от 6 900 ₽</td></tr>
            </tbody>
          </table>
        </div>
        <div class="price-wrap" data-reveal data-delay="80">
          <table class="price-table">
            <thead><tr><th>Психиатрия — форматы помощи</th><th>Цена</th></tr></thead>
            <tbody>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-first' ) ); ?>">Первичная консультация психиатра</a></td><td>от 4 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-followup' ) ); ?>">Повторная консультация</a></td><td>от 2 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-online' ) ); ?>">Онлайн-консультация</a></td><td>от 4 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-support' ) ); ?>">Психиатрическое сопровождение</a></td><td>от 7 000 ₽ / мес</td></tr>
            </tbody>
          </table>
        </div>
        <div class="price-wrap" data-reveal>
          <table class="price-table">
            <thead><tr><th>Психотерапия</th><th>Цена</th></tr></thead>
            <tbody>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-therapist' ) ); ?>">Консультация психотерапевта</a></td><td>от 4 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-psychologist' ) ); ?>">Консультация психолога</a></td><td>от 4 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-psy-counseling' ) ); ?>">Психотерапевтическое консультирование</a></td><td>от 4 500 ₽</td></tr>
              <tr><td><a href="<?php echo esc_url( alba_city_url( 'service-family' ) ); ?>">Семейные отношения</a></td><td>от 4 500 ₽</td></tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="home-price__more" data-reveal>
        <a class="btn btn--blue" href="<?php echo esc_url( alba_city_url( 'prices' ) ); ?>">Смотреть все цены <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
      </div>
    </section>
