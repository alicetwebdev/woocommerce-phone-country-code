<?php
require_once ACEWCPCC_PLUGIN_DIR . '/includes/functions.php';
require_once ACEWCPCC_PLUGIN_DIR . '/includes/phone-country-code-functions.php';
require_once ACEWCPCC_PLUGIN_DIR . '/includes/controller.php';

class ACEWCPCC {

	public static function get_option( $name, $default = false ) {
		$option = get_option( 'acewcpcc' );

		if ( false === $option ) {
			return $default;
		}

		if ( isset( $option[$name] ) ) {
			return $option[$name];
		} else {
			return $default;
		}
	}

	public static function update_option( $name, $value ) {
		$option = get_option( 'acewcpcc' );
		$option = ( false === $option ) ? array() : (array) $option;
		$option = array_merge( $option, array( $name => $value ) );
		update_option( 'acewcpcc', $option );
	}
}

add_action( 'plugins_loaded', 'acewcpcc', 10, 0 );

function acewcpcc() {

	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action(
			'admin_notices',
			function() {
				echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'WooCommerce Phone Country Code requires the WooCommerce plugin to be installed and active. You can download %s here.', 'woocommerce-services' ), '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
			}
		);
		return;
	}

	/* WooCommerce Hooks */
    add_action( 'woocommerce_after_checkout_validation', 'acewcpcc_wc_validate_checkout_phone', 10, 2 );
    add_action( 'woocommerce_checkout_create_order', 'acewcpcc_wc_save_order_custom_meta_data', 10, 2 );
    add_action( 'woocommerce_checkout_update_customer', 'acewcpcc_wc_save_checkout_phone', 10, 2 );
}

add_action( 'init', 'acewcpcc_init', 10, 0 );

function acewcpcc_init() {

	do_action( 'acewcpcc_init' );
}

add_action( 'admin_init', 'acewcpcc_upgrade', 10, 0 );

function acewcpcc_upgrade() {
	$old_ver = ACEWCPCC::get_option( 'version', '0' );
	$new_ver = ACEWCPCC_VERSION;

	if ( $old_ver == $new_ver ) {
		return;
	}

	do_action( 'acewcpcc_upgrade', $new_ver, $old_ver );

	ACEWCPCC::update_option( 'version', $new_ver );
}

/* Install and default settings */

add_action( 'activate_' . ACEWCPCC_PLUGIN_BASENAME, 'acewcpcc_install', 10, 0 );

function acewcpcc_install() {
	if ( $opt = get_option( 'acewcpcc' ) ) {
		return;
	}

	acewcpcc_upgrade();
}
