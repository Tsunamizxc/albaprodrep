<?php
/**
 * Service / program ACF: structured body (no HTML in admin), render + seed.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'acf/init',
	static function () {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		// Service/program structured fields (no HTML / WYSIWYG).
		$body_layouts = array(
			'layout_svc_h'   => array(
				'key'        => 'layout_svc_h',
				'name'       => 'heading',
				'label'      => 'Заголовок',
				'display'    => 'row',
				'sub_fields' => array(
					array(
						'key'           => 'fld_svc_hl',
						'label'         => 'Уровень',
						'name'          => 'level',
						'type'          => 'select',
						'choices'       => array( 'h2' => 'H2', 'h3' => 'H3' ),
						'default_value' => 'h2',
					),
					array(
						'key'   => 'fld_svc_ht',
						'label' => 'Текст',
						'name'  => 'text',
						'type'  => 'text',
					),
				),
			),
			'layout_svc_p'   => array(
				'key'        => 'layout_svc_p',
				'name'       => 'paragraphs',
				'label'      => 'Абзацы',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_svc_ps',
						'label'        => 'Абзацы',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Абзац',
						'sub_fields'   => array(
							array( 'key' => 'fld_svc_pt', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 3 ),
						),
					),
				),
			),
			'layout_svc_l'   => array(
				'key'        => 'layout_svc_l',
				'name'       => 'list',
				'label'      => 'Список',
				'display'    => 'block',
				'sub_fields' => array(
					array(
						'key'          => 'fld_svc_ls',
						'label'        => 'Пункты',
						'name'         => 'items',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Пункт',
						'sub_fields'   => array(
							array( 'key' => 'fld_svc_li', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
						),
					),
				),
			),
			'layout_svc_fig' => array(
				'key'        => 'layout_svc_fig',
				'name'       => 'figure',
				'label'      => 'Фото',
				'display'    => 'row',
				'sub_fields' => array(
					array( 'key' => 'fld_svc_fu', 'label' => 'URL', 'name' => 'image_url', 'type' => 'text' ),
					array( 'key' => 'fld_svc_fa', 'label' => 'Alt', 'name' => 'alt', 'type' => 'text' ),
					array( 'key' => 'fld_svc_fc', 'label' => 'Подпись', 'name' => 'caption', 'type' => 'text' ),
				),
			),
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_alba_service',
				'title'                 => 'Услуга / программа (ACF)',
				'fields'                => array(
					array(
						'key'          => 'field_svc_hero',
						'label'        => 'H1',
						'name'         => 'hero_title',
						'type'         => 'text',
						'instructions' => 'Перенос строки: |',
					),
					array(
						'key'   => 'field_svc_lead',
						'label' => 'Лид под H1',
						'name'  => 'lead',
						'type'  => 'textarea',
						'rows'  => 3,
					),
					array(
						'key'   => 'field_svc_cover_url',
						'label' => 'Обложка (URL)',
						'name'  => 'cover_url',
						'type'  => 'text',
						'instructions' => '/images/… или полный URL',
					),
					array(
						'key'          => 'field_svc_intro',
						'label'        => 'Вводные абзацы (колонка слева)',
						'name'         => 'intro',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Абзац',
						'sub_fields'   => array(
							array( 'key' => 'field_svc_intro_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
					array(
						'key'   => 'field_svc_price',
						'label' => 'Цена (подпись)',
						'name'  => 'price_label',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_svc_price_note',
						'label' => 'Подпись цены',
						'name'  => 'price_note',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_svc_includes',
						'label'        => 'Что входит',
						'name'         => 'includes',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Пункт',
						'sub_fields'   => array(
							array( 'key' => 'field_svc_includes_item', 'label' => 'Текст', 'name' => 'item', 'type' => 'text' ),
						),
					),
					array(
						'key'   => 'field_svc_doctor_name',
						'label' => 'Вам поможет — ФИО',
						'name'  => 'help_doctor_name',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_svc_doctor_role',
						'label' => 'Вам поможет — специальность',
						'name'  => 'help_doctor_role',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_svc_doctor_photo',
						'label' => 'Вам поможет — фото (URL)',
						'name'  => 'help_doctor_photo',
						'type'  => 'text',
					),
					array(
						'key'          => 'field_svc_related',
						'label'        => 'Связанные программы (карточки)',
						'name'         => 'related_programs',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							array( 'key' => 'fld_rel_badge', 'label' => 'Бейдж', 'name' => 'badge', 'type' => 'text' ),
							array( 'key' => 'fld_rel_title', 'label' => 'Заголовок', 'name' => 'title', 'type' => 'text' ),
							array( 'key' => 'fld_rel_text', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
							array( 'key' => 'fld_rel_price', 'label' => 'Цена', 'name' => 'price', 'type' => 'text' ),
							array( 'key' => 'fld_rel_url', 'label' => 'Ссылка (slug или URL)', 'name' => 'url', 'type' => 'text' ),
							array( 'key' => 'fld_rel_feat', 'label' => 'Выделить', 'name' => 'featured', 'type' => 'true_false', 'ui' => 1 ),
						),
					),
					array(
						'key'   => 'field_svc_rel_h',
						'label' => 'Заголовок блока связанных программ',
						'name'  => 'related_heading',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_svc_rel_l',
						'label' => 'Лид связанных программ',
						'name'  => 'related_lead',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'   => 'field_svc_funnel_h',
						'label' => 'Воронка — заголовок',
						'name'  => 'funnel_title',
						'type'  => 'text',
					),
					array(
						'key'   => 'field_svc_funnel_t',
						'label' => 'Воронка — текст',
						'name'  => 'funnel_text',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_svc_funnel_c',
						'label'        => 'Воронка — чипы',
						'name'         => 'funnel_chips',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Чип',
						'sub_fields'   => array(
							array( 'key' => 'fld_svc_fc_t', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
						),
					),
					array(
						'key'          => 'field_svc_benefits',
						'label'        => 'Преимущества',
						'name'         => 'benefits',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Карточка',
						'sub_fields'   => array(
							array( 'key' => 'fld_ben_t', 'label' => 'Заголовок', 'name' => 'title', 'type' => 'text' ),
							array( 'key' => 'fld_ben_d', 'label' => 'Текст', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
						),
					),
					array(
						'key'          => 'field_svc_body',
						'label'        => 'Статья (блоки)',
						'name'         => 'body_blocks',
						'type'         => 'flexible_content',
						'button_label' => 'Добавить блок',
						'layouts'      => $body_layouts,
					),
					array(
						'key'   => 'field_svc_sticky_tip_h',
						'label' => 'Липкий блок — совет (заголовок)',
						'name'  => 'sticky_tip_title',
						'type'  => 'text',
						'default_value' => 'Близкий отказывается от помощи?',
					),
					array(
						'key'   => 'field_svc_sticky_tip_t',
						'label' => 'Липкий блок — совет (текст)',
						'name'  => 'sticky_tip_text',
						'type'  => 'textarea',
						'rows'  => 3,
						'default_value' => 'Не уговаривайте через силу. Дежурный подскажет, как начать разговор и когда вызывать врача на дом.',
					),
					array(
						'key'   => 'field_svc_sticky_tip_btn',
						'label' => 'Липкий блок — совет (кнопка)',
						'name'  => 'sticky_tip_button',
						'type'  => 'text',
						'default_value' => 'Получить совет',
					),
					array(
						'key'   => 'field_svc_sticky_form_h',
						'label' => 'Липкий блок — форма (заголовок)',
						'name'  => 'sticky_form_title',
						'type'  => 'text',
						'default_value' => 'Перезвоним за 2 минуты',
					),
					array(
						'key'   => 'field_svc_sticky_rel_h',
						'label' => 'Липкий блок — ссылки (заголовок)',
						'name'  => 'sticky_links_heading',
						'type'  => 'text',
						'default_value' => 'Рядом по маршруту',
					),
					array(
						'key'          => 'field_svc_sticky_links',
						'label'        => 'Липкий блок — ссылки',
						'name'         => 'sticky_links',
						'type'         => 'repeater',
						'layout'       => 'table',
						'button_label' => 'Ссылка',
						'sub_fields'   => array(
							array( 'key' => 'fld_stk_title', 'label' => 'Название', 'name' => 'title', 'type' => 'text' ),
							array( 'key' => 'fld_stk_price', 'label' => 'Цена', 'name' => 'price', 'type' => 'text' ),
							array( 'key' => 'fld_stk_url', 'label' => 'Ссылка', 'name' => 'url', 'type' => 'text' ),
						),
					),
					array(
						'key'          => 'field_svc_faq',
						'label'        => 'FAQ',
						'name'         => 'faq',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'Вопрос',
						'sub_fields'   => array(
							array( 'key' => 'field_faq_q', 'label' => 'Вопрос', 'name' => 'q', 'type' => 'text' ),
							array( 'key' => 'field_faq_a', 'label' => 'Ответ', 'name' => 'a', 'type' => 'textarea' ),
						),
					),
					array(
						'key'   => 'field_svc_cta_h',
						'label' => 'CTA — заголовок',
						'name'  => 'cta_title',
						'type'  => 'text',
						'default_value' => 'Подскажем формат помощи',
					),
					array(
						'key'   => 'field_svc_cta_t',
						'label' => 'CTA — текст',
						'name'  => 'cta_text',
						'type'  => 'textarea',
						'rows'  => 2,
						'default_value' => 'Дежурный врач на связи 24/7.',
					),
					array(
						'key'          => 'field_svc_city_ov',
						'label'        => 'Оверрайды по городу',
						'name'         => 'city_overrides',
						'type'         => 'repeater',
						'layout'       => 'row',
						'button_label' => 'Город',
						'sub_fields'   => array(
							array( 'key' => 'field_ov_slug', 'label' => 'City slug', 'name' => 'city_slug', 'type' => 'text' ),
							array( 'key' => 'field_ov_price', 'label' => 'Цена', 'name' => 'ov_price_label', 'type' => 'text' ),
							array( 'key' => 'field_ov_lead', 'label' => 'Лид', 'name' => 'ov_lead', 'type' => 'textarea' ),
							array( 'key' => 'field_ov_note', 'label' => 'Заметка', 'name' => 'ov_price_note', 'type' => 'text' ),
							array( 'key' => 'field_ov_hide', 'label' => 'Скрыть в городе', 'name' => 'ov_hide', 'type' => 'true_false', 'ui' => 1 ),
						),
					),
					array(
						'key'          => 'field_svc_schedule_h',
						'label'        => 'Расписание — заголовок',
						'name'         => 'schedule_heading',
						'type'         => 'text',
						'instructions' => 'Для программ со слотом по дням',
					),
					array(
						'key'   => 'field_svc_schedule_l',
						'label' => 'Расписание — лид',
						'name'  => 'schedule_lead',
						'type'  => 'textarea',
						'rows'  => 2,
					),
					array(
						'key'          => 'field_svc_schedule',
						'label'        => 'Расписание по дням',
						'name'         => 'schedule_days',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => 'День',
						'sub_fields'   => array(
							array( 'key' => 'fld_sch_title', 'label' => 'День (заголовок)', 'name' => 'title', 'type' => 'text' ),
							array(
								'key'          => 'fld_sch_morning',
								'label'        => 'Утро',
								'name'         => 'morning',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Пункт',
								'sub_fields'   => array(
									array( 'key' => 'fld_sch_mt', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
								),
							),
							array(
								'key'          => 'fld_sch_day',
								'label'        => 'День',
								'name'         => 'day',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Пункт',
								'sub_fields'   => array(
									array( 'key' => 'fld_sch_dt', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
								),
							),
							array(
								'key'          => 'fld_sch_evening',
								'label'        => 'Вечер',
								'name'         => 'evening',
								'type'         => 'repeater',
								'layout'       => 'table',
								'button_label' => 'Пункт',
								'sub_fields'   => array(
									array( 'key' => 'fld_sch_et', 'label' => 'Текст', 'name' => 'text', 'type' => 'text' ),
								),
							),
						),
					),
					array(
						'key'   => 'field_svc_schedule_note',
						'label' => 'Расписание — сноска',
						'name'  => 'schedule_note',
						'type'  => 'textarea',
						'rows'  => 2,
					),
				),
				'location'              => array(
					array(
						array( 'param' => 'post_type', 'operator' => '==', 'value' => 'service' ),
					),
					array(
						array( 'param' => 'post_type', 'operator' => '==', 'value' => 'program' ),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'active'                => true,
			)
		);
	},
	30
);

add_action(
	'admin_init',
	static function () {
		remove_post_type_support( 'service', 'editor' );
		remove_post_type_support( 'program', 'editor' );
	}
);

/**
 * Permalink for a service/program slug or legacy filename stem.
 *
 * @param string $slug Slug, service-foo, or absolute URL.
 * @return string
 */
