<?php
/**
 * Custom post types and taxonomies.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'service',
			array(
				'labels'       => array(
					'name'          => 'Услуги',
					'singular_name' => 'Услуга',
					'add_new_item'  => 'Добавить услугу',
					'edit_item'     => 'Редактировать услугу',
				),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'service', 'with_front' => false ),
				'menu_icon'    => 'dashicons-heart',
				'supports'     => array( 'title', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);

		register_post_type(
			'program',
			array(
				'labels'       => array(
					'name'          => 'Программы',
					'singular_name' => 'Программа',
					'add_new_item'  => 'Добавить программу',
					'edit_item'     => 'Редактировать программу',
				),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'program', 'with_front' => false ),
				'menu_icon'    => 'dashicons-clipboard',
				'supports'     => array( 'title', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);

		register_post_type(
			'doctor',
			array(
				'labels'       => array(
					'name'          => 'Врачи',
					'singular_name' => 'Врач',
				),
				'public'       => true,
				'show_in_rest' => true,
				'has_archive'  => 'doctors',
				'rewrite'      => array( 'slug' => 'doctor', 'with_front' => false ),
				'menu_icon'    => 'dashicons-groups',
				'supports'     => array( 'title', 'excerpt', 'thumbnail', 'revisions' ),
			)
		);

		register_taxonomy(
			'service_cat',
			array( 'service', 'program' ),
			array(
				'label'        => 'Категории услуг',
				'hierarchical' => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'service-cat' ),
			)
		);

		register_taxonomy(
			'doctor_spec',
			array( 'doctor' ),
			array(
				'label'        => 'Специальности',
				'hierarchical' => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'spec' ),
			)
		);
	}
);
