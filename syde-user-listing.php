<?php
/**
 * Plugin Name: Syde User Listing
 * Plugin URI: https://github.com/HILAYTRIVEDI/syde-user-listing
 * Description: This Plugin will list the dummy data of users
 * Version: 1.0.0
 * Author: HILAYTRIVEDI
 * Author URI: https://github.com/HILAYTRIVEDI
 * License: GPL-3.0-or-later
 * Text Domain: syde-user-listing
 * 
 * @package SydeUserListing
 */

//  Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Declare plugin constants.
if( ! defined( 'SYDE_USER_LISTING_VERSION' ) ) {
	define( 'SYDE_USER_LISTING_VERSION', '1.0.0' );
}

if( ! defined( 'SYDE_USER_LISTING_PLUGIN_DIR' ) ) {
	define( 'SYDE_USER_LISTING_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if( ! defined( 'SYDE_USER_LISTING_PLUGIN_URL' ) ) {
	define( 'SYDE_USER_LISTING_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Autoload the plugin.
 * 
 * @return bool
 * 
 * @since 1.0.0
 */
function autoload():bool{
	static $loaded;

	if (wp_validate_boolean($loaded)) {
		return $loaded;
	}

	$autoload_file = SYDE_USER_LISTING_PLUGIN_DIR . '/vendor/autoload.php';

	if (file_exists($autoload_file) && is_readable($autoload_file)) {
		require_once $autoload_file;
		$loaded = true;
		return $loaded;
	}

	$loaded = false;
	return $loaded;
}

if( ! autoload() ) {
	return;
}

//  Initilize the plugin.
use Syde\SydeUserListing\Plugin;

Plugin::init();