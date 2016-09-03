<?php

namespace Horsaw\Theme;

use Horsaw\Helpers\Post_Type;
use Horsaw\Helpers\Taxonomy;

class App {
	/**
	 * The App instance.
	 *
	 * @var Horsaw\Theme\App
	 */
	protected static $instance = null;

	/**
	 * Theme absolute path.
	 *
	 * @var string
	 */
	protected $theme_path = '';

	/**
	 * Constructor.
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function __construct() {
		$this->theme_path = get_template_directory() . '/';
	}

	/**
	 * Returns the main instance of the Application.
	 *
	 * @static
	 * @access public
	 *
	 * @return \Horsaw\Theme\App
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Initializes the theme hooks.
	 *
	 * @access public
	 *
	 * @return voida
	 */
	public function init() {
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );

		add_action( 'init', array( $this, 'register_custom_post_types' ) );
		add_action( 'init', array( $this, 'register_custom_taxonomies' ) );
	}

	/**
	 * Setups the Theme.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function setup_theme() {
		/*
		|--------------------------------------------------------------------------
		| Theme Supports
		|--------------------------------------------------------------------------
		*/
		$features = horsaw_config( 'theme.supports' );
		if ( $features ) {
			foreach ( $features as $feature ) {
				add_theme_support( $feature );
			}
		}

		/*
		|--------------------------------------------------------------------------
		| Theme Option Files
		|--------------------------------------------------------------------------
		|
		| Here, we load all custom option files like: widgets, shortcodes, post-types,
		| taxonomies, etc.
		|
		*/

		$files = apply_filters( 'horsaw_theme_option_files', [
			'options/shortcodes.php',
			'options/widgets.php',
			'options/post-types.php',
			'options/taxonomies.php',
		] );

		// Load 
		foreach ( $files as $file ) {
			if ( file_exists( $this->theme_path . $file ) ) {
				require_once $this->theme_path . $file;
			}
		}
	}

	/**
	 * Registers Custom Post Types.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function register_custom_post_types() {
		// Register Custom Post Types
		Post_Type::register();
	}

	/**
	 * Registers Custom Taxonomies.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function register_custom_taxonomies() {
		// Register Custom Taxonomies
		Taxonomy::register();
	}
}