<?php
/**
 * Structured ACF page blocks (no HTML / WYSIWYG in admin).
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared ACF field builders.
 */
function alba_acf_f_text( $key, $name, $label, $extra = array() ) {
	return array_merge(
		array(
			'key'   => $key,
			'label' => $label,
			'name'  => $name,
			'type'  => 'text',
		),
		$extra
	);
}

function alba_acf_f_area( $key, $name, $label, $rows = 3, $extra = array() ) {
	return array_merge(
		array(
			'key'   => $key,
			'label' => $label,
			'name'  => $name,
			'type'  => 'textarea',
			'rows'  => $rows,
		),
		$extra
	);
}

function alba_acf_f_lines( $key, $name, $label, $btn = 'Строка' ) {
	return array(
		'key'          => $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'table',
		'button_label' => $btn,
		'sub_fields'   => array(
			alba_acf_f_area( $key . '_t', 'text', 'Текст', 2 ),
		),
	);
}

function alba_acf_f_kv( $key, $name, $label, $btn = 'Пункт' ) {
	return array(
		'key'          => $key,
		'label'        => $label,
		'name'         => $name,
		'type'         => 'repeater',
		'layout'       => 'table',
		'button_label' => $btn,
		'sub_fields'   => array(
			alba_acf_f_text( $key . '_ti', 'title', 'Заголовок' ),
			alba_acf_f_area( $key . '_tx', 'text', 'Текст', 2 ),
		),
	);
}

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$layouts = array(
			'layout_text'       => array(
				'key'        => 'layout_text',
				'name'       => 'text',
				'label'      => 'Текст',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_txt_h', 'heading', 'Заголовок' ),
					alba_acf_f_lines( 'fld_txt_p', 'paragraphs', 'Абзацы', 'Абзац' ),
					alba_acf_f_lines( 'fld_txt_l', 'list', 'Маркированный список', 'Пункт' ),
					alba_acf_f_text( 'fld_txt_id', 'anchor', 'Якорь (id)', array( 'instructions' => 'Например anon' ) ),
				),
			),
			'layout_text_image' => array(
				'key'        => 'layout_text_image',
				'name'       => 'text_image',
				'label'      => 'Текст + фото',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_ti_h', 'heading', 'Заголовок' ),
					alba_acf_f_lines( 'fld_ti_p', 'paragraphs', 'Абзацы', 'Абзац' ),
					alba_acf_f_lines( 'fld_ti_l', 'list', 'Список', 'Пункт' ),
					alba_acf_f_text( 'fld_ti_img', 'image_url', 'URL изображения', array( 'instructions' => '/images/… или полный URL' ) ),
					alba_acf_f_text( 'fld_ti_alt', 'image_alt', 'Alt' ),
					array(
						'key'           => 'fld_ti_side',
						'label'         => 'Фото справа',
						'name'          => 'image_right',
						'type'          => 'true_false',
						'ui'            => 1,
						'default_value' => 1,
					),
				),
			),
			'layout_stats'      => array(
				'key'        => 'layout_stats',
				'name'       => 'stats',
				'label'      => 'Статистика',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_st_items',
						'label'        => 'Показатели',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Показатель',
						'sub_fields'   => array(
							array(
								'key'     => 'fld_st_type',
								'label'   => 'Тип значения',
								'name'    => 'value_type',
								'type'    => 'select',
								'choices' => array(
									'text'         => 'Текст / число',
									'count'        => 'Счётчик (анимация)',
									'city_name'    => 'Город (авто)',
									'city_address' => 'Адрес (авто)',
									'city_license' => 'Лицензия (авто)',
								),
							),
							alba_acf_f_text( 'fld_st_val', 'value', 'Значение' ),
							alba_acf_f_text( 'fld_st_lab', 'label', 'Подпись' ),
						),
					),
				),
			),
			'layout_cards'      => array(
				'key'        => 'layout_cards',
				'name'       => 'cards',
				'label'      => 'Карточки',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_cd_h', 'heading', 'Заголовок секции' ),
					alba_acf_f_area( 'fld_cd_lead', 'lead', 'Лид', 2 ),
					alba_acf_f_text( 'fld_cd_anchor', 'anchor', 'Якорь (id)' ),
					array(
						'key'     => 'fld_cd_style',
						'label'   => 'Стиль',
						'name'    => 'style',
						'type'    => 'select',
						'choices' => array(
							'anon'    => 'Анонимность (иконки)',
							'pillars' => 'Колонки / столпы',
							'info'    => 'Инфо-карточки',
						),
					),
					array(
						'key'          => 'fld_cd_items',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_cd_ti', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_cd_tx', 'text', 'Текст', 2 ),
							array(
								'key'     => 'fld_cd_ico',
								'label'   => 'Иконка',
								'name'    => 'icon',
								'type'    => 'select',
								'choices' => array(
									''     => '—',
									'lock' => 'Замок',
									'docs' => 'Документы',
									'pin'  => 'Метка',
								),
							),
						),
					),
				),
			),
			'layout_gallery'    => array(
				'key'        => 'layout_gallery',
				'name'       => 'gallery',
				'label'      => 'Галерея',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_gal_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_gal_l', 'lead', 'Лид', 2 ),
					alba_acf_f_text( 'fld_gal_b', 'button', 'Кнопка' ),
					alba_acf_f_text( 'fld_gal_bu', 'button_url', 'URL кнопки', array( 'default_value' => 'gallery' ) ),
					array(
						'key'           => 'fld_gal_style',
						'label'         => 'Стиль',
						'name'          => 'style',
						'type'          => 'select',
						'choices'       => array(
							'about'   => 'О нас (две колонки)',
							'default' => 'Обычная сетка',
						),
						'default_value' => 'about',
					),
					array(
						'key'          => 'fld_gal_items',
						'label'        => 'Фото',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Фото',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_gal_u', 'image_url', 'URL' ),
							alba_acf_f_text( 'fld_gal_a', 'alt', 'Alt' ),
							alba_acf_f_text( 'fld_gal_c', 'caption', 'Подпись' ),
						),
					),
				),
			),
			'layout_steps'      => array(
				'key'        => 'layout_steps',
				'name'       => 'steps',
				'label'      => 'Шаги',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_sp_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_sp_l', 'lead', 'Лид', 2 ),
					alba_acf_f_kv( 'fld_sp_i', 'items', 'Шаги', 'Шаг' ),
				),
			),
			'layout_timeline'   => array(
				'key'        => 'layout_timeline',
				'name'       => 'timeline',
				'label'      => 'Таймлайн',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_tl_h', 'heading', 'Заголовок' ),
					array(
						'key'          => 'fld_tl_i',
						'label'        => 'События',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Событие',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_tl_y', 'year', 'Год / метка' ),
							alba_acf_f_area( 'fld_tl_t', 'text', 'Текст', 2 ),
						),
					),
				),
			),
			'layout_faq'        => array(
				'key'        => 'layout_faq',
				'name'       => 'faq',
				'label'      => 'FAQ',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_fq_h', 'heading', 'Заголовок' ),
					array(
						'key'          => 'fld_fq_i',
						'label'        => 'Вопросы',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Вопрос',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_fq_q', 'q', 'Вопрос' ),
							alba_acf_f_area( 'fld_fq_a', 'a', 'Ответ', 3 ),
						),
					),
				),
			),
			'layout_cta'        => array(
				'key'        => 'layout_cta',
				'name'       => 'cta',
				'label'      => 'CTA (низ)',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_ct_h', 'title', 'Заголовок' ),
					alba_acf_f_area( 'fld_ct_t', 'text', 'Текст', 2 ),
				),
			),
			'layout_hub'        => array(
				'key'        => 'layout_hub',
				'name'       => 'hub_lead',
				'label'      => 'Лидогенерация (полоса)',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_hb_h', 'title', 'Заголовок' ),
					alba_acf_f_area( 'fld_hb_t', 'text', 'Текст', 2 ),
					alba_acf_f_text( 'fld_hb_b', 'button', 'Текст кнопки', array( 'default_value' => 'Оставить заявку' ) ),
				),
			),
			'layout_prog_cards' => array(
				'key'        => 'layout_prog_cards',
				'name'       => 'program_cards',
				'label'      => 'Карточки программ (alko)',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_pc_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_pc_l', 'lead', 'Лид', 2 ),
					array(
						'key'          => 'fld_pc_items',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_pc_badge', 'badge', 'Бейдж' ),
							alba_acf_f_text( 'fld_pc_title', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_pc_text', 'text', 'Текст', 2 ),
							alba_acf_f_text( 'fld_pc_price', 'price', 'Цена' ),
							alba_acf_f_text( 'fld_pc_more', 'more', 'Подпись ссылки', array( 'default_value' => 'Подробнее' ) ),
							alba_acf_f_text( 'fld_pc_url', 'url', 'Ссылка (slug)' ),
							array( 'key' => 'fld_pc_feat', 'label' => 'Выделить', 'name' => 'featured', 'type' => 'true_false', 'ui' => 1 ),
						),
					),
				),
			),
			'layout_catalog'    => array(
				'key'        => 'layout_catalog',
				'name'       => 'catalog',
				'label'      => 'Каталог (cat-card)',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_cat_items',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_cat_badge', 'badge', 'Бейдж' ),
							alba_acf_f_text( 'fld_cat_title', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_cat_text', 'text', 'Текст', 2 ),
							alba_acf_f_text( 'fld_cat_price', 'price', 'Цена' ),
							alba_acf_f_text( 'fld_cat_url', 'url', 'Ссылка (slug)' ),
							alba_acf_f_text( 'fld_cat_icon', 'icon', 'Иконка URL' ),
							array( 'key' => 'fld_cat_accent', 'label' => 'Акцент', 'name' => 'accent', 'type' => 'true_false', 'ui' => 1 ),
						),
					),
				),
			),
			'layout_ward'       => array(
				'key'        => 'layout_ward',
				'name'       => 'ward_fund',
				'label'      => 'Палатный фонд',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_wf_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_wf_l', 'lead', 'Лид', 2 ),
					array(
						'key'          => 'fld_wf_items',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_wf_badge', 'badge', 'Бейдж' ),
							alba_acf_f_text( 'fld_wf_title', 'title', 'Заголовок' ),
							alba_acf_f_lines( 'fld_wf_list', 'list', 'Пункты', 'Пункт' ),
							array( 'key' => 'fld_wf_feat', 'label' => 'Выделить', 'name' => 'featured', 'type' => 'true_false', 'ui' => 1 ),
						),
					),
					alba_acf_f_text( 'fld_wf_btn', 'button', 'Текст кнопки', array( 'default_value' => 'Забронировать палату' ) ),
				),
			),
			'layout_doctors'    => array(
				'key'        => 'layout_doctors',
				'name'       => 'doctors_grid',
				'label'      => 'Сетка врачей',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_dg_h', 'heading', 'Заголовок', array( 'default_value' => 'Наши специалисты' ) ),
					alba_acf_f_area( 'fld_dg_l', 'lead', 'Лид', 2 ),
					array(
						'key'           => 'fld_dg_from_cpt',
						'label'         => 'Брать врачей из CPT «Врачи»',
						'name'          => 'from_cpt',
						'type'          => 'true_false',
						'ui'            => 1,
						'default_value' => 1,
						'instructions'  => 'Если включено — список строится из записей Врачи. Иначе — из карточек ниже.',
					),
					array(
						'key'          => 'fld_dg_items',
						'label'        => 'Карточки (если не CPT)',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Врач',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_dg_name', 'name', 'ФИО' ),
							alba_acf_f_text( 'fld_dg_spec', 'spec', 'Специальность' ),
							alba_acf_f_text( 'fld_dg_exp', 'experience', 'Стаж' ),
							alba_acf_f_area( 'fld_dg_desc', 'short_desc', 'Описание', 2 ),
							alba_acf_f_text( 'fld_dg_photo', 'photo_url', 'Фото URL' ),
							array(
								'key'     => 'fld_dg_filter',
								'label'   => 'Контур',
								'name'    => 'docs_filter',
								'type'    => 'select',
								'choices' => array(
									'field'      => 'Выезд',
									'ambulatory' => 'Амбулаторно',
									'stationary' => 'Стационар',
								),
							),
							alba_acf_f_text( 'fld_dg_url', 'url', 'Ссылка (slug врача)' ),
						),
					),
				),
			),
			'layout_funnel'     => array(
				'key'        => 'layout_funnel',
				'name'       => 'funnel',
				'label'      => 'Форма «перезвоните»',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'           => 'fld_fn_v',
						'label'         => 'Вариант',
						'name'          => 'variant',
						'type'          => 'select',
						'choices'       => array(
							'form' => 'С формой телефона',
							'call' => 'Кнопки заявка / звонок',
						),
						'default_value' => 'form',
					),
					alba_acf_f_text( 'fld_fn_h', 'title', 'Заголовок' ),
					alba_acf_f_area( 'fld_fn_t', 'text', 'Текст', 2 ),
					array(
						'key'          => 'fld_fn_c',
						'label'        => 'Чипы',
						'name'         => 'chips',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Чип',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_fn_ct', 'text', 'Текст' ),
						),
					),
				),
			),
			'layout_contacts'   => array(
				'key'        => 'layout_contacts',
				'name'       => 'contacts',
				'label'      => 'Контакты + карта + форма',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_cn_cards',
						'label'        => 'Карточки',
						'name'         => 'cards',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_cn_l', 'label', 'Метка' ),
							array(
								'key'     => 'fld_cn_vt',
								'label'   => 'Тип значения',
								'name'    => 'value_type',
								'type'    => 'select',
								'choices' => array(
									'text'       => 'Текст',
									'phone'      => 'Телефон города',
									'messengers' => 'Max + Telegram',
									'address'    => 'Адрес города',
									'license'    => 'Лицензия города',
								),
							),
							alba_acf_f_text( 'fld_cn_v', 'value', 'Значение (если «Текст»)' ),
							alba_acf_f_area( 'fld_cn_tx', 'text', 'Описание', 2 ),
						),
					),
					array( 'key' => 'fld_cn_map', 'label' => 'Показать карту', 'name' => 'show_map', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1 ),
					array( 'key' => 'fld_cn_form', 'label' => 'Показать форму', 'name' => 'show_form', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1 ),
					alba_acf_f_text( 'fld_cn_fh', 'form_title', 'Заголовок формы', array( 'default_value' => 'Оставить номер' ) ),
					alba_acf_f_area( 'fld_cn_ft', 'form_text', 'Текст формы', 2 ),
				),
			),
			'layout_prices'     => array(
				'key'        => 'layout_prices',
				'name'       => 'prices',
				'label'      => 'Прайс-блоки',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_pr_g',
						'label'        => 'Группы',
						'name'         => 'groups',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Группа',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_pr_gt', 'title', 'Заголовок группы' ),
							array(
								'key'          => 'fld_pr_rows',
								'label'        => 'Строки',
								'name'         => 'rows',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Строка',
								'sub_fields'   => array(
									alba_acf_f_text( 'fld_pr_n', 'name', 'Услуга' ),
									alba_acf_f_text( 'fld_pr_p', 'price', 'Цена' ),
									alba_acf_f_text( 'fld_pr_link', 'link', 'Ссылка (необяз.)' ),
								),
							),
						),
					),
					alba_acf_f_area( 'fld_pr_note', 'note', 'Сноска под прайсом', 3 ),
				),
			),
			'layout_team'       => array(
				'key'        => 'layout_team',
				'name'       => 'team',
				'label'      => 'Тизер команды',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_tm_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_tm_l', 'lead', 'Текст', 2 ),
					alba_acf_f_text( 'fld_tm_b', 'button', 'Кнопка', array( 'default_value' => 'Смотреть врачей' ) ),
					alba_acf_f_text( 'fld_tm_u', 'button_url', 'URL кнопки', array( 'default_value' => 'doctors' ) ),
				),
			),
			'layout_links'      => array(
				'key'        => 'layout_links',
				'name'       => 'links',
				'label'      => 'Карточки ссылок',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_lk_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_lk_lead', 'lead', 'Лид', 2 ),
					array(
						'key'          => 'fld_lk_i',
						'label'        => 'Ссылки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Ссылка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_lk_e', 'eyebrow', 'Надпись' ),
							alba_acf_f_text( 'fld_lk_l', 'label', 'Название' ),
							alba_acf_f_text( 'fld_lk_u', 'url', 'URL' ),
							alba_acf_f_area( 'fld_lk_d', 'text', 'Описание', 2 ),
						),
					),
				),
			),
			'layout_info_story' => array(
				'key'        => 'layout_info_story',
				'name'       => 'info_story',
				'label'      => 'История + фото',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_is_img', 'image_url', 'URL изображения' ),
					alba_acf_f_text( 'fld_is_alt', 'image_alt', 'Alt' ),
					alba_acf_f_lines( 'fld_is_p', 'paragraphs', 'Абзацы', 'Абзац' ),
					alba_acf_f_text( 'fld_is_lh', 'list_heading', 'Заголовок списка' ),
					alba_acf_f_lines( 'fld_is_l', 'list', 'Список', 'Пункт' ),
					alba_acf_f_text( 'fld_is_b', 'button', 'Кнопка', array( 'default_value' => 'Записаться' ) ),
				),
			),
			'layout_license_cards' => array(
				'key'        => 'layout_license_cards',
				'name'       => 'license_cards',
				'label'      => 'Карточки лицензий',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_lc_i',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_lc_e', 'eyebrow', 'Надпись' ),
							alba_acf_f_text( 'fld_lc_t', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_lc_x', 'text', 'Текст', 3 ),
							alba_acf_f_lines( 'fld_lc_l', 'list', 'Список', 'Пункт' ),
							array(
								'key'   => 'fld_lc_w',
								'label' => 'Широкая',
								'name'  => 'wide',
								'type'  => 'true_false',
								'ui'    => 1,
							),
							array(
								'key'   => 'fld_lc_city',
								'label' => 'Номер лицензии города',
								'name'  => 'use_city_license',
								'type'  => 'true_false',
								'ui'    => 1,
							),
						),
					),
				),
			),
			'layout_review_list' => array(
				'key'        => 'layout_review_list',
				'name'       => 'review_list',
				'label'      => 'Список отзывов',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_rl_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_rl_l', 'lead', 'Лид', 2 ),
					array(
						'key'          => 'fld_rl_i',
						'label'        => 'Отзывы',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Отзыв',
						'sub_fields'   => array(
							alba_acf_f_area( 'fld_rl_t', 'text', 'Текст', 3 ),
							alba_acf_f_text( 'fld_rl_n', 'name', 'Имя' ),
							alba_acf_f_text( 'fld_rl_r', 'role', 'Роль / тема' ),
							array(
								'key'   => 'fld_rl_f',
								'label' => 'Крупный',
								'name'  => 'featured',
								'type'  => 'true_false',
								'ui'    => 1,
							),
						),
					),
				),
			),
			'layout_atlas' => array(
				'key'        => 'layout_atlas',
				'name'       => 'atlas',
				'label'      => 'Атлас методов',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_at_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_at_l', 'lead', 'Лид', 2 ),
					array(
						'key'          => 'fld_at_i',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Метод',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_at_e', 'eyebrow', 'Надпись' ),
							alba_acf_f_text( 'fld_at_t', 'title', 'Название' ),
							alba_acf_f_text( 'fld_at_x', 'text', 'Текст' ),
							alba_acf_f_text( 'fld_at_u', 'url', 'URL' ),
						),
					),
				),
			),
			'layout_related' => array(
				'key'        => 'layout_related',
				'name'       => 'related',
				'label'      => 'Смежные страницы',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_rel_h', 'heading', 'Заголовок', array( 'default_value' => 'Рядом по маршруту' ) ),
					array(
						'key'          => 'fld_rel_i',
						'label'        => 'Карточки',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_rel_t', 'title', 'Заголовок' ),
							alba_acf_f_text( 'fld_rel_x', 'text', 'Текст' ),
							alba_acf_f_text( 'fld_rel_u', 'url', 'URL' ),
							alba_acf_f_text( 'fld_rel_m', 'more', 'Кнопка', array( 'default_value' => 'Открыть' ) ),
						),
					),
				),
			),
			'layout_sitemap' => array(
				'key'        => 'layout_sitemap',
				'name'       => 'sitemap',
				'label'      => 'Карта сайта',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_sm_j',
						'label'        => 'Быстрый переход',
						'name'         => 'jumps',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Якорь',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_sm_jl', 'label', 'Подпись' ),
							alba_acf_f_text( 'fld_sm_ja', 'anchor', 'Якорь (без #)' ),
						),
					),
					array(
						'key'          => 'fld_sm_s',
						'label'        => 'Секции',
						'name'         => 'sections',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Секция',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_sm_sa', 'anchor', 'Якорь' ),
							alba_acf_f_text( 'fld_sm_sn', 'number', 'Номер' ),
							alba_acf_f_text( 'fld_sm_st', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_sm_sl', 'lead', 'Лид', 2 ),
							array(
								'key'          => 'fld_sm_links',
								'label'        => 'Ссылки (без групп)',
								'name'         => 'links',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Ссылка',
								'sub_fields'   => array(
									alba_acf_f_text( 'fld_sm_ll', 'label', 'Название' ),
									alba_acf_f_text( 'fld_sm_lu', 'url', 'URL' ),
								),
							),
							array(
								'key'          => 'fld_sm_g',
								'label'        => 'Группы',
								'name'         => 'groups',
								'type'         => 'repeater',
								'layout'       => 'block',
								'button_label' => 'Группа',
								'sub_fields'   => array(
									alba_acf_f_text( 'fld_sm_gt', 'title', 'Заголовок группы' ),
									array(
										'key'          => 'fld_sm_gl',
										'label'        => 'Ссылки',
										'name'         => 'links',
										'type'         => 'repeater',
										'layout'       => 'table',
										'button_label' => 'Ссылка',
										'sub_fields'   => array(
											alba_acf_f_text( 'fld_sm_gll', 'label', 'Название' ),
											alba_acf_f_text( 'fld_sm_glu', 'url', 'URL' ),
										),
									),
								),
							),
						),
					),
					alba_acf_f_area( 'fld_sm_note', 'note', 'Сноска', 2 ),
				),
			),
			'layout_essay' => array(
				'key'        => 'layout_essay',
				'name'       => 'essay',
				'label'      => 'SEO-текст',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_es_h', 'heading', 'Заголовок' ),
					alba_acf_f_lines( 'fld_es_p', 'paragraphs', 'Абзацы сверху', 'Абзац' ),
					array(
						'key'          => 'fld_es_s',
						'label'        => 'Подразделы',
						'name'         => 'sections',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Подраздел',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_es_st', 'title', 'H3' ),
							alba_acf_f_lines( 'fld_es_sp', 'paragraphs', 'Абзацы', 'Абзац' ),
							alba_acf_f_lines( 'fld_es_sl', 'list', 'Список', 'Пункт' ),
							array(
								'key'   => 'fld_es_so',
								'label' => 'Нумерованный список',
								'name'  => 'ordered',
								'type'  => 'true_false',
								'ui'    => 1,
							),
						),
					),
					alba_acf_f_area( 'fld_es_n', 'note', 'Заметка', 2 ),
				),
			),
			'layout_articles_grid' => array(
				'key'        => 'layout_articles_grid',
				'name'       => 'articles_grid',
				'label'      => 'Сетка статей',
				'display'    => 'block',
				'sub_fields' => array(
					alba_acf_f_text( 'fld_ag_h', 'heading', 'Заголовок' ),
					alba_acf_f_area( 'fld_ag_l', 'lead', 'Лид', 2 ),
					array(
						'key'           => 'fld_ag_from',
						'label'         => 'Брать из записей (посты)',
						'name'          => 'from_posts',
						'type'          => 'true_false',
						'ui'            => 1,
						'default_value' => 1,
					),
					array(
						'key'          => 'fld_ag_i',
						'label'        => 'Карточки (если не из постов)',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Статья',
						'sub_fields'   => array(
							alba_acf_f_text( 'fld_ag_t', 'title', 'Заголовок' ),
							alba_acf_f_area( 'fld_ag_x', 'text', 'Текст', 2 ),
							alba_acf_f_text( 'fld_ag_u', 'url', 'URL' ),
							alba_acf_f_text( 'fld_ag_img', 'image', 'Картинка' ),
							alba_acf_f_text( 'fld_ag_d', 'date', 'Дата' ),
						),
					),
				),
			),
			'layout_home_mod'   => array(
				'key'        => 'layout_home_mod',
				'name'       => 'home_module',
				'label'      => 'Модуль главной',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'     => 'fld_hm_key',
						'label'   => 'Модуль',
						'name'    => 'module',
						'type'    => 'select',
						'choices' => array(
							'hero'         => 'Hero',
							'dirs'         => 'Направления',
							'calc'         => 'Калькулятор',
							'test_strip'   => 'Полоса теста',
							'promos'       => 'Промо',
							'offers'       => 'Офферы',
							'trust'        => 'Доверие',
							'formats'      => 'Форматы',
							'steps'        => 'Шаги',
							'station'      => 'Стационар',
							'ward'         => 'Палатный фонд',
							'rooms'        => 'Слайдер палат',
							'licenses'     => 'Лицензии',
							'people'       => 'Врачи',
							'funnel'       => 'Воронка',
							'guarantee'    => 'Гарантии',
							'reviews'      => 'Отзывы',
							'price'        => 'Цены',
							'essay'        => 'SEO-текст',
							'seo_funnel'   => 'SEO-воронка',
							'faq'          => 'FAQ',
							'cta'          => 'CTA',
						),
					),
					alba_acf_f_text( 'fld_hm_h', 'heading', 'Заголовок (оверрайд)' ),
					alba_acf_f_area( 'fld_hm_l', 'lead', 'Лид (оверрайд)', 2 ),
					alba_acf_f_lines( 'fld_hm_p', 'paragraphs', 'Абзацы', 'Абзац' ),
					alba_acf_f_kv( 'fld_hm_i', 'items', 'Пункты / карточки', 'Пункт' ),
				),
			),
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_alba_page',
				'title'                 => 'Контент страницы (ACF)',
				'fields'                => array(
					alba_acf_f_text( 'field_page_hero_title', 'hero_title', 'H1', array( 'instructions' => 'Перенос строки: напишите | между частями' ) ),
					alba_acf_f_area( 'field_page_hero_lead', 'hero_lead', 'Лид под H1', 3 ),
					array(
						'key'          => 'field_page_chips',
						'label'        => 'Чипы под hero',
						'name'         => 'page_chips',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Чип',
						'sub_fields'   => array(
							alba_acf_f_text( 'field_page_chip_t', 'title', 'Заголовок' ),
							alba_acf_f_text( 'field_page_chip_d', 'text', 'Текст' ),
						),
					),
					array(
						'key'          => 'field_page_blocks',
						'label'        => 'Блоки страницы',
						'name'         => 'page_blocks',
						'type'         => 'flexible_content',
						'button_label' => 'Добавить блок',
						'layouts'      => $layouts,
					),
				),
				'location'              => array(
					array(
						array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);

		// Keep test-specific groups (already plain text fields).
	},
	20
);

