<?php
/**
 * Renders the passed fragment.
 *
 * @param string $fragment_path
 * @param array  $params
 *
 * @return void
 */
function horsaw_fragment( $fragment_path, $params = [] ) {
	$fragment_full_path = get_template_directory() . '/fragments/' . $fragment_path . '.php';

	if ( file_exists( $fragment_full_path ) ) {
		extract( $params );
		include_once $fragment_full_path;
	}
}

/**
 * Returns the config value for the given option.
 *
 * @param string $config
 *
 * @return mixed
 */
function horsaw_config( $name ) {
	$name = explode( '.', $name );

	$config_file_path = get_template_directory() . '/config/' . $name[0] . '.php';
	$config_contents  = require $config_file_path;

	if ( ! isset( $config_contents[ $name[1] ] ) ) {
		return false;
	}

	return $config_contents[ $name[1] ];
}