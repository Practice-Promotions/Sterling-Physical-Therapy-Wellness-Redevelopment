<?php
/**
 * EIYSM Class
 *
 * Handles the plugin functionality.
 *
 * @package WordPress
 * @package Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if( function_exists( 'yoast__seo_register_tags' ) ){ // check function exists
	$option_name = '_yoast_custom_tags';
	if( get_option( $option_name ) != '' ){
		$get_tag_list = unserialize( get_option( $option_name ) );
		foreach ($get_tag_list as $key => $value) {
			$resgister_yoast_tags[$value['t_name']] = $value['t_value'];
		}
		yoast__seo_register_tags($resgister_yoast_tags); // call function
	}
}

function yoast__seo_register_tags( $yoast_tags ) {

	add_action( 'wpseo_register_extra_replacements', function() use ( $yoast_tags ) {

		$yoast_tags = apply_filters( EIYSM_META_PREFIX .'add_yoast_tags', $yoast_tags );

		foreach ( $yoast_tags as $key => $val ) {
			wpseo_register_var_replacement(
				'%%'.$key.'%%',
				function () use ( $val ) { return $val; },
				'advanced',
				'about some text'
			);
		}
	});
}



if ( !class_exists( 'EIYSM' ) ) {

	/**
	 * The main EIYSM class
	 */
	class EIYSM {

		private static $_instance = null;

		var $admin = null,
			$front = null,
			$lib   = null;

		public static function instance() {

			if ( is_null( self::$_instance ) )
				self::$_instance = new self();

			return self::$_instance;
		}

		function __construct() {

			add_action( 'plugins_loaded', array( $this, 'action__plugins_loaded' ), 1 );

			# Register plugin activation hook
			register_activation_hook( EIYSM_FILE, array( $this, 'action__plugin_activation' ) );

		}

		/**
		 * Action: plugins_loaded
		 * 		 
		 * @return [type] [description]
		 */
		function action__plugins_loaded() {

			# Load Paypal SDK on int action

			# Action to load custom post type
			add_action( 'init', array( $this, 'action__init' ) );

			global $wp_version;

			# Set filter for plugin's languages directory
			$EIYSM_lang_dir = dirname( EIYSM_PLUGIN_BASENAME ) . '/languages/';
			$EIYSM_lang_dir = apply_filters( 'EIYSM_languages_directory', $EIYSM_lang_dir );

			# Traditional WordPress plugin locale filter.
			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			# Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale',  $get_locale, 'easy-import-yoast-seo-meta' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'easy-import-yoast-seo-meta', $locale );

			# Setup paths to current locale file
			$mofile_global = WP_LANG_DIR . '/plugins/' . basename( EIYSM_DIR ) . '/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				# Look in global /wp-content/languages/plugin-name folder
				load_textdomain( 'easy-import-yoast-seo-meta', $mofile_global );
			} else {
				# Load the default language files
				load_plugin_textdomain( 'easy-import-yoast-seo-meta', false, $EIYSM_lang_dir );
			}
		}

		/**
		 * Action: init
		 *
		 * - If license found then action run
		 *
		 */
		function action__init() {

			flush_rewrite_rules();

			# Post Type: Here you add your post type
		}



		/**
		 * register_activation_hook
		 *
		 * - When active plugin
		 *
		 */
		function action__plugin_activation() {

			if ( ! is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) 
			{				
				wp_die('Sorry, but this plugin requires the Yoast SEO to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
			}

		}

	}
}

function EIYSM() {
	return EIYSM::instance();
}

EIYSM();
