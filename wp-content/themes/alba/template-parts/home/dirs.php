<?php
/**
 * Home module: dirs
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h = trim( (string) ( $b['heading'] ?? '' ) );
$l = trim( (string) ( $b['lead'] ?? '' ) );
?>
<section class="dirs dirs--compact wrap">
      <h2 class="section-title" data-reveal>Направления деятельности</h2>
    </section>
<div class="dirs__bar wrap" data-dirs data-reveal>
        <div class="dirs__drop" data-dirs-drop>
          <button type="button" class="dirs__btn" data-dirs-btn aria-expanded="false">
            Наркология — алкоголь
            <span class="dirs__chev" aria-hidden="true"></span>
          </button>
          <div class="dirs__menu" data-dirs-menu hidden>
            <a href="<?php echo esc_url( alba_city_url( 'service-consult' ) ); ?>">Консультация психиатра-нарколога</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-help' ) ); ?>">Наркологическая помощь на дому</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-zapoy' ) ); ?>">Срочный вывод из запоя на дому</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-visit' ) ); ?>">Нарколог на дом</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-code-home' ) ); ?>">Кодирование на дому</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-alcohol' ) ); ?>">Лечение алкоголизма</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-alcohol-hangover' ) ); ?>">Капельница от алкоголя</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-detox' ) ); ?>">Прокапаться от алкоголя в стационаре</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab-alcohol' ) ); ?>">Курс реабилитации при алкоголизме</a>
          </div>
        </div>
        <div class="dirs__drop" data-dirs-drop>
          <button type="button" class="dirs__btn" data-dirs-btn aria-expanded="false">
            Помощь при наркомании
            <span class="dirs__chev" aria-hidden="true"></span>
          </button>
          <div class="dirs__menu" data-dirs-menu hidden>
            <a href="<?php echo esc_url( alba_city_url( 'service-drugs' ) ); ?>">Капельница от наркотиков</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-drugs' ) ); ?>">Лечение наркомании</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-detox' ) ); ?>">Прокапаться от наркотиков в стационаре</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-withdrawal' ) ); ?>">Снятие ломки</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Курс реабилитации при наркомании</a>
          </div>
        </div>
        <div class="dirs__drop" data-dirs-drop>
          <button type="button" class="dirs__btn" data-dirs-btn aria-expanded="false">
            Психиатрия
            <span class="dirs__chev" aria-hidden="true"></span>
          </button>
          <div class="dirs__menu" data-dirs-menu hidden>
            <a href="<?php echo esc_url( alba_city_url( 'service-psychiatry' ) ); ?>">Все направления психиатрии</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-first' ) ); ?>">Первичная консультация</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-followup' ) ); ?>">Повторная консультация</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-online' ) ); ?>">Онлайн-консультация</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-home' ) ); ?>">Выезд врача на дом</a>
            <span class="dirs__label">Состояния</span>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-depression' ) ); ?>">Депрессия</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-anxiety' ) ); ?>">Тревога</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-ocd' ) ); ?>">Навязчивые мысли и действия</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-bipolar' ) ); ?>">Колебания настроения</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-sleep' ) ); ?>">Нарушения сна</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-panic' ) ); ?>">Панические атаки</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-somatic' ) ); ?>">Соматические симптомы на фоне тревоги</a>
            <span class="dirs__label">Хронические заболевания</span>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-chronic' ) ); ?>">Хронические психические заболевания</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-bpd' ) ); ?>">Расстройства личности</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-schizophrenia' ) ); ?>">Эндогенные заболевания</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-meds' ) ); ?>">Подбор поддерживающей терапии</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-crisis-meds' ) ); ?>">Медикаментозная коррекция в обострение</a>
            <span class="dirs__label">Психотические расстройства</span>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-psychosis' ) ); ?>">Психотические расстройства</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-outpatient' ) ); ?>">Амбулаторное купирование симптомов</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-hospital' ) ); ?>">Консультирование по госпитализации</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-relatives' ) ); ?>">Помощь родственникам</a>
            <span class="dirs__label">Возраст и восстановление</span>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-elderly' ) ); ?>">Расстройства в пожилом возрасте</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-postcovid' ) ); ?>">Постковидные состояния</a>
          </div>
        </div>
        <div class="dirs__drop" data-dirs-drop>
          <button type="button" class="dirs__btn" data-dirs-btn aria-expanded="false">
            Психотерапия
            <span class="dirs__chev" aria-hidden="true"></span>
          </button>
          <div class="dirs__menu" data-dirs-menu hidden>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-therapist' ) ); ?>">Консультация психотерапевта</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-psychologist' ) ); ?>">Консультация психолога</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-counseling' ) ); ?>">Психотерапевтическое консультирование</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-family' ) ); ?>">Семейные отношения</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-compat' ) ); ?>">Психологическая совместимость</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-parenting' ) ); ?>">Детско-родительские отношения</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-apathy' ) ); ?>">Снижение мотивации</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-growth' ) ); ?>">Саморазвитие и личностный рост</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-psy-emotion' ) ); ?>">Эмоциональные и коммуникативные трудности</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-gambling' ) ); ?>">Лечение игромании</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-code' ) ); ?>">Лечение от курения</a>
          </div>
        </div>
        <div class="dirs__drop" data-dirs-drop>
          <button type="button" class="dirs__btn" data-dirs-btn aria-expanded="false">
            Реабилитация
            <span class="dirs__chev" aria-hidden="true"></span>
          </button>
          <div class="dirs__menu" data-dirs-menu hidden>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Реабилитация</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab-alcohol' ) ); ?>">Реабилитация при алкоголизме</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab' ) ); ?>">Реабилитация при наркомании</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab-12' ) ); ?>">Программа 12 шагов</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-rehab-daytop' ) ); ?>">Day Top</a>
            <a href="<?php echo esc_url( alba_city_url( 'service-sober' ) ); ?>">Поддержка трезвости</a>
          </div>
        </div>
    </div>

    
