<?php
/**
* Custom Admin Option and definitions
*
* @package herostencilpt
*/

/** Add the admin menu page */
function my_admin_menu() {
    $menu_slug = 'header-option';

    /** Add main menu page */
    add_menu_page(
        __( 'Theme Option', 'herostencilpt' ),
        __( 'Theme Option', 'herostencilpt' ),
        'manage_options',
        $menu_slug,
        'header_option_injector',
        'dashicons-schedule',
        60
    );

    /** Add submenus under the Theme Option menu */
    $submenus = [
        [
            'title' => __( 'Header Option', 'herostencilpt' ),
            'slug' => $menu_slug,
            'callback' => 'header_option_injector'
        ],
        [
            'title' => __( 'Footer Option', 'herostencilpt' ),
            'slug' => 'footer-option',
            'callback' => 'footer_option_injector'
        ],
        [
            'title' => __( 'General Option', 'cogentprc' ),
            'slug' => 'general-option',
            'callback' => 'general_option_injector'
        ],
        [
            'title' => __( 'Site Town Option', 'herostencilpt' ),
            'slug' => 'site-town-option',
            'callback' => 'site_towns_injector'
        ],
        [
            'title' => __( 'Google | Scripts', 'herostencilpt' ),
            'slug' => 'google-scripts',
            'callback' => 'google_scripts_injector'
        ],
        [
            'title' => __( 'Theme Popup', 'herostencilpt' ),
            'slug' => 'popup-options',
            'callback' => 'popup_options_injector'
        ],
        [
            'title' => __( 'Theme Guidelines', 'herostencilpt' ),
            'slug' => 'theme-guidelines',
            'callback' => 'theme_guidelines_injector'
        ],
    ];

    foreach ($submenus as $submenu) {
        add_submenu_page(
            $menu_slug,
            $submenu['title'],
            $submenu['title'],
            'manage_options',
            $submenu['slug'],
            $submenu['callback']
        );
    }
}
add_action( 'admin_menu', 'my_admin_menu' );


/**  Callback function for the Footer Option page */
function theme_guidelines_injector() {
    echo '<h1>' . __( 'Theme guidelines', 'herostencilpt' ) . '</h1>';
    echo '<p>' . __( 'This is the Theme guidelines page.', 'herostencilpt' ) . '</p>' .
    '<div class="guidelines-meta-box">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="developer">Developer Tools</a>
        </h2>
    </div>
    <div id="developer" class="tab-content meta-field">
        <h2>Developer Guidelines Goes Here</h2>

        <div class="guidlines-wrap">
            <div class="guidlines-wrap-inner">
                 <h2>' . esc_html__('Search Patterns where to Use', 'textdomain') . '</h2>
                <form method="post" action="">';
                    
                    // WP_Query to get all template part posts
                    $args = array(
                        'post_type' => 'wp_block',  // Post type for template parts
                        'posts_per_page' => -1,     // Get all posts, no pagination
                        'post_status' => 'publish', // Only get published posts
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        echo '<select name="herostencilpt_block_patterns">';
                        echo '<option value="">' . esc_html__('Select Pattern', 'textdomain') . '</option>'; // Default option

                        // Loop through each template part
                        while ($query->have_posts()) {
                            $query->the_post();
                            $template_part_title = get_the_title();
                            $template_part_id = get_the_ID();
                            $edit_link = get_edit_post_link();

                            echo '<option value="' . esc_attr($template_part_title) . '">' . esc_html($template_part_title) . '</option>';
                            //echo '<a href="' . $edit_link . '">' . esc_html($template_part_title) . '</a>';
                        }

                        echo '</select>';
                    } else {
                        echo 'No pattern parts found.';
                    }

                    // Reset post data after custom query
                    wp_reset_postdata();

                echo '</form>
                <div id="pattern-search-results"></div>
            </div>

            <div class="guidlines-wrap-inner">
                <h2>' . esc_html__('Search Custom Block where to Use', 'textdomain') . '</h2>
                <form method="post" action="">';

                $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
                $herostencilpt_blocks = [];

                // Filter all blocks under the 'herostencilpt' namespace
                foreach ($registered_blocks as $block_name => $block_type) {
                    //echo '<h3>' . $block_name . '</h3>';
                    if (strpos($block_name, 'herostencilpt/') === 0 || strpos($block_name, 'herostencilpts/') === 0 || strpos($block_name, 'ppcoreblocks/') === 0 ) {
                        $herostencilpt_blocks[$block_name] = $block_type->title;
                    }
                }

                // Output a dropdown with the filtered blocks
                if (!empty($herostencilpt_blocks)) {
                    echo '<select name="herostencilpt_blocks">';
                    echo '<option value="">' . esc_html__('Select Block', 'textdomain') . '</option>'; // Default option
                    foreach ($herostencilpt_blocks as $block => $blockTitle) {
                        echo '<option value="' . esc_attr($block) . '">' . esc_html($blockTitle) . '</option>';
                    }
                    echo '</select>';
                } else {
                    echo 'No herostencilpt Child blocks found.';
                }

                echo '</form>
                <div id="block-search-results"></div>'.
            '</div>'.
        '</div>'.

    '</div>';
}


