<?php
/**
 * Block: gallery
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$lead  = $b['lead'] ?? '';
$btn   = $b['button'] ?? '';
$burl  = $b['button_url'] ?? 'gallery';
$style = $b['style'] ?? 'about';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items && ! $h ) {
	return;
}

if ( 'about' === $style ) :
	?>
<section class="about-gallery wrap">
	<div class="about-gallery__head" data-reveal>
		<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
		<?php if ( $lead ) : ?><p><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		<?php if ( $btn ) : ?>
			<a class="btn btn--blue" href="<?php echo esc_url( alba_block_href( $burl ) ); ?>"><?php echo esc_html( $btn ); ?></a>
		<?php endif; ?>
	</div>
	<?php if ( $items ) : ?>
		<div class="about-gallery__grid" data-reveal>
			<?php foreach ( $items as $it ) :
				$url = alba_media_url( $it['image_url'] ?? '' );
				if ( ! $url ) {
					continue;
				}
				?>
				<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $it['alt'] ?? '' ); ?>" loading="lazy">
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
	<?php
	return;
endif;
?>
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<div class="gallery">
		<?php foreach ( $items as $it ) :
			$url = alba_media_url( $it['image_url'] ?? '' );
			if ( ! $url ) {
				continue;
			}
			?>
			<figure data-reveal>
				<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $it['alt'] ?? '' ); ?>" loading="lazy">
				<?php if ( ! empty( $it['caption'] ) ) : ?><figcaption><?php echo esc_html( $it['caption'] ); ?></figcaption><?php endif; ?>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
