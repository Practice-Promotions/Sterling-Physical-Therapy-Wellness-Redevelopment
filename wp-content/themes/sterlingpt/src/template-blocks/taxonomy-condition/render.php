<?php

global $post;
$bodyterm   = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$taxonomy_content = get_option('taxonomy_content');

echo '<div class="condition-wrapper">'.
	'<div class="condition-body">'.
		human_body().
	'</div>'.

	/** Condition terms */
	'<div class="condition-list custom-bullet">'.
		'<h2 class="h3 '. $bodyterm->slug .'">'. apply_filters( 'the_title', $bodyterm->name ) .'</h2>'.
		'<p><strong>'. $taxonomy_content .'</strong></p>';
		if ( have_posts() ) :
			echo '<ul class="wp-block-list round-bullet">';
				while ( have_posts() ) : the_post();
					echo '<li>'.
						'<a data-fancybox data-touch="false" data-src="#'. $post->post_name .'" href="javascript:void(0)">'. get_the_title() .'</a>'.
						'<div id="'. $post->post_name .'" class="condition-content-popup" style="display: none;">'.
							'<div class="container">'. apply_filters( 'the_content', get_the_content() ) .'</div>'.
						'</div>'.
					'</li>';
				endwhile;
			echo '</ul>';
		endif;
	echo '</div>'.
'</div>';
?>
