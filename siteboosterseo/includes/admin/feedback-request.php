<?php
namespace nameSiteboosterseo;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/* Render the SiteBoosterSEO feedback request box.
 * @param string $context Display context: dashboard|plugin_page.
 * @return void*/
class classSiteboosterseoFeedbackRequest {
/** Delay before showing the feedback request. Testing: MINUTE_IN_SECONDS
 * Production: WEEK_IN_SECONDS */
private const FEEDBACK_PROMPT_DELAY = WEEK_IN_SECONDS;
public static function run() {
		add_action( 'admin_notices', array( __CLASS__, 'renderDashboardFeedbackRequest' ) );
		add_action( 'admin_post_siteboosterseo_feedback_action', array( __CLASS__, 'handleFeedbackAction' ) );
        add_action( 'admin_enqueue_scripts', array( self::class, 'enqueueAdminStyles' ) );
	}

	/**
 * Render feedback request HTML.
 *
 * @param string $context Display context: dashboard|plugin_page.
 * @return void
 */
public static function renderFeedbackRequest( $context = 'plugin_page' ) {
	$context = in_array( $context, array( 'dashboard', 'plugin_page' ), true ) ? $context : 'plugin_page';
	$redirect_to = self::getCurrentAdminUrl();

	$review_action_url = wp_nonce_url(
		add_query_arg(
			array(
				'action'                  => 'siteboosterseo_feedback_action',
				'siteboosterseo_feedback' => 'review',
			),
			admin_url( 'admin-post.php' )
		),
		'siteboosterseo_feedback_action',
		'siteboosterseo_feedback_nonce'
	);

	$later_url = wp_nonce_url(
	add_query_arg(
		array(
			'action'                   => 'siteboosterseo_feedback_action',
			'siteboosterseo_feedback' => 'later',
			'redirect_to'             => $redirect_to,
		),
		admin_url( 'admin-post.php' )
	),
	'siteboosterseo_feedback_action',
	'siteboosterseo_feedback_nonce'
);
	$dismiss_url = wp_nonce_url(
	add_query_arg(
		array(
			'action'                   => 'siteboosterseo_feedback_action',
			'siteboosterseo_feedback' => 'dismiss',
			'redirect_to'             => $redirect_to,
		),
		admin_url( 'admin-post.php' )
	),
	'siteboosterseo_feedback_action',
	'siteboosterseo_feedback_nonce'
);

	$wrapper_class = 'sbseo-feedback-notice sbseo-feedback-notice--' . $context;

	if ( 'dashboard' === $context ) {
		$wrapper_class .= ' notice notice-info';
	}
	?>

	<div class="<?php echo esc_attr( $wrapper_class ); ?>">
		<div class="sbseo-feedback-notice__inner">
			<div class="sbseo-feedback-notice__text">
				<strong><?php esc_html_e( 'Enjoying SiteBoosterSEO?', 'siteboosterseo' ); ?></strong>
				<span><?php esc_html_e( 'A quick review would really help us improve and keep the plugin growing.', 'siteboosterseo' ); ?></span>
			</div>

			<div class="sbseo-feedback-request">
				<a
	class="button button-primary"
	href="<?php echo esc_url( $review_action_url ); ?>"
	data-sbseo-feedback-action="review">
	<?php esc_html_e( 'Leave a review', 'siteboosterseo' ); ?>
</a>

				<a
					class="button"
					href="<?php echo esc_url( $later_url ); ?>"
				>
					<?php esc_html_e( 'Maybe later', 'siteboosterseo' ); ?>
				</a>

				<a
					class="button-link"
					href="<?php echo esc_url( $dismiss_url ); ?>"
				>
					<?php esc_html_e( 'No, thanks', 'siteboosterseo' ); ?>
				</a>
			</div>
		</div>
	</div>

	<?php
}
/* Render feedback request on WordPress Dashboard only. @return void */

/* Render feedback request on WordPress Dashboard only.* @return void */
public static function renderDashboardFeedbackRequest() {
	if ( ! is_admin() ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}

	if ( ! self::shouldShowFeedbackRequest() ) {
		return;
	}

	self::renderFeedbackRequest( 'dashboard' );
}

/** Handle feedback request actions. * @return void */


/**
 * Handle feedback request actions.
 *
 * @return void
 */
public static function handleFeedbackAction() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to perform this action.', 'siteboosterseo' ) );
	}
	check_admin_referer( 'siteboosterseo_feedback_action', 'siteboosterseo_feedback_nonce' );

	$feedback_action = isset( $_GET['siteboosterseo_feedback'] )
		? sanitize_key( wp_unslash( $_GET['siteboosterseo_feedback'] ) )
		: '';
	$current_time = time();