/**
 * Turn "a|b" into title with &lt;br&gt;.
 *
 * @param string $title Raw title.
 * @return string
 */
function alba_title_br( $title ) {
	$parts = array_map( 'trim', explode( '|', (string) $title ) );
	$parts = array_filter( $parts, static function ( $p ) {
		return '' !== $p;
	} );
	return implode( '<br>', array_map( 'esc_html', $parts ) );
}

/**
 * Resolve internal slug / .html / absolute URL for block links.
 *
 * @param string $url Raw URL.
 * @return string
 */
function alba_block_href( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url || '#' === $url ) {
		return '#';
	}
	if ( preg_match( '#^(https?:)?//#i', $url ) || 0 === strpos( $url, 'tel:' ) || 0 === strpos( $url, 'mailto:' ) ) {
		return $url;
	}
	if ( 0 === strpos( $url, '#' ) ) {
		return $url;
	}

	$hash = '';
	if ( preg_match( '/^(.*?)(#[a-z0-9\-_]+)$/i', $url, $hm ) ) {
		$url  = $hm[1];
		$hash = $hm[2];
	}
	$url = preg_replace( '/\.(html?)$/i', '', $url );

	if ( 'index' === $url || '' === $url ) {
		return alba_city_url() . $hash;
	}

	// Already city-relative service path.
	if ( preg_match( '#^(service|program|doctor)/#', $url ) ) {
		return alba_city_url( $url ) . $hash;
	}

	// Legacy stems: service-detox, doctor-volkov, article-anon.
	if ( preg_match( '/^(service|program)-(.+)$/i', $url, $m ) ) {
		if ( function_exists( 'alba_service_permalink' ) ) {
			return alba_service_permalink( $url ) . $hash;
		}
		return alba_city_url( $m[1] . '/' . $m[2] ) . $hash;
	}
	if ( preg_match( '/^doctor-(.+)$/i', $url, $m ) ) {
		return alba_city_url( 'doctor/' . $m[1] ) . $hash;
	}
	if ( preg_match( '/^article-(.+)$/i', $url, $m ) || preg_match( '/^(article-.+)$/i', $url, $m ) ) {
		$full = 0 === strpos( $url, 'article-' ) ? $url : ( 'article-' . $m[1] );
		$post = get_page_by_path( $full, OBJECT, 'post' );
		if ( ! $post ) {
			$post = get_page_by_path( 'article-' . $m[1], OBJECT, 'post' );
		}
		if ( $post ) {
			return get_permalink( $post ) . $hash;
		}
		return alba_city_url( 'article/' . $full ) . $hash;
	}

	return alba_city_url( ltrim( $url, '/' ) ) . $hash;
}

