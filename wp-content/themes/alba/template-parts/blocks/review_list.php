<?php
/**
 * Block: review_list
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$lead  = $b['lead'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p class="about-lead" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<div class="review-list">
		<?php foreach ( $items as $it ) :
			$is_lead = ! empty( $it['featured'] );
			?>
			<article class="review<?php echo $is_lead ? ' review--lead' : ''; ?>" data-reveal>
				<p><?php echo esc_html( $it['text'] ?? '' ); ?></p>
				<div class="review__who">
					<div>
						<b><?php echo esc_html( $it['name'] ?? '' ); ?></b>
						<?php if ( ! empty( $it['role'] ) ) : ?><span><?php echo esc_html( $it['role'] ); ?></span><?php endif; ?>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
