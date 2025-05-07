<?php
/**
* Location functions and definitions and Meta related things.
*
* @package herostencilpt
*/

function location_register_cpts() {
	/**
	 * Post Type: Locations.
	 */
	$labels = [
		"name" => __( "Locations", "herostencilpt" ),
		"singular_name" => __( "Our Location", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Locations", "herostencilpt" ),
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
		"rewrite" => [ "slug" => "physical-therapy-clinic", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields" ],
		"show_in_graphql" => true,
		"menu_icon" => 'dashicons-admin-multisite',
	];
	register_post_type( "location", $args );
}
add_action( 'init', 'location_register_cpts' );

function location_register_taxes() {

	/**
	 * Taxonomy: Location Specialties.
	 */
	$labels = [
		"name" => __( "Location Specialties", "herostencilpt" ),
		"singular_name" => __( "Location Specialty", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Location Specialties", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'location-specialty', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "location_specialty",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "location_specialty", [ "location" ], $args );

	/**
	 * Taxonomy: Location Categories.
	 */
	$labels = [
		"name" => __( "Location Categories", "herostencilpt" ),
		"singular_name" => __( "Location Category", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Location Categories", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'location-category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "location_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "location_category", [ "location", "our_team" ], $args );

}
add_action( 'init', 'location_register_taxes' );



function add_location_meta_box() {
    add_meta_box(
        'location_meta_box',
        'Post: Our location',
        'display_location_meta_box',
        'location',
        'advanced',
        'high',
		'register_location_meta'
    );
}
add_action('add_meta_boxes', 'add_location_meta_box');


function display_location_meta_box($post) {
    // Add nonce for security and authentication
    wp_nonce_field('save_location_meta_box', 'location_meta_box_nonce');

    $location_custom_title = get_post_meta($post->ID, '_location_custom_title', true);
    $location_phone = get_post_meta($post->ID, '_location_phone_number', true);
    $location_email = get_post_meta($post->ID, '_location_email', true);
    $location_address = get_post_meta($post->ID, '_location_address', true);
    $location_map_link = get_post_meta($post->ID, '_location_map_link', true);
    $location_map_iframe = get_post_meta($post->ID, '_location_map_iframe', true);
    $location_map_latitude = get_post_meta($post->ID, '_location_map_latitude', true);
    $location_map_longitude = get_post_meta($post->ID, '_location_map_longitude', true);
    $location_fax_number = get_post_meta($post->ID, '_location_fax_number', true);
    $location_working_hours = get_post_meta($post->ID, '_location_working_hours', true);
    $location_located_near = get_post_meta($post->ID, '_location_located_near', true);
    $social_media = get_post_meta($post->ID, '_social_media', true) ?: [];
    $social_media = is_array($social_media) ? $social_media : [];

    ?>
    <div class="location-meta-box">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="location-details">Location Details</a>
            <a href="#" class="nav-tab" data-tab="location-map">Location Map</a>
            <a href="#" class="nav-tab" data-tab="social-media-part">Location Social Media</a>
        </h2>
        <div id="location-details" class="tab-content">
            <div class="meta-field">
                <label for="location_custom_title">Location Custom Title</label>
                <input type="text" name="location_custom_title" id="location_custom_title" value="<?php echo esc_attr($location_custom_title); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_phone_number">Location Phone Number</label>
                <input type="text" name="location_phone_number" id="location_phone_number" value="<?php echo esc_attr($location_phone); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_fax_number">Location Fax Number</label>
                <input type="text" name="location_fax_number" id="location_fax_number" value="<?php echo esc_attr($location_fax_number); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_email">Location Email</label>
                <input type="text" name="location_email" id="location_email" value="<?php echo esc_attr($location_email); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_address">Location Address</label>
				<textarea id="location_address" name="location_address" rows="5"><?php echo esc_textarea($location_address); ?></textarea>
            </div>
            <div class="meta-field">
                <label for="location_located_near">Directions Or Located Near</label>
                <input type="text" name="location_located_near" id="location_located_near" value="<?php echo esc_attr($location_located_near); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_map_link">Location Map Link</label>
                <input type="text" name="location_map_link" id="location_map_link" value="<?php echo esc_attr($location_map_link); ?>" />
            </div>

			<div class="meta-field">
				<label for="location_working_hours">Location Working Hours</label>
				<textarea id="location_working_hours" name="location_working_hours" rows="5"><?php echo esc_textarea($location_working_hours); ?></textarea>
			</div>

        </div>
        <div id="location-map" class="tab-content" style="display:none">
			<div class="meta-field">
				<label for="location_map_iframe">Address Map Iframe</label>
				<p class="description">Please add Iframe SRC.</p>
				<textarea id="location_map_iframe" name="location_map_iframe" rows="5"><?php echo esc_textarea($location_map_iframe); ?></textarea>
			</div>
            <div class="meta-field">
                <label for="location_map_latitude">Location Map Latitude</label>
                <input id="location_map_latitude" name="location_map_latitude" value="<?php echo esc_attr($location_map_latitude); ?>" />
            </div>
            <div class="meta-field">
                <label for="location_map_longitude">Location Map Longitude</label>
                <input id="location_map_longitude" name="location_map_longitude" value="<?php echo esc_attr($location_map_longitude); ?>" />
            </div>
        </div>
		<div id="social-media-part" class="tab-content" style="display:none">
			<div id="social-media-fields">
			    <?php foreach ($social_media as $index => $media): ?>
			        <div class="social-media-field">
			            <select name="social_media[<?php echo $index; ?>][name]">
			                <option value="facebook" <?php selected($media['name'], 'facebook'); ?>>Facebook</option>
			                <option value="twitter" <?php selected($media['name'], 'twitter'); ?>>Twitter</option>
			                <option value="instagram" <?php selected($media['name'], 'instagram'); ?>>Instagram</option>
			                <option value="yelp" <?php selected($media['name'], 'yelp'); ?>>Yelp</option>
			                <option value="linkedin" <?php selected($media['name'], 'linkedin'); ?>>LinkedIn</option>
			                <option value="pinterest" <?php selected($media['name'], 'pinterest'); ?>>Pinterest</option>
			                <option value="youtube" <?php selected($media['name'], 'youtube'); ?>>YouTube</option>
			            </select>
			            <input type="text" name="social_media[<?php echo $index; ?>][link]" value="<?php echo esc_attr($media['link']); ?>" placeholder="Link" />
			            <button type="button" class="remove-social-media button button-primary">Remove</button>
			        </div>
			    <?php endforeach; ?>
			</div>
			<button type="button" id="add-social-media" class="button button-primary">Add Social Media</button>
		</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-social-media').addEventListener('click', function() {
                const fieldsDiv = document.getElementById('social-media-fields');
                const index = fieldsDiv.children.length;
                const newField = document.createElement('div');
                newField.className = 'social-media-field';
                newField.innerHTML = `
                    <select name="social_media[${index}][name]">
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter</option>
                        <option value="instagram">Instagram</option>
                        <option value="yelp">Yelp</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="pinterest">Pinterest</option>
                        <option value="youtube">YouTube</option>
                    </select>
                    <input type="text" name="social_media[${index}][link]" placeholder="Link" />
                    <button type="button" class="remove-social-media button-primary">Remove</button>
                `;
                fieldsDiv.appendChild(newField);
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-social-media')) {
                    e.target.parentElement.remove();
                    updateIndices();
                }
            });

            function updateIndices() {
                const fieldsDiv = document.getElementById('social-media-fields');
                const fields = fieldsDiv.children;
                for (let i = 0; i < fields.length; i++) {
                    const select = fields[i].querySelector('select');
                    const input = fields[i].querySelector('input');
                    select.name = `social_media[${i}][name]`;
                    input.name = `social_media[${i}][link]`;
                }
            }
        });
    </script>
    <?php
}

