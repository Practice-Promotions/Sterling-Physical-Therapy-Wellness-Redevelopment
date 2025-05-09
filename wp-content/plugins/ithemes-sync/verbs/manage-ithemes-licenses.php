<?php

/*
Implementation of the manage-ithemes-licenses verb.
Written by Chris Jean for iThemes.com
Version 1.0.0

Version History
	1.0.0 - 2014-11-18 - Chris Jean
		Initial version
*/


class Ithemes_Sync_Verb_Manage_Ithemes_Licenses extends Ithemes_Sync_Verb {
	public static $name = 'manage-ithemes-licenses';
	public static $description = 'Get, set, and delete license keys for iThemes products.';
	public static $status_element_name = 'ithemes-licenses';
	public static $show_in_status_by_default = false;

	private $default_arguments = [];
	private $response = [];


	public function run( $arguments ) {
		$arguments = Ithemes_Sync_Functions::merge_defaults( $arguments, $this->default_arguments );

		if ( empty( $GLOBALS['ithemes_updater_path'] ) ) {
			if ( defined( 'ITHEMES_UPDATER_DISABLE' ) && ITHEMES_UPDATER_DISABLE ) {
				return new WP_Error( 'ithemes-updater-is-disabled', 'The iThemes updater library is disabled on this site due to the ITHEMES_UPDATER_DISABLE define being set to a truthy value. Licensing for this site cannot be managed.' );
			} else {
				return new WP_Error( 'ithemes-updater-not-loaded', 'The $GLOBALS[\'ithemes_updater_path\'] variable is empty or not set. This indicates that the updater was not loaded although the cause for this is not known.' );
			}
		}

		include_once $GLOBALS['ithemes_updater_path'] . '/keys.php';

		if ( ! class_exists( 'Ithemes_Updater_Keys' ) ) {
			return new WP_Error( 'ithemes-updater-keys-class-missing', "The Ithemes_Updater_Keys class was not found. This could indicate an issue with the files of the updater located at {$GLOBALS['ithemes_updater_path']}." );
		}

		$actions = [
			'get'              => 'get_keys',
			'set'              => 'set_keys',
			'set_licensed_url' => 'set_licensed_url',
		];

		if ( empty( $arguments ) ) {
			$arguments = [ 'get' => true ];
		}

		foreach ( $arguments as $action => $data ) {
			if ( ! isset( $actions[ $action ] ) ) {
				$this->response[ $action ] = 'This action is not recognized.';
				continue;
			}
			if ( ! is_array( $data ) && 'set' === $action ) {
				$this->response[ $action ] = new WP_Error( 'invalid-argument', 'This action requires an array.' );
				continue;
			}

			$this->response[ $action ] = call_user_func( [ $this, $actions[ $action ] ], $data );
		}

		return $this->response;
	}

	private function get_keys( $packages ) {
		if ( ! is_callable( 'Ithemes_Updater_Keys', 'get' ) ) {
			return new WP_Error( 'ithemes-updater-keys-get-not-callable', 'The Ithemes_Updater_Keys::get function is not callable due to an unknown issue. Unable to process the request.' );
		}

		require_once $GLOBALS['ithemes_updater_path'] . '/packages.php';

		if ( ! class_exists( 'Ithemes_Updater_Packages' ) ) {
			return new WP_Error( 'ithemes-updater-packages-class-missing', "The Ithemes_Updater_Packages class was not found. This could indicate an issue with the files of the updater located at {$GLOBALS['ithemes_updater_path']}." );
		} elseif ( ! is_callable( 'Ithemes_Updater_Packages', 'get_full_details' ) ) {
			return new WP_Error( 'ithemes-updater-packages-get-full-details-not-callable', 'The Ithemes_Updater_Packages::get_full_details function is not callable due to an unknown issue. Unable to process the request.' );
		}

		if ( empty( $packages ) ) {
			$packages = '__all__';
		}

		$keys = Ithemes_Updater_Keys::get( $packages );

		if ( '__all__' == $packages ) {
			$package_details = Ithemes_Updater_Packages::get_full_details();

			foreach ( $package_details['packages'] as $data ) {
				if ( ! isset( $keys[ $data['package'] ] ) ) {
					$keys[ $data['package'] ] = null;
				}
			}
		}

		return $keys;
	}

	private function set_keys( $packages ) {
		if ( ! is_callable( 'Ithemes_Updater_Keys', 'set' ) ) {
			return new WP_Error( 'ithemes-updater-keys-set-not-callable', 'The Ithemes_Updater_Keys::set function is not callable due to an unknown issue. Unable to process the request.' );
		}

		return Ithemes_Updater_Keys::set( $packages );
	}

	private function set_licensed_url( string $new_url ) {
		require_once $GLOBALS['ithemes_updater_path'] . '/settings.php';

		/** @var Ithemes_Updater_Settings $settings */
		$settings = $GLOBALS['ithemes-updater-settings'];
		$settings->set_licensed_site_url( $new_url );

		return true;
	}
}
