<?php

global $PlayIcon;

$videoargs = array (
    'post_type'      => 'video',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'posts_per_page' => -1
);
$videoquery = new WP_Query( $videoargs );

if ( $videoquery->have_posts() ) {
    echo '<div class="video-listing">';
    while ( $videoquery->have_posts() ) : $videoquery->the_post();

        // Custom Meta
        $video_type = get_post_meta(get_the_ID(), '_video_type', true);
        $youtube_video = get_post_meta(get_the_ID(), '_youtube_video', true);
        $vimeo_video = get_post_meta(get_the_ID(), '_vimeo_video', true);
        $upload_video = get_post_meta(get_the_ID(), '_upload_video', true);


        if ( $video_type && ( $youtube_video || $vimeo_video || $upload_video ) ) {
            echo '<div class="video-item">'.
                '<div class="video-media">'.
                    (
                        ( $video_type == 'YouTube' && $youtube_video )
                        ? '<a data-fancybox href="https://www.youtube.com/watch?v='. esc_attr( $youtube_video ) .'" class="d-block">'.
                            (
                                has_post_thumbnail()
                                ? '<figure>'. wp_get_attachment_image( get_post_thumbnail_id(), 'large' ) .'</figure>'
                                : '<figure><img src="https://img.youtube.com/vi/'. esc_attr( $youtube_video ) .'/0.jpg" alt="'. esc_attr( get_the_title() ) .'"></figure>'
                            ).
                        '</a>'
                        : ''
                    ).
                    (
                        ( $video_type == 'Vimeo' && $vimeo_video )
                        ? '<a data-fancybox href="https://vimeo.com/'. esc_attr( $vimeo_video ) .'" class="d-block">'.
                            (
                                has_post_thumbnail()
                                ? '<figure>'. wp_get_attachment_image( get_post_thumbnail_id(), 'large' ) .'</figure>'
                                : placeholder_image( esc_attr( get_the_title() ) )
                            ).
                        '</a>'
                        : ''
                    ).
                    (
                        ( $video_type == 'Upload' && !empty( $upload_video ) )
                        ? '<a data-fancybox href="'. esc_url( is_array( $upload_video ) ? $upload_video['url'] : $upload_video ) .'" class="d-block">'.
                            (
                                has_post_thumbnail()
                                ? '<figure>'. wp_get_attachment_image( get_post_thumbnail_id(), 'large' ) .'</figure>'
                                : placeholder_image( esc_attr( get_the_title() ) )
                            ).
                        '</a>'
                        : ''
                    ).
                    '<span class="icon-play"></span>'.
                '</div>'.
                '<div class="video-body">'.
                    '<h2 class="h5">'. esc_html( get_the_title() ) .'</h2>'.
                '</div>'.
            '</div>';
        }
    endwhile; wp_reset_postdata();
    echo '</div>';
}
?>
