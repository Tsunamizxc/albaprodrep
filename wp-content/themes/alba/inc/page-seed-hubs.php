<?php
/**
 * Curated ACF seeds for hub pages (about, links, licenses, reviews, methods, sitemap).
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param string[] $texts Texts.
 * @return array<int, array{text:string}>
 */
function alba_seed_lines( array $texts ) {
	$out = array();
	foreach ( $texts as $t ) {
		$t = trim( (string) $t );
		if ( '' !== $t ) {
			$out[] = array( 'text' => $t );
		}
	}
	return $out;
}

/**
 * Parse sitemap.html into structured sitemap block.
 *
 * @return array|null
 */
function alba_parse_sitemap_legacy() {
	$path = trailingslashit( ABSPATH ) . 'legacy-html/sitemap.html';
	if ( ! file_exists( $path ) ) {
		return null;
	}
	$html = (string) file_get_contents( $path );
	if ( ! preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
		return null;
	}
	$main = $m[1];

	$jumps = array();
	if ( preg_match( '/<nav class="map-jump"[^>]*>([\s\S]*?)<\/nav>/i', $main, $nm ) ) {
		if ( preg_match_all( '/<a[^>]+href=["\']#([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>/i', $nm[1], $jm, PREG_SET_ORDER ) ) {
			foreach ( $jm as $row ) {
				$jumps[] = array(
					'label'  => trim( wp_strip_all_tags( $row[2] ) ),
					'anchor' => $row[1],
				);
			}
		}
	}

	$sections = array();
	if ( preg_match_all( '/<article class="map-block"[^>]*id=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/article>/i', $main, $arts, PREG_SET_ORDER ) ) {
		foreach ( $arts as $i => $art ) {
			$chunk  = $art[2];
			$anchor = $art[1];
			$num    = str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT );
			$title  = '';
			$lead   = '';
			if ( preg_match( '/map-block__n[^>]*>([^<]+)</i', $chunk, $nm ) ) {
				$num = trim( $nm[1] );
			}
			if ( preg_match( '/<h2>([\s\S]*?)<\/h2>/i', $chunk, $hm ) ) {
				$title = trim( wp_strip_all_tags( $hm[1] ) );
			}
			if ( preg_match( '/map-block__head[\s\S]*?<p>([\s\S]*?)<\/p>/i', $chunk, $pm ) ) {
				$lead = trim( wp_strip_all_tags( $pm[1] ) );
			}

			$groups = array();
			if ( preg_match_all( '/<div class="map-group">([\s\S]*?)<\/div>/i', $chunk, $gms, PREG_SET_ORDER ) ) {
				foreach ( $gms as $g ) {
					$gt = '';
					if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $g[1], $ghm ) ) {
						$gt = trim( wp_strip_all_tags( $ghm[1] ) );
					}
					$glinks = alba_parse_map_links( $g[1] );
					if ( $glinks ) {
						$groups[] = array(
							'title' => $gt,
							'links' => $glinks,
						);
					}
				}
			}

			$links = array();
			if ( ! $groups ) {
				$links = alba_parse_map_links( $chunk );
			}

			$sections[] = array(
				'anchor' => $anchor,
				'number' => $num,
				'title'  => $title,
				'lead'   => $lead,
				'links'  => $links,
				'groups' => $groups,
			);
		}
	}

	$note = '';
	if ( preg_match( '/class="map-note"[^>]*>([\s\S]*?)<\/p>/i', $main, $nm ) ) {
		$note = trim( wp_strip_all_tags( $nm[1] ) );
	}

	return array(
		'acf_fc_layout' => 'sitemap',
		'jumps'         => $jumps,
		'sections'      => $sections,
		'note'          => $note,
	);
}

/**
 * @param string $html Chunk.
 * @return array<int, array{label:string,url:string}>
 */
function alba_parse_map_links( $html ) {
	$links = array();
	if ( ! preg_match( '/<div class="map-links">([\s\S]*?)<\/div>/i', $html, $m ) ) {
		return $links;
	}
	if ( preg_match_all( '/<a[^>]+href=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>/i', $m[1], $mm, PREG_SET_ORDER ) ) {
		foreach ( $mm as $row ) {
			$url = trim( $row[1] );
			// Keep legacy filename stem; alba_block_href resolves service-/doctor-/article-.
			$url = preg_replace( '#^\./#', '', $url );
			$links[] = array(
				'label' => trim( wp_strip_all_tags( $row[2] ) ),
				'url'   => $url,
			);
		}
	}
	return $links;
}

/**
 * Seed one of the premium hub pages.
 *
 * @param string $slug Page slug.
 * @return array{hero_title:string,hero_lead:string,chips:array,blocks:array}|null
 */
