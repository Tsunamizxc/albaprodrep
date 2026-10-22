<?php
/**
 * Home module: offers
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="offers wrap">
      <h2 class="section-title split">Помощь, которую ищут<br>сейчас</h2>
      <div class="offer-grid">
        
        <article class="offer" data-offer data-offer-group="zapoy" data-reveal data-tilt>
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">
            <span>Срочно · на дом</span>
            <h3>Срочный вывод из запоя на дому</h3>
            <p>Инфузия и стабилизация дома под контролем давления, сна и сердечного ритма.</p>
            <ul class="offer__feats"><li>Круглосуточный выезд</li><li>Контроль давления и ЭКГ-рисков</li><li>Сон и восстановление за сутки</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 1 300 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Вывод из запоя 1 день</span><em>от 8 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy-1day' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Курс 3 дня</span><em>от 24 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy-3days' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Курс 5 дней</span><em>от 39 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy-5days' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Курс 7 дней</span><em>от 54 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy-7days' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Вывод из запоя</span><em>от 1 300 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Капельница от похмелья</span><em>от 2 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-hangover' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение на дому</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-home' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Детокс 24/7</span><em>от 8 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-detox' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Выезд нарколога</span><em>от 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-visit' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Частный вытрезвитель</span><em>от 6 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-sober' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="alcohol" data-reveal data-tilt data-delay="60">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>">
            <span>Алкоголь</span>
            <h3>Лечение алкогольной зависимости</h3>
            <p>Не «капельница и всё». Детокс, психиатр и план, который человек принимает осознанно.</p>
            <ul class="offer__feats"><li>Индивидуальный протокол</li><li>Стационар или дом</li><li>Сопровождение семьи</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 1 380 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Лечение алкоголизма</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение женского алкоголизма</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-women' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение мужского алкоголизма</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-men' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение пивного алкоголизма</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-beer' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение винного алкоголизма</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-wine' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение старческого алкоголизма</span><em>от 6 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-alcohol-elderly' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Кодирование</span><em>от 7 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="code" data-reveal data-tilt data-delay="80">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>">
            <span>После стабилизации</span>
            <h3>Кодирование от алкоголя</h3>
            <p>Методы называем вслух. Наблюдение 30 дней — без кодирования «с порога».</p>
            <ul class="offer__feats"><li>Подбор метода после осмотра</li><li>Письменный протокол</li><li>Контроль в течение месяца</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 1 720 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Кодирование</span><em>от 7 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Торпедо</span><em>от 9 300 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code-torpedo' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Эспераль</span><em>от 7 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code-esperal' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Двойной блок</span><em>от 8 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code-double' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Метод Довженко</span><em>от 9 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code-dovzhenko' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Вивитрол</span><em>от 28 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-code-vivitrol' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Раскодирование</span><em>от 5 600 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-decode' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="visit" data-reveal data-tilt data-delay="100">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-visit' ) ); ?>">
            <span>На дом</span>
            <h3>Вызов нарколога</h3>
            <p>Врач приезжает с набором для стабилизации. Решаем на месте: остаётесь дома или едете в палату.</p>
            <ul class="offer__feats"><li>Выезд от 40 минут</li><li>Анонимно, без уведомлений</li><li>Капельница и осмотр на месте</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 700 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-visit' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Вызов нарколога</span><em>от 700 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-visit' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Вывод из запоя</span><em>от 1 300 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Наркологическая скорая</span><em>от 1 450 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-ambulance' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Детокс</span><em>от 8 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-detox' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Консультация</span><em>0 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-consult' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="drugs" data-reveal data-tilt>
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-drugs' ) ); ?>">
            <span>Наркотики</span>
            <h3>Помощь при зависимости</h3>
            <p>Ломка, УБОД, вещества по отдельности — без общих палат и случайных соседей.</p>
            <ul class="offer__feats"><li>Отдельная палата</li><li>Купирование абстиненции</li><li>Психиатр в команде</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 18 900 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-drugs' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Лечение наркомании</span><em>от 18 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugs' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Снятие ломки</span><em>от 12 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-withdrawal' ) ); ?>">Перейти</a></div><div class="offer-price"><span>УБОД</span><em>от 45 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-ubod' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение от солей</span><em>от 18 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugs-salts' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение от спайсов</span><em>от 18 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugs-spice' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение от мефедрона</span><em>от 18 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugs-mephedrone' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение от героина</span><em>от 22 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugs-heroin' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="gambling" data-reveal data-tilt data-delay="60">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-gambling' ) ); ?>">
            <span>Поведение</span>
            <h3>Игровая зависимость</h3>
            <p>Ставки, казино, «ещё одна линия». Работаем с семьёй и триггерами, не с запретами.</p>
            <ul class="offer__feats"><li>Психотерапевт и психиатр</li><li>Семейные сессии</li><li>План контроля импульса</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 12 000 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-gambling' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Лечение игровой зависимости</span><em>от 12 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-gambling' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение от ставок на спорт</span><em>от 12 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-betting' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Семейная программа</span><em>от 12 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-family' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Психотерапевт</span><em>от 4 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-psy-therapist' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="rehab" data-reveal data-tilt data-delay="80">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">
            <span>21 день</span>
            <h3>Реабилитация</h3>
            <p>Алкоголь и наркотики. 12 шагов и Day Top — по показаниям, без давления «секты».</p>
            <ul class="offer__feats"><li>Жилой модуль 24/7</li><li>Индивидуальный куратор</li><li>Поддержка после выписки</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 210 000 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Реабилитация</span><em>от 210 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Перейти</a></div><div class="offer-price"><span>12 шагов</span><em>от 210 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-rehab-12' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Day Top</span><em>от 210 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-rehab-daytop' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение алкоголизма, реабилитация</span><em>от 210 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-rehab-alcohol' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Поддержка трезвости</span><em>от 6 900 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-sober' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
        <article class="offer" data-offer data-offer-group="help" data-reveal data-tilt data-delay="100">
          <a class="offer__main" href="<?php echo esc_url( alba_city_url( 'service-help' ) ); ?>">
            <span>24/7</span>
            <h3>Наркологическая помощь</h3>
            <p>Скорая, тест, токсиколог, ломка. Один номер — отвечает врач, не колл-центр.</p>
            <ul class="offer__feats"><li>Круглосуточный пост</li><li>Экстренный выезд</li><li>Маршрут без очереди</li></ul>
          </a>
          <div class="offer__foot">
            <b>от 2 500 ₽</b>
            <div class="offer__actions"><a class="offer__cta" href="<?php echo esc_url( alba_city_url( 'service-help' ) ); ?>">Подробнее</a>
            </div>
          </div>
          <div class="offer-prices">
            <div class="offer-prices__list"><div class="offer-price"><span>Наркологическая помощь</span><em>от 2 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-help' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Скорая</span><em>от 1 450 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-ambulance' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Лечение ломки</span><em>от 12 000 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-withdrawal' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Наркотест</span><em>от 3 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-drugtest' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Токсиколог</span><em>от 4 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-toxicologist' ) ); ?>">Перейти</a></div><div class="offer-price"><span>Психиатрия</span><em>от 4 500 ₽</em><a href="<?php echo esc_url( alba_city_url( 'service-psychiatry' ) ); ?>">Перейти</a></div></div>
          </div>
        </article>
      
      </div>
      <div class="offers__lead" data-reveal>
        <p>Не уверены, какая программа нужна? Опишите ситуацию — дежурный нарколог подскажет за 5 минут, без обязательств.</p>
        <a class="btn btn--blue" href="#" data-open-modal>Получить консультацию <span class="arr"><svg viewBox="0 0 14 14" fill="none"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span></a>
      </div>
    </section>
