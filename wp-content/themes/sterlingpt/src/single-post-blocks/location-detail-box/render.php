<?php
 if (is_singular('location')) {
	$location_custom_title = get_post_meta(get_the_ID(), '_location_custom_title', true);
	/** Location detail block for the Location single page used */
	echo '<div class="location-contact location-single-detail">'.
			'<div class="location-contact-info">'.
				(
					$location_custom_title
					? '<h2 class="h4">'. $location_custom_title .'</h2>'
					: '<h2 class="h4">'. get_the_title() .'</h2>'
				).
			'<h4>Contact Info</h4>'.
				do_shortcode('[location-address]').
			'<div class="location-contact-wrap">'.
				do_shortcode('[location-phone]').
				do_shortcode('[location-fax]').
			'</div>'.
			do_shortcode('[location-email]').
			(
				(do_shortcode('[location-hours]'))
				? '<h4 class="mt-30">Business Hours</h4>'. 
					do_shortcode('[location-hours]')
				: ''
			).
			(
				(do_shortcode('[location-located]'))
				? '<h4 class="mt-30">Directions/Located Near</h4>'. 
					do_shortcode('[location-located]')
				: ''
			).
			do_shortcode('[social-media-locations]').
	   '</div>'.
	   '<div class="location-contact-map">'.
			do_shortcode('[location-map]').
		'</div>'.
	'</div>';
 } else {
	echo '<h2>' . __( 'This block is used exclusively on the Location Post page or the Single Location Template.', 'herostencilpt' ) . '</h2>';
 }
?>
