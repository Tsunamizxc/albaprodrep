<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><path fill='%234f84ff' d='M16 1.8c1.7 5.6 5.8 9.7 11.4 11.4C21.8 15 17.7 19.1 16 24.7 14.3 19.1 10.2 15 4.6 13.2 10.2 11.5 14.3 7.4 16 1.8Z'/></svg>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php $city = alba_get_current_city(); ?>
  <div class="preloader" aria-hidden="true"><div class="preloader__inner"><?php echo alba_icon_svg(); // phpcs:ignore ?><div class="preloader__bar"><span></span></div></div></div>
  <header class="header" data-header>
    <div class="header__bar wrap">
      <a class="logo" href="<?php echo esc_url( alba_city_url() ); ?>"><?php echo alba_icon_svg(); // phpcs:ignore ?><span class="logo__text">Альба</span></a>
      <button type="button" class="city-btn" data-open-city aria-label="Выбор города">
        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 18s6-5.2 6-10a6 6 0 1 0-12 0c0 4.8 6 10 6 10Z" stroke="currentColor" stroke-width="1.6"/><circle cx="10" cy="8" r="2.1" stroke="currentColor" stroke-width="1.6"/></svg>
        <span data-city-name><?php echo esc_html( $city['name'] ); ?></span>
      </button>
      <nav class="nav" aria-label="Основное меню">
        <div class="nav__drop">
          <button class="nav__btn" type="button">Клиника <svg viewBox="0 0 12 12" fill="none"><path d="M2 4.5 6 8.5 10 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>
          <div class="nav__menu">
            <a href="<?php echo esc_url( alba_city_url( 'about' ) ); ?>">О нас</a>
            <a href="<?php echo esc_url( alba_city_url( 'gallery' ) ); ?>">Галерея</a>
            <a href="<?php echo esc_url( alba_city_url( 'links' ) ); ?>">Полезные ссылки</a>
            <a href="<?php echo esc_url( alba_city_url( 'licenses' ) ); ?>">Лицензии</a>
            <a href="<?php echo esc_url( alba_city_url( 'prices' ) ); ?>">Цены</a>
            <a href="<?php echo esc_url( alba_city_url( 'about' ) ); ?>#anon">Анонимность</a>
          </div>
        </div>
        <div class="nav__drop">
          <button class="nav__btn" type="button">Программы <svg viewBox="0 0 12 12" fill="none"><path d="M2 4.5 6 8.5 10 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>
          <div class="nav__menu">
            <a class="nav__catalog" href="<?php echo esc_url( alba_city_url( 'programs' ) ); ?>">Весь каталог</a>
            <?php
            $nav_services = get_posts( array( 'post_type' => 'service', 'numberposts' => 8, 'orderby' => 'title', 'order' => 'ASC' ) );
            foreach ( $nav_services as $s ) {
                echo '<a href="' . esc_url( get_permalink( $s ) ) . '">' . esc_html( get_the_title( $s ) ) . '</a>';
            }
            ?>
          </div>
        </div>
        <a href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Врачи</a>
        <a href="<?php echo esc_url( alba_city_url( 'articles' ) ); ?>">Статьи</a>
        <a href="<?php echo esc_url( alba_city_url( 'contacts' ) ); ?>">Контакты</a>
      </nav>
      <div class="header__actions">
        <a class="icon-btn icon-btn--msg" href="<?php echo esc_url( $city['max'] ); ?>" data-city-max target="_blank" rel="noopener" aria-label="Max"><img class="icon-max" src="<?php echo esc_url( home_url( '/images/Max_logo.svg' ) ); ?>" alt="" width="18" height="18" decoding="async"></a>
        <a class="icon-btn icon-btn--msg" href="<?php echo esc_url( $city['tg'] ); ?>" data-city-tg target="_blank" rel="noopener" aria-label="Telegram"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.43 4.53 3.87 11.32c-1.2.47-1.19 1.13-.22 1.43l4.5 1.4 10.45-6.59c.5-.3.95-.13.58.18l-8.46 7.63-.33 4.72c.48 0 .69-.22.96-.48l2.3-2.24 4.78 3.53c.88.48 1.51.23 1.73-.81l3.13-14.74c.32-1.28-.49-1.86-1.36-1.42Z"/></svg></a>
        <a class="icon-btn" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel aria-label="Позвонить"><span class="icon-phone" aria-hidden="true"></span></a>
        <a class="btn btn--dark" href="#" data-open-modal>Записаться <?php echo alba_arr(); // phpcs:ignore ?></a>
        <button class="burger" type="button" data-burger aria-label="Открыть меню"><span></span><span></span><span></span></button>
      </div>
    </div>
  </header>
  <nav class="mnav" data-mnav>
    <a href="<?php echo esc_url( alba_city_url( 'about' ) ); ?>">О нас</a>
    <a href="<?php echo esc_url( alba_city_url( 'programs' ) ); ?>">Программы</a>
    <a href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Врачи</a>
    <a href="<?php echo esc_url( alba_city_url( 'articles' ) ); ?>">Статьи</a>
    <a href="<?php echo esc_url( alba_city_url( 'contacts' ) ); ?>">Контакты</a>
  </nav>
