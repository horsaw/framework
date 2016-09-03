<?php

namespace Horsaw\Assets;

class Style extends Asset {
	/**
	 * Script Dependencies.
	 *
	 * @var array
	 */
	protected $dependencies = [];

	/**
	 * Registers a new style.
	 *
	 * @access public
	 *
	 * @param string $handle
	 * @param string $location
	 *
	 * @return \Horsaw\Assets\Style
	 */
	public function init() {
		if ( $this->enqueue ) {
			wp_enqueue_style( $this->handle, $this->get_location(), $this->dependencies, $this->get_version(), 'all' );
		} else {
			wp_register_style( $this->handle, $this->get_location(), $this->dependencies, $this->get_version(), 'all' );
		}
	}
}