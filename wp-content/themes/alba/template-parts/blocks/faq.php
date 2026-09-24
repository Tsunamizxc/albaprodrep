<?php
/**
 * Block: faq
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
?>
<section class="faq wrap" data-page-faq>
	<?php if ( $h ) : ?>
		<div data-reveal>
			<h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2>
		</div>
	<?php endif; ?>
	<?php if ( $items ) : ?>
		<div class="acc" data-acc data-reveal>
			<?php foreach ( $items as $i => $it ) : ?>
				<article class="acc__item<?php echo 0 === $i ? ' is-open' : ''; ?>">
					<button class="acc__btn" type="button"><?php echo esc_html( $it['q'] ?? $it['question'] ?? '' ); ?><i>+</i></button>
					<div class="acc__panel"><div><p><?php echo esc_html( $it['a'] ?? $it['answer'] ?? '' ); ?></p></div></div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
