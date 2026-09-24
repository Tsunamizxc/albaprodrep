<?php
/**
 * 404
 *
 * @package Alba
 */
get_header();
?>
<main>
	<section class="page-hero wrap">
		<div class="page-hero__box">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / 404</div>
				<h1 class="split">Страница не найдена</h1>
			</div>
			<p>Проверьте адрес или вернитесь на главную. Контент редактируется в WordPress.</p>
		</div>
	</section>
	<section class="cta wrap">
		<div class="cta__box" data-reveal="scale">
			<div><h2>Нужна помощь?</h2><p>Дежурный врач на связи 24/7.</p></div>
			<div class="cta__actions">
				<a class="btn btn--light" href="<?php echo esc_url( alba_city_url() ); ?>">На главную <?php echo alba_arr(); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light" href="#" data-open-modal>Оставить заявку</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
