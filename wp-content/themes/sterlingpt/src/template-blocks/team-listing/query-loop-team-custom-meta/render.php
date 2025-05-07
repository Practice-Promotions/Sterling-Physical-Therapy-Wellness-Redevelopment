<?php

// Get the ID of the current post in the Query Loop
$post_id = get_the_ID();

// Fetch the 'team_education' custom meta value for the current post
$team_education = get_post_meta($post_id, '_team_education', true);

// Check if 'team_education' has a value
if (!empty($team_education)) {
    // Output the HTML structure with the custom meta value
    echo '<div class="team-designation">'. wp_kses_post($team_education).'</div>';
}

return '';
