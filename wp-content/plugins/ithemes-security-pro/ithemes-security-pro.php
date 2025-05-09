<?php

/*
 * Plugin Name: Solid Security Pro
 * Plugin URI: https://solidwp.com/security
 * Description: Shield your site from cyberattacks and prevent security vulnerabilities. The only security plugin you need for a solid foundation.
 * Author: SolidWP
 * Author URI: https://solidwp.com
 * Version: 8.5.4
 * Text Domain: it-l10n-ithemes-security-pro
 * Domain Path: /lang
 * Network: True
 * License: GPLv2
 * Requires at least: 6.5
 * Requires PHP: 7.3
 * iThemes Package: ithemes-security-pro
 */

if ( version_compare( phpversion(), '7.3.0', '<' ) ) {
	function itsec_minimum_php_version_notice() {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Solid Security requires PHP 7.3 or higher.', 'it-l10n-ithemes-security-pro' ) . '</p></div>';
	}

	add_action( 'admin_notices', 'itsec_minimum_php_version_notice' );

	return;
}

if ( version_compare( $GLOBALS['wp_version'], '6.5', '<' ) ) {
	function itsec_minimum_wp_version_notice() {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Solid Security requires WordPress 6.5 or later.', 'it-l10n-ithemes-security-pro' ) . '</p></div>';
	}

	add_action( 'admin_notices', 'itsec_minimum_wp_version_notice' );

	return;
}

function itsec_pro_load_textdomain() {
	$locale = determine_locale();
	$locale = apply_filters( 'plugin_locale', $locale, 'it-l10n-ithemes-security-pro' );

	load_textdomain( 'it-l10n-ithemes-security-pro', WP_LANG_DIR . "/plugins/ithemes-security-pro/it-l10n-ithemes-security-pro-$locale.mo" );
	load_plugin_textdomain( 'it-l10n-ithemes-security-pro', false, basename( dirname( __FILE__ ) ) . '/lang/' );
}

add_action( 'after_setup_theme', 'itsec_pro_load_textdomain', 0 );

if ( isset( $itsec_dir ) || class_exists( 'ITSEC_Core' ) ) {
	include( dirname( __FILE__ ) . '/core/show-multiple-version-notice.php' );

	return;
}

if ( file_exists( __DIR__ . '/vendor-prod/autoload.php' ) ) {
	require_once( __DIR__ . '/vendor-prod/autoload.php' );
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once( __DIR__ . '/vendor/autoload.php' );
}

if ( ! function_exists( 'itsec_pro_register_modules' ) ) {
	// Add pro modules at priority 11 so they are added after core modules (thus taking precedence)
	add_action( 'itsec-register-modules', 'itsec_pro_register_modules', 11 );

	function itsec_pro_register_modules() {
		$path = dirname( __FILE__ );
		if ( ITSEC_Core::get_install_type() === 'pro' ) {
			ITSEC_Modules::register_module( 'pro', "$path/pro/pro" );
			ITSEC_Modules::register_module( 'pro-dashboard', "$path/pro/pro-dashboard" );
			ITSEC_Modules::register_module( 'pro-two-factor', "$path/pro/pro-two-factor" );
			ITSEC_Modules::register_module( 'dashboard-widget', "$path/pro/dashboard-widget" );
			ITSEC_Modules::register_module( 'magic-links', "$path/pro/magic-links" );
			ITSEC_Modules::register_module( 'online-files', "$path/pro/online-files" );
			ITSEC_Modules::register_module( 'passwordless-login', "$path/pro/passwordless-login" );
			ITSEC_Modules::register_module( 'password-expiration', "$path/pro/password-expiration" );
			ITSEC_Modules::register_module( 'privilege', "$path/pro/privilege" );
			ITSEC_Modules::register_module( 'recaptcha', "$path/pro/recaptcha" );
			ITSEC_Modules::register_module( 'import-export', "$path/pro/import-export" );
			ITSEC_Modules::register_module( 'user-logging', "$path/pro/user-logging" );
			ITSEC_Modules::register_module( 'user-security-check', "$path/pro/user-security-check" );
			ITSEC_Modules::register_module( 'version-management', "$path/pro/version-management" );
			ITSEC_Modules::register_module( 'fingerprinting', "$path/pro/fingerprinting" );
			ITSEC_Modules::register_module( 'geolocation', "$path/pro/geolocation" );
			ITSEC_Modules::register_module( 'webauthn', "$path/pro/webauthn" );
		}

		if ( defined( 'WP_CLI' ) && WP_CLI && class_exists( 'WP_CLI_Command' ) ) {
			require( "$path/pro/wp-cli/load.php" );
		}
	}
}


$itsec_dir = dirname( __FILE__ );

require( "$itsec_dir/core/core.php" );
$itsec_core = ITSEC_Core::get_instance();
$itsec_core->init( __FILE__, 'Solid Security Pro' );

if ( is_admin() && file_exists( "$itsec_dir/lib/icon-fonts/load.php" ) ) {
	require( "$itsec_dir/lib/icon-fonts/load.php" );
}


if ( ! function_exists( 'ithemes_repository_name_updater_register' ) ) {
	function ithemes_repository_name_updater_register( $updater ) {
		$updater->register( 'ithemes-security-pro', __FILE__ );
	}

	add_action( 'ithemes_updater_register', 'ithemes_repository_name_updater_register' );

	if ( file_exists( "$itsec_dir/lib/updater/load.php" ) ) {
		require( "$itsec_dir/lib/updater/load.php" );
	}
}
