var $ = jQuery.noConflict();

$(() => {

	if ($('#other-details .meta-datepicker').length) {
		$('.meta-datepicker').datepicker({
		    dateFormat: 'yy-mm-dd'
		});
	}

	if ($('.job-hiring-form-showhide').length) {
		const $shortcodeField = $("#shortcode_field");
		const $thirdpartyField = $("#thirdparty_link_field");
		const $radioButtons = $('input[name="job_hiring_type"]');

		$radioButtons.on("change", function() {
			if ($('input[name="job_hiring_type"]:checked').val() === "shortcode") {
				$shortcodeField.show();
				$thirdpartyField.hide();
			} else {
				$shortcodeField.hide();
				$thirdpartyField.show();
			}
		});

		// Initialize on page load
		if ($('input[name="job_hiring_type"]:checked').val() === "shortcode") {
			$shortcodeField.show();
			$thirdpartyField.hide();
		} else {
			$shortcodeField.hide();
			$thirdpartyField.show();
		}
	}

	/** Meta Field Tab Click event */
	$('.nav-tab').click(function() {
 	   var tab = $(this).data('tab');
 	   $('.nav-tab').removeClass('nav-tab-active');
 	   $(this).addClass('nav-tab-active');
 	   $('.tab-content').hide();
 	   $('#' + tab).show();
 	   return false;
    });

	/* Option: Header - Call Button Repeater Click event */
	$('#call-repeater-item').on('click', function(e) {
	   e.preventDefault();
	   var index = $('#call-cta-list .repeater-item').length;
	   $('#call-cta-list').append(
		   '<div class="repeater-item data">' +
			   '<div class="half">' +
				   '<input type="text" name="call_cta_list[' + index + '][call_cta_name]" />' +
			   '</div>' +
			   '<div class="half">' +
				   '<input type="text" name="call_cta_list[' + index + '][call_cta_tel_num]" />' +
			   '</div>' +
			   '<a href="#" class="remove-repeater-item action-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"></path></svg></a>' +
		   '</div>'
	   );
   	});

	/* Option: Header - Review Button Repeater Click event */
   	$('#review-repeater-item').on('click', function(e) {
	   e.preventDefault();
	   var index = $('#review-cta-list .repeater-item').length;
	   $('#review-cta-list').append(
		   '<div class="repeater-item data">' +
			   '<div class="half">' +
				   '<input type="text" name="review_cta_list[' + index + '][review_cta_name]" />' +
			   '</div>' +
			   '<div class="half">' +
				   '<input type="text" name="review_cta_list[' + index + '][review_cta_link]" />' +
			   '</div>' +
			   '<a href="#" class="remove-repeater-item action-icon"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"></path></svg></a>' +
		   '</div>'
	   );
   	});



	/** Post: Team*/
	$('#add-repeater-item').click(function() {
		var index = $('#skills-info .repeater-item').length;
		$('#skills-info').append(
			'<div class="repeater-item">' +
			'<div class="half">' +
			'<input type="text" name="skills_info_repeater[' + index + '][skills_name]" />' +
			'</div>' +
			'<div class="half">' +
			'<input type="text" name="skills_info_repeater[' + index + '][skills]" />' +
			'</div>' +
			'<a href="#" class="remove-repeater-item">Remove</a>' +
			'</div>'
		);
		return false;
	});

	/** Globally: Remove repeater item click event  */
	$(document).on('click', '.remove-repeater-item', function() {
		$(this).parent('.repeater-item').remove();
		return false;
	});

	/** Open Date Picker on click event */
    // $('.meta-datepicker').datepicker({
 	//    dateFormat: 'yy-mm-dd',
 	//    defaultDate: new Date(),
    // });



    var mediaUploader;

    /** function for opening the media uploader */
    function openMediaUploader(buttonID, inputFieldID, imageElementID) {
        $(buttonID).click(function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            mediaUploader = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });

            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $(inputFieldID).val(attachment.url);
                $(imageElementID).attr('src', attachment.url);
            });

            mediaUploader.open();
        });
    }

	/** function for remove image */
	function removeImage(removeButtonID, inputFieldID, imageElementID) {
        $(removeButtonID).click(function(e) {
            e.preventDefault();

            $(inputFieldID).val('');
            $(imageElementID).attr('src', '');
        });
    }
    /** Here to Add Media Uploader & Remove ID */
    openMediaUploader('#upload_host_image_button', '#workshop_host_image', '#workshop_host_image_preview');
	removeImage('#remove_host_image_button', '#workshop_host_image', '#workshop_host_image_preview');
    openMediaUploader('#upload_logo_button', '#job_hiring_organization_logo', '#job_hiring_organization_logo_preview');
	removeImage('#remove_logo_button', '#job_hiring_organization_logo', '#job_hiring_organization_logo_preview');
    // openMediaUploader('#upload_video_button', '#upload_video', '#upload_video_preview');
	// removeImage('#remove_video_button', '#upload_video', '#upload_video_preview');


	// Media uploader for video upload
	var videoFrame, testimonialVideoFrame;

	// Event handler for main video upload
	$('#upload_video_button').on('click', function(e) {
	    e.preventDefault();

	    // If the media frame already exists, reopen it.
	    if (videoFrame) {
	        videoFrame.open();
	        return;
	    }

	    // Create the media frame.
	    videoFrame = wp.media.frames.videoFrame = wp.media({
	        title: 'Select or Upload Video',
	        button: {
	            text: 'Use this video',
	        },
	        multiple: false
	    });

	    // When a video is selected, run a callback.
	    videoFrame.on('select', function() {
	        var attachment = videoFrame.state().get('selection').first().toJSON();
	        $('#upload_video').val(attachment.url);
	        $('#upload_video_preview').attr('src', attachment.url).show();

			// Get additional file data (title, name, size)
	        $('span[data-name="title"]').text(attachment.title);
	        $('a[data-name="filename"]').text(attachment.filename).attr('href', attachment.url);
	        $('span[data-name="filesize"]').text(attachment.filesizeHumanReadable || 'N/A');

	        // Show the video preview section
	        $('#upload_video_preview').show();
	    });

	    // Finally, open the modal
	    videoFrame.open();
	});

	// Remove video handler
	$('#remove_video_button').on('click', function(e) {
	    e.preventDefault();
	    $('#upload_video').val('');
	    $('#upload_video_preview').attr('src', '').hide();
	    $('span[data-name="title"]').text('');
	    $('a[data-name="filename"]').text('').attr('href', '#');
	    $('span[data-name="filesize"]').text('');
	});


	// Event handler for testimonial video upload
	$('#upload_testimonial_video_button').on('click', function(e) {
	    e.preventDefault();

	    // If the media frame already exists, reopen it.
	    if (testimonialVideoFrame) {
	        testimonialVideoFrame.open();
	        return;
	    }

	    // Create the media frame.
	    testimonialVideoFrame = wp.media.frames.testimonialVideoFrame = wp.media({
	        title: 'Select or Upload Testimonial Video',
	        button: {
	            text: 'Use this video',
	        },
	        multiple: false
	    });

	    // When a video is selected, run a callback.
	    testimonialVideoFrame.on('select', function() {
	        var attachment = testimonialVideoFrame.state().get('selection').first().toJSON();

	        // Set the video URL in the hidden field
	        $('#testimonial_upload_video').val(attachment.url);

	        // Get additional file data (title, name, size)
	        $('span[data-name="title"]').text(attachment.title);
	        $('a[data-name="filename"]').text(attachment.filename).attr('href', attachment.url);
	        $('span[data-name="filesize"]').text(attachment.filesizeHumanReadable || 'N/A');

	        // Show the video preview section
	        $('#upload_testimonial_video_preview').show();
	    });

	    // Finally, open the modal
	    testimonialVideoFrame.open();
	});

	// Remove video handler
	$('#remove_testimonial_video_button').on('click', function(e) {
	    e.preventDefault();
	    $('#testimonial_upload_video').val('');
	    $('#upload_testimonial_video_preview').hide();
	    $('span[data-name="title"]').text('');
	    $('a[data-name="filename"]').text('').attr('href', '#');
	    $('span[data-name="filesize"]').text('');
	});



    // Function to toggle visibility of video fields
	var videoTypeSelector = $('#video_type, #testimonial_video_type');

	function toggleVideoFields() {

        var videoType = videoTypeSelector.val();

        // Hide all video fields
        $('.youtube-video-field, .vimeo-video-field, .upload-video-field').hide();

        // Show the correct field based on video type
        if (videoType === 'YouTube') {
            $('.youtube-video-field').show();
        } else if (videoType === 'Vimeo') {
            $('.vimeo-video-field').show();
        } else if (videoType === 'Upload') {
            $('.upload-video-field').show();
        }
    }

    toggleVideoFields();

    // Change event on the dropdown
    videoTypeSelector.on('change', function() {
        toggleVideoFields();
    });


	// Trigger AJAX on dropdown value change in the Theme Guidlines Block search Purpose used
	$("select[name='sterlingpt_block_patterns']").change(function() {
		var selectedPattern = $(this).val();

		// Show loading spinner
		$("#pattern-search-results").html("<div class='spinner is-active' style='float:left'></div>"); // Display WordPress default loader

		// Send AJAX request
		$.ajax({
			url: ajax_object.ajax_url, // Enclose PHP output in quotes
			type: "POST",
			data: {
				action: "search_patterns",
				patterns_name: selectedPattern,
				//nonce: ajax_object.nonce // Uncomment if you\'re using nonce
			},
			success: function(response) {
				if (response.success) {
					var results = response.data;
					var output = "";

					// Display the total count of results
					output += "<h2>Total Results: " + results.totalcount + "</h2>"; // Show total count

					// Loop through each post type
					$.each(results, function(postType, pages) {
						// Skip the \'totalcount\' key
						if (!Array.isArray(pages)) {
	                        return true; // Continue to the next iteration
	                    }

						if (postType === "Wp_template" && pages.length > 0) {
							output += "<ul>"; // Start unordered list for each post type
							output += "<h3>" + postType + " : (" + pages.length + ") </h3>"; // Add post type heading

							// Loop through each page under the post type
							$.each(pages, function(index, page) {
								var fullUrl = page.guid;
								var link = document.createElement("a");
								link.href = fullUrl;
								var newguid = link.pathname.endsWith("/") ? link.pathname : link.pathname + "/";
								newguid = newguid.replace(/^\/+|\/+$/g, ''); // Remove slashes from start and end

								output += "<li><a href=\'/wp-admin/site-editor.php?postId=" + results.themeslug + "//" + newguid + "&postType=" + postType.toLowerCase() + "&canvas=edit\' target=\'_blank\'>" + page.post_title + "</a></li>"; // Add list item
							});
							output += "</ul>"; // Close unordered list

						}

						if (postType !== "totalcount" && postType !== "Wp_template") {
							output += "<ul>"; // Start unordered list for each post type
							output += "<h3>" + postType + " : (" + pages.length + ") </h3>"; // Add post type heading

							// Loop through each page under the post type
							$.each(pages, function(index, page) {
								output += "<li><a href=\'/wp-admin/post.php?post=" + page.ID + "&action=edit\' target=\'_blank\'>" + page.post_title + "</a></li>"; // Add list item
							});
							output += "</ul>"; // Close unordered list
						}
					});

					$("#pattern-search-results").html(output); // Insert the constructed HTML
				} else {
					// Display error message
					$("#pattern-search-results").html("<p>" + response.data + "</p>");
				}
			}
		});
	});

	// Trigger AJAX on dropdown value change in the Theme Guidlines Block search Purpose used
	$("select[name='sterlingpt_blocks']").change(function() {
		var selectedBlock = $(this).val();

		$('#block-search-results').html('<div class="spinner is-active" style="float:left"></div>'); // Display WordPress default loader
		$.ajax({
			url: ajax_object.ajax_url,
			type: "POST",
			data: {
				action: "search_block_pages",
				block_name: selectedBlock,
			},
			success: function (response) {
            if (response.success) {
                var results = response.data;
                var output = '';

                output += '<h2>Total Results: ' + results.totalcount + '</h2>';
                $.each(results, function (postType, pages) {
                    // Skip invalid keys or non-array values
                    if (!Array.isArray(pages)) {
                        return true; // Continue to the next iteration
                    }

                    if (postType === "Wp_template") {
                        output += '<ul>';
                        output += '<h3>' + postType + ' : (' + pages.length + ')</h3>';
                        $.each(pages, function (index, page) {
                            var fullUrl = page.guid;
                            var link = document.createElement("a");
                            link.href = fullUrl;
                            var newguid = link.pathname.endsWith("/") ? link.pathname : link.pathname + "/";
                            newguid = newguid.replace(/^\/+|\/+$/g, ''); // Remove slashes from start and end
                            output += '<li><a href="/wp-admin/site-editor.php?postId=' + results.themeslug + '//' + newguid + '&postType=' + postType.toLowerCase() + '&canvas=edit" target="_blank">' + page.post_title + '</a></li>';
                        });
                        output += '</ul>';
                    } else {
                        output += '<ul>';
                        output += '<h3>' + postType + ' : (' + pages.length + ')</h3>';
                        $.each(pages, function (index, page) {
                            output += '<li><a href="/wp-admin/post.php?post=' + page.ID + '&action=edit" target="_blank">' + page.post_title + '</a></li>';
                        });
                        output += '</ul>';
                    }
                });

                $("#block-search-results").html(output);
            } else {
                $("#block-search-results").html('<p>' + response.data + '</p>');
            }
        }
		});
	});

});
