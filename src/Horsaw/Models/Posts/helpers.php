<?php
/**
 * Returns a Model object for the given Post ID.
 *
 * @param int    $post_id
 * @param string $model
 *
 * @return Horsaw\Models\Posts\BaseModel
 */
function horsaw_get_post($post_id = null, $model = null) {
	if ( is_null( $post_id ) ) {
		$post_id = get_the_id();
	}

	// Invalid
	if ( empty( $post_id ) ) {
		return false;
	}
}