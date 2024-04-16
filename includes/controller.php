<?php
/**
 * Controller for front-end requests, scripts, and styles
 */


/**
 * Registers main scripts and styles.
 */
add_action(
	'wp_enqueue_scripts',
	function () {

		wp_register_script(
			'ace-woocommerce-phone-country-code',
			acewcpcc_plugin_url( 'includes/js/index.js' ),
			array( 'jquery' ),
			ACEWCPCC_VERSION,
			( 'header' !== acewcpcc_load_js() )
		);

		wp_register_script(
			'ace-intl-tel-input',
			acewcpcc_plugin_url( 'includes/js/intl-tel-input/intlTelInput.min.js' ),
			array( 'jquery' ),
			ACEWCPCC_VERSION,
			true
		);

		wp_register_script(
			'ace-intl-tel-input-utils',
			acewcpcc_plugin_url( 'includes/js/intl-tel-input/utils.min.js' ),
			array( 'jquery' ),
			ACEWCPCC_VERSION,
			true
		);

		if ( acewcpcc_load_js() ) {
			acewcpcc_enqueue_scripts();
		}

		wp_register_style(
			'ace-woocommerce-phone-country-code',
			acewcpcc_plugin_url( 'includes/css/styles.css' ),
			array(),
			ACEWCPCC_VERSION,
			'all'
		);

		wp_register_style(
			'ace-intl-tel-input-styles',
			acewcpcc_plugin_url( 'includes/css/intl-tel-input/intlTelInput.css' ),
			array(),
			ACEWCPCC_VERSION,
			'all'
		);

		if ( acewcpcc_load_css() ) {
			acewcpcc_enqueue_styles();
		}
	},
	10, 0
);


/**
 * Enqueues scripts.
 */
function acewcpcc_enqueue_scripts() {
    
    if ( is_checkout() && empty( get_query_var('order-pay') ) && null === get_query_var('order-received') ) {
    	wp_enqueue_script( 'ace-woocommerce-phone-country-code' );
    	wp_enqueue_script( 'ace-intl-tel-input' );
    	wp_enqueue_script( 'ace-intl-tel-input-utils' );

        $acewcpcc = array(
            'utilsScriptUrl' => './intl-tel-input/utils.min.js',
        );

        wp_localize_script( 'ace-woocommerce-phone-country-code', 'acewcpcc', $acewcpcc );

        do_action( 'acewcpcc_enqueue_scripts' );
    }
}


/**
 * Enqueues styles.
 */
function acewcpcc_enqueue_styles() {
    
    if ( is_checkout() && empty( get_query_var('order-pay') ) && null === get_query_var('order-received') ) {
    	wp_enqueue_style( 'ace-woocommerce-phone-country-code' );
    	wp_enqueue_style( 'ace-intl-tel-input-styles' );
    }

	do_action( 'acewcpcc_enqueue_styles' );
}