<?php
/**
 * Home module: seo_funnel
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="seo-funnel wrap">
      <div class="seo-funnel__head" data-reveal>
        <h2 class="section-title">Частые запросы</h2>
        <p>Три направления, с которых чаще всего начинают путь к помощи.</p>
      </div>
      <div class="seo-funnel__grid">
        <a class="seo-funnel__card" href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>" data-reveal>
          <span>Срочно</span>
          <h3>Вывод из запоя</h3>
          <p>Капельница дома или стабилизация с выездом — врач подскажет формат.</p>
          <em>Получить помощь</em>
        </a>
        <a class="seo-funnel__card" href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>" data-reveal data-delay="60">
          <span>Алкоголь</span>
          <h3>Лечение зависимости</h3>
          <p>Детокс, психиатр и план без «капельница и всё».</p>
          <em>Узнать маршрут</em>
        </a>
        <a class="seo-funnel__card" href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>" data-reveal data-delay="120">
          <span>После стабилизации</span>
          <h3>Кодирование</h3>
          <p>Метод после осмотра, наблюдение 30 дней — без кодирования «с порога».</p>
          <em>Записаться</em>
        </a>
      </div>
    </section>
