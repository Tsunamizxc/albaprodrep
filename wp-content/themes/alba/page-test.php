<?php
/**
 * Template Name: Тест-бриф
 * Quiz page /test/ — texts from ACF.
 *
 * @package Alba
 */
get_header();
$city  = alba_get_current_city();
$pid   = get_the_ID();
$title = function_exists( 'get_field' ) ? (string) get_field( 'test_hero_title', $pid ) : '';
$lead  = function_exists( 'get_field' ) ? (string) get_field( 'test_hero_lead', $pid ) : '';
$badges = function_exists( 'get_field' ) ? get_field( 'test_badges', $pid ) : array();
$side_t = function_exists( 'get_field' ) ? (string) get_field( 'test_side_title', $pid ) : '';
$side_p = function_exists( 'get_field' ) ? (string) get_field( 'test_side_text', $pid ) : '';
$cta_t  = function_exists( 'get_field' ) ? (string) get_field( 'test_cta_title', $pid ) : '';
$cta_p  = function_exists( 'get_field' ) ? (string) get_field( 'test_cta_text', $pid ) : '';

if ( ! $title ) {
	$title = 'Пройдите тест‑бриф|для врача';
}
if ( ! $lead ) {
	$lead = 'Выберите категорию и ответьте на короткие вопросы. Результат — ориентир для дежурного нарколога, а не диагноз. Анонимно, 2–3 минуты.';
}
if ( ! is_array( $badges ) || ! $badges ) {
	$badges = array( array( 'text' => 'Анонимно' ), array( 'text' => 'Без регистрации' ), array( 'text' => '18+' ) );
}
if ( ! $side_t ) {
	$side_t = 'Обсудить с врачом';
}
if ( ! $side_p ) {
	$side_p = 'Оставьте телефон — перезвоним и разберём бриф. Можно без имени.';
}
if ( ! $cta_t ) {
	$cta_t = 'Нужна помощь без теста?';
}
if ( ! $cta_p ) {
	$cta_p = 'Дежурный врач на связи 24/7 ' . $city['prep'] . '.';
}
?>
<main class="test-page" data-test-quiz>
  <section class="test-hero wrap">
    <div class="test-hero__box" data-reveal>
      <div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / Тест</div>
      <h1 class="split"><?php echo function_exists( 'alba_title_br' ) ? alba_title_br( $title ) : esc_html( $title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
      <p><?php echo esc_html( $lead ); ?></p>
      <div class="test-meta">
        <?php foreach ( $badges as $b ) : ?>
          <span><?php echo esc_html( isset( $b['text'] ) ? $b['text'] : '' ); ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="wrap" data-reveal>
    <div data-test-cats-wrap>
      <div class="test-cats" data-test-cats></div>
    </div>

    <div class="test-board" data-test-board hidden>
      <div class="test-board__main">
        <div class="test-stage" data-test-stage>
          <div class="test-card">
            <div class="test-progress">
              <div class="test-progress__bar"><i data-test-bar></i></div>
              <span class="test-progress__label" data-test-label>1 / 8</span>
            </div>
            <h2 class="test-q" data-test-q></h2>
            <div class="test-opts" data-test-opts></div>
            <div class="test-nav">
              <button class="btn btn--line" type="button" data-test-back>Назад</button>
            </div>
          </div>
        </div>

        <div class="test-result" data-test-result>
          <div class="test-result__card test-card test-result__main">
            <span class="test-result__badge" data-test-badge>Результат</span>
            <h2 data-test-title></h2>
            <p data-test-text></p>
            <div class="test-brief">
              <h3 data-test-brief-heading><?php
				$bh = function_exists( 'get_field' ) ? (string) get_field( 'test_brief_heading', $pid ) : '';
				echo esc_html( $bh ? $bh : 'Бриф для врача' );
				?></h3>
              <ul data-test-brief></ul>
            </div>
            <p class="test-result__note" data-test-result-note><?php
				$rn = function_exists( 'get_field' ) ? (string) get_field( 'test_result_note', $pid ) : '';
				echo esc_html( $rn ? $rn : 'Тест носит информационный характер и не заменяет очный осмотр. 18+. Имеются противопоказания.' );
				?></p>
            <div class="test-nav" style="margin-top:18px">
              <button class="btn btn--line" type="button" data-test-restart><?php
				$rl = function_exists( 'get_field' ) ? (string) get_field( 'test_restart_label', $pid ) : '';
				echo esc_html( $rl ? $rl : 'Пройти другой тест' );
				?></button>
              <a class="btn btn--blue" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
            </div>
          </div>
        </div>
      </div>

      <aside class="test-board__side" data-test-side aria-hidden="true">
        <div class="test-board__side-inner test-result__card test-result__side">
          <h3><?php echo esc_html( $side_t ); ?></h3>
          <p><?php echo esc_html( $side_p ); ?></p>
          <form class="form" data-form data-alba-lead data-test-lead>
            <div class="form__fields">
              <input type="hidden" name="program" data-test-cat-field value="Тест-бриф">
              <input type="hidden" name="test_score" data-test-score-field value="">
              <input type="hidden" name="test_brief" data-test-brief-field value="">
              <label for="test-phone">Телефон</label>
              <input id="test-phone" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
              <button class="btn btn--blue" type="submit">Жду звонка <?php echo alba_arr(); // phpcs:ignore ?></button>
              <a class="btn btn--line" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel data-no-arr>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ); ?></span></a>
            </div>
            <div class="form__ok">Заявка принята. Дежурный врач перезвонит с учётом вашего брифа.</div>
          </form>
        </div>
      </aside>
    </div>
  </section>

  <section class="cta wrap">
    <div class="cta__box" data-reveal="scale">
      <div>
        <h2><?php echo esc_html( $cta_t ); ?></h2>
        <p><?php echo esc_html( $cta_p ); ?></p>
      </div>
      <div class="cta__actions">
        <a class="btn btn--light" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
        <a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel data-no-arr>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ); ?></span></a>
      </div>
    </div>
  </section>
</main>
<?php
get_footer();
