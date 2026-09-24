<?php
/**
 * Block: sitemap
 *
 * @var array $b
 * @package Alba
 */
$jumps    = is_array( $b['jumps'] ?? null ) ? $b['jumps'] : array();
$sections = is_array( $b['sections'] ?? null ) ? $b['sections'] : array();
$note     = $b['note'] ?? '';
if ( ! $sections && ! $jumps ) {
	return;
}
?>
<section class="map-page">
	<?php if ( $jumps ) : ?>
		<nav class="map-jump wrap" aria-label="Быстрый переход" data-reveal>
			<?php foreach ( $jumps as $j ) :
				$anchor = ltrim( (string) ( $j['anchor'] ?? '' ), '#' );
				if ( ! $anchor ) {
					continue;
				}
				?>
				<a href="#<?php echo esc_attr( $anchor ); ?>"><?php echo esc_html( $j['label'] ?? $anchor ); ?></a>
			<?php endforeach; ?>
		</nav>
	<?php endif; ?>

	<div class="map-body wrap">
		<?php foreach ( $sections as $i => $sec ) :
			$sid    = $sec['anchor'] ?? ( 'map-sec-' . ( $i + 1 ) );
			$num    = $sec['number'] ?? str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT );
			$title  = $sec['title'] ?? '';
			$lead   = $sec['lead'] ?? '';
			$groups = is_array( $sec['groups'] ?? null ) ? $sec['groups'] : array();
			$links  = is_array( $sec['links'] ?? null ) ? $sec['links'] : array();
			?>
			<article class="map-block" id="<?php echo esc_attr( $sid ); ?>" data-reveal>
				<header class="map-block__head">
					<span class="map-block__n"><?php echo esc_html( $num ); ?></span>
					<div>
						<?php if ( $title ) : ?><h2><?php echo esc_html( $title ); ?></h2><?php endif; ?>
						<?php if ( $lead ) : ?><p><?php echo esc_html( $lead ); ?></p><?php endif; ?>
					</div>
				</header>
				<?php if ( $groups ) : ?>
					<?php foreach ( $groups as $g ) :
						$glinks = is_array( $g['links'] ?? null ) ? $g['links'] : array();
						?>
						<div class="map-group">
							<?php if ( ! empty( $g['title'] ) ) : ?><h3><?php echo esc_html( $g['title'] ); ?></h3><?php endif; ?>
							<?php if ( $glinks ) : ?>
								<div class="map-links">
									<?php foreach ( $glinks as $lnk ) : ?>
										<a href="<?php echo esc_url( alba_block_href( $lnk['url'] ?? '#' ) ); ?>"><?php echo esc_html( $lnk['label'] ?? '' ); ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php elseif ( $links ) : ?>
					<div class="map-links">
						<?php foreach ( $links as $lnk ) : ?>
							<a href="<?php echo esc_url( alba_block_href( $lnk['url'] ?? '#' ) ); ?>"><?php echo esc_html( $lnk['label'] ?? '' ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( $note ) : ?>
		<p class="map-note wrap" data-reveal><?php echo esc_html( $note ); ?></p>
	<?php endif; ?>
</section>
