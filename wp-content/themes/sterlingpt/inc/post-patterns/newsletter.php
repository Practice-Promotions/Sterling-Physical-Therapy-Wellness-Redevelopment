<?php
/**
* Newsletter functions and definitions and Meta related things.
*
* @package herostencilpt
*/

function newsletter_register_cpts() {

	/**
	 * Post Type: Newsletters.
	 */
	$labels = [
		"name" => __( "Newsletters", "herostencilpt" ),
		"singular_name" => __( "Newsletter", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Newsletters", "herostencilpt" ),
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
		"rewrite" => [ "slug" => "newsletter", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "excerpt", "editor", "thumbnail" ],
		"show_in_graphql" => false,
		"menu_icon" => 'dashicons-media-document',
	];
	register_post_type( "newsletter", $args );
}
add_action( 'init', 'newsletter_register_cpts' );

function add_newsletter_services_meta_box() {
    add_meta_box(
        'newsletter_services_meta_box',
        'Newsletter Services',
        'display_newsletter_services_meta_box',
        'newsletter',
        'advanced',
        'high'
    );
}
add_action('add_meta_boxes', 'add_newsletter_services_meta_box');

function display_newsletter_services_meta_box($post) {
    // Add nonce for security
    wp_nonce_field('save_newsletter_services_meta_box', 'newsletter_services_meta_box_nonce');

    // Retrieve existing meta values if they exist
    $newsletter_url = get_post_meta($post->ID, '_newsletter_url', true);
    $newsletter_services = get_post_meta($post->ID, '_newsletter_services', true) ?: [];

    ?>

    <h2 class="nav-tab-wrapper">
        <a href="#" class="nav-tab nav-tab-active" data-tab="newsletter-data-container">Newsletter Data</a>
        <a href="#" class="nav-tab" data-tab="newsletter-services-tab">Newsletter Services</a>
    </h2>

    <div id="newsletter-data-container" class="tab-content">
        <div class="meta-field">
            <label for="newsletter_url">Newsletter URL:</label>
            <input type="url" id="newsletter_url" name="newsletter_url" value="<?php echo esc_attr($newsletter_url); ?>" style="width: 100%;" placeholder="Add third-party newsletter URL, if available." />
        </div>
    </div>

    <div id="newsletter-services-tab" class="tab-content" style="display:none;">
        <div id="newsletter-services-container">
            <?php foreach ($newsletter_services as $index => $service): ?>
                <div class="three-column newsletter-service-row">
                    <div class="meta-field">
                        <label>Newsletter Service Title:</label>
                        <input type="text" name="newsletter_services[<?php echo $index; ?>][title]" value="<?php echo esc_attr($service['title']); ?>" />
                    </div>
                    
                    <div class="meta-field">
                        <label>Newsletter Service Image:</label>
                        <input type="hidden" class="newsletter-service-image" name="newsletter_services[<?php echo $index; ?>][image]" value="<?php echo esc_url($service['image']); ?>" />
                        <img class="newsletter-service-image-preview" src="<?php echo esc_url($service['image']); ?>" style="max-width: 150px; height: auto; <?php echo $service['image'] ? '' : 'display:none;'; ?>" />
                        <button type="button" class="button select-media"><?php _e('Select Image', 'herostencilpt'); ?></button>
                        <button type="button" class="button remove-media" style="<?php echo $service['image'] ? '' : 'display:none;'; ?>"><?php _e('Remove Image', 'herostencilpt'); ?></button>
                    </div>

                    <div class="meta-field">
                        <label>Newsletter Service Text:</label>
                        <textarea name="newsletter_services[<?php echo $index; ?>][text]" rows="8"><?php echo esc_textarea($service['text']); ?></textarea>
                    </div>

                    <a href="#" class="remove-newsletter-service remove-repeater-item action-icon icon-close"></a>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-newsletter-service" class="button">Add Row</button>
    </div>
	

    <script>
        jQuery(document).ready(function($) {
            function addNewServiceRow(index) {
                const newRow = `
                    <div class="three-column newsletter-service-row repeater-item">
						<div class="meta-field">
							<label>Newsletter Service Title:</label>
							<input type="text" name="newsletter_services[${index}][title]" />
						</div>

						<div class="meta-field">
							<label>Newsletter Service Image:</label>
							<input type="hidden" class="newsletter-service-image" name="newsletter_services[${index}][image]" />
							<img class="newsletter-service-image-preview" src="" style="max-width: 150px; height: auto; display:none;" />
							<button type="button" class="button select-media">Select Image</button>
							<button type="button" class="button remove-media" style="display:none;">Remove Image</button>
						</div>	

						<div class="meta-field">
							<label>Newsletter Service Text:</label>
							<textarea name="newsletter_services[${index}][text]" rows="8"></textarea>
						</div>

						<a href="#" class="remove-newsletter-service  remove-repeater-item action-icon icon-close"></a>
                    </div>
                `;
                $('#newsletter-services-container').append(newRow);
            }

            $('#add-newsletter-service').click(function() {
                const index = $('#newsletter-services-container .newsletter-service-row').length;
                addNewServiceRow(index);
            });

            $(document).on('click', '.remove-newsletter-service', function() {
                $(this).closest('.newsletter-service-row').remove();
            });

            // Image upload and preview
            $(document).on('click', '.select-media', function(e) {
                e.preventDefault();
                const button = $(this);
                const input = button.siblings('.newsletter-service-image');
                const preview = button.siblings('.newsletter-service-image-preview');
                const removeButton = button.siblings('.remove-media');

                const frame = wp.media({
                    title: 'Select or Upload Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function() {
                    const attachment = frame.state().get('selection').first().toJSON();
                    input.val(attachment.url);
                    preview.attr('src', attachment.url).show();
                    removeButton.show();
                });

                frame.open();
            });

            // Remove image and hide preview
            $(document).on('click', '.remove-media', function(e) {
                e.preventDefault();
                const button = $(this);
                const input = button.siblings('.newsletter-service-image');
                const preview = button.siblings('.newsletter-service-image-preview');

                input.val('');
                preview.hide();
                button.hide();
            });
        });
    </script>
    <?php
}


function save_newsletter_services_meta_box($post_id) {
    if (get_post_type($post_id) === 'newsletter') {
        if (!isset($_POST['newsletter_services_meta_box_nonce']) || !wp_verify_nonce($_POST['newsletter_services_meta_box_nonce'], 'save_newsletter_services_meta_box')) {
            return;
        }

        // Save Newsletter URL
         if (isset($_POST['newsletter_url'])) {
            update_post_meta($post_id, '_newsletter_url', esc_url_raw($_POST['newsletter_url']));
        } else {
            delete_post_meta($post_id, '_newsletter_url');
        }

        // Sanitize and save newsletter services
        if (isset($_POST['newsletter_services']) && is_array($_POST['newsletter_services'])) {
            $sanitized_services = [];
            foreach ($_POST['newsletter_services'] as $service) {
                $sanitized_services[] = [
                    'title' => sanitize_text_field($service['title']),
                    'image' => esc_url_raw($service['image']),
                    'text' => sanitize_textarea_field($service['text']),
                ];
            }
            update_post_meta($post_id, '_newsletter_services', $sanitized_services);
        } else {
            delete_post_meta($post_id, '_newsletter_services');
        }
    }
}
add_action('save_post', 'save_newsletter_services_meta_box');
