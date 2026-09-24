<?php
/**
 * Front page — ACF page_blocks (home modules), no HTML from admin.
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
$front_id = (int) get_option( 'page_on_front' );
if ( $front_id && function_exists( 'alba_page_uses_acf' ) && alba_page_uses_acf( $front_id ) ) {
	alba_render_acf_page( $front_id );
} elseif ( $front_id && function_exists( 'alba_render_acf_page' ) ) {
	// Soft fallback: still try ACF render (hero modules may be empty until seed).
	alba_render_acf_page( $front_id );
} else {
	echo '<section class="wrap"><p>Заполните главную в админке: блоки «Модуль главной», либо запустите «Заполнить ACF» в Альба → Импорт HTML.</p></section>';
}
?>
</main>
<?php
get_footer();
