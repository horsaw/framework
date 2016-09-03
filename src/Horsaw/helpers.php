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