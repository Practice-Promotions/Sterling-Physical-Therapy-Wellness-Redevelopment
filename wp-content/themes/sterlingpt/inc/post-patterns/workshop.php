<?php
/**
* Team functions and definitions and Meta related things.
*
* @package herostencilpt
*/


/**
 * Post Type: Workshops.
*/
function workshop_register_cpts() {

	$labels = [
		"name" => __( "Workshops", "herostencilpt" ),
		"singular_name" => __( "Workshop", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Workshops", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"single" => true,
        "type" => "string",
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
		"rewrite" => [ "slug" => "workshop", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
		"menu_icon" => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45"> <path d="M5.4,44.087l-.382-.5L4.943,30.756C4.9,23.7,4.858,17.907,4.83,17.878a.619.619,0,0,0-.34,0l-.325.043-.071,6.021c-.071,5.583-.085,6.049-.34,6.46a1.849,1.849,0,0,1-1.712.907A1.8,1.8,0,0,1,.259,30.232c-.269-.581-.283-.808-.241-7.948l.043-7.339L.5,14.025a5.247,5.247,0,0,1,3.3-2.989,6.788,6.788,0,0,1,1.741-.255l.962-.014L8.157,14.1l1.67,3.314,1.7-3.314,1.7-3.329h6.624c7.232,0,7.219,0,7.912.822a2.462,2.462,0,0,1,.085,3.23c-.821.921-.665.907-6.681.907H15.7l-.028,13.912-.042,13.926-.325.467a2.547,2.547,0,0,1-4.218-.354c-.255-.5-.269-1.021-.34-6.772-.043-3.428-.1-6.247-.113-6.276-.113-.127-.58.014-.651.2-.043.127-.085,2.9-.085,6.191,0,5.566-.029,6.021-.269,6.573A2.516,2.516,0,0,1,7.316,45,2.377,2.377,0,0,1,5.4,44.087ZM33.21,42.076H32.191l-2.236-4.463L27.732,33.15h2.123l2.194,4.392c1.2,2.408,2.194,4.42,2.194,4.463a3.7,3.7,0,0,1-.767.08Q33.343,42.085,33.21,42.076ZM20.514,42c0-.043.991-2.054,2.194-4.463L24.9,33.15h.991c.566,0,.991.056.991.142s-.977,2.082-2.151,4.463l-2.166,4.321H21.547q-.133.01-.266.01A3.7,3.7,0,0,1,20.514,42ZM17.541,31.31V17.568h4.529c4.119,0,4.586-.028,5.237-.269a4.307,4.307,0,0,0,.283-7.976c-.623-.326-.75-.326-6.4-.368-3.185-.028-5.775-.071-5.775-.1a7.514,7.514,0,0,1,.354-.737,6.79,6.79,0,0,0,.5-5.029,8.546,8.546,0,0,1-.283-1.007c0-.056,2.321-.1,5.166-.1h5.166V0H28.44V1.982H44.307l.339.358L45,2.68v13.9c0,14-.014,14.308-.481,14.62-.085.057-6.185.113-13.559.113ZM7.76,9.478A5.062,5.062,0,0,1,5.425,7.2a5.476,5.476,0,0,1-.2-3.967A5.27,5.27,0,0,1,8.723.142a5.933,5.933,0,0,1,2.9.242,5.726,5.726,0,0,1,2.633,2.366,3.626,3.626,0,0,1,.382,2.209,3.906,3.906,0,0,1-.354,2.2,5.286,5.286,0,0,1-2.378,2.309,3.828,3.828,0,0,1-2.081.382A3.892,3.892,0,0,1,7.76,9.478Z" transform="translate(0)" fill="#fff"/> </svg>'),
	];
	register_post_type( "workshop", $args );
}
add_action( 'init', 'workshop_register_cpts' );


/**
 * Add Meta Box.
*/
function add_workshop_meta_box() {
	add_meta_box(
		'workshop_meta_box',
		'Post: Workshops',
		'display_workshop_meta_box',
		'workshop',
		'advanced',
		'high'
	);
}
add_action('add_meta_boxes', 'add_workshop_meta_box');


/**
 * Displat Meta fields.
 */
function display_workshop_meta_box($post) {

	global $editIcon;
	global $deleteIcon;

	/**  Add nonce for security and authentication */
   	wp_nonce_field('save_workshop_meta_box', 'workshop_meta_box_nonce');

	/** Tab: Workshop Details */
   	$workshop_date = get_post_meta($post->ID, '_workshop_date', true);
   	$workshop_title = get_post_meta($post->ID, '_workshop_title', true);
   	$workshop_duration = get_post_meta($post->ID, '_workshop_duration', true);
   	$workshop_location = get_post_meta($post->ID, '_workshop_location', true);
   	$workshop_contact_number = get_post_meta($post->ID, '_workshop_contact_number', true);
   	$workshop_form = get_post_meta($post->ID, '_workshop_form', true);
   	$workshop_url = get_post_meta($post->ID, '_workshop_url', true);
   	$workshop_redirect = get_post_meta($post->ID, '_workshop_redirect', true);

	/** Tab: Workshop Future */
	$workshop_future_title = get_post_meta($post->ID, '_workshop_future_title', true);
	$workshop_future_description = get_post_meta($post->ID, '_workshop_future_description', true);

	/** Tab: Host Details */
	$workshop_host_image = get_post_meta($post->ID, '_workshop_host_image', true);
	$workshop_host_by_title = get_post_meta($post->ID, '_workshop_host_by_title', true);
	$workshop_host_name = get_post_meta($post->ID, '_workshop_host_name', true);
	$workshop_host_designation = get_post_meta($post->ID, '_workshop_host_designation', true);
	$workshop_host_info = get_post_meta($post->ID, '_workshop_host_info', true);
	$workshop_highlight_text = get_post_meta($post->ID, '_workshop_highlight_text', true);

	?>
	<div class="team-meta-box">

		<div class="nav-tab-wrapper">
			<a href="#" class="nav-tab nav-tab-active" data-tab="workshop-details">Workshop Details</a>
			<a href="#" class="nav-tab" data-tab="workshop-future">Workshop Future</a>
			<a href="#" class="nav-tab" data-tab="host-details">Host/Author Details</a>
		</div>

		<div id="workshop-details" class="tab-content">
			
			<div class="meta-field">
				<label for="workshop_date">Workshop Date</label>
				<input type="text" name="workshop_date" id="workshop_date" value="<?php echo esc_attr($workshop_date); ?>" placeholder="Enter date in format YYYY-MM-DD" />
			</div>
			<div class="two-column">
				<div class="meta-field">
					<label for="workshop_title">Workshop Title</label>
					<input type="text" name="workshop_title" id="workshop_title" value="<?php echo esc_attr($workshop_title); ?>" />
				</div>
				<div class="meta-field">
					<label for="workshop_duration">Workshop Duration</label>
					<input type="text" name="workshop_duration" id="workshop_duration" value="<?php echo esc_attr($workshop_duration); ?>" />
				</div>
			</div>
			<div class="two-column">
				<div class="meta-field">
					<label for="workshop_location">Workshop Location</label>
					<input type="text" name="workshop_location" id="workshop_location" value="<?php echo esc_attr($workshop_location); ?>" />
				</div>
				<div class="meta-field">
					<label for="workshop_contact_number">Workshop Contact Number</label>
					<input type="text" name="workshop_contact_number" id="workshop_contact_number" value="<?php echo esc_attr($workshop_contact_number); ?>" />
				</div>
			</div>
			<div class="meta-field">
				<label for="workshop_form">Workshop Form</label>
				<input type="text" name="workshop_form" id="workshop_form" value="<?php echo esc_attr($workshop_form); ?>" />
			</div>
			<div class="two-column">
				<div class="meta-field">
					<label for="workshop_url">Workshop URL</label>
					<input type="text" name="workshop_url" id="workshop_url" value="<?php echo esc_attr($workshop_url); ?>" />
				</div>
				<div class="meta-field">
					<label for="workshop_redirect">Redirect on Single Page</label>
					<input type="checkbox" name="workshop_redirect" value="1" <?php checked($workshop_redirect, '1'); ?> >Check to redirect on details page instead of third party URL.</input>
				</div>
			</div>
		</div>

		<div id="workshop-future" class="tab-content" style="display:none;">
			<div class="meta-field">
				<label for="workshop_future_title">Workshop Future Title</label>
				<input type="text" name="workshop_future_title" id="workshop_future_title" value="<?php echo esc_attr($workshop_future_title); ?>" />
			</div>
			<div class="meta-field">
				<label for="workshop_future_description">Workshop Future Description</label>
				<textarea rows="4" name="workshop_future_description" id="workshop_future_description"><?php echo esc_attr($workshop_future_description); ?></textarea>
			</div>
		</div>

		<div id="host-details" class="tab-content" style="display:none;">
			<div class="meta-field">
				<label for="workshop_host_image">Host Image</label>
				<div class="meta-image">
					<img id="workshop_host_image_preview" src="<?php echo esc_attr($workshop_host_image); ?>" style="max-width: 180px; height: auto; background:#f1f1f1;" />
					<div cass="action-item">
						<button type="button" class="action-icon edit" id="upload_host_image_button"><?php echo $editIcon;?></button>
						<button type="button" class="action-icon delete" id="remove_host_image_button"><?php echo $deleteIcon;?></button>
					</div>
				</div>
				<input type="hidden" name="workshop_host_image" id="workshop_host_image" value="<?php echo esc_attr($workshop_host_image); ?>" />
			</div>
			<div class="meta-field">
				<label for="workshop_host_by_title">Host By Title</label>
				<input type="text" name="workshop_host_by_title" id="workshop_host_by_title" value="<?php echo esc_attr($workshop_host_by_title); ?>" />
			</div>
			<div class="two-column">
				<div class="meta-field">
					<label for="workshop_host_name">Host Name</label>
					<input type="text" name="workshop_host_name" id="workshop_host_name" value="<?php echo esc_attr($workshop_host_name); ?>" />
				</div>
				<div class="meta-field">
					<label for="workshop_host_designation">Host Designation</label>
					<input type="text" name="workshop_host_designation" id="workshop_host_designation" value="<?php echo esc_attr($workshop_host_designation); ?>" />
				</div>
			</div>
			<div class="meta-field">
				<label for="workshop_host_info">Host Info</label>
				<textarea rows="4" name="workshop_host_info" id="workshop_host_info"><?php echo esc_attr($workshop_host_info); ?></textarea>
			</div>
			<div class="meta-field">
				<label for="workshop_highlight_text">Highlight Text</label>
				<input type="text" name="workshop_highlight_text" id="workshop_highlight_text" value="<?php echo esc_attr($workshop_highlight_text); ?>" />
			</div>
		</div>
	</div>

	<?php
}


/**
 * Save Meta fields.
 */
function save_workshop_meta_box($post_id) {

	/** Save Workshop Details fields */
	if (array_key_exists('workshop_date', $_POST)) {
        update_post_meta($post_id, '_workshop_date', sanitize_text_field($_POST['workshop_date']));
    }
    if (array_key_exists('workshop_title', $_POST)) {
        update_post_meta($post_id, '_workshop_title', sanitize_text_field($_POST['workshop_title']));
    }
    if (array_key_exists('workshop_duration', $_POST)) {
        update_post_meta($post_id, '_workshop_duration', sanitize_text_field($_POST['workshop_duration']));
    }
    if (array_key_exists('workshop_location', $_POST)) {
        update_post_meta($post_id, '_workshop_location', sanitize_text_field($_POST['workshop_location']));
    }
    if (array_key_exists('workshop_contact_number', $_POST)) {
        update_post_meta($post_id, '_workshop_contact_number', sanitize_text_field($_POST['workshop_contact_number']));
    }
    if (array_key_exists('workshop_form', $_POST)) {
        update_post_meta($post_id, '_workshop_form', sanitize_text_field($_POST['workshop_form']));
    }
    if (array_key_exists('workshop_url', $_POST)) {
        update_post_meta($post_id, '_workshop_url', sanitize_text_field($_POST['workshop_url']));
    }
	if (isset($_POST['workshop_redirect'])) {
        update_post_meta($post_id, '_workshop_redirect', '1');
    } else {
        update_post_meta($post_id, '_workshop_redirect', '0');
    }

	/** Save Workshop Future fields */
    if (array_key_exists('workshop_future_title', $_POST)) {
        update_post_meta($post_id, '_workshop_future_title', sanitize_text_field($_POST['workshop_future_title']));
    }
    if (array_key_exists('workshop_future_description', $_POST)) {
		update_post_meta($post_id, '_workshop_future_description', sanitize_textarea_field($_POST['workshop_future_description']));
    }

	/** Save Host Details fields */
    if (array_key_exists('workshop_host_image', $_POST)) {
        update_post_meta($post_id, '_workshop_host_image', sanitize_text_field($_POST['workshop_host_image']));
    }
    if (array_key_exists('workshop_host_by_title', $_POST)) {
        update_post_meta($post_id, '_workshop_host_by_title', sanitize_text_field($_POST['workshop_host_by_title']));
    }
    if (array_key_exists('workshop_host_name', $_POST)) {
        update_post_meta($post_id, '_workshop_host_name', sanitize_text_field($_POST['workshop_host_name']));
    }
    if (array_key_exists('workshop_host_designation', $_POST)) {
        update_post_meta($post_id, '_workshop_host_designation', sanitize_text_field($_POST['workshop_host_designation']));
    }
    if (array_key_exists('workshop_host_info', $_POST)) {
        update_post_meta($post_id, '_workshop_host_info', sanitize_textarea_field($_POST['workshop_host_info']));
    }
    if (array_key_exists('workshop_highlight_text', $_POST)) {
        update_post_meta($post_id, '_workshop_highlight_text', sanitize_text_field($_POST['workshop_highlight_text']));
    }
}
add_action('save_post', 'save_workshop_meta_box');


/**
 * Add Meta in REST API.
 */
function add_workshop_meta_to_rest_response($response, $post, $context) {

    if ($post->post_type === 'workshop') {

		/** Workshop Details meta */
        $response->data['workshop_date'] = get_post_meta($post->ID, '_workshop_date', true);
        $response->data['workshop_title'] = get_post_meta($post->ID, '_workshop_title', true);
        $response->data['workshop_duration'] = get_post_meta($post->ID, '_workshop_duration', true);
        $response->data['workshop_location'] = get_post_meta($post->ID, '_workshop_location', true);
        $response->data['workshop_contact_number'] = get_post_meta($post->ID, '_workshop_contact_number', true);
        $response->data['workshop_form'] = get_post_meta($post->ID, '_workshop_form', true);
        $response->data['workshop_url'] = get_post_meta($post->ID, '_workshop_url', true);
        $response->data['workshop_redirect'] = get_post_meta($post->ID, '_workshop_redirect', true);

		/** Workshop Future meta */
        $response->data['workshop_future_title'] = get_post_meta($post->ID, '_workshop_future_title', true);
        $response->data['workshop_future_description'] = get_post_meta($post->ID, '_workshop_future_description', true);

		/** Host Details meta */
        $response->data['workshop_host_image'] = get_post_meta($post->ID, '_workshop_host_image', true);
        $response->data['workshop_host_by_title'] = get_post_meta($post->ID, '_workshop_host_by_title', true);
        $response->data['workshop_host_name'] = get_post_meta($post->ID, '_workshop_host_name', true);
        $response->data['workshop_host_designation'] = get_post_meta($post->ID, '_workshop_host_designation', true);
        $response->data['workshop_host_info'] = get_post_meta($post->ID, '_workshop_host_info', true);
        $response->data['workshop_highlight_text'] = get_post_meta($post->ID, '_workshop_highlight_text', true);

    }
    return $response;

}
add_filter('rest_prepare_workshop', 'add_workshop_meta_to_rest_response', 10, 3);
