<?php
/**
 * Theme setup, assets, menus.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 200, 'flex-height' => true, 'flex-width' => true ) );

		register_nav_menus(
			array(
				'primary'   => __( 'Основное меню', 'alba' ),
				'mobile'    => __( 'Мобильное меню', 'alba' ),
				'footer'    => __( 'Футер', 'alba' ),
				'programs'  => __( 'Программы (выпадающее)', 'alba' ),
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		$css = trailingslashit( ABSPATH ) . 'css/style.css';
		$js  = trailingslashit( ABSPATH ) . 'js/main.js';
		$ver = file_exists( $css ) ? (string) filemtime( $css ) : ALBA_VERSION;

		wp_enqueue_style( 'alba-fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap', array(), null );
		wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11' );
		wp_enqueue_style( 'alba-main', home_url( '/css/style.css' ), array( 'alba-fonts', 'swiper' ), $ver );

		wp_enqueue_script( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true );
		wp_enqueue_script( 'alba-main', home_url( '/js/main.js' ), array( 'swiper' ), file_exists( $js ) ? (string) filemtime( $js ) : ALBA_VERSION, true );

		$city = alba_get_current_city();
		// Before main.js: seed localStorage so geo modal does not reopen / reload-loop.
		wp_add_inline_script(
			'alba-main',
			'try{localStorage.setItem("alba-city",' . wp_json_encode( $city['slug'] ) . ');}catch(e){}',
			'before'
		);

		$bridge = ALBA_DIR . '/assets/city-bridge.js';
		wp_enqueue_script(
			'alba-city-bridge',
			ALBA_URI . '/assets/city-bridge.js',
			array( 'alba-main' ),
			file_exists( $bridge ) ? (string) filemtime( $bridge ) : ALBA_VERSION,
			true
		);

		wp_localize_script(
			'alba-main',
			'ALBA',
			array(
				'ajax'   => admin_url( 'admin-ajax.php' ),
				'home'   => home_url( '/' ),
				'city'   => $city,
				'cities' => alba_get_cities_public(),
				'nonce'  => wp_create_nonce( 'alba_city' ),
				'rest'   => esc_url_raw( rest_url( 'alba/v1' ) ),
			)
		);

		$quiz = trailingslashit( ABSPATH ) . 'js/test-quiz.js';
		if ( is_page( 'test' ) || is_page_template( 'page-test.php' ) ) {
			wp_enqueue_script(
				'alba-test-quiz',
				home_url( '/js/test-quiz.js' ),
				array( 'alba-main' ),
				file_exists( $quiz ) ? (string) filemtime( $quiz ) : ALBA_VERSION,
				true
			);
			wp_localize_script(
				'alba-test-quiz',
				'ALBA_QUIZ',
				function_exists( 'alba_get_quizzes_for_js' ) ? alba_get_quizzes_for_js() : array( 'cats' => array() )
			);
		}
	}
);

add_filter(
	'acf/settings/save_json',
	function () {
		return ALBA_DIR . '/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = ALBA_DIR . '/acf-json';
		return $paths;
	}
);
