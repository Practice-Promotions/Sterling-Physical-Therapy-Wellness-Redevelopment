<?php

global $jobIcon, $roundArrow;

$JobPosts = get_posts(array(
    'post_type' => 'job',
    'posts_per_page' => -1,
));

if ($JobPosts) {
	echo '<div class="job-section">';
		foreach ($JobPosts as $JobPost) {
			$job_title = get_post_meta($JobPost->ID, '_job_title', true);
			$job_street_address = get_post_meta($JobPost->ID, '_job_street_address', true);
			$job_valid_through = get_post_meta($JobPost->ID, '_job_valid_through', true);
			$job_employment_type = get_post_meta($JobPost->ID, '_job_employment_type', true);
			$todayDate = strtotime(date('Ymd'));
			$job_valid_timestamp = strtotime($job_valid_through);
			$jobStatusClass = ($job_valid_timestamp >= $todayDate) ? 'open' : 'closed';
			echo '<div class="job-item">'.
				'<div class="job-item-inner">'.
					'<a class="job-title" href="'. esc_url(get_permalink($JobPost->ID)) .'" aria-label="Job Link">'.
						
						(
							$job_title
							? '<h3 class="h5">'. $jobIcon . $job_title .'</h3>'
							: '<h3 class="h5">'. $jobIcon . esc_html(get_the_title($JobPost->ID)) .'</h3>'
						).
					'</a>'.
					(
						$job_street_address || $job_valid_timestamp >= $todayDate 
						? '<div class="job-location">' .
							(
								$job_street_address
								? '<strong>'. esc_html__('Location: ', 'herostencilpt ') .'</strong>' . $job_street_address 
								: ''
							).
							'<div class="job-status ' . esc_attr($jobStatusClass) . '">' .
									'<strong>'. esc_html__('Status: ', 'herostencilpt ') .'</strong>'.
									'<span>'. esc_html(($job_valid_timestamp >= $todayDate) ? __('Open', 'herostencilpt ') : __('Closed', 'herostencilpt ')) .'</span>'.
							'</div>'.
						'</div>'
						: ''
					).
					'<div class="job-status-type">'.
							(
								$job_employment_type
								? '<div class="job-type">' .
									'<strong>'. esc_html__('Job Type: ', 'herostencilpt ') .'</strong>'. 
									'<span>' .$job_employment_type . '</span>'.
								'</div>'
								: ''
							).
							'<div class="job-date">' .
								esc_html__('Published on: ', 'herostencilpt ') .
								'<span>'. esc_html(get_the_date('j, M Y', $JobPost->ID)) .'</span>'.
							'</div>'.
					'</div>'.
				'</div>'.
				
			'</div>';
		}
	echo '</div>';
} else {
	echo '<h2>'. __('No Job found.', 'herostencilpt ') .'</h2>';
}
?>
