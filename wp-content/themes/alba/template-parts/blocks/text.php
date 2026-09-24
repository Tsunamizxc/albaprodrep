<?php
/**
 * Block: text
 *
 * @var array $b
 * @package Alba
 */
$h  = $b['heading'] ?? '';
$ps = alba_lines( $b['paragraphs'] ?? array() );
$ls = alba_lines( $b['list'] ?? array() );
$id = trim( (string) ( $b['anchor'] ?? '' ) );
$aid = $id ? ' id="' . esc_attr( $id ) . '"' : '';
?>
<section class="wrap"<?php echo $aid; // phpcs:ignore ?>>
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<?php foreach ( $ps as $p ) : ?><p data-reveal><?php echo esc_html( $p ); ?></p><?php endforeach; ?>
	<?php if ( $ls ) : ?>
		<ul class="about-bullets" data-reveal>
			<?php foreach ( $ls as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
		</ul>
	<?php endif; ?>
</section>
