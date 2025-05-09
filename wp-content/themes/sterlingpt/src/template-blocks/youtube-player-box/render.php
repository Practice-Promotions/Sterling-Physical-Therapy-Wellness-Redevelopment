<?php
global $PlayerIcon;
// Get the block attribute from the dynamic block render
$channelId = isset($attributes['VideoChannelID']) ? esc_attr($attributes['VideoChannelID']) : '';
$apiKey = 'AIzaSyA42Bggu-WC18WbgWAWgq9YEfq3AHitsGU';
$resultsNumber = '9';
$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber . '&order=date';
// echo $apiKey;
// Fetch data using cURL
$json_response = null;
if ( function_exists( 'curl_version' ) ) {
    $curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, $requestUrl );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, true );
    $response = curl_exec( $curl );
    curl_close( $curl );
    $json_response = json_decode( $response, true );
}
//echo $channelId;
// Display videos
if ( $json_response ) {
    $i = 1;
    echo '<div class="video-player">
        <div class="container">
            <div class="video-player-list">';
                foreach( $json_response['items'] as $item ) {
                    $videoTitle = $item['snippet']['title'];
                    $videoID = $item['id']['videoId'];

                    echo '<div class="video-list-item video-' . $i++ . '">'.
                        '<div class="video-media">'.
                            '<div class="video-media">'.
                                ( $videoID ? '<a data-fancybox href="https://www.youtube.com/watch?v=' . esc_attr($videoID) . '">'.
                                    '<picture>'.
                                        '<img src="https://img.youtube.com/vi/' . esc_attr($videoID) . '/0.jpg" alt="">'.
                                    '</picture>'.
                                    '<div class="player-play-icon">'. $PlayerIcon .'</div>'.
                                '</a>' : '').
                            '</div>'.
                        '</div>'.
                        '<div class="video-body"><h4 class="text-center">' . esc_html($videoTitle) . '</h4></div>'.
                    '</div>';
                }
            echo '</div>'.
        '</div>'.
    '</div>';

} else {
    echo '<div class="youtube-channel-videos error text-center"><p>No videos are available at this time from the channel specified!</p></div>';
}

?>
