<?php
/** WooCommerce coupon fields and plugin settings screen. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Coupon_Payment_Methods_Admin {
	public static function init() {
		add_action( 'woocommerce_coupon_options_usage_restriction', array( __CLASS__, 'render_coupon_fields' ), 10, 2 );
		add_action( 'woocommerce_coupon_options_save', array( __CLASS__, 'save_coupon_fields' ), 10, 2 );
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_styles' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( COUPON_PAYMENT_METHODS_FILE ), array( __CLASS__, 'add_settings_link' ) );
	}

	public static function render_coupon_fields( $coupon_id, $coupon = null ) {
		if ( ! current_user_can( 'edit_shop_coupons', $coupon_id ) ) {
			return;
		}

		$enabled  = 'yes' === get_post_meta( $coupon_id, Coupon_Payment_Methods_Coupons::RESTRICT_META, true );
		$selected = get_post_meta( $coupon_id, Coupon_Payment_Methods_Coupons::GATEWAYS_META, true );
		$selected = is_array( $selected ) ? array_map( 'sanitize_text_field', $selected ) : array();
		$gateways = self::get_gateways();
		?>
		<div class="options_group">
			<div class="coupon-payment-methods-box">
				<label class="coupon-payment-methods-toggle" for="coupon_payment_methods_restrict">
					<input type="checkbox" id="coupon_payment_methods_restrict" name="coupon_payment_methods_restrict" value="yes" <?php checked( $enabled ); ?> />
					<span><?php echo esc_html__( 'Restrict payment methods', 'coupon-payment-methods' ); ?></span>
				</label>
				<p class="coupon-payment-methods-description"><?php echo esc_html__( 'When enabled, this coupon can only be used with the selected payment methods.', 'coupon-payment-methods' ); ?></p>
				<?php wp_nonce_field( 'coupon_payment_methods_save_coupon', 'coupon_payment_methods_nonce' ); ?>

				<?php if ( empty( $gateways ) ) : ?>
					<p class="coupon-payment-methods-description"><?php echo esc_html__( 'No payment methods were found in WooCommerce.', 'coupon-payment-methods' ); ?></p>
				<?php else : ?>
					<div class="coupon-payment-methods-label"><?php echo esc_html__( 'Allowed payment methods', 'coupon-payment-methods' ); ?></div>
					<div class="coupon-payment-methods-grid">
						<?php foreach ( $gateways as $gateway_id => $gateway ) : ?>
							<?php $label = is_callable( array( $gateway, 'get_title' ) ) ? $gateway->get_title() : $gateway->title; ?>
							<label class="coupon-payment-methods-card">
								<input type="checkbox" name="coupon_payment_methods_gateways[]" value="<?php echo esc_attr( $gateway_id ); ?>" <?php checked( self::contains_gateway_id( $selected, $gateway_id ) ); ?> />
								<span><?php echo esc_html( $label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
					<p class="coupon-payment-methods-description"><?php echo esc_html__( 'If you enable this restriction without selecting a method, the coupon will not be valid with any payment method.', 'coupon-payment-methods' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public static function save_coupon_fields( $coupon_id, $coupon = null ) {
		if ( ! current_user_can( 'edit_shop_coupons', $coupon_id ) ||
			! isset( $_POST['coupon_payment_methods_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['coupon_payment_methods_nonce'] ) ), 'coupon_payment_methods_save_coupon' ) ) {
			return;
		}

		$enabled = isset( $_POST['coupon_payment_methods_restrict'] ) && 'yes' === sanitize_text_field( wp_unslash( $_POST['coupon_payment_methods_restrict'] ) );
		$raw     = isset( $_POST['coupon_payment_methods_gateways'] ) ? (array) wp_unslash( $_POST['coupon_payment_methods_gateways'] ) : array();
		$allowed = array_values( array_unique( array_filter( array_map( 'sanitize_text_field', $raw ) ) ) );

		update_post_meta( $coupon_id, Coupon_Payment_Methods_Coupons::RESTRICT_META, $enabled ? 'yes' : 'no' );
		update_post_meta( $coupon_id, Coupon_Payment_Methods_Coupons::GATEWAYS_META, $allowed );
	}

	public static function add_settings_page() {
		add_submenu_page(
			'woocommerce',
			__( 'Coupon payment method settings', 'coupon-payment-methods' ),
			__( 'Coupon settings', 'coupon-payment-methods' ),
			'manage_woocommerce',
			Coupon_Payment_Methods::PAGE_SLUG,
			array( __CLASS__, 'render_settings_page' )
		);
	}

	public static function register_settings() {
		register_setting(
			'coupon_payment_methods_settings',
			Coupon_Payment_Methods::ERROR_MESSAGE_OPTION,
			array(
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_textarea_field',
				'default'           => __( Coupon_Payment_Methods::DEFAULT_ERROR, 'coupon-payment-methods' ),
			)
		);
	}

	public static function render_settings_page() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$default_message = __( Coupon_Payment_Methods::DEFAULT_ERROR, 'coupon-payment-methods' );
		$message         = get_option( Coupon_Payment_Methods::ERROR_MESSAGE_OPTION, $default_message );
		?>
		<div class="wrap coupon-payment-methods-settings" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
			<h1><?php echo esc_html__( 'Coupon payment method settings', 'coupon-payment-methods' ); ?></h1>
			<p><?php echo esc_html__( 'Choose allowed payment methods in the "Usage restriction" tab of each coupon. The message below is shown when a customer selects a payment method that is not allowed for that coupon.', 'coupon-payment-methods' ); ?></p>
			<form action="options.php" method="post">
				<?php settings_fields( 'coupon_payment_methods_settings' ); ?>
				<table class="form-table" role="presentation"><tbody>
					<tr>
						<th scope="row"><label for="coupon_payment_methods_error_message"><?php echo esc_html__( 'Payment method restriction error message', 'coupon-payment-methods' ); ?></label></th>
						<td>
							<textarea id="coupon_payment_methods_error_message" name="<?php echo esc_attr( Coupon_Payment_Methods::ERROR_MESSAGE_OPTION ); ?>" rows="3" class="large-text"><?php echo esc_textarea( $message ); ?></textarea>
							<p class="description"><?php echo esc_html( sprintf( __( 'Default message: “%s”', 'coupon-payment-methods' ), $default_message ) ); ?></p>
						</td>
					</tr>
				</tbody></table>
				<?php submit_button( __( 'Save changes', 'coupon-payment-methods' ) ); ?>
			</form>
			<hr />
			<p><?php echo esc_html__( 'Repository:', 'coupon-payment-methods' ); ?> <a href="https://github.com/search?q=coupon-payment-methods&amp;type=repositories" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Search GitHub', 'coupon-payment-methods' ); ?></a> (<?php echo esc_html__( 'temporary link until the official repository is published', 'coupon-payment-methods' ); ?>).</p>
		</div>
		<?php
	}

	public static function enqueue_admin_styles( $hook ) {
		$is_coupon_editor = in_array( $hook, array( 'post.php', 'post-new.php' ), true ) &&
			function_exists( 'get_current_screen' ) &&
			get_current_screen() && 'shop_coupon' === get_current_screen()->post_type;
		$is_settings_page = 'woocommerce_page_' . Coupon_Payment_Methods::PAGE_SLUG === $hook;

		if ( $is_coupon_editor || $is_settings_page ) {
			wp_enqueue_style(
				'coupon-payment-methods-admin',
				plugin_dir_url( COUPON_PAYMENT_METHODS_FILE ) . 'assets/css/admin.css',
				array(),
				COUPON_PAYMENT_METHODS_VERSION
			);
		}
	}

	public static function add_settings_link( $links ) {
		$url  = admin_url( 'admin.php?page=' . Coupon_Payment_Methods::PAGE_SLUG );
		$link = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'coupon-payment-methods' ) . '</a>';
		array_unshift( $links, $link );
		return $links;
	}

	private static function get_gateways() {
		if ( ! function_exists( 'WC' ) || ! WC()->payment_gateways() ) {
			return array();
		}

		return WC()->payment_gateways()->payment_gateways();
	}

	private static function contains_gateway_id( $gateway_ids, $needle ) {
		$needle = strtolower( (string) $needle );
		foreach ( $gateway_ids as $gateway_id ) {
			if ( $needle === strtolower( (string) $gateway_id ) ) {
				return true;
			}
		}
		return false;
	}
}
