<?php

global $post;

$attributes = $block->attributes; 

$selectlayout = isset($attributes['faqSelectType']) ? $attributes['faqSelectType'] : 'faq-normal-listing';
$layoutType = isset($attributes['faqLayoutType']) ? $attributes['faqLayoutType'] : 'single-column'; // Default to 'single-column'

// FAQ query
$faqargs = array(
    'post_type'      => 'faq',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => -1
);
$faqquery = new WP_Query($faqargs);

// FAQ Category
$faqterms = get_terms('faq_category');


if ($faqquery->have_posts()) {

    echo '<div class="accordion-wrapper ' . (($selectlayout == 'faq-normal-listing') ? 'no-filter' : '') . '">';

    if ($selectlayout == 'faq-category-filter') {

        /** FAQs category filter */
        if ($faqterms) {
            echo '<div class="category-filter accordion-cat-filter">' .
                '<ul class="category-filter-nav">' .
                    '<li><a href="javascript:void(0);" data-id="all" class="link active" role="button"><span>' . __('View All', 'herostencilpt') . '</span></a></li>';
                    foreach ($faqterms as $faqterm) :
                        echo '<li><a href="javascript:void(0);" data-id="' . esc_attr($faqterm->term_id) . '" class="link" role="button"><span>' . esc_html($faqterm->name) . '</span></a></li>';
                    endforeach;
                echo '</ul>'.
                '<select class="category-select-nav" aria-label="Select FAQ">' .
                    '<option data-id="all" selected>' . __('View All', 'herostencilpt') . '</option>';
                    foreach ($faqterms as $faqterm) :
                        echo '<option data-id="' . esc_attr($faqterm->term_id) . '" value="' . esc_attr($faqterm->slug) . '">' . esc_html($faqterm->name) . '</option>';
                    endforeach; 
                echo '</select>'.
            '</div>';
        }
    }

    /** FAQs post */
    echo '<div class="accordion-list ' . (($selectlayout == 'faq-normal-listing') ? 'no-filter' : '') . ' ' . esc_attr($layoutType) . '">';
    while ($faqquery->have_posts()) : $faqquery->the_post();
        echo '<div class="accordion-item">' .
            '<div class="accordion-title" aria-expanded="false">' .
                '<h5 style="' . (!empty($item_text_color) ? 'color:' . esc_attr($item_text_color) . ';' : '') . '">' . get_the_title() . '</h5>' .
                '<span></span>' .
            '</div>' .
            '<div class="accordion-content" style="display:none;">' .
            apply_filters('the_content', get_post_field('post_content', get_the_ID())) .
            '</div>' .
            '</div>';
    endwhile;
    wp_reset_postdata();
    echo '</div>';

    echo '</div>';
}
?>
