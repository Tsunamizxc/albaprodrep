<?php
/**
 * Block: info_story
 *
 * @var array $b
 * @package Alba
 */
$img   = alba_media_url( $b['image_url'] ?? '' );
$alt   = $b['image_alt'] ?? '';
$ps    = alba_lines( $b['paragraphs'] ?? array() );
$lh    = $b['list_heading'] ?? '';
$ls    = alba_lines( $b['list'] ?? array() );
$btn   = $b['button'] ?? 'Записаться';
if ( ! $img && ! $ps && ! $ls ) {
	return;
}
?>
<section class="info-story wrap">
	<?php if ( $img ) : ?>
		<div class="info-story__media" data-reveal>
			<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
		</div>
	<?php endif; ?>
	<div class="info-story__text" data-reveal>
		<?php foreach ( $ps as $p ) : ?><p><?php echo esc_html( $p ); ?></p><?php endforeach; ?>
		<?php if ( $lh ) : ?><h2><?php echo esc_html( $lh ); ?></h2><?php endif; ?>
		<?php if ( $ls ) : ?>
			<ul>
				<?php foreach ( $ls as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="info-story__actions">
			<a class="btn btn--dark" href="#" data-open-modal><?php echo esc_html( $btn ); ?> <?php echo alba_arr(); // phpcs:ignore ?></a>
			<a class="btn btn--line" href="tel:<?php echo esc_attr( ( alba_get_current_city()['tel'] ?? '' ) ); ?>" data-city-tel>Позвонить</a>
		</div>
	</div>
</section>
