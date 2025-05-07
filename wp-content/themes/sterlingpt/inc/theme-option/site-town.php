<?php 
/**
* Custom Site Town Option and definitions
*
* @package herostencilpt
*/



/** Callback function for the General Option page */
function site_towns_injector() {

    global $deleteIcon;

    echo '<h1 style="font-weight:400">' . __( 'General Option', 'herostencilpt' ) . '</h1>';

    /** Retrieve the stored values */
    $terms_of_use_state = get_option('terms_of_use_state', '');
    $all_and_town = get_option('all_and_town', array());
    $all_or_town = get_option('all_or_town', array());
    $town_one_name = get_option('town_one_name', '');
    $town_one_link = get_option('town_one_link', '');
    $town_two_name = get_option('town_two_name', '');
    $town_two_link = get_option('town_two_link', '');
    $town_three_name = get_option('town_three_name', '');
    $town_three_link = get_option('town_three_link', '');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['general_options_nonce']) && wp_verify_nonce($_POST['general_options_nonce'], 'general_options_save')) {

        if (isset($_POST['terms_of_use_state'])) {
            update_option('terms_of_use_state', sanitize_text_field($_POST['terms_of_use_state']));
        }

        // Dropdown all_and_town
        if (isset($_POST['all_and_town']) && is_array($_POST['all_and_town'])) {
            $sanitized_list = array();
            foreach ($_POST['all_and_town'] as $item) {
                if (isset($item['town_name']) && !empty($item['town_name'])) {
                    $sanitized_list[] = array(
                        'town_name' => sanitize_text_field($item['town_name']),
                        'town_link' => intval($item['town_link']), // Ensure this is an integer
                    );
                }
            }
            update_option('all_and_town', $sanitized_list);
        }

        // Dropdown all_or_town
        if (isset($_POST['all_or_town']) && is_array($_POST['all_or_town'])) {
            $sanitized_list = array();
            foreach ($_POST['all_or_town'] as $item) {
                if (isset($item['town_name']) && !empty($item['town_name'])) {
                    $sanitized_list[] = array(
                        'town_name' => sanitize_text_field($item['town_name']),
                        'town_link' => intval($item['town_link']), // Ensure this is an integer
                    );
                }
            }
            update_option('all_or_town', $sanitized_list);
        }

        if (isset($_POST['town_one_name'])) {
            update_option('town_one_name', sanitize_text_field($_POST['town_one_name']));
        }
        if (isset($_POST['town_one_link'])) {
            update_option('town_one_link', intval($_POST['town_one_link']));
        }
        if (isset($_POST['town_two_name'])) {
            update_option('town_two_name', sanitize_text_field($_POST['town_two_name']));
        }
        if (isset($_POST['town_two_link'])) {
            update_option('town_two_link', intval($_POST['town_two_link']));
        }
        if (isset($_POST['town_three_name'])) {
            update_option('town_three_name', sanitize_text_field($_POST['town_three_name']));
        }
        if (isset($_POST['town_three_link'])) {
            update_option('town_three_link', intval($_POST['town_three_link']));
        }

        // Redirect to avoid form resubmission
        wp_redirect(esc_url($_SERVER['REQUEST_URI']));
        exit;
    }

    ?>

    <div class="header-meta-box">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="sitetown">Site Town</a>
        </h2>
        <form method="post">
            <?php wp_nonce_field('general_options_save', 'general_options_nonce'); ?>

            <div id="header" class="tab-content">
                <div class="meta-field">
                    <label for="terms_of_use_state">Terms of Use State</label>
                    <p class="description">Use the shortcode <code><strong>[state-name]</strong></code> for posts and pages.</p>
                    <input type="text" name="terms_of_use_state" id="terms_of_use_state" value="<?php echo esc_attr($terms_of_use_state); ?>" />
                </div>
                <div class="two-column">
                    <div class="meta-field">
                        <label for="all_and_town">All and Town</label>
                        <p class="description">Use the shortcode <code><strong>[all-and-town]</strong></code> for posts and pages.</p>
                        <div class="repeater-table" id="town-and-list">
                            <div class="repeater-item header">
                                <div class="half"><label>Town Name</label></div>
                                <div class="half"><label>Town Link</label></div>
                            </div>
                            <?php foreach ($all_and_town as $index => $item) : ?>
                                <div class="repeater-item data">
                                    <div class="half">
                                        <input type="text" name="all_and_town[<?php echo $index; ?>][town_name]" value="<?php echo esc_attr($item['town_name']); ?>" />
                                    </div>
                                    <div class="half">
                                        <select name="all_and_town[<?php echo $index; ?>][town_link]">
                                            <option value="">Select Location</option>
                                            <?php
                                            $locations = get_posts(array(
                                                'post_type' => 'location',
                                                'posts_per_page' => -1,
                                            ));
                                            foreach ($locations as $location) {
                                                $selected = ($location->ID == $item['town_link']) ? 'selected' : '';
                                                echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <a href="#" class="remove-repeater-item action-icon icon-close icon-close"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="#" id="all-and-repeater-item" class="acf-button acf-repeater-add-row button button-primary">Add Item</a>
                    </div>

                    <div class="meta-field">
                        <label for="all_or_town">All or Town</label>
                        <p class="description">Use the shortcode <code><strong>[all-or-town]</strong></code> for posts and pages.</p>
                        <div class="repeater-table" id="town-or-list">
                            <div class="repeater-item header">
                                <div class="half"><label>Town Name</label></div>
                                <div class="half"><label>Town Link</label></div>
                            </div>
                            <?php foreach ($all_or_town as $index => $item) : ?>
                                <div class="repeater-item data">
                                    <div class="half">
                                        <input type="text" name="all_or_town[<?php echo $index; ?>][town_name]" value="<?php echo esc_attr($item['town_name']); ?>" />
                                    </div>
                                    <div class="half">
                                        <select name="all_or_town[<?php echo $index; ?>][town_link]">
                                            <option value="">Select Location</option>
                                            <?php
                                            $locations = get_posts(array(
                                                'post_type' => 'location',
                                                'posts_per_page' => -1,
                                            ));
                                            foreach ($locations as $location) {
                                                $selected = ($location->ID == $item['town_link']) ? 'selected' : '';
                                                echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <a href="#" class="remove-repeater-item action-icon icon-close"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="#" id="all-or-repeater-item" class="acf-button acf-repeater-add-row button button-primary">Add Item</a>
                    </div>
                </div>
                <div class="three-column">
                    <div class="meta-field">
                        <label>Town 1</label>
                        <p class="description">Use the shortcode <code><strong>[town-one]</strong></code> for posts and pages.</p>
                        <div class="field"><input type="text" placeholder="Town Name" name="town_one_name" id="town_one_name" value="<?php echo esc_attr($town_one_name); ?>" /></div>
                        <div class="field">
                            <select name="town_one_link">
                                <option value="">Select Location</option>
                                <?php
                                $locations = get_posts(array(
                                    'post_type' => 'location',
                                    'posts_per_page' => -1,
                                ));
                                foreach ($locations as $location) {
                                    $selected = ($location->ID == $town_one_link) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="meta-field">
                        <label>Town 2</label>
                        <p class="description">Use the shortcode <code><strong>[town-two]</strong></code> for posts and pages.</p>
                        <div class="field"><input type="text" placeholder="Town Name" name="town_two_name" id="town_two_name" value="<?php echo esc_attr($town_two_name); ?>" /></div>
                        <div class="field">
                            <select name="town_two_link">
                                <option value="">Select Location</option>
                                <?php
                                $locations = get_posts(array(
                                    'post_type' => 'location',
                                    'posts_per_page' => -1,
                                ));
                                foreach ($locations as $location) {
                                    $selected = ($location->ID == $town_two_link) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="meta-field">
                            <label>Town 3</label>
                            <p class="description">Use the shortcode <code><strong>[town-three]</strong></code> for posts and pages.</p>
                            <div class="field"><input type="text" placeholder="Town Name" name="town_three_name" id="town_three_name" value="<?php echo esc_attr($town_three_name); ?>" /></div>
                            <div class="field">
                            <select name="town_three_link">
                                <option value="">Select Location</option>
                                <?php
                                $locations = get_posts(array(
                                    'post_type' => 'location',
                                    'posts_per_page' => -1,
                                ));
                                foreach ($locations as $location) {
                                    $selected = ($location->ID == $town_three_link) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($location->ID) . '" ' . $selected . '>' . esc_html($location->post_title) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                </div>
            </div>

            <p><input type="submit" class="button button-primary" value="<?php _e('Save Settings', 'herostencilpt'); ?>"></p>

        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#all-and-repeater-item').on('click', function(e) {
                e.preventDefault();
                var index = $('#town-and-list .repeater-item').length;
                $('#town-and-list').append(
                    '<div class="repeater-item data">' +
                        '<div class="half">' +
                            '<input type="text" name="all_and_town[' + index + '][town_name]" placeholder="Town Name" />' +
                        '</div>' +
                        '<div class="half">' +
                            '<select name="all_and_town[' + index + '][town_link]">' +
                                '<option value="">Select Location</option>' +
                                '<?php
                                $locations = get_posts(array(
                                    "post_type" => "location",
                                    "posts_per_page" => -1,
                                ));
                                foreach ($locations as $location) {
                                    echo "<option value=\"" . esc_attr($location->ID) . "\">" . esc_html($location->post_title) . "</option>";
                                }
                                ?>' +
                            '</select>' +
                        '</div>' +
                        '<a href="#" class="remove-repeater-item action-icon icon-close"></a>' +
                    '</div>'
                );
            });

            $('#all-or-repeater-item').on('click', function(e) {
                e.preventDefault();
                var index = $('#town-or-list .repeater-item').length;
                $('#town-or-list').append(
                    '<div class="repeater-item data">' +
                        '<div class="half">' +
                            '<input type="text" name="all_or_town[' + index + '][town_name]" placeholder="Town Name" />' +
                        '</div>' +
                        '<div class="half">' +
                            '<select name="all_or_town[' + index + '][town_link]">' +
                                '<option value="">Select Location</option>' +
                                '<?php
                                $locations = get_posts(array(
                                    "post_type" => "location",
                                    "posts_per_page" => -1,
                                ));
                                foreach ($locations as $location) {
                                    echo "<option value=\"" . esc_attr($location->ID) . "\">" . esc_html($location->post_title) . "</option>";
                                }
                                ?>' +
                            '</select>' +
                        '</div>' +
                        '<a href="#" class="remove-repeater-item action-icon icon-close"></a>' +
                    '</div>'
                );
            });
        });
    </script>

    <?php
}

