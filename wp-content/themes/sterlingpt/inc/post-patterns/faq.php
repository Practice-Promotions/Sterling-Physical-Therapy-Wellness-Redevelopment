<?php
/**
* Faq functions and definitions and Meta related things.
*
* @package herostencilpt
*/


/** Post Type: FAQs. */
function faq_register_cpts() {

	$labels = [
		"name" => __( "FAQs", "herostencilpt" ),
		"singular_name" => __( "FAQ", "herostencilpt" ),
	];
	$args = [
		"label" => __( "FAQs", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
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
		"rewrite" => [ "slug" => "faq", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
		"menu_icon" => 'data:image/svg+xml;base64,' . base64_encode('<svg fill="rgba(240,245,250,.6);" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m512 346.5c0-63.535156-36.449219-120.238281-91.039062-147.820312-1.695313 121.820312-100.460938 220.585937-222.28125 222.28125 27.582031 54.589843 84.285156 91.039062 147.820312 91.039062 29.789062 0 58.757812-7.933594 84.210938-23.007812l80.566406 22.285156-22.285156-80.566406c15.074218-25.453126 23.007812-54.421876 23.007812-84.210938zm0 0" /><path d="m391 195.5c0-107.800781-87.699219-195.5-195.5-195.5s-195.5 87.699219-195.5 195.5c0 35.132812 9.351562 69.339844 27.109375 99.371094l-26.390625 95.40625 95.410156-26.386719c30.03125 17.757813 64.238282 27.109375 99.371094 27.109375 107.800781 0 195.5-87.699219 195.5-195.5zm-225.5-45.5h-30c0-33.085938 26.914062-60 60-60s60 26.914062 60 60c0 16.792969-7.109375 32.933594-19.511719 44.277344l-25.488281 23.328125v23.394531h-30v-36.605469l35.234375-32.25c6.296875-5.761719 9.765625-13.625 9.765625-22.144531 0-16.542969-13.457031-30-30-30s-30 13.457031-30 30zm15 121h30v30h-30zm0 0" /></svg>'),
	];
	register_post_type( "faq", $args );
}
add_action( 'init', 'faq_register_cpts' );


/** Taxonomy: FAQ Categories. */
function faq_register_taxes() {

	$labels = [
		"name" => __( "FAQ Categories", "herostencilpt" ),
		"singular_name" => __( "FAQ Category", "herostencilpt" ),
	];
	$args = [
		"label" => __( "FAQ Categories", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'faq-category', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "faq_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "faq_category", [ "faq" ], $args );
}
add_action( 'init', 'faq_register_taxes' );


 /** AJAX: FAQs category based listing */
 add_action('wp_ajax_faq_category_filter',        'faq_category_filter');
 add_action('wp_ajax_nopriv_faq_category_filter', 'faq_category_filter');
 function faq_category_filter() {
 	$dataid = $_POST['dataid'];
 	$search = $_POST['keyword'];
 	if ( $dataid == 'all' ) :
 		$faqargs = array (
 			'post_type'      =>'faq',
 			'orderby'        => 'menu_order',
 			'order'          => 'ASC',
 			'post_status'    => 'publish',
 			'posts_per_page' => -1
 		);
 	else :
 		$faqargs = array (
 			'post_type'      =>'faq',
 			'orderby'        => 'menu_order',
 			'order'          => 'ASC',
 			'post_status'    => 'publish',
 			'posts_per_page' => -1,
 			'tax_query'      => array (
 				array (
 					'taxonomy' => 'faq_category',
 					'field'    => 'term_id',
 					'terms'    => $dataid
 				)
 			)
 		);
 	endif;
 	$faqquery = new WP_Query( $faqargs );
 	if ( $faqquery->have_posts() ) :
 		while ( $faqquery->have_posts() ) : $faqquery->the_post();
 			echo '<div class="accordion-item">'.
 				'<div class="accordion-title" aria-expanded="false">'.
 					'<h5>'. get_the_title() .'</h5>'.
 					'<span></span>'.
 				'</div>'.
 				'<div class="accordion-content" style="display:none">'.
 					apply_filters( 'the_content', get_post_field( 'post_content' )).
 				'</div>'.
 			'</div>';
 		endwhile; wp_reset_postdata();
 	endif;
 	wp_die();
 }
