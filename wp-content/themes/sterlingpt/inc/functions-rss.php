<?php
/**
* Custom functions and definitions for RSS
*
* @package herostencilpt
*/

/** Set featured image and shortcode for RSS feed */
add_filter('the_excerpt_rss', 'my_theme_shortcodes_and_featured_image_in_rss');
add_filter('the_content_feed', 'my_theme_shortcodes_and_featured_image_in_rss');
function my_theme_shortcodes_and_featured_image_in_rss($content) {
    global $post;
    $thumbnail = '';
    if (has_post_thumbnail($post->ID)) {
        $thumbnail = '<image>'. get_the_post_thumbnail($post->ID, 'medium') .'</image>';
    }
    if (has_excerpt($post->ID)) {
        $excerpt = get_the_excerpt($post->ID);
        $excerpt = do_shortcode($excerpt);
    } else {
        $excerpt = get_the_content();
        $excerpt = do_shortcode($excerpt);
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = wp_trim_words($excerpt, 150, ' [...]');
    }
    $combined_content = $thumbnail . $excerpt;
    return $combined_content;
}

/** Apply the filter to the RSS feed permalinks */
add_filter('the_permalink_rss', 'add_utm_to_rss_permalink');
function add_utm_to_rss_permalink($permalink) {
    // Get the global post object
    global $post;

	// Get the post type
    $post_type = get_post_type($post);

    // Check if the post type is 'newsletter' or 'post/blog'
	if ('post' === $post_type) {
		// Define UTM parameters
		$utm_params = array(
			'utm_source' => 'blog',
			'utm_medium' => 'email'
		);
	} elseif ('newsletter' === $post_type) {
		// Define UTM parameters
		$utm_params = array(
			'utm_source' => 'newsletter',
			'utm_medium' => 'email'
		);
	}
    if ( ('post' === $post_type) || ('newsletter' === $post_type) ) {
        // Parse the permalink
        $parsed_url = parse_url($permalink);
        $query = array();

        // Parse existing query parameters if any
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query);
        }

        // Add UTM parameters
		$query = array_merge($query, $utm_params);

        // Build new query string
        $new_query = http_build_query($query);

        // Construct new URL
        $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        if (isset($parsed_url['path'])) {
            $new_url .= $parsed_url['path'];
        }
        $new_url .= '?' . $new_query;

        // Decode HTML entities to convert &#038; back to &
        $new_url = html_entity_decode($new_url);

        return $new_url;
    }

    // Return the original permalink if the post type is not 'newsletter'
    return $permalink;
}

/** Newsletter RSS Feed - Customization */
add_action('rss2_item', 'add_custom_rss_element');
function add_custom_rss_element() {
    global $post;

    // Retrieve the newsletter services data
    $newsletter_services = get_post_meta($post->ID, '_newsletter_services', true);

    if (is_array($newsletter_services)) :
        foreach ($newsletter_services as $service) :
            $newsletter_service_title = isset($service['title']) ? $service['title'] : '';
            $newsletter_service_image = isset($service['image']) ? $service['image'] : '';
            $newsletter_service_text = isset($service['text']) ? $service['text'] : '';

            if (!empty($newsletter_service_title)) :
                echo '<newsletterServiceTitle>' . esc_html($newsletter_service_title) . '</newsletterServiceTitle>';
            endif;
            if (!empty($newsletter_service_image)) :
                echo '<newsletterServiceImage>' . esc_url($newsletter_service_image) . '</newsletterServiceImage>';
            endif;
            if (!empty($newsletter_service_text)) :
                echo '<newsletterServiceText>' . esc_html($newsletter_service_text) . '</newsletterServiceText>';
            endif;
        endforeach;
    endif;
}