var $ = jQuery.noConflict();

/** Define global SVG variables */
const prevArrowSVG = '<button class="slick-prev slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="14.982" height="15.81" viewBox="0 0 14.982 15.81"><path d="M16.315,9.824H3.333M9.824,3.333,3.333,9.824l6.491,6.491" transform="translate(-2.333 -1.919)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></button>';
const nextArrowSVG = '<button class="slick-next slick-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="14.982" height="15.81" viewBox="0 0 14.982 15.81"><path id="Icon_feather-arrow-right" data-name="Icon feather-arrow-right" d="M3.333,9.824H16.315M9.824,3.333l6.491,6.491L9.824,16.315" transform="translate(-2.333 -1.919)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg></button>';


/********** Script on ready **********/
$(() => {
	const headerHeight = $('header.wp-block-template-part').outerHeight();

	/** Address bar close */
	$(document).on('click', '.notification-close', function () {
		var cookieName = 'notificationbarcookie';
		var cookieValue = $('#notification-bar').attr('data-name');
		$.cookie(cookieName, cookieValue, {
			expires: 1,
			path: '/'
		});
		$('.notification-bar').addClass('slide-upp').slideUp();
	});

	$('.hero-banner-section .hero-banner-list').slick({
		rows: 0,
		dots: true,
		arrows: false,
		prevArrow: prevArrowSVG,
		nextArrow: nextArrowSVG
	});

	$('.gallery-with-slider').slick({
		rows: 0,
		dots: true,
		arrows: false,
		prevArrow: prevArrowSVG,
		nextArrow: nextArrowSVG
	});

	$('.testimonial-block .testimonial-block-listing').slick({
		rows: 0,
		dots: false,
		arrows: true,
		prevArrow: prevArrowSVG,
		nextArrow: nextArrowSVG,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 1
				}
			},
		]
	});

	// if ($('.about-section .about-listing .cta-item').length > 3) {
	// 	$('.about-section .about-listing').slick({
	// 		rows: 0,
	// 		dots: false,
	// 		arrows: true,
	// 		slidesToShow: 3,
	// 		slidesToScroll: 1,
	// 		prevArrow: prevArrowSVG,
	// 		nextArrow: nextArrowSVG,
	// 		responsive: [
	// 			{
	// 				breakpoint: 767,
	// 				settings: {
	// 					slidesToShow: 1,
	// 					fade: true,
	// 					cssEase: 'linear',
	// 				}
	// 			}
	// 		]
	// 	});
	// }
	
	


	$('.team-section .team-slider-part .team-slider-listing').slick({
		rows: 0,
		dots: false,
		arrows: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		prevArrow: prevArrowSVG,
		nextArrow: nextArrowSVG,
		responsive: [
			{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
					fade: true,
					cssEase: 'linear',
				}
			},
		]
	});


	$('.services-section .services-part-slider').slick({
		rows: 0,
		dots: false,
		arrows: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		prevArrow: prevArrowSVG,
		nextArrow: nextArrowSVG,
		fade: true,
		cssEase: 'linear',
	});


	if ($('.insurance-partner .insurance-partner-gallery .wp-block-column').length > 5) {
		$('.insurance-partner .insurance-partner-gallery').slick({
			rows: 0,
			dots: false,
			arrows: true,
			slidesToShow: 4,
			slidesToScroll: 1,
			prevArrow: prevArrowSVG,
			nextArrow: nextArrowSVG,
			responsive: [{
				breakpoint: 1199,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1
				}
			}
			]
		});
	}

	/** matchHeight: As per design */
	$('.cta-icon-column').matchHeight();
	$('.three-column > div > .cta-icon-title').matchHeight();
	$('.cta-icon-title').matchHeight();
	$('.same-height').matchHeight();
	$('.location-listing-info').matchHeight();
	$('.query-blog-content').matchHeight();


	/** Custom Gallery With fancybox popup */
	$('.gallery-with-popup .wp-block-image a').attr('data-fancybox', 'gallery');

	/** Custom Services fancybox popup */
	$(".wp-block-ppcoreblocks-cta-popup-link-block .cta-link-popup").fancybox({
		loop: false,
		arrows: false
	}),

		/** eBook fancybox popup */
		$('.ebook-link a').fancybox({
			loop: false,
			arrows: false
		});

	/** Globally Disable #group from URLs fancybox. */
	$.fancybox.defaults.hash = false;
	$.fancybox.defaults.hideScrollbar = false;
	$.fancybox.defaults.arrows = true;

	/** FAQ category filter for desktop */
	$('.accordion-cat-filter .link').on('click', function () {
		$('.accordion-list').append('<div class="ajax-loader"></div>');
		$('.accordion-cat-filter .link').removeClass('active');
		$(this).addClass('active');
		data = {
			'action': 'faq_category_filter',
			'dataid': $(this).attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.accordion-list').html('');
				$('.accordion-list').append(data);
			},
			complete: function () {
				accordion();
			}
		});
	});

	/** FAQ category filter for mobile */
	$('.accordion-cat-filter .category-select-nav').change(function () {
		$('.accordion-list').append('<div class="ajax-loader"></div>');
		data = {
			'action': 'faq_category_filter',
			'dataid': $(this).find('option:selected').attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.accordion-list').html('');
				$('.accordion-list').append(data);
			},
			complete: function () {
				accordion();
			}
		});
	});

	/** Team category filter for desktop */
	$('.team-cat-filter .btn').on('click', function () {
		$('.team-wrapper').append('<div class="ajax-loader"></div>');
		$('.team-cat-filter .btn').removeClass('active');
		$(this).addClass('active');
		data = {
			'action': 'team_category_filter',
			'dataid': $(this).attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.team-wrapper').html('');
				$('.team-wrapper').append(data);
			}
		});
	});

	/** Team category filter for mobile */
	$('.team-cat-filter .category-select-nav').change(function () {
		$('.team-wrapper').append('<div class="ajax-loader"></div>');
		data = {
			'action': 'team_category_filter',
			'dataid': $(this).find('option:selected').attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.team-wrapper').html('');
				$('.team-wrapper').append(data);
			}
		});
	});

	/** Team location filter for desktop */
	$('.team-loc-filter .btn').on('click', function () {
		$('.team-wrapper').append('<div class="ajax-loader"></div>');
		$('.team-loc-filter .btn').removeClass('active');
		$(this).addClass('active');
		data = {
			'action': 'team_location_filter',
			'dataid': $(this).attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.team-wrapper').html('');
				$('.team-wrapper').append(data);
			}
		});
	});

	/** Team location filter for mobile */
	$('.team-loc-filter .category-select-nav').change(function () {
		$('.team-wrapper').append('<div class="ajax-loader"></div>');
		data = {
			'action': 'team_location_filter',
			'dataid': $(this).find('option:selected').attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.team-wrapper').html('');
				$('.team-wrapper').append(data);
			}
		});
	});

	/** Testimonial page masonry */
	if ($('.testimonial-wrapper .testimonial-list').length) {
		$('.testimonial-wrapper .testimonial-list').masonry({
			itemSelector: '.testimonial-item',
			horizontalOrder: true
		});
	}

	/** Testimonial category filter for desktop */
	$('.testimonial-cat-filter .btn').on('click', function () {
		$('.testimonial-wrapper').append('<div class="ajax-loader"></div>');
		$('.testimonial-cat-filter .btn').removeClass('active');
		$(this).addClass('active');
		data = {
			'action': 'testimonial_category_filter',
			'dataid': $(this).attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.testimonial-wrapper').html('');
				$('.testimonial-wrapper').append(data);
			},
			complete: function () {
				$('.testimonial-list').masonry({
					itemSelector: '.testimonial-item',
					horizontalOrder: true
				});
			}
		});
	});

	/** Testimonial category filter for mobile */
	$('.testimonial-cat-filter .category-select-nav').change(function () {
		$('.testimonial-wrapper').append('<div class="ajax-loader"></div>');
		data = {
			'action': 'testimonial_category_filter',
			'dataid': $(this).find('option:selected').attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.testimonial-wrapper').html('');
				$('.testimonial-wrapper').append(data);
			},
			complete: function () {
				$('.testimonial-list').masonry({
					itemSelector: '.testimonial-item',
					horizontalOrder: true
				});
			}
		});
	});

	/** Location Search Page category filter */
	$('.location-specialty-filter').change(function () {
		$('.location-search-wrap').append('<div class="ajax-loader"></div>');
		data = {
			'action': 'location_search_category_filter',
			'dataid': $(this).find('option:selected').attr('data-id')
		};
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
			data: data,
			type: 'POST',
			success: function (data) {
				$('.location-search-wrap').html('');
				$('.location-search-wrap').append(data);

				//Location Search Page Scroll functions
				LocationSearchScroll();
			}
		});
	});

	/** Popup primary scripts */
	var popupCookiePrimaryName = 'popupcookieprimary';
	var popupCookiePrimaryOldValue = $.cookie('popupcookieprimary');
	var popupCookiePrimaryNewValue = $('#theme-popup-primary').attr('data-name');
	if (($('#theme-popup-primary').length > 0) && (popupCookiePrimaryOldValue != popupCookiePrimaryNewValue)) {
		$('[data-fancybox="theme-popup-primary"]').fancybox({
			mobile: {
				clickSlide: !1,
				touch: !1
			},
			afterShow: function () {
				$(document).on('click', '#theme-popup-primary .icon-close', function () {
					$('.theme-popup-primary-alert').addClass('active');
				});
				$(document).on('click', '.cookiebutton-primary', function () {
					$.cookie(popupCookiePrimaryName, popupCookiePrimaryNewValue, {
						expires: 1,
						path: '/'
					});
				});
				$(document).on('click', '.theme-popup-primary-alert .btn', function () {
					$('.theme-popup-primary-alert').removeClass('active');
					$('.theme-popup-primary .fancybox-close-small').trigger('click');
				});
			},
		})
	}

	/** Ebook theme popup */
	if ($('#ebook-theme-popup').length) {
		var popupCounter = 0;
		$(document).mouseleave(function () {
			if (popupCounter < 1) {
				$(".ebook-theme-popup-btn .btn").trigger('click');
			}
			popupCounter++;
		});
	}

	/** Gravity Form: disable Pastdate, future date */
	jQuery(document).on('gform_post_render', function (event) {
		// Check if the form has past date restriction
		if (jQuery('.disable-gravity-pastdate').length > 0) {
			gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) {
				// Example for form ID 32 and field ID 11
				if (formId == 32 && fieldId == 11) {
					optionsObj.minDate = '0'; // Disable past dates
				}
				jQuery(".datepicker").attr('readonly', 'readonly'); // Make datepicker readonly
				return optionsObj;
			});
		}

		// Check if the form has future date restriction
		if (jQuery('.disable-gravity-futuredate').length > 0) {
			gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) {
				// Example for form ID 32 and field ID 16
				if (formId == 32 && fieldId == 16) {
					optionsObj.maxDate = '0'; // Disable future dates
				}
				jQuery(".datepicker").attr('readonly', 'readonly'); // Make datepicker readonly
				return optionsObj;
			});
		}

		// Check if the form has past and future(3month) date restriction
		if (jQuery('.disable-gravity-aptm-pastfuture-date').length > 0) {
			gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) {
				// Example for form ID 27 and field ID 5
				if (formId == 27 && fieldId == 5) {
					optionsObj.minDate = '0'; // Disable past dates
					optionsObj.maxDate = '+3 M'; // Allow up to 3 months in the future
				}
				jQuery(".datepicker").attr('readonly', 'readonly'); // Make datepicker readonly
				return optionsObj;
			});
		}
	});

	/* Smooth scroll-to-section scripts. */
	$('.scroll-buttons a, .goto-link').on('click', function (event) {
		event.preventDefault();
		const targetId = $(this).attr('href').substring(1);
		const $targetSection = $('#' + targetId);
		if ($targetSection.length) {
			const targetPosition = $targetSection.offset().top - headerHeight;
			$('html, body').animate(
				{
					scrollTop: targetPosition,
				}, 600
			);
		}
	});

	// Call accordion function
	accordion();

	// Desktop - Third Level Menu Click event
	DesktopMenuThirdLevel();

	// Location Search Page Scroll functions
	setTimeout(function () {
		LocationSearchScroll();
	}, 1000);

	$(window).resize(function () {
		// Desktop - Third Level Menu Click event
		DesktopMenuThirdLevel();

		// Location Search Page Scroll functions
		LocationSearchScroll();
	});

	$(window).on('load', function () {
		// Desktop - Third Level Menu Click event
		DesktopMenuThirdLevel();

		// Location Search Page Scroll functions
		LocationSearchScroll();
	});


	$('#commentform').on('submit', function (e) {
		e.preventDefault();

		var form = $(this);
		var formData = form.serialize();

		$.ajax({
			type: 'POST',
			url: frontend_ajax_object.ajax_url,
			data: formData + '&action=post_submit_comment&nonce=' + frontend_ajax_object.nonce,
			success: function (response) {
				if (response.success) {
					$('.comment-list').append(response.data.comment);
					$('#commentform')[0].reset(); // Reset form on success
				} else {
					$('.comment-error').remove(); // Remove previous errors
					form.prepend('<div class="comment-error">' + response.data + '</div>');
				}
			}
		});
	});

    if (navigator.platform.toUpperCase().indexOf('MAC') >= 0) {
        $('html').addClass('is-mac');
    } else if (navigator.platform.toUpperCase().indexOf('WIN') >= 0) {
        $('html').addClass('is-win');
    }

    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('html').addClass('is-firefox');
    }

});

