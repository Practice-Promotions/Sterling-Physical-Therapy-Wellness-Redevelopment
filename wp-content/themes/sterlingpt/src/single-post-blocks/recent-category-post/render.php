<?php
if (is_singular('post')) {
	$post_id = get_the_ID();

	$categories = get_the_category( $post_id );
	if ( empty( $categories ) ) {
		return '';
	}

	$category_ids = wp_list_pluck( $categories, 'term_id' );
	$query_args = [
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => [ $post_id ],
		'category__in'   => $category_ids,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	$recent_posts = new WP_Query( $query_args );

	if ( $recent_posts->have_posts() ) {
		echo '<div class="post-listing">';

		while ( $recent_posts->have_posts() ) {
			$recent_posts->the_post();
			?>
			<div class="post-item">
				<a href="<?php the_permalink(); ?>" class="post-item-media">
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
				</a>
				<div class="post-item-content">
					<span class="post-item-date"><?php echo get_the_date(); ?></span>
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<p><?php the_excerpt(); ?></p>
					<div class="post-item-category">
    <?php
    $post_categories = get_the_category(); // Get all categories of the current post
    if ( ! empty( $post_categories ) ) {
        // Loop through all categories and display them
        foreach ( $post_categories as $category ) {
            echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
            echo esc_html( $category->name );
            echo '</a>';

            // Optionally, add a separator between categories (e.g., a comma)
            echo ' ';
        }
    }
    ?>
</div>
					<div class="text-right"><a class="btn-link" href="<?php the_permalink(); ?>">Read More</a></div>
				</div>
			</div>
			<?php
		}

		echo '</div>';
	} else {
		echo '<h4>'. __( 'No posts found in the current categories.', 'herostencilpt' ) .'</h4>';
	}
	wp_reset_postdata();
} else {
	echo '<h4>'. __( 'This block is used exclusively on the Post Detail page or the Single Post Template. ', 'herostencilpt' ) .'</h4>';
 }
?>
