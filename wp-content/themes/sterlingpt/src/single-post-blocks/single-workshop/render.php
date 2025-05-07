<?php

	if (is_singular('workshop')) {
    // Custom Meta
   	$workshop_title = get_post_meta(get_the_ID(), '_workshop_title', true);
    $workshop_date = get_post_meta(get_the_ID(), '_workshop_date', true);
    $workshop_datenew = $workshop_date ? new DateTime($workshop_date) : null;
	$workshop_duration = get_post_meta(get_the_ID(), '_workshop_duration', true);
   	$workshop_location = get_post_meta(get_the_ID(), '_workshop_location', true);
   	$workshop_contact_number = get_post_meta(get_the_ID(), '_workshop_contact_number', true);
   	$workshop_form = get_post_meta(get_the_ID(), '_workshop_form', true);
	$workshop_highlight_text = get_post_meta(get_the_ID(), '_workshop_highlight_text', true);
    $workshop_url = get_post_meta(get_the_ID(), '_workshop_url', true);
    $workshop_redirect = get_post_meta(get_the_ID(), '_workshop_redirect', true);

    $workshop_host_name = get_post_meta(get_the_ID(), '_workshop_host_name', true);
    $workshop_host_image = get_post_meta(get_the_ID(), '_workshop_host_image', true);
    $workshop_host_by_title = get_post_meta(get_the_ID(), '_workshop_host_by_title', true);
    $workshop_host_designation = get_post_meta(get_the_ID(), '_workshop_host_designation', true);
	$workshop_host_info = get_post_meta(get_the_ID(), '_workshop_host_info', true);

    echo '<div class="workshop-details">' .
		(
			$workshop_title
			? '<div class="section-header">'.
				'<h6>'. esc_html('WORKSHOP', 'herostencilpt') .'</h6>'.
				'<h2>'. $workshop_title .'</h2>'.
			'</div>'
			:''
		).

        (
            $workshop_host_name || $workshop_host_image || $workshop_host_designation
                ? '<div class="author-part">' .
                (
                    $workshop_host_image
                    ? '<div class="author">' .
                    	'<figure>' .
                    		'<img width="317" height="350" src="' . esc_url($workshop_host_image) . '" alt="' . esc_attr($workshop_host_name) . '">' .
						'</figure>' .
                    '</div>'
                    : ''
                ) .
                '<div class="author-data">' .
					(
						$workshop_host_name
							? '<h3 class="host-name">' . esc_html($workshop_host_name) . '</h3>'
							: ''
					) .
					(
						$workshop_host_designation
							? '<p class="host-designation">' . esc_html($workshop_host_designation) . '</p>'
							: ''
					) .
					'<div class="data-info">'.
						(
							$workshop_host_info
							? '<div class="host-info">'.
								apply_filters( 'the_content', $workshop_host_info ).
							'</div>'
							:''
						).
						(
		                    $workshop_datenew || $workshop_location || $workshop_duration
		                   	? '<div class="workshop-venue">' .
								(
									$workshop_datenew
									? '<div class="date icon-calendar">' . esc_html($workshop_datenew->format('l, M j, Y')) . '</div>'
									: ''
								) .
								(
									$workshop_location
									? '<div class="location icon-pin">' . $workshop_location . '</div>'
									: ''
								) .
								(
									$workshop_duration
									? '<div class="time icon-timer">' . $workshop_duration . '</div>'
									: ''
								) .
							'</div>'
		                   	: ''
		                ) .
					'</div>'.
                '</div>' .
            '</div>'
            : ''
        ) .

		/** Get the content */
		'<div class="workshop-content">'. apply_filters( 'the_content', get_the_content() ) .'</div>'.

		'<div class="workshop-button">' .
			(
				$workshop_contact_number
					? '<a class="btn contact-number icon-phone" href="tel:'. preg_replace( '/[^0-9]/', '', $workshop_contact_number ) .'" aria-label="Contact Number">' .   $workshop_contact_number . '</a>'
					: ''
			) .
			(
				$workshop_form
				? '<a data-fancybox data-src="#register" class="btn" href="javascript:;" aria-label="Workshop Form">' . esc_html('Register Now', 'herostencilpt') . '</a>'
				: ''
			) .

			(
				$workshop_form
				? '<div id="register" style="display:none">'.
					(
						$workshop_title
						? '<h4>'. $workshop_title .'</h4>'
						:''
					).
					do_shortcode($workshop_form).
				'</div>'
				:''
			).
		'</div>'.

	'</div>';
	} else {
		echo '<h2>' . gettext('This block is used exclusively on the Workshop Post page or the Single Workshop Template.') . '</h2>';
	}

?>
