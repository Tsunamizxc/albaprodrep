<?php
/**
 * Home module: test_strip
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="test-strip wrap" data-reveal aria-label="Пройдите тест">
      <div class="test-strip__box">
        <div class="test-strip__copy">
          <strong>Пройдите тест</strong>
          <p>Анонимный брифинг за 2–3 минуты — врачу проще понять ситуацию до звонка</p>
        </div>
        <a class="btn btn--light test-strip__btn" href="<?php echo esc_url( alba_city_url( 'test' ) ); ?>">Пройти тест <span class="arr" aria-hidden="true"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
      </div>
    </section>
