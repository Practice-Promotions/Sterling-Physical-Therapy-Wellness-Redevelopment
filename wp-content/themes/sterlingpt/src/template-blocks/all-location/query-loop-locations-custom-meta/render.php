<?php

$location_id = get_the_ID();

$location_link = get_post_meta($location_id, '_location_map_link', true) ?: '';
$location_title = get_post_meta($location_id, '_location_custom_title', true) ?: '';
$location_phone_number = get_post_meta($location_id, '_location_phone_number', true) ?: '';
$location_fax_number = get_post_meta($location_id, '_location_fax_number', true) ?: '';
$location_email = get_post_meta($location_id, '_location_email', true) ?: '';
$location_address = get_post_meta($location_id, '_location_address', true) ?: '';
$location_working_hours = get_post_meta($location_id, '_location_working_hours', true) ?: '';

$enable_location_address = $attributes['enable_location_address'];
$enable_location_phone_number = $attributes['enable_location_phone_number'];
$enable_location_fax_number = $attributes['enable_location_fax_number'];
$enable_location_email = $attributes['enable_location_email'];
$enable_location_working_hours = $attributes['enable_location_working_hours'];
$enable_location_map_link = $attributes['enable_location_map_link'];

$enable_address_label = $attributes['enable_address_label'];
$enable_working_hours_label = $attributes['enable_working_hours_label'];

$output = '<div class="location-listing-info">';

$output .= do_shortcode('[location-custom-title]');

if ($enable_address_label) {
    $output .= '<h6 class="label">Address</h6>';
}

if ($location_address && $enable_location_address) {
    $output .= do_shortcode('[location-address]');
}

if ($location_phone_number || $location_fax_number) {
    $output .= '<div class="location-listing-wrap">';
    if ($location_phone_number && $enable_location_phone_number) {
        $output .= do_shortcode('[location-phone]');
    }
    if ($location_fax_number && $enable_location_fax_number) {
        $output .= do_shortcode('[location-fax]');
    }
    $output .= '</div>';
}

if ($location_email && $enable_location_email) {
    $output .= do_shortcode('[location-email]');
}

if ($location_working_hours && $enable_location_working_hours) {
    $output .= '<div class="business-hours">';
    if ($enable_working_hours_label) {
        $output .= '<h6 class="label">Business Hours</h6>';
    }
    $output .= do_shortcode('[location-hours]');
    $output .= '</div>';
}

if ($location_link && $enable_location_map_link) {
    $output .= '<div class="location-listing-action">
        <a href="' . get_the_permalink($location_id) . '" title="' . esc_attr(get_the_title($location_id)) . '" class="btn primary" aria-label="Location Info">' . __('View Info', 'herostencilpt') . '</a>
        <a href="' . esc_url($location_link) . '" title="' . esc_attr($location_title) . '" target="_blank" class="btn outline" aria-label="Location Info">' . __('Direction', 'herostencilpt') . '</a>
    </div>';
}

$output .= '</div>';

echo $output;
