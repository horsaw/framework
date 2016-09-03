<?php

namespace Horsaw;

class Taxonomy {
	public $taxonomy_data = array();
	public $taxonomy = '';
	public $post_types = [  ];
	protected $singular_name = '';
	protected $plural_name = '';

	/**
	 * Constructor.
	 *
	 * @access private
	 * 
	 * @param string $taxonomy
	 * @param string $singular_name
	 * @param string $plural_name
	 */
	private function __construct( $taxonomy, $singular_name, $plural_name ) {
		$this->taxonomy      = $taxonomy;
		$this->singular_name = $singular_name;
		$this->plural_name   = $plural_name;

		// Setup Labels
		$this->setup_labels();

		// Setup Default options
		$this->setup();
	}

	/**
	 * Magic method __set
	 *
	 * @return void
	 */
	public function __call( $name, $value ) {
		$arg_name = str_replace( 'set_', '', $name );

		$this->taxonomy_data[ $arg_name ] = $value[0];

		return $this;
	}

	/**
	 * Registers a new Custom Post Type.
	 *
	 * @static
	 * @access public
	 */
	public static function make( $post_type, $singular_name, $plural_name ) {
		return new self( $post_type, $singular_name, $plural_name );
	}

	/**
	 * Sets the Taxonomy Post Types.
	 *
	 * @access public
	 *
	 * @param array $post_types
	 *
	 * @return $this
	 */
	public function set_post_types( $post_types ) {
		$this->post_types = $post_types;

		return $this;
	}

	/**
	 * Sets the Post Type Labels.
	 *
	 * @access private
	 */
	private function setup_labels() {
		$this->taxonomy_data['labels'] = [
			'name'               => $this->plural_name,
			'singular_name'      => $this->singular_name,
			'menu_name'          => $this->plural_name,
			'name_admin_bar'     => $this->singular_name,
			'add_new'            => __( 'Add New', 'horsaw' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'horsaw' ), $this->singular_name ),
			'new_item'           => sprintf( __( 'New %s', 'horsaw' ), $this->singular_name ),
			'edit_item'          => sprintf( __( 'Edit %s', 'horsaw' ), $this->singular_name ),
			'view_item'          => sprintf( __( 'View %s', 'horsaw' ), $this->singular_name ),
			'all_items'          => sprintf( __( 'All %s', 'horsaw' ), $this->plural_name ),
			'search_items'       => sprintf( __( 'Search %s', 'horsaw' ), $this->plural_name ),
			'parent_item_colon'  => sprintf( __( 'Parent %s', 'horsaw' ), $this->plural_name ),
			'not_found'          => sprintf( __( 'No %s found', 'horsaw' ), strtolower( $this->plural_name ) ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'horsaw' ), strtolower( $this->plural_name ) ),
		];
	}

	/**
	 * Sets the Default Post Type settings.
	 *
	 * @access private
	 */
	private function setup() {
		$this->taxonomy_data = array_merge( $this->taxonomy_data, [
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => str_replace( [ horsaw_config( 'theme.prefix' ), '_' ], [ '', '-' ], $this->taxonomy ) ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'thumbnail' ],
		] );
	}
}