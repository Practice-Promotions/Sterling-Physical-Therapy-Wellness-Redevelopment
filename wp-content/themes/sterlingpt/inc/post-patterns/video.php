<?php
/**
* Video functions and definitions and Meta related things.
*
* @package herostencilpt
*/

function video_register_cpts() {

	/**
	 * Post Type: Videos.
	 */
	$labels = [
		"name" => __( "Videos", "herostencilpt" ),
		"singular_name" => __( "Video", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Videos", "herostencilpt" ),
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
		"rewrite" => [ "slug" => "video", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
		"menu_icon" => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45"><path d="M22,44A22,22,0,0,1,6.444,6.444,22,22,0,0,1,37.556,37.556,21.857,21.857,0,0,1,22,44ZM17.443,12.884a.912.912,0,0,0-.912.911V30.2a.91.91,0,0,0,.911.912.9.9,0,0,0,.493-.145l12.763-8.2a.911.911,0,0,0,0-1.533l-12.763-8.2A.9.9,0,0,0,17.443,12.884Z" transform="translate(0.5 0.5)" fill="#fff"/></svg>'),
	];
	register_post_type( "video", $args );

}
add_action( 'init', 'video_register_cpts' );



/**
 * Add Meta Box.
 */
function add_video_meta_box() {
    add_meta_box(
        'video_meta_box',
        'Post: Video',
        'display_video_meta_box',
        'video',
        'advanced',
        'high',
		'register_video_meta'
    );
}
add_action('add_meta_boxes', 'add_video_meta_box');


/**
 * Displat Meta fields.
 */
function display_video_meta_box($post) {

	global $editIcon, $deleteIcon;

	// Add nonce for security and authentication
   wp_nonce_field('save_video_meta_box', 'video_meta_box_nonce');

   $video_type = get_post_meta($post->ID, '_video_type', true);
   $youtube_video = get_post_meta($post->ID, '_youtube_video', true);
   $vimeo_video = get_post_meta($post->ID, '_vimeo_video', true);
   $upload_video = get_post_meta($post->ID, '_upload_video', true);


	if (!empty($upload_video)) {
		$attachment_id = attachment_url_to_postid($upload_video);

		// Get the file title, filename, and file size
		$file_title = get_the_title($attachment_id);
		$file_url = wp_get_attachment_url($attachment_id);
		$file_path = get_attached_file($attachment_id);
		$file_name = basename($file_path);
		$file_size = size_format(filesize($file_path));
	} else {
		 $file_title = $file_name = $file_size = '';
	}

    ?>
    <div class="video-meta-box">
        <div class="tab-content">
			<div class="meta-field">
				<label for="video_type">Select Video Type</label>
				<select name="video_type" id="video_type">
					<option value="">-- Select Option --</option>
					<option value="YouTube" <?php selected($video_type, 'YouTube'); ?>>YouTube</option>
					<option value="Vimeo" <?php selected($video_type, 'Vimeo'); ?>>Vimeo</option>
					<option value="Upload" <?php selected($video_type, 'Upload'); ?>>Upload</option>
				</select>
			</div>
			<div class="meta-field youtube-video-field" style="display: none;">
                <label for="youtube_video">YouTube Video</label>
                <input type="text" name="youtube_video" id="youtube_video" value="<?php echo esc_attr($youtube_video); ?>" />
            </div>
            <div class="meta-field vimeo-video-field" style="display: none;">
                <label for="vimeo_video">Vimeo Video</label>
                <input type="text" name="vimeo_video" id="vimeo_video" value="<?php echo esc_attr($vimeo_video); ?>" />
            </div>
			<div class="meta-field upload-video-field" style="display: none;">
                <label for="upload_video">Upload Video</label>
                <div class="meta-image">
					<div id="upload_video_preview" class="file-part">
						<div class="file-video">
							<img src="<?php echo get_theme_file_uri() .'/assets/images/video.png'; ?>" alt="<?php echo esc_html($file_title); ?>" />
						</div>
						<div class="file-info">
							<?php if($file_title) { ?>
								<div>
									<strong>File Title:</strong>
									<span data-name="title"><?php echo esc_html($file_title); ?></span>
								</div>
							<?php } ?>
							<?php if($file_name) { ?>
								<div>
									<strong>File name:</strong>
									<a data-name="filename" href="<?php echo esc_attr($upload_video); ?>" target="_blank"><?php echo esc_html($file_name); ?></a>
								</div>
							<?php } ?>
							<?php if($file_size) { ?>
								<div>
									<strong>File size:</strong>
									<span data-name="filesize"><?php echo esc_html($file_size); ?></span>
								</div>
							<?php } ?>
						</div>
					</div>
                    <div class="action-item">
                        <button type="button" class="action-icon edit upload_video_button" id="upload_video_button"><?php echo $editIcon; ?></button>
                        <button type="button" class="action-icon delete remove_video_button" id="remove_video_button"><?php echo $deleteIcon; ?></button>
                    </div>
                </div>
                <input type="hidden" name="upload_video" id="upload_video" value="<?php echo esc_attr($upload_video); ?>" />
            </div>
		</div>
    </div>
    <?php
}

/**
 * Save Meta fields.
 */
function save_video_meta_box($post_id) {
	if (get_post_type( $post_id ) === 'video') {


		if (array_key_exists('video_type', $_POST)) {
           update_post_meta($post_id, '_video_type', sanitize_text_field($_POST['video_type']));
       }
	   if (array_key_exists('youtube_video', $_POST)) {
		   update_post_meta($post_id, '_youtube_video', sanitize_text_field($_POST['youtube_video']));
	   }
		if (array_key_exists('vimeo_video', $_POST)) {
			update_post_meta($post_id, '_vimeo_video', sanitize_text_field($_POST['vimeo_video']));
		}
		if (array_key_exists('upload_video', $_POST)) {
			update_post_meta($post_id, '_upload_video', sanitize_text_field($_POST['upload_video']));
		}
	}
}
add_action('save_post', 'save_video_meta_box');
