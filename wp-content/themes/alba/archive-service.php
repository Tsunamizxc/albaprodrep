<?php
/**
 * Services archive / programs catalog.
 *
 * @package Alba
 */
get_header();
?>
<main>
	<section class="page-hero wrap">
		<div class="page-hero__box">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / Программы</div>
				<h1 class="split">Каталог программ<br>и услуг</h1>
			</div>
			<p>Все направления заполняются из админки WordPress. Контакты зависят от города.</p>
		</div>
	</section>
	<section class="wrap">
		<div class="catalog">
		<?php
		$q = new WP_Query(
			array(
				'post_type'      => array( 'service', 'program' ),
				'posts_per_page' => 100,
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
		while ( $q->have_posts() ) :
			$q->the_post();
			$price = alba_field( 'price_label', get_the_ID(), '' );
			?>
			<a class="cat-card" href="<?php the_permalink(); ?>" data-reveal>
				<span>18+, добровольно</span>
				<h3><?php the_title(); ?></h3>
				<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php if ( $price ) : ?><b><?php echo esc_html( $price ); ?></b><?php endif; ?>
			</a>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
		</div>
	</section>
</main>
<?php
get_footer();
