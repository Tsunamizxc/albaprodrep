<?php
/**
 * ACF field groups (registered in PHP so they work without JSON sync).
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => 'Настройки Альба (ACF)',
					'menu_title' => 'ACF Альба',
					'menu_slug'  => 'alba-acf-options',
					'capability' => 'manage_options',
					'redirect'   => false,
				)
			);
		}

		// Service/program fields: see inc/service-acf.php

		acf_add_local_field_group(
			array(
				'key'    => 'group_alba_doctor',
				'title'  => 'Врач',
				'fields' => array(
					array( 'key' => 'field_doc_spec', 'label' => 'Специальность', 'name' => 'spec', 'type' => 'text' ),
					array( 'key' => 'field_doc_exp', 'label' => 'Стаж', 'name' => 'experience', 'type' => 'text' ),
					array(
						'key'     => 'field_doc_type',
						'label'   => 'Контур',
						'name'    => 'docs_filter',
						'type'    => 'select',
						'choices' => array(
							'field'      => 'Выезд',
							'ambulatory' => 'Амбулаторно',
							'stationary' => 'Стационар',
						),
					),
					array(
						'key'          => 'field_doc_photo',
						'label'        => 'Фото (URL)',
						'name'         => 'photo_url',
						'type'         => 'text',
						'instructions' => '/images/… или полный URL',
					),
					array(
						'key'   => 'field_doc_desc',
						'label' => 'Краткое описание (карточка)',
						'name'  => 'short_desc',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_doc_hero',
						'label' => 'Подзаголовок в шапке',
						'name'  => 'hero_subtitle',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_doc_lead',
						'label' => 'Лид на странице врача',
						'name'  => 'doctor_lead',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'          => 'field_doc_bio',
						'label'        => 'Биография (абзацы)',
						'name'         => 'bio_paragraphs',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Абзац',
						'sub_fields'   => array(
							array(
								'key'  => 'fld_doc_bio_t',
								'label'=> 'Текст',
								'name' => 'text',
								'type' => 'textarea',
								'rows' => 3,
							),
						),
					),
					array(
						'key'          => 'field_doc_tags',
						'label'        => 'Специализация (теги)',
						'name'         => 'specializations',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Тег',
						'sub_fields'   => array(
							array(
								'key'  => 'fld_doc_tag_t',
								'label'=> 'Текст',
								'name' => 'text',
								'type' => 'text',
							),
						),
					),
					array(
						'key'   => 'field_doc_edu_h',
						'label' => 'Заголовок «Образование»',
						'name'  => 'education_heading',
						'type'  => 'text',
						'default_value' => 'Образование и опыт',
					),
					array(
						'key'          => 'field_doc_edu',
						'label'        => 'Образование и опыт (абзацы)',
						'name'         => 'education_paragraphs',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Абзац',
						'sub_fields'   => array(
							array(
								'key'  => 'fld_doc_edu_t',
								'label'=> 'Текст',
								'name' => 'text',
								'type' => 'textarea',
								'rows' => 2,
							),
						),
					),
					array(
						'key'   => 'field_doc_note',
						'label' => 'Дисклеймер',
						'name'  => 'disclaimer',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_doc_cta_h',
						'label' => 'CTA заголовок',
						'name'  => 'cta_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_doc_cta_t',
						'label' => 'CTA текст',
						'name'  => 'cta_text',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location' => array(
					array(
						array( 'param' => 'post_type', 'operator' => '==', 'value' => 'doctor' ),
					),
				),
			)
		);
	}
);