function alba_hub_page_payload( $slug ) {
	switch ( $slug ) {
		case 'about':
			return array(
				'hero_title' => 'О клинике «Альба»',
				'hero_lead'  => 'Помогаем людям с зависимостью и их близким пройти путь от стабилизации до возвращения к привычной жизни — конфиденциально, профессионально и без осуждения.',
				'chips'      => array(
					array( 'title' => 'Круглосуточно', 'text' => 'Специалист на связи 24/7' ),
					array( 'title' => 'Конфиденциально', 'text' => 'Соблюдаем врачебную тайну' ),
					array( 'title' => 'Два формата', 'text' => 'Стационар и помощь на дому' ),
				),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'stats',
						'items'         => array(
							array( 'value_type' => 'count', 'value' => '2014', 'label' => 'Год основания' ),
							array( 'value_type' => 'text', 'value' => '24/7', 'label' => 'Принимаем без выходных' ),
							array( 'value_type' => 'city_name', 'value' => 'Омск', 'label' => '' ),
							array( 'value_type' => 'city_license', 'value' => '', 'label' => 'Медицинская лицензия' ),
						),
					),
					array(
						'acf_fc_layout' => 'text_image',
						'heading'       => 'Место, где помогают|без давления и осуждения',
						'paragraphs'    => alba_seed_lines(
							array(
								'«Альба» — наркологическая клиника, объединяющая медицинскую помощь, психотерапию и реабилитацию. Мы работаем не только с физическими проявлениями зависимости, но и с причинами, которые мешают сохранять трезвость.',
								'План помощи составляется после оценки состояния. Пациент и близкие понимают, что происходит сейчас и какие шаги могут потребоваться дальше.',
							)
						),
						'list'          => alba_seed_lines(
							array(
								'Добровольное лечение с информированным согласием пациента (18+)',
								'Индивидуальный план с учётом состояния и противопоказаний',
								'Поддержка родственников на разных этапах',
								'Стационарный и выездной форматы помощи',
							)
						),
						'image_url'     => 'images/clinic-hall.jpg',
						'image_alt'     => 'Интерьер клиники Альба',
						'image_right'   => 1,
					),
					array(
						'acf_fc_layout' => 'funnel',
						'variant'       => 'form',
						'title'         => 'Перезвоним за 2 минуты',
						'text'          => 'Дежурный врач подскажет формат: дом, стационар или консультация. Имя можно не называть.',
						'chips'         => array(
							array( 'text' => '24/7' ),
							array( 'text' => 'Анонимно' ),
							array( 'text' => '18+' ),
						),
					),
					array(
						'acf_fc_layout' => 'cards',
						'style'         => 'pillars',
						'heading'       => 'Помощь не заканчивается|после улучшения самочувствия',
						'lead'          => 'Комплексный подход: физическое состояние, психологические причины и возвращение к повседневной жизни.',
						'items'         => array(
							array( 'title' => 'Медицинская помощь', 'text' => 'Осмотр, оценка рисков, детоксикация и наблюдение по показаниям.' ),
							array( 'title' => 'Психотерапия', 'text' => 'Работа с причинами зависимости, мотивацией и способами справляться.' ),
							array( 'title' => 'Реабилитация', 'text' => 'Восстановление режима, навыков общения и устойчивости к срыву.' ),
							array( 'title' => 'Работа с близкими', 'text' => 'Консультации помогают семье выстроить границы без давления.' ),
						),
					),
					array(
						'acf_fc_layout' => 'funnel',
						'variant'       => 'call',
						'title'         => 'Не уверены, куда обращаться?',
						'text'          => 'Коротко опишите ситуацию — подскажем следующий шаг без давления.',
					),
					array(
						'acf_fc_layout' => 'steps',
						'heading'       => 'Как начинается|и продолжается помощь',
						'lead'          => 'Понятный процесс снижает тревогу: каждый следующий шаг обсуждается с пациентом.',
						'items'         => array(
							array( 'title' => 'Обращение', 'text' => 'Звонок или заявка для конфиденциальной консультации.' ),
							array( 'title' => 'Оценка', 'text' => 'Специалист уточняет симптомы, возраст и важные особенности.' ),
							array( 'title' => 'Осмотр', 'text' => 'Анамнез, риски и подходящий формат — дом или палата.' ),
							array( 'title' => 'План помощи', 'text' => 'Назначения и понятное объяснение следующих действий.' ),
							array( 'title' => 'Поддержка', 'text' => 'При необходимости — психотерапия, реабилитация, работа с близкими.' ),
						),
					),
					array(
						'acf_fc_layout' => 'gallery',
						'style'         => 'about',
						'heading'       => 'Спокойное пространство|для восстановления',
						'lead'          => 'Светлые кабинеты, зоны ожидания и палаты стационара. Можно приехать посмотреть заранее.',
						'button'        => 'Смотреть галерею',
						'button_url'    => 'gallery',
						'items'         => array(
							array( 'image_url' => 'images/clinic-room.jpg', 'alt' => 'Палата' ),
							array( 'image_url' => 'images/clinic-hall.jpg', 'alt' => 'Холл' ),
							array( 'image_url' => 'images/clinic-bright.jpg', 'alt' => 'Кабинет' ),
							array( 'image_url' => 'images/clinic-consult.jpg', 'alt' => 'Консультация' ),
						),
					),
					array(
						'acf_fc_layout' => 'team',
						'heading'       => 'Команда клиники',
						'lead'          => 'Врачи-наркологи, психиатры и психотерапевты работают с пациентом на разных этапах лечения и восстановления.',
						'button'        => 'Смотреть врачей',
						'button_url'    => 'doctors',
					),
					array(
						'acf_fc_layout' => 'timeline',
						'heading'       => 'История клиники|и команды',
						'items'         => array(
							array( 'year' => '2014', 'text' => 'Основание «Альбы» как небольшого стационара с отдельным входом и акцентом на сервис.' ),
							array( 'year' => '2016', 'text' => 'Расширение палат и круглосуточного дежурства нарколога.' ),
							array( 'year' => '2018', 'text' => 'Усилена помощь на дому и связка бригад со стационаром.' ),
							array( 'year' => '2020', 'text' => 'Полный цикл: медицина, психотерапия, реабилитация и поддержка родственников.' ),
							array( 'year' => '2022', 'text' => 'Онлайн-каналы связи рядом с телефоном — быстрее консультация для семьи.' ),
							array( 'year' => '2024–2026', 'text' => 'Персональные программы и более понятный маршрут пациента.' ),
						),
					),
					array(
						'acf_fc_layout' => 'cards',
						'style'         => 'anon',
						'anchor'        => 'anon',
						'heading'       => 'Анонимность —|не слоган, а регламент',
						'items'         => array(
							array( 'icon' => 'lock', 'title' => 'Отдельный вход', 'text' => 'Пациенты не пересекаются в холле. Документы можно оформить в палате.' ),
							array( 'icon' => 'docs', 'title' => 'Закрытые документы', 'text' => 'Диагноз не уходит работодателю без вашего письменного согласия. Возможен псевдоним.' ),
							array( 'icon' => 'pin', 'title' => 'Лицензия', 'text' => 'Работаем на основании медицинской лицензии. Документы — в разделе «Лицензии».' ),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Почему выбирают|клинику Альба',
						'sections'      => array(
							array(
								'title'      => 'Медицина без театра',
								'paragraphs' => alba_seed_lines(
									array(
										'Мы не продаём «чудесный укол навсегда». Сначала безопасность: осмотр, оценка рисков, понятный протокол. Затем — медикаментозная поддержка, психотерапия и план после выписки.',
										'Стационар и выезд работают в одной логике: родственники получают маршрут, а не обещания. Это снижает тревогу и помогает не сорваться на следующий день после улучшения самочувствия.',
									)
								),
								'list'       => array(),
							),
							array(
								'title'      => 'Кому подходит обращение',
								'paragraphs' => array(),
								'list'       => alba_seed_lines(
									array(
										'Алкогольная или наркотическая зависимость у взрослых 18+',
										'Запой, абстиненция, необходимость детокса в палате или на дому',
										'Подготовка к кодированию и реабилитации по показаниям',
										'Семья, которой нужна консультация без давления на пациента',
									)
								),
								'ordered'    => 0,
							),
						),
						'note'          => 'Принудительное лечение не проводим. При угрозе жизни вызывайте 112.',
					),
					array(
						'acf_fc_layout' => 'faq',
						'heading'       => 'Частые вопросы|о клинике',
						'items'         => array(
							array( 'q' => 'Обращение действительно конфиденциально?', 'a' => 'Да. Информация об обращении и состоянии относится к врачебной тайне. Персональные данные обрабатываются по закону.' ),
							array( 'q' => 'Можно получить консультацию без записи на лечение?', 'a' => 'Да. Специалист уточнит ситуацию, ответит на вопросы и объяснит возможные шаги. Решение о лечении — после полной информации.' ),
							array( 'q' => 'Может ли родственник обратиться без пациента?', 'a' => 'Да. Родственник может описать ситуацию и узнать, как подготовиться к разговору. Плановое лечение — только с добровольного согласия пациента 18+.' ),
							array( 'q' => 'Как выбрать дом или стационар?', 'a' => 'Формат зависит от состояния, длительности употребления, сопутствующих заболеваний и рисков. Решение принимает врач после оценки.' ),
							array( 'q' => 'Что делать при резком ухудшении?', 'a' => 'При потере сознания, судорогах, нарушении дыхания или боли в груди немедленно вызывайте скорую по номеру 112.' ),
						),
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Начните с разговора|со специалистом',
						'text'          => 'Объясним, как оценить ситуацию и предложить помощь без давления. 18+. Добровольно.',
					),
				),
			);

		case 'links':
			return array(
				'hero_title' => 'Официальные источники|и страницы клиники',
				'hero_lead'  => 'Реестры, законы и наши документы. Без каталогов «лечения через силу» и без чужих прайсов.',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'links',
						'heading'       => '',
						'lead'          => '',
						'items'         => array(
							array( 'eyebrow' => 'Лицензии', 'label' => 'Росздравнадзор', 'url' => 'https://roszdravnadzor.gov.ru/', 'text' => 'Сайт службы. Номер нашей лицензии — на странице лицензий, проверяйте в реестре.' ),
							array( 'eyebrow' => 'Здравоохранение', 'label' => 'Минздрав России', 'url' => 'https://minzdrav.gov.ru/', 'text' => 'Нормативные документы и разъяснения по медицинской помощи.' ),
							array( 'eyebrow' => 'Закон', 'label' => 'ФЗ-323 об охране здоровья', 'url' => 'https://www.consultant.ru/document/cons_doc_LAW_31908/', 'text' => 'Права пациента, добровольность, врачебная тайна. 18+.' ),
							array( 'eyebrow' => 'Персональные данные', 'label' => 'ФЗ-152 о персональных данных', 'url' => 'https://www.consultant.ru/document/cons_doc_LAW_61873/', 'text' => 'Как должны обрабатываться сведения. Наша политика — отдельно.' ),
							array( 'eyebrow' => 'Клиника', 'label' => 'Реквизиты Альбы', 'url' => 'legal', 'text' => 'ИНН, ОГРН, лицензия, адрес. Для договора и бухгалтерии.' ),
							array( 'eyebrow' => 'Клиника', 'label' => 'Цены программ', 'url' => 'prices', 'text' => 'Прайс до заезда. Не оферта, сумма фиксируется после осмотра.' ),
							array( 'eyebrow' => 'Клиника', 'label' => 'Методы помощи', 'url' => 'methods', 'text' => 'Детокс, кодирование по показаниям, реабилитация, психиатрия.' ),
							array( 'eyebrow' => 'Навигация', 'label' => 'Карта сайта', 'url' => 'sitemap', 'text' => 'Все разделы без поиска наугад. Если страницы нет — напишите в контакты.' ),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Зачем отдельная|страница ссылок',
						'paragraphs'    => alba_seed_lines(
							array(
								'Пациенты и родственники часто просят «доказательства»: лицензию, реквизиты, нормы закона. Мы собрали официальные источники рядом со страницами клиники — чтобы не искать наугад и не путать нас с чужими каталогами.',
								'Если нужна выписка из реестра или копия лицензии для договора — оставьте заявку: администратор пришлёт номер и актуальные данные по городу.',
							)
						),
						'sections'      => array(),
						'note'          => '',
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Не нашли нужный документ',
						'text'          => 'Позвоните. Администратор пришлёт номер лицензии или реквизиты.',
					),
				),
			);

		case 'licenses':
			return array(
				'hero_title' => 'Лицензия на медицинскую|деятельность',
				'hero_lead'  => 'Работаем по лицензии. Номер меняется вместе с городом. Сканы чужих бланков не публикуем — проверяйте запись в реестре Росздравнадзора.',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'license_cards',
						'items'         => array(
							array(
								'eyebrow'           => 'Действующая лицензия',
								'title'             => '',
								'text'              => 'Выдана территориальным органом Росздравнадзора. При смене города на сайте подставляется номер клиники в этом регионе.',
								'list'              => array(),
								'wide'              => 0,
								'use_city_license'  => 1,
							),
							array(
								'eyebrow'          => 'Оператор',
								'title'            => 'ООО «Альба Медикал»',
								'text'             => 'ИНН 5501234560 · ОГРН 1225500012345 · КПП 550101001. Полные реквизиты — на странице юридической информации.',
								'list'             => array(),
								'wide'             => 0,
								'use_city_license' => 0,
							),
							array(
								'eyebrow'          => 'Виды помощи',
								'title'            => 'Что разрешено лицензией',
								'text'             => 'Помощь оказывается совершеннолетним пациентам, добровольно и после осмотра врача. Принудительное лечение мы не проводим.',
								'list'             => alba_seed_lines(
									array(
										'Наркология: осмотр, детокс, кодирование по показаниям, выезд врача',
										'Психиатрия: консультация психиатра, сопровождение в стационаре',
										'Анестезиология и реанимация в объёме, необходимом для детокса',
										'Клиническая лабораторная диагностика при поступлении',
									)
								),
								'wide'             => 1,
								'use_city_license' => 0,
							),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Как проверить|лицензию самостоятельно',
						'sections'      => array(
							array(
								'title'      => 'Реестр Росздравнадзора',
								'paragraphs' => alba_seed_lines(
									array(
										'Откройте официальный сайт службы и найдите запись по номеру лицензии вашего города (номер на этой странице подставляется автоматически). Не доверяйте чужим сканам с других сайтов — сверяйте номер в реестре.',
									)
								),
								'list'       => array(),
							),
							array(
								'title'      => 'Что мы не делаем',
								'paragraphs' => array(),
								'list'       => alba_seed_lines(
									array(
										'Не лечим принудительно и не госпитализируем «по заявлению родственников»',
										'Не принимаем пациентов младше 18 лет',
										'Не обещаем «кодирование навсегда» без осмотра и показаний',
									)
								),
							),
						),
						'note'          => 'Для договора можем прислать номер лицензии и выписку из реестра на телефон или почту.',
					),
					array(
						'acf_fc_layout' => 'related',
						'heading'       => 'Рядом по маршруту',
						'items'         => array(
							array( 'title' => 'Реквизиты', 'text' => 'ИНН и ОГРН', 'url' => 'legal', 'more' => 'Открыть' ),
							array( 'title' => 'Полезные ссылки', 'text' => 'Реестры и законы', 'url' => 'links', 'more' => 'Открыть' ),
							array( 'title' => 'Контакты', 'text' => 'Связь с клиникой', 'url' => 'contacts', 'more' => 'Открыть' ),
						),
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Нужна копия лицензии в договоре',
						'text'          => 'Пришлём номер и выписку из реестра на указанный телефон или почту.',
					),
				),
			);

		case 'reviews':
			return array(
				'hero_title' => 'Истории, которые|нам доверили',
				'hero_lead'  => 'Публикуем с согласия и без деталей, по которым можно узнать человека на работе.',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'info_story',
						'image_url'     => 'images/clinic-bright.jpg',
						'image_alt'     => 'Клиника Альба',
						'paragraphs'    => alba_seed_lines(
							array(
								'Отзыв — не рейтинг «пять звёзд за капельницу». Это то, что люди готовы сказать после детокса, кодирования или месяца тишины дома.',
								'Если история звучит как реклама чуда — мы её не ставим.',
							)
						),
						'list_heading'  => 'Что входит',
						'list'          => alba_seed_lines(
							array(
								'Можно оставить отзыв без имени',
								'Не публикуем диагнозы в открытую',
								'Жалобу можно сказать врачу',
							)
						),
						'button'        => 'Записаться',
					),
					array(
						'acf_fc_layout' => 'review_list',
						'heading'       => 'Отзывы пациентов|и близких',
						'lead'          => 'Короткие истории без «рекламного чуда» — только то, что люди готовы сказать после реальной помощи.',
						'items'         => array(
							array( 'featured' => 1, 'text' => 'Муж прошёл детокс и три недели реабилитации. На работе не узнали. Врачи говорили спокойно, без давления.', 'name' => 'Ольга, 47', 'role' => 'Супруга пациента' ),
							array( 'featured' => 0, 'text' => 'Вышел на пятый день без ломки и с понятным планом. Звонят после выписки — это важно.', 'name' => 'Дмитрий', 'role' => 'Детокс' ),
							array( 'featured' => 0, 'text' => 'Объяснили про сына без страшных слов. Семейная программа убрала крик из кухни.', 'name' => 'Анна', 'role' => 'Семья' ),
							array( 'featured' => 0, 'text' => 'Ломку снимали в палате, не на полу. Не обещали «навсегда». Обещали маршрут — его и дали.', 'name' => 'Игорь', 'role' => 'Наркомания' ),
							array( 'featured' => 0, 'text' => 'Кодирование сделали только когда я сам попросил. До этого — сон и еда.', 'name' => 'Сергей', 'role' => 'Кодирование' ),
							array( 'featured' => 0, 'text' => 'Ставки и запой шли вместе. Психиатр не читал мораль. Составили ограничения, которые я выдерживаю.', 'name' => 'Павел', 'role' => 'Игровая зависимость' ),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Как мы публикуем|отзывы',
						'sections'      => array(
							array(
								'title'      => 'Правила модерации',
								'paragraphs' => alba_seed_lines(
									array(
										'Мы убираем имена третьих лиц, названия работодателей и любые детали, по которым человека можно узнать без его согласия. Можно оставить отзыв анонимно.',
										'Не публикуем истории «вылечили за сутки навсегда» — такие обещания противоречат нашей практике. Жалобу можно передать врачу напрямую: это важнее красивого текста на сайте.',
									)
								),
								'list'       => array(),
							),
						),
						'note'          => 'Хотите удалить опубликованный отзыв — напишите нам, уберём.',
					),
					array(
						'acf_fc_layout' => 'steps',
						'heading'       => 'Как это проходит',
						'lead'          => '',
						'items'         => array(
							array( 'title' => 'Написать', 'text' => 'Через форму или врачу.' ),
							array( 'title' => 'Согласие', 'text' => 'Что можно показать.' ),
							array( 'title' => 'Публикация', 'text' => 'Без лишнего.' ),
						),
					),
					array(
						'acf_fc_layout' => 'faq',
						'heading'       => 'Вопросы|по отзывам',
						'items'         => array(
							array( 'q' => 'Можно удалить отзыв?', 'a' => 'Да, напишите нам — уберём публикацию.' ),
							array( 'q' => 'Можно без имени?', 'a' => 'Да. Достаточно инициалов или роли («супруга», «пациент»).' ),
							array( 'q' => 'Публикуете негатив?', 'a' => 'Конструктивную жалобу разбираем с врачом. Рекламные нападки и чужие диагнозы не размещаем.' ),
						),
					),
					array(
						'acf_fc_layout' => 'related',
						'heading'       => 'Рядом по маршруту',
						'items'         => array(
							array( 'title' => 'Врачи', 'text' => 'Кто ведёт', 'url' => 'doctors', 'more' => 'Открыть' ),
							array( 'title' => 'О нас', 'text' => 'Клиника', 'url' => 'about', 'more' => 'Открыть' ),
							array( 'title' => 'Контакты', 'text' => 'Связь', 'url' => 'contacts', 'more' => 'Открыть' ),
						),
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Хотите рассказать — без имени',
						'text'          => 'Дежурный врач на связи 24/7. Можно не называть имя.',
					),
				),
			);

		case 'methods':
			return array(
				'hero_title' => 'Методы, которые|называем вслух',
				'hero_lead'  => 'Не «авторская методика с закрытым составом». Препарат, срок, риск срыва — до согласия.',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'info_story',
						'image_url'     => 'images/clinic-consult.jpg',
						'image_alt'     => 'Консультация',
						'paragraphs'    => alba_seed_lines(
							array(
								'Довженко, дисульфирам, налтрексон, 12 шагов, дневник Шичко, элементы Day Top живут в разных этапах. Сначала безопасность, потом язык терапии.',
								'Если метод не подходит, мы не называем это саботажем.',
							)
						),
						'list_heading'  => 'Что входит',
						'list'          => alba_seed_lines(
							array(
								'Медикаментозный детокс',
								'Кодирование по списку методов',
								'Психотерапия и семья',
								'12 шагов и Day Top по желанию',
							)
						),
						'button'        => 'Записаться',
					),
					array(
						'acf_fc_layout' => 'atlas',
						'heading'       => 'Карта методов',
						'lead'          => 'Каждый метод — отдельная страница с показаниями, рисками и маршрутом. Без «закрытого состава».',
						'items'         => array(
							array( 'eyebrow' => 'Тело', 'title' => 'Детокс', 'text' => 'Монитор, инфузии, пост.', 'url' => 'service/detox' ),
							array( 'eyebrow' => 'Запрет', 'title' => 'Кодирование', 'text' => 'Все препараты и сессии.', 'url' => 'service/code' ),
							array( 'eyebrow' => 'Психотерапия', 'title' => 'Довженко', 'text' => 'Без зала зрителей.', 'url' => 'service/code-dovzhenko' ),
							array( 'eyebrow' => 'Привычка', 'title' => 'Шичко', 'text' => 'Дневник, не заговор.', 'url' => 'service/alcohol-shichko' ),
							array( 'eyebrow' => 'Сообщество', 'title' => '12 шагов', 'text' => 'Без обязательной веры.', 'url' => 'service/rehab-12' ),
							array( 'eyebrow' => 'Ритм', 'title' => 'Day Top', 'text' => 'Без перековки.', 'url' => 'service/rehab-daytop' ),
							array( 'eyebrow' => 'Опиоиды', 'title' => 'УБОД', 'text' => 'Только после допуска.', 'url' => 'service/ubod' ),
							array( 'eyebrow' => 'Психика', 'title' => 'Психиатрия', 'text' => 'Добровольно, 18+.', 'url' => 'service/psychiatry' ),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Как выбираем|метод вместе с вами',
						'sections'      => array(
							array(
								'title'      => 'Сначала безопасность',
								'paragraphs' => alba_seed_lines(
									array(
										'Детокс и стабилизация идут раньше кодирования. Мы не кодируем на фоне тяжёлой ломки и не подбираем препарат «по рекламе».',
										'После осмотра врач объясняет, что можно сейчас, что — через несколько дней, и какие риски срыва остаются после выписки.',
									)
								),
								'list'       => array(),
							),
							array(
								'title'      => 'Что обсуждаем до согласия',
								'paragraphs' => array(),
								'list'       => alba_seed_lines(
									array(
										'Препарат или психотерапевтический метод и срок действия',
										'Противопоказания и совместимость с хроническими заболеваниями',
										'План поддержки 30 дней после кода или выписки',
										'Роль семьи: границы без давления и морали',
									)
								),
								'ordered'    => 1,
							),
						),
						'note'          => '«Лучший метод» — тот, который вам показан. Универсальной схемы не существует.',
					),
					array(
						'acf_fc_layout' => 'steps',
						'heading'       => 'Как это проходит',
						'items'         => array(
							array( 'title' => 'Осмотр', 'text' => 'Что вообще можно.' ),
							array( 'title' => 'Выбор', 'text' => 'Вы понимаете метод.' ),
							array( 'title' => 'Сопровождение', 'text' => '30 дней после кода или выписки.' ),
						),
					),
					array(
						'acf_fc_layout' => 'faq',
						'heading'       => 'Вопросы|по методам',
						'items'         => array(
							array( 'q' => 'Какой метод лучший?', 'a' => 'Тот, который вам показан после осмотра. Универсального «лучшего» нет.' ),
							array( 'q' => 'Можно ли кодироваться сразу?', 'a' => 'Только если состояние позволяет. Часто сначала нужен детокс и сон.' ),
							array( 'q' => 'Обязательны ли 12 шагов?', 'a' => 'Нет. Предлагаем как один из форматов реабилитации — без обязательной веры.' ),
						),
					),
					array(
						'acf_fc_layout' => 'related',
						'heading'       => 'Рядом по маршруту',
						'items'         => array(
							array( 'title' => 'Кодирование', 'text' => 'Таблица методов', 'url' => 'service/code', 'more' => 'Открыть' ),
							array( 'title' => 'Реабилитация', 'text' => 'Программы', 'url' => 'service/rehab', 'more' => 'Открыть' ),
							array( 'title' => 'Лицензия', 'text' => 'Что разрешено', 'url' => 'licenses', 'more' => 'Открыть' ),
						),
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Подскажем, эта ли программа',
						'text'          => 'Дежурный врач на связи 24/7. Можно не называть имя.',
					),
				),
			);

		case 'sitemap':
			$sm = alba_parse_sitemap_legacy();
			$blocks = array();
			if ( $sm ) {
				$blocks[] = $sm;
			}
			$blocks[] = array(
				'acf_fc_layout' => 'essay',
				'heading'       => 'Как пользоваться|картой сайта',
				'paragraphs'    => alba_seed_lines(
					array(
						'Карта сайта — навигация по разделам клиники: о нас, врачи, срочная помощь, программы, психиатрия, статьи и документы. Это не прайс и не «этапы лечения» — сюда удобно возвращаться, если потерялись в меню.',
						'Быстрые якоря сверху ведут к блокам. Если страницы нет или ссылка устарела — напишите в контакты, подскажем актуальный адрес.',
					)
				),
				'sections'      => array(),
				'note'          => 'Адреса услуг открываются с учётом выбранного города в URL.',
			);
			$blocks[] = array(
				'acf_fc_layout' => 'cta',
				'title'         => 'Не нашли нужный раздел',
				'text'          => 'Оставьте заявку или позвоните — подскажем страницу и формат помощи.',
			);
			return array(
				'hero_title' => 'Карта сайта',
				'hero_lead'  => 'Все разделы Альбы в одном списке: клиника, врачи, программы и документы. Без прайса и без «этапов лечения» — это навигация.',
				'chips'      => array(),
				'blocks'     => $blocks,
			);

		case 'gallery':
			return array(
				'hero_title' => 'Как выглядит клиника|изнутри',
				'hero_lead'  => 'Отдельный вход со двора. Холл без регистратуры с очередью. Палаты на одного и двоих. Фотографии реальных помещений, без стоковых коридоров.',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'gallery',
						'style'         => 'default',
						'heading'       => '',
						'lead'          => '',
						'button'        => '',
						'button_url'    => '',
						'items'         => array(
							array( 'image_url' => 'images/clinic-hall.jpg', 'alt' => 'Холл клиники Альба', 'caption' => 'Холл и отдельный вход' ),
							array( 'image_url' => 'images/clinic-room.jpg', 'alt' => 'Палата стационара', 'caption' => 'Палата на одного' ),
							array( 'image_url' => 'images/clinic-consult.jpg', 'alt' => 'Кабинет консультации', 'caption' => 'Кабинет врача' ),
							array( 'image_url' => 'images/clinic-bright.jpg', 'alt' => 'Коридор клиники', 'caption' => 'Коридор стационара' ),
							array( 'image_url' => 'images/room-single.jpg', 'alt' => 'Одноместная палата', 'caption' => 'Одноместная палата' ),
							array( 'image_url' => 'images/room-double.jpg', 'alt' => 'Двухместная палата', 'caption' => 'Двухместная палата' ),
							array( 'image_url' => 'images/room-vip.jpg', 'alt' => 'VIP-палата', 'caption' => 'Усиленный комфорт' ),
							array( 'image_url' => 'images/room-stabilize.jpg', 'alt' => 'Палата стабилизации', 'caption' => 'Палата стабилизации' ),
							array( 'image_url' => 'images/clinic-hall.jpg', 'alt' => 'Зона ожидания', 'caption' => 'Зона ожидания для родственников' ),
							array( 'image_url' => 'images/clinic-consult.jpg', 'alt' => 'Консультационный кабинет', 'caption' => 'Разбор состояния без очереди' ),
							array( 'image_url' => 'images/clinic-bright.jpg', 'alt' => 'Светлый коридор', 'caption' => 'Светлые пространства' ),
							array( 'image_url' => 'images/clinic-room.jpg', 'alt' => 'Палата после детокса', 'caption' => 'Отдых после процедур' ),
						),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'Зачем смотреть|клинику заранее',
						'paragraphs'    => alba_seed_lines(
							array(
								'Многие родственники приезжают до заезда пациента: так спокойнее понять маршрут, отдельный вход и как устроены палаты. Можно согласовать время без очереди — имя на ресепшене не называют вслух.',
								'Фотографии показывают реальные помещения клиники Альба. При необходимости врач или администратор проведет короткую экскурсию до госпитализации.',
							)
						),
						'sections'      => array(),
						'note'          => '18+. Добровольное обращение. Имеются противопоказания.',
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Можно приехать посмотреть палату',
						'text'          => 'Согласуем время без очереди. Имя на ресепшене не называют вслух.',
					),
				),
			);

		case 'articles':
			return array(
				'hero_title' => 'Коротко и по делу:|что происходит в клинике',
				'hero_lead'  => 'Тексты пишут врачи Альбы. Без запугивания и без обещаний «навсегда за один укол».',
				'chips'      => array(),
				'blocks'     => array(
					array(
						'acf_fc_layout' => 'articles_grid',
						'heading'       => '',
						'lead'          => '',
						'from_posts'    => 1,
						'items'         => array(),
					),
					array(
						'acf_fc_layout' => 'essay',
						'heading'       => 'О чём пишем|в блоге клиники',
						'paragraphs'    => alba_seed_lines(
							array(
								'Статьи отвечают на вопросы, которые чаще всего задают пациенты и родственники: как проходит детокс, что означает анонимность юридически и как говорить с близким без давления.',
								'Мы не публикуем «рейтинги чудес» и не обещаем лечение за один укол. Каждый материал можно обсудить с дежурным врачом по телефону — анонимно, 18+.',
							)
						),
						'sections'      => array(),
						'note'          => '',
					),
					array(
						'acf_fc_layout' => 'cta',
						'title'         => 'Хотите разобрать ситуацию с врачом',
						'text'          => 'Оставьте номер — перезвоним и подскажем следующий шаг. Можно без имени.',
					),
				),
			);
	}

	return null;
}

