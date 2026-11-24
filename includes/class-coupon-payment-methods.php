<?php
/** Plugin bootstrap and shared settings. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Coupon_Payment_Methods {
	const PAGE_SLUG            = 'coupon-payment-methods';
	const ERROR_MESSAGE_OPTION = 'coupon_payment_methods_error_message';
	const DEFAULT_ERROR       = 'این کد تخفیف فقط برای پرداخت نقدی معتبر می‌باشد.';

	public static function init() {
		Coupon_Payment_Methods_Admin::init();
		Coupon_Payment_Methods_Coupons::init();
	}
}
