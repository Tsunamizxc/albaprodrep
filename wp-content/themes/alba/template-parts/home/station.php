<?php
/**
 * Home module: station
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="station wrap">
      <div class="station__card" data-reveal="left">
        <h2 class="section-title">Стационар, в котором<br>не стыдно остаться</h2>
        <p>Одноместные палаты, отдельный вход, пост медсестры. Посторонние не ходят по коридору «посмотреть».</p>
        <ul class="station__list">
          <li><i>01</i><span>Монитор, инфузии и сон в первые сутки — не «капельница на час».</span></li>
          <li><i>02</i><span>Комната для индивидуальной и семейной сессии, не актовый зал.</span></li>
          <li><i>03</i><span>Документы оформляем в палате. Работодателю не звоним.</span></li>
          <li><i>04</i><span>Если дома безопаснее — выезд без опознавательных знаков.</span></li>
        </ul>
      </div>
      <div class="station__aside">
        <article class="split-card" data-reveal>
          <h3>Рассрочка без театра</h3>
          <p>Без похода в банк в рекламном ролике. Условия — в договоре, после осмотра.</p>
          <ul>
            <li>Без скрытой комиссии в мелком шрифте</li>
            <li>Без «одобрения за 5 минут» с чужого телефона</li>
            <li>Первый платёж можно обсудить до заезда</li>
          </ul>
          <a class="more" href="#" data-open-modal>Оставить заявку на рассрочку</a>
        </article>
        <article class="pay-card" data-reveal data-delay="80">
          <h3>Как платить</h3>
          <p>Называем сумму до выезда. Не добавляем «расходники» после капельницы.</p>
          <div class="pay-row">
            <span>Карта</span><span>Наличные</span><span>Безнал</span><span>Рассрочка</span>
          </div>
        </article>
      </div>
    </section>
