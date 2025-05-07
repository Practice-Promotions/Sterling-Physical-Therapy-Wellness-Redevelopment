<?php
$testimonial_post_id = get_the_ID(); 

$testimonial_title = get_post_meta($testimonial_post_id, '_testimonial_title', true) ?: '';
$enable_testimonial_title = $attributes['enable_testimonial_title'];

$output = '';
if ($testimonial_title && $enable_testimonial_title) {
    $output .= '<h3>"' . esc_html($testimonial_title) . '"</h3>';
}
echo $output;