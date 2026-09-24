<?php
/**
 * Альба theme bootstrap.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ALBA_VERSION', '1.0.0' );
define( 'ALBA_DIR', get_template_directory() );
define( 'ALBA_URI', get_template_directory_uri() );
define( 'ALBA_STATIC_URI', home_url( '/' ) );

require_once ALBA_DIR . '/inc/setup.php';
require_once ALBA_DIR . '/inc/disable-gutenberg.php';
require_once ALBA_DIR . '/inc/cpt.php';
require_once ALBA_DIR . '/inc/cities.php';
require_once ALBA_DIR . '/inc/rewrites.php';
require_once ALBA_DIR . '/inc/acf-fields.php';
require_once ALBA_DIR . '/inc/page-blocks.php';
require_once ALBA_DIR . '/inc/page-acf.php';
require_once ALBA_DIR . '/inc/page-seed-hubs.php';
require_once ALBA_DIR . '/inc/catalog-query.php';
require_once ALBA_DIR . '/inc/service-acf.php';
require_once ALBA_DIR . '/inc/doctor-acf.php';
require_once ALBA_DIR . '/inc/quiz.php';
require_once ALBA_DIR . '/inc/integrations.php';
require_once ALBA_DIR . '/inc/admin-settings.php';
require_once ALBA_DIR . '/inc/importer.php';
require_once ALBA_DIR . '/inc/template-tags.php';
require_once ALBA_DIR . '/inc/seo.php';
require_once ALBA_DIR . '/inc/article-acf.php';
