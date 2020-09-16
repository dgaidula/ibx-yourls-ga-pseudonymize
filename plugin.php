<?php
/*
Plugin Name: GA Pseudonymize Plugin
Plugin URI: https://github.com/dgaidula/ibx-yourls-ga-pseudonymize
Description: Pseudonymize IP addresses using GA method. Remove last segment of ipv4 and last 80-bits of ipv6.
Version: 1.0
Author: D Gaidula
Author URI: https://gaidula.com/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

function ipv4_anon_grep($value) {
	return preg_replace('/((?:\d{1,3}\.){3})\d{1,3}/','${1}0', $value);
}
function ipv6_anon_grep($value) {
	return preg_replace('/((?:[0-9a-fA-F]{1,4}\:){3})(?:[0-9a-fA-F]{1,4}\:){4}[0-9a-fA-F]{1,4}/','${1}0:0:0:0:0', $value);
}

yourls_add_filter( 'get_IP', 'ibx_ga_pseudonymize_IP' );

function ibx_ga_pseudonymize_IP ( $value ) {
    if( str_contains($value, '.') ){
		return ipv4_anon_grep($value);
    }
    if (str_contains($value, ':')) {
		return ipv6_anon_grep($value);
    }
	return $value;
}


?>
