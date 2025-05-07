<?php
/**
* Custom functions and definitions
*
* @package herostencilpt
*/

/** Admin logo */
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            width: 100%;
            height: 60px;
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png);
            background-size: contain;
            background-repeat: no-repeat;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function custom_loginlogo_url( $url ) {
    return site_url();
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );

/** Site url Shortcode */
function siteurl() {
	$site_url_link = '<a href="'. site_url() .'" class="link">'. get_bloginfo( 'name' ) .'</a>';
	return $site_url_link;
}
add_shortcode( 'site-url', 'siteurl' );


/** Allow SVG upload on media. */
function add_svg_file_types_to_upload( $file_types ) {
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge( $file_types, $new_filetypes );
	return $file_types;
}
add_action( 'upload_mimes', 'add_svg_file_types_to_upload' );

/** Remove <p> tags for the core/shortcode block */
function remove_p_tags_from_shortcode_block($block_content, $block) {
    if ( $block['blockName'] === 'core/shortcode' ) {
        $block_content = preg_replace('/<p>(.*?)<\/p>/is', '$1', $block_content);
    }
    return $block_content;
}
add_filter('render_block', 'remove_p_tags_from_shortcode_block', 10, 2);


/** Yoast breadcrumb structure */
function site_breadcrumb() {
    ob_start();
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb(
            '<div id="breadcrumbs" class="breadcrumbs" role="navigation" aria-label="Breadcrumbs Navigation"><div class="breadcrumbs-inner" aria-label="Breadcrumbs Navigation" role="navigation">', '</div></div>'
        );
    }
    return ob_get_clean();
}
add_shortcode('site-breadcrumb', 'site_breadcrumb');

/** Replace breadcrumb "Home" text to icon */
function replace_home_text_with_svg_output($output) {
    $svg_icon = file_get_contents(get_stylesheet_directory() . '/assets/images/icons/home.svg');
    $output = str_replace('>Home<', '>' . $svg_icon . '<', $output);
    return $output;
}
add_filter('wpseo_breadcrumb_output', 'replace_home_text_with_svg_output');

/** Dynamic title for page heading of the inner banner */
function dynamic_inner_banner_heading( $block_content, $block ) {
    if ( 'core/heading' === $block['blockName'] && isset( $block['innerHTML'] ) ) {
        if ( strpos( $block_content, '{{POST_TITLE}}' ) !== false ) {
            if ( is_home() && get_option( 'page_for_posts' ) || is_tax('post') ) {
                $title = get_the_title( get_option( 'page_for_posts' ) );
            } elseif ( is_archive() ) {
                $title = wp_strip_all_tags( get_the_archive_title() );
            } elseif ( is_404() ) {
				$title =  __( 'Nothing here', 'herostencilpt' );
            } else {
                $title = get_the_title();
            }
            $block_content = str_replace( '{{POST_TITLE}}', esc_html( $title ), $block_content );
        }
    }
    return $block_content;
}
add_filter( 'render_block', 'dynamic_inner_banner_heading', 10, 2 );

/** Current post categories */
function current_post_category() {
	ob_start();
    $post_id = get_the_ID();
    $categories = get_the_category($post_id);
    if (!empty($categories)) {
        $total_categories = count($categories);
        foreach ($categories as $index => $category) {
            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">';
            echo esc_html($category->name);
            echo '</a>';
            if ($index < $total_categories - 1) {
                echo ', ';
            }
        }
    }
	return ob_get_clean();
}
add_shortcode('category', 'current_post_category');


/** Placeholder image function */
function placeholder_image( $imgalt = '' ) {
	ob_start();
	echo '<figure class="wp-block-post-featured-image"><img src="'. get_theme_file_uri() .'/assets/images/placeholder-image.jpg" alt="'. $imgalt .'" /></figure>';
	return ob_get_clean();
}

/** Function to return a placeholder image if no featured image is set */
function placeholder_featured_image( $html, $post_id ) {
    if ( ! has_post_thumbnail( $post_id ) ) {
        $post_type = get_post_type( $post_id );
        if ( $post_type === 'our_team' ) {
            $html = '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title( $post_id ) ) . '" class="wp-post-image" />';
        } elseif($post_type === 'page') {
            $html = '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-inner-banner.jpg" alt="' . esc_attr( get_the_title( $post_id ) ) . '" class="wp-block-cover__image-background wp-post-image" />';
        } else {
            $html = '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-image.jpg" alt="' . esc_attr( get_the_title( $post_id ) ) . '" class="wp-block-cover__image-background wp-post-image" />';
        }
    }
    return $html;
}
add_filter( 'post_thumbnail_html', 'placeholder_featured_image', 10, 2 );

/** Condition human body svg */
function human_body() {
	ob_start();

	global $Humanbody;
	$conditionargs = array(
		'post_type' => 'condition',
		'orderby'   => 'menu_order',
		'order'     => 'ASC',
		'taxonomy'  => 'body_parts',
	);
	$conditionposts = get_categories( $conditionargs );
	echo '<div class="condition-body-media">';
		echo '<div class="condition-body-media-inner">'. $Humanbody .'</div>';
		foreach ( $conditionposts as $conditionpost ) :
            $active_class = ( is_tax( 'body_parts', $conditionpost->term_id ) ) ? ' active' : '';    
			echo '<a href="'. get_term_link( $conditionpost, $conditionpost->taxonomy ) .'" title="'. $conditionpost->name .'" id="'. $conditionpost->slug .'" class="condition-term-title '. $conditionpost->slug . $active_class .'" aria-label="'.$conditionpost->name.'"><span title="'. $conditionpost->name .'" ></span></a>';
		endforeach; wp_reset_postdata();
	echo '</div>';
	return ob_get_clean();
}
add_shortcode( 'human-body', 'human_body' );

