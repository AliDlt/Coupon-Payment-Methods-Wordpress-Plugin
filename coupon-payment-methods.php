<?php
/**
 * Plugin Name: Coupon Payment Methods
 * Plugin URI: https://github.com/search?q=coupon-payment-methods&type=repositories
 * Description: Choose eligible payment methods for each coupon and customize the notice shown for an ineligible payment method.
 * Version: 1.4.0
 * Author: علی دولت آبادی
 * Text Domain: coupon-payment-methods
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'COUPON_PAYMENT_METHODS_VERSION', '1.4.0' );
define( 'COUPON_PAYMENT_METHODS_FILE', __FILE__ );
define( 'COUPON_PAYMENT_METHODS_PATH', plugin_dir_path( __FILE__ ) );

require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods.php';
require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods-admin.php';
require_once COUPON_PAYMENT_METHODS_PATH . 'includes/class-coupon-payment-methods-coupons.php';

add_action( 'plugins_loaded', array( 'Coupon_Payment_Methods', 'init' ), 20 );
