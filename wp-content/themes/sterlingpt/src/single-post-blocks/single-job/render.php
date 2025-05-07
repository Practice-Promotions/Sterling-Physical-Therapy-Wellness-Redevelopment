<?php
// Check if this is a single 'job' post type
if (is_singular('job')) {

    // Custom Meta
    $job_hiring_type = get_post_meta(get_the_ID(), '_job_hiring_type', true);
    $job_hiring_form = get_post_meta(get_the_ID(), '_job_hiring_form', true);
    $job_hiring_thirdparty_link = get_post_meta(get_the_ID(), '_job_hiring_thirdparty_link', true);

    $job_date_posted = get_post_meta(get_the_ID(), '_job_date_posted', true);
    $job_valid_through = get_post_meta(get_the_ID(), '_job_valid_through', true);

    $jobdate = $job_date_posted ? new DateTime($job_date_posted) : null;
    $jobvaliddate = $job_valid_through ? new DateTime($job_valid_through) : null;


    $job_base_salary = get_post_meta(get_the_ID(), '_job_base_salary', true);
    $job_min_salary = get_post_meta(get_the_ID(), '_job_min_salary', true);
    $job_max_salary = get_post_meta(get_the_ID(), '_job_max_salary', true);
    $job_salary_in_currency = get_post_meta(get_the_ID(), '_job_salary_in_currency', true);
    $job_salary_per_unit = get_post_meta(get_the_ID(), '_job_salary_per_unit', true);
    $job_employment_type = get_post_meta(get_the_ID(), '_job_employment_type', true);
    $job_description = get_post_meta(get_the_ID(), '_job_description', true);
    $job_street_address = get_post_meta(get_the_ID(), '_job_street_address', true);
    $job_full_address = get_post_meta(get_the_ID(), '_job_full_address', true);
    $job_location_map = get_post_meta(get_the_ID(), '_job_location_map', true);
    $job_locality = get_post_meta(get_the_ID(), '_job_locality', true);
    $job_postal_code = get_post_meta(get_the_ID(), '_job_postal_code', true);
    $job_education = get_post_meta(get_the_ID(), '_job_education', true);
    $job_qualifications = get_post_meta(get_the_ID(), '_job_qualifications', true);
    $job_responsibilities = get_post_meta(get_the_ID(), '_job_responsibilities', true);
    $job_skills = get_post_meta(get_the_ID(), '_job_skills', true);
    $job_benefits = get_post_meta(get_the_ID(), '_job_benefits', true);
    

    $todayDate = strtotime(date('Ymd'));
    $job_valid_timestamp = strtotime($job_valid_through);
    $jobStatusClass = ($job_valid_timestamp >= $todayDate) ? 'open' : 'closed';

    echo '<div class="job-single-wrap">' . 
        (
            $jobdate || $jobvaliddate || $job_base_salary || $job_min_salary || $job_max_salary || $job_salary_in_currency || $job_salary_per_unit
            ? '<div class="job-single-meta">'.
                '<div class="job-meta-items">'.

                    ( $jobdate ? '<p class="job-date"><span>'.esc_html(__('Date Posted: ', 'herostencilpt')).'</span>'. $jobdate->format('F jS, Y') .'</p>' : '' ).

                    ( $jobvaliddate ? '<p class="job-valid-date"><span>'.esc_html(__('Date Valid Through: ', 'herostencilpt')).'</span>'. $jobvaliddate->format('F jS, Y') .'</p>' : '' ).

                    (
                        ( $job_base_salary ) 
                        ? '<p class="job-salary">'.
                            '<span>' . esc_html(__('Base Salary: ', 'herostencilpt')) . '</span>' .
                            (
                                $job_base_salary 
                                ? esc_html__('$', 'herostencilpt') . $job_base_salary 
                                : ''
                            ).
                        '</p>' 
                        : ''
                    ).
                    (
                        ( $job_min_salary ) 
                        ? '<p class="job-salary">'.
                            '<span>' . esc_html(__('Min Salary: ', 'herostencilpt')) . '</span>' .
                            (
                                $job_min_salary 
                                ? esc_html__('$', 'herostencilpt') . $job_min_salary 
                                : ''
                            ). 
                        '</p>' 
                        : ''
                    ).
                    (
                        ( $job_max_salary ) 
                        ? '<p class="job-salary">'.
                            '<span>' . esc_html(__('Max Salary: ', 'herostencilpt')) . '</span>' .
                            (
                                $job_max_salary 
                                ? esc_html__('$', 'herostencilpt') . $job_max_salary 
                                : ''
                            ). 
                        '</p>' 
                        : ''
                    ).
                '</div>'.
                '<div class="job-meta-items">'.
                    ( $job_salary_in_currency ? '<p class="job-currency"><span>'.esc_html(__('Salary Currency: ', 'herostencilpt')).'</span>'. $job_salary_in_currency  .'</p>' : '' ).

                    ( $job_salary_per_unit ? '<p class="job-currency font-medium"><span>'.esc_html(__('Salary Per Unit: ', 'herostencilpt')).'</span>'. $job_salary_per_unit .'</p>' : '' ).
                '</div>'.
                    (
                        ($job_valid_timestamp >= $todayDate)
                        ? (
                            ($job_hiring_type === 'shortcode' && $job_hiring_form)
                            ? '<div class="job-application-apply"><a href="#apply-today" target="_self" class="goto-link btn">'. __( 'Apply Now', 'herostencilpt' ) .'</a></div>'
                            : (
                                 $job_hiring_thirdparty_link
                                 ? '<div class="job-application-apply"><a href="'. $job_hiring_thirdparty_link .'" target="_blank" class="btn">'. __( 'Apply Now', 'herostencilpt' ) .'</a></div>'
                                 :''
                              )
                          )
                        : ''
                    ).   
                '</div>'
            : ''
        ).
        (
            $job_employment_type || $job_street_address || $job_education || $job_qualifications || $job_responsibilities || $job_skills || $job_description || $job_benefits || $job_full_address || $job_location_map || $job_full_address || $job_location_map 
            ? '<div class="job-requirement-wrap">'.
                '<div class="job-requirement">'.
                    (
                        $job_valid_timestamp
                        ? '<div class="job-status ' . ($job_valid_timestamp >= $todayDate ? 'open' : 'closed') . '">'.
                            '<span>Status:</span>'.
                            '<span>'. esc_html(($job_valid_timestamp >= $todayDate) ? __('Open', 'herostencilpt') : __('Closed', 'herostencilpt')) .'</span>'.
                            '</div>'
                        : ''
                    ).
                    (
                        $job_full_address 
                        ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>' . esc_html(__(' Full Address: ', 'acephysique')) . '</span></p></div>'.
                            (
                                $job_location_map 
                                ? '<div class="job-requirement-col-2 address"><a href="'. esc_url($job_location_map) .'" target="_blank">'. esc_html($job_full_address) .'</a></div>'
                                : esc_html($job_full_address) 
                            ) .
                        '</div>' 
                        : ''
                    ).
                    ( $job_employment_type ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Type:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_employment_type .'</div></div>' : '' ).
                    ( $job_education ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Education:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_education .'</div></div>' : '' ).
                    ( $job_description ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Job Description:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_description .'</div></div>' : '' ).
                    // ( $job_education ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Education:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_education .'</div></div>' : '' ).
                    // ( $job_qualifications ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Qualifications:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_qualifications .'</div></div>' : '' ).
                    // ( $job_responsibilities ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Responsibilities:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_responsibilities .'</div></div>' : '' ).
                    // ( $job_skills ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Skills:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_skills .'</div></div>' : '' ).
                    // ( $job_benefits ? '<div class="job-requirement-row"><div class="job-requirement-col-1"><p><span>'. esc_html(__('Benefits:', 'herostencilpt')) .'</span></p></div><div class="job-requirement-col-2">'. $job_benefits .'</div></div>' : '' ).
                '</div>'.
            '</div>'
            : ''
        ).
       
        /** Get the content */
        ( get_the_content() ? '<div class="job-content">'. apply_filters( 'the_content', get_the_content() ) .'</div>' :'' ).
        
        /* form and third-party link. */
        '<div class="job-application">';

            if ($job_valid_timestamp >= $todayDate) {
                if ($job_hiring_type === 'shortcode' && $job_hiring_form) {
                    // Display the form if shortcode is selected
                    echo '<div id="apply-today" class="job-application-form">' . do_shortcode($job_hiring_form) . '</div>';
                } elseif ($job_hiring_type === 'thirdparty' && $job_hiring_thirdparty_link) {
                    // Display "Apply Now" button if third-party link is selected
                    echo '<div class="job-application-link">';
                    echo '<a href="' . esc_url($job_hiring_thirdparty_link) . '" class="btn" target="_blank">' . __('Apply Now', 'herostencilpt') . '</a>';
                    echo '</div>';
                } else {
                    echo '<div class="job-application-note"><p>' . __('Application details are missing.', 'herostencilpt') . '</p></div>';
                }
            } else {
                echo '<div class="job-application-note"><p>' . __('Requirement is closed.', 'herostencilpt') . '</p></div>';
            }
            
        echo '</div>'.
    '</div>';
} else {
    echo '<h2>' . gettext(' This block is used exclusively on the Job Post page or the Single job Template. ') . '</h2>';
}
