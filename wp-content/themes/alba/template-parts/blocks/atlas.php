<?php
/**
 * Block: atlas (methods map)
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
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p class="about-lead" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<?php if ( $items ) : ?>
		<div class="atlas">
			<?php foreach ( $items as $it ) : ?>
				<a href="<?php echo esc_url( alba_block_href( $it['url'] ?? '#' ) ); ?>" data-reveal>
					<?php if ( ! empty( $it['eyebrow'] ) ) : ?><span><?php echo esc_html( $it['eyebrow'] ); ?></span><?php endif; ?>
					<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
					<?php if ( ! empty( $it['text'] ) ) : ?><p><?php echo esc_html( $it['text'] ); ?></p><?php endif; ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
