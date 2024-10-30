<?php
/**
 * Plugin Name: Mechlin Portfolio Widgets For Elementor
 * Plugin URI: https://mechlintech.com
 * Description: Mechmentor Portfolio Addon plugin offers a Portfolio Grid Widget for Elementor page builder.
 * Version: 1.0.0
 * Author: Mechlin
 * Author URI: https://www.mechlintech.com
 * Text Domain: mechlin-portfolio
 * Domain Path: /languages/
 *
 * @package Mechlin Portfolio
 */

defined( 'ABSPATH' ) || exit;


// Define MPT_FILE.
if ( ! defined( 'MPT_FILE' ) ) {
	define( 'MPT_FILE', __FILE__ );
}

// Include the main Mechlin_Portfolio class.
if ( ! class_exists( 'Mechlin_Portfolio' ) ) {
	include_once dirname( __FILE__ ) . '/inc/class-init.php';
}

/**
 * Returns the main instance of Mechlin_Portfolio.
 *
 * @return Mechlin_Portfolio
 */
function Mechlin_Portfolio() { 
	return Mechlin_Portfolio::instance();
}

// Global for backwards compatibility.
$GLOBALS['Mechlin_Portfolio'] = Mechlin_Portfolio();