function save_location_meta_box($post_id) {
    if (get_post_type($post_id) === 'location') {
        if (!isset($_POST['location_meta_box_nonce']) || !wp_verify_nonce($_POST['location_meta_box_nonce'], 'save_location_meta_box')) {
            return;
        }

		$fields = [
            'location_custom_title' => '_location_custom_title',
            'location_phone_number' => '_location_phone_number',
            'location_email' => '_location_email',
            'location_map_link' => '_location_map_link',
            'location_fax_number' => '_location_fax_number',
            'location_map_latitude' => '_location_map_latitude',
            'location_map_longitude' => '_location_map_longitude',
            'location_located_near' => '_location_located_near',
        ];

        foreach ($fields as $key => $meta_key) {
            if (array_key_exists($key, $_POST)) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$key]));
            }
        }

		update_post_meta($post_id, '_location_map_iframe', wp_kses_post($_POST['location_map_iframe']));
		update_post_meta($post_id, '_location_working_hours', wp_kses_post($_POST['location_working_hours']));
		update_post_meta($post_id, '_location_address', wp_kses_post($_POST['location_address']));


        // Save repeater field with proper sanitization
        if (isset($_POST['social_media']) && is_array($_POST['social_media'])) {
            $sanitized_social_media = [];

            foreach ($_POST['social_media'] as $index => $media) {
                if (isset($media['name']) && isset($media['link'])) {
                    $sanitized_social_media[$index] = [
                        'name' => sanitize_text_field($media['name']),
                        'link' => esc_url_raw($media['link']),
                    ];
                }
            }

            update_post_meta($post_id, '_social_media', $sanitized_social_media);
        } else {
            update_post_meta($post_id, '_social_media', []);
        }
    }
}
add_action('save_post', 'save_location_meta_box');



