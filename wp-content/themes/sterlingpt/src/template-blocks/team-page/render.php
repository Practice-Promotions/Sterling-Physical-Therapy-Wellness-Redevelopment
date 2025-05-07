<?php
global $post;
$attributes = $block->attributes; 

$selectlayout = isset($attributes['teamSelectType']) ? $attributes['teamSelectType'] : 'team-category-listing';
$teamcatterms = get_terms( 'team_category' );
$teamlocterms = get_terms( 'location_category' );

/** layout condition start */
if ( $selectlayout == 'team-category-listing' ) {
	/** Team posts by category list */
	if ( $teamcatterms ) :
		/** Posts */
		echo '<div class="team-wrapper">';
			foreach ( $teamcatterms as $teamcatterm ) :
				$teamargs  = array(
					'taxonomy'       => 'team_category',
					'term'           => $teamcatterm->slug,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => -1
				);
				$teamquery = new WP_Query( $teamargs );
				if ( $teamquery->have_posts() ) :
					echo '<div class="team-listing">'.
						'<h2 class="h4 team-cat-title">'. $teamcatterm->name .'</h2>';
						while ( $teamquery->have_posts() ) : $teamquery->the_post();
						$education = get_post_meta( $post->ID, '_team_education', true );
							echo '<div class="team-item">'.
								'<div class="team-item-inner">'.
									'<a href="'. get_the_permalink() .'" class="team-media">'.
										(
											has_post_thumbnail()
											? get_the_post_thumbnail( '', 'team-thumb' )
											: '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title() ) . '" class="wp-post-image" />'
										) .
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
		echo '</div>';
	endif;
} elseif ( $selectlayout == 'team-category-filter' ) {
	/** Team posts by category filter */
	if ( $teamcatterms ) :
		/** Category filter */
		echo '<div class="category-filter team-cat-filter">'.
			'<ul class="category-filter-nav">'.
				'<li><a href="javascript:void(0);" data-id="all" class="btn active" role="button"><span>'. __( 'View All', 'herostencilpt' ) .'</span></a></li>';
				foreach ( $teamcatterms as $teamcatterm ) :
					echo '<li><a href="javascript:void(0);" data-id="'. $teamcatterm->term_id .'" class="btn" role="button"><span>'. ucfirst( $teamcatterm->name ) .'</span></a></li>';
				endforeach;
			echo '</ul>'.
			'<select class="category-select-nav" aria-label="Select Category">'.
				'<option data-id="all" selected>'. __( 'View All', 'herostencilpt' ) .'</option>';
				foreach ( $teamcatterms as $teamcatterm ) :
				echo '<option data-id="'. $teamcatterm->term_id .'" value="'. $teamcatterm->slug .'" aria-label="'.ucfirst( $teamcatterm->name ).'">'. ucfirst( $teamcatterm->name ) .'</option>',"\n";
				endforeach;
			echo '</select>'.
		'</div>';
		/** Posts */
		$teamargs  = array(
			'post_type'      => 'our_team',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => -1
		);
		$teamquery = new WP_Query( $teamargs );
		if ( $teamquery->have_posts() ) :
			echo '<div class="team-wrapper">'.
				'<div class="team-listing">';
					while ( $teamquery->have_posts() ) : $teamquery->the_post();
					$education = get_post_meta( $post->ID, '_team_education', true );
						echo '<div class="team-item">'.
							'<div class="team-item-inner">'.
								'<a href="'. get_the_permalink() .'" class="team-media">'.
									(
										has_post_thumbnail()
										? get_the_post_thumbnail( '', 'team-thumb' )
										: '<img src="'. get_theme_file_uri() .'/assets/images/placeholder-avatar.jpg" alt="' . esc_attr( get_the_title() ) . '" class="wp-post-image" />'
									) .
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
				echo '</div>'.
			'</div>';
		endif;
	endif;
} elseif ( $selectlayout == 'team-location-filter' ) {
	/** Team posts by location filter */
	if ( $teamlocterms ) :
		/** Category filter */
		echo '<div class="category-filter team-loc-filter">'.
			'<ul class="category-filter-nav">'.
				'<li><a href="javascript:void(0);" data-id="all" class="btn active"><span>'. __( 'View All', 'herostencilpt' ) .'</span></a></li>';
				foreach ( $teamlocterms as $teamlocterm ) :
					echo '<li><a href="javascript:void(0);" data-id="'. $teamlocterm->term_id .'" data-slug="'. $teamlocterm->slug .'" class="btn"><span>'. ucfirst( $teamlocterm->name ) .'</span></a></li>';
				endforeach;
			echo '</ul>'.
			'<select class="category-select-nav">'.
				'<option data-id="all" selected>'. __( 'View All', 'herostencilpt' ) .'</option>';
				foreach ( $teamlocterms as $teamlocterm ) :
					echo '<option data-id="'. $teamlocterm->term_id .'" value="'. $teamlocterm->slug .'">'. ucfirst( $teamlocterm->name ) .'</option>',"\n";
				endforeach;
			echo '</select>'.
		'</div>';
		/** Posts */
		echo '<div class="team-wrapper">';
			foreach ( $teamcatterms as $teamcatterm ) :
				$teamargs  = array(
					'taxonomy'       => 'team_category',
					'term'           => $teamcatterm->slug,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => -1
				);
				$teamquery = new WP_Query( $teamargs );
				if ( $teamquery->have_posts() ) :
					echo '<div class="team-listing">'.
						'<h3 class="team-cat-title">'. $teamcatterm->name .'</h3>';
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
		echo '</div>';
	endif;
}

?>
