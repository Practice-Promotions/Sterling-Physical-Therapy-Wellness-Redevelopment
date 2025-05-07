<?php 
/**
* Custom Header Option and definitions
*
* @package herostencilpt
*/

/** Callback function for the Header Option page */
function header_option_injector() {

    echo '<h1 style="font-weight:400">'. __( 'Header Option', 'herostencilpt' ) .'</h1>';

	/** Retrieve the stored values */
    $addressbar = get_option('header_address_bar', '');
    $CallCtaText = get_option('call_cta_text', '');
    $call_cta_list = get_option('call_cta_list', array());
    $ReviewCtaText = get_option('review_cta_text', '');
    $review_cta_list = get_option('review_cta_list', array());
    $HeaderCTAURL = get_option('header_cta_url', '');
    $HeaderCTAText = get_option('header_cta_text', '');
    $HeaderCTAtarget = get_option('header_cta_target', '');
    $appointmentCTAURL = get_option('appointment_cta_url', '');
    $appointmentCTAText = get_option('appointment_cta_text', '');
    $appointmentCTAtarget = get_option('appointment_cta_target', '');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['header_address_bar'])) {
            update_option('header_address_bar', wp_kses_post($_POST['header_address_bar']));
        }

        if (isset($_POST['header_cta_url'])) {
            update_option('header_cta_url', sanitize_text_field($_POST['header_cta_url']));
        }
        if (isset($_POST['header_cta_text'])) {
            update_option('header_cta_text', sanitize_text_field($_POST['header_cta_text']));
        }
        if (isset($_POST['header_cta_target'])) {
            update_option('header_cta_target', sanitize_text_field($_POST['header_cta_target']));
        }

        if (isset($_POST['call_cta_text'])) {
            update_option('call_cta_text', sanitize_text_field($_POST['call_cta_text']));
        }
        // Dropdown call_cta_list
        if (isset($_POST['call_cta_list']) && is_array($_POST['call_cta_list'])) {
            $sanitized_list = array();
            foreach ($_POST['call_cta_list'] as $item) {
                if (isset($item['call_cta_name'], $item['call_cta_tel_num']) && !empty($item['call_cta_name']) && !empty($item['call_cta_tel_num'])) {
                    $sanitized_list[] = array(
                        'call_cta_name' => sanitize_text_field($item['call_cta_name']),
                        'call_cta_tel_num' => sanitize_text_field($item['call_cta_tel_num']),
                    );
                }
            }
            update_option('call_cta_list', $sanitized_list);
        } else {
            // If no items are present, clear the option
            update_option('call_cta_list', array());
        }

        if (isset($_POST['review_cta_text'])) {
            update_option('review_cta_text', sanitize_text_field($_POST['review_cta_text']));
        }
        // Dropdown review_cta_list
        if (isset($_POST['review_cta_list']) && is_array($_POST['review_cta_list'])) {
            $sanitized_list = array();
            foreach ($_POST['review_cta_list'] as $item) {
                if (isset($item['review_cta_name'], $item['review_cta_link']) && !empty($item['review_cta_name']) && !empty($item['review_cta_link'])) {
                    $sanitized_list[] = array(
                        'review_cta_name' => sanitize_text_field($item['review_cta_name']),
                        'review_cta_link' => sanitize_text_field($item['review_cta_link']),
                    );
                }
            }
            update_option('review_cta_list', $sanitized_list);
        } else {
            // If no items are present, clear the option
            update_option('review_cta_list', array());
        }

        if (isset($_POST['appointment_cta_url'])) {
            update_option('appointment_cta_url', sanitize_text_field($_POST['appointment_cta_url']));
        }
        if (isset($_POST['appointment_cta_text'])) {
            update_option('appointment_cta_text', sanitize_text_field($_POST['appointment_cta_text']));
        }
        if (isset($_POST['appointment_cta_target'])) {
            update_option('appointment_cta_target', sanitize_text_field($_POST['appointment_cta_target']));
        }

        // Redirect to avoid form resubmission
        echo '<script>window.location.href = "'. esc_url($_SERVER['REQUEST_URI']) .'";</script>';

        exit;
    }
    ?>
	<div class="header-meta-box">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="header">Header</a>
            <a href="#" class="nav-tab" data-tab="addressbar">Notification Bar</a>
        </h2>

        <form method="post">
            <!-- Nonce field for security -->
            <?php wp_nonce_field('header_options_save', 'header_options_nonce'); ?>

            <div id="header" class="tab-content">
                <div class="meta-field">
                    <label for="call_cta_text">Call CTA Text</label>
                    <input type="text" name="call_cta_text" id="call_cta_text" value="<?php echo esc_attr($CallCtaText); ?>" />
                </div>
                <div class="meta-field">
                    <h3>Call CTA List</h3>
                    <div class="repeater-table" id="call-cta-list">
                        <div class="repeater-item header">
                            <div class="half"><label>Call CTA Name</label></div>
                            <div class="half"><label>Call CTA Tel Number</label></div>
                        </div>
                        <?php if (!empty($call_cta_list)) : ?>
                            <?php foreach ($call_cta_list as $index => $item) : ?>
                                <div class="repeater-item data">
                                    <div class="half">
                                        <input type="text" name="call_cta_list[<?php echo $index; ?>][call_cta_name]" value="<?php echo esc_attr($item['call_cta_name']); ?>" />
                                    </div>
                                    <div class="half">
                                        <input type="text" name="call_cta_list[<?php echo $index; ?>][call_cta_tel_num]" value="<?php echo esc_attr($item['call_cta_tel_num']); ?>" />
                                    </div>
                                    <a href="#" class="remove-repeater-item action-icon icon-close"></a>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="repeater-item data">
                                <div class="half">
                                    <input type="text" name="call_cta_list[0][call_cta_name]" />
                                </div>
                                <div class="half">
                                    <input type="text" name="call_cta_list[0][call_cta_tel_num]" />
                                </div>
                                <a href="#" class="remove-repeater-item action-icon icon-close"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="#" id="call-repeater-item" class="acf-button acf-repeater-add-row button button-primary">Add Item</a>
                </div>
				<div class="meta-field">
                    <label for="review_cta_text">Review CTA Text</label>
                    <input type="text" name="review_cta_text" id="review_cta_text" value="<?php echo esc_attr($ReviewCtaText); ?>" />
                </div>
				<div class="meta-field">
                    <h3>Review CTA List</h3>
                    <div class="repeater-table" id="review-cta-list">
                        <div class="repeater-item header">
                            <div class="half"><label>Review CTA Name</label></div>
                            <div class="half"><label>Review CTA Link</label></div>
                        </div>
                        <?php if (!empty($review_cta_list)) : ?>
                            <?php foreach ($review_cta_list as $index => $item) : ?>
                                <div class="repeater-item data">
                                    <div class="half">
                                        <input type="text" name="review_cta_list[<?php echo $index; ?>][review_cta_name]" value="<?php echo esc_attr($item['review_cta_name']); ?>" />
                                    </div>
                                    <div class="half">
                                        <input type="text" name="review_cta_list[<?php echo $index; ?>][review_cta_link]" value="<?php echo esc_attr($item['review_cta_link']); ?>" />
                                    </div>
                                    <a href="#" class="remove-repeater-item action-icon icon-close"></a>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="repeater-item data">
                                <div class="half">
                                    <input type="text" name="review_cta_list[0][review_cta_name]" />
                                </div>
                                <div class="half">
                                    <input type="text" name="review_cta_list[0][review_cta_link]" />
                                </div>
                                <a href="#" class="remove-repeater-item action-icon icon-close"></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="#" id="review-repeater-item" class="acf-button acf-repeater-add-row button button-primary">Add Item</a>
                </div>
                <div class="meta-field">
                    <label for="header_cta_text">Header CTA</label>
                    <label for="header_cta_text">Link Text:</label>
                    <input type="text" id="header_cta_text" name="header_cta_text" value="<?php echo esc_attr($HeaderCTAText); ?>">
                    <label for="header_cta_url">URL:</label>
                    <input type="text" id="header_cta_url" name="header_cta_url" value="<?php echo esc_attr($HeaderCTAURL); ?>">
                    <label for="header_cta_target">
                        <input type="checkbox" id="header_cta_target" name="header_cta_target" <?php checked($HeaderCTAtarget, '_blank'); ?> value="_blank">
                        Open link in a new tab
                    </label>
                </div>
                <div class="meta-field">
                    <label for="appointment_cta_text">Appointment CTA</label>
                    <label for="appointment_cta_text">Link Text:</label>
                    <input type="text" id="appointment_cta_text" name="appointment_cta_text" value="<?php echo esc_attr($appointmentCTAText); ?>">
                    <label for="appointment_cta_url">URL:</label>
                    <input type="text" id="appointment_cta_url" name="appointment_cta_url" value="<?php echo esc_attr($appointmentCTAURL); ?>">
                    <label for="appointment_cta_target">
                        <input type="checkbox" id="appointment_cta_target" name="appointment_cta_target" <?php checked($appointmentCTAtarget, '_blank'); ?> value="_blank">
                        Open link in a new tab
                    </label>
                </div>
            </div>

            <div id="addressbar" class="tab-content" style="display:none;">
                <div class="meta-field">
                    <label for="header_address_bar">Notification Bar</label>
                    <textarea name="header_address_bar" id="header_address_bar" rows="1"><?php echo esc_textarea($addressbar); ?></textarea>
                </div>
            </div>

            <p><input type="submit" class="button button-primary" value="<?php _e('Save Settings', 'herostencilpt'); ?>"></p>
        </form>
    </div>

    <?php
}


