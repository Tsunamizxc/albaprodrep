<?php
/**
 * Default page template.
 *
 * @package Alba
 */
get_header();
?>
<main>
<?php
while ( have_posts() ) :
	the_post();
	$legacy_file = get_post_meta( get_the_ID(), '_alba_legacy_file', true );
	$legacy_path = $legacy_file ? trailingslashit( ABSPATH ) . 'legacy-html/' . $legacy_file : '';
	if ( $legacy_path && file_exists( $legacy_path ) && ! trim( wp_strip_all_tags( get_the_content() ) ) ) {
		$html = file_get_contents( $legacy_path );
		if ( preg_match( '/<main\b[^>]*>([\s\S]*?)<\/main>/i', $html, $m ) ) {
			$chunk = $m[1];
			$chunk = preg_replace_callback(
				'/href="([^"]+)\.html"/i',
				function ( $mm ) {
					$file = $mm[1];
					if ( 0 === strpos( $file, 'service-' ) ) {
						$slug = preg_replace( '/^service-/', '', $file );
						return 'href="' . esc_url( home_url( '/' . alba_get_current_city()['slug'] . '/service/' . $slug . '/' ) ) . '"';
					}
					if ( 0 === strpos( $file, 'doctor-' ) ) {
						$slug = preg_replace( '/^doctor-/', '', $file );
						return 'href="' . esc_url( home_url( '/' . alba_get_current_city()['slug'] . '/doctor/' . $slug . '/' ) ) . '"';
					}
					return 'href="' . esc_url( alba_city_url( $file === 'index' ? '' : $file ) ) . '"';
				},
				$chunk
			);
			echo $chunk; // phpcs:ignore
		}
	} else {
		?>
		<section class="page-hero wrap">
			<div class="page-hero__box">
				<div>
					<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / <?php the_title(); ?></div>
					<h1 class="split"><?php the_title(); ?></h1>
				</div>
				<?php if ( has_excerpt() ) : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			</div>
		</section>
		<section class="wrap entry-content">
			<?php the_content(); ?>
		</section>
		<?php
	}
endwhile;
?>
</main>
<?php
get_footer();