$redirect_to = isset( $_GET['redirect_to'] )
	? esc_url_raw( wp_unslash( $_GET['redirect_to'] ) )
	: '';

$redirect_to = wp_validate_redirect( $redirect_to, admin_url( 'index.php' ) );	

	$review_url = 'https://wordpress.org/support/plugin/siteboosterseo/reviews/#new-post';

	if ( 'review' === $feedback_action ) {
		self::updateFeedbackState(
			array(
				'reviewed'  => true,
				'dismissed' => true,
			)
		);

		wp_redirect( esc_url_raw( $review_url ) );
		exit;
	}
	if ( 'later' === $feedback_action ) {
	self::updateFeedbackState(
		array(
			'next_prompt_at' => $current_time + self::FEEDBACK_PROMPT_DELAY,
		)
	);

	wp_safe_redirect( $redirect_to );
	exit;
}

if ( 'dismiss' === $feedback_action ) {
	self::updateFeedbackState(
		array(
			'dismissed' => true,
		)
	);

	wp_safe_redirect( $redirect_to );
	exit;
}

	wp_safe_redirect( admin_url( 'index.php' ) );
	exit;
}



public static function enqueueAdminStyles( $hook ) {

	$allowed_hooks = array(
		'index.php', // Dashboard.
		'toplevel_page_dcjmyplug_settings', // Página principal del plugin, si ese es tu hook.
	);

	if ( ! in_array( $hook, $allowed_hooks, true ) ) {
		return;
	}

	wp_enqueue_style(
		'siteboosterseo-feedback',
		plugins_url( 'assets/css/admin-feedback.min.css', dirname( __DIR__, 2 ) . '/siteboosterseo.php' ),
		array(),
		'1.3.0'
	);

}
/**
 * Get default feedback state.
 *
 * @return array
 */
private static function getDefaultFeedbackState() {
	return array(
		'detected_config_at' => 0,
		'next_prompt_at'     => 0,
		'dismissed'          => false,
		'reviewed'           => false,
	);
}

/**
 * Get feedback state.
 *
 * @return array
 */
private static function getFeedbackState() {
	$state = get_option( 'dcjmyplug_feedback_state', array() );

	if ( ! is_array( $state ) ) {
		$state = array();
	}

	return wp_parse_args( $state, self::getDefaultFeedbackState() );
}

/**
 * Update feedback state.
 *
 * @param array $new_state New state values.
 * @return void
 */
private static function updateFeedbackState( $new_state ) {
	$state = self::getFeedbackState();
	$state = array_merge( $state, $new_state );

	update_option( 'dcjmyplug_feedback_state', $state, false );
}

/**
 * Check if the plugin has a real configuration saved.
 *
 * @return bool
 */
private static function hasRealPluginConfiguration() {
	$options = get_option( 'dcjmyplug_options', array() );

	if ( ! is_array( $options ) ) {
		return false;
	}

	$title = isset( $options['title'] ) ? trim( wp_strip_all_tags( $options['title'] ) ) : '';

	// Change "description" if your real option key has another name.
	$description = isset( $options['description'] ) ? trim( wp_strip_all_tags( $options['description'] ) ) : '';

	return '' !== $title || '' !== $description;
}

/**
 * Decide if the feedback request should be shown.
 *
 * @return bool
 */
public static function shouldShowFeedbackRequest() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return false;
	}

	if ( ! self::hasRealPluginConfiguration() ) {
		return false;
	}

	$state = self::getFeedbackState();

	if ( ! empty( $state['dismissed'] ) || ! empty( $state['reviewed'] ) ) {
		return false;
	}

	$current_time = time();

	// First time we detect that the plugin has been configured.
	// We schedule the prompt, but we do not show it immediately.
	if ( empty( $state['detected_config_at'] ) || empty( $state['next_prompt_at'] ) ) {
		self::updateFeedbackState(
			array(
				'detected_config_at' => $current_time,
				'next_prompt_at' => $current_time + self::FEEDBACK_PROMPT_DELAY,
			)
		);

		return false;
	}

	return $current_time >= absint( $state['next_prompt_at'] );
}

/**
 * Get current admin URL.
 *
 * @return string
 */
private static function getCurrentAdminUrl() {
	$scheme      = is_ssl() ? 'https://' : 'http://';
	$host        = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';

	if ( empty( $host ) || empty( $request_uri ) ) {
		return admin_url( 'index.php' );
	}

	$current_url = esc_url_raw( $scheme . $host . $request_uri );

	return remove_query_arg(
		array(
			'action',
			'siteboosterseo_feedback',
			'siteboosterseo_feedback_nonce',
			'_wpnonce',
			'redirect_to',
		),
		$current_url
	);
}
}