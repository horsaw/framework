<?php

namespace Horsaw\Assets;

class Script extends Asset {
	/**
	 * Whether the Script should be loaded in footer.
	 *
	 * @var boolean
	 */
	protected $in_footer = true;

	/**
	 * Script Localization.
	 *
	 * @var array
	 */
	protected $localization = [];

	/**
	 * Script Dependencies.
	 *
	 * @var array
	 */
	protected $dependencies = [];

	/**
	 * Registers a new script.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function init() {
		if ( $this->enqueue ) {
			wp_enqueue_script( $this->handle, $this->get_location(), $this->dependencies, $this->get_version(), $this->in_footer );
		} else {
			wp_register_script( $this->handle, $this->get_location(), $this->dependencies, $this->get_version(), $this->in_footer );
		}

		// Register Localization
		if ( ! empty( $this->localization ) ) {
			foreach ( $this->localization as $object_name => $l10n ) {
				wp_localize_script( $this->handle, $object_name, $l10n );
			}
		}
	}

	public function with( $object_name, $localization = [] ) {
		$this->localization[ $object_name ] = $localization;

		return $this;
	}

	public function depends_on( $dependencies = [] ) {
		$this->dependencies = $dependencies;

		return $this;
	}
}