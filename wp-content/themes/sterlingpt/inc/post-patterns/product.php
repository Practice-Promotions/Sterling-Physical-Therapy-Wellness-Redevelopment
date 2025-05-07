<?php
/**
* Product functions and definitions and Meta related things.
*
* @package herostencilpt
*/

/**
 * Post Type: Product.
 */
function product_register_cpts() {

	$labels = [
		"name" => __( "Product", "herostencilpt" ),
		"singular_name" => __( "Product", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Products", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"type"         => "string",
        "single"       => true,
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
		"rewrite" => [ "slug" => "product", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "excerpt", "editor", "thumbnail" ],
		"show_in_graphql" => false,
		"menu_icon" => 'dashicons-products',
	];
	register_post_type( "product", $args );
}
add_action( 'init', 'product_register_cpts' );


/**
 * Taxonomy: Product Categories.
 */
function product_register_taxes() {

	$labels = [
		"name" => __( "Product Categories", "herostencilpt" ),
		"singular_name" => __( "Product Category", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Product Categories", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'product-category', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "product_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "product_category", [ "product" ], $args );
}
add_action( 'init', 'product_register_taxes' );


/**
 * Add Meta Box.
 */
function add_product_meta_box() {
    add_meta_box(
        'product_meta_box',
        'Post: Product',
        'display_product_meta_box',
        'product',
        'advanced',
        'high',
		'register_product_meta'
    );
}
add_action('add_meta_boxes', 'add_product_meta_box');


/**
 * Displat Meta fields.
 */
function display_product_meta_box($post) {

	// Add nonce for security and authentication
   wp_nonce_field('save_product_meta_box', 'product_meta_box_nonce');

   $product_link = get_post_meta($post->ID, '_product_link', true);

    ?>
    <div class="product-meta-box">
        <div class="tab-content">
			<div class="meta-field">
				<label for="product_custom_title">Product Link</label>
				<input type="text" name="product_link" id="product_link" value="<?php echo esc_attr($product_link); ?>" />
			</div>
		</div>
    </div>
    <?php
}

/**
 * Save Meta fields.
 */
function save_product_meta_box($post_id) {
	if (get_post_type( $post_id ) === 'product') {

		if (array_key_exists('product_link', $_POST)) {
			update_post_meta($post_id, '_product_link', sanitize_text_field($_POST['product_link']));
		}
	}
}
add_action('save_post', 'save_product_meta_box');
