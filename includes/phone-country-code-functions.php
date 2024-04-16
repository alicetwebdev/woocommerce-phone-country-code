<?php

function acewcpcc_wc_validate_checkout_phone( $fields, $errors ) {
 
	$post_contactNo = isset($_POST['billing_phone']) ? sanitize_text_field( $_POST['billing_phone'] ) : '';
	
	$post_phoneHasError = isset($_POST['phoneHasError']) ? sanitize_text_field( $_POST['phoneHasError'] ) : '';

	$post_contactNo = str_replace(" ", "", $post_contactNo);
	$post_contactNo = filter_var($post_contactNo, FILTER_SANITIZE_NUMBER_INT);

	$post_contactNo_clear = str_replace("-", "", $post_contactNo);
	$post_contactNo_clear = str_replace("+", "", $post_contactNo_clear);
	if( !(filter_var($post_contactNo, FILTER_SANITIZE_NUMBER_INT) && strlen($post_contactNo_clear) >= 5 && strlen($post_contactNo_clear) <= 20) || $post_phoneHasError == '1' ) {
        $errors->add( 'validation', __('<b>Billing Phone</b> is not valid', ACEWCPCC_TEXT_DOMAIN) );
    }
}

function acewcpcc_wc_save_order_custom_meta_data( $order, $data ) {
	
	$post_contactNo = isset($_POST['contactNo']) ? sanitize_text_field( $_POST['contactNo'] ) : '';
	
    if( isset($_POST['countryCode']) && ! empty($_POST['countryCode']) ) {
		$order->set_billing_phone( $post_contactNo );
    }
	
    if( isset($_POST['countryCode']) && ! empty($_POST['countryCode']) ) {
        $order->update_meta_data( '_billing_phone_country_code', esc_attr( $_POST['countryCode'] ) );
    }
	
    if( isset($_POST['dialCode']) && ! empty($_POST['dialCode']) ) {
        $order->update_meta_data( '_billing_phone_dial_code', esc_attr( $_POST['dialCode'] ) );
    }
	
    if( isset($_POST['phoneCountry']) && ! empty($_POST['phoneCountry']) ) {
        $order->update_meta_data( '_billing_phone_country_name', esc_attr( $_POST['phoneCountry'] ) );
    }
}

function acewcpcc_wc_save_checkout_phone( $customer, $data ) {
	
	$post_phoneCountryCode = isset($_POST['countryCode']) ? sanitize_text_field( wp_unslash ($_POST['countryCode']) ) : '';
	$post_dialCode = isset($_POST['dialCode']) ? sanitize_text_field( wp_unslash ($_POST['dialCode']) ) : '';
	$post_phoneCountry = isset($_POST['phoneCountry']) ? sanitize_text_field( wp_unslash ($_POST['phoneCountry']) ) : '';
	$post_contactNo = isset($_POST['contactNo']) ? sanitize_text_field( $_POST['contactNo'] ) : '';

	$post_contactNo = str_replace(" ", "", $post_contactNo);
	$post_contactNo = filter_var($post_contactNo, FILTER_SANITIZE_NUMBER_INT);
	
	$billing_phone = $_POST['billing_phone'];
	
	// Check if billing_phone has country code in front?
	
    if( preg_match('/^\+' . $post_phoneCountryCode . '/', $post_contactNo) === false ) {
		$billing_phone = '+' . $post_phoneCountryCode . $billing_phone;
		$customer->update_meta_data( 'billing_phone', esc_attr( $billing_phone ) );
	}
	
    if ( isset($_POST['countryCode']) && ! empty($_POST['countryCode']) ) {
        $customer->update_meta_data( 'billing_phone_country_code', $post_phoneCountryCode );
    }
	
	if ( isset($_POST['dialCode']) && ! empty($_POST['dialCode']) ) {
        $customer->update_meta_data( 'billing_phone_dial_code', $post_dialCode );
    }
	
	if ( isset($_POST['phoneCountry']) && ! empty($_POST['phoneCountry']) ) {
        $customer->update_meta_data( 'billing_phone_country_name', $post_phoneCountry );
    }
}