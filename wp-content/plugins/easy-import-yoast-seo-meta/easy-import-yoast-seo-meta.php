<?php
/**
 * Plugin Name: Easy Import Yoast SEO Meta Using CSV
 * Plugin URL: https://wordpress.org/plugin-url/
 * Description: Easy import yoast meta using csv file.
 * Version: 1.0
 * Author: ZealousWeb
 * Author URI: https://www.plugin-author-url.com
 * Developer: Zealousweb Technology
 * Developer E-Mail: opensource@zealousweb.com
 * Text Domain: easy-import-yoast-seo-meta
 * Domain Path: /languages
 *
 * Copyright: © 2009-2021 Zealousweb.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 *
 * @package Plugin name
 * @since 1.0
 */

if ( !defined( 'EIYSM_VERSION' ) ) {
	define( 'EIYSM_VERSION', '1.0' ); // Version of plugin
}

if ( !defined( 'EIYSM_FILE' ) ) {
	define( 'EIYSM_FILE', __FILE__ ); // Plugin File
}

if ( !defined( 'EIYSM_DIR' ) ) {
	define( 'EIYSM_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if ( !defined( 'EIYSM_URL' ) ) {
	define( 'EIYSM_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if ( !defined( 'EIYSM_PLUGIN_BASENAME' ) ) {
	define( 'EIYSM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}

if ( !defined( 'EIYSM_META_PREFIX' ) ) {
	define( 'EIYSM_META_PREFIX', 'eiysm_' ); // Plugin metabox prefix
}

if ( !defined( 'EIYSM_PREFIX' ) ) {
	define( 'EIYSM_PREFIX', 'eiysm' ); // Plugin prefix
}

/**
 * Initialize the main class
 */
if ( !function_exists( 'EIYSM' ) ) {

	if ( is_admin() ) {
		require_once( EIYSM_DIR . '/inc/admin/class.' . EIYSM_PREFIX . '.admin.php' );
		require_once( EIYSM_DIR . '/inc/admin/class.' . EIYSM_PREFIX . '.admin.action.php' );
		require_once( EIYSM_DIR . '/inc/admin/class.' . EIYSM_PREFIX . '.admin.filter.php' );
	} else {
		require_once( EIYSM_DIR . '/inc/front/class.' . EIYSM_PREFIX . '.front.php' );
		require_once( EIYSM_DIR . '/inc/front/class.' . EIYSM_PREFIX . '.front.action.php' );
		require_once( EIYSM_DIR . '/inc/front/class.' . EIYSM_PREFIX . '.front.filter.php' );
	}

	require_once( EIYSM_DIR . '/inc/lib/class.' . EIYSM_PREFIX . '.lib.php' );

	//Initialize all the things.
	require_once( EIYSM_DIR . '/inc/class.' . EIYSM_PREFIX . '.php' );
}