/** Gravity form: Added site logo and title on the custom body(mail). */
add_filter( 'gform_replace_merge_tags', 'gf_custom_tags', 10, 7 );
function gf_custom_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {
    $custom_merge_tags = array(
		'{assets_url}' => get_stylesheet_directory_uri() . '/assets/images',
        '{site_name}' => get_bloginfo( 'name' )
    );
    return str_replace( array_keys( $custom_merge_tags ), array_values( $custom_merge_tags ), $text );
}

/** Gravity form: Stop scrolling to leave the form while error has been display. */
add_filter( 'gform_confirmation_anchor', '__return_false' );

/** Gravity form: Added class on the  Appointement and Contact forms. */
add_filter( 'gform_submit_button', 'add_custom_css_classes', 10, 2 );
function add_custom_css_classes( $button, $form ) {
	$dom = new DOMDocument();
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
	$input = $dom->getElementsByTagName( 'input' )->item(0);
	$classes = $input->getAttribute( 'class' );
	if( $form['id'] == 38 ) {
		$classes .= " contact-submit ";
	} elseif ( $form['id'] == 27 ) {
		$classes .= " appointment-submit ";
	}
	$input->setAttribute( 'class', $classes );
	return $dom->saveHtml( $input );
}

/** Add custom rewrite rules to enforce /blog/ prefix for posts */
function custom_rewrite_rules() {
    add_rewrite_rule(
        '^blog/([^/]+)/?$',
        'index.php?name=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');

/** Modify post permalinks to include /blog/ only for published posts */
function add_blog_prefix_to_permalinks($permalink, $post) {
    if ($post->post_type === 'post' && $post->post_status === 'publish') {
        return home_url('/blog/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_link', 'add_blog_prefix_to_permalinks', 10, 2);

/** Force redirection from example.com/post-slug/ to example.com/blog/post-slug/ */
function force_blog_prefix() {
    if (is_single() && get_post_type() === 'post') {
        if (isset($_GET['preview']) || isset($_GET['preview_id'])) {
            return;
        }

        $correct_url = home_url('/blog/' . get_post_field('post_name', get_queried_object_id()) . '/');
        if (!strstr($_SERVER['REQUEST_URI'], '/blog/')) {
            wp_redirect($correct_url, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'force_blog_prefix');

/** Active Class Navigation */
function my_theme_add_active_class_to_menu_block( $block, $source_block ) {
    // Check if the block is a navigation link
    if ( isset( $block['blockName'] ) && 'core/navigation-link' === $block['blockName'] ) {
        // Get the label of the navigation link (e.g., 'Video', 'Health Tips', etc.)
        $link_label = isset( $block['attrs']['label'] ) ? $block['attrs']['label'] : '';
        // Add active class based on the page and label of the link
        if ( is_post_type_archive('video') && ( $link_label === 'Video' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_post_type_archive('ebook') && ( $link_label === 'Ebook' || $link_label === 'Ebooks' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_post_type_archive('newsletter') && ( $link_label === 'Newsletter' || $link_label === 'Newsletters' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } else if ( is_post_type_archive('workshop') && ( $link_label == 'Workshop' || $link_label == 'Workshops' || $link_label == 'Health Tips' ) ) {
		    $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_singular('post') && ( $link_label === 'Health Blog' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_category() && ( $link_label === 'Health Blog' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_singular('our_team') && ( $link_label === 'Our Team' || $link_label === 'About' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_singular('newsletter') && ( $link_label === 'Newsletter' || $link_label === 'Newsletters' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_singular('workshop') && ( $link_label === 'Workshop' || $link_label === 'Workshops' || $link_label === 'Health Tips' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_singular('location') && ( $link_label === 'Our Location' || $link_label === 'Our Locations' || $link_label === 'About' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        } elseif ( is_tax('body_parts') && ( $link_label === 'View More Conditions' || $link_label === 'What We Treat' ) ) {
            $block['attrs']['className'] = 'current-menu-item';
        }
    }
    return $block;
}
add_filter( 'render_block_data', 'my_theme_add_active_class_to_menu_block', 10, 2 );


/** Active Class Navigation */
function post_submit_comment() {
    check_ajax_referer('comment_nonce', 'nonce');

    $comment_data = array(
        'comment_post_ID'      => intval($_POST['comment_post_ID']),
        'comment_author'       => sanitize_text_field($_POST['author']),
        'comment_author_email' => sanitize_email($_POST['email']),
        'comment_content'      => sanitize_textarea_field($_POST['comment']),
        'comment_type'         => '',
        'comment_parent'       => intval($_POST['comment_parent']),
        'user_id'              => get_current_user_id(),
    );

    // Validate required fields
    if (empty($comment_data['comment_author']) || empty($comment_data['comment_author_email']) || empty($comment_data['comment_content'])) {
        wp_send_json_error('Please fill in all required fields.');
    }

    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        $comment = get_comment($comment_id);
        $comment_html = '<li>' . get_comment_text($comment) . '</li>';
        wp_send_json_success(array('comment' => $comment_html));
    } else {
        wp_send_json_error('Failed to submit comment.');
    }
}
add_action('wp_ajax_post_submit_comment', 'post_submit_comment');
add_action('wp_ajax_nopriv_post_submit_comment', 'post_submit_comment');


/** Adding attribute in all "core/button" element */
function add_aria_label_to_buttons($block_content, $block) {
    if (!empty($block['blockName']) && $block['blockName'] === 'core/button') {
        $block_content = preg_replace('/(<a\s+[^>]*)(role="[^"]*"|\s*)>/', '$1 role="button">', $block_content, 1);
    }
    return $block_content;
}
add_filter('render_block', 'add_aria_label_to_buttons', 10, 2);

