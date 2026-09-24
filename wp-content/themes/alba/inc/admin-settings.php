<?php
/**
 * Admin pages: cities + integrations (SMTP / CRM / VK / Yandex).
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'admin_menu',
	function () {
		add_menu_page(
			'Альба',
			'Альба',
			'manage_options',
			'alba-settings',
			'alba_render_cities_page',
			'dashicons-location-alt',
			3
		);
		add_submenu_page( 'alba-settings', 'Города', 'Города', 'manage_options', 'alba-settings', 'alba_render_cities_page' );
		add_submenu_page( 'alba-settings', 'Интеграции', 'Интеграции', 'manage_options', 'alba-integrations', 'alba_render_integrations_page' );
		add_submenu_page( 'alba-settings', 'Импорт HTML', 'Импорт HTML', 'manage_options', 'alba-import', 'alba_render_import_page' );
	}
);

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( false === strpos( (string) $hook, 'alba-integrations' ) ) {
			return;
		}
		wp_enqueue_style(
			'alba-admin-integrations',
			ALBA_URI . '/assets/admin-integrations.css',
			array(),
			file_exists( ALBA_DIR . '/assets/admin-integrations.css' ) ? (string) filemtime( ALBA_DIR . '/assets/admin-integrations.css' ) : ALBA_VERSION
		);
		wp_enqueue_script(
			'alba-admin-integrations',
			ALBA_URI . '/assets/admin-integrations.js',
			array(),
			file_exists( ALBA_DIR . '/assets/admin-integrations.js' ) ? (string) filemtime( ALBA_DIR . '/assets/admin-integrations.js' ) : ALBA_VERSION,
			true
		);
		wp_localize_script(
			'alba-admin-integrations',
			'ALBA_INT',
			array(
				'ajax'  => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'alba_smtp_test' ),
			)
		);
	}
);

function alba_render_cities_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['alba_cities_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_cities_nonce'] ) ), 'alba_save_cities' ) ) {
		$raw   = isset( $_POST['cities'] ) ? wp_unslash( $_POST['cities'] ) : array();
		$clean = array();
		if ( is_array( $raw ) ) {
			foreach ( $raw as $row ) {
				if ( empty( $row['name'] ) && empty( $row['slug'] ) ) {
					continue;
				}
				$clean[] = array(
					'slug'    => sanitize_title( $row['slug'] ?: $row['name'] ),
					'name'    => sanitize_text_field( $row['name'] ),
					'prep'    => sanitize_text_field( $row['prep'] ?? '' ),
					'phone'   => sanitize_text_field( $row['phone'] ?? '' ),
					'tel'     => sanitize_text_field( $row['tel'] ?? '' ),
					'address' => sanitize_text_field( $row['address'] ?? '' ),
					'extra'   => sanitize_text_field( $row['extra'] ?? '' ),
					'license' => sanitize_text_field( $row['license'] ?? '' ),
					'map'     => esc_url_raw( $row['map'] ?? '' ),
					'tg'      => esc_url_raw( $row['tg'] ?? '' ),
					'max'     => esc_url_raw( $row['max'] ?? '' ),
					'default' => ! empty( $row['default'] ) ? 1 : 0,
				);
			}
		}
		update_option( 'alba_cities', $clean, false );
		flush_rewrite_rules();
		echo '<div class="updated"><p>Города сохранены. ЧПУ обновлены.</p></div>';
	}
	$cities = alba_get_cities();
	?>
	<div class="wrap">
		<h1>Города и контакты</h1>
		<p>URL вида <code>/omsk/about</code>. Контакты подставляются в шаблон и доступны для точечных оверрайдов услуг (поле «Оверрайды по городу»).</p>
		<form method="post">
			<?php wp_nonce_field( 'alba_save_cities', 'alba_cities_nonce' ); ?>
			<table class="widefat striped">
				<thead>
					<tr>
						<th>Slug</th><th>Название</th><th>в городе</th><th>Телефон</th><th>tel:</th><th>Адрес</th><th>Лицензия</th><th>По умолч.</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $cities as $i => $c ) : ?>
					<tr>
						<td><input name="cities[<?php echo (int) $i; ?>][slug]" value="<?php echo esc_attr( $c['slug'] ); ?>" class="regular-text"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][name]" value="<?php echo esc_attr( $c['name'] ); ?>" class="regular-text"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][prep]" value="<?php echo esc_attr( $c['prep'] ); ?>"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][phone]" value="<?php echo esc_attr( $c['phone'] ); ?>"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][tel]" value="<?php echo esc_attr( $c['tel'] ); ?>"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][address]" value="<?php echo esc_attr( $c['address'] ); ?>" class="regular-text"></td>
						<td><input name="cities[<?php echo (int) $i; ?>][license]" value="<?php echo esc_attr( $c['license'] ); ?>"></td>
						<td><input type="checkbox" name="cities[<?php echo (int) $i; ?>][default]" value="1" <?php checked( ! empty( $c['default'] ) ); ?>></td>
					</tr>
					<tr>
						<td colspan="8">
							<label>extra <input name="cities[<?php echo (int) $i; ?>][extra]" value="<?php echo esc_attr( $c['extra'] ); ?>" class="large-text"></label>
							<label>map <input name="cities[<?php echo (int) $i; ?>][map]" value="<?php echo esc_attr( $c['map'] ); ?>" class="large-text"></label>
							<label>tg <input name="cities[<?php echo (int) $i; ?>][tg]" value="<?php echo esc_attr( $c['tg'] ); ?>" class="regular-text"></label>
							<label>max <input name="cities[<?php echo (int) $i; ?>][max]" value="<?php echo esc_attr( $c['max'] ); ?>" class="regular-text"></label>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php $n = count( $cities ); ?>
					<tr><td colspan="8"><strong>Новый город</strong></td></tr>
					<tr>
						<td><input name="cities[<?php echo (int) $n; ?>][slug]" placeholder="slug"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][name]" placeholder="Название"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][prep]" placeholder="в …"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][phone]"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][tel]"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][address]"></td>
						<td><input name="cities[<?php echo (int) $n; ?>][license]"></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<?php submit_button( 'Сохранить города' ); ?>
		</form>
	</div>
	<?php
}

function alba_render_integrations_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$prev = get_option( 'alba_integrations', array() );
	if ( isset( $_POST['alba_int_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_int_nonce'] ) ), 'alba_save_int' ) ) {
		$keys = array(
			'smtp_host', 'smtp_port', 'smtp_user', 'smtp_secure', 'smtp_from', 'smtp_from_name',
			'crm_webhook', 'crm_token', 'lead_email',
			'vk_api_id', 'vk_api_secret', 'vk_pixel_id', 'vk_access_token',
			'yandex_metrika_id', 'yandex_direct_counter', 'yandex_direct_token', 'yandex_oauth_client',
		);
		$opts = array();
		foreach ( $keys as $k ) {
			$opts[ $k ] = isset( $_POST[ $k ] ) ? sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) : '';
		}
		$opts['smtp_enabled'] = ! empty( $_POST['smtp_enabled'] ) ? 1 : 0;
		$opts['smtp_auth']    = ! empty( $_POST['smtp_auth'] ) ? 1 : 0;
		// Keep previous password if field left blank.
		$new_pass = isset( $_POST['smtp_pass'] ) ? (string) wp_unslash( $_POST['smtp_pass'] ) : '';
		$opts['smtp_pass'] = '' !== $new_pass ? sanitize_text_field( $new_pass ) : (string) ( $prev['smtp_pass'] ?? '' );
		update_option( 'alba_integrations', $opts, false );
		$prev = $opts;
		echo '<div class="notice notice-success is-dismissible"><p>Интеграции сохранены.</p></div>';
	}

	$o = $prev;
	$v = function ( $k, $d = '' ) use ( $o ) {
		return esc_attr( $o[ $k ] ?? $d );
	};

	$smtp_on  = ! empty( $o['smtp_enabled'] ) && ! empty( $o['smtp_host'] );
	$crm_on   = ! empty( $o['crm_webhook'] );
	$vk_on    = ! empty( $o['vk_pixel_id'] ) || ! empty( $o['vk_api_id'] );
	$ya_on    = ! empty( $o['yandex_metrika_id'] ) || ! empty( $o['yandex_direct_counter'] );
	$lead_to  = $o['lead_email'] ?? get_option( 'admin_email' );
	$test_to  = $lead_to ?: get_option( 'admin_email' );
	?>
	<div class="wrap alba-int">
		<header class="alba-int__hero">
			<div>
				<p class="alba-int__eyebrow">Альба · настройки</p>
				<h1>Интеграции</h1>
				<p class="alba-int__lead">Почта заявок, CRM, пиксели VK и Яндекс. Сохраните SMTP и проверьте отправку тестовым письмом.</p>
			</div>
			<div class="alba-int__status-row">
				<span class="alba-int__pill <?php echo $smtp_on ? 'is-on' : 'is-off'; ?>">SMTP <?php echo $smtp_on ? 'вкл' : 'выкл'; ?></span>
				<span class="alba-int__pill <?php echo $crm_on ? 'is-on' : 'is-off'; ?>">CRM <?php echo $crm_on ? 'вкл' : '—'; ?></span>
				<span class="alba-int__pill <?php echo $vk_on ? 'is-on' : 'is-off'; ?>">VK <?php echo $vk_on ? 'вкл' : '—'; ?></span>
				<span class="alba-int__pill <?php echo $ya_on ? 'is-on' : 'is-off'; ?>">Яндекс <?php echo $ya_on ? 'вкл' : '—'; ?></span>
			</div>
		</header>

		<nav class="alba-int__tabs" data-alba-int-tabs>
			<a href="#alba-smtp" class="is-active">Почта / SMTP</a>
			<a href="#alba-crm">CRM</a>
			<a href="#alba-vk">VK</a>
			<a href="#alba-yandex">Яндекс</a>
		</nav>

		<form method="post" class="alba-int__form" id="alba-int-form">
			<?php wp_nonce_field( 'alba_save_int', 'alba_int_nonce' ); ?>

			<section class="alba-int__card" id="alba-smtp">
				<div class="alba-int__card-head">
					<div>
						<h2>SMTP и заявки</h2>
						<p>Исходящая почта для заявок с сайта. Без SMTP письма идут через серверный mail().</p>
					</div>
					<label class="alba-int__switch">
						<input type="checkbox" name="smtp_enabled" value="1" <?php checked( ! empty( $o['smtp_enabled'] ) ); ?>>
						<span>Включить SMTP</span>
					</label>
				</div>

				<div class="alba-int__grid">
					<label class="alba-int__field">
						<span>SMTP host</span>
						<input name="smtp_host" value="<?php echo $v( 'smtp_host' ); ?>" placeholder="smtp.yandex.ru" autocomplete="off">
					</label>
					<label class="alba-int__field">
						<span>Port</span>
						<input name="smtp_port" value="<?php echo $v( 'smtp_port', '587' ); ?>" placeholder="587">
					</label>
					<label class="alba-int__field">
						<span>Шифрование</span>
						<select name="smtp_secure">
							<option value="tls" <?php selected( $v( 'smtp_secure', 'tls' ), 'tls' ); ?>>TLS</option>
							<option value="ssl" <?php selected( $v( 'smtp_secure' ), 'ssl' ); ?>>SSL</option>
							<option value="" <?php selected( $v( 'smtp_secure' ), '' ); ?>>Без шифрования</option>
						</select>
					</label>
					<label class="alba-int__field alba-int__field--check">
						<span>Авторизация</span>
						<label class="alba-int__check"><input type="checkbox" name="smtp_auth" value="1" <?php checked( ! isset( $o['smtp_auth'] ) || ! empty( $o['smtp_auth'] ) ); ?>> Требовать логин и пароль</label>
					</label>
					<label class="alba-int__field">
						<span>Логин</span>
						<input name="smtp_user" value="<?php echo $v( 'smtp_user' ); ?>" autocomplete="off">
					</label>
					<label class="alba-int__field">
						<span>Пароль <?php if ( ! empty( $o['smtp_pass'] ) ) : ?><em class="alba-int__hint">(сохранён — оставьте пустым, чтобы не менять)</em><?php endif; ?></span>
						<input type="password" name="smtp_pass" value="" autocomplete="new-password" placeholder="<?php echo ! empty( $o['smtp_pass'] ) ? '••••••••' : ''; ?>">
					</label>
					<label class="alba-int__field">
						<span>From email</span>
						<input name="smtp_from" type="email" value="<?php echo $v( 'smtp_from' ); ?>" placeholder="noreply@example.com">
					</label>
					<label class="alba-int__field">
						<span>From name</span>
						<input name="smtp_from_name" value="<?php echo $v( 'smtp_from_name', 'Альба' ); ?>">
					</label>
					<label class="alba-int__field alba-int__field--wide">
						<span>Email для заявок с сайта</span>
						<input name="lead_email" type="email" value="<?php echo $v( 'lead_email', get_option( 'admin_email' ) ); ?>">
					</label>
				</div>

				<div class="alba-int__test" data-smtp-test>
					<div>
						<strong>Проверка SMTP</strong>
						<p>Отправит тестовое письмо через текущие настройки (сначала сохраните изменения). Если зависает или таймаут — на VPS часто закрыты исходящие порты 465/587.</p>
					</div>
					<div class="alba-int__test-row">
						<input type="email" data-smtp-to value="<?php echo esc_attr( $test_to ); ?>" placeholder="куда отправить тест">
						<button type="button" class="button button-primary" data-smtp-send>Отправить тест</button>
					</div>
					<p class="alba-int__test-msg" data-smtp-msg hidden></p>
				</div>
			</section>

			<section class="alba-int__card" id="alba-crm">
				<div class="alba-int__card-head">
					<div>
						<h2>CRM webhook</h2>
						<p>Каждая заявка уходит JSON POST на указанный URL.</p>
					</div>
				</div>
				<div class="alba-int__grid">
					<label class="alba-int__field alba-int__field--wide">
						<span>Webhook URL</span>
						<input name="crm_webhook" value="<?php echo $v( 'crm_webhook' ); ?>" placeholder="https://crm.example/hooks/leads">
					</label>
					<label class="alba-int__field alba-int__field--wide">
						<span>Bearer token</span>
						<input name="crm_token" value="<?php echo $v( 'crm_token' ); ?>" autocomplete="off">
					</label>
				</div>
			</section>

			<section class="alba-int__card" id="alba-vk">
				<div class="alba-int__card-head">
					<div>
						<h2>VK</h2>
						<p>Пиксель ретаргетинга и данные приложения.</p>
					</div>
				</div>
				<div class="alba-int__grid">
					<label class="alba-int__field"><span>App ID</span><input name="vk_api_id" value="<?php echo $v( 'vk_api_id' ); ?>"></label>
					<label class="alba-int__field"><span>App Secret</span><input name="vk_api_secret" value="<?php echo $v( 'vk_api_secret' ); ?>" autocomplete="off"></label>
					<label class="alba-int__field"><span>Pixel ID</span><input name="vk_pixel_id" value="<?php echo $v( 'vk_pixel_id' ); ?>"></label>
					<label class="alba-int__field alba-int__field--wide"><span>Access token</span><input name="vk_access_token" value="<?php echo $v( 'vk_access_token' ); ?>" autocomplete="off"></label>
				</div>
			</section>

			<section class="alba-int__card" id="alba-yandex">
				<div class="alba-int__card-head">
					<div>
						<h2>Яндекс</h2>
						<p>Метрика и Direct — идентификаторы для фронта и рекламы.</p>
					</div>
				</div>
				<div class="alba-int__grid">
					<label class="alba-int__field"><span>Metrika ID</span><input name="yandex_metrika_id" value="<?php echo $v( 'yandex_metrika_id' ); ?>"></label>
					<label class="alba-int__field"><span>Direct counter</span><input name="yandex_direct_counter" value="<?php echo $v( 'yandex_direct_counter' ); ?>"></label>
					<label class="alba-int__field alba-int__field--wide"><span>Direct OAuth token</span><input name="yandex_direct_token" value="<?php echo $v( 'yandex_direct_token' ); ?>" autocomplete="off"></label>
					<label class="alba-int__field alba-int__field--wide"><span>OAuth Client ID</span><input name="yandex_oauth_client" value="<?php echo $v( 'yandex_oauth_client' ); ?>"></label>
				</div>
			</section>

			<div class="alba-int__bar">
				<button type="submit" class="button button-primary button-hero">Сохранить интеграции</button>
				<span class="alba-int__bar-hint">Пароль SMTP не затирается, если поле пустое.</span>
			</div>
		</form>
	</div>
	<?php
}

function alba_render_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$result = null;
	$seed   = null;
	if ( isset( $_POST['alba_import_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_import_nonce'] ) ), 'alba_import' ) ) {
		$result = alba_import_legacy_html();
		if ( function_exists( 'alba_seed_pages_acf' ) ) {
			$seed = alba_seed_pages_acf( true );
		}
		if ( function_exists( 'alba_seed_services_acf' ) ) {
			$seed = is_array( $seed ) ? $seed : array();
			$seed['services'] = alba_seed_services_acf( true );
		}
		if ( function_exists( 'alba_seed_doctors_acf' ) ) {
			$seed = is_array( $seed ) ? $seed : array();
			$seed['doctors'] = alba_seed_doctors_acf( true );
		}
		if ( function_exists( 'alba_seed_articles_acf' ) ) {
			$seed = is_array( $seed ) ? $seed : array();
			$seed['articles'] = alba_seed_articles_acf( true );
		}
	}
	if ( isset( $_POST['alba_seed_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_seed_nonce'] ) ), 'alba_seed_acf' ) ) {
		$force = ! empty( $_POST['alba_seed_force'] );
		$seed  = function_exists( 'alba_seed_pages_acf' ) ? alba_seed_pages_acf( $force ) : array( 'error' => 'no seeder' );
		if ( function_exists( 'alba_seed_services_acf' ) ) {
			$seed['services'] = alba_seed_services_acf( $force );
		}
		if ( function_exists( 'alba_seed_articles_acf' ) ) {
			$seed['articles'] = alba_seed_articles_acf( $force );
		}
	}
	$svc_seed = null;
	if ( isset( $_POST['alba_svc_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_svc_nonce'] ) ), 'alba_seed_svc' ) ) {
		$svc_seed = function_exists( 'alba_seed_services_acf' ) ? alba_seed_services_acf( ! empty( $_POST['alba_svc_force'] ) ) : array( 'error' => 'no seeder' );
	}
	$doc_seed = null;
	if ( isset( $_POST['alba_doc_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_doc_nonce'] ) ), 'alba_seed_doc' ) ) {
		$doc_seed = function_exists( 'alba_seed_doctors_acf' ) ? alba_seed_doctors_acf( true ) : array( 'error' => 'no seeder' );
	}
	?>
	<div class="wrap">
		<h1>Импорт из legacy-html</h1>
		<p>Создаёт страницы, услуги (CPT service), программы, врачей и статьи из папки <code>legacy-html/</code>.</p>
		<?php if ( $result ) : ?>
			<div class="updated"><p><strong>Импорт HTML</strong></p><pre><?php echo esc_html( print_r( $result, true ) ); ?></pre></div>
		<?php endif; ?>
		<?php if ( $seed ) : ?>
			<div class="updated"><p><strong>Заполнение ACF</strong></p><pre><?php echo esc_html( print_r( $seed, true ) ); ?></pre></div>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'alba_import', 'alba_import_nonce' ); ?>
			<?php submit_button( 'Запустить импорт + заполнить ACF' ); ?>
		</form>
		<hr>
		<h2>Только ACF-поля страниц</h2>
		<p>Собирает страницы из structured ACF-блоков (без HTML в админке): заголовки, чипы, flexible <code>page_blocks</code>. Gutenberg и редактор страницы отключены.</p>
		<form method="post">
			<?php wp_nonce_field( 'alba_seed_acf', 'alba_seed_nonce' ); ?>
			<label><input type="checkbox" name="alba_seed_force" value="1" checked> Перезаписать уже заполненные поля</label>
			<?php submit_button( 'Заполнить ACF из legacy-html', 'secondary' ); ?>
		</form>
		<hr>
		<h2>Услуги и программы (ACF)</h2>
		<p>Переносит услуги/программы из <code>legacy-html/service-*.html</code> в structured ACF (без HTML в редакторе). Редактор CPT отключён.</p>
		<?php if ( $svc_seed ) : ?>
			<div class="updated"><p><strong>Услуги/программы</strong></p><pre><?php echo esc_html( print_r( $svc_seed, true ) ); ?></pre></div>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'alba_seed_svc', 'alba_svc_nonce' ); ?>
			<label><input type="checkbox" name="alba_svc_force" value="1" checked> Перезаписать</label>
			<?php submit_button( 'Заполнить услуги и программы', 'secondary' ); ?>
		</form>
		<hr>
		<h2>Врачи (ACF + страница)</h2>
		<p>Обновляет CPT <strong>Врачи</strong> из <code>legacy-html/doctors.html</code> и собирает страницу «Врачи» с сеткой карточек.</p>
		<?php if ( $doc_seed ) : ?>
			<div class="updated"><pre><?php echo esc_html( print_r( $doc_seed, true ) ); ?></pre></div>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'alba_seed_doc', 'alba_doc_nonce' ); ?>
			<?php submit_button( 'Заполнить врачей и страницу', 'secondary' ); ?>
		</form>
		<hr>
		<h2>Тесты (квизы)</h2>
		<p>Создаёт записи в меню <strong>Тесты</strong>: вопросы, ответы и брифы. Дальше добавляйте и правьте там же.</p>
		<?php
		$quiz_seed = null;
		if ( isset( $_POST['alba_quiz_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['alba_quiz_nonce'] ) ), 'alba_seed_quiz' ) ) {
			$quiz_seed = function_exists( 'alba_seed_quizzes' ) ? alba_seed_quizzes( ! empty( $_POST['alba_quiz_force'] ) ) : array( 'error' => 'no seeder' );
		}
		if ( $quiz_seed ) {
			echo '<div class="updated"><pre>' . esc_html( print_r( $quiz_seed, true ) ) . '</pre></div>';
		}
		?>
		<form method="post">
			<?php wp_nonce_field( 'alba_seed_quiz', 'alba_quiz_nonce' ); ?>
			<label><input type="checkbox" name="alba_quiz_force" value="1"> Удалить существующие тесты и создать заново</label>
			<?php submit_button( 'Создать стартовые тесты', 'secondary' ); ?>
		</form>
	</div>
	<?php
}