/** Location custom title */
function location_custom_title() {
	ob_start();
	$location_custom_title = get_post_meta(get_the_ID(), '_location_custom_title', true);
	if ( $location_custom_title ) :
		echo '<h2 class="h4"><a href="'. get_the_permalink() .'" title="'. $location_custom_title .'">'. $location_custom_title .'</a></h2>';
	else :
		echo '<h2 class="h4"><a href="'. get_the_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h2>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-custom-title', 'location_custom_title' );

/** Location phone number */
function location_phone() {
	ob_start();
	$location_phone_number = get_post_meta(get_the_ID(), '_location_phone_number', true);
	if ( $location_phone_number ) :
		echo '<p class="icon-phone">'.
			'<a href="tel:'. preg_replace( '/[^0-9]/', '', $location_phone_number ) .'">'. $location_phone_number .'</a>'.
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-phone', 'location_phone' );

/** Location email address */
function location_email() {
	ob_start();
	$location_email = get_post_meta(get_the_ID(), '_location_email', true);
	if ( $location_email ) :
		echo '<p class="icon-envelop">'.
			'<a href="mailto:'. $location_email .'">'. $location_email .'</a>'.
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-email', 'location_email' );

/** Location fax number */
function location_fax() {
	ob_start();
	$location_fax_number = get_post_meta(get_the_ID(), '_location_fax_number', true);
	if ( $location_fax_number ) :
		echo '<p class="icon-fax">'.
			$location_fax_number .
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-fax', 'location_fax' );

/** Location address */
function location_address() {
	ob_start();
	$location_address = get_post_meta(get_the_ID(), '_location_address', true);
	$location_map_link = get_post_meta(get_the_ID(), '_location_map_link', true);
	if ( $location_address ) :
		echo '<p class="icon-pin">'.
			'<a rel="noreferrer" href="'. $location_map_link .'" target="_blank" aria-label="Location Address (opens in a new tab)">'. wp_kses_post($location_address) .'</a>'.
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-address', 'location_address' );

/** location hours */
function location_hours() {
	ob_start();
	$location_working_hours = get_post_meta(get_the_ID(), '_location_working_hours', true);
	if ( $location_working_hours ) :
		echo '<p class="location-hours icon-timer">'.
				wp_kses_post($location_working_hours).
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-hours', 'location_hours' );

/** location map function will display map or custom map in footer, contact page, location details page */
function location_map() {
	ob_start();
	$location_map_iframe = get_post_meta(get_the_ID(), '_location_map_iframe', true);
	if ( $location_map_iframe ) {
		echo '<iframe src="'. $location_map_iframe .'" title="locations"></iframe>';
	}
	return ob_get_clean();
}
add_shortcode( 'location-map', 'location_map' );

/** Location fax number */
function location_located() {
	ob_start();
	$location_located_near = get_post_meta(get_the_ID(), '_location_located_near', true);
	if ( $location_located_near ) :
		echo '<p class="icon-flag">'.
			$location_located_near .
		'</p>';
	endif;
	return ob_get_clean();
}
add_shortcode( 'location-located', 'location_located' );


function register_location_meta() {
    $meta_fields = [
        '_location_map_latitude', '_location_map_longitude', '_location_custom_title', '_location_phone_number', '_location_email', '_location_address',
        '_location_map_link', '_location_map_iframe', '_location_fax_number', '_location_working_hours',
        '_location_located_near'
    ];
    foreach ($meta_fields as $field) {
        register_post_meta('location', $field, ['show_in_rest' => true, 'single' => true, 'type' => 'string', ]);
    }
}
add_action('init', 'register_location_meta');

function add_location_meta_to_rest_response($response, $post) {
    if ($post->post_type === 'location') {
        $meta_fields = ['_location_map_latitude', '_location_map_longitude', '_location_custom_title', '_location_phone_number', '_location_email', '_location_address',
                        '_location_map_link', '_location_map_iframe', '_location_working_hours', '_location_located_near'];
        foreach ($meta_fields as $field) {
            $response->data[substr($field, 1)] = get_post_meta($post->ID, $field, true);
        }
    }
    return $response;
}
add_filter('rest_prepare_location', 'add_location_meta_to_rest_response', 10, 2);


/** AJAX: Team category based listing */
add_action('wp_ajax_fetch_nearest_location', 'fetch_nearest_location');
add_action('wp_ajax_nopriv_fetch_nearest_location', 'fetch_nearest_location');

function fetch_nearest_location() {

	$lat = $_POST['lat'];
	$long = $_POST['lang'];

	$distance = '1000';

	global $wpdb;

	// Radius of the earth 3959 miles or 6371 kilometers.
	$earth_radius = 3959;

	$sql = $wpdb->prepare( "
		SELECT DISTINCT
			p.ID,
			p.post_title,
			_location_map_latitude.meta_value as locLat,
			_location_map_longitude.meta_value as locLong,
			( %d * acos(
			cos( radians( %s ) )
			* cos( radians( _location_map_latitude.meta_value ) )
			* cos( radians( _location_map_longitude.meta_value ) - radians( %s ) )
			+ sin( radians( %s ) )
			* sin( radians( _location_map_latitude.meta_value ) )
			) )
			AS distance
		FROM $wpdb->posts p
		INNER JOIN $wpdb->postmeta _location_map_latitude ON p.ID = _location_map_latitude.post_id
		INNER JOIN $wpdb->postmeta _location_map_longitude ON p.ID = _location_map_longitude.post_id
		WHERE 1 = 1
		AND p.post_type = 'location'
		AND p.post_status = 'publish'
		AND _location_map_latitude.meta_key = '_location_map_latitude'
		AND _location_map_longitude.meta_key = '_location_map_longitude'
		HAVING distance < %s
		ORDER BY distance ASC",
		$earth_radius,
		$lat,
		$long,
		$lat,
		$distance
	);

	$nearbyLocations = $wpdb->get_results( $sql );

	if ( $nearbyLocations ) {
		echo '<div class="location-listing">';
		foreach ($nearbyLocations as $sortedata) {
			// Corrected usage of get_post_meta
			$location_custom_title = get_post_meta($sortedata->ID, '_location_custom_title', true);
			$location_address = get_post_meta($sortedata->ID, '_location_address', true);
			$location_phone_number = get_post_meta($sortedata->ID, '_location_phone_number', true);
			$location_email = get_post_meta($sortedata->ID, '_location_email', true);
			$location_fax_number = get_post_meta($sortedata->ID, '_location_fax_number', true);
			$location_map_link = get_post_meta($sortedata->ID, '_location_map_link', true);
		?>
			<div class="location-listing-item">
				<?php if (has_post_thumbnail($sortedata->ID)) { ?>
					<figure class="location-media">
						<a href="<?php echo get_the_permalink($sortedata->ID); ?>"><?php echo get_the_post_thumbnail($sortedata->ID, 'large'); ?></a>
					</figure>
				<?php } ?>
				<div class="location-listing-info">
					<?php if ( $location_custom_title ) { ?>
						<h2 class="h4"><a href="<?php echo get_the_permalink($sortedata->ID); ?>" title="<?php echo esc_attr($location_custom_title); ?>"><?php echo esc_html($location_custom_title); ?></a></h4>
					<?php } else { ?>
						<h2 class="h4"><a href="<?php echo get_the_permalink($sortedata->ID); ?>" title="<?php echo esc_attr(get_the_title($sortedata->ID)); ?>"><?php echo esc_html(get_the_title($sortedata->ID)); ?></a></h4>
					<?php } ?>
					<?php if ( $location_address ) { ?>
						<p class="icon-pin">
							<a rel="noreferrer" href="<?php echo esc_url($location_map_link); ?>" target="_blank" aria-label="Location Address (opens in a new tab)"><?php echo esc_html($location_address); ?></a>
						</p>
					<?php } ?>
					<div class="location-listing-wrap">
						<?php if ( $location_phone_number ) { ?>
							<p class="icon-phone">
								<a href="tel:<?php echo esc_attr($location_phone_number); ?>"><?php echo esc_html($location_phone_number); ?></a>
							</p>
						<?php } ?>
						<?php if ( $location_fax_number ) { ?>
							<p class="icon-fax">
								<?php echo esc_html($location_fax_number); ?>
							</p>
						<?php } ?>
					</div>
					<?php if ( $location_email ) { ?>
						<p class="icon-envelop">
							<a href="mailto:<?php echo esc_attr($location_email); ?>"><?php echo esc_html($location_email); ?></a>
						</p>
					<?php } ?>
					<div class="location-action">
						<a href="<?php echo get_the_permalink($sortedata->ID); ?>" title="<?php echo esc_attr(get_the_title($sortedata->ID)); ?>" class="btn primary" aria-label="Location Info">
							<?php echo esc_html__('View Info', 'herostencilpt'); ?>
						</a>
						<?php if ( $location_map_link ) { ?>
							<a href="<?php echo esc_url($location_map_link); ?>" target="_blank" class="btn outline" aria-label="Map Link">
								<?php echo esc_html__('Direction', 'herostencilpt'); ?>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		}
		echo '</div>';
	} else {
		echo "No Location Found!";
	}
	die;
}

/** AJAX: Location category based listing */
add_action('wp_ajax_location_search_category_filter', 'location_search_category_filter');
add_action('wp_ajax_nopriv_location_search_category_filter', 'location_search_category_filter');
function location_search_category_filter() {
	$dataid = $_POST['dataid'];
	if ( $dataid == 'all' ) :
		$locargs = array(
			'post_type'      => 'location',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1
		);
	else :
		$locargs = array(
			'post_type'      => 'location',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'location_specialty',
					'field'    => 'term_id',
					'terms'    => $dataid
				)
			)
		);
	endif;

	$locquery = new WP_Query( $locargs );

	if ( $locquery->have_posts() ) {

		echo '<div class="location-listing">';

			global $post;

			while ( $locquery->have_posts() ) : $locquery->the_post();

			// Corrected usage of get_post_meta
			$location_custom_title = get_post_meta($post->ID, '_location_custom_title', true);
			$location_address = get_post_meta($post->ID, '_location_address', true);
			$location_phone_number = get_post_meta($post->ID, '_location_phone_number', true);
			$location_email = get_post_meta($post->ID, '_location_email', true);
			$location_fax_number = get_post_meta($post->ID, '_location_fax_number', true);
			$location_map_link = get_post_meta($post->ID, '_location_map_link', true);

			?>
				<div class="location-listing-item">
					<?php if (has_post_thumbnail($post->ID)) { ?>
						<figure class="location-media">
							<a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail($post->ID, 'large'); ?></a>
						</figure>
					<?php } ?>
					<div class="location-listing-info">
						<?php if ( $location_custom_title ) { ?>
							<h2 class="h4"><a href="<?php echo get_the_permalink($post->ID); ?>" title="<?php echo esc_attr($location_custom_title); ?>"><?php echo esc_html($location_custom_title); ?></a></h4>
						<?php } else { ?>
							<h2 class="h4"><a href="<?php echo get_the_permalink($post->ID); ?>" title="<?php echo esc_attr(get_the_title($post->ID)); ?>"><?php echo esc_html(get_the_title($sortedata->ID)); ?></a></h4>
						<?php } ?>
						<?php if ( $location_address ) { ?>
							<p class="icon-pin">
								<a rel="noreferrer" href="<?php echo esc_url($location_map_link); ?>" target="_blank" aria-label="Location Address (opens in a new tab)"><?php echo esc_html($location_address); ?></a>
							</p>
						<?php } ?>
						<div class="location-listing-wrap">
							<?php if ( $location_phone_number ) { ?>
								<p class="icon-phone">
									<a href="tel:<?php echo esc_attr($location_phone_number); ?>"><?php echo esc_html($location_phone_number); ?></a>
								</p>
							<?php } ?>
							<?php if ( $location_fax_number ) { ?>
								<p class="icon-fax">
									<?php echo esc_html($location_fax_number); ?>
								</p>
							<?php } ?>
						</div>
						<?php if ( $location_email ) { ?>
							<p class="icon-envelop">
								<a href="mailto:<?php echo esc_attr($location_email); ?>"><?php echo esc_html($location_email); ?></a>
							</p>
						<?php } ?>
						<div class="location-action">
							<a href="<?php echo get_the_permalink($post->ID); ?>" title="<?php echo esc_attr(get_the_title($post->ID)); ?>" class="btn primary" aria-label="Location Info">
								<?php echo esc_html__('View Info', 'herostencilpt'); ?>
							</a>
							<?php if ( $location_map_link ) { ?>
								<a href="<?php echo esc_url($location_map_link); ?>" target="_blank" class="btn outline" aria-label="Map Link">
									<?php echo esc_html__('Direction', 'herostencilpt'); ?>
								</a>
							<?php } ?>
						</div>
					</div>
				</div>

			<?php endwhile; wp_reset_postdata(); ?>
		</div>

<?php
	}
	wp_die();
}

function social_media_locations() {
    global $post;
    $social_media = get_post_meta($post->ID, '_social_media', true) ?: [];

    // Start building the output
    ob_start(); ?>
        <?php if (!empty($social_media)): ?>
            <div class="social-media">
                <ul>
                    <?php foreach ($social_media as $media):
                        // Determine the class based on the media name
                        $class = '';
                        switch ($media['name']) {
                            case 'facebook':
                                $class = 'icon-meta';
                                break;
                            case 'twitter':
                                $class = 'icon-x';
                                break;
                            case 'instagram':
                                $class = 'icon-instagram';
                                break;
                            case 'yelp':
                                $class = 'icon-yelp';
                                break;
                            case 'linkedin':
                                $class = 'icon-linkedin';
                                break;
                            case 'pinterest':
                                $class = 'icon-pinterest';
                                break;
                            case 'youtube':
                                $class = 'icon-youtube';
                                break;
                        }
                    ?>
                        <li><a href="<?php echo esc_url($media['link']); ?>" class="<?php echo esc_attr($class); ?>" target="_blank"></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <?php
    return ob_get_clean();
}
add_shortcode('social-media-locations', 'social_media_locations');


?>
