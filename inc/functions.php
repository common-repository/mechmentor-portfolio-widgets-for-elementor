<?php
/**
 * Mech Portfolio Functions
 *
 * @package Mechlin Portfolio
 */


/**
 * Load Template Part
 */
if( ! function_exists( 'mpt_load_template' ) ) {
	function mpt_load_template( $slug, $name = '', $settings = array() ){
		$GLOBALS['Mechlin_Portfolio']->load_template( $slug, $name, $settings );
	}
}