function alba_service_permalink( $slug ) {
	$slug = trim( (string) $slug );
	if ( ! $slug ) {
		return '#';
	}
	if ( preg_match( '#^https?://#i', $slug ) ) {
		return $slug;
	}
	$stem = preg_replace( '/\.(html?)$/i', '', $slug );
	$stem = preg_replace( '/^(service|program)-/', '', $stem );
	$post = get_page_by_path( $stem, OBJECT, array( 'service', 'program' ) );
	if ( $post ) {
		return get_permalink( $post );
	}
	$city = alba_get_current_city();
	// Heuristic: zapoy-* courses live as program CPT.
	$bucket = preg_match( '/^zapoy-/i', $stem ) ? 'program' : 'service';
	return home_url( '/' . $city['slug'] . '/' . $bucket . '/' . $stem . '/' );
}

/**
 * Whether service/program has ACF content (not legacy HTML).
 *
 * @param int $post_id ID.
 * @return bool
 */
function alba_service_uses_acf( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return false;
	}
	if ( get_field( 'hero_title', $post_id ) || get_field( 'lead', $post_id ) ) {
		return true;
	}
	$body = get_field( 'body_blocks', $post_id );
	$inc  = get_field( 'includes', $post_id );
	return ( is_array( $body ) && $body ) || ( is_array( $inc ) && $inc );
}

/**
 * Render single service/program from ACF only.
 *
 * @param int $post_id ID.
 */
