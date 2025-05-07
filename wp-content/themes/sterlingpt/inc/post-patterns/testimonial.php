<?php
/**
* Testimonial functions, definitions and Meta related things.
*
* @package herostencilpt
*/


/** Post Type: Testimonials. */
function testimonial_register_cpts() {

	$labels = [
		"name" => __( "Testimonials", "herostencilpt" ),
		"singular_name" => __( "Testimonial", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Testimonials", "herostencilpt" ),
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
		"rewrite" => [ "slug" => "testimonial", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"show_in_graphql" => false,
		"menu_icon" => 'dashicons-format-quote',
	];
	register_post_type( "testimonial", $args );

}
add_action( 'init', 'testimonial_register_cpts' );


/** Taxonomy: Testimonial Categories. */
function testimonial_register_taxes() {

	$labels = [
		"name" => __( "Testimonial Categories", "herostencilpt" ),
		"singular_name" => __( "Testimonial Category", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Testimonial Categories", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'testimonial-category', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "testimonial_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "testimonial_category", [ "testimonial" ], $args );

}
add_action( 'init', 'testimonial_register_taxes' );


/**  Add Meta Box. */
function add_testimonial_video_meta_box() {
    add_meta_box(
        'testimonial_video_meta_box',
        'Post: Testimonial',
        'display_testimonial_video_meta_box',
        'testimonial',
        'advanced',
        'high',
		'register_testimonial_video_meta'
    );
}
add_action('add_meta_boxes', 'add_testimonial_video_meta_box');


/** Display Meta fields. */
function display_testimonial_video_meta_box($post) {

	global $editIcon, $deleteIcon;

    // Add nonce for security and authentication
    wp_nonce_field('save_testimonial_video_meta_box', 'testimonial_video_meta_box_nonce');

	$testimonial_title = get_post_meta($post->ID, '_testimonial_title', true);
    $testimonial_video_type = get_post_meta($post->ID, '_testimonial_video_type', true);
    $testimonial_youtube_video = get_post_meta($post->ID, '_testimonial_youtube_video', true);
    $testimonial_vimeo_video = get_post_meta($post->ID, '_testimonial_vimeo_video', true);
    $testimonial_upload_video = get_post_meta($post->ID, '_testimonial_upload_video', true);

    // Prepare upload video file info if it exists
    if (!empty($testimonial_upload_video)) {
        $testimonial_attachment_id = attachment_url_to_postid($testimonial_upload_video);
        $testimonial_file_title = get_the_title($testimonial_attachment_id);
        $testimonial_file_name = basename(get_attached_file($testimonial_attachment_id));
        $testimonial_file_size = size_format(filesize(get_attached_file($testimonial_attachment_id)));
    } else {
        $testimonial_file_title = $testimonial_file_name = $testimonial_file_size = '';
    }

    ?>
    <div class="video-meta-box">
        <div class="tab-content">
			<div class="meta-field">
                <label for="testimonial_title">Testimonial Title</label>
                <input type="text" name="testimonial_title" id="testimonial_title" value="<?php echo esc_attr($testimonial_title); ?>" />
            </div>
            <div class="meta-field">
                <label for="testimonial_video_type">Select Video Type</label>
                <select name="testimonial_video_type" id="testimonial_video_type">
                    <option value="">-- Select Option --</option>
                    <option value="YouTube" <?php selected($testimonial_video_type, 'YouTube'); ?>>YouTube</option>
                    <option value="Vimeo" <?php selected($testimonial_video_type, 'Vimeo'); ?>>Vimeo</option>
                    <option value="Upload" <?php selected($testimonial_video_type, 'Upload'); ?>>Upload</option>
                </select>
            </div>
            <div class="meta-field youtube-video-field" style="display: none;">
                <label for="testimonial_youtube_video">YouTube Video</label>
                <input type="text" name="testimonial_youtube_video" id="testimonial_youtube_video" value="<?php echo esc_attr($testimonial_youtube_video); ?>" />
            </div>
            <div class="meta-field vimeo-video-field" style="display: none;">
                <label for="testimonial_vimeo_video">Vimeo Video</label>
                <input type="text" name="testimonial_vimeo_video" id="testimonial_vimeo_video" value="<?php echo esc_attr($testimonial_vimeo_video); ?>" />
            </div>
            <div class="meta-field upload-video-field" style="display: none;">
                <label for="testimonial_upload_video">Upload Video</label>
                <div class="meta-image">
                    <div id="upload_testimonial_video_preview" class="file-part">
                        <div class="file-video">
                            <img src="<?php echo get_theme_file_uri() . '/assets/images/video.png'; ?>" alt="<?php echo esc_html($testimonial_file_title); ?>" />
                        </div>
                        <div class="file-info">
                            <div>
                                <strong>File Title:</strong>
                                <span data-name="title"><?php echo esc_html($testimonial_file_title); ?></span>
                            </div>
                            <div>
                                <strong>File name:</strong>
                                <a data-name="filename" href="<?php echo esc_attr($testimonial_upload_video); ?>" target="_blank"><?php echo esc_html($testimonial_file_name); ?></a>
                            </div>
                            <div>
                                <strong>File size:</strong>
                                <span data-name="filesize"><?php echo esc_html($testimonial_file_size); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="action-item">
                        <button type="button" class="action-icon edit upload_video_button" id="upload_testimonial_video_button"><?php echo $editIcon; ?></button>
                        <button type="button" class="action-icon delete remove_video_button" id="remove_testimonial_video_button"><?php echo $deleteIcon; ?></button>
                    </div>
                </div>
                <input type="hidden" name="testimonial_upload_video" id="testimonial_upload_video" value="<?php echo esc_attr($testimonial_upload_video); ?>" />
            </div>
        </div>
    </div>
    <?php
}


/** Save Meta fields. */
function save_testimonial_video_meta_box($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['testimonial_video_meta_box_nonce'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['testimonial_video_meta_box_nonce'], 'save_testimonial_video_meta_box')) {
        return;
    }
    // If this isn't a valid post type, do nothing.
    if (get_post_type($post_id) !== 'testimonial') {
        return;
    }
    // Check if the current user is authorized to save data.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the data
	if (array_key_exists('testimonial_title', $_POST)) {
        update_post_meta($post_id, '_testimonial_title', sanitize_text_field($_POST['testimonial_title']));
    }
	if (array_key_exists('testimonial_video_type', $_POST)) {
        update_post_meta($post_id, '_testimonial_video_type', sanitize_text_field($_POST['testimonial_video_type']));
    }
    if (array_key_exists('testimonial_youtube_video', $_POST)) {
        update_post_meta($post_id, '_testimonial_youtube_video', sanitize_text_field($_POST['testimonial_youtube_video']));
    }
    if (array_key_exists('testimonial_vimeo_video', $_POST)) {
        update_post_meta($post_id, '_testimonial_vimeo_video', sanitize_text_field($_POST['testimonial_vimeo_video']));
    }
    if (array_key_exists('testimonial_upload_video', $_POST)) {
        update_post_meta($post_id, '_testimonial_upload_video', esc_url_raw($_POST['testimonial_upload_video']));
    }
}
add_action('save_post', 'save_testimonial_video_meta_box');


/** Add Meta in REST API. */
function add_testimonial_video_meta_to_rest_response($response, $post, $request) {
    if ($post->post_type === 'testimonial') {
        // Add Testimonial Video Details meta
        $response->data['testimonial_title'] = get_post_meta($post->ID, '_testimonial_title', true);
        $response->data['testimonial_video_type'] = get_post_meta($post->ID, '_testimonial_video_type', true);
        $response->data['testimonial_youtube_video'] = get_post_meta($post->ID, '_testimonial_youtube_video', true);
        $response->data['testimonial_vimeo_video'] = get_post_meta($post->ID, '_testimonial_vimeo_video', true);
        $response->data['testimonial_upload_video'] = get_post_meta($post->ID, '_testimonial_upload_video', true);
    }
    return $response;
}
add_filter('rest_prepare_testimonial', 'add_testimonial_video_meta_to_rest_response', 10, 3);


/** AJAX: testimonials category based listing */
add_action('wp_ajax_testimonial_category_filter', 'testimonial_category_filter');
add_action('wp_ajax_nopriv_testimonial_category_filter', 'testimonial_category_filter');
function testimonial_category_filter() {

	global $iconquotestart;

	$dataid = $_POST['dataid'];
	if ( $dataid == 'all' ) :
		$testimonialargs = array(
			'post_type'      => 'testimonial',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1
		);
	else :
		$testimonialargs = array(
			'post_type'      => 'testimonial',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'testimonial_category',
					'field'    => 'term_id',
					'terms'    => $dataid
				)
			)
		);
	endif;
	$testimonialquery = new WP_Query( $testimonialargs );

	if ( $testimonialquery->have_posts() ) {
		echo '<div class="testimonial-list">';

		while ($testimonialquery->have_posts()) : $testimonialquery->the_post();

			// Custom Meta
            $testimonial_title = get_post_meta(get_the_ID(), '_testimonial_title', true);
			$testimonial_video_type = get_post_meta(get_the_ID(), '_testimonial_video_type', true);
			$testimonial_youtube_video = get_post_meta(get_the_ID(), '_testimonial_youtube_video', true);
			$testimonial_vimeo_video = get_post_meta(get_the_ID(), '_testimonial_vimeo_video', true);
			$testimonial_upload_video = get_post_meta(get_the_ID(), '_testimonial_upload_video', true);

			if ( $testimonial_video_type || get_the_content() ) {
				echo '<div class="testimonial-item '.( ($testimonial_youtube_video || $testimonial_vimeo_video || $testimonial_upload_video ) ?'has-video' :'').'">' .
					'<div class="testimonial-item-inner">';
						if ( $testimonial_video_type && ($testimonial_youtube_video || $testimonial_vimeo_video || $testimonial_upload_video) ) {
							echo '<div class="video-media">' .
								(
									( $testimonial_video_type == 'YouTube' && $testimonial_youtube_video )
									? '<a data-fancybox href="https://www.youtube.com/watch?v=' . esc_attr($testimonial_youtube_video) . '" class="d-block">' .
									(
										has_post_thumbnail()
										? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
										: '<figure><img src="https://img.youtube.com/vi/' . esc_attr($testimonial_youtube_video) . '/0.jpg" alt="' . esc_attr(get_the_title()) . '"></figure>'
									) .
									'</a>'
									: ''
								) .
								(
									( $testimonial_video_type == 'Vimeo' && $testimonial_vimeo_video )
									? '<a data-fancybox href="https://vimeo.com/' . esc_attr($testimonial_vimeo_video) . '" class="d-block">' .
									(
										has_post_thumbnail()
										? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
										: placeholder_image(esc_attr(get_the_title()))
									) .
									'</a>'
									: ''
								) .
								(
									( $testimonial_video_type == 'Upload' && !empty($testimonial_upload_video) )
									? '<a data-fancybox href="' . esc_url(is_array($testimonial_upload_video) ? $testimonial_upload_video['url'] : $testimonial_upload_video) . '" class="d-block">' .
									(
										has_post_thumbnail()
										? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
										: placeholder_image(esc_attr(get_the_title()))
									) .
									'</a>'
									: ''
								) .
								'<span class="icon-play"></span>' .
							'</div>' ;
						}
						echo '<div class="testimonial-item-quote">' .
								'<div class="quote-icon start">' . $iconquotestart . '</div>' .
								(
                                    $testimonial_title
                                    ? '<h3>'. $testimonial_title . '</h3>'
                                    : ''
                                ).
								apply_filters('the_content', get_the_content()) .
								'<h4 class="h5">~ ' . get_the_title() . '</h4>' .
							'</div>' .
							'<div class="testimonial-media">' .
								(
									has_post_thumbnail(get_the_ID())
									? '<figure>' . wp_get_attachment_image(get_post_thumbnail_id(), 'medium') . '</figure>'
									: placeholder_image(esc_attr(get_the_title()))
								) .
							'</div>' .
						'</div>' .
				'</div>';
			}
		endwhile; wp_reset_postdata();
		echo '</div>';
	}
	wp_die();
}
