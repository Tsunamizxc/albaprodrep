<?php
/**
 * Doctors archive — same people grid as the page.
 *
 * @package Alba
 */
get_header();
$city = alba_get_current_city();
?>
<main>
	<section class="page-intro wrap">
		<div class="page-intro__inner">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / Врачи</div>
				<h1 class="split">Медицинская команда<br>экспертного уровня</h1>
			</div>
			<p>Наркологи, психиатры и психотерапевты работают в одной смене. Решение по протоколу принимается вместе.</p>
		</div>
	</section>
	<?php
	$b = array(
		'heading'  => 'Наши специалисты',
		'lead'     => 'Выездные бригады, амбулаторный приём и стационарное отделение — три контура помощи. Можно выбрать специалиста ещё до визита.',
		'from_cpt' => 1,
		'items'    => array(),
	);
	include get_template_directory() . '/template-parts/blocks/doctors_grid.php';
	?>
</main>
<?php
get_footer();
