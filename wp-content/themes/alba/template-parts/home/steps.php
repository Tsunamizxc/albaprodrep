<?php
/**
 * Home module: steps
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="steps wrap">
      <div class="steps__head">
        <h2 class="section-title" data-reveal>Как проходит<br>лечение в Альбе</h2>
        <p data-reveal>Четыре тихих шага. Без очередей, без случайных людей в коридоре, без звонков на работу.</p>
      </div>
      <div class="steps__grid">
        <article class="step" data-reveal>
          <div class="step__n">01</div>
          <h3>Звонок</h3>
          <p>Дежурный врач отвечает в любое время. Вы описываете ситуацию своими словами — мы не требуем документов по телефону.</p>
        </article>
        <article class="step" data-reveal data-delay="80">
          <div class="step__n">02</div>
          <h3>Приезд</h3>
          <p>Трансфер на автомобиле клиники или встреча на отдельном входе. Палата готовится заранее.</p>
        </article>
        <article class="step" data-reveal data-delay="160">
          <div class="step__n">03</div>
          <h3>Детокс</h3>
          <p>Снимаем абстиненцию, стабилизируем сон и давление. Рядом — пост медсестры и врач на этаже.</p>
        </article>
        <article class="step" data-reveal data-delay="240">
          <div class="step__n">04</div>
          <h3>План</h3>
          <p>После стабилизации — кодирование, реабилитация или амбулаторное сопровождение. Решение за вами.</p>
        </article>
      </div>
    </section>
