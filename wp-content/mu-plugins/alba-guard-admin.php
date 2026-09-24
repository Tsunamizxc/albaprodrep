<?php
/**
 * Plugin Name: Alba guard admin
 * Description: Block city front redirects for WordPress admin/login paths.
 */
add_action(
	'template_redirect',
	static function () {
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
		if ( preg_match( '#/(wp-admin|wp-login\.php|wp-cron\.php|xmlrpc\.php|wp-json)(/|$)#i', $path ) ) {
			remove_action( 'template_redirect', 'alba_city_template_redirect', 1 );
		}
	},
	0
);
