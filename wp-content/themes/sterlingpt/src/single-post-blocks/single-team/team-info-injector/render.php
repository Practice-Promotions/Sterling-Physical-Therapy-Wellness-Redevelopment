<?php
// Fetch the 'team_education' custom meta value for the current post
$education = get_post_meta(get_the_ID(), '_team_education', true);


echo '<div class="team-contact-info">';
    if ( !empty($education) ) {
        echo '<p class="team-designation">' . wp_kses_post($education) . '</p>';
    }
echo '</div>';
