<?php

$newsletter_id = get_the_ID();

$newsletter_link = get_post_meta($newsletter_id, '_newsletter_url', true) ?: '';
if ($newsletter_link) {
    echo '<a href="' . $newsletter_link . '" title="' . esc_attr(get_the_title($newsletter_id)) . '" class="btn primary" aria-label="newsletter Info">' . __('Read More', 'herostencilpt') . '</a>';
} else {
    echo '<a href="' . get_the_permalink($newsletter_link) . '" title="' . esc_attr(get_the_title($newsletter_id)) . '" class="btn primary" aria-label="newsletter Info">' . __('Read More', 'herostencilpt') . '</a>';
}
