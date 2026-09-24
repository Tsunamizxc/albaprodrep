<?php
/**
 * Block: ward_fund
 *
 * @var array $b
 * @var array $city
 * @package Alba
 */
$h     = $b['heading'] ?? '';
$l     = $b['lead'] ?? '';
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
$btn   = $b['button'] ?? 'Забронировать палату';
?>
<section class="ward-fund wrap" data-reveal id="ward-fund">
	<div class="ward-fund__head">
		<?php if ( $h ) : ?><h2 class="section-title"><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
		<?php if ( $l ) : ?><p><?php echo esc_html( $l ); ?></p><?php endif; ?>
	</div>
	<?php if ( $items ) : ?>
		<div class="ward-fund__grid">
			<?php foreach ( $items as $it ) :
				$feat = ! empty( $it['featured'] ) ? ' ward-fund__feat' : '';
				$list = alba_lines( $it['list'] ?? array() );
				?>
				<article class="<?php echo esc_attr( trim( $feat ) ); ?>">
					<?php if ( ! empty( $it['badge'] ) ) : ?><span class="ward-fund__badge"><?php echo esc_html( $it['badge'] ); ?></span><?php endif; ?>
					<h3><?php echo esc_html( $it['title'] ?? '' ); ?></h3>
					<?php if ( $list ) : ?>
						<ul>
							<?php foreach ( $list as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="ward-fund__cta">
		<a class="btn btn--blue" href="#" data-open-modal><?php echo esc_html( $btn ); ?> <?php echo alba_arr(); // phpcs:ignore ?></a>
		<a class="btn btn--line" href="tel:<?php echo esc_attr( $city['tel'] ?? '' ); ?>" data-city-tel>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ?? '' ); ?></span></a>
	</div>
</section>
