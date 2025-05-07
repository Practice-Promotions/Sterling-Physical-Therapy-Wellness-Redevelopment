<?php
//Global Variable
global $post, $RadiusIcon;

// Team Category
$locspecialtyterms = get_terms( 'location_specialty' );
?>

<div class="location-filter-part">
	<div class="pac-card" id="pac-card">
		<div id="pac-container">
		  	<input id="pac-input" type="text" placeholder="Enter Zipcode" />
		  	<?php echo $RadiusIcon; ?>
		</div>
	</div>
	<?php
	/** Team category filter */
	if ( $locspecialtyterms ) { ?>
		<select class="location-specialty-filter category-select-nav" aria-label="Select Location Specailty">
			<option data-id="all" selected><?php echo __( 'Filter by Specialities', 'herostencilpt' );?></option>
			<?php foreach ( $locspecialtyterms as $locspecialtyterm ) : ?>
				<option data-id="<?php echo esc_attr( $locspecialtyterm->term_id ); ?>" value="<?php echo esc_attr( $locspecialtyterm->slug ); ?>"><?php echo esc_html( $locspecialtyterm->name ) ;?></option>
			<?php endforeach; ?>
		</select>
	<?php } ?>
</div>

<div class="location-search">
	<div id="map"></div>
	<div class="location-search-wrap">
	  	<?php
			$args = array (
				'post_type' => 'location',
				'order' => 'ASC',
				'posts_per_page' => -1
			);
			$query = new WP_Query ($args);
			$post_count = $query->post_count;
			?>
			<?php if ($post_count) { ?>
				<div class="location-listing">
					<?php
						$i=1; while ($query->have_posts()): $query->the_post();

						//Var
						$location_map_link = get_post_meta(get_the_ID(), '_location_map_link', true);

						?>
						<div class="location-listing-item">
							<?php if (has_post_thumbnail($post->ID)) { ?>
								<figure class="location-media">
									<a href="<?php echo get_the_permalink($post->ID); ?>"><?php echo get_the_post_thumbnail($post->ID, 'large'); ?></a>
								</figure>
							<?php } ?>
					    	<div class="location-listing-info">
						    	<?php echo do_shortcode('[location-custom-title]'); ?>
						    	<?php echo do_shortcode('[location-address]'); ?>
						    	<div class="location-listing-wrap">
							 		<?php echo do_shortcode('[location-phone]'); ?>
						        	<?php echo do_shortcode('[location-fax]'); ?>
						    	</div>
							 	<?php echo do_shortcode('[location-email]'); ?>
								<div class="location-action">
				   					<a href="<?php echo get_the_permalink($post->ID); ?>" title="<?php echo esc_attr(get_the_title($post->ID)); ?>" class="btn primary" aria-label="Location Info">
				   						<?php echo esc_html('View Info', 'herostencilpt'); ?>
				   					</a>
				   					<?php if ($location_map_link): ?>
				   						<a href="<?php echo esc_url($location_map_link); ?>" target="_blank" class="btn outline" aria-label="Map Link">
				   							<?php echo esc_html('Direction', 'herostencilpt'); ?>
				   						</a>
				   					<?php endif; ?>
				   				</div>
						    </div>
						</div>
					<?php $i++; endwhile; wp_reset_postdata(); wp_reset_query(); ?>
				</div>
			<?php } else { ?>
				<?php echo "No Location Found"; ?>
			<?php } ?>
	</div>
</div>
<script type="text/javascript">

