<?php
/**
 * Block: timeline
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
?>
<section class="about-timeline wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $items ) : ?>
		<ol class="about-timeline__list">
			<?php foreach ( $items as $it ) : ?>
				<li data-reveal><b><?php echo esc_html( $it['year'] ?? '' ); ?></b><span><?php echo esc_html( $it['text'] ?? '' ); ?></span></li>
			<?php endforeach; ?>
		</ol>
	<?php endif; ?>
</section>
