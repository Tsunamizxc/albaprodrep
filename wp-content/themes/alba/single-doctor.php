<?php
/**
 * Single doctor — ACF fields only (no legacy HTML).
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
while ( have_posts() ) :
	the_post();
	if ( function_exists( 'alba_render_doctor' ) ) {
		alba_render_doctor( get_the_ID() );
	}
endwhile;
?>
</main>
<?php
get_footer();
