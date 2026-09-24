<?php
/**
 * Block: prices
 *
 * @var array $b
 * @package Alba
 */
$groups = is_array( $b['groups'] ?? null ) ? $b['groups'] : array();
$note   = $b['note'] ?? '';
if ( ! $groups ) {
	return;
}
?>
<section class="wrap price-block">
	<div class="price-block__grid">
		<?php foreach ( $groups as $g ) : ?>
			<article class="price-card">
				<h2><?php echo esc_html( $g['title'] ?? '' ); ?></h2>
				<div class="price-wrap" data-reveal>
					<table class="price-table">
						<thead><tr><th>Услуга</th><th>Стоимость</th></tr></thead>
						<tbody>
						<?php
						$rows = is_array( $g['rows'] ?? null ) ? $g['rows'] : array();
						foreach ( $rows as $row ) :
							$name = $row['name'] ?? '';
							$price = $row['price'] ?? '';
							$link = trim( (string) ( $row['link'] ?? '' ) );
							?>
							<tr>
								<td>
								<?php
								if ( $link ) {
									$href = preg_match( '#^https?://#', $link ) ? $link : alba_city_url( ltrim( $link, '/' ) );
									echo '<a href="' . esc_url( $href ) . '">' . esc_html( $name ) . '</a>';
								} else {
									echo esc_html( $name );
								}
								?>
								</td>
								<td><?php echo esc_html( $price ); ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</article>
		<?php endforeach; ?>
		<?php if ( $note ) : ?><p class="price-note" data-reveal><?php echo esc_html( $note ); ?></p><?php endif; ?>
	</div>
</section>
