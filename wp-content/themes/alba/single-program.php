<?php
/**
 * Single program — ACF fields only (no legacy HTML).
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
while ( have_posts() ) :
	the_post();
	alba_render_service( get_the_ID() );
endwhile;
?>
</main>
<?php
get_footer();
