<?php
/**
* Condition functions and definitions and Meta related things.
*
* @package herostencilpt
*/


function condition_register_cpts() {
	/**
	 * Post Type: Conditions.
	 */
	$labels = [
		"name" => __( "Conditions", "herostencilpt" ),
		"singular_name" => __( "Condition", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Conditions", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "condition", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
		"menu_icon" => 'dashicons-universal-access',
	];
	register_post_type( "condition", $args );

}

add_action( 'init', 'condition_register_cpts' );

function condition_register_taxes() {
	/**
	 * Taxonomy: Body Parts.
	 */
	$labels = [
		"name" => __( "Body Parts", "herostencilpt" ),
		"singular_name" => __( "Body Part", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Body Parts", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'body-parts', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "body_parts",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "body_parts", [ "condition" ], $args );
}
add_action( 'init', 'condition_register_taxes' );


/** Display callback for the submenu page. */
function condition_page_callback() {
	$taxonomy_content = get_option('taxonomy_content');
	echo '<table class="form-table">'.
		'<tbody>'.
			'<tr>'.
				'<td>'.
					'<h1>'. __( 'Taxonomy Page Content', 'herostencilpt' ) .'</h1>'.
					'<form action="" method="post">'.
						'<textarea placeholder="Add page content" name="taxonomycontent" style="width: 100%;height: 200px;">'. $taxonomy_content .'</textarea>'.
						'<input class="button button-primary" type="submit" name="taxcontent" value="'. __( 'Submit', 'herostencilpt' ) .'" />'.
					'</form>'.
				'</td>'.
			'</tr>'.
		'</tbody>'.
	'</table>';
}
function condition_save_meta() {
	if ( isset($_POST['taxcontent']) == 'Submit' ) {
		$taxonomycontent = $_POST['taxonomycontent'];
		if ( get_option('taxonomy_content') == '' ) {
			update_option( 'taxonomy_content', $taxonomycontent );
		} elseif ( get_option('taxonomy_content') != '' ) {
			update_option( 'taxonomy_content', $taxonomycontent );
		} else {
			add_option('taxonomy_content', $taxonomycontent, '',true );
		}
	}
}
add_action( 'admin_init', 'condition_save_meta', 10, 2 );

/**
* Adds a submenu page under a custom post type parent(condition).
*/
add_action('admin_menu', 'my_theme_admin_menu');
function my_theme_admin_menu() {
	add_submenu_page(
		'edit.php?post_type=condition',
		__( 'Taxonomy Page Content', 'herostencilpt' ),
		__( 'Taxonomy Content', 'herostencilpt' ),
		'manage_options',
		'condition-content',
		'condition_page_callback'
	);
}
