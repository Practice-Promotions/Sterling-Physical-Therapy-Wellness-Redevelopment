<?php 
/**
* Custom General Option and definitions
*
* @package cogentprc
*/

/** Callback function for the General Option page */
function general_option_injector() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['submit'])) {

        //Custom List
        update_option('li_primary_color', sanitize_hex_color($_POST['li_primary_color']));
        update_option('li_secondary_color', sanitize_hex_color($_POST['li_secondary_color']));
        update_option('li_background_color', sanitize_hex_color($_POST['li_background_color']));

        //FAQs
        update_option('item_gap', intval($_POST['item_gap']));
        update_option('item_bg_color', sanitize_hex_color($_POST['item_bg_color']));
        update_option('item_text_color', sanitize_hex_color($_POST['item_text_color']));

        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $li_primary_color = get_option('li_primary_color', '#9e9e9e'); 
    $li_secondary_color = get_option('li_secondary_color', '#000000'); 
    $li_background_color = get_option('li_background_color', '#fff'); 

    $item_gap = get_option('item_gap', '');
    $item_bg_color = get_option('item_bg_color', '#0071bd'); 
    $item_text_color = get_option('item_text_color', '#fff');
    ?>

    <div class="wrap">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="typography">Typography</a>
            <a href="#" class="nav-tab" data-tab="faq">FAQs</a>
        </h2>
        <div class="ga-wrap">
            <form method="POST">
                <div id="typography" class="tab-content">
                    <h1>Custom List Styling</h1>
                    <p><strong>Note:</strong> If you choose the checkmark for the bullet, apply the style below to modify the global checkmark color. </p>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="li_primary_color">LI Primary Color</label>
                                <p class="description">Default <code>&lt;li&gt;</code> Checkmark Primary color for the entire theme.</p>
                            </th>
                            <td>
                                <input type="text" id="li_primary_color" name="li_primary_color" class="list-color-picker" value="<?php echo esc_attr($li_primary_color); ?>" data-default-color="#9e9e9e" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="li_secondary_color">LI Secondary Color</label>
                                <p class="description">Default <code>&lt;li&gt;</code>Checkmark Secondary color for the entire theme.</p>
                            </th>
                            <td>
                                <input type="text" id="li_secondary_color" name="li_secondary_color" class="list-color-picker" value="<?php echo esc_attr($li_secondary_color); ?>" data-default-color="#000000" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="li_background_color">LI Background Color</label>
                                <p class="description">Default <code>&lt;li&gt;</code>Checkmark Bullte Background color for the entire theme.</p>
                            </th>
                            <td>
                                <input type="text" id="li_background_color" name="li_background_color" class="list-color-picker" value="<?php echo esc_attr($li_background_color); ?>" data-default-color="#fff" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="faq" class="tab-content" style="display:none;">
                    <h2 class="h1">FAQs Styling</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="item_gap">Item Gap</label> 
                                <p class="description">Adjust spacing between each FAQ item.</p>
                            </th>
                            <td>
                                <input type="number" id="item_gap" name="item_gap" class="" value="<?php echo esc_attr($item_gap); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="item_bg_color">Item Background Color</label>
                                <p class="description">Adjust a background for each FAQ item.</p>
                            </th>
                            <td>
                                <input type="text" id="item_bg_color" name="item_bg_color" class="list-color-picker" value="<?php echo esc_attr($item_bg_color); ?>" data-default-color="#0071bd" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="item_text_color">Item Text Color</label>
                                <p class="description">Adjust a text color for each FAQ item.</p>
                            </th>
                            <td>
                                <input type="text" id="item_text_color" name="item_text_color" class="list-color-picker" value="<?php echo esc_attr($item_text_color); ?>" data-default-color="#fff" />
                            </td>
                        </tr>
                    </table>
                    </div>
                <?php submit_button(); ?>
            </form>
        </div>
    </div>

    <script>
        (function($) {
            $(document).ready(function() {
                $('.list-color-picker').wpColorPicker(); // Initialize WordPress Color Picker
            });
        })(jQuery);
    </script>
    <?php
}


function enqueue_color_picker() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'enqueue_color_picker');


function inject_dynamic_styles() {
    // Get the color options
    $li_primary_color = get_option('li_primary_color', '#9e9e9e');
    $li_secondary_color = get_option('li_secondary_color', '#000000');
    $li_background_color = get_option('li_background_color', '#000000');

    $item_gap = get_option('item_gap', '');
    $item_bg_color = get_option('item_bg_color', '#1e73be');
    $item_text_color = get_option('item_text_color', '#fff');

    // Output the styles
    echo '<style>

        ul.is-style-checkmark-list>li::after, ul.wp-block-page-list>li::after {
            border-left: 4px solid ' . esc_attr($li_primary_color) . ';
            border-bottom: 4px solid ' . esc_attr($li_secondary_color) . ';
        }
        ul.is-style-checkmark-list>li::before, ul.wp-block-page-list>li::before {
            background:  ' . esc_attr($li_background_color) . ';
        }

        .accordion-list { gap: '. esc_attr($item_gap) .'px; }
        .accordion-list .accordion-title { background: '. esc_attr($item_bg_color) .'; }
        .accordion-list .accordion-title h5 { color: '. esc_attr($item_text_color) .'; }
        .accordion-list .accordion-content *:not(a) { color: '. esc_attr($item_text_color) .'; }
        .accordion-list .accordion-title span:before,
        .accordion-list .accordion-title span:after {
            background: '. esc_attr($item_text_color) .';
        }
        .accordion-list .accordion-content { background: '. esc_attr($item_bg_color) .'; }    
        
    </style>';
}
add_action('wp_head', 'inject_dynamic_styles');