function alba_render_service( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$city    = alba_get_current_city();

	$hide = alba_field( 'hide', $post_id, false );
	if ( $hide ) {
		echo '<section class="wrap"><p>Услуга временно недоступна в выбранном городе. <a href="' . esc_url( alba_city_url( 'programs' ) ) . '">Каталог</a></p></section>';
		return;
	}

	$hero     = (string) ( get_field( 'hero_title', $post_id ) ?: get_the_title( $post_id ) );
	$lead     = (string) ( get_field( 'lead', $post_id ) ?: '' );
	$price    = (string) alba_field( 'price_label', $post_id, '' );
	$note     = (string) alba_field( 'price_note', $post_id, 'Имеются противопоказания. Нужна консультация врача.' );
	$includes = get_field( 'includes', $post_id );
	$intro    = get_field( 'intro', $post_id );
	$faq      = get_field( 'faq', $post_id );
	$body     = get_field( 'body_blocks', $post_id );
	$benefits = get_field( 'benefits', $post_id );
	$related  = get_field( 'related_programs', $post_id );
	$rel_h    = (string) get_field( 'related_heading', $post_id );
	$rel_l    = (string) get_field( 'related_lead', $post_id );
	$funnel_h = (string) get_field( 'funnel_title', $post_id );
	$funnel_t = (string) get_field( 'funnel_text', $post_id );
	$funnel_c = get_field( 'funnel_chips', $post_id );
	$cta_h    = (string) ( get_field( 'cta_title', $post_id ) ?: 'Подскажем формат помощи' );
	$cta_t    = (string) ( get_field( 'cta_text', $post_id ) ?: 'Дежурный врач на связи 24/7.' );
	$sch_h    = (string) get_field( 'schedule_heading', $post_id );
	$sch_l    = (string) get_field( 'schedule_lead', $post_id );
	$sch_note = (string) get_field( 'schedule_note', $post_id );
	$schedule = get_field( 'schedule_days', $post_id );
	$cover    = (string) get_field( 'cover_url', $post_id );

	$sticky_tip_h   = (string) ( get_field( 'sticky_tip_title', $post_id ) ?: 'Близкий отказывается от помощи?' );
	$sticky_tip_t   = (string) ( get_field( 'sticky_tip_text', $post_id ) ?: 'Не уговаривайте через силу. Дежурный подскажет, как начать разговор и когда вызывать врача на дом.' );
	$sticky_tip_btn = (string) ( get_field( 'sticky_tip_button', $post_id ) ?: 'Получить совет' );
	$sticky_form_h  = (string) ( get_field( 'sticky_form_title', $post_id ) ?: 'Перезвоним за 2 минуты' );
	$sticky_rel_h   = (string) ( get_field( 'sticky_links_heading', $post_id ) ?: 'Рядом по маршруту' );
	$sticky_links   = get_field( 'sticky_links', $post_id );
	if ( ! is_array( $sticky_links ) ) {
		$sticky_links = array();
	}
	if ( ! $cover && has_post_thumbnail( $post_id ) ) {
		$cover = get_the_post_thumbnail_url( $post_id, 'large' );
	}
	if ( ! $cover ) {
		$cover = home_url( '/images/clinic-room.jpg' );
	} else {
		$cover = function_exists( 'alba_media_url' ) ? alba_media_url( $cover ) : $cover;
	}

	$doc_name  = (string) get_field( 'help_doctor_name', $post_id );
	$doc_role  = (string) get_field( 'help_doctor_role', $post_id );
	$doc_photo = (string) get_field( 'help_doctor_photo', $post_id );
	if ( $doc_photo && function_exists( 'alba_media_url' ) ) {
		$doc_photo = alba_media_url( $doc_photo );
	}

	?>
	<section class="page-hero wrap">
		<div class="page-hero__box">
			<div>
				<div class="crumb"><a href="<?php echo esc_url( alba_city_url() ); ?>">Главная</a> / <a href="<?php echo esc_url( alba_city_url( 'programs' ) ); ?>">Программы</a> / <?php echo esc_html( get_the_title( $post_id ) ); ?></div>
				<h1 class="split"><?php echo function_exists( 'alba_title_br' ) ? alba_title_br( $hero ) : esc_html( $hero ); // phpcs:ignore ?></h1>
			</div>
			<?php if ( $lead ) : ?><p><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		</div>
	</section>

	<section class="svc wrap">
		<div data-reveal>
			<img class="article-cover" src="<?php echo esc_url( $cover ); ?>" alt="" loading="lazy">
			<?php
			if ( is_array( $intro ) ) {
				foreach ( $intro as $row ) {
					$t = trim( (string) ( $row['text'] ?? '' ) );
					if ( $t ) {
						echo '<p>' . esc_html( $t ) . '</p>';
					}
				}
			}
			?>
			<?php if ( $doc_name ) : ?>
			<div class="svc-help" data-svc-help>
				<p class="svc-help__title">Вам поможет</p>
				<div class="svc-help__card">
					<?php if ( $doc_photo ) : ?>
						<img class="svc-help__photo" src="<?php echo esc_url( $doc_photo ); ?>" alt="<?php echo esc_attr( $doc_name ); ?>" width="144" height="144" loading="lazy" decoding="async">
					<?php endif; ?>
					<div>
						<p class="svc-help__name"><?php echo esc_html( $doc_name ); ?></p>
						<?php if ( $doc_role ) : ?><p class="svc-help__role"><?php echo esc_html( $doc_role ); ?></p><?php endif; ?>
					</div>
				</div>
				<a class="btn btn--blue" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
			</div>
			<?php endif; ?>
			<?php if ( is_array( $includes ) && $includes ) : ?>
			<h2>Что входит</h2>
			<ul>
				<?php foreach ( $includes as $row ) : ?>
					<li><?php echo esc_html( is_array( $row ) ? ( $row['item'] ?? '' ) : $row ); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
		<aside class="svc-side" data-reveal>
			<span>Стоимость</span>
			<b><?php echo esc_html( $price ?: 'по запросу' ); ?></b>
			<em><?php echo esc_html( $note ); ?></em>
			<a class="btn btn--dark" href="#" data-open-modal>Записаться <?php echo alba_arr(); // phpcs:ignore ?></a>
			<a class="btn btn--line" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel data-no-arr>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ); ?></span></a>
			<p>18+. Добровольно. Имеются противопоказания.</p>
		</aside>
	</section>

	<?php if ( is_array( $schedule ) && $schedule ) : ?>
	<section class="prog-schedule wrap" data-reveal>
		<div class="prog-schedule__head">
			<?php if ( $sch_h ) : ?><h2 class="section-title"><?php echo alba_title_br( $sch_h ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $sch_l ) : ?><p><?php echo esc_html( $sch_l ); ?></p><?php endif; ?>
		</div>
		<div class="prog-schedule__list">
			<?php foreach ( $schedule as $day ) : ?>
				<article class="prog-day">
					<h3><?php echo esc_html( $day['title'] ?? '' ); ?></h3>
					<div class="prog-day__cols">
						<?php
						$cols = array(
							'Утро'  => $day['morning'] ?? array(),
							'День'  => $day['day'] ?? array(),
							'Вечер' => $day['evening'] ?? array(),
						);
						foreach ( $cols as $label => $items ) :
							if ( ! is_array( $items ) || ! $items ) {
								continue;
							}
							?>
							<div>
								<h4><?php echo esc_html( $label ); ?></h4>
								<ul>
									<?php foreach ( $items as $it ) : ?>
										<li><?php echo esc_html( is_array( $it ) ? ( $it['text'] ?? '' ) : $it ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endforeach; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php if ( $sch_note ) : ?><p class="prog-schedule__note"><?php echo esc_html( $sch_note ); ?></p><?php endif; ?>
	</section>
	<?php endif; ?>

	<?php if ( is_array( $related ) && $related ) : ?>
	<section class="alko-progs wrap" data-reveal>
		<div class="alko-progs__head">
			<?php if ( $rel_h ) : ?><h2 class="section-title"><?php echo alba_title_br( $rel_h ); // phpcs:ignore ?></h2><?php endif; ?>
			<?php if ( $rel_l ) : ?><p><?php echo esc_html( $rel_l ); ?></p><?php endif; ?>
		</div>
		<div class="alko-progs__grid">
			<?php foreach ( $related as $card ) :
				$href = alba_service_permalink( $card['url'] ?? '' );
				$feat = ! empty( $card['featured'] ) ? ' alko-prog--feat' : '';
				?>
				<a class="alko-prog<?php echo esc_attr( $feat ); ?>" href="<?php echo esc_url( $href ); ?>">
					<?php if ( ! empty( $card['badge'] ) ) : ?><em><?php echo esc_html( $card['badge'] ); ?></em><?php endif; ?>
					<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
					<?php if ( ! empty( $card['text'] ) ) : ?><p><?php echo esc_html( $card['text'] ); ?></p><?php endif; ?>
					<?php if ( ! empty( $card['price'] ) ) : ?><b><?php echo esc_html( $card['price'] ); ?></b><?php endif; ?>
					<span class="more">Подробнее</span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( $funnel_h || $funnel_t ) : ?>
	<section class="page-funnel page-funnel--form wrap svc-rich-lead" data-reveal>
		<div class="page-funnel__box page-funnel__box--form form">
			<div class="page-funnel__copy">
				<?php if ( $funnel_h ) : ?><h2><?php echo esc_html( $funnel_h ); ?></h2><?php endif; ?>
				<?php if ( $funnel_t ) : ?><p><?php echo esc_html( $funnel_t ); ?></p><?php endif; ?>
				<?php if ( is_array( $funnel_c ) && $funnel_c ) : ?>
					<ul class="page-funnel__chips">
						<?php foreach ( $funnel_c as $c ) : ?><li><?php echo esc_html( $c['text'] ?? '' ); ?></li><?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<form data-form data-alba-lead class="page-funnel__form">
				<div class="form__fields page-funnel__fields page-funnel__fields--namephone">
					<label class="visually-hidden" for="svc-n-<?php echo (int) $post_id; ?>">Имя</label>
					<input id="svc-n-<?php echo (int) $post_id; ?>" name="name" type="text" placeholder="Имя или псевдоним" autocomplete="name">
					<label class="visually-hidden" for="svc-p-<?php echo (int) $post_id; ?>">Телефон</label>
					<input id="svc-p-<?php echo (int) $post_id; ?>" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
					<button class="btn btn--blue" type="submit">Жду звонка <?php echo alba_arr(); // phpcs:ignore ?></button>
				</div>
				<p class="page-funnel__legal">Нажимая кнопку, вы соглашаетесь с <a href="<?php echo esc_url( alba_city_url( 'consent' ) ); ?>">обработкой ПДн</a>.</p>
				<div class="form__ok"><strong>Заявка принята.</strong> Дежурный врач перезвонит с номера клиники.</div>
			</form>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( is_array( $benefits ) && $benefits ) : ?>
	<section class="svc-benefits-row wrap" data-reveal>
		<div class="svc-benefits">
			<?php foreach ( $benefits as $b ) : ?>
				<article>
					<h3><?php echo esc_html( $b['title'] ?? '' ); ?></h3>
					<p><?php echo esc_html( $b['text'] ?? '' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<?php if ( is_array( $body ) && $body ) : ?>
	<section class="svc-layout wrap">
		<div class="svc-article" data-reveal>
			<?php foreach ( $body as $block ) : ?>
				<?php alba_render_service_body_block( $block ); ?>
			<?php endforeach; ?>
		</div>
		<aside class="svc-sticky">
			<?php if ( $sticky_tip_h || $sticky_tip_t ) : ?>
			<div class="svc-sticky__card">
				<?php if ( $sticky_tip_h ) : ?><h3><?php echo esc_html( $sticky_tip_h ); ?></h3><?php endif; ?>
				<?php if ( $sticky_tip_t ) : ?><p><?php echo esc_html( $sticky_tip_t ); ?></p><?php endif; ?>
				<a class="btn btn--blue" href="#" data-open-modal><?php echo esc_html( $sticky_tip_btn ); ?> <?php echo alba_arr(); // phpcs:ignore ?></a>
			</div>
			<?php endif; ?>
			<div class="svc-sticky__card svc-sticky__card--form form">
				<h3><?php echo esc_html( $sticky_form_h ); ?></h3>
				<form data-form data-alba-lead>
					<div class="form__fields svc-sticky__fields">
						<label class="visually-hidden" for="svc-sticky-p-<?php echo (int) $post_id; ?>">Телефон</label>
						<input id="svc-sticky-p-<?php echo (int) $post_id; ?>" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">
						<button class="btn btn--blue" type="submit">Перезвоните мне</button>
					</div>
					<div class="form__ok"><strong>Принято.</strong> Ждите звонка.</div>
				</form>
			</div>
			<?php if ( $sticky_links ) : ?>
			<div class="svc-sticky__card">
				<h3><?php echo esc_html( $sticky_rel_h ); ?></h3>
				<div class="svc-related">
					<?php foreach ( $sticky_links as $link ) :
						$href = function_exists( 'alba_service_permalink' ) ? alba_service_permalink( $link['url'] ?? '' ) : '#';
						?>
						<a class="svc-related__item" href="<?php echo esc_url( $href ); ?>">
							<span><?php echo esc_html( $link['title'] ?? '' ); ?></span>
							<?php if ( ! empty( $link['price'] ) ) : ?><b><?php echo esc_html( $link['price'] ); ?></b><?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</aside>
	</section>
	<?php endif; ?>

	<?php if ( is_array( $faq ) && $faq ) : ?>
	<section class="faq wrap" data-page-faq>
		<div data-reveal>
			<h2 class="section-title">Часто задаваемые<br>вопросы</h2>
		</div>
		<div class="acc" data-acc data-reveal>
			<?php foreach ( $faq as $i => $item ) : ?>
			<article class="acc__item<?php echo 0 === $i ? ' is-open' : ''; ?>">
				<button class="acc__btn" type="button"><?php echo esc_html( $item['q'] ?? '' ); ?><i>+</i></button>
				<div class="acc__panel"><div><p><?php echo esc_html( $item['a'] ?? '' ); ?></p></div></div>
			</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>

	<section class="cta wrap">
		<div class="cta__box" data-reveal="scale">
			<div>
				<?php if ( $cta_h ) : ?><h2><?php echo esc_html( $cta_h ); ?></h2><?php endif; ?>
				<?php if ( $cta_t ) : ?><p><?php echo esc_html( $cta_t ); ?></p><?php endif; ?>
			</div>
			<div class="cta__actions">
				<a class="btn btn--light" href="#" data-open-modal>Оставить заявку <?php echo alba_arr(); // phpcs:ignore ?></a>
				<a class="btn btn--ghost-light" href="tel:<?php echo esc_attr( $city['tel'] ); ?>" data-city-tel data-no-arr>Позвонить: <span data-city-phone><?php echo esc_html( $city['phone'] ); ?></span></a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Render one body_blocks layout.
 *
 * @param array $block Block.
 */
function alba_render_service_body_block( $block ) {
	$layout = $block['acf_fc_layout'] ?? '';
	switch ( $layout ) {
		case 'heading':
			$lvl = ( 'h3' === ( $block['level'] ?? '' ) ) ? 'h3' : 'h2';
			$text = (string) ( $block['text'] ?? '' );
			if ( $text ) {
				echo '<' . $lvl . '>' . esc_html( $text ) . '</' . $lvl . '>';
			}
			break;
		case 'paragraphs':
			$items = is_array( $block['items'] ?? null ) ? $block['items'] : array();
			foreach ( $items as $row ) {
				$t = trim( (string) ( $row['text'] ?? '' ) );
				if ( $t ) {
					echo '<p>' . esc_html( $t ) . '</p>';
				}
			}
			break;
		case 'list':
			$items = is_array( $block['items'] ?? null ) ? $block['items'] : array();
			if ( $items ) {
				echo '<ul>';
				foreach ( $items as $row ) {
					$t = trim( (string) ( $row['text'] ?? '' ) );
					if ( $t ) {
						echo '<li>' . esc_html( $t ) . '</li>';
					}
				}
				echo '</ul>';
			}
			break;
		case 'figure':
			$url = function_exists( 'alba_media_url' ) ? alba_media_url( $block['image_url'] ?? '' ) : ( $block['image_url'] ?? '' );
			if ( ! $url ) {
				break;
			}
			echo '<figure class="svc-figure">';
			echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $block['alt'] ?? '' ) . '" loading="lazy" width="800" height="520">';
			if ( ! empty( $block['caption'] ) ) {
				echo '<figcaption>' . esc_html( $block['caption'] ) . '</figcaption>';
			}
			echo '</figure>';
			break;
	}
}

/**
 * Human title for admin list from parsed ACF data / H1.
 *
 * @param array $data Parsed service data.
 * @return string
 */
function alba_service_admin_title( $data ) {
	// Prefer dedicated admin_title if set by parser.
	$t = trim( (string) ( $data['admin_title'] ?? '' ) );
	if ( $t ) {
		return $t;
	}
	$hero = trim( (string) ( $data['hero_title'] ?? '' ) );
	if ( $hero ) {
		return trim( preg_replace( '/\s+/u', ' ', str_replace( '|', ' ', $hero ) ) );
	}
	return '';
}

/**
 * Update ACF field by key (avoids name collisions with nested fields).
 *
 * @param string $key   Field key like field_svc_lead.
 * @param mixed  $value Value.
 * @param int    $post_id Post ID.
 */
function alba_update_field_key( $key, $value, $post_id ) {
	if ( function_exists( 'update_field' ) ) {
		update_field( $key, $value, $post_id );
	}
}

/**
 * Seed all services/programs from legacy-html into ACF (no HTML left in post_content).
 *
 * @param bool $force Overwrite.
 * @return array Stats.
 */
function alba_seed_services_acf( $force = false ) {
	if ( ! function_exists( 'update_field' ) ) {
		return array( 'error' => 'ACF missing' );
	}

	$dir   = trailingslashit( ABSPATH ) . 'legacy-html';
	$stats = array( 'updated' => 0, 'skipped' => 0, 'programs' => 0, 'services' => 0 );

	$files = array_merge(
		glob( $dir . '/service-*.html' ) ?: array(),
		glob( $dir . '/program-*.html' ) ?: array()
	);

	$map = array(
		'hero_title'         => 'field_svc_hero',
		'lead'               => 'field_svc_lead',
		'cover_url'          => 'field_svc_cover_url',
		'intro'              => 'field_svc_intro',
		'price'              => 'field_svc_price',
		'price_note'         => 'field_svc_price_note',
		'includes'           => 'field_svc_includes',
		'help_doctor_name'   => 'field_svc_doctor_name',
		'help_doctor_role'   => 'field_svc_doctor_role',
		'help_doctor_photo'  => 'field_svc_doctor_photo',
		'related_heading'    => 'field_svc_rel_h',
		'related_lead'       => 'field_svc_rel_l',
		'related'            => 'field_svc_related',
		'funnel_title'       => 'field_svc_funnel_h',
		'funnel_text'        => 'field_svc_funnel_t',
		'funnel_chips'       => 'field_svc_funnel_c',
		'benefits'           => 'field_svc_benefits',
		'body_blocks'        => 'field_svc_body',
		'faq'                => 'field_svc_faq',
		'cta_title'          => 'field_svc_cta_h',
		'cta_text'           => 'field_svc_cta_t',
		'schedule_heading'   => 'field_svc_schedule_h',
		'schedule_lead'      => 'field_svc_schedule_l',
		'schedule_days'      => 'field_svc_schedule',
		'schedule_note'      => 'field_svc_schedule_note',
		'sticky_tip_title'   => 'field_svc_sticky_tip_h',
		'sticky_tip_text'    => 'field_svc_sticky_tip_t',
		'sticky_tip_button'  => 'field_svc_sticky_tip_btn',
		'sticky_form_title'  => 'field_svc_sticky_form_h',
		'sticky_links_heading' => 'field_svc_sticky_rel_h',
		'sticky_links'       => 'field_svc_sticky_links',
	);

	foreach ( $files as $path ) {
		$file = basename( $path );
		$slug = preg_replace( '/^(service|program)-/', '', basename( $file, '.html' ) );
		$is_program = (bool) preg_match( '/zapoy-\d|program/i', $file );
		$type = $is_program ? 'program' : 'service';

		$post = get_page_by_path( $slug, OBJECT, array( 'service', 'program' ) );
		if ( ! $post ) {
			$stats['skipped']++;
			continue;
		}
		$id = (int) $post->ID;

		if ( ! $force ) {
			$has = get_field( 'hero_title', $id ) && ( get_field( 'body_blocks', $id ) || get_field( 'schedule_days', $id ) || get_field( 'includes', $id ) );
			if ( $has && 'field_svc_lead' === get_post_meta( $id, '_lead', true ) ) {
				$stats['skipped']++;
				continue;
			}
		}

		$html = (string) file_get_contents( $path );
		$data = alba_parse_service_to_acf( $html );

		wp_update_post(
			array(
				'ID'           => $id,
				'post_content' => '',
				'post_excerpt' => $data['excerpt'] ?: get_post_field( 'post_excerpt', $id ),
				'post_title'   => alba_service_admin_title( $data ),
			)
		);
		delete_post_meta( $id, '_alba_legacy_file' );

		// Fix broken field references from name collisions.
		foreach ( array( 'lead', 'price_label', 'price_note', 'hide' ) as $broken ) {
			$ref = get_post_meta( $id, '_' . $broken, true );
			if ( is_string( $ref ) && 0 === strpos( $ref, 'field_ov_' ) ) {
				delete_post_meta( $id, '_' . $broken );
			}
		}

		alba_update_field_key( $map['hero_title'], $data['hero_title'], $id );
		alba_update_field_key( $map['lead'], $data['lead'], $id );
		alba_update_field_key( $map['cover_url'], $data['cover_url'], $id );
		alba_update_field_key( $map['intro'], $data['intro'], $id );
		alba_update_field_key( $map['price'], $data['price'], $id );
		alba_update_field_key( $map['price_note'], $data['price_note'], $id );
		alba_update_field_key( $map['includes'], $data['includes'], $id );
		alba_update_field_key( $map['help_doctor_name'], $data['help_doctor_name'], $id );
		alba_update_field_key( $map['help_doctor_role'], $data['help_doctor_role'], $id );
		alba_update_field_key( $map['help_doctor_photo'], $data['help_doctor_photo'], $id );
		alba_update_field_key( $map['related_heading'], $data['related_heading'], $id );
		alba_update_field_key( $map['related_lead'], $data['related_lead'], $id );
		alba_update_field_key( $map['related'], $data['related'], $id );
		alba_update_field_key( $map['funnel_title'], $data['funnel_title'], $id );
		alba_update_field_key( $map['funnel_text'], $data['funnel_text'], $id );
		alba_update_field_key( $map['funnel_chips'], $data['funnel_chips'], $id );
		alba_update_field_key( $map['benefits'], $data['benefits'], $id );
		alba_update_field_key( $map['body_blocks'], $data['body_blocks'], $id );
		alba_update_field_key( $map['faq'], $data['faq'], $id );
		alba_update_field_key( $map['cta_title'], $data['cta_title'], $id );
		alba_update_field_key( $map['cta_text'], $data['cta_text'], $id );
		alba_update_field_key( $map['schedule_heading'], $data['schedule_heading'], $id );
		alba_update_field_key( $map['schedule_lead'], $data['schedule_lead'], $id );
		alba_update_field_key( $map['schedule_days'], $data['schedule_days'], $id );
		alba_update_field_key( $map['schedule_note'], $data['schedule_note'], $id );
		alba_update_field_key( $map['sticky_tip_title'], $data['sticky_tip_title'], $id );
		alba_update_field_key( $map['sticky_tip_text'], $data['sticky_tip_text'], $id );
		alba_update_field_key( $map['sticky_tip_button'], $data['sticky_tip_button'], $id );
		alba_update_field_key( $map['sticky_form_title'], $data['sticky_form_title'], $id );
		alba_update_field_key( $map['sticky_links_heading'], $data['sticky_links_heading'], $id );
		alba_update_field_key( $map['sticky_links'], $data['sticky_links'], $id );

		$seo_title = trim( str_replace( '|', ' ', (string) $data['hero_title'] ) );
		if ( $seo_title ) {
			$seo_title .= ' — клиника Альба';
		} else {
			$seo_title = get_the_title( $id ) . ' — клиника Альба';
		}
		$seo_desc = (string) ( $data['lead'] ?: $data['excerpt'] );
		if ( ! $seo_desc ) {
			$seo_desc = 'Анонимная наркологическая помощь в клинике Альба. 18+, добровольно, дежурный врач 24/7.';
		}
		update_field( 'seo_title', $seo_title, $id );
		update_field( 'seo_description', mb_substr( $seo_desc, 0, 180 ), $id );
		update_field( 'seo_image', $data['cover_url'] ?: 'images/clinic-room.jpg', $id );

		$stats['updated']++;
		$stats[ 'program' === $post->post_type ? 'programs' : 'services' ]++;
	}

	return $stats;
}

/**
 * Parse service/program legacy HTML into structured ACF values.
 *
 * @param string $html Full HTML file.
 * @return array
 */
function alba_parse_service_to_acf( $html ) {
	$out = array(
		'excerpt'            => '',
		'admin_title'        => '',
		'hero_title'         => '',
		'lead'               => '',
		'cover_url'          => '',
		'intro'              => array(),
		'price'              => '',
		'price_note'         => '',
		'includes'           => array(),
		'help_doctor_name'   => '',
		'help_doctor_role'   => '',
		'help_doctor_photo'  => '',
		'related_heading'    => '',
		'related_lead'       => '',
		'related'            => array(),
		'funnel_title'       => '',
		'funnel_text'        => '',
		'funnel_chips'       => array(),
		'benefits'           => array(),
		'body_blocks'        => array(),
		'faq'                => array(),
		'cta_title'          => 'Подскажем формат помощи',
		'cta_text'           => 'Дежурный врач на связи 24/7.',
		'schedule_heading'   => '',
		'schedule_lead'      => '',
		'schedule_days'      => array(),
		'schedule_note'      => '',
		'sticky_tip_title'   => 'Близкий отказывается от помощи?',
		'sticky_tip_text'    => 'Не уговаривайте через силу. Дежурный подскажет, как начать разговор и когда вызывать врача на дом.',
		'sticky_tip_button'  => 'Получить совет',
		'sticky_form_title'  => 'Перезвоним за 2 минуты',
		'sticky_links_heading' => 'Рядом по маршруту',
		'sticky_links'       => array(),
	);

	if ( preg_match( '/<title>(.*?)<\/title>/is', $html, $m ) ) {
		$t = trim( html_entity_decode( wp_strip_all_tags( $m[1] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
		$t = preg_replace( '/\s*[—\-|]\s*Альба\s*$/u', '', $t );
		$out['admin_title'] = trim( $t );
	}

	if ( preg_match( '/name="description"\s+content="([^"]*)"/i', $html, $m ) ) {
		$out['excerpt'] = html_entity_decode( $m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	}

	if ( preg_match( '/<h1[^>]*>([\s\S]*?)<\/h1>/i', $html, $m ) ) {
		$t = preg_replace( '/<br\s*\/?>/i', '|', $m[1] );
		$t = html_entity_decode( wp_strip_all_tags( $t ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
		$out['hero_title'] = trim( preg_replace( '/\s+/u', ' ', $t ) );
	}

	if ( preg_match( '/page-hero__box[\s\S]*?<p>([\s\S]*?)<\/p>/i', $html, $m ) ) {
		$out['lead'] = trim( wp_strip_all_tags( $m[1] ) );
	}

	if ( preg_match( '/class="article-cover"[^>]+src=["\']([^"\']+)["\']/i', $html, $m ) ) {
		$out['cover_url'] = $m[1];
	}

	// Intro paragraphs inside .svc before svc-help / Что входит.
	if ( preg_match( '/<section class="svc wrap">([\s\S]*?)<aside class="svc-side"/i', $html, $m ) ) {
		$col = $m[1];
		$col = preg_replace( '/<div class="svc-help"[\s\S]*?<\/div>\s*(?=<h2|<\/div>)/i', '', $col );
		$col = preg_replace( '/<h2>\s*Что входит\s*<\/h2>[\s\S]*$/i', '', $col );
		$col = preg_replace( '/<img[^>]*>/i', '', $col );
		if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $col, $pm ) ) {
			foreach ( $pm[1] as $p ) {
				$t = trim( wp_strip_all_tags( $p ) );
				if ( $t && false === stripos( $t, 'Вам поможет' ) ) {
					$out['intro'][] = array( 'text' => $t );
				}
			}
		}
	}

	if ( preg_match( '/<aside class="svc-side"[\s\S]*?<b>([\s\S]*?)<\/b>/i', $html, $m ) ) {
		$out['price'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/<aside class="svc-side"[\s\S]*?<em>([\s\S]*?)<\/em>/i', $html, $m ) ) {
		$out['price_note'] = trim( wp_strip_all_tags( $m[1] ) );
	}

	if ( preg_match( '/<h2>\s*Что входит\s*<\/h2>\s*<ul>([\s\S]*?)<\/ul>/i', $html, $m ) ) {
		if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $m[1], $lis ) ) {
			foreach ( $lis[1] as $li ) {
				$out['includes'][] = array( 'item' => trim( wp_strip_all_tags( $li ) ) );
			}
		}
	}

	if ( preg_match( '/svc-help__name[^>]*>([\s\S]*?)<\//i', $html, $m ) ) {
		$out['help_doctor_name'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/svc-help__role[^>]*>([\s\S]*?)<\//i', $html, $m ) ) {
		$out['help_doctor_role'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/svc-help__photo[^>]+src=["\']([^"\']+)["\']/i', $html, $m ) ) {
		$out['help_doctor_photo'] = $m[1];
	}

	if ( preg_match( '/<section class="alko-progs[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $html, $m ) ) {
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$out['related_heading'] = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/alko-progs__head[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$out['related_lead'] = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match_all( '/<a class="alko-prog([^"]*)"[^>]*href=["\']([^"\']+)["\'][^>]*>([\s\S]*?)<\/a>/i', $m[1], $cards, PREG_SET_ORDER ) ) {
			foreach ( $cards as $c ) {
				$inner = $c[3];
				$badge = '';
				$title = '';
				$text  = '';
				$price = '';
				if ( preg_match( '/<em>([\s\S]*?)<\/em>/i', $inner, $em ) ) {
					$badge = trim( wp_strip_all_tags( $em[1] ) );
				}
				if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $h3 ) ) {
					$title = trim( wp_strip_all_tags( $h3[1] ) );
				}
				if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $inner, $p ) ) {
					$text = trim( wp_strip_all_tags( $p[1] ) );
				}
				if ( preg_match( '/<b>([\s\S]*?)<\/b>/i', $inner, $b ) ) {
					$price = trim( wp_strip_all_tags( $b[1] ) );
				}
				$url = $c[2];
				if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
					$url = $um[1];
				}
				$out['related'][] = array(
					'badge'    => $badge,
					'title'    => $title,
					'text'     => $text,
					'price'    => $price,
					'url'      => $url,
					'featured' => ( false !== strpos( $c[1], 'feat' ) ) ? 1 : 0,
				);
			}
		}
	}

	// Compact related links (program pages).
	if ( ! $out['related'] && preg_match_all( '/<a class="svc-related__item"[^>]*href=["\']([^"\']+)["\'][^>]*>\s*<span>([\s\S]*?)<\/span>\s*<b>([\s\S]*?)<\/b>/i', $html, $rm, PREG_SET_ORDER ) ) {
		foreach ( $rm as $r ) {
			$url = $r[1];
			if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
				$url = $um[1];
			}
			$out['related'][] = array(
				'badge'    => '',
				'title'    => trim( wp_strip_all_tags( $r[2] ) ),
				'text'     => '',
				'price'    => trim( wp_strip_all_tags( $r[3] ) ),
				'url'      => $url,
				'featured' => 0,
			);
		}
		if ( $out['related'] && ! $out['related_heading'] ) {
			$out['related_heading'] = 'Другие курсы';
		}
	}

	// Sticky sidebar (svc-layout right column).
	if ( preg_match( '/<aside[^>]*class="[^"]*svc-sticky[^"]*"[^>]*>([\s\S]*?)<\/aside>/i', $html, $sm ) ) {
		$sticky = $sm[1];
		if ( preg_match( '/svc-sticky__card(?![^>]*form)[^>]*>\s*<h3>([\s\S]*?)<\/h3>\s*<p>([\s\S]*?)<\/p>/i', $sticky, $tm ) ) {
			$out['sticky_tip_title'] = trim( wp_strip_all_tags( $tm[1] ) );
			$out['sticky_tip_text']  = trim( wp_strip_all_tags( $tm[2] ) );
		}
		if ( preg_match( '/svc-sticky__card[^>]*>[\s\S]*?<a[^>]*data-open-modal[^>]*>([\s\S]*?)<\/a>/i', $sticky, $bm ) ) {
			$out['sticky_tip_button'] = trim( wp_strip_all_tags( $bm[1] ) );
		}
		if ( preg_match( '/svc-sticky__card--form[\s\S]*?<h3>([\s\S]*?)<\/h3>/i', $sticky, $fm ) ) {
			$out['sticky_form_title'] = trim( wp_strip_all_tags( $fm[1] ) );
		}
		if ( preg_match( '/svc-related[\s\S]*?<\/div>/i', $sticky, $rmatch ) ) {
			if ( preg_match( '/<h3>([\s\S]*?)<\/h3>\s*<div class="svc-related"/i', $sticky, $rh ) ) {
				$out['sticky_links_heading'] = trim( wp_strip_all_tags( $rh[1] ) );
			}
			if ( preg_match_all( '/<a class="svc-related__item"[^>]*href=["\']([^"\']+)["\'][^>]*>\s*<span>([\s\S]*?)<\/span>\s*<b>([\s\S]*?)<\/b>/i', $sticky, $rl, PREG_SET_ORDER ) ) {
				foreach ( $rl as $r ) {
					$url = $r[1];
					if ( preg_match( '/([a-z0-9\-]+)\.html/i', $url, $um ) ) {
						$url = $um[1];
					}
					$out['sticky_links'][] = array(
						'title' => trim( wp_strip_all_tags( $r[2] ) ),
						'price' => trim( wp_strip_all_tags( $r[3] ) ),
						'url'   => $url,
					);
				}
			}
		}
	}

	// Program day schedule.
	if ( preg_match( '/<section class="prog-schedule[^"]*"[^>]*>([\s\S]*?)<\/section>/i', $html, $m ) ) {
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $hm ) ) {
			$out['schedule_heading'] = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( preg_replace( '/<br\s*\/?>/i', '|', $hm[1] ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		}
		if ( preg_match( '/prog-schedule__head[\s\S]*?<p>([\s\S]*?)<\/p>/i', $m[1], $pm ) ) {
			$out['schedule_lead'] = trim( wp_strip_all_tags( $pm[1] ) );
		}
		if ( preg_match( '/prog-schedule__note[^>]*>([\s\S]*?)<\//i', $m[1], $nm ) ) {
			$out['schedule_note'] = trim( wp_strip_all_tags( $nm[1] ) );
		}
		if ( preg_match_all( '/<article class="prog-day">([\s\S]*?)<\/article>/i', $m[1], $days, PREG_SET_ORDER ) ) {
			foreach ( $days as $day ) {
				$inner = $day[1];
				$title = '';
				if ( preg_match( '/<h3>([\s\S]*?)<\/h3>/i', $inner, $ht ) ) {
					$title = trim( wp_strip_all_tags( $ht[1] ) );
				}
				$row = array(
					'title'   => $title,
					'morning' => array(),
					'day'     => array(),
					'evening' => array(),
				);
				$map_h4 = array(
					'утро'  => 'morning',
					'день'  => 'day',
					'вечер' => 'evening',
				);
				if ( preg_match_all( '/<div>\s*<h4>([\s\S]*?)<\/h4>\s*<ul>([\s\S]*?)<\/ul>\s*<\/div>/i', $inner, $cols, PREG_SET_ORDER ) ) {
					foreach ( $cols as $col ) {
						$label = mb_strtolower( trim( wp_strip_all_tags( $col[1] ) ), 'UTF-8' );
						$key   = $map_h4[ $label ] ?? '';
						if ( ! $key ) {
							continue;
						}
						if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $col[2], $lis ) ) {
							foreach ( $lis[1] as $li ) {
								$t = trim( wp_strip_all_tags( $li ) );
								if ( $t ) {
									$row[ $key ][] = array( 'text' => $t );
								}
							}
						}
					}
				}
				$out['schedule_days'][] = $row;
			}
		}
	}

	if ( preg_match( '/page-funnel__copy[\s\S]*?<h2[^>]*>([\s\S]*?)<\/h2>/i', $html, $m ) ) {
		$out['funnel_title'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match( '/page-funnel__copy[\s\S]*?<p>([\s\S]*?)<\/p>/i', $html, $m ) ) {
		$out['funnel_text'] = trim( wp_strip_all_tags( $m[1] ) );
	}
	if ( preg_match_all( '/page-funnel__chips[\s\S]*?<li>([\s\S]*?)<\/li>/i', $html, $cm ) ) {
		foreach ( $cm[1] as $c ) {
			$out['funnel_chips'][] = array( 'text' => trim( wp_strip_all_tags( $c ) ) );
		}
	}

	if ( preg_match( '/<div class="svc-benefits">([\s\S]*?)<\/div>/i', $html, $m ) ) {
		if ( preg_match_all( '/<article>\s*<h3>([\s\S]*?)<\/h3>\s*<p>([\s\S]*?)<\/p>\s*<\/article>/i', $m[1], $bm, PREG_SET_ORDER ) ) {
			foreach ( $bm as $b ) {
				$out['benefits'][] = array(
					'title' => trim( wp_strip_all_tags( $b[1] ) ),
					'text'  => trim( wp_strip_all_tags( $b[2] ) ),
				);
			}
		}
	}

	$article = '';
	if ( preg_match( '/<div class="svc-article">([\s\S]*?)<\/div>\s*(?:<aside|<\/section)/i', $html, $m ) ) {
		$article = $m[1];
	}
	if ( $article ) {
		$out['body_blocks'] = alba_parse_article_to_blocks( $article );
	}

	if ( preg_match_all( '/<article class="acc__item[^"]*">\s*<button class="acc__btn"[^>]*>([\s\S]*?)<i>/i', $html, $qs ) ) {
		if ( preg_match_all( '/<div class="acc__panel"><div><p>([\s\S]*?)<\/p>/i', $html, $as ) ) {
			foreach ( $qs[1] as $i => $q ) {
				$out['faq'][] = array(
					'q' => trim( wp_strip_all_tags( $q ) ),
					'a' => isset( $as[1][ $i ] ) ? trim( wp_strip_all_tags( $as[1][ $i ] ) ) : '',
				);
			}
		}
	}

	if ( preg_match( '/<section class="cta wrap">([\s\S]*?)<\/section>/i', $html, $m ) ) {
		if ( preg_match( '/<h2[^>]*>([\s\S]*?)<\/h2>/i', $m[1], $h ) ) {
			$out['cta_title'] = trim( wp_strip_all_tags( $h[1] ) );
		}
		if ( preg_match( '/<p>([\s\S]*?)<\/p>/i', $m[1], $p ) ) {
			$out['cta_text'] = trim( wp_strip_all_tags( $p[1] ) );
		}
	}

	return $out;
}

