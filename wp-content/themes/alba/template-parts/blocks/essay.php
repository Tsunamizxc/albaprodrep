<?php
/**
 * Block: essay (SEO / long-form)
 *
 * @var array $b
 * @package Alba
 */
$h        = $b['heading'] ?? '';
$sections = is_array( $b['sections'] ?? null ) ? $b['sections'] : array();
$note     = $b['note'] ?? '';
$ps       = alba_lines( $b['paragraphs'] ?? array() );
if ( ! $h && ! $sections && ! $ps ) {
	return;
}
?>
<section class="essay wrap">
	<?php if ( $h ) : ?><h2 class="section-title" data-reveal><?php echo alba_title_br( $h ); // phpcs:ignore ?></h2><?php endif; ?>
	<div class="essay-col" data-reveal>
		<?php foreach ( $ps as $p ) : ?><p><?php echo esc_html( $p ); ?></p><?php endforeach; ?>
		<?php foreach ( $sections as $sec ) :
			$st = $sec['title'] ?? '';
			$sp = alba_lines( $sec['paragraphs'] ?? array() );
			$sl = alba_lines( $sec['list'] ?? array() );
			$ol = ! empty( $sec['ordered'] );
			?>
			<?php if ( $st ) : ?><h3><?php echo esc_html( $st ); ?></h3><?php endif; ?>
			<?php foreach ( $sp as $p ) : ?><p><?php echo esc_html( $p ); ?></p><?php endforeach; ?>
			<?php if ( $sl ) : ?>
				<?php echo $ol ? '<ol>' : '<ul class="about-bullets">'; ?>
					<?php foreach ( $sl as $li ) : ?><li><?php echo esc_html( $li ); ?></li><?php endforeach; ?>
				<?php echo $ol ? '</ol>' : '</ul>'; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if ( $note ) : ?><div class="note"><?php echo esc_html( $note ); ?></div><?php endif; ?>
	</div>
</section>
