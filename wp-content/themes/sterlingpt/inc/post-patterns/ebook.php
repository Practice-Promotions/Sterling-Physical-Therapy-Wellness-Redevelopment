<?php
/**
* Ebook functions and definitions and Meta related things.
*
* @package herostencilpt
*/

function ebook_register_cpts() {

	/**
	 * Post Type: Ebooks.
	 */
	$labels = [
		"name" => __( "Ebooks", "herostencilpt" ),
		"singular_name" => __( "Ebook", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Ebooks", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "ebook", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
		"menu_icon" => "dashicons-book",
	];
	register_post_type( "ebook", $args );

}
add_action( 'init', 'ebook_register_cpts' );
