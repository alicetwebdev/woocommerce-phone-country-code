<?php
/**
 * Plugin Name: WooCommerce Phone Country Code
 * Description: Add country code to phone field of WooCommerce
 * Author: Alice T
 * Text Domain: ace-wc-phone-country-code
 * Domain Path: /languages/
 * Version: 1.0.0
 */

define( 'ACEWCPCC_VERSION', '1.0.0' );

define( 'ACEWCPCC_REQUIRED_WP_VERSION', '5.5' );

define( 'ACEWCPCC_TEXT_DOMAIN', 'ace-wc-phone-country-code' );

define( 'ACEWCPCC_PLUGIN', __FILE__ );

define( 'ACEWCPCC_PLUGIN_BASENAME', plugin_basename( ACEWCPCC_PLUGIN ) );

define( 'ACEWCPCC_PLUGIN_NAME', trim( dirname( ACEWCPCC_PLUGIN_BASENAME ), '/' ) );

define( 'ACEWCPCC_PLUGIN_DIR', untrailingslashit( dirname( ACEWCPCC_PLUGIN ) ) );

if ( ! defined( 'ACEWCPCC_LOAD_JS' ) ) {
	define( 'ACEWCPCC_LOAD_JS', true );
}

if ( ! defined( 'ACEWCPCC_LOAD_CSS' ) ) {
	define( 'ACEWCPCC_LOAD_CSS', true );
}

require_once ACEWCPCC_PLUGIN_DIR . '/load.php';