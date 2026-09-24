<?php
/**
 * Block: related (cat-card row)
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? 'Рядом по маршруту';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<div class="related">
		<?php foreach ( $items as $it ) : ?>
			<a class="cat-card" href="<?php echo esc_url( alba_block_href( $it['url'] ?? '#' ) ); ?>" data-reveal>
				<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $it['text'] ) ) : ?><p><?php echo esc_html( $it['text'] ); ?></p><?php endif; ?>
				<span class="more"><?php echo esc_html( $it['more'] ?? 'Открыть' ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
