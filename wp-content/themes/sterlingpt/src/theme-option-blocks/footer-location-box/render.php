<?php


$locationdetails_args = array(
    'post_type'      => 'location',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
);

$locationdetails_query = new WP_Query($locationdetails_args);

echo '<div class="footer-location-listing">';
while ($locationdetails_query->have_posts()) : $locationdetails_query->the_post();
    echo '<div class="footer-location-item footer-location-detail">' .
        do_shortcode('[location-custom-title]') .
        // do_shortcode('[location-phone]') .
        do_shortcode('[location-address]') .
        (
            do_shortcode('[location-phone]')
            ? '<span>Phone:  '. do_shortcode('[location-phone]') .'</span>'
            : ''
        ).
    '</div>';
endwhile;
echo '</div>';

wp_reset_postdata(); // Reset the post data after the query

?>
