<?php
/**
 * Block: catalog (cat-card grid) — CPT full catalog or ACF cards.
 *
 * @var array $b
 * @package Alba
 */

$from_cpt = ! empty( $b['from_cpt'] );
// Programs hub always uses the full CPT catalog.
if ( ! $from_cpt && function_exists( 'is_page' ) && is_page( 'programs' ) ) {
	$from_cpt = true;
}
$defs = function_exists( 'alba_catalog_term_defs' ) ? alba_catalog_term_defs() : array( 'directions' => array(), 'formats' => array() );

if ( $from_cpt && function_exists( 'alba_catalog_query' ) ) {
	$req         = alba_catalog_parse_request();
	$query       = alba_catalog_query( $req );
	$total       = (int) $query->found_posts;
	$form_action = alba_catalog_form_action();
	?>
<section class="wrap catalog-section" id="catalog" data-catalog>
	<form class="catalog-filters" method="get" action="<?php echo esc_url( $form_action ); ?>" data-catalog-filters data-reveal>
		<div class="catalog-filters__search">
			<label class="catalog-filters__label" for="catalog-q">Поиск</label>
			<input
				type="search"
				id="catalog-q"
				name="q"
				value="<?php echo esc_attr( $req['q'] ); ?>"
				placeholder="Название услуги или программы"
				autocomplete="off"
				data-catalog-q
			>
		</div>

		<fieldset class="catalog-filters__group">
			<legend>Направление</legend>
			<div class="catalog-filters__chips">
				<?php foreach ( $defs['directions'] as $slug => $label ) :
					$checked = in_array( $slug, $req['directions'], true );
					?>
					<label class="catalog-chip<?php echo $checked ? ' is-on' : ''; ?>">
						<input type="checkbox" name="direction[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( $checked ); ?> data-catalog-filter>
						<span><?php echo esc_html( $label ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>

		<fieldset class="catalog-filters__group">
			<legend>Формат</legend>
			<div class="catalog-filters__chips">
				<?php foreach ( $defs['formats'] as $slug => $label ) :
					$checked = in_array( $slug, $req['formats'], true );
					?>
					<label class="catalog-chip<?php echo $checked ? ' is-on' : ''; ?>">
						<input type="checkbox" name="format[]" value="<?php echo esc_attr( $slug ); ?>" <?php checked( $checked ); ?> data-catalog-filter>
						<span><?php echo esc_html( $label ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</fieldset>

		<div class="catalog-filters__bar">
			<p class="catalog-filters__count" data-catalog-count>Найдено: <strong><?php echo esc_html( (string) $total ); ?></strong></p>
			<div class="catalog-filters__actions">
				<button type="submit" class="btn catalog-filters__apply">Применить</button>
				<a class="btn btn--line" href="<?php echo esc_url( $form_action ); ?>#catalog" data-catalog-reset>Сбросить</a>
			</div>
		</div>
	</form>

	<div class="catalog-results" data-catalog-results>
		<?php alba_catalog_render_results( $query, $req, $form_action ); ?>
	</div>
</section>
	<?php
	return;
}

// Legacy ACF repeater cards.
$items = is_array( $b['items'] ?? null ) ? $b['items'] : array();
if ( ! $items ) {
	return;
}
?>
<section class="wrap">
	<div class="catalog">
		<?php foreach ( $items as $card ) :
			$url  = trim( (string) ( $card['url'] ?? '' ) );
			$href = '#';
			if ( $url ) {
				if ( preg_match( '#^https?://#', $url ) ) {
					$href = $url;
				} elseif ( 0 === strpos( $url, 'service-' ) || get_page_by_path( preg_replace( '/^service-/', '', $url ), OBJECT, array( 'service', 'program' ) ) ) {
					$href = function_exists( 'alba_service_permalink' ) ? alba_service_permalink( $url ) : alba_city_url( $url );
				} else {
					$href = alba_city_url( ltrim( $url, '/' ) );
				}
			}
			$accent = ! empty( $card['accent'] ) ? ' cat-card--accent' : '';
			$icon   = function_exists( 'alba_media_url' ) ? alba_media_url( $card['icon'] ?? '' ) : ( $card['icon'] ?? '' );
			?>
			<a class="cat-card<?php echo esc_attr( $accent ); ?>" href="<?php echo esc_url( $href ); ?>" data-reveal>
				<?php if ( ! empty( $card['badge'] ) ) : ?><span><?php echo esc_html( $card['badge'] ); ?></span><?php endif; ?>
				<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
				<?php if ( ! empty( $card['text'] ) ) : ?><p><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
				<?php if ( ! empty( $card['price'] ) ) : ?><b><?php echo esc_html( $card['price'] ); ?></b><?php endif; ?>
				<?php if ( $icon ) : ?><img src="<?php echo esc_url( $icon ); ?>" alt=""><?php endif; ?>
			</a>
		<?php endforeach; ?>
	</div>
</section>