/** Site name for terms of use and privacy policy page */
function sitename() {
	$site_name_html = get_bloginfo( 'name' );
	return $site_name_html;
}
add_shortcode( 'site-name', 'sitename' );


/** State name for terms of use page */
function state_name() {
    $state_name = get_option('terms_of_use_state', '');
    return $state_name ? esc_html($state_name) : '';
}
add_shortcode('state-name', 'state_name');

/** All and Town for terms of use page */
function all_and_town() {
    $all_and_town = get_option('all_and_town', []);
    $allandtown_data = [];

    foreach ($all_and_town as $item) {
        $townname = sanitize_text_field($item['town_name']);
        $townlink = intval($item['town_link']); // Ensure the link is an integer
        if (!empty($townname)) {
            $allandtown_data[] = '<a href="' . ($townlink ? esc_url(get_permalink($townlink)) : 'javascript:void(0);') . '">' . esc_html($townname) . '</a>';
        }
    }

    // Check if the array is empty
    if (empty($allandtown_data)) {
        return '';
    }

    // Format the output correctly
    if (count($allandtown_data) === 1) {
        return $allandtown_data[0];
    } else {
        $last_item = array_pop($allandtown_data); // Get the last item
        return join(', ', $allandtown_data) . ' and ' . $last_item; // Join with ', ' and add 'and' before the last item
    }
}
add_shortcode('all-and-town', 'all_and_town');