// Register the AJAX handler
add_action('wp_ajax_search_block_pages', 'search_block_pages');

function search_block_pages() {
    // Check nonce if you are using it (uncomment below line if you have nonce)
    // check_ajax_referer('block_search_nonce', 'nonce');

    //Get Child theme SLug
    $child_theme = wp_get_theme();
    $child_theme_slug = $child_theme->get_stylesheet(); // Get the slug (folder name)

    if (isset($_POST['block_name'])) {
        $block_name = sanitize_text_field($_POST['block_name']);

        global $wpdb;

        // Query all post types where the block is used in post_content
        $pages = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID, post_title, guid, post_type FROM $wpdb->posts
                WHERE post_status = 'publish'
                AND post_content LIKE %s",
                '%' . $wpdb->esc_like($block_name) . '%'
            )
        );

		if (!empty($pages)) {
            // Prepare results for output, grouped by post type
            $results = [];
            foreach ($pages as $page) {
                $post_type = ucfirst($page->post_type);
                $results[$post_type][] = [
                    'ID' => $page->ID,
                    'post_title' => $page->post_title,
                    'guid' => $page->guid,
                ];
            }
			$results["totalcount"] = count($pages);
            $results["themeslug"] = $child_theme_slug;
            // Output the pages in JSON format
            wp_send_json_success($results);
        } else {
            wp_send_json_error('No pages found using the block.');
        }
    }

    wp_die(); // Required to terminate immediately and return a proper response
}


// Register the AJAX handler
add_action('wp_ajax_search_patterns', 'search_patterns');

function search_patterns() {
    // Check nonce if you are using it (uncomment below line if you have nonce)
    // check_ajax_referer('block_search_nonce', 'nonce');
	//print_r($_POST);

    //Get Child theme SLug
    $child_theme = wp_get_theme();
    $child_theme_slug = $child_theme->get_stylesheet(); // Get the slug (folder name)

    if (isset($_POST['patterns_name'])) {
        $pattern_name = sanitize_text_field($_POST['patterns_name']);
		$pattern_name = str_replace('–', '-', $pattern_name);
        global $wpdb;

        // Query all post types where the block is used in post_content
        $pages = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID, post_title, guid, post_type FROM $wpdb->posts
                WHERE post_status = 'publish'
                AND post_content LIKE %s",
                '%' . $wpdb->esc_like($pattern_name) . '%'
            )
        );

		// echo "SELECT ID, post_title, guid, post_type FROM $wpdb->posts
		// WHERE post_status = 'publish'
		// AND post_content LIKE %s",
		// '%' . $wpdb->esc_like($pattern_name) . '%';

		if (!empty($pages)) {
            // Prepare results for output, grouped by post type
            $results = [];
            foreach ($pages as $page) {
                $post_type = ucfirst($page->post_type);
                $results[$post_type][] = [
                    'ID' => $page->ID,
                    'post_title' => $page->post_title,
                    'guid' => $page->guid,
                ];
            }
			$results["totalcount"] = count($pages);
            $results["themeslug"] = $child_theme_slug;
            // Output the pages in JSON format
            wp_send_json_success($results);
        } else {
            wp_send_json_error('No patterns found using the block.');
        }
    }

    wp_die(); // Required to terminate immediately and return a proper response
}

?>
