<?php

	$Productcategories = get_terms( 'product_category' );

    echo '<div class="alignwide">';
	    foreach ( $Productcategories as $Productcategory ) {
	        echo '<div class="product-section">'.

				//Category Name
				'<h2>' . esc_html( $Productcategory->name ) . '</h2>';

		        $Productposts = get_posts( array(
		            'post_type' => 'product',
					'posts_per_page' => -1,
		            'tax_query' => array(
		                array(
		                    'taxonomy' => 'product_category',
		                    'field' => 'term_id',
		                    'terms' => $Productcategory->term_id,
		                ),
		            ),
		        ));


		        if ( ! empty( $Productposts ) ) {
		            echo '<div class="product-list">';
			            foreach ( $Productposts as $Productpost ) {

							//Custom Meta
				   		 	$product_link = get_post_meta($Productpost->ID, '_product_link', true);

			                echo '<div class="product-item">'.
								(
									has_post_thumbnail($Productpost->ID)
									? '<div class="product-thumb">'.
										'<figure>'.
											get_the_post_thumbnail($Productpost->ID, 'full').
										'</figure>'.
									'</div>'
									:''
								).
								(
									get_the_title($Productpost->ID)
									? '<h3>'. esc_html( wp_trim_words( get_the_title( $Productpost->ID ), 8, '...' ) ) .'</h3>'
									: ''
								).
			                	'<div class="same-height">' . wp_kses_post( $Productpost->post_content ) . '</div>'.
								(
									$product_link
									? '<a href="'. esc_url($product_link) .'" target="_blank" class="btn primary" aria-label="Product Link">'.
									 	esc_html('View Product', 'herostencilpt') .
									'</a>'
									:''
								).
			                '</div>';
			            }
		            echo '</div>';
		        } else {
					echo '<p>'. __('No products found in this category.', 'herostencilpt') .'</p>';
		        }

	        echo '</div>';
	    }
    echo '</div>';

?>
