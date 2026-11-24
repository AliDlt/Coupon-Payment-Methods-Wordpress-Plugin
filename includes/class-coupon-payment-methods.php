<?php
/** Plugin bootstrap and shared settings. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Coupon_Payment_Methods {
	const PAGE_SLUG            = 'coupon-payment-methods';
	const ERROR_MESSAGE_OPTION = 'coupon_payment_methods_error_message';
	const DEFAULT_ERROR        = 'This coupon is only valid for cash payments.';

	public static function init() {
		load_plugin_textdomain(
			'coupon-payment-methods',
			false,
			dirname( plugin_basename( COUPON_PAYMENT_METHODS_FILE ) ) . '/languages'
		);

		Coupon_Payment_Methods_Admin::init();
		Coupon_Payment_Methods_Coupons::init();
	}
}
