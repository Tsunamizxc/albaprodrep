<?php
/**
 * Block: text_image
 *
 * @var array $b
 * @package Alba
 */
$h   = $b['heading'] ?? '';
$ps  = alba_lines( $b['paragraphs'] ?? array() );
$ls  = alba_lines( $b['list'] ?? array() );
$img = alba_media_url( $b['image_url'] ?? '' );
$alt = $b['image_alt'] ?? '';
$right = ! empty( $b['image_right'] );
?>
<section class="about wrap">
	<div data-reveal="<?php echo $right ? 'left' : 'right'; ?>">
		<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
		<?php foreach ( $ps as $p ) : ?><p><?php echo esc_html( $p ); ?></p><?php endforeach; ?>
		<?php if ( $ls ) : ?>
			<ul class="about-bullets">
				<?php foreach ( $ls as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php if ( $img ) : ?>
		<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>" data-reveal="<?php echo $right ? 'right' : 'left'; ?>" loading="lazy">
	<?php endif; ?>
</section>