/**
 * Apply hub payload to a page ID.
 *
 * @param int    $id   Page ID.
 * @param string $slug Slug.
 * @return bool
 */
function alba_seed_hub_page( $id, $slug ) {
	$payload = alba_hub_page_payload( $slug );
	if ( ! $payload || ! function_exists( 'update_field' ) ) {
		return false;
	}
	wp_update_post(
		array(
			'ID'           => $id,
			'post_content' => '',
		)
	);
	delete_field( 'page_body', $id );
	delete_field( 'home_main_html', $id );
	delete_field( 'page_mode', $id );

	update_field( 'hero_title', $payload['hero_title'], $id );
	update_field( 'hero_lead', $payload['hero_lead'], $id );
	update_field( 'page_chips', $payload['chips'], $id );
	update_field( 'page_blocks', $payload['blocks'], $id );

	// SEO defaults from hero.
	$seo_title = str_replace( '|', ' ', (string) $payload['hero_title'] );
	$seo_desc  = (string) $payload['hero_lead'];
	$seo_map   = array(
		'about'     => array( 'О клинике Альба — анонимная наркология', 'images/clinic-hall.jpg' ),
		'gallery'   => array( 'Галерея клиники Альба: палаты и кабинеты', 'images/clinic-hall.jpg' ),
		'articles'  => array( 'Статьи клиники Альба о детоксе и анонимности', 'images/clinic-consult.jpg' ),
		'programs'  => array( 'Программы лечения зависимости — Альба', 'images/clinic-room.jpg' ),
		'licenses'  => array( 'Лицензия на медицинскую деятельность — Альба', 'images/clinic-bright.jpg' ),
		'reviews'   => array( 'Отзывы пациентов клиники Альба', 'images/clinic-bright.jpg' ),
		'methods'   => array( 'Методы лечения зависимости в клинике Альба', 'images/clinic-consult.jpg' ),
		'links'     => array( 'Полезные ссылки и официальные реестры — Альба', 'images/clinic-hall.jpg' ),
		'sitemap'   => array( 'Карта сайта клиники Альба', 'images/clinic-hall.jpg' ),
	);
	if ( isset( $seo_map[ $slug ] ) ) {
		$seo_title = $seo_map[ $slug ][0];
		update_field( 'seo_image', $seo_map[ $slug ][1], $id );
	}
	update_field( 'seo_title', $seo_title, $id );
	update_field( 'seo_description', mb_substr( $seo_desc, 0, 180 ), $id );
	return true;
}
