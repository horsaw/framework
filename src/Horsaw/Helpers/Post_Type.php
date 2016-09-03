<?php

namespace Horsaw\Helpers;

use Horsaw\Post_Type as Base_Post_Type;

final class Post_Type {
	public static $post_types = [];

	/**
	 * Creates a new Post Type object.
	 *
	 * @access public
	 * @static
	 * 
	 * @param string $post_type
	 * @param string $singular_name
	 * @param string $plural_name
	 *
	 * @return \Nes\Post_Type
	 */
	public static function make( $post_type, $singular_name, $plural_name ) {
		$post_type_object = Base_Post_Type::make( $post_type, $singular_name, $plural_name );

		self::$post_types[] = $post_type_object;

		return $post_type_object;
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
		foreach ( self::$post_types as $post_type ) {
			register_post_type( $post_type->post_type, $post_type->post_type_data );
		}
	}
}