<?php
/**
 * Default page template — ACF page_blocks only (no HTML body).
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
while ( have_posts() ) :
	the_post();

	if ( function_exists( 'alba_page_uses_acf' ) && alba_page_uses_acf( get_the_ID() ) ) {
		alba_render_acf_page( get_the_ID() );
		continue;
	}

	// Empty structured page: show title so editors know to fill ACF.
	?>
	<section class="page-hero wrap">
		<div class="page-hero__box">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / <?php the_title(); ?></div>
				<h1 class="split"><?php the_title(); ?></h1>
			</div>
			<p>Добавьте блоки в поле «Контент страницы (ACF)» или запустите заполнение в Альба → Импорт HTML.</p>
		</div>
	</section>
	<?php
endwhile;
?>
</main>
<?php
get_footer();
