<?php
/**
* Team functions and definitions and Meta related things.
*
* @package herostencilpt
*/

/** Post Type: Our Team. */
function team_register_cpts() {
	$labels = [
		"name" => __( "Our Team", "herostencilpt" ),
		"singular_name" => __( "Our Team", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Our Team", "herostencilpt" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
        "single" => true,
        "type" => "string",
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "our-team", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => true,
		"menu_icon" => 'dashicons-groups',
	];
	register_post_type( "our_team", $args );
}
add_action( 'init', 'team_register_cpts' );

/** Taxonomy: Team Categories. */
function team_register_taxes() {
	$labels = [
		"name" => __( "Team Categories", "herostencilpt" ),
		"singular_name" => __( "Team Category", "herostencilpt" ),
	];
	$args = [
		"label" => __( "Team Categories", "herostencilpt" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'team-category', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "team_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "team_category", [ "our_team" ], $args );
}
add_action( 'init', 'team_register_taxes' );

/** Add the CPT name between the home and page name. */
add_filter( 'wpseo_breadcrumb_links', 'my_theme_wpseo_breadcrumb_links' );
function my_theme_wpseo_breadcrumb_links( $links ) {
	$postobj = get_post_type_object( get_post_type() );
	if ( is_singular( 'our_team' ) && $postobj ) {
		$rewriteslug      = $postobj->rewrite['slug'];
		$rewriteslugfinal = preg_split( '/\//', $rewriteslug );
		$pageobj          = get_page_by_path( $rewriteslugfinal[0] );
		$teampageid       = $pageobj->ID;
		$breadcrumb[]     = array(
			'url' => get_permalink( $teampageid ),
			'text' => 'Our Team',
		);
		array_splice( $links, 1, -2, $breadcrumb );
	}
	return $links;
}

/** Add Meta Box. */
function add_team_meta_box() {
    add_meta_box(
        'team_meta_box',
        'Post: Our Team',
        'display_team_meta_box',
        'our_team',
        'advanced',
        'high',
		'add_team_meta_to_rest_response'
    );
}
add_action('add_meta_boxes', 'add_team_meta_box');


/** Display Meta Box. */
function display_team_meta_box($post) {
	// Add nonce for security and authentication
	wp_nonce_field('save_team_meta_box', 'team_meta_box_nonce');

	$education = get_post_meta($post->ID, '_team_education', true);
    ?>
    <div class="team-meta-box">
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" data-tab="doctor-info">Team Designation</a>
        </h2>
        <div id="doctor-info" class="tab-content">
			<div class="meta-field">
				<label for="team_education">Designation</label>
				<textarea name="team_education" id="team_education"><?php echo esc_textarea($education); ?></textarea>
			</div>
		</div>
    </div>
    <?php
}

/** Save Meta Box. */
function save_team_meta_box($post_id) {

    // Save simple fields
    if (array_key_exists('team_education', $_POST)) {
		update_post_meta($post_id, '_team_education', wp_kses_post($_POST['team_education']));
    }
}
add_action('save_post', 'save_team_meta_box');


/** AJAX: show category based team listing */
add_action('wp_ajax_team_category_filter', 'team_category_filter');
add_action('wp_ajax_nopriv_team_category_filter', 'team_category_filter');
function team_category_filter() {
	global $post;
	$dataid = $_POST['dataid'];
	if ( $dataid == 'all' ) :
		$teamargs = array(
			'post_type'      => 'our_team',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1
		);
	else :
		$teamargs = array(
			'post_type'      => 'our_team',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'team_category',
					'field'    => 'term_id',
					'terms'    => $dataid
				)
			)
		);
	endif;
	$teamquery = new WP_Query( $teamargs );
	if ( $teamquery->have_posts() ) :
		echo '<div class="team-listing">';
			while ( $teamquery->have_posts() ) : $teamquery->the_post();
			$education = get_post_meta( $post->ID, '_team_education', true );
				echo '<div class="team-item">'.
					'<div class="team-item-inner">'.
						'<a href="'. get_the_permalink() .'" class="team-media">'.
							(
								has_post_thumbnail()
								? get_the_post_thumbnail( '', 'team-thumb' )
								: '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title() ) . '" class="wp-post-image" />'
							).
							'<div class="team-hover">'.
								'<span class="btn-link">'. __( 'Read More', 'herostencilpt' ) .'</span>'.
							'</div>'.
						'</a>'.
						'<div class="team-body">'.
							'<h3 class="team-name"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></h3>'.
							( $education ? '<p>' . wp_kses_post($education) . '</p>' :'' ).
						'</div>'.
					'</div>'.
				'</div>';
			endwhile; wp_reset_postdata();
		echo '</div>';
	endif;
	wp_die();
}

/** AJAX: show location based team listing */
add_action('wp_ajax_team_location_filter', 'team_location_filter');
add_action('wp_ajax_nopriv_team_location_filter', 'team_location_filter');
function team_location_filter() {
	global $post;
	$dataid   = $_POST['dataid'];
	if ( $dataid == 'all' ) :
		$teamterms = get_terms('team_category');
		foreach ( $teamterms as $teamterm ) :
			$teamargs = array(
				'taxonomy'       => 'team_category',
				'term'           => $teamterm->slug,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'post_status'    => 'publish',
				'posts_per_page' => -1
			);
			$teamquery = new WP_Query( $teamargs );
			if ( $teamquery->have_posts() ) :
				echo '<div class="team-listing">'.
					'<h3 class="team-cat-title">'. $teamterm->name .'</h3>';
					while ( $teamquery->have_posts() ) : $teamquery->the_post();
					$education = get_post_meta( $post->ID, '_team_education', true );
						echo '<div class="team-item">'.
							'<div class="team-item-inner">'.
								'<a href="'. get_the_permalink() .'" class="team-media">'.
									(
										has_post_thumbnail()
										? get_the_post_thumbnail( '', 'team-thumb' )
										: '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title() ) . '" class="wp-post-image" />'
									).
									'<div class="team-hover">'.
										'<span class="btn-link">'. __( 'Read More', 'herostencilpt' ) .'</span>'.
									'</div>'.
								'</a>'.
								'<div class="team-body">'.
									'<h3 class="team-name"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></h3>'.
									( $education ? '<p>' . wp_kses_post($education) . '</p>' :'' ).
								'</div>'.
							'</div>'.
						'</div>';
					endwhile; wp_reset_postdata();
				echo '</div>';
			endif;
		endforeach; wp_reset_postdata();
	else :
		$teamargs1 = array (
			'post_type'      => 'our_team',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'location_category',
					'field'    => 'term_id',
					'terms'    => $dataid
				)
			)
		);
		$teamquery1 = new WP_Query( $teamargs1 );
		if ( $teamquery1->have_posts() ) :
			$unique_cat = array();
			while ( $teamquery1->have_posts() ) : $teamquery1->the_post();
			$education = get_post_meta( $post->ID, '_team_education', true );
				$teamterms1 =  get_the_terms( get_the_id(), 'team_category' );
				foreach ( $teamterms1 as $teamterm1 ) :
					$unique_cat[] = $teamterm1->slug;
				endforeach;
			endwhile; wp_reset_postdata();
			$get_cat = array_unique( $unique_cat );
			$teamterms2 =  get_terms('team_category');
			foreach ( $teamterms2 as $teamterm2 ) :
				if ( in_array( $teamterm2->slug, $get_cat ) ) :
					$teamargs2 = array(
						'post_type'      => 'our_team',
						'orderby'        => 'menu_order',
						'order'          => 'ASC',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'tax_query'      => array(
						'relation'       => 'AND',
							array(
								'taxonomy' => 'location_category',
								'field'    => 'term_id',
								'terms'    => $dataid,
							),
							array(
								'taxonomy' => 'team_category',
								'field'    => 'term_id',
								'terms'    => $teamterm2->term_id,
							)
						)
					);
					$teamquery2 = new WP_Query( $teamargs2 );
					if ( $teamquery2->have_posts() ) :
						echo '<div class="team-listing">'.
							'<h3 class="team-cat-title">'. $teamterm2->name .'</h3>';
							while ( $teamquery2->have_posts() ) : $teamquery2->the_post();
							$education = get_post_meta( $post->ID, '_team_education', true );
								echo '<div class="team-item">'.
									'<div class="team-item-inner">'.
										'<a href="'. get_the_permalink() .'" class="team-media">'.
											(
												has_post_thumbnail()
												? get_the_post_thumbnail( '', 'team-thumb' )
												: '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title() ) . '" class="wp-post-image" />'
											).
											'<div class="team-hover">'.
												'<span class="btn-link">'. __( 'Read More', 'herostencilpt' ) .'</span>'.
											'</div>'.
										'</a>'.
										'<div class="team-body">'.
											'<h3 class="team-name"><a href="'. get_the_permalink() .'">'. get_the_title() .'</a></h3>'.
											( $education ? '<p>' . wp_kses_post($education) . '</p>' :'' ).
										'</div>'.
									'</div>'.
								'</div>';
							endwhile; wp_reset_postdata();
						echo '</div>';
					endif;
				endif;
			endforeach; wp_reset_postdata();
		endif;
	endif;
	wp_die();
}