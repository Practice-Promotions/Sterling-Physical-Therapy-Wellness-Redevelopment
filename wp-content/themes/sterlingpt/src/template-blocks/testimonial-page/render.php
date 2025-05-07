<?php

global $iconquotestart;

$testimonialargs = array(
    'post_type'      => 'testimonial',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => -1
);
$testimonialquery = new WP_Query($testimonialargs);

// Testimonial Category
$testimonialterms = get_terms('testimonial_category');

if ($testimonialquery->have_posts()) {
    echo '<section class="testimonial-page">';

	    /** Testimonial category filter */
	    if ($testimonialterms) {
	        echo '<div class="category-filter testimonial-cat-filter">' .
		        '<ul class="category-filter-nav">' .
		        	'<li><a href="javascript:void(0);" data-id="all" class="btn active" role="button"><span>' . __('View All', 'herostencilpt') . '</span></a></li>';
			        foreach ($testimonialterms as $testimonialterm) :
			            echo '<li><a href="javascript:void(0);" data-id="' . $testimonialterm->term_id . '" class="btn" role="button"><span>' . ucfirst($testimonialterm->name) . '</span></a></li>';
			        endforeach;
		        echo '</ul>' .
		        '<select class="category-select-nav" aria-label="Select Testimonials Category">' .
			            '<option data-id="all" selected>' . __('View All', 'herostencilpt') . '</option>';
			        foreach ($testimonialterms as $testimonialterm) :
			            echo '<option data-id="' . $testimonialterm->term_id . '" value="' . $testimonialterm->slug . '">' . ucfirst($testimonialterm->name) . '</option>', "\n";
			        endforeach;
		        echo '</select>' .
	        '</div>';
	    }

    	/** Testimonial listing */
    	echo '<div class="testimonial-wrapper">' .
	        '<div class="testimonial-list">';
			    while ($testimonialquery->have_posts()) : $testimonialquery->the_post();

			        // Custom Meta
			        $testimonial_video_type = get_post_meta(get_the_ID(), '_testimonial_video_type', true);
			        $testimonial_youtube_video = get_post_meta(get_the_ID(), '_testimonial_youtube_video', true);
			        $testimonial_vimeo_video = get_post_meta(get_the_ID(), '_testimonial_vimeo_video', true);
			        $testimonial_upload_video = get_post_meta(get_the_ID(), '_testimonial_upload_video', true);
					$testimonial_title = get_post_meta(get_the_ID(), '_testimonial_title', true);


			        if ( $testimonial_video_type || get_the_content() ) {
			            echo '<div class="testimonial-item '.(($testimonial_youtube_video || $testimonial_vimeo_video || $testimonial_upload_video) ?'has-video' :'').'">' .
			                '<div class="testimonial-item-inner">';
					            if ($testimonial_video_type && ($testimonial_youtube_video || $testimonial_vimeo_video || $testimonial_upload_video)) {
					                echo '<div class="video-media">' .
					                    (
					                        ($testimonial_video_type == 'YouTube' && $testimonial_youtube_video)
					                        ? '<a data-fancybox href="https://www.youtube.com/watch?v=' . esc_attr($testimonial_youtube_video) . '" class="d-block">' .
					                        (
					                            has_post_thumbnail()
					                            ? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
					                           	: '<figure><img src="https://img.youtube.com/vi/' . esc_attr($testimonial_youtube_video) . '/0.jpg" alt="' . esc_attr(get_the_title()) . '"></figure>'
					                        ) .
					                        '</a>'
					                        : ''
					                    ) .
					                    (
					                        ($testimonial_video_type == 'Vimeo' && $testimonial_vimeo_video)
					                        ? '<a data-fancybox href="https://vimeo.com/' . esc_attr($testimonial_vimeo_video) . '" class="d-block">' .
					                        (
					                            has_post_thumbnail()
					                            ? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
					                            : placeholder_image(esc_attr(get_the_title()))
					                        ) .
					                        '</a>'
					                        : ''
					                    ) .
					                    (
					                        ($testimonial_video_type == 'Upload' && !empty($testimonial_upload_video))
					                        ? '<a data-fancybox href="' . esc_url(is_array($testimonial_upload_video) ? $testimonial_upload_video['url'] : $testimonial_upload_video) . '" class="d-block">' .
					                       	(
					                            has_post_thumbnail()
					                            ? '<figure>'. wp_get_attachment_image(get_post_thumbnail_id(), 'large') .'</figure>'
					                            : placeholder_image(esc_attr(get_the_title()))
					                        ) .
					                        '</a>'
					                        : ''
					                    ) .
					                    '<span class="icon-play"></span>' .
				                    '</div>' ;
					            }
					            echo '<div class="testimonial-item-quote">' .
										'<div class="quote-icon start">' . $iconquotestart . '</div>' .
										(
											$testimonial_title
											? '<h3>'. $testimonial_title . '</h3>' 
											:''
										).
						                apply_filters('the_content', get_the_content()) .
						                '<h4 class="h5">~ ' . get_the_title() . '</h4>' .
					                '</div>' .
					                '<div class="testimonial-media">' .
						                (
						                    has_post_thumbnail(get_the_ID())
					                        ? '<figure>' . wp_get_attachment_image(get_post_thumbnail_id(), 'medium') . '</figure>'
					                        : placeholder_image(esc_attr(get_the_title()))
						                ) .
					                '</div>' .
					            '</div>' .
					    '</div>';
			        }
			    endwhile; wp_reset_postdata();
	    	echo '</div>' .
        '</div>' .

    '</section>';
} else {
    echo '<h2>' . __('No Testimonial found...', 'herostencilpt') . '</h2>';
}

?>