/**
 * Convert svc-article HTML into flexible body_blocks.
 *
 * @param string $html Inner article HTML.
 * @return array
 */
function alba_parse_article_to_blocks( $html ) {
	$blocks = array();
	$para_buf = array();

	$flush_paras = static function () use ( &$blocks, &$para_buf ) {
		if ( $para_buf ) {
			$blocks[]  = array(
				'acf_fc_layout' => 'paragraphs',
				'items'         => $para_buf,
			);
			$para_buf = array();
		}
	};

	if ( ! preg_match_all( '/<(h2|h3|p|ul|ol|figure)\b([^>]*)>([\s\S]*?)<\/\1>/i', $html, $matches, PREG_SET_ORDER ) ) {
		// Fallback: loose paragraphs.
		if ( preg_match_all( '/<p>([\s\S]*?)<\/p>/i', $html, $pm ) ) {
			$items = array();
			foreach ( $pm[1] as $p ) {
				$t = trim( wp_strip_all_tags( $p ) );
				if ( $t ) {
					$items[] = array( 'text' => $t );
				}
			}
			if ( $items ) {
				$blocks[] = array( 'acf_fc_layout' => 'paragraphs', 'items' => $items );
			}
		}
		return $blocks;
	}

	foreach ( $matches as $m ) {
		$tag = strtolower( $m[1] );
		$inner = $m[3];
		if ( 'h2' === $tag || 'h3' === $tag ) {
			$flush_paras();
			$blocks[] = array(
				'acf_fc_layout' => 'heading',
				'level'         => $tag,
				'text'          => trim( wp_strip_all_tags( $inner ) ),
			);
		} elseif ( 'p' === $tag ) {
			$t = trim( wp_strip_all_tags( $inner ) );
			if ( $t ) {
				$para_buf[] = array( 'text' => $t );
			}
		} elseif ( 'ul' === $tag || 'ol' === $tag ) {
			$flush_paras();
			$items = array();
			if ( preg_match_all( '/<li>([\s\S]*?)<\/li>/i', $inner, $lis ) ) {
				foreach ( $lis[1] as $li ) {
					$t = trim( wp_strip_all_tags( $li ) );
					if ( $t ) {
						$items[] = array( 'text' => $t );
					}
				}
			}
			if ( $items ) {
				$blocks[] = array( 'acf_fc_layout' => 'list', 'items' => $items );
			}
		} elseif ( 'figure' === $tag ) {
			$flush_paras();
			$url = '';
			$alt = '';
			$cap = '';
			if ( preg_match( '/src=["\']([^"\']+)["\']/i', $inner, $sm ) ) {
				$url = $sm[1];
			}
			if ( preg_match( '/alt=["\']([^"\']*)["\']/i', $inner, $am ) ) {
				$alt = $am[1];
			}
			if ( preg_match( '/<figcaption>([\s\S]*?)<\/figcaption>/i', $inner, $cm ) ) {
				$cap = trim( wp_strip_all_tags( $cm[1] ) );
			}
			if ( $url ) {
				$blocks[] = array(
					'acf_fc_layout' => 'figure',
					'image_url'     => $url,
					'alt'           => $alt,
					'caption'       => $cap,
				);
			}
		}
	}
	$flush_paras();

	return $blocks;
}
