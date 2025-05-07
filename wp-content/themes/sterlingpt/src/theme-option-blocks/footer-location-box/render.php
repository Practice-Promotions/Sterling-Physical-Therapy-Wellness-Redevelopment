<?php

$attributes = $block->attributes; 

$location_type = isset($attributes['locationType']) ? $attributes['locationType'] : 'single-location';

$locationdetails_args = array(
    'post_type'      => 'location',
    'posts_per_page' => $location_type === 'multi-location' ? 3 : 1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$locationdetails_query = new WP_Query($locationdetails_args);

if ($location_type === 'multi-location') {
    echo '<div class="footer-location-listing">';
    while ($locationdetails_query->have_posts()) : $locationdetails_query->the_post();
        echo '<div class="footer-location-item footer-location-detail">' .
            do_shortcode('[location-custom-title]') .
            do_shortcode('[location-email]') .
            '<div class="footer-location-wrap">' .
                do_shortcode('[location-phone]') .
                do_shortcode('[location-fax]') .
            '</div>' .
            do_shortcode('[location-address]') .
            '<div class="footer-location-goto">' .
                '<a class="btn-link" href="' . get_the_permalink() . '" title="' . esc_attr(get_the_title()) . '">Location Info</a>' .
            '</div>' .
        '</div>';
    endwhile;
    echo '</div>';
} else {
    echo '<div class="footer-location-single">';
    while ($locationdetails_query->have_posts()) : $locationdetails_query->the_post();
        echo '<div class="footer-location-address">' .
                '<h4>'. __( 'Location', 'herostencilpt' ) .'</h4>'.
                do_shortcode('[location-address]') .
            '</div>' .
            '<div class="footer-location-contact">' .
                '<h4>'. __( 'Contact', 'herostencilpt' ) .'</h4>'.
                do_shortcode('[location-email]') .
                do_shortcode('[location-phone]') .
                do_shortcode('[location-fax]') .
            '</div>';
    endwhile;
    echo '</div>';
}

wp_reset_postdata(); // Reset the post data after the query

?>
