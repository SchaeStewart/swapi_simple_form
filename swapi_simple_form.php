<?php
/*
Plugin Name: SWAPI Simple Form
Plugin URI: https://schaffer.tech
Description: A simple form interacting with the Star Wars API for learning purposes
Version: 1.0
Author: Schaffer Stewart
Author URI: https://schaffer.tech
 */

function swapi_form_code() {
	echo '<form action ="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
	echo '<p>';
	echo 'Name of Character (required) <br />';
	echo '<input type="text" name="swapi-name" value="' . ( isset( $_POST["swapi-name"] ) ? esc_attr( $_POST["swapi-name"] ) : '' ) . '" size="40" />';
	echo '</p>';
	echo '<p><input type="submit" name="swapi-submitted" value="Send"/></p>';
	echo '</form>';
}

function swapi_name_search() {
	$root_url = 'http://swapi.co/api/people/?search=';
	if ( isset( $_POST['swapi-submitted'] ) ) {

		$name          = sanitize_text_field( $_POST["swapi-name"] );
		$request_url   = esc_url_raw( $root_url . $name );
		$response      = wp_remote_get( $request_url );
		$json_response = json_decode( wp_remote_retrieve_body( $response ), true );
		swapi_display_results( $json_response );
	}

}

function swapi_display_results( $response ) {
	$root_object = $response['results'][0];
	$person      = array(
		'name'       => $root_object['name'],
		'height'     => $root_object['height'],
		'mass'       => $root_object['mass'],
		'hair color' => $root_object['hair_color'],
		'skin color' => $root_object['skin_color'],
		'birth year' => $root_object['birth_year'],
		'gender'     => $root_object['gender'],
	);
	echo '<ul>';
	foreach ( $person as $key => $value ) {
		echo '<li>';
		echo ucfirst( $key ) . ": " . esc_attr( $value ) . " <br />\n";
		echo '</li>';
	}
	echo '</ul>';
}

function swapi_shortcode() {
	ob_start();
	swapi_form_code();
	swapi_name_search();

	return ob_get_clean();
}

add_shortcode( 'swapi_name_search', 'swapi_shortcode' );

?>
