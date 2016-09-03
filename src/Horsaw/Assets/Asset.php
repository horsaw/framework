<?php

namespace Horsaw\Assets;

use Exception;

abstract class Asset {
	/**
	 * Contains all registered assets.
	 *
	 * @var array
	 */
	public static $assets = [
		'script' => [],
		'style'  => [],
	];

	/**
	 * Handle Name.
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $handle = '';

	/**
	 * Location.
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $location = '';

	/**
	 * Whether the asset should be enqueued.
	 *
	 * @access protected
	 *
	 * @var boolean
	 */
	public $enqueue = false;

	/**
	 * Constructor.
	 *
	 * @access public
	 *
	 * @return \Horsaw\Assets\Asset
	 */
	public function __construct( $handle, $location, $enqueue ) {
		$this->handle   = $handle;
		$this->location = $location;
		$this->enqueue  = $enqueue;
	}

	/**
	 * Registers a new Asset.
	 *
	 * @access public
	 * @static
	 *
	 * @param string $type
	 * @param string $handle
	 * @param string $location
	 *
	 * @return \Horsaw\Assets\Asset
	 */
	public static function register( $type, $handle, $location ) {
		// Check for supported type
		if ( ! in_array( $type, [ 'style', 'script' ] ) ) {
			throw new Exception( sprintf( __( 'Asset type %s doesn\'t exist', 'horsaw' ), $type ) );
		}

		// Check for already existing asset
		if ( isset( self::$assets[ $type ][ $handle ] ) ) {
			throw new Exception( sprintf( __( 'Asset with handle name %s already exists', 'horsaw' ), $handle ) );
		}

		// Instantiate the Asset class
		$asset_class_name = __NAMESPACE__ . '\\' . ucwords( $type );

		$asset = new $asset_class_name( $handle, $location, false );
		self::$assets[ $type ][ $handle ] = $asset;

		return $asset;
	}

	/**
	 * Enqueues a new Asset.
	 *
	 * @access public
	 * @static
	 *
	 * @param string $type
	 * @param string $handle
	 * @param string $location
	 *
	 * @return \Horsaw\Assets\Asset
	 */
	public static function enqueue( $type, $handle, $location ) {
		$asset = self::register( $type, $handle, $location );

		$asset->enqueue = true;

		return $asset;
	}

	/**
	 * Returns the Asset version.
	 *
	 * Use file modified time as version.
	 *
	 * @access protected
	 *
	 * @todo
	 * 
	 * @return string|boolean
	 */
	protected function get_version() {
		if ( preg_match( '~^https?:\/\/~', $this->location ) ) {
			return false;
		}

		$file_location = $this->get_full_path();
		if ( $file_location && file_exists( $file_location ) ) {
			return filemtime( $file_location );
		}

		return false;
	}

	/**
	 * Returns the full path to the asset file.
	 * 
	 * @access public
	 *
	 * @return string|boolean
	 */
	public function get_full_path() {
		if ( preg_match( '~^https?:\/\/~', $this->location ) ) {
			return false;
		}

		return str_replace( home_url( '/' ), ABSPATH, $this->get_location() );
	}

	/**
	 * Returns the full location to the Asset.
	 *
	 * @access public
	 *
	 * @todo
	 *
	 * @return string
	 */
	public function get_location() {
		if ( preg_match( '~^https?:\/\/~', $this->location ) ) {
			return $this->location;
		}

		return get_template_directory_uri() . '/resources/assets/' . $this->location;
	}
}