/**
 * Inline SVG for anonymity cards (icon key → markup).
 *
 * @param string $key Icon key.
 * @return string
 */
function alba_anon_icon_svg( $key ) {
	$key = sanitize_key( (string) $key );
	$map = array(
		'lock' => '<svg viewBox="0 0 24 24" fill="none"><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 11V8a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
		'docs' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
		'pin'  => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="10" r="2.2" stroke="currentColor" stroke-width="1.8"/></svg>',
	);
	return isset( $map[ $key ] ) ? $map[ $key ] : '';
}

/**
 * Absolute image URL helper.
 *
 * @param string $url Relative or absolute.
 * @return string
 */
function alba_media_url( $url ) {
	$url = trim( (string) $url );
	if ( ! $url ) {
		return '';
	}
	if ( preg_match( '#^https?://#i', $url ) || 0 === strpos( $url, '//' ) ) {
		return $url;
	}
	if ( 0 === strpos( $url, '/' ) ) {
		return home_url( $url );
	}
	if ( 0 === strpos( $url, 'images/' ) ) {
		return home_url( '/' . $url );
	}
	return home_url( '/' . ltrim( $url, '/' ) );
}

/**
 * Lines from repeater of {text}.
 *
 * @param mixed $rows Rows.
 * @return string[]
 */
