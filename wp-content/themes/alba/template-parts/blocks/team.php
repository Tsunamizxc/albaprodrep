<?php
/**
 * Block: team
 *
 * @var array $b
 * @package Alba
 */
$h    = $b['heading'] ?? '';
$l    = $b['lead'] ?? '';
$btn  = $b['button'] ?? 'Смотреть врачей';
$url  = $b['button_url'] ?? 'doctors';
$href = alba_block_href( $url );
?>
<section class="about-team wrap">
	<div class="about-team__box" data-reveal>
		<div>
			<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $l ) : ?><p><?php echo esc_html( $l ); ?></p><?php endif; ?>
		</div>
		<a class="btn btn--dark" href="<?php echo esc_url( $href ); ?>"><?php echo esc_html( $btn ); ?></a>
	</div>
</section>
