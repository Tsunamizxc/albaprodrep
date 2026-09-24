<?php
/**
 * Home module: ward
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="ward-fund wrap" data-reveal id="ward-fund">
      <div class="ward-fund__head">
        <h2 class="section-title">Палатный фонд<br>клиники</h2>
        <p>В стационаре 5 двухместных палат и 1 палата премиум. Размещение 1–2 места, круглосуточный пост медсестры.</p>
      </div>
      <div class="ward-fund__grid">
        <article>
          <span class="ward-fund__badge">5 палат</span>
          <h3>Двухместные палаты</h3>
          <ul>
            <li>5 двухместных палат в отделении</li>
            <li>Возможно 1–2 местное размещение</li>
            <li>Спокойный режим, без «проходного» коридора</li>
          </ul>
        </article>
        <article class="ward-fund__feat">
          <span class="ward-fund__badge">Премиум</span>
          <h3>1 палата премиум</h3>
          <ul>
            <li>Собственный санузел</li>
            <li>Душ и раковина в палате</li>
            <li>Больше приватности для пациента и сопровождающего</li>
          </ul>
        </article>
        <article>
          <span class="ward-fund__badge">В каждой</span>
          <h3>Оснащение палаты</h3>
          <ul>
            <li>Кондиционер</li>
            <li>Тонометр для контроля давления</li>
            <li>1–2 местное размещение по согласованию</li>
            <li>Мебель и условия для отдыха после капельницы</li>
          </ul>
        </article>
        <article>
          <span class="ward-fund__badge">24/7</span>
          <h3>Пост и сервис</h3>
          <ul>
            <li>Пост медицинской сестры круглосуточно</li>
            <li>Обходы врача-нарколога</li>
            <li>Питание и помощь с режимом дня</li>
            <li>Анонимное оформление, 18+, добровольно</li>
          </ul>
        </article>
      </div>
      <div class="ward-fund__cta">
        <a class="btn btn--blue" href="#" data-open-modal>Забронировать палату <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
        <a class="btn btn--line" href="tel:+78001001212" data-city-tel>Позвонить: <span data-city-phone>8 800 100-12-12</span></a>
      </div>
    </section>
