<?php
/**
 * Quiz CPT + ACF + export for front-end test-quiz.js
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	static function () {
		register_post_type(
			'alba_quiz',
			array(
				'labels'              => array(
					'name'               => 'Тесты',
					'singular_name'      => 'Тест',
					'add_new'            => 'Добавить тест',
					'add_new_item'       => 'Добавить тест',
					'edit_item'          => 'Редактировать тест',
					'new_item'           => 'Новый тест',
					'view_item'          => 'Смотреть',
					'search_items'       => 'Искать тесты',
					'not_found'          => 'Тестов нет',
					'not_found_in_trash' => 'В корзине пусто',
					'menu_name'          => 'Тесты',
				),
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-clipboard',
				'menu_position'       => 26,
				'supports'            => array( 'title', 'page-attributes' ),
			)
		);
	}
);

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'    => 'group_alba_quiz',
				'title'  => 'Настройки теста',
				'fields' => array(
					array(
						'key'           => 'field_quiz_slug',
						'label'         => 'ID (латиница)',
						'name'          => 'quiz_slug',
						'type'          => 'text',
						'instructions'  => 'Уникальный код: alcohol, drugs, gambling, family…',
						'required'      => 1,
					),
					array(
						'key'           => 'field_quiz_icon',
						'label'         => 'Иконка',
						'name'          => 'quiz_icon',
						'type'          => 'select',
						'choices'       => array(
							'alcohol'  => 'Алкоголь',
							'drugs'    => 'Наркотики',
							'gambling' => 'Игры',
							'family'   => 'Семья',
							'default'  => 'Общая',
						),
						'default_value' => 'default',
					),
					array(
						'key'   => 'field_quiz_desc',
						'label' => 'Описание на карточке',
						'name'  => 'quiz_desc',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'           => 'field_quiz_meta',
						'label'         => 'Мета (под карточкой)',
						'name'          => 'quiz_meta',
						'type'          => 'text',
						'default_value' => '8 вопросов · ~2 мин',
					),
					array(
						'key'          => 'field_quiz_questions',
						'label'        => 'Вопросы',
						'name'         => 'quiz_questions',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Добавить вопрос',
						'sub_fields'   => array(
							array(
								'key'      => 'field_quiz_q_text',
								'label'    => 'Вопрос',
								'name'     => 'question',
								'type'     => 'textarea',
								'rows'     => 2,
								'required' => 1,
							),
							array(
								'key'           => 'field_quiz_q_preset',
								'label'         => 'Варианты ответов',
								'name'          => 'options_preset',
								'type'          => 'select',
								'choices'       => array(
									'yes_no' => 'Нет / Скорее нет / Скорее да / Да (0–3)',
									'freq'   => 'Частота: никогда…ежедневно (0–3)',
									'custom' => 'Свои варианты',
								),
								'default_value' => 'yes_no',
							),
							array(
								'key'               => 'field_quiz_q_opts',
								'label'             => 'Свои варианты',
								'name'              => 'custom_options',
								'type'              => 'repeater',
								'layout'            => 'table',
								'button_label'      => 'Вариант',
								'conditional_logic' => array(
									array(
										array(
											'field'    => 'field_quiz_q_preset',
											'operator' => '==',
											'value'    => 'custom',
										),
									),
								),
								'sub_fields'        => array(
									array( 'key' => 'field_quiz_opt_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
									array( 'key' => 'field_quiz_opt_s', 'label' => 'Балл', 'name' => 'score', 'type' => 'number', 'default_value' => 0, 'min' => 0, 'max' => 10 ),
								),
							),
						),
					),
					array(
						'key'          => 'field_quiz_brief_low',
						'label'        => 'Бриф — низкий риск (пункты)',
						'name'         => 'brief_low',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Пункт',
						'sub_fields'   => array(
							array( 'key' => 'field_quiz_bl_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
					array(
						'key'          => 'field_quiz_brief_mid',
						'label'        => 'Бриф — умеренный риск',
						'name'         => 'brief_mid',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Пункт',
						'sub_fields'   => array(
							array( 'key' => 'field_quiz_bm_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
					array(
						'key'          => 'field_quiz_brief_high',
						'label'        => 'Бриф — высокий риск',
						'name'         => 'brief_high',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Пункт',
						'sub_fields'   => array(
							array( 'key' => 'field_quiz_bh_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
				),
				'location' => array(
					array(
						array( 'param' => 'post_type', 'operator' => '==', 'value' => 'alba_quiz' ),
					),
				),
			)
		);

		// Extra result copy on test page.
		acf_add_local_field_group(
			array(
				'key'    => 'group_alba_page_test_results',
				'title'  => 'Результаты теста (общие тексты)',
				'fields' => array(
					array( 'key' => 'field_res_disclaimer', 'label' => 'Текст под заголовком результата', 'name' => 'test_result_disclaimer', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Это не диагноз. Бриф ниже поможет дежурному врачу быстрее сориентироваться в разговоре — анонимно и без ярлыков.' ),
					array( 'key' => 'field_res_low_badge', 'label' => 'Низкий риск — бейдж', 'name' => 'result_low_badge', 'type' => 'text', 'default_value' => 'Низкий риск' ),
					array( 'key' => 'field_res_low_title', 'label' => 'Низкий риск — заголовок', 'name' => 'result_low_title', 'type' => 'text', 'default_value' => 'Сигналов немного — но разговор с врачом всё равно полезен' ),
					array( 'key' => 'field_res_mid_badge', 'label' => 'Умеренный — бейдж', 'name' => 'result_mid_badge', 'type' => 'text', 'default_value' => 'Умеренный риск' ),
					array( 'key' => 'field_res_mid_title', 'label' => 'Умеренный — заголовок', 'name' => 'result_mid_title', 'type' => 'text', 'default_value' => 'Есть признаки, которые стоит обсудить со специалистом' ),
					array( 'key' => 'field_res_high_badge', 'label' => 'Высокий — бейдж', 'name' => 'result_high_badge', 'type' => 'text', 'default_value' => 'Высокий риск' ),
					array( 'key' => 'field_res_high_title', 'label' => 'Высокий — заголовок', 'name' => 'result_high_title', 'type' => 'text', 'default_value' => 'По ответам нужна помощь врача в ближайшее время' ),
					array( 'key' => 'field_res_brief_h', 'label' => 'Заголовок блока «Бриф»', 'name' => 'test_brief_heading', 'type' => 'text', 'default_value' => 'Бриф для врача' ),
					array( 'key' => 'field_res_note', 'label' => 'Юридическая сноска', 'name' => 'test_result_note', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Тест носит информационный характер и не заменяет очный осмотр. 18+. Имеются противопоказания.' ),
					array( 'key' => 'field_res_restart', 'label' => 'Кнопка «Пройти другой»', 'name' => 'test_restart_label', 'type' => 'text', 'default_value' => 'Пройти другой тест' ),
				),
				'location' => array(
					array(
						array( 'param' => 'page_template', 'operator' => '==', 'value' => 'page-test.php' ),
					),
				),
			)
		);
	},
	25
);

/**
 * Preset answer sets.
 *
 * @return array
 */
