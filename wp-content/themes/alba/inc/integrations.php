<?php
/**
 * SMTP, CRM, VK API, Yandex Direct integrations.
 *
 * @package Alba
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function alba_get_integration( $key, $default = '' ) {
	$opts = get_option( 'alba_integrations', array() );
	return isset( $opts[ $key ] ) ? $opts[ $key ] : $default;
}

/**
 * PHPMailer SMTP from Alba settings.
 */
add_action(
	'phpmailer_init',
	function ( $phpmailer ) {
		// Prevent admin/UI hangs when remote SMTP is unreachable.
		$phpmailer->Timeout = 12;
		if ( ! alba_get_integration( 'smtp_enabled' ) ) {
			return;
		}
		$host = alba_get_integration( 'smtp_host' );
		if ( ! $host ) {
			return;
		}
		$phpmailer->isSMTP();
		$phpmailer->Host       = $host;
		$phpmailer->Port       = (int) alba_get_integration( 'smtp_port', 587 );
		$phpmailer->SMTPAuth   = (bool) alba_get_integration( 'smtp_auth', 1 );
		$phpmailer->Username   = alba_get_integration( 'smtp_user' );
		$phpmailer->Password   = alba_get_integration( 'smtp_pass' );
		$secure                = alba_get_integration( 'smtp_secure', 'tls' );
		if ( $secure ) {
			$phpmailer->SMTPSecure = $secure;
		}
		$from = alba_get_integration( 'smtp_from' );
		$name = alba_get_integration( 'smtp_from_name', get_bloginfo( 'name' ) );
		if ( $from ) {
			$phpmailer->setFrom( $from, $name, false );
		}
	}
);

/**
 * Quick TCP probe for SMTP host:port.
 *
 * @param string $host Host.
 * @param int    $port Port.
 * @param int    $timeout Seconds.
 * @return true|WP_Error
 */
function alba_smtp_probe( $host, $port, $timeout = 5 ) {
	$host = trim( (string) $host );
	$port = (int) $port;
	if ( ! $host || $port < 1 ) {
		return new WP_Error( 'smtp_probe', 'Не указан SMTP host или port.' );
	}
	$errno  = 0;
	$errstr = '';
	$fp     = @fsockopen( $host, $port, $errno, $errstr, $timeout );
	if ( ! $fp ) {
		return new WP_Error(
			'smtp_unreachable',
			sprintf(
				'Сервер не может подключиться к %s:%d (%s). Исходящие SMTP-порты, скорее всего, закрыты на хостинге — попросите провайдера открыть исходящие 465/587 или смените способ отправки.',
				$host,
				$port,
				$errstr ? $errstr : ( 'errno ' . $errno )
			)
		);
	}
	fclose( $fp );
	return true;
}

/**
 * Send lead to CRM webhook.
 *
 * @param array $payload Lead data.
 * @return array|WP_Error
 */
function alba_send_crm( $payload ) {
	$url = alba_get_integration( 'crm_webhook' );
	if ( ! $url ) {
		return new WP_Error( 'crm_missing', 'CRM webhook not configured' );
	}
	$token = alba_get_integration( 'crm_token' );
	$args  = array(
		'timeout' => 15,
		'headers' => array(
			'Content-Type' => 'application/json',
		),
		'body'    => wp_json_encode( $payload ),
	);
	if ( $token ) {
		$args['headers']['Authorization'] = 'Bearer ' . $token;
	}
	$response = wp_remote_post( $url, $args );
	if ( is_wp_error( $response ) ) {
		return $response;
	}
	$code = wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		return new WP_Error( 'crm_http', 'CRM HTTP ' . $code, array( 'body' => wp_remote_retrieve_body( $response ) ) );
	}
	return array(
		'code' => $code,
		'body' => wp_remote_retrieve_body( $response ),
	);
}

/**
 * Form submit hook — email + CRM.
 */
add_action(
	'wp_ajax_alba_lead',
	'alba_handle_lead'
);
add_action(
	'wp_ajax_nopriv_alba_lead',
	'alba_handle_lead'
);

function alba_handle_lead() {
	check_ajax_referer( 'alba_city', 'nonce' );
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$program = isset( $_POST['program'] ) ? sanitize_text_field( wp_unslash( $_POST['program'] ) ) : '';
	$page    = isset( $_POST['page'] ) ? esc_url_raw( wp_unslash( $_POST['page'] ) ) : '';
	$test_score = isset( $_POST['test_score'] ) ? sanitize_text_field( wp_unslash( $_POST['test_score'] ) ) : '';
	$test_brief = isset( $_POST['test_brief'] ) ? sanitize_textarea_field( wp_unslash( $_POST['test_brief'] ) ) : '';
	$city    = alba_get_current_city();

	if ( ! $phone ) {
		wp_send_json_error( array( 'message' => 'Укажите телефон' ), 400 );
	}

	$payload = array(
		'name'       => $name,
		'phone'      => $phone,
		'program'    => $program,
		'page'       => $page,
		'test_score' => $test_score,
		'test_brief' => $test_brief,
		'city'       => $city['name'],
		'city_slug'  => $city['slug'],
		'source'     => 'site',
		'created_at' => gmdate( 'c' ),
	);

	$to = alba_get_integration( 'lead_email', get_option( 'admin_email' ) );
	wp_mail(
		$to,
		'Заявка с сайта — ' . $city['name'],
		wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT )
	);

	$crm = alba_send_crm( $payload );
	wp_send_json_success(
		array(
			'ok'  => true,
			'crm' => is_wp_error( $crm ) ? $crm->get_error_message() : 'ok',
		)
	);
}

