<?php
/** Enqueue admin custom style */
function my_theme_enqueue_admin_style()
{
	wp_enqueue_style('admin-style', get_theme_file_uri() . '/assets/admin/admin.css', array(), wp_get_theme()->get('Version'));
	wp_enqueue_script('admin-script', get_theme_file_uri() . '/assets/admin/admin.js', array(), wp_get_theme()->get('Version'), true);

	/* Enqueue the fontastic-icon stylesheet only in the admin area */
	wp_enqueue_style('admin-icon', get_theme_file_uri() . '/assets/fonts/icons/font.css', array(), wp_get_theme()->get('Version'));
	wp_localize_script('admin-script', 'ajax_object', array(
		'ajax_url' => admin_url('admin-ajax.php')
	));
}
add_action('admin_enqueue_scripts', 'my_theme_enqueue_admin_style');

/** Enqueue theme style */
function my_theme_enqueue_styles()
{
	wp_enqueue_style('twentytwentyfour-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('twentytwentyfour-child-style', get_stylesheet_uri(), array('twentytwentyfour-style'));

	/* fontastic style */
	wp_enqueue_style('fontastic-icon', get_theme_file_uri() . '/assets/fonts/icons/font.css', array(), wp_get_theme()->get('Version'));

	/* Main style */
	wp_enqueue_style('default-style', get_theme_file_uri() . '/assets/dest/css/style.css', array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

/** Enqueue theme script */
function my_theme_enqueue_scripts()
{
	wp_enqueue_script('jquery');

	/** main script */
	wp_enqueue_script('default-script', get_theme_file_uri() . '/assets/dest/js/scripts.min.js', array(), wp_get_theme()->get('Version'), true);

	wp_enqueue_script('googlemap-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBKMhpr0cVhxEixcHGExqXFvUHoicTCmLo&libraries=places&v=weekly', array(), wp_get_theme()->get('Version'), true);

	/** AJAX localize a script */
	wp_localize_script('default-script', 'frontend_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
	wp_localize_script('default-script', 'admin_theme_object', array('themeurl' => get_theme_file_uri()));
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

/** Unregister blocks and patterns */
function remove_twenty_twenty_four_patterns()
{
	// Unregister block pattern categories
	unregister_block_pattern_category('gallery');
	unregister_block_pattern_category('portfolio');
	unregister_block_pattern_category('about');
	unregister_block_pattern_category('banner');
	unregister_block_pattern_category('services');
	unregister_block_pattern_category('team');
	unregister_block_pattern_category('testimonials');
	unregister_block_pattern_category('text');
	unregister_block_pattern_category('call-to-action');

	// Unregister specific block patterns
	unregister_block_pattern('twentytwentyfour/banner-hero');
	unregister_block_pattern('twentytwentyfour/text-title-left-image-right');
	unregister_block_pattern('twentytwentyfour/banner-project-description');
	unregister_block_pattern('twentytwentyfour/cta-services-image-left');
	unregister_block_pattern('twentytwentyfour/cta-content-image-on-right');
	unregister_block_pattern('twentytwentyfour/cta-rsvp');
	unregister_block_pattern('twentytwentyfour/cta-pricing');
	unregister_block_pattern('twentytwentyfour/cta-subscribe-centered');
	unregister_block_pattern('twentytwentyfour/gallery-full-screen-image');
	unregister_block_pattern('twentytwentyfour/gallery-offset-images-grid-2-col');
	unregister_block_pattern('twentytwentyfour/gallery-offset-images-grid-3-col');
	unregister_block_pattern('twentytwentyfour/gallery-offset-images-grid-4-col');
	unregister_block_pattern('twentytwentyfour/gallery-project-layout');
	unregister_block_pattern('twentytwentyfour/page-about-business');
	unregister_block_pattern('twentytwentyfour/page-home-blogging');
	unregister_block_pattern('twentytwentyfour/page-home-business');
	unregister_block_pattern('twentytwentyfour/page-home-gallery');
	unregister_block_pattern('twentytwentyfour/page-home-portfolio');
	unregister_block_pattern('twentytwentyfour/page-newsletter-landing');
	unregister_block_pattern('twentytwentyfour/page-portfolio-overview');
	unregister_block_pattern('twentytwentyfour/page-rsvp-landing');
	unregister_block_pattern('twentytwentyfour/posts-1-col');
	unregister_block_pattern('twentytwentyfour/posts-images-only-offset-4-col');
	unregister_block_pattern('twentytwentyfour/posts-list');
	unregister_block_pattern('twentytwentyfour/team-4-col');
	unregister_block_pattern('twentytwentyfour/text-alternating-images');
	unregister_block_pattern('twentytwentyfour/text-centered-statement-small');
	unregister_block_pattern('twentytwentyfour/text-centered-statement');
	unregister_block_pattern('twentytwentyfour/text-faq');
	unregister_block_pattern('twentytwentyfour/text-feature-grid-3-col');
	unregister_block_pattern('twentytwentyfour/text-project-details');
	unregister_block_pattern('twentytwentyfour/testimonial-centered');
	unregister_block_pattern('twentytwentyfour/posts-grid-2-col');
	unregister_block_pattern('twentytwentyfour/posts-images-only-3-col');
	unregister_block_pattern('twentytwentyfour/footer-centered-logo-nav');
	unregister_block_pattern('twentytwentyfour/footer-colophon-3-col');
	unregister_block_pattern('twentytwentyfour/footer');
}
add_action('init', 'remove_twenty_twenty_four_patterns');

/** Register blocks */
function my_theme_register_blocks()
{
	/** Common Blocks */
	register_block_type(__DIR__ . '/build/common-blocks/accordion-block');
	register_block_type(__DIR__ . '/build/common-blocks/cta-icon-title-block');
	register_block_type(__DIR__ . '/build/common-blocks/cta-image-title-description-block');
	register_block_type(__DIR__ . '/build/common-blocks/cta-link-block');
	register_block_type(__DIR__ . '/build/common-blocks/cta-popup-link-block');
	register_block_type(__DIR__ . '/build/common-blocks/hero-banner-block');
	register_block_type(__DIR__ . '/build/common-blocks/swiper-slider-block');
	register_block_type(__DIR__ . '/build/common-blocks/hero-swiper-banner');
	register_block_type(__DIR__ . '/build/common-blocks/icon-box-layout-one-block');
	register_block_type(__DIR__ . '/build/common-blocks/icon-box-layout-two-block');
	register_block_type(__DIR__ . '/build/common-blocks/icon-box-layout-three-block');
	register_block_type(__DIR__ . '/build/common-blocks/inner-banner-block');
	register_block_type(__DIR__ . '/build/common-blocks/section-header-block');
	register_block_type(__DIR__ . '/build/common-blocks/subscribe-block');
	register_block_type(__DIR__ . '/build/common-blocks/testimonial-block');
	register_block_type(__DIR__ . '/build/common-blocks/testimonial-block/testimonial-meta-injector');
	register_block_type(__DIR__ . '/build/common-blocks/recent-newsletter-block');
	register_block_type(__DIR__ . '/build/common-blocks/blog-block');
	register_block_type(__DIR__ . '/build/common-blocks/human-body-block');
	register_block_type(__DIR__ . '/build/common-blocks/related-condition-block');
	register_block_type(__DIR__ . '/build/common-blocks/source-link-block');
	register_block_type(__DIR__ . '/build/common-blocks/patient-form-block');
	register_block_type(__DIR__ . '/build/common-blocks/job-list-block');
	register_block_type(__DIR__ . '/build/common-blocks/svg-embed');
	register_block_type(__DIR__ . '/build/common-blocks/video-block');
	register_block_type(__DIR__ . '/build/common-blocks/gallery-block');

	/** Theme Options Blocks */
	register_block_type(__DIR__ . '/build/theme-option-blocks/social-share');
	register_block_type(__DIR__ . '/build/theme-option-blocks/footer-location-box');
	register_block_type(__DIR__ . '/build/theme-option-blocks/header-top-buttons');
	register_block_type(__DIR__ . '/build/theme-option-blocks/header-notification');
	register_block_type(__DIR__ . '/build/theme-option-blocks/copyright-site-title');

	/** Template Blocks */
	register_block_type(__DIR__ . '/build/template-blocks/faq-page');
	register_block_type(__DIR__ . '/build/template-blocks/parent-page');
	register_block_type(__DIR__ . '/build/template-blocks/taxonomy-condition');
	register_block_type(__DIR__ . '/build/template-blocks/team-listing');
	register_block_type(__DIR__ . '/build/template-blocks/team-listing/query-loop-team-custom-meta');
	register_block_type(__DIR__ . '/build/template-blocks/contact-single-location');
	register_block_type(__DIR__ . '/build/template-blocks/contact-single-location/location-meta-injector');
	register_block_type(__DIR__ . '/build/template-blocks/all-location');
	register_block_type(__DIR__ . '/build/template-blocks/all-location/query-loop-locations-custom-meta');
	register_block_type(__DIR__ . '/build/template-blocks/shop-post');
	register_block_type(__DIR__ . '/build/template-blocks/team-page');
	register_block_type(__DIR__ . '/build/template-blocks/video-list');
	register_block_type(__DIR__ . '/build/template-blocks/workshop-page');
	register_block_type(__DIR__ . '/build/template-blocks/testimonial-page');
	register_block_type(__DIR__ . '/build/template-blocks/newsletter-list');
	register_block_type(__DIR__ . '/build/template-blocks/newsletter-list/newsletter-meta');
	register_block_type(__DIR__ . '/build/template-blocks/location-search-page');

	/** Single Post Blocks */
	register_block_type(__DIR__ . '/build/single-post-blocks/single-job');
	register_block_type(__DIR__ . '/build/single-post-blocks/single-workshop');
	register_block_type(__DIR__ . '/build/single-post-blocks/single-team');
	register_block_type(__DIR__ . '/build/single-post-blocks/single-team/team-info-injector');
	register_block_type(__DIR__ . '/build/single-post-blocks/single-team/team-professional-injector');
	register_block_type(__DIR__ . '/build/single-post-blocks/recent-category-post');
	register_block_type(__DIR__ . '/build/single-post-blocks/location-detail-box');
}
add_action('init', 'my_theme_register_blocks');

/** Include all PHP files in the 'inc' directory */
foreach (glob(__DIR__ . '/inc/post-patterns/*.php') as $file) {
	include $file;
}
foreach (glob(__DIR__ . '/inc/theme-option/*.php') as $file) {
	include $file;
}
foreach (glob(__DIR__ . '/inc/core-extensions/*.php') as $file) {
	include $file;
}
foreach (glob(__DIR__ . '/inc/*.php') as $file) {
	include $file;
}

/** Register a custom image size with a 3:4 aspect ratio */
function custom_image_sizes()
{
	add_image_size('team-thumb', 450, 600, true);
}
add_action('after_setup_theme', 'custom_image_sizes');

/** WP: wp_head function to load data into header */
add_action('wp_head', 'add_custom_script_to_head');
function add_custom_script_to_head()
{
?>
	<script>
		/* Mobile Menu */
		document.addEventListener('DOMContentLoaded', function() {
			const navBlocks = document.querySelectorAll('.wp-block-navigation__responsive-container-content');
			const divToClone = document.querySelector('#header-button');

			function updateClonedDiv() {
				if (divToClone) {
					const clonedDiv = divToClone.cloneNode(true);
					navBlocks.forEach(function(navBlock) {
						const existingClone = navBlock.querySelector('#header-button');
						if (existingClone) {
							existingClone.remove();
						}

						const isMobile = window.innerWidth < 992;
						if (isMobile) {
							navBlock.appendChild(clonedDiv);
						}
					});
				}
			}
			updateClonedDiv();
			window.addEventListener('resize', updateClonedDiv);
		});
	</script>
<?php
}

/** WP: wp_footer function to load data into header */
add_action('wp_footer', 'add_custom_script_to_footer');
function add_custom_script_to_footer()
{
?>
	<script>
		function adjustHeader() {
			const header = document.querySelector("header.wp-block-template-part");
			if (header) {
				let headerHeight = header.offsetHeight;
				let headerSpacer = document.querySelector(".header-spacer");
				if (!headerSpacer) {
					headerSpacer = document.createElement("div");
					headerSpacer.className = "header-spacer";
					header.insertAdjacentElement("afterend", headerSpacer);
				}
				headerSpacer.style.height = `${headerHeight}px`;
			}
		}
		document.addEventListener("DOMContentLoaded", function() {
			adjustHeader();
			window.addEventListener("resize", adjustHeader);
		});
	</script>
<?php
}

/** Thank you pages for successful submissions are redirected to the homepage. */
add_action('wp_footer', 'redirect_after_success_template');
function redirect_after_success_template()
{
	// Check if the current page is using the 'success' template
	$template_name = get_page_template_slug();
	if ($template_name === 'wp-custom-template-success') {
		echo '<script>
            setTimeout(function() {
                window.location.href = "' . home_url() . '";
            }, 5000);
        </script>';
	}
}

/** Register 'Common' block with category */
add_filter('block_categories_all', 'add_custom_block_category', 10, 2);
function add_custom_block_category($categories)
{
	$custom_categories = array(
		array(
			'slug'  => 'common_block',
			'title' => __('Common Blocks'),
		),
		array(
			'slug'  => 'archive_template_block',
			'title' => __('Page/Template Blocks'),
		),
		array(
			'slug'  => 'single_post_block',
			'title' => __('Single Post Blocks'),
		),
		array(
			'slug'  => 'theme_option',
			'title' => __('Theme Option'),
		)
	);
	return array_merge($custom_categories, $categories);
}

/** Custom Block namespace configuration  */
add_filter('pre_render_block', 'filter__post_listing_manager_render_block', 10, 2);
function filter__post_listing_manager_render_block($pre_render, $block)
{

	// Check for 'location-listings' or 'team-listings' namespaces
	if (isset($block['attrs']['namespace']) && ($block['attrs']['namespace'] == 'location-listings' || $block['attrs']['namespace'] == 'team-listings' || $block['attrs']['namespace'] == 'team-listing-categorys'
		|| $block['attrs']['namespace'] == 'testimonial-block' || $block['attrs']['namespace'] == 'related-conditions' || $block['attrs']['namespace'] == 'location-listing-single')) {

		// Capture the post type from the block attributes
		$post_type = isset($block['attrs']['query']['postType']) ? $block['attrs']['query']['postType'] : '';

		// Capture the include IDs from the block attributes
		$include_ids = isset($block['attrs']['query']['include']) ? $block['attrs']['query']['include'] : array();

		// Only add the filter if it's not already added
		if (!has_filter('query_loop_block_query_vars', 'modify_query_with_include_ids')) {
			add_filter('query_loop_block_query_vars', 'modify_query_with_include_ids');
		}

		// Store post type in a transient
		set_transient('post_type_for_query', $post_type);

		// Store include_ids in a transient or a static variable if needed
		set_transient('include_ids_for_query', $include_ids);
	}

	return $pre_render;
}
function modify_query_with_include_ids($query)
{

	// Get post type from the transient
	$post_type = get_transient('post_type_for_query');

	// Get include IDs from the transient
	$include_ids = get_transient('include_ids_for_query');

	// Apply post type to the query if set
	if (!empty($post_type)) {
		$query['post_type'] = $post_type;
	}

	// Apply include IDs to the query
	if (!empty($include_ids)) {
		$query['post__in'] = $include_ids;
		$query['orderby'] = 'post__in';
	} else {
		$query['post__in'] = [];
	}

	// Optionally remove the filter to avoid repetition
	remove_filter('query_loop_block_query_vars', 'modify_query_with_include_ids');

	return $query;
}