/** Option: Header function */
function header_button_data() {
    ob_start();

	echo '<ul id="header-button" class="header-button">';

		$CallCtaText = get_option('call_cta_text', '');
		$call_cta_list = get_option('call_cta_list', array());
		if (!empty($call_cta_list) && is_array($call_cta_list)) {
			if (count($call_cta_list) > 1) {
				echo '<li class="call multi-call">'.
					'<a href="javascript:void(0);" class="btn" role="button">'. 
                        '<span class="icon-phone"></span>'.
                        '<span class="text-number">'. esc_html($CallCtaText) .'</span>'.
                    '</a>'.
					'<ul class="quick-dropdown">';
					foreach ($call_cta_list as $item) {
						if (!empty($item['call_cta_name']) && !empty($item['call_cta_tel_num'])) {
							echo '<li>'.
								'<a href="tel:'. preg_replace( '/[^0-9]/', '', $item['call_cta_tel_num'] ) .'">'. esc_html($item['call_cta_name']) .'</a>'.
							'</li>';
						}
					}
					echo'</ul>'.
				'</li>';
			} else {
				$item = $call_cta_list[0];
				if (!empty($item['call_cta_name']) && !empty($item['call_cta_tel_num'])) {
					echo '<li class="call single-call">'.
						'<a href="tel:'. preg_replace( '/[^0-9]/', '', $item['call_cta_tel_num'] ) .'" class="btn " role="button">'.
                            '<span class="icon-phone"></span>'.
							'<span class="text-number">'.
								esc_html($CallCtaText) .
							'</span>'.
						'</a>'.
					'</li>';
				}
			}
		}

        // Header CTA
	    $HeaderCTAURL = get_option('header_cta_url', '');
	    $HeaderCTAText = get_option('header_cta_text', '');
	    $HeaderCTAtarget = get_option('header_cta_target', '');
	    if (!empty($HeaderCTAURL) && !empty($HeaderCTAText)) {
	        echo '<li>'.
	        	'<a href="'. esc_html($HeaderCTAURL) .'" class="btn outline" role="button" target="'.( $HeaderCTAtarget ? '_blank' :'_self' ).'">'. esc_html($HeaderCTAText) .'</a>'.
	        '</li>';
	    }

		$ReviewCtaText = get_option('review_cta_text', '');
		$review_cta_list = get_option('review_cta_list', array());
		if (!empty($review_cta_list) && is_array($review_cta_list)) {
			if (count($review_cta_list) > 1) {
				echo '<li class="review">'.
					'<a href="javascript:void(0);" class="btn" role="button">'. esc_html($ReviewCtaText) .'</a>'.
					'<ul class="quick-dropdown">';
					foreach ($review_cta_list as $item) {
						if (!empty($item['review_cta_name']) && !empty($item['review_cta_link'])) {
							echo '<li>'.
								'<a href="'. esc_attr($item['review_cta_link']) .'">'. esc_html($item['review_cta_name']) .'</a>'.
							'</li>';
						}
					}
					echo '</ul>'.
				'</li>';
			} else {
				$item = $review_cta_list[0];
				if (!empty($item['review_cta_name']) && !empty($item['review_cta_link'])) {
					echo '<li class="review">'.
						'<a href="'. esc_attr($item['review_cta_link']) .'" class="btn " role="button">'. esc_html($ReviewCtaText) .'</a>'.
					'</li>';
				}
			}
		}

         // Appointment CTA
	    $appointmentCTAURL = get_option('appointment_cta_url', '');
	    $appointmentCTAText = get_option('appointment_cta_text', '');
	    $appointmentCTAtarget = get_option('appointment_cta_target', '');


		if (!empty($appointmentCTAURL) && !empty($appointmentCTAText)) {
			echo '<li class="appointment-button"><a href="'. esc_html($appointmentCTAURL) .'" class="btn secondary" role="button" target="'.( $appointmentCTAtarget ? '_blank' :'_self' ).'">'. esc_html($appointmentCTAText) .'</a></li>';
		}
        
        echo '<div class="hamburger"><span></span><span></span><span></span></div>';
    echo '</ul>';
        

    return ob_get_clean();
}
add_shortcode('header-button-data', 'header_button_data');

function header_appointment_data() {
    ob_start();

    // Appointment CTA
    $appointmentCTAURL = get_option('appointment_cta_url', '');
    $appointmentCTAText = get_option('appointment_cta_text', '');
    $appointmentCTAtarget = get_option('appointment_cta_target', '');
    if (!empty($appointmentCTAURL) && !empty($appointmentCTAText)) {
        echo '<div class="appointment-button"><a href="'. esc_html($appointmentCTAURL) .'" class="btn secondary" role="button" target="'.( $appointmentCTAtarget ? '_blank' :'_self' ).'">'. esc_html($appointmentCTAText) .'</a></div>';
    }

    return ob_get_clean();
}
add_shortcode('header-appointment-data', 'header_appointment_data');
?>