jQuery(document).ready(function(){

	function initMap() {
	  	const map = new google.maps.Map(document.getElementById("map"), {
			center: { lat: 33.5334251, lng: -112.5509009 },
			zoom: 11,
			// How you would like to style the map.
			// This is where you would paste any style found on Snazzy Maps.
			styles: [ {"featureType": "all", "elementType": "labels.text.fill", "stylers": [ {"saturation": 36 }, {"color": "#333333" }, {"lightness": 40 }] }, {"featureType": "all", "elementType": "labels.text.stroke", "stylers": [ {"visibility": "on" }, {"color": "#ffffff" }, {"lightness": 16 }] }, {"featureType": "all", "elementType": "labels.icon", "stylers": [ {"visibility": "off" }] }, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [ {"color": "#fefefe" }, {"lightness": 20 }] }, {"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ {"color": "#fefefe" }, {"lightness": 17 }, {"weight": 1.2 }] }, {"featureType": "administrative.locality", "elementType": "labels.icon", "stylers": [ {"color": "#bd081c" }] }, {"featureType": "landscape", "elementType": "geometry", "stylers": [ {"color": "#f5f5f5" }, {"lightness": 20 }] }, {"featureType": "poi", "elementType": "geometry", "stylers": [ {"color": "#f5f5f5" }, {"lightness": 21 }] }, {"featureType": "poi.park", "elementType": "geometry", "stylers": [ {"color": "#dedede" }, {"lightness": 21 }] }, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [ {"color": "#ffffff" }, {"lightness": 17 }] }, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ {"color": "#ffffff" }, {"lightness": 29 }, {"weight": 0.2 }] }, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [ {"color": "#ffffff" }, {"lightness": 18 }] }, {"featureType": "road.local", "elementType": "geometry", "stylers": [ {"color": "#ffffff" }, {"lightness": 16 }] }, {"featureType": "transit", "elementType": "geometry", "stylers": [ {"color": "#f2f2f2" }, {"lightness": 19 }] }, {"featureType": "water", "elementType": "geometry", "stylers": [ {"color": "#e9e9e9" }, {"lightness": 17 }] }]

	  	});
		const card = document.getElementById("pac-card");
		const input = document.getElementById("pac-input");
		//map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		const autocomplete = new google.maps.places.Autocomplete(input);
		// bounds option in the request.
		autocomplete.bindTo("bounds", map);
		// Set the data fields to return when the user selects a place.
		autocomplete.setFields(["address_components", "geometry", "icon", "name"]);
		const infowindow = new google.maps.InfoWindow();
		const infowindowContent = document.getElementById("infowindow-content");
		infowindow.setContent(infowindowContent);
		const marker = new google.maps.Marker({
		    map,
			anchorPoint: new google.maps.Point(0, -29),
		});
	 	autocomplete.addListener("place_changed", () => {
		    infowindow.close();
		    marker.setVisible(false);
		    const place = autocomplete.getPlace();


		    /*** Find nearest location list ***/
		    var place_changed_lat = place.geometry.location.lat(),
		    place_changed_lng = place.geometry.location.lng();

			var latitude = jQuery(this).attr('id');

		    data = {
		        'action': 'fetch_nearest_location',
		        'lat': place_changed_lat,
		        'lang': place_changed_lng,
		    };
			//alert(data);
		    jQuery.ajax({
		        url: "<?php echo admin_url('admin-ajax.php'); ?>",
		        data: data,
		        type: 'POST',
		        success: function(data) {
		           jQuery('.location-search-wrap').html('');
		           jQuery('.location-search-wrap').html(data);

				   //Location Search Page Scroll functions
   					LocationSearchScroll();

		        },
		        complete: function() {
		            //isProcessing = false;
		        }
		    });

		    /****** End *********/

		    if (!place.geometry) {
		      	// pressed the Enter key, or the Place Details request failed.
		      	window.alert("No details available for input: '" + place.name + "'");
		      	return;
		    }

		    // If the place has a geometry, then present it on a map.
		    if (place.geometry.viewport) {
		      	map.fitBounds(place.geometry.viewport);
		    } else {
		      	map.setCenter(place.geometry.location);
		      	map.setZoom(17); // Why 17? Because it looks good.
		    }
		    marker.setPosition(place.geometry.location);
		    marker.setVisible(true);
		    let address = "";

		    if (place.address_components) {
		      	address = [
		        	(place.address_components[0] &&
		          	place.address_components[0].short_name) ||
		          	"",
			        (place.address_components[1] &&
		          	place.address_components[1].short_name) ||
		          	"",
		        	(place.address_components[2] &&
		          	place.address_components[2].short_name) ||
		          	"",
		      	].join(" ");
		    }
		    infowindowContent.children["place-icon"].src = place.icon;
		    infowindowContent.children["place-name"].textContent = place.name;
		    infowindowContent.children["place-address"].textContent = address;
		    infowindow.open(map, marker);
	  	});

	    var infoWin = new google.maps.InfoWindow();

	    var markers = locations.map(function(location, i) {
	        var marker = new google.maps.Marker({
	            position: location,
	            icon:"<?php echo esc_url(get_theme_file_uri()); ?>/assets/images/map-pin.png",
	        });
	        google.maps.event.addListener(marker, 'click', function(evt) {
	            infoWin.setContent(location.info);
	            infoWin.open(map, marker);
	        })
	        return marker;
	    });

	    var markerCluster = new MarkerClusterer(map, markers, {
	        imagePath: '<?php echo get_theme_file_uri() ?>/assets/images/'
	    });

	}

	var locations = [
		<?php
		query_posts(array(
			'post_type' => 'location',
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC'
		));
		while (have_posts()): the_post();

		    // vars
		 	$locmaplink = get_post_meta(get_the_ID(), '_location_map_link', true);
			$loclatitude = get_post_meta(get_the_ID(), '_location_map_latitude', true);
			$loclongitude = get_post_meta(get_the_ID(), '_location_map_longitude', true);

		    if(!empty($loclatitude) && !empty($loclongitude) ){ ?>
		        {
		            lat: <?php echo $loclatitude; ?>,
		            lng: <?php echo $loclongitude; ?>,
		            info: '<a class="map-direction" target="_blank" href="<?php echo $locmaplink; ?>"><b><?php the_title(); ?></b></a>',
		        },

		<?php }
		endwhile; wp_reset_query(); ?>
	];

    google.maps.event.addDomListener(window, 'load', initMap);

});

</script>
