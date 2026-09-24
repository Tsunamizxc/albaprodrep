<?php
/**
 * Home module: licenses
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="home-licenses wrap">
      <div class="home-licenses__head">
        <h2 class="section-title" data-reveal>Лицензии<br>и документы клиники</h2>
        <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'licenses' ) ); ?>">Все документы</a>
      </div>
      <p class="home-licenses__note" data-reveal>Временные макеты для вёрстки. Финальные сканы заменим после согласования.</p>
      <div class="home-licenses__grid">
        <a class="home-licenses__card" href="<?php echo esc_url( alba_city_url( 'licenses' ) ); ?>" data-reveal>
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>license-1.jpg" alt="Лицензия на медицинскую деятельность" loading="lazy" decoding="async">
          <span>Лицензия ЛО-55-01-002891</span>
        </a>
        <a class="home-licenses__card" href="<?php echo esc_url( alba_city_url( 'licenses' ) ); ?>" data-reveal data-delay="80">
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>license-2.jpg" alt="Приложение к лицензии" loading="lazy" decoding="async">
          <span>Приложение к видам работ</span>
        </a>
        <a class="home-licenses__card" href="<?php echo esc_url( alba_city_url( 'licenses' ) ); ?>" data-reveal data-delay="160">
          <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>license-3.jpg" alt="Выписка о регистрации" loading="lazy" decoding="async">
          <span>Выписка ООО «Альба Медикал»</span>
        </a>
      </div>
    </section>