/********** Script on load **********/
window.onload = () => {

	document.querySelectorAll('.mySwiper').forEach((el) => {
		// Pull config values from data-* attributes
		const slidesToShow = parseInt(el.dataset.slidesToShow || 1);
		const slidesToScroll = parseInt(el.dataset.slidesToScroll || 1);
		const loop = el.dataset.loop === 'true';
		const autoplay = el.dataset.autoplay === 'true';

		// Init Swiper
		new Swiper(el, {
			loop: loop,
			autoplay: autoplay
				? {
					delay: 3000,
					disableOnInteraction: false,
				}
				: false,
			slidesPerView: slidesToShow,
			slidesPerGroup: slidesToScroll,
			pagination: {
				el: el.querySelector('.swiper-pagination'),
				clickable: true,
			},
			navigation: {
				nextEl: el.querySelector('.swiper-button-next'),
				prevEl: el.querySelector('.swiper-button-prev'),
			},
			spaceBetween: 0,
		});
	});


	// document.querySelectorAll('.mySwiper').forEach(function (el) {
	// 	const autoplayEnabled = el.classList.contains('autoplay-on');
	// 	const block = el.closest('[data-type="custom/slider-grid"]');
	// 	const attrs = block?.dataset || {};
	// 	new Swiper(el, {
	// 		loop: attrs.loop === 'true',
	// 		autoplay: autoplayEnabled ? {
	// 			delay: 3000,
	// 			disableOnInteraction: false,
	// 		} : false,
	// 		pagination: {
	// 			el: el.querySelector(".swiper-pagination"),
	// 			clickable: true,
	// 		},
	// 		navigation: {
	// 			nextEl: el.querySelector(".swiper-button-next"),
	// 			prevEl: el.querySelector(".swiper-button-prev"),
	// 		},
	// 		slidesPerView: 1,
	// 		spaceBetween: 0,
	// 	});
	// });

	// 	const sliders = document.querySelectorAll('.custom-slider.swiper');
	// 
	// 	sliders.forEach((element) => {
	// 		// ✋ Skip if Swiper already initialized
	// 		if (element.swiper) return;
	// 
	// 		// ✅ Make sure element is actually a DOM element
	// 		if (!(element instanceof Element)) return;
	// 
	// 		// ✅ Parse classList safely
	// 		const classList = [...element.classList];
	// 		const slidesShowClass = classList.find(cls => cls.startsWith('slides-show-'));
	// 		const slidesScrollClass = classList.find(cls => cls.startsWith('slides-scroll-'));
	// 
	// 		const slidesToShow = slidesShowClass ? parseInt(slidesShowClass.replace('slides-show-', ''), 10) : 1;
	// 		const slidesToScroll = slidesScrollClass ? parseInt(slidesScrollClass.replace('slides-scroll-', ''), 10) : slidesToShow;
	// 
	// 		try {
	// 			new Swiper(element, {
	// 				loop: true,
	// 				slidesPerView: slidesToShow,
	// 				slidesPerGroup: slidesToScroll,
	// 				spaceBetween: 20,
	// 				navigation: {
	// 					nextEl: element.querySelector(".swiper-button-next"),
	// 					prevEl: element.querySelector(".swiper-button-prev"),
	// 				},
	// 				pagination: {
	// 					el: element.querySelector(".swiper-pagination"),
	// 					clickable: true,
	// 				},
	// 			});
	// 		} catch (error) {
	// 			console.error('Swiper failed to init:', error);
	// 		}
	// 	});


	/** Theme popup primary & secondary onload*/
	var popupCookiePrimaryOldVal = $.cookie('popupcookieprimary');
	var popupCookiePrimaryNewVal = $('#theme-popup-primary').attr('data-name');
	if (($('#theme-popup-primary').length > 0) && (popupCookiePrimaryOldVal != popupCookiePrimaryNewVal)) {
		$(".theme-popup-primary-btn .btn").trigger('click');
	}
};