function alba_quiz_presets() {
	return array(
		'yes_no' => array(
			array( 't' => 'Нет', 's' => 0 ),
			array( 't' => 'Скорее нет', 's' => 1 ),
			array( 't' => 'Скорее да', 's' => 2 ),
			array( 't' => 'Да', 's' => 3 ),
		),
		'freq'   => array(
			array( 't' => 'Никогда / крайне редко', 's' => 0 ),
			array( 't' => 'Раз в месяц или реже', 's' => 1 ),
			array( 't' => 'Раз в неделю', 's' => 2 ),
			array( 't' => 'Несколько раз в неделю или ежедневно', 's' => 3 ),
		),
	);
}

/**
 * Brief lines from repeater.
 *
 * @param mixed $rows ACF repeater.
 * @return string[]
 */
function alba_quiz_brief_lines( $rows ) {
	$out = array();
	if ( ! is_array( $rows ) ) {
		return $out;
	}
	foreach ( $rows as $row ) {
		$t = isset( $row['text'] ) ? trim( (string) $row['text'] ) : '';
		if ( $t ) {
			$out[] = $t;
		}
	}
	return $out;
}

/**
 * Build front-end quiz payload from CPT.
 *
 * @return array{cats:array,levels:array,disclaimer:string}
 */
function alba_get_quizzes_for_js() {
	$presets = alba_quiz_presets();
	$cats    = array();

	$q = new WP_Query(
		array(
			'post_type'      => 'alba_quiz',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'no_found_rows'  => true,
		)
	);

	while ( $q->have_posts() ) {
		$q->the_post();
		$id   = get_the_ID();
		$slug = function_exists( 'get_field' ) ? (string) get_field( 'quiz_slug', $id ) : '';
		if ( ! $slug ) {
			$slug = sanitize_title( get_the_title() );
		}
		$icon = function_exists( 'get_field' ) ? (string) get_field( 'quiz_icon', $id ) : 'default';
		$desc = function_exists( 'get_field' ) ? (string) get_field( 'quiz_desc', $id ) : '';
		$meta = function_exists( 'get_field' ) ? (string) get_field( 'quiz_meta', $id ) : '';
		$rawq = function_exists( 'get_field' ) ? get_field( 'quiz_questions', $id ) : array();
		$questions = array();
		if ( is_array( $rawq ) ) {
			foreach ( $rawq as $row ) {
				$preset = isset( $row['options_preset'] ) ? $row['options_preset'] : 'yes_no';
				$opts   = array();
				if ( 'custom' === $preset && ! empty( $row['custom_options'] ) && is_array( $row['custom_options'] ) ) {
					foreach ( $row['custom_options'] as $o ) {
						$opts[] = array(
							't' => isset( $o['text'] ) ? (string) $o['text'] : '',
							's' => isset( $o['score'] ) ? (int) $o['score'] : 0,
						);
					}
				} else {
					$opts = isset( $presets[ $preset ] ) ? $presets[ $preset ] : $presets['yes_no'];
				}
				$questions[] = array(
					'q'    => isset( $row['question'] ) ? (string) $row['question'] : '',
					'opts' => $opts,
				);
			}
		}
		$cats[] = array(
			'id'        => $slug,
			'title'     => get_the_title(),
			'desc'      => $desc,
			'meta'      => $meta,
			'icon'      => $icon ? $icon : 'default',
			'questions' => $questions,
			'briefs'    => array(
				'low'  => alba_quiz_brief_lines( get_field( 'brief_low', $id ) ),
				'mid'  => alba_quiz_brief_lines( get_field( 'brief_mid', $id ) ),
				'high' => alba_quiz_brief_lines( get_field( 'brief_high', $id ) ),
			),
		);
	}
	wp_reset_postdata();

	$test_id = 0;
	$test    = get_page_by_path( 'test' );
	if ( $test ) {
		$test_id = (int) $test->ID;
	}

	$gf = static function ( $key, $default ) use ( $test_id ) {
		if ( ! $test_id || ! function_exists( 'get_field' ) ) {
			return $default;
		}
		$v = get_field( $key, $test_id );
		return ( null === $v || '' === $v ) ? $default : $v;
	};

	return array(
		'cats'        => $cats,
		'disclaimer'  => (string) $gf( 'test_result_disclaimer', 'Это не диагноз. Бриф ниже поможет дежурному врачу быстрее сориентироваться в разговоре — анонимно и без ярлыков.' ),
		'briefHeading'=> (string) $gf( 'test_brief_heading', 'Бриф для врача' ),
		'resultNote'  => (string) $gf( 'test_result_note', 'Тест носит информационный характер и не заменяет очный осмотр. 18+. Имеются противопоказания.' ),
		'restartLabel'=> (string) $gf( 'test_restart_label', 'Пройти другой тест' ),
		'levels'      => array(
			'low'  => array(
				'badge' => (string) $gf( 'result_low_badge', 'Низкий риск' ),
				'title' => (string) $gf( 'result_low_title', 'Сигналов немного — но разговор с врачом всё равно полезен' ),
				'cls'   => 'test-result__badge--low',
			),
			'mid'  => array(
				'badge' => (string) $gf( 'result_mid_badge', 'Умеренный риск' ),
				'title' => (string) $gf( 'result_mid_title', 'Есть признаки, которые стоит обсудить со специалистом' ),
				'cls'   => 'test-result__badge--mid',
			),
			'high' => array(
				'badge' => (string) $gf( 'result_high_badge', 'Высокий риск' ),
				'title' => (string) $gf( 'result_high_title', 'По ответам нужна помощь врача в ближайшее время' ),
				'cls'   => 'test-result__badge--high',
			),
		),
	);
}

