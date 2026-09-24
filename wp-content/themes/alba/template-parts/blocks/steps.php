<?php
/**
 * Block: steps
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$lead  = $b['lead'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items && ! $h ) {
	return;
}
?>
<section class="steps wrap">
	<?php if ( $h || $lead ) : ?>
		<div class="steps__head" data-reveal>
			<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $lead ) : ?><p><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if ( $items ) : ?>
		<div class="steps__grid">
			<?php foreach ( $items as $i => $it ) : ?>
				<article class="step" data-reveal<?php echo $i ? ' data-delay="' . esc_attr( (string) ( $i * 60 ) ) . '"' : ''; ?>>
					<div class="step__n"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
					<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $it['text'] ?? '' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