/********** Script on scroll **********/
window.onscroll = () => {
	/* Do jQuery stuff on Scroll */
};

/********** Script on resize **********/
window.onresize = () => {
	/* Do jQuery stuff on resize */
};

/********** Script all functions **********/
/** Location Search Page Scroll funtion */
function LocationSearchScroll() {
	$(".location-search .location-listing").mCustomScrollbar({
		axis: "y",
		scrollInertia: 800,
		advanced: {
			updateOnContentResize: true
		}
	});
}

/** Desktop - Third Level Menu Click event */
function DesktopMenuThirdLevel() {
	if ($(window).width() > 992) {
		$('header nav ul.wp-block-navigation > .wp-block-navigation-item > ul.wp-block-navigation-submenu').find('ul.wp-block-navigation-submenu').parent().addClass('dropdown-submenu');
		$('.dropdown-submenu > button').off('click').on('click', function (e) {
			e.preventDefault();
			$(this).parents('.dropdown-submenu').find('ul.wp-block-navigation-submenu').stop().slideToggle();
			$(this).parent().toggleClass('dropdown-active');
		});
	}
}

/** Match height function */
function sameHeight(elem, heightType) {
	var mhelem = $(elem);
	var maxHeight = 0;
	if (heightType == undefined) {
		heightType = 'min-height';
	} else {
		heightType = 'height';
	}
	mhelem.css(heightType, 'auto');
	mhelem.each(function () {
		if ($(this).height() > maxHeight) {
			maxHeight = $(this).height();
		}
	});
	mhelem.css(heightType, maxHeight);
}

