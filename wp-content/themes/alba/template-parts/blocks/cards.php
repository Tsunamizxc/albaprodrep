<?php
/**
 * Block: cards
 *
 * @var array $b
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$lead  = $b['lead'] ?? '';
$style = $b['style'] ?? 'pillars';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items && ! $h ) {
	return;
}
if ( 'anon' === $style ) :
	?>
<section class="wrap"<?php echo ! empty( $b['anchor'] ) ? ' id="' . esc_attr( $b['anchor'] ) . '"' : ''; ?>>
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p class="about-lead" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<div class="anon">
		<?php foreach ( $items as $i => $it ) : ?>
			<article data-reveal<?php echo $i ? ' data-delay="' . esc_attr( (string) ( $i * 80 ) ) . '"' : ''; ?>>
				<?php
				$ico = alba_anon_icon_svg( $it['icon'] ?? '' );
				if ( $ico ) :
					?>
					<div class="anon__ico"><?php echo $ico; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
				<?php endif; ?>
				<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
				<p><?php echo esc_html( $it['text'] ?? '' ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>
<?php elseif ( 'info' === $style ) : ?>
<section class="wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<div class="info-list">
		<?php foreach ( $items as $it ) : ?>
			<article class="info" data-reveal>
				<span><?php echo esc_html( $it['title'] ?? '' ); ?></span>
				<b><?php echo esc_html( $it['text'] ?? '' ); ?></b>
			</article>
		<?php endforeach; ?>
	</div>
</section>
<?php else : ?>
<section class="about-pillars wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php if ( $lead ) : ?><p class="about-lead" data-reveal><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	<div class="about-pillars__grid">
		<?php foreach ( $items as $i => $it ) : ?>
			<article data-reveal<?php echo $i ? ' data-delay="' . esc_attr( (string) ( $i * 60 ) ) . '"' : ''; ?>>
				<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
				<p><?php echo esc_html( $it['text'] ?? '' ); ?></p>
			</article>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>