/** All Or Town for terms of use page */
function all_or_town() {
    $all_or_town = get_option('all_or_town', []);
    $allortown_data = [];

    foreach ($all_or_town as $item) {
        $townname = sanitize_text_field($item['town_name']);
        $townlink = intval($item['town_link']); // Ensure the link is an integer
        if (!empty($townname)) {
            $allortown_data[] = '<a href="' . ($townlink ? esc_url(get_permalink($townlink)) : 'javascript:void(0);') . '">' . esc_html($townname) . '</a>';
        }
    }

    // Check if the array is empty
    if (empty($allortown_data)) {
        return '';
    }

    // Format the output correctly
    if (count($allortown_data) === 1) {
        return $allortown_data[0];
    } else {
        $last_item = array_pop($allortown_data); // Get the last item
        return join(', ', $allortown_data) . ' or ' . $last_item; // Join with ', ' and add 'or' before the last item
    }
}
add_shortcode('all-or-town', 'all_or_town');



/** Town one for terms of use page */
function town_one() {
    $town_one_name = get_option('town_one_name', '');
    $town_one_link_id = get_option('town_one_link', '');

    $town_one_link = $town_one_link_id ? get_permalink($town_one_link_id) : '';

    return $town_one_name ? '<a href="' . ($town_one_link ? esc_url($town_one_link) : 'javascript:void(0);') . '" role="button">' . esc_html($town_one_name) . '</a>' : '';
}
add_shortcode('town-one', 'town_one');

/** Town two for terms of use page */
function town_two() {
    $town_two_name = get_option('town_two_name', '');
    $town_two_link_id = get_option('town_two_link', '');

    $town_two_link = $town_two_link_id ? get_permalink($town_two_link_id) : '';

    return $town_two_name ? '<a href="' . ($town_two_link ? esc_url($town_two_link) : 'javascript:void(0);') . '" role="button">' . esc_html($town_two_name) . '</a>' : '';
}
add_shortcode('town-two', 'town_two');

/** Town three for terms of use page */
function town_three() {
    $town_three_name = get_option('town_three_name', '');
    $town_three_link_id = get_option('town_three_link', '');

    $town_three_link = $town_three_link_id ? get_permalink($town_three_link_id) : '';

    return $town_three_name ? '<a href="' . ($town_three_link ? esc_url($town_three_link) : 'javascript:void(0);') . '" role="button">' . esc_html($town_three_name) . '</a>' : '';
}
add_shortcode('town-three', 'town_three');



?>