<?php

namespace Horsaw\Models\Posts;

abstract class Base_Model {
	/**
	 * The Post ID.
	 *
	 * @var int
	 */
	protected $ID = 0;

	/**
	 * The associated WP_Post object.
	 *
	 * @var \WP_Post
	 */
	protected $wp_post = null;

	/**
	 * Associated Meta.
	 *
	 * @var array
	 */
	protected $metas = [];

	/**
	 * Handle for magic methods.
	 *
	 * @access public
	 *
	 * @param string $name
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __call($name, $params = []) {
		// Post ID
		if ( in_array( $name, ['id', 'ID'] ) ) {
			return $this->ID;
		}

		// WP Post
		if ( $name === 'wp_post' ) {
			return $this->wp_post;
		}

		// WP Post property
		if ( property_exists( $this->wp_post, $name ) ) {
			return $this->wp_post->$name;
		}

		// Post Meta
		if ( isset( $this->metas[ $name ] ) ) {
			$meta_key = $this->metas[ $name ];

			return call_user_func_array( [ $this, 'get_meta' ], explode( ':', $meta_key ) );
		}

		// Otherwise
		return false;
	}
}