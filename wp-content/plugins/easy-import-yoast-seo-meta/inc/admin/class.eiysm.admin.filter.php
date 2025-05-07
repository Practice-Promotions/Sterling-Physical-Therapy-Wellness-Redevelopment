<?php
/**
 * EIYSM_Admin_Filter Class
 *
 * Handles the admin functionality.
 *
 * @package WordPress
 * @subpackage Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EIYSM_Admin_Filter' ) ) {

	/**
	 *  The EIYSM_Admin_Filter Class
	 */
	class EIYSM_Admin_Filter {

		function __construct() {

			add_filter( 'bulk_actions-edit-post',  array( $this, 'filter__add_export_btn' ) );
			add_filter( 'bulk_actions-edit-page',  array( $this, 'filter__add_export_btn' ) );

			add_filter( 'handle_bulk_actions-edit-post', array( $this, 'filter__bulk_action_handler' ), 10, 3 );
			add_filter( 'handle_bulk_actions-edit-page', array( $this, 'filter__bulk_action_handler' ), 10, 3 );

		}		

		/*
		######## #### ##       ######## ######## ########   ######
		##        ##  ##          ##    ##       ##     ## ##    ##
		##        ##  ##          ##    ##       ##     ## ##
		######    ##  ##          ##    ######   ########   ######
		##        ##  ##          ##    ##       ##   ##         ##
		##        ##  ##          ##    ##       ##    ##  ##    ##
		##       #### ########    ##    ######## ##     ##  ######
		*/

		/**
		 * Add Button Export Selected Post in CSV.
		 */
		function filter__add_export_btn($bulk_actions) {

			$currentScreen = get_current_screen();
			if( $currentScreen->post_type == 'page' ){
				$bulk_actions['export-posts'] = __('Export Selected Page', 'easy-import-yoast-seo-meta');			
			}else{
				$bulk_actions['export-posts'] = __('Export Selected Posts', 'easy-import-yoast-seo-meta');
			}
			return $bulk_actions;
		}


		/**
		 * Bulk action handler.
		 */
		function filter__bulk_action_handler( $redirect_to, $doaction, $posts_ids ) {	

			// do something for "Make Draft" bulk action
			if ( $doaction == 'export-posts' ) {

				$currentScreen = get_current_screen();

				$args = [
					'csv_download' => 1,
					'post_ids' => implode( ',', $posts_ids ),
					'post_type' => $currentScreen->post_type,
				];
				return add_query_arg( $args, $redirect_to );

			}
		}
		
		/*
		######## ##     ## ##    ##  ######  ######## ####  #######  ##    ##  ######
		##       ##     ## ###   ## ##    ##    ##     ##  ##     ## ###   ## ##    ##
		##       ##     ## ####  ## ##          ##     ##  ##     ## ####  ## ##
		######   ##     ## ## ## ## ##          ##     ##  ##     ## ## ## ##  ######
		##       ##     ## ##  #### ##          ##     ##  ##     ## ##  ####       ##
		##       ##     ## ##   ### ##    ##    ##     ##  ##     ## ##   ### ##    ##
		##        #######  ##    ##  ######     ##    ####  #######  ##    ##  ######
		*/


	}

	add_action( 'plugins_loaded', function() {
		EIYSM()->admin->filter = new EIYSM_Admin_Filter;
	} );
}
