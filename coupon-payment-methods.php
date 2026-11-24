<?php
/**
 * Plugin Name: محدودیت روش پرداخت کد تخفیف ووکامرس
 * Plugin URI: https://github.com/search?q=coupon-payment-methods&type=repositories
 * Description: روش‌های پرداخت مجاز هر کد تخفیف را تعیین کنید و متن پیام روش پرداخت نامجاز را سفارشی کنید.
 * Version: 1.3.0
 * Author: علی دولت آبادی
 * Text Domain: coupon-payment-methods
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'COUPON_PAYMENT_METHODS_VERSION', '1.3.0' );
define( 'COUPON_PAYMENT_METHODS_FILE', __FILE__ );
define( 'COUPON_PAYMENT_METHODS_PATH', plugin_dir_path( __FILE__ ) );

require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods.php';
require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods-admin.php';
require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods-coupons.php';

add_action( 'plugins_loaded', array( 'Coupon_Payment_Methods', 'init' ), 20 );