function alba_lines( $rows ) {
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
 * Whether page has structured ACF content.
 *
 * @param int $post_id ID.
 * @return bool
 */
function alba_page_uses_acf( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return false;
	}
	if ( get_field( 'hero_title', $post_id ) ) {
		return true;
	}
	$blocks = get_field( 'page_blocks', $post_id );
	return is_array( $blocks ) && count( $blocks ) > 0;
}

/**
 * Render full ACF page.
 *
 * @param int $post_id ID.
 */
function alba_render_acf_page( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$city    = alba_get_current_city();
	$title   = (string) ( get_field( 'hero_title', $post_id ) ?: get_the_title( $post_id ) );
	$lead    = (string) get_field( 'hero_lead', $post_id );
	$chips   = get_field( 'page_chips', $post_id );
	$blocks  = get_field( 'page_blocks', $post_id );

	$is_front = (int) get_option( 'page_on_front' ) === $post_id;

	if ( ! $is_front ) {
		echo '<section class="page-intro wrap">';
		echo '<div class="page-intro__inner"><div>';
		echo '<div class="crumb"><a href="' . esc_url( alba_city_url() ) . '">Главная</a> / ' . esc_html( get_the_title( $post_id ) ) . '</div>';
		echo '<h1 class="split">' . alba_title_br( $title ) . '</h1>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
		if ( $lead ) {
			echo '<p>' . esc_html( $lead ) . '</p>';
		}
		echo '</div>';
		if ( is_array( $chips ) && $chips ) {
			echo '<ul class="about-chips" data-reveal>';
			foreach ( $chips as $chip ) {
				echo '<li><b>' . esc_html( $chip['title'] ?? '' ) . '</b><span>' . esc_html( $chip['text'] ?? '' ) . '</span></li>';
			}
			echo '</ul>';
		}
		echo '</section>';
	}

	if ( is_array( $blocks ) ) {
		foreach ( $blocks as $block ) {
			alba_render_page_block( $block, $city, $is_front );
		}
	}
}

