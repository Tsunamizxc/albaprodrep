<?php
/**
 * Home module: trust
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="trust wrap">
      <div data-reveal="left">
        <h2 class="section-title">Надёжная клиника<br>с полной конфиденциальностью</h2>
        <div class="trust__cards">
          <article class="t-card">
            <svg viewBox="0 0 36 36" fill="none"><path d="M8 20.5 15 27l13-16" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Лицензия Минздрава<br>и протоколы 2026</span>
          </article>
          <article class="t-card">
            <svg viewBox="0 0 36 36" fill="none"><path d="M18 16a5 5 0 1 0-0.01 0ZM8 28c1.4-4 5-6.5 10-6.5S26.6 24 28 28" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M26 12a4 4 0 1 0 .01 0ZM29.5 22.5c.8 1.6 1.2 3.3 1.5 5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
            <span>Семейное<br>сопровождение</span>
          </article>
        </div>
      </div>
      <div class="trust__photos" data-reveal="right">
        <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>clinic-bright.jpg" alt="Коридор клиники Альба" loading="lazy" decoding="async">
        <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>clinic-consult.jpg" alt="Консультация врачей" loading="lazy" decoding="async">
      </div>
    </section>
