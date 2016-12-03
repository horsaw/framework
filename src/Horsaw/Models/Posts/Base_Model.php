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
	 * Constructor.
	 *
	 * @access public
	 *
	 * @param int
	 *
	 * @return \Horsaw\Models\Posts\Base_Model
	 */
	public function __construct( $post_id ) {
		$this->ID      = absint( $post_id );
		$this->wp_post = get_post( $post_id );
	}

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

	public function __get( $name ) {
		// WP Post Data
		if ( property_exists( $this->wp_post, $name ) ) {
			return $this->wp_post->$name;
		}

		// Meta Data
		if ( array_key_exists( $name, $this->metas ) ) {
			return call_user_func_array( [ $this, 'get_meta' ], explode( ':', $this->metas[ $name ] ) );
		}

		return false;
	}

	/**
	 * Returns an instance of the Model.
	 *
	 * @access public
	 * @static
	 *
	 * @param int $the_post Post ID
	 *
	 * @return \Horsaw\Models\Posts\Base_Model
	 */
	public static function get( $the_post ) {
		try {
			$object = new static( $the_post );

			return $object;
		} catch ( Exception $e ) {
			return false;
		}
	}

	public function get_meta( $meta_key, $meta_type = null ) {
		return carbon_get_post_meta( $this->ID, $meta_key, $meta_type );
	}
}