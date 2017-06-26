<?php

add_action( 'admin_menu', 'swapi_admin_menu' );
function swapi_admin_menu() {
	add_options_page( 'SWAPI Simple Form', 'SWAPI Simple Form', 'manage_options', 'swapi-simple-form', 'swapi_options_page' );
}

add_action( 'admin_init', 'swapi_admin_init' );
function swapi_admin_init() {
	register_setting( 'swapi-error-messages-group', 'swapi-not-found-message' );
	add_settings_section( 'swapi_error_messages_section', 'Error Messages', 'swapi_error_messages_section', 'swapi-settings' );
	add_settings_field( 'swapi-not-found-message-field', 'Not Found Message', 'swapi_not_found_field', 'swapi-settings', 'swapi_error_messages_section' );
}

function swapi_error_messages_section() {
	echo 'text goes here';
}

function swapi_not_found_field() {
	$setting = esc_attr( get_option( 'swapi-not-found-message' ) );
	echo "<input type='text' name='swapi-not-found-message' value='$setting' />";
}

function swapi_options_page() {
	?>
	<div class="wrap">
		<h2>SWAPI Simple Form Options</h2>
		<form action="options.php" method="POST">
			<?php settings_fields('swapi-error-messages-group'); ?>
			<?php do_settings_sections('swapi-settings'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

function swapi_sanitize_error_message( $input) {
	return sanitize_text_field($input);
}