/** Accordion function */
function accordion() {
	$('.accordion-title').on('click', function () {
		var $accordionItem = $(this).closest('.accordion-item');
		var $content = $accordionItem.find('.accordion-content');
		if ($accordionItem.hasClass('active')) {
			$content.slideUp(300);
			$accordionItem.removeClass('active');
			$(this).attr('aria-expanded', 'false');
		} else {
			$('.accordion-item.active .accordion-content').slideUp(300);
			$('.accordion-item.active').removeClass('active');
			$('.accordion-title').attr('aria-expanded', 'false');

			$content.slideDown(300);
			$accordionItem.addClass('active');
			$(this).attr('aria-expanded', 'true');
		}
	});
}


function initResponsiveSlider() {
	const $slider = $('.about-section .about-listing');
	const slideCount = $slider.find('.cta-item').length;

	let currentMode = null; // Track current mode to prevent unnecessary reinitialization

	function getMode() {
		const width = $(window).width();
		if (width < 768) return 'mobile';
		if (width < 993) return 'tablet';
		return 'desktop';
	}

	function activateSlider(slidesToShow) {
		$slider.slick({
			rows: 0,
			dots: false,
			arrows: true,
			slidesToShow: slidesToShow,
			slidesToScroll: 1,
			prevArrow: whitePrevArrow,
			nextArrow: whiteNextArrow,
			fade: slidesToShow === 1, // Apply fade only for mobile
			cssEase: 'linear'
		});
	}

	function handleSlider() {
		const mode = getMode();

		if (mode === currentMode) return; // Skip if nothing changed
		currentMode = mode;

		// Destroy if already initialized
		if ($slider.hasClass('slick-initialized')) {
			$slider.slick('unslick');
		}

		// Decide slider settings based on mode
		if (mode === 'desktop') {
			if (slideCount > 3) activateSlider(3);
		} else if (mode === 'tablet') {
			activateSlider(2);
		} else {
			activateSlider(1);
		}
	}

	// Run on load and resize
	$(window).on('load resize', handleSlider);
}

