<?php

function acewcpcc_plugin_path( $path = '' ) {
	return path_join( ACEWCPCC_PLUGIN_DIR, trim( $path, '/' ) );
}

function acewcpcc_plugin_url( $path = '' ) {
	$url = plugins_url( $path, ACEWCPCC_PLUGIN );

	if ( is_ssl()
	and 'http:' == substr( $url, 0, 5 ) ) {
		$url = 'https:' . substr( $url, 5 );
	}

	return $url;
}

function acewcpcc_load_js() {
	return apply_filters( 'acewcpcc_load_js', ACEWCPCC_LOAD_JS );
}

function acewcpcc_load_css() {
	return apply_filters( 'acewcpcc_load_css', ACEWCPCC_LOAD_CSS );
}

function acewcpcc_get_request_uri() {
	static $request_uri = '';

	if ( empty( $request_uri ) ) {
		$request_uri = add_query_arg( array() );
	}

	return esc_url_raw( $request_uri );
}