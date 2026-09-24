<?php
/**
 * Block: links (links-grid / links-card)
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
		<div class="links-grid">
			<?php foreach ( $items as $it ) :
				$url   = $it['url'] ?? '';
				$href  = alba_block_href( $url );
				$ext   = (bool) preg_match( '#^https?://#i', (string) $url );
				$label = $it['label'] ?? '';
				$eye   = $it['eyebrow'] ?? '';
				$text  = $it['text'] ?? '';
				?>
				<article class="links-card" data-reveal>
					<?php if ( $eye ) : ?><span><?php echo esc_html( $eye ); ?></span><?php endif; ?>
					<a href="<?php echo esc_url( $href ); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $label ); ?></a>
					<?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