$(document).ready(function () {
	initResponsiveSlider();
});



/** Added a Query String to users coming from UTM. */
jQuery(document).ready(function() {
    // Function to get URL parameters
    function getUrlParams(url) {
        let params = {};
        let parser = document.createElement('a');
        parser.href = url;
        let query = parser.search.substring(1);
        let vars = query.split('&');
        for (let i = 0; i < vars.length; i++) {
            let pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    }

    // Get current URL parameters
    let params = getUrlParams(window.location.href);
    console.table(params);

    // Check if the specific UTM parameters are present
    if (params['utm_source'] === 'googleads') {
        sessionStorage.setItem('datasource', 'cpc');
    } else if(params['utm_source'] === 'google_ads_hiring') {
        sessionStorage.setItem('datasource', 'google_ads_hiring');
    } else if(params['utm_source'] === 'google_jobs_apply') {
        sessionStorage.setItem('datasource', 'google_jobs');
    }

    // Function to append query string to internal links
    function appendQueryStringToLinks(queryString) {
        let links = document.querySelectorAll('a');
        links.forEach(function(link) {
            let href = link.getAttribute('href');
            if (href && href.startsWith(window.location.origin) && !href.includes(queryString)) {
                if (href.includes('?')) {
                    href += '&' + queryString;
                } else {
                    href += '?' + queryString;
                }
                link.setAttribute('href', href);
            }
        });
    }
   
    if (sessionStorage.getItem('datasource') === 'cpc') {
        appendQueryStringToLinks('datasource=cpc');
    } else if (sessionStorage.getItem('datasource') === 'google_ads_hiring') {
        appendQueryStringToLinks('datasource=google_ads_hiring');
    } else if (sessionStorage.getItem('datasource') === 'google_jobs') {
        appendQueryStringToLinks('datasource=google_jobs');
    }
});