/**
 * Admin: send SMTP test email.
 */
function alba_smtp_test() {
	check_ajax_referer( 'alba_smtp_test', 'nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Недостаточно прав.' ), 403 );
	}

	$to = isset( $_POST['to'] ) ? sanitize_email( wp_unslash( $_POST['to'] ) ) : '';
	if ( ! $to || ! is_email( $to ) ) {
		wp_send_json_error( array( 'message' => 'Укажите корректный email.' ), 400 );
	}

	@set_time_limit( 25 );

	$host = (string) alba_get_integration( 'smtp_host' );
	$port = (int) alba_get_integration( 'smtp_port', 587 );
	if ( alba_get_integration( 'smtp_enabled' ) && $host ) {
		$probe = alba_smtp_probe( $host, $port, 5 );
		if ( is_wp_error( $probe ) ) {
			wp_send_json_error( array( 'message' => $probe->get_error_message() ) );
		}
	}

	$mail_error = null;
	$on_fail    = function ( $error ) use ( &$mail_error ) {
		$mail_error = $error;
	};
	add_action( 'wp_mail_failed', $on_fail );

	$subject = 'Тест SMTP — клиника Альба';
	$body    = "Это тестовое письмо с сайта " . home_url( '/' ) . "\n\n"
		. 'Время: ' . wp_date( 'd.m.Y H:i:s' ) . "\n"
		. 'SMTP: ' . ( alba_get_integration( 'smtp_enabled' ) ? 'включён' : 'выключен' ) . "\n"
		. 'Host: ' . ( $host ?: '—' ) . ':' . $port . "\n";

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	$ok      = wp_mail( $to, $subject, $body, $headers );
	remove_action( 'wp_mail_failed', $on_fail );

	if ( $ok ) {
		wp_send_json_success(
			array(
				'message' => 'Письмо отправлено на ' . $to . '. Проверьте входящие и «Спам».',
			)
		);
	}

	$detail = '';
	if ( $mail_error instanceof WP_Error ) {
		$detail = $mail_error->get_error_message();
	}
	if ( ! $detail ) {
		$detail = 'wp_mail вернул ошибку. Проверьте host/port/логин/пароль.';
	}
	if ( false !== stripos( $detail, 'connect' ) || false !== stripos( $detail, 'timed out' ) || false !== stripos( $detail, 'таймаут' ) ) {
		$detail .= ' На этом сервере исходящие SMTP-подключения до удалённых хостов недоступны.';
	}
	// Timeweb / Exim: mailbox or outgoing mail disabled.
	if ( false !== stripos( $detail, 'Disabled' ) || false !== stripos( $detail, '550' ) ) {
		$user = (string) alba_get_integration( 'smtp_user' );
		$detail  = 'SMTP-сервер ответил 550 Disabled — ящик '
			. ( $user ? $user : 'SMTP-пользователя' )
			. ' авторизуется, но отправка с него запрещена. '
			. 'В панели Timeweb откройте почтовый ящик: убедитесь, что он не отключён, включена исходящая почта/SMTP, нет блокировки за спам. '
			. 'Либо создайте новый ящик и укажите его в User / From / Password.';
	}
	wp_send_json_error( array( 'message' => 'Ошибка отправки: ' . $detail ) );
}
add_action( 'wp_ajax_alba_smtp_test', 'alba_smtp_test' );

/**
 * Head pixels: Yandex Direct / Metrika + VK pixel.
 */
add_action(
	'wp_head',
	function () {
		$ym = alba_get_integration( 'yandex_metrika_id' );
		if ( $ym ) {
			$ym = preg_replace( '/\D+/', '', $ym );
			echo "<!-- Yandex.Metrika -->\n<script>(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};m[i].l=1*new Date();for(var j=0;j<document.scripts.length;j++){if(document.scripts[j].src===r)return;}k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})(window,document,'script','https://mc.yandex.ru/metrika/tag.js','ym');ym(" . esc_js( $ym ) . ",'init',{clickmap:true,trackLinks:true,accurateTrackBounce:true,webvisor:true});</script>\n";
		}
		$yd = alba_get_integration( 'yandex_direct_counter' );
		if ( $yd ) {
			echo "<!-- Yandex Direct counter placeholder -->\n<script>window.ALBA_YD=" . wp_json_encode( $yd ) . ";</script>\n";
		}
		$vk = alba_get_integration( 'vk_pixel_id' );
		if ( $vk ) {
			echo "<!-- VK Pixel -->\n<script>!function(){var t=document.createElement('script');t.type='text/javascript',t.async=!0,t.src='https://vk.com/js/api/openapi.js?169',t.onload=function(){VK.Retargeting.Init('" . esc_js( $vk ) . "'),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script>\n";
		}
		$vk_api = alba_get_integration( 'vk_api_id' );
		if ( $vk_api ) {
			echo '<script>window.ALBA_VK_API_ID=' . wp_json_encode( $vk_api ) . ';</script>' . "\n";
		}
	},
	5
);
