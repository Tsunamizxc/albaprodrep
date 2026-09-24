<?php
/**
 * Footer + modal.
 *
 * @package Alba
 */
$city = alba_get_current_city();
?>
  <footer class="footer">
    <div class="wrap">
      <div class="footer__grid">
        <div>
          <a class="logo" href="<?php echo esc_url( alba_city_url() ); ?>"><?php echo alba_icon_svg(); // phpcs:ignore ?><span class="logo__text">Альба</span></a>
          <p>Премиальная наркологическая клиника. Анонимное лечение зависимостей <span data-city-prep><?php echo esc_html( $city['prep'] ); ?></span>.</p>
        </div>
        <div>
          <h4>Клиника</h4>
          <ul>
            <li><a href="<?php echo esc_url( alba_city_url( 'about' ) ); ?>">О нас</a></li>
            <li><a href="<?php echo esc_url( alba_city_url( 'gallery' ) ); ?>">Галерея</a></li>
            <li><a href="<?php echo esc_url( alba_city_url( 'prices' ) ); ?>">Цены</a></li>
            <li><a href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Врачи</a></li>
            <li><a href="<?php echo esc_url( alba_city_url( 'articles' ) ); ?>">Статьи</a></li>
          </ul>
        </div>
        <div>
          <h4>Программы</h4>
          <ul>
            <li><a href="<?php echo esc_url( alba_city_url( 'programs' ) ); ?>">Каталог</a></li>
            <li><a href="<?php echo esc_url( home_url( '/' . $city['slug'] . '/service/zapoy/' ) ); ?>">Запой и капельница</a></li>
            <li><a href="<?php echo esc_url( home_url( '/' . $city['slug'] . '/service/detox/' ) ); ?>">Детокс</a></li>
            <li><a href="<?php echo esc_url( home_url( '/' . $city['slug'] . '/service/psychiatry/' ) ); ?>">Психиатрия</a></li>
          </ul>
        </div>
        <div>
          <h4>Связь 24/7</h4>
          <a class="footer__phone" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel><span data-city-phone><?php echo esc_html( $city['phone'] ); ?></span></a>
          <div class="footer__msg">
            <a href="<?php echo esc_url( $city['max'] ); ?>" data-city-max target="_blank" rel="noopener" aria-label="Max"><img class="icon-max" src="<?php echo esc_url( home_url( '/images/Max_logo.svg' ) ); ?>" alt="" width="18" height="18"></a>
            <a href="<?php echo esc_url( $city['tg'] ); ?>" data-city-tg target="_blank" rel="noopener" aria-label="Telegram"><svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M21.43 4.53 3.87 11.32c-1.2.47-1.19 1.13-.22 1.43l4.5 1.4 10.45-6.59c.5-.3.95-.13.58.18l-8.46 7.63-.33 4.72c.48 0 .69-.22.96-.48l2.3-2.24 4.78 3.53c.88.48 1.51.23 1.73-.81l3.13-14.74c.32-1.28-.49-1.86-1.36-1.42Z"/></svg></a>
          </div>
          <p><span data-city-address><?php echo esc_html( $city['address'] ); ?></span><br>Лицензия <span data-city-license><?php echo esc_html( $city['license'] ); ?></span></p>
        </div>
      </div>
      <div class="footer__copy">
        <span>© <span data-year><?php echo esc_html( gmdate( 'Y' ) ); ?></span> ООО «Альба Медикал». 18+. Имеются противопоказания.</span>
        <span class="footer__legal">
          <a href="<?php echo esc_url( alba_city_url( 'privacy' ) ); ?>">Политика ПДн</a>
          <a href="<?php echo esc_url( alba_city_url( 'consent' ) ); ?>">Согласие</a>
          <a href="<?php echo esc_url( alba_city_url( 'terms' ) ); ?>">Условия</a>
          <a href="<?php echo esc_url( alba_city_url( 'legal' ) ); ?>">Реквизиты</a>
        </span>
      </div>
    </div>
  </footer>

  <div class="modal" data-modal>
    <div class="modal__box form">
      <button class="modal__close" type="button" data-close-modal aria-label="Закрыть">×</button>
      <h2>Запись на консультацию</h2>
      <p>Оставьте номер — перезвоним за 2 минуты. Имя можно не указывать.</p>
      <form data-form data-alba-lead>
        <div class="form__fields">
          <label for="m-name">Как к вам обращаться</label>
          <input id="m-name" name="name" type="text" placeholder="Имя или псевдоним" autocomplete="name">
          <label for="m-phone">Телефон</label>
          <input id="m-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
          <label for="m-prog">Программа</label>
          <select id="m-prog" name="program">
            <option>Пока не знаю — подскажет врач</option>
            <option>Детокс</option>
            <option>Запой и капельница</option>
            <option>Психиатрия</option>
            <option>Кодирование</option>
            <option>Реабилитация</option>
          </select>
          <button class="btn btn--blue" type="submit">Жду звонка <?php echo alba_arr(); // phpcs:ignore ?></button>
        </div>
        <div class="form__ok">Заявка принята. Дежурный врач перезвонит с номера клиники.</div>
      </form>
    </div>
  </div>
<?php wp_footer(); ?>
</body>
</html>