/**
 * Render one flexible layout.
 *
 * @param array $block Block.
 * @param array $city City.
 * @param bool  $is_front Front page.
 */
function alba_render_page_block( $block, $city, $is_front = false ) {
	$layout = isset( $block['acf_fc_layout'] ) ? $block['acf_fc_layout'] : '';
	$path   = ALBA_DIR . '/template-parts/blocks/' . $layout . '.php';
	if ( file_exists( $path ) ) {
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( array( 'b' => $block, 'city' => $city, 'is_front' => $is_front ), EXTR_SKIP );
		include $path;
		return;
	}
	// Inline fallbacks for core layouts if partial missing.
	switch ( $layout ) {
		case 'cta':
			include ALBA_DIR . '/template-parts/blocks/cta.php';
			break;
		case 'home_module':
			alba_render_home_module( $block, $city );
			break;
		default:
			break;
	}
}

/**
 * Home interactive / composite modules.
 *
 * @param array $block Block.
 * @param array $city City.
 */
function alba_render_home_module( $block, $city ) {
	$mod = isset( $block['module'] ) ? $block['module'] : '';
	$file = ALBA_DIR . '/template-parts/home/' . preg_replace( '/[^a-z0-9_]/', '', $mod ) . '.php';
	if ( file_exists( $file ) ) {
		$b = $block;
		include $file;
		return;
	}
	// Soft fallback: heading + paragraphs + items as generic section.
	$h = isset( $block['heading'] ) ? $block['heading'] : '';
	$l = isset( $block['lead'] ) ? $block['lead'] : '';
	$ps = alba_lines( isset( $block['paragraphs'] ) ? $block['paragraphs'] : array() );
	$items = isset( $block['items'] ) && is_array( $block['items'] ) ? $block['items'] : array();
	if ( ! $h && ! $ps && ! $items ) {
		return;
	}
	echo '<section class="wrap" data-home-mod="' . esc_attr( $mod ) . '">';
	if ( $h ) {
		echo '<h2 class="section-title">' . alba_title_br( $h ) . '</h2>'; // phpcs:ignore
	}
	if ( $l ) {
		echo '<p>' . esc_html( $l ) . '</p>';
	}
	foreach ( $ps as $p ) {
		echo '<p>' . esc_html( $p ) . '</p>';
	}
	if ( $items ) {
		echo '<ul class="about-bullets">';
		foreach ( $items as $it ) {
			$t = trim( ( $it['title'] ?? '' ) . ( ! empty( $it['title'] ) && ! empty( $it['text'] ) ? ' — ' : '' ) . ( $it['text'] ?? '' ) );
			if ( $t ) {
				echo '<li>' . esc_html( $t ) . '</li>';
			}
		}
		echo '</ul>';
	}
	echo '</section>';
}
