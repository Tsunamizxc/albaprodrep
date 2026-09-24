<?php
/**
 * Home module: reviews
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="reviews wrap">
        <div class="people__head">
          <h2 class="section-title" data-reveal>Истории, которые<br>нам доверили</h2>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'reviews' ) ); ?>">Все отзывы</a>
        </div>
      <div class="reviews__grid">
        <article class="review review--lead" data-reveal>
          <p>Муж прошёл детокс и три недели реабилитации. Никто на работе не узнал. Врачи говорили с нами спокойно, без давления. Это первый раз, когда я почувствовала, что нас не осуждают.</p>
          <div class="review__who">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>avatar-3.jpg" alt="">
            <div><b>Ольга, 47 лет</b><span>Супруга пациента</span></div>
          </div>
        </article>
        <article class="review" data-reveal data-delay="80">
          <p>Палата как в хорошем отеле, а не больница. Вышел на пятый день — без ломки, с понятным планом. Звонят и после выписки, это важно.</p>
          <div class="review__who">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>avatar-2.jpg" alt="">
            <div><b>Дмитрий</b><span>Программа детокса</span></div>
          </div>
        </article>
        <article class="review" data-reveal data-delay="160">
          <p>Консультацию провела Сафонова. Объяснила про сына без страшных слов. Семейная программа помогла нам перестать кричать друг на друга.</p>
          <div class="review__who">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>avatar-1.jpg" alt="">
            <div><b>Анна</b><span>Семейное сопровождение</span></div>
          </div>
        </article>
      </div>
    </section>
