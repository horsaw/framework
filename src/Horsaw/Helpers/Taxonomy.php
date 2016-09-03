<?php

namespace Horsaw\Helpers;

use Horsaw\Taxonomy as Base_Taxonomy;

final class Taxonomy {
	public static $taxonomies = [];

	/**
	 * Creates a new Taxonomy object.
	 *
	 * @access public
	 * @static
	 * 
	 * @param string $taxonomy
	 * @param string $singular_name
	 * @param string $plural_name
	 *
	 * @return \Nes\taxonomy
	 */
	public static function make( $taxonomy, $singular_name, $plural_name ) {
		$taxonomy_object = Base_Taxonomy::make( $taxonomy, $singular_name, $plural_name );

		self::$taxonomies[] = $taxonomy_object;

		return $taxonomy_object;
	}

	/**
	 * Registers all Custom Post Types.
	 *
	 * @access public
	 * @static
	 *
	 * @return array
	 */
	public static function register() {
		foreach ( self::$taxonomies as $taxonomy ) {
			register_taxonomy( $taxonomy->taxonomy, $taxonomy->taxonomy_data );
		}
	}
}