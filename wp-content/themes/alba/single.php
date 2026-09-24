<?php
/**
 * Single post (articles) — ACF only.
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
while ( have_posts() ) :
	the_post();
	if ( function_exists( 'alba_render_article' ) ) {
		alba_render_article( get_the_ID() );
	}
endwhile;
?>
</main>
<?php
get_footer();
