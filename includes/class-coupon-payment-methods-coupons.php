<?php
/** Enforce coupon payment-method restrictions during checkout. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Coupon_Payment_Methods_Coupons {
	const RESTRICT_META = '_coupon_payment_methods_restrict_gateways';
	const GATEWAYS_META = '_coupon_payment_methods_allowed_gateways';

	public static function init() {
		add_filter( 'woocommerce_coupon_is_valid', array( __CLASS__, 'validate_coupon_gateway' ), 10, 3 );
		add_filter( 'woocommerce_coupon_error', array( __CLASS__, 'filter_coupon_error' ), 10, 3 );
		add_action( 'woocommerce_after_calculate_totals', array( __CLASS__, 'notify_disallowed_applied_coupons' ), 20, 1 );
	}

	public static function validate_coupon_gateway( $valid, $coupon, $discounts = null ) {
		if ( ! $valid || ! $coupon instanceof WC_Coupon ) {
			return $valid;
		}

		return self::is_gateway_disallowed( $coupon ) ? false : $valid;
	}

	public static function filter_coupon_error( $message, $error_code, $coupon ) {
		if ( defined( 'WC_Coupon::E_WC_COUPON_INVALID_FILTERED' ) &&
			WC_Coupon::E_WC_COUPON_INVALID_FILTERED === (int) $error_code &&
			$coupon instanceof WC_Coupon && self::is_gateway_disallowed( $coupon ) ) {
			return self::get_error_message();
		}

		return $message;
	}

	public static function notify_disallowed_applied_coupons( $cart ) {
		if ( ! $cart instanceof WC_Cart || ! function_exists( 'wc_add_notice' ) || ! function_exists( 'wc_has_notice' ) ) {
			return;
		}

		foreach ( $cart->get_coupons() as $coupon ) {
			if ( self::is_gateway_disallowed( $coupon ) ) {
				$message = self::get_error_message();
				if ( ! wc_has_notice( $message, 'error' ) ) {
					wc_add_notice( $message, 'error' );
				}
			}
		}
	}

	private static function is_gateway_disallowed( $coupon ) {
		if ( ! $coupon instanceof WC_Coupon || 'yes' !== get_post_meta( $coupon->get_id(), self::RESTRICT_META, true ) ) {
			return false;
		}

		$allowed = get_post_meta( $coupon->get_id(), self::GATEWAYS_META, true );
		$allowed = is_array( $allowed ) ? $allowed : array();
		$chosen  = '';

		if ( isset( $_POST['payment_method'] ) ) {
			$chosen = sanitize_text_field( wp_unslash( $_POST['payment_method'] ) );
		}
		if ( ! $chosen && function_exists( 'WC' ) && WC()->session ) {
			$chosen = (string) WC()->session->get( 'chosen_payment_method', '' );
		}
		if ( '' === $chosen ) {
			return false;
		}

		return ! self::contains_gateway_id( $allowed, $chosen );
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

	private static function get_error_message() {
		$default = __( Coupon_Payment_Methods::DEFAULT_ERROR, 'coupon-payment-methods' );
		$message = get_option( Coupon_Payment_Methods::ERROR_MESSAGE_OPTION, $default );
		return is_string( $message ) && '' !== trim( $message ) ? $message : $default;
	}
}
