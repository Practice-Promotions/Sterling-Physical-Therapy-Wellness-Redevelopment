<?php
global $post;

// Workshop query
$workshop_args = array(
    'post_type'      => 'workshop',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => -1
);
$workshop_query = new WP_Query($workshop_args);

$todayDate = strtotime(date('Ymd'));
$workshop_found = false;

if ($workshop_query->have_posts()) {

    echo '<div class="workshop-listing">';

		while ($workshop_query->have_posts()) : $workshop_query->the_post();

			// Custom Meta
			$workshop_date = get_post_meta($post->ID, '_workshop_date', true);
			$workshop_valid_timestamp = strtotime($workshop_date);

			if ($workshop_valid_timestamp >= $todayDate) {
				$workshop_found = true;

				$workshop_datenew = new DateTime($workshop_date);
				$workshop_host_image = get_post_meta($post->ID, '_workshop_host_image', true);
				$workshop_host_by_title = get_post_meta($post->ID, '_workshop_host_by_title', true);
				$workshop_host_name = get_post_meta($post->ID, '_workshop_host_name', true);
				$workshop_host_designation = get_post_meta($post->ID, '_workshop_host_designation', true);
				$workshop_highlight_text = get_post_meta($post->ID, '_workshop_highlight_text', true);
				$workshop_url = get_post_meta($post->ID, '_workshop_url', true);
				$workshop_redirect = get_post_meta($post->ID, '_workshop_redirect', true);

				echo '<div class="workshop-item '. ( $workshop_host_image ? 'has-image' :'' ) .'">'.
					(
						$workshop_host_name || $workshop_host_image || $workshop_host_designation
						? '<div class="workshop-author">'.
							(
								$workshop_host_image
								? '<div class="author">'.
									'<figure>'.
										'<img class="size-medium" src="'. esc_url($workshop_host_image) .'" alt="'. esc_attr($workshop_host_name) .'" size="medium">'.
									'</figure>'.
								'</div>'
								: ''
							).
							(
								$workshop_host_by_title || $workshop_host_name || $workshop_host_designation
								? '<div class="author-data">'.
								(
									$workshop_host_by_title
									? '<div class="host-title">'. esc_html($workshop_host_by_title) .'</div>'
									: ''
								).
								(
									$workshop_host_name
									? '<div class="host-name">'. esc_html($workshop_host_name) .'</div>'
									: ''
								).
								(
									$workshop_host_designation
									? '<div class="host-designation">'. esc_html($workshop_host_designation) .'</div>'
									: ''
								).
							'</div>'
								:''
							).
						'</div>'
						: ''
					).
					(
						get_the_title() || get_the_excerpt() || $workshop_highlight_text
						? '<div class="workshop-info">'.
							(
								$workshop_url && !$workshop_redirect
								? '<h3 class="h2"><a href="'. $workshop_url .'" title="'. get_the_title() .'" target="_blank">'. get_the_title() .'</a></h3>'
								: '<h3 class="h2"><a href="'. esc_url(get_the_permalink()) .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>'
							).
							'<div class="excerpt">'. get_the_excerpt() .'</div>'.
							(
								$workshop_highlight_text
								? '<h4>'. esc_html($workshop_highlight_text) .'</h4>'
								: ''
							).
							(
								$workshop_date
								? '<div class="date">'. esc_html($workshop_datenew->format('l, M j, Y')) .'</div>'
								: ''
							).
							(
								$workshop_url && !$workshop_redirect
								? '<a class="btn" href="'. $workshop_url .'" aria-label="Workshop Link" target="_blank">'. esc_html('Register Now', 'herostencilpt') .'</a>'
								: '<a class="btn" href="'. esc_url(get_the_permalink()) .'" aria-label="Workshop Link">'. esc_html('Register Now', 'herostencilpt') .'</a>'
							).
						'</div>'
						: ''
					).
				'</div>';

			}

		endwhile; wp_reset_postdata();

		if (!$workshop_found) {
			echo '<h2>'. __( 'No Workshop found...', 'herostencilpt' ) .'</h2>';
		}

    echo '</div>';

}