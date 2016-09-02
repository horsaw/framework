<?php

namespace Horsaw\Traits;

trait Carbon_Fields_Post_Meta {
	/**
	 * Returns the value for the given meta.
	 *
	 * @access public
	 *
	 * @param string $meta_key
	 * @param string $meta_type
	 *
	 * @return mixed
	 */
	public function get_meta($meta_key, $meta_type = null) {
		return call_user_func_array( 'carbon_get_post_meta', [ $this->ID, $meta_key, $meta_type ] );
	}
}