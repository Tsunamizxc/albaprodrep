<?php
/**
 * Home module: rooms
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="rooms wrap" data-rooms>
      <div class="rooms__head">
        <h2 class="section-title" data-reveal>Как выглядят<br>палаты</h2>
        <div class="rooms__nav">
          <button type="button" class="rooms__btn" data-rooms-prev aria-label="Предыдущая">←</button>
          <button type="button" class="rooms__btn" data-rooms-next aria-label="Следующая">→</button>
        </div>
      </div>
      <div class="rooms__viewport swiper" data-reveal data-rooms-swiper>
        <div class="swiper-wrapper">
          <article class="swiper-slide rooms__slide">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>room-double.jpg" alt="Двухместная палата" loading="lazy" decoding="async">
            <div class="rooms__meta">
              <h3>Двухместная</h3>
              <p>5 палат: 1–2 места, кондиционер, тонометр, пост медсестры рядом.</p>
              <span>от 6 900 ₽ / сутки</span>
              <div class="rooms__actions">
                <a class="btn btn--blue" href="#" data-open-modal>Записаться</a>
                <a class="btn btn--line" href="tel:+78001001212" data-city-tel>Позвонить</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide rooms__slide">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>room-vip.jpg" alt="Палата премиум" loading="lazy" decoding="async">
            <div class="rooms__meta">
              <h3>Премиум</h3>
              <p>1 палата: санузел, душ, раковина — больше приватности.</p>
              <span>от 14 900 ₽ / сутки</span>
              <div class="rooms__actions">
                <a class="btn btn--blue" href="#" data-open-modal>Записаться</a>
                <a class="btn btn--line" href="tel:+78001001212" data-city-tel>Позвонить</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide rooms__slide">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>room-single.jpg" alt="Одноместное размещение" loading="lazy" decoding="async">
            <div class="rooms__meta">
              <h3>1 место в палате</h3>
              <p>Можно занять палату одному — тишина после капельницы.</p>
              <span>от 8 900 ₽ / сутки</span>
              <div class="rooms__actions">
                <a class="btn btn--blue" href="#" data-open-modal>Записаться</a>
                <a class="btn btn--line" href="tel:+78001001212" data-city-tel>Позвонить</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide rooms__slide">
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>room-stabilize.jpg" alt="Палата со стабилизацией" loading="lazy" decoding="async">
            <div class="rooms__meta">
              <h3>Стабилизация</h3>
              <p>Первые сутки с усиленным наблюдением и контролем давления.</p>
              <span>от 11 500 ₽ / сутки</span>
              <div class="rooms__actions">
                <a class="btn btn--blue" href="#" data-open-modal>Записаться</a>
                <a class="btn btn--line" href="tel:+78001001212" data-city-tel>Позвонить</a>
              </div>
            </div>
          </article>
        </div>
      </div>
      <div class="rooms__dots swiper-pagination" data-rooms-dots aria-label="Палаты"></div>
    </section>
