<?php
/**
 * EIYSM_Admin_Action Class
 *
 * Handles the admin functionality.
 *
 * @package WordPress
 * @package Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'EIYSM_Admin_Action' ) ) {

	/**
	 *  The EIYSM_Admin_Action Class
	 */
	class EIYSM_Admin_Action {

		function __construct()  {

			add_action( 'admin_init',     				array( $this, 'action__admin_init' ) );
			add_action( 'admin_menu',     				array( $this, 'action__add_menu' ) );
			add_action( 'admin_notices',  				array( $this, 'action__seo_flash_notices' ) );
			add_action( 'admin_init',     				array( $this, 'action__admin_init_import_seo' ) );
			add_action( 'admin_init',     				array( $this, 'action__save_yoast_seo_tags' ) );
			add_action( 'manage_posts_extra_tablenav', 	array( $this, 'admin_post_list_add_export_button' ), 20, 1 );
		}

		/*
		   ###     ######  ######## ####  #######  ##    ##  ######
		  ## ##   ##    ##    ##     ##  ##     ## ###   ## ##    ##
		 ##   ##  ##          ##     ##  ##     ## ####  ## ##
		##     ## ##          ##     ##  ##     ## ## ## ##  ######
		######### ##          ##     ##  ##     ## ##  ####       ##
		##     ## ##    ##    ##     ##  ##     ## ##   ### ##    ##
		##     ##  ######     ##    ####  #######  ##    ##  ######
		*/

		/**
		 * Action: admin_init
		 *
		 * - Register admin min js and admin min css
		 *
		 */
		function action__admin_init() {
			wp_register_script( EIYSM_PREFIX . '_admin_js', EIYSM_URL . 'assets/js/admin.js', array(), EIYSM_VERSION );
			wp_enqueue_style( EIYSM_PREFIX . '_admin_css', EIYSM_URL . 'assets/css/admin.css', array(), EIYSM_VERSION );

			if ( ! is_plugin_active( 'wordpress-seo/wp-seo.php' ) )
			{
				deactivate_plugins(EIYSM_PLUGIN_BASENAME);
			}
		}

		/**
		 * Register Seo Menu.
		 */
		function action__add_menu() {

			add_menu_page(
				__( 'Yoast Seo Meta Import', 'easy-import-yoast-seo-meta' ),
				__( 'Yoast Seo Meta Import', 'easy-import-yoast-seo-meta' ),
				'manage_options',
				'import-seo-val',
				array( $this, 'import__seo_callback_function' ),
				'dashicons-search'
			);

			add_submenu_page(
				'import-seo-val',
				__( 'Add Yoast Seo Tags', 'easy-import-yoast-seo-meta' ),
				__( 'Add Yoast Seo Tags', 'easy-import-yoast-seo-meta' ),
				'manage_options',
				'add-seo-tag',
				array( $this, 'import__add_seo_tags' )
			);
		}

		/**
		 * Yoast_seo_flash_notices
		 *
		 * @return void
		 */
		function action__seo_flash_notices() {
			$notices = get_option( 'yoast__seo_flash_notices_msg', array() );
			// Iterate through our notices to be displayed and print them.
			foreach ( $notices as $notice ) {
				printf(
					'<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
					esc_attr( $notice['type'] ),
					esc_attr( $notice['dismissible'] ),
					esc_attr( $notice['notice'] )
				);
			}

			// Now we reset our options to prevent notices being displayed forever.
			if ( ! empty( $notices ) ) {
				delete_option( 'yoast__seo_flash_notices_msg', array() );
			}
		}


		/**
		 * Upload Seo Meta title and description.
		 *
		 * @return void
		 */
		function action__admin_init_import_seo() {

			if ( array_key_exists( 'import-seo-metadata-submit', $_REQUEST ) && '' !== $_REQUEST['import-seo-metadata-submit'] ) {

				$error = array();

				// checking the nonce first.
				if ( isset( $_REQUEST['_wpnonce_import_seo'] ) && '' !== $_REQUEST['_wpnonce_import_seo'] ) {

					if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce_import_seo'] ) ), 'import_seo_metadata' ) ) {
						$this->add__yoast_seo_flash_notice( __( 'Upload file security issue.. Please try again.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
						return;
					}

					if ( isset( $_FILES['seo_importcsv']['type'] ) && '' !== $_FILES['seo_importcsv']['type'] ) {

						$file_name      = isset( $_FILES['seo_importcsv']['name'] ) ? sanitize_file_name( wp_unslash( $_FILES['seo_importcsv']['name'] ) ) : '';
						$file_array     = explode( '.', $file_name );
						$file_extension = end( $file_array );
						$ext            = strtolower( $file_extension );
						$tmp_name       = isset( $_FILES['seo_importcsv']['tmp_name'] ) ? $_FILES['seo_importcsv']['tmp_name'] : '';

						// check the file is a csv.
						if ( 'csv' === $ext ) {

							if ( ( $handle = fopen( $tmp_name, 'r' ) ) !== false ) {

								set_time_limit( 0 );

								$row = 0;

								$col_count = count( file( $tmp_name, FILE_SKIP_EMPTY_LINES ) );

								if ( $col_count < 2 ) {
									$this->add__yoast_seo_flash_notice( __( 'Uploaded file not have encourage data.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
									return;
								}

								$post_id_error = array();
								while ( ( $data = fgetcsv( $handle, 10000, ',' ) ) !== false ) {

									// Check data is blank or not.
									if ( ! empty( $data ) ) {

										if ( $row > 0 ) {

											$id        = trim( $data[0] );
											$title     = trim( mb_convert_encoding( $data[4], "HTML-ENTITIES", "UTF-8" ) );
											$metadesc  = trim( mb_convert_encoding( $data[5], "HTML-ENTITIES", "UTF-8" ) );
											$post_slug = trim( $data[2] );

											try {
												if ( get_post_status( $id ) ) {

													if ( $title ) {
														$get_title = $this->replace__string_tag_to_seo_tags( $title );
														if ( $get_title ) {
															update_post_meta( $id, '_yoast_wpseo_title', $get_title );
														}
													}

													if ( $metadesc ) {
														$get_metadesc = $this->replace__string_tag_to_seo_tags( $metadesc );
														if ( $get_metadesc ) {
															update_post_meta( $id, '_yoast_wpseo_metadesc', $get_metadesc );
														}
													}

													if ( $post_slug ) {
														wp_update_post(
															array(
																'post_name' => $post_slug,
																'ID' => $id,
															)
														);
													}
												} else {

													$post_id_error[] = $id;

												}
											} catch ( Exception $e ) {

												$this->add__yoast_seo_flash_notice( __( 'Upload file security issue.. Please try again.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
												break;
											}
										}
										$row++;
									}
								}

								if ( $row == $col_count ) {
									if ( count( $post_id_error ) > 0 ) {

										$get_post_id = implode( ', ', $post_id_error );

										if ( count( $post_id_error ) > 1 ) {
											$this->add__yoast_seo_flash_notice( '( ' . $get_post_id . ' ) ' . __( 'Check following id are not found, please check and try agian.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
										} else {
											$this->add__yoast_seo_flash_notice( '( ' . $get_post_id . ' ) ' . __( 'Check following id not found, please check and try agian.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
										}
									}

									if ( count( $post_id_error ) !== $col_count - 1 ) {
										$this->add__yoast_seo_flash_notice( __( 'Import is done successfully.', 'easy-import-yoast-seo-meta' ), 'success', true );  // Set flash notice.
									}
								}

								// File Close.
								fclose( $handle );
							}
						} else {
							// File type error.
							$this->add__yoast_seo_flash_notice( __( 'File Format is not suported.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
						}
					} else {
						// File type error.
						$this->add__yoast_seo_flash_notice( __( 'Upload file security issue.. Please try again.', 'easy-import-yoast-seo-meta' ), 'error', true );  // Set flash notice.
					}
				}
			}

			/**
			 * Export Pages
			 */
		    if(isset($_GET['export_all_posts']) || isset($_GET['export_all_page']) ) {
		        $arg = array(
		            'post_type' => isset($_GET['export_all_posts']) ? 'post' : 'page',
		            'post_status' => 'publish',
		            'posts_per_page' => -1,
		        );

		        global $post;
		        $arr_post = get_posts($arg);
		        if ($arr_post) {

		            header('Content-type: text/csv');
		            header('Content-Disposition: attachment; filename="wp-posts.csv"');
		            header('Pragma: no-cache');
		            header('Expires: 0');

		            $file = fopen('php://output', 'w');

		            fputcsv($file, array('Post ID', 'Post Title', 'Slug', 'URL', 'Yoast Title', 'MetaDesc' ));

		            foreach ($arr_post as $post) {
		                setup_postdata($post);

		                $title = get_post_meta( get_the_ID(), '_yoast_wpseo_title', true );

		                $fetch_title = $this->replace__seo_tags_to_string( $title );

		                $update_title = substr($fetch_title, 0, -1);
		                $set_title = substr($update_title, 0, -1);

		                $metadesc = get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true );

		                fputcsv($file, array(get_the_ID(),  get_the_title(), $post->post_name, get_the_permalink(), $set_title, $metadesc ) );
		            }

		            exit();
		        }
		    }

			/**
			 * Export posts
			 */
		    if(isset($_REQUEST['csv_download']) ) {

		    	if( empty( $_REQUEST['post_ids'] ) && empty( $_REQUEST['post_type'] ) ) { return; }

		        $arg = array(
		        	'post_type' => $_REQUEST['post_type'],
		            'post_status' => 'publish',
		            'posts_per_page' => -1,
		            'post__in' => explode(',', $_REQUEST['post_ids'])
		        );

		        global $post;
		        $arr_post = get_posts($arg);

		        if ($arr_post) {

		            header('Content-type: text/csv');
		            header('Content-Disposition: attachment; filename="wp-posts.csv"');
		            header('Pragma: no-cache');
		            header('Expires: 0');

		            $file = fopen('php://output', 'w');

		            fputcsv($file, array('Post ID', 'Post Title', 'Slug', 'URL', 'Yoast Title', 'MetaDesc' ));

		            foreach ($arr_post as $post) {
		                setup_postdata($post);

		                $title = get_post_meta( get_the_ID(), '_yoast_wpseo_title', true );

		                $fetch_title = $this->replace__seo_tags_to_string( $title );

		                $update_title = substr($fetch_title, 0, -1);
		                $set_title = substr($update_title, 0, -1);

		                $metadesc = get_post_meta( get_the_ID(), '_yoast_wpseo_metadesc', true );

		                fputcsv($file, array(get_the_ID(),  get_the_title(), $post->post_name, get_the_permalink(), $set_title, $metadesc ) );
		            }

		            exit();
		        }
		    }
		}

		/**
		 * Save yoast seo tags.
		 *
		 * @return void
		 */
		function action__save_yoast_seo_tags() {

			if( isset($_REQUEST['page']) && $_REQUEST['page'] == 'add-seo-tag' && $_POST ){

				if ( ! wp_verify_nonce( $_POST['yoast_seo_tags'], 'save_yoast_tag' ) ) {
					return;
				}

				$option_name = '_yoast_custom_tags';

				if( array_key_exists("yoast", $_POST ) ) {
					$seotags_finalarray = array();
					foreach ($_POST['yoast'] as $key => $value) {
						foreach ($value as $k => $v) {
							$seotags_finalarray[$k][$key] = $v;
						}
					}

					if ( get_option( $option_name ) !== false ) {
						update_option( $option_name, serialize( $seotags_finalarray ) );
					} else {
						add_option( $option_name, serialize( $seotags_finalarray ) );
					}

					$this->add__yoast_seo_flash_notice( __( 'Update your change has been made succesfully.', 'easy-import-yoast-seo-meta' ), 'success', true );  // Set flash notice.

				} else {
					update_option( $option_name, '' );
				}
			}
		}


		function admin_post_list_add_export_button( $which ) {
			global $typenow;
			if ('post' === $typenow && 'top' === $which ) {
				echo '<input type="submit" name="export_all_posts" class="button button-primary" value="Export All Posts" />';
			}
			if ('page' === $typenow && 'top' === $which ) {
				echo '<input type="submit" name="export_all_page" class="button button-primary" value="Export All Pages" />';
			}
		}

		/**
		 * Upload Error notice.
		 *
		 * @return void
		 */
		function action_admin_notices_import_seo_nonce_issue() {
			echo '<div class="error"><p>' .
				esc_html__( 'Upload file security issue.. Please try again.', 'easy-import-yoast-seo-meta' ) .
			'</p></div>';
		}


		/**
		 * Import file format notice.
		 *
		 * @return void
		 */
		function action_admin_notices_import_seo_file_format() {
			echo '<div class="error"><p>' .
				esc_html__( 'File Format is not suported.', 'easy-import-yoast-seo-meta' ) .
			'</p></div>';
		}

		/**
		 * Upload Success notice.
		 *
		 * @return void
		 */
		function action_admin_notices_import_done() {
			echo '<div class="updated"><p>' .
				esc_html__( 'Import is done successfully..', 'easy-import-yoast-seo-meta' ) .
			'</p></div>';
		}

		/**
		 * Data empty error notice.
		 *
		 * @return void
		 */
		function action_admin_notices_file_data_error() {
			echo '<div class="error"><p>' .
				esc_html__( 'Uploaded file not have encourage data...', 'easy-import-yoast-seo-meta' ) .
			'</p></div>';
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


		/**
		 * Menu Callback Function.
		 *
		 * @return void
		 */
		function import__seo_callback_function() {
			?>
			<div class="wrap show-upload-view">
				<h1 class ="wp-heading-inline"> <?php echo esc_html__( 'Import your CSV.', 'easy-import-yoast-seo-meta' ); ?> </h1>
				<div class="upload-plugin">
					<p class ="install-help"><?php echo esc_html__( 'Check Demo CSV ', 'easy-import-yoast-seo-meta' ); ?>
						<a download href='<?php echo esc_url( EIYSM_URL ) . 'import_demo_file/seo-demo.csv'; ?>'; ?>
							<?php echo esc_html__( 'here..', 'easy-import-yoast-seo-meta' ); ?>
						</a>
					</p>
					<form method="post" enctype="multipart/form-data" class="wp-upload-form" style="max-width:780px;">
						<label><?php echo esc_html__( 'Upload File', 'easy-import-yoast-seo-meta' ); ?>
						<input type="hidden" id="_wpnonce" name="_wpnonce_import_seo" value='<?php echo esc_attr( wp_create_nonce( 'import_seo_metadata' ) ); ?>'>
						<input type="file" id="pluginzip" name="seo_importcsv"></label>
						<label><input type="submit" name="import-seo-metadata-submit" id="install-plugin-submit" class="button" value="Import Now" disabled=""></label>
					</form>
					</div>
			</div>
			<?php
		}

		/**
		 * Add Seo Tags Custom
		 */
		function import__add_seo_tags(){

			wp_enqueue_script( EIYSM_PREFIX . '_admin_js');

			echo '<div class="wrap show-upload-view yoast_seo_tags_main">
				<h1 class ="wp-heading-inline create_seo_custom_tags"> '. esc_html__( 'Create Yoast Seo Tags', 'easy-import-yoast-seo-meta' ) .' </h1>

				<form method="post" action="'.admin_url( 'admin.php' ).'?page=add-seo-tag" name="">';
					$option_name = '_yoast_custom_tags';
					if ( get_option( $option_name ) !== false && get_option( $option_name ) != '' ) {

						$current_options = unserialize( get_option( $option_name ) );
						echo '<div id="yoast_seo_tags">	';
							foreach ($current_options as $value) {
								echo '<p><label for="seo_tname"> <b> ' . esc_html__('Seo Tag Name', 'easy-import-yoast-seo-meta') . ' :</b> <input type="text" size="20" name="yoast[t_name][]" class="seotags" data-seoid="1" required value="'.$value['t_name'].'" placeholder="Tag Name" /></label>
								<label for="seo_tvalue"> <b>' . esc_html__('Tag Value', 'easy-import-yoast-seo-meta') . ' :</b> <input type="text" size="20" name="yoast[t_value][]" required value="'.$value['t_value'].'" placeholder="Tag Value" /></label>
								<button id="remScnt">' . esc_html__('Remove', 'easy-import-yoast-seo-meta') . ' </button>
								<span class="lblError lblError1" style="color: red; display:block;"></span>
								</p>';
							}
						echo '</div>';

					} else {

						echo '<div id="yoast_seo_tags">
							<p>
								<label for="seo_tname"> <b>' . esc_html__('Seo Tag Name', 'easy-import-yoast-seo-meta') . ' : </b> <input type="text" size="20" name="yoast[t_name][]" class="seotags" data-seoid="1" required value="" placeholder="Tag Name" /></label>
								<label for="seo_tvalue"> <b>' . esc_html__('Tag Value', 'easy-import-yoast-seo-meta') . ' :</b> <input type="text" size="20" name="yoast[t_value][]" required value="" placeholder="Tag Value" /></label>
								<button id="remScnt">' . esc_html__('Remove', 'easy-import-yoast-seo-meta') . '</button>
								<span class="lblError lblError1" style="color: red; display:block;"></span>
							</p>
						</div>';
					}
					wp_nonce_field( "save_yoast_tag", "yoast_seo_tags" );
					echo '
					<input type="hidden" name="tag_count" class="tag_count" value="" />
					<button id="addScnt" type="button">' . esc_html__('Add Yoast Tags', 'easy-import-yoast-seo-meta') . '</button>
					<button id="save" type="submit">' . esc_html__('Save Tags', 'easy-import-yoast-seo-meta') . '</button>
				</form>
			</div>';
		}

		/**
		 * Add_yoast_seo_flash_notice
		 *
		 * @param  mixed $notice  Notice Text.
		 * @param  mixed $type Notice Type.
		 * @param  mixed $dismissible Error dismiss option.
		 * @return void
		 */
		function add__yoast_seo_flash_notice( $notice = '', $type = 'warning', $dismissible = true ) {
			// Here we return the notices saved on our option, if there are not notices, then an empty array is returned.
			$notices = get_option( 'yoast__seo_flash_notices_msg', array() );

			$dismissible_text = ( $dismissible ) ? 'is-dismissible' : '';

			// We add our new notice.
			array_push(
				$notices,
				array(
					'notice'      => $notice,
					'type'        => $type,
					'dismissible' => $dismissible_text,
				)
			);
			// Then we update the option with our notices array.
			update_option( 'yoast__seo_flash_notices_msg', $notices );
		}


		/**
		 * fetch tags list which added in custom.
		 */

		function fetch_yoast_tags(){

			$option_name = '_yoast_custom_tags';

			$variable_match = array(
				'[title]',
				'[page]',
				'[sitename]',
				'[sitedesc]',
				'[sep]',
				'[date]',
				'[excerpt_only]',
				'[tag]',
				'[category]',
				'[focuskw]',
				'[Date]',
				'[parent_title]',
				'[archive_title]',
				'[sitedesc]',
				'[excerpt]',
				'[category_description]',
				'[primary_category]',
				'[tag_description]',
				'[term_title]',
				'[blog_title]',

			);

			if( get_option( $option_name ) != '' ){
				$get_tag_list = unserialize( get_option( $option_name ) );
				foreach ($get_tag_list as $key => $value) {
					$variable_match[] = '['.$value['t_name'].']';
				}
			}

			return $variable_match;
		}


		/**
		 * Replace normal tag to seo tag.
		 *
		 * @param  mixed $variables_str uploaded row string.
		 * @return string
		 */
		function replace__string_tag_to_seo_tags( $variables_str ) {

			$set_title = array();

			$variables = explode( '/', $variables_str );

			$variable_match = $this->fetch_yoast_tags();

			foreach ( $variables as $val ) {

				$value = trim( $val );

				if ( in_array( $value, $variable_match ) ) {

					$set_tag = preg_match( '#\[(.*?)\]#', $value, $match );
					if ( $match[1] ) {
						$set_title[] = '%%' . $match[1] . '%% ';
					} else {
						$set_title[] = ' ' . $value . ' ';
					}
				} else {
					$set_title[] = ' ' . $value . ' ';
				}
			}
			return implode( '', $set_title );
		}

		function startsWith ($string, $startString)
		{
		    $len = strlen($startString);
		    return (substr($string, 0, $len) === $startString);
		}


		function replace__seo_tags_to_string( $variables_str ) {

			$set_title = array();

			$variables = explode('%%', $variables_str );
			foreach ( $variables as $val ) {

				if( $val == ' ' || $val == '' ){
					$set_title[] = '[';
				}else{
					if($this->startsWith($val," ")){
						$set_title[] = '';
						$set_title[] = $val;
						$set_title[] = '/[';
					}else{
						$set_title[] = $val. ']/';
					}
				}

			}
			return implode( '', $set_title );
		}

	}

	add_action( 'plugins_loaded', function() {
		EIYSM()->admin->action = new EIYSM_Admin_Action;
	} );
}
