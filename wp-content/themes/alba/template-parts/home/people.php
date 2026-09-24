<?php
/**
 * Home module: people
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="people wrap" data-doctors>
      <div class="people__head">
        <div class="people__intro">
          <h2 class="section-title" data-reveal>Наши специалисты</h2>
          <p class="people__lead" data-reveal>Выездные бригады, амбулаторный приём и стационарное отделение — три контура помощи. Можно выбрать специалиста ещё до визита.</p>
          <a class="pd-badge" href="https://prodoctorov.ru/" target="_blank" rel="noopener" data-reveal>
            <img src="<?php echo esc_url( home_url( '/images/' ) ); ?>prodoctorov-logo.png" alt="ПроДокторов" width="120" height="24">
            <span class="pd-badge__score">4.8 <i>★</i></span>
            <span class="pd-badge__text">Рекомендуют пациенты</span>
          </a>
        </div>
        <div class="people__tools">
          <div class="people__nav">
            <button type="button" class="people__btn" data-docs-prev aria-label="Предыдущий">←</button>
            <button type="button" class="people__btn" data-docs-next aria-label="Следующий">→</button>
          </div>
          <a class="btn btn--line" href="<?php echo esc_url( alba_city_url( 'doctors' ) ); ?>">Вся команда</a>
        </div>
      </div>
      <div class="people__switch" data-docs-switch role="tablist" aria-label="Тип приёма" data-reveal>
        <button type="button" class="is-on" data-docs-filter="field" role="tab" aria-selected="true">Выездные врачи / фельдшера</button>
        <button type="button" data-docs-filter="ambulatory" role="tab" aria-selected="false">Амбулаторная служба</button>
        <button type="button" data-docs-filter="stationary" role="tab" aria-selected="false">Стационарное отделение</button>
      </div>
      <div class="people__viewport swiper" data-reveal data-docs-swiper>
        <div class="swiper-wrapper" data-docs-track>
          <article class="swiper-slide person" data-docs-card data-spec="field">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-5.jpg" alt="Морозов Павел Игоревич" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Морозов Павел Игоревич</h3>
              <p class="person__spec">Врач-нарколог выездной бригады</p>
              <p class="person__exp">Стаж 11 лет</p>
              <p class="person__desc">Срочный выезд, вывод из запоя и стабилизация на дому до решения о госпитализации.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-morozov' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="field">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-6.jpg" alt="Кузнецова Анна Сергеевна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Кузнецова Анна Сергеевна</h3>
              <p class="person__spec">Фельдшер выездной бригады</p>
              <p class="person__exp">Стаж 9 лет</p>
              <p class="person__desc">Капельницы, мониторинг состояния и сопровождение врача на выезде.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-kuznetsova' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="field">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>doctor-1.jpg" alt="Волков Андрей Сергеевич" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Волков Андрей Сергеевич</h3>
              <p class="person__spec">Главный врач, куратор выездов</p>
              <p class="person__exp">Стаж 18 лет</p>
              <p class="person__desc">Маршрутизация сложных вызовов и протоколы тяжёлого абстинентного синдрома.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-volkov' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="ambulatory">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>doctor-2.jpg" alt="Сафонова Елена Викторовна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Сафонова Елена Викторовна</h3>
              <p class="person__spec">Психиатр-нарколог, к.м.н.</p>
              <p class="person__exp">Стаж 15 лет</p>
              <p class="person__desc">Сложные двойные диагнозы, первичная консультация пациента и семьи.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-safonova' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="ambulatory">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>doctor-4.jpg" alt="Орлова Мария Дмитриевна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Орлова Мария Дмитриевна</h3>
              <p class="person__spec">Клинический психолог</p>
              <p class="person__exp">Стаж 12 лет</p>
              <p class="person__desc">Реабилитация, созависимость и поддержка семьи после острого этапа.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-orlova' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="ambulatory">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-9.jpg" alt="Белова Наталья Юрьевна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Белова Наталья Юрьевна</h3>
              <p class="person__spec">Психотерапевт</p>
              <p class="person__exp">Стаж 13 лет</p>
              <p class="person__desc">Индивидуальная и семейная психотерапия при зависимостях и тревожных расстройствах.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-belova' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="ambulatory">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-2.jpg" alt="Ермолаева Ольга Викторовна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Ермолаева Ольга Викторовна</h3>
              <p class="person__spec">Медсестра амбулаторного приёма</p>
              <p class="person__exp">Стаж 8 лет</p>
              <p class="person__desc">Подготовка к процедурам, сопровождение приёма и контроль самочувствия.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-ermolaeva' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="stationary">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>doctor-3.jpg" alt="Лебедев Игорь Алексеевич" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Лебедев Игорь Алексеевич</h3>
              <p class="person__spec">Врач-нарколог, интенсивная терапия</p>
              <p class="person__exp">Стаж 14 лет</p>
              <p class="person__desc">Ночной детокс, мониторинг и вывод из запоя при сопутствующей кардиологии.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-lebedev' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="stationary">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-8.jpg" alt="Соколов Дмитрий Алексеевич" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Соколов Дмитрий Алексеевич</h3>
              <p class="person__spec">Врач-нарколог стационара</p>
              <p class="person__exp">Стаж 16 лет</p>
              <p class="person__desc">Ведение курса в отделении, коррекция терапии и план выписки.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-sokolov' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
          <article class="swiper-slide person" data-docs-card data-spec="stationary">
            <div class="person__photo"><img src="<?php echo esc_url( home_url( '/images/' ) ); ?>staff-7.jpg" alt="Петрова Ирина Валентиновна" loading="lazy" decoding="async"></div>
            <div class="person__meta">
              <h3>Петрова Ирина Валентиновна</h3>
              <p class="person__spec">Старшая медсестра стационара</p>
              <p class="person__exp">Стаж 17 лет</p>
              <p class="person__desc">Организация ухода, круглосуточный контроль и комфорт пациентов в палате.</p>
              <div class="person__actions">
                <a class="person__more" href="<?php echo esc_url( alba_city_url( 'doctor-petrova' ) ); ?>">Подробнее</a>
                <a class="btn btn--blue person__book" href="#" data-open-modal>Записаться</a>
              </div>
            </div>
          </article>
        </div>
      </div>
      <div class="people__dots swiper-pagination" data-docs-dots aria-label="Врачи"></div>
    </section>