/**
 * Seed default quizzes from built-in content.
 *
 * @param bool $force Recreate / overwrite fields.
 * @return array
 */
function alba_seed_quizzes( $force = false ) {
	if ( ! function_exists( 'update_field' ) ) {
		return array( 'error' => 'ACF missing' );
	}

	$existing = get_posts(
		array(
			'post_type'      => 'alba_quiz',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing && ! $force ) {
		return array( 'skipped' => count( $existing ), 'message' => 'Quizzes already exist' );
	}

	if ( $force && $existing ) {
		$all = get_posts(
			array(
				'post_type'      => 'alba_quiz',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);
		foreach ( $all as $pid ) {
			wp_delete_post( $pid, true );
		}
	}

	$yes = 'yes_no';
	$frq = 'freq';

	$defs = array(
		array(
			'title' => 'Алкоголь',
			'slug'  => 'alcohol',
			'icon'  => 'alcohol',
			'desc'  => 'Частота, контроль и последствия употребления — для брифа нарколога.',
			'meta'  => '8 вопросов · ~2 мин',
			'order' => 1,
			'qs'    => array(
				array( 'Как часто за последний месяц вы употребляли алкоголь?', $frq ),
				array( 'Бывало ли, что вы не могли остановиться, начав пить?', $yes ),
				array( 'Нужен ли алкоголь утром или «на похмелье», чтобы прийти в себя?', $yes ),
				array( 'Беспокоились ли близкие о вашем употреблении?', $yes ),
				array( 'Пропускали ли из‑за алкоголя работу, учёбу или важные дела?', $yes ),
				array( 'Были ли провалы в памяти после употребления?', $yes ),
				array( 'Пытались ли сократить или бросить — и возвращались снова?', $yes ),
				array( 'Есть ли сейчас тревога, тремор или бессонница без алкоголя?', $yes ),
			),
			'low'   => array( 'Эпизодическое употребление без явных признаков потери контроля.', 'Рекомендуется поддерживающая беседа и гигиена режима.' ),
			'mid'   => array( 'Есть сигналы снижения контроля и влияния на повседневность.', 'Показана консультация нарколога и план снижения / детокса при необходимости.' ),
			'high'  => array( 'Выраженные признаки зависимости: контроль, абстиненция, социальный ущерб.', 'Желателен скорый осмотр: оценка детокса, безопасности и формата помощи.' ),
		),
		array(
			'title' => 'Наркотики и ПАВ',
			'slug'  => 'drugs',
			'icon'  => 'drugs',
			'desc'  => 'Стимуляторы, опиоиды, каннабис и другие вещества — без ярлыков, только факты для врача.',
			'meta'  => '8 вопросов · ~2 мин',
			'order' => 2,
			'qs'    => array(
				array( 'Как часто за последние 3 месяца употребляли наркотические или психоактивные вещества?', $frq ),
				array( 'Увеличивалась ли доза, чтобы получить прежний эффект?', $yes ),
				array( 'Была ли сильная тяга или «ломка» при паузе?', $yes ),
				array( 'Употребляли ли в ситуациях, где это опасно (за рулём, на работе)?', $yes ),
				array( 'Скрывали ли употребление от близких?', $yes ),
				array( 'Тратили ли значительную часть средств на вещества?', $yes ),
				array( 'Были ли срывы после попыток бросить?', $yes ),
				array( 'Есть ли сейчас проблемы со сном, давлением, тревогой или психозом после употребления?', $yes ),
			),
			'low'   => array( 'Низкая частота / слабые маркеры зависимости по ответам.', 'Достаточно консультации и информирования о рисках.' ),
			'mid'   => array( 'Есть эскалация дозы, тяга или влияние на жизнь.', 'Нужна оценка врача: детокс, коррекция состояния, план сопровождения.' ),
			'high'  => array( 'Высокий риск сформированной зависимости и осложнений.', 'Рекомендуем срочный контакт с наркологом, при остром состоянии — стационар.' ),
		),
		array(
			'title' => 'Игровая зависимость',
			'slug'  => 'gambling',
			'icon'  => 'gambling',
			'desc'  => 'Ставки, казино, онлайн‑игры — влияние на финансы и отношения.',
			'meta'  => '7 вопросов · ~2 мин',
			'order' => 3,
			'qs'    => array(
				array( 'Как часто за месяц вы играли на деньги или делали ставки?', $frq ),
				array( 'Увеличивали ли ставки, чтобы вернуть проигранное?', $yes ),
				array( 'Скрывали ли масштаб игры или долгов от близких?', $yes ),
				array( 'Мешала ли игра работе, учёбе или семье?', $yes ),
				array( 'Брали ли в долг / продавали вещи ради игры?', $yes ),
				array( 'Чувствовали ли раздражение или тревогу, когда не можете играть?', $yes ),
				array( 'Пытались ли ограничить игру — и нарушали собственные запреты?', $yes ),
			),
			'low'   => array( 'Игра эпизодическая, без явного финансового/семейного кризиса по ответам.', 'Полезны границы бюджета и консультация при росте вовлечённости.' ),
			'mid'   => array( 'Есть «догон», сокрытие и влияние на обязательства.', 'Рекомендуем консультацию: психотерапия + при сопутствующих ПАВ — нарколог.' ),
			'high'  => array( 'Выраженная игровая зависимость с долгами и потерей контроля.', 'Нужен план помощи: ограничение доступа, терапия, поддержка семьи.' ),
		),
		array(
			'title' => 'Для родственников',
			'slug'  => 'family',
			'icon'  => 'family',
			'desc'  => 'Если беспокоит близкий: как оценить ситуацию до разговора с врачом.',
			'meta'  => '8 вопросов · ~2 мин',
			'order' => 4,
			'qs'    => array(
				array( 'Как часто близкий употребляет / играет вопреки вашим просьбам?', $frq ),
				array( 'Замечали ли рост дозы, смену веществ или удлинение запоев?', $yes ),
				array( 'Есть ли агрессия, изоляция или резкие перепады настроения?', $yes ),
				array( 'Терял ли близкий работу, учёбу или важные отношения из‑за этого?', $yes ),
				array( 'Были ли госпитализации, полиция, долги или угроза здоровью?', $yes ),
				array( 'Отрицает ли проблему и срывает договорённости о лечении?', $yes ),
				array( 'Чувствуете ли вы выгорание, страх или необходимость «контролировать» всё?', $yes ),
				array(
					'Готовы ли вы (или близкий) к консультации врача в ближайшие дни?',
					'custom',
					array(
						array( 'text' => 'Пока нет', 'score' => 0 ),
						array( 'text' => 'Сомневаемся', 'score' => 1 ),
						array( 'text' => 'Да, хотим созвон', 'score' => 2 ),
						array( 'text' => 'Да, нужна помощь срочно', 'score' => 3 ),
					),
				),
			),
			'low'   => array( 'Ситуация настораживает, но острых маркеров кризиса мало.', 'Полезна семейная консультация и чёткие границы без ультиматумов.' ),
			'mid'   => array( 'Есть эскалация и влияние на семью/работу.', 'Рекомендуем созвон с наркологом: план мотивации и варианты помощи.' ),
			'high'  => array( 'Высокий риск для здоровья и безопасности семьи.', 'Нужен срочный контакт с клиникой: выезд, стационар или кризисная поддержка.' ),
		),
	);

	$created = 0;
	foreach ( $defs as $def ) {
		$pid = wp_insert_post(
			array(
				'post_type'   => 'alba_quiz',
				'post_title'  => $def['title'],
				'post_status' => 'publish',
				'menu_order'  => $def['order'],
			),
			true
		);
		if ( is_wp_error( $pid ) || ! $pid ) {
			continue;
		}
		update_field( 'quiz_slug', $def['slug'], $pid );
		update_field( 'quiz_icon', $def['icon'], $pid );
		update_field( 'quiz_desc', $def['desc'], $pid );
		update_field( 'quiz_meta', $def['meta'], $pid );

		$questions = array();
		foreach ( $def['qs'] as $qrow ) {
			$item = array(
				'question'       => $qrow[0],
				'options_preset' => $qrow[1],
			);
			if ( 'custom' === $qrow[1] && isset( $qrow[2] ) ) {
				$item['custom_options'] = $qrow[2];
			}
			$questions[] = $item;
		}
		update_field( 'quiz_questions', $questions, $pid );
		update_field( 'brief_low', array_map( static function ( $t ) { return array( 'text' => $t ); }, $def['low'] ), $pid );
		update_field( 'brief_mid', array_map( static function ( $t ) { return array( 'text' => $t ); }, $def['mid'] ), $pid );
		update_field( 'brief_high', array_map( static function ( $t ) { return array( 'text' => $t ); }, $def['high'] ), $pid );
		$created++;
	}

	// Seed result texts on test page if empty.
	$test = get_page_by_path( 'test' );
	if ( $test ) {
		$tid = (int) $test->ID;
		if ( $force || ! get_field( 'test_result_disclaimer', $tid ) ) {
			update_field( 'test_result_disclaimer', 'Это не диагноз. Бриф ниже поможет дежурному врачу быстрее сориентироваться в разговоре — анонимно и без ярлыков.', $tid );
			update_field( 'result_low_badge', 'Низкий риск', $tid );
			update_field( 'result_low_title', 'Сигналов немного — но разговор с врачом всё равно полезен', $tid );
			update_field( 'result_mid_badge', 'Умеренный риск', $tid );
			update_field( 'result_mid_title', 'Есть признаки, которые стоит обсудить со специалистом', $tid );
			update_field( 'result_high_badge', 'Высокий риск', $tid );
			update_field( 'result_high_title', 'По ответам нужна помощь врача в ближайшее время', $tid );
			update_field( 'test_brief_heading', 'Бриф для врача', $tid );
			update_field( 'test_result_note', 'Тест носит информационный характер и не заменяет очный осмотр. 18+. Имеются противопоказания.', $tid );
			update_field( 'test_restart_label', 'Пройти другой тест', $tid );
		}
	}

	return array( 'created' => $created );
}
