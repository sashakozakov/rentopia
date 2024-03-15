import vars from './_vars';

const $ = jQuery.noConflict();
// Helper functions:
import {throttle} from './functions/throttle';

// Plugins (NPM modules and uploaded files):
import Swiper, {Navigation, Pagination, Autoplay, Thumbs} from 'swiper/bundle'; // import Swiper bundle with all modules installed
// available Swiper.js modules = [Virtual, Keyboard, Mousewheel, Navigation, Pagination, Scrollbar, Parallax, Zoom, Lazy, Controller, A11y, History, HashNavigation, Autoplay, Thumbs, FreeMode, Grid, Manipulation, EffectFade, EffectCube, EffectFlip, EffectCoverflow, EffectCreative, EffectCards]
// import './vendors/jquery.nice-select.min.js'; // jQuery Nice Select
import {Fancybox} from "@fancyapps/ui"; // Fancybox

$(document).ready(function () {
	"use strict";

	submit_application();

	teamMemberPopup();
	AppartamentGallerySlider();
	neighborhoodsAjaxLoadMore();
	collectionsAjaxLoadMore();
	portfolioAjaxLoadMore();
	buildingsAjaxLoadMore();
	blogAjaxLoadMore();
	searchAjaxLoadMore();
	taxCollectionsAjaxLoadMore();
	taxNeighborhoodsAjaxLoadMore();
	module_collections_slider();
	filter_MultiSelect();
	module_tiles_slider();
	swiper_images();
	module_why_us_slider();
	apartamentCardSlider();

	adminLoginForm();
	adminListingFilter();
	adminSettingPage();
	ajaxEditListing();
	ajaxNewListing();
	agents_search();
	edit_user_page();
	datepicker();


	$('.editor iframe').wrap('<div class="iframe_wrapper"></div>').wrap('<div></div>');

	/**
	 * Tweak for mobiles (full height)
	 */
	const fixFullheight = () => {
		const vh = window.innerHeight * 0.01;
		vars.htmlEl.style.setProperty('--vh', `${vh}px`);
	};

	fixFullheight();
	const fixHeight = throttle(fixFullheight);
	window.addEventListener('resize', fixHeight);


	/**
	 * Force load of all lazy-loading images
	 */
	setTimeout(function () {
		$('.lazyload.loading').removeClass('loading').addClass('loaded');
	}, 3000);


	/**
	 * Nice select
	 */
	// do not activate NiceSelect on those pages, where it might conflict with Select2
	// if (!$('body').hasClass('woocommerce-account')) {
	// 	$('select').niceSelect();
	// }


	/**
	 * Trigger NiceSelect update after Woocommerce Update variations
	 */
	// $(".variations_form").on("woocommerce_variation_has_changed", function () {
	// 	$('.variations_form select').niceSelect('update');
	// });


});

function teamMemberPopup() {
	let desktop = window.matchMedia('(min-width: 641px)');
	$('.team_member--link').click(function (e) {
		e.preventDefault();
		var parent = $(this).parent().parent().parent();
		var member_id = $(this).attr('href');
		var $teamMembersPopup = $('.team_members__popup');
		$teamMembersPopup.detach().insertAfter(parent);


		if (desktop.matches) {
			$('.team_member__info').hide();
			$teamMembersPopup.show();
			$("#" + member_id).toggle();
			$('html, body').animate({
				scrollTop: $("#team_members__popup").offset().top - 90
			}, 400);
		} else {
			$(this).next('.hidden_content').slideToggle();
		}
	});

	$('.team_member__info--nav div.close_btn').on('click', function () {
		$('.team_member__info, .team_members__popup').hide();
	});

	$('.team_member__info--nav div.next_btn').on('click', function () {
		var parent = $(this).parents('.team_member__info');
		parent.hide().next().show();
	});

	$('.team_member__info--nav div.prev_btn').on('click', function () {
		var parent = $(this).parents('.team_member__info');
		parent.hide().prev().show();
	});
}


/**
 * Trigger filterMultiSelect
 */
function filter_MultiSelect() {
	if ($('select#status').length) {
		let neighborhood = new filterMultiSelect("#status", {
			// "maxOptionWidth": 110,
			"maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Status",
			translations: {"all": "All", "items": "Status"}
		});
	}
	if ($('select#neighborhood').length) {
		let neighborhood = new filterMultiSelect("#neighborhood", {
			// "maxOptionWidth": 110,
			"maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Neighborhood",
			translations: {"all": "All", "items": "Neighborhood"}
		});
	}

	if ($('select#mobile_neighborhood').length) {
		let mobile_neighborhood = new filterMultiSelect("#mobile_neighborhood", {
			// "maxOptionWidth": 110,
			"maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Neighborhood",
			translations: {"all": "All", "items": "Neighborhood"}
		});
	}

	if ($('select#bedrooms').length) {
		let bedrooms = new filterMultiSelect("#bedrooms", {
			// "maxOptionWidth": 110,
			"maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Bedrooms",
			translations: {"all": "All", "items": "Bedrooms"}
		});
	}
	if ($('select#mobile_bedrooms').length) {
		let mobile_bedrooms = new filterMultiSelect("#mobile_bedrooms", {
			// "maxOptionWidth": 110,
			"maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Bedrooms",
			translations: {"all": "All", "items": "Bedrooms"}
		});
	}

	if ($('select#price').length) {
		let price = new filterMultiSelect("#price", {
			// "maxOptionWidth": 110,
			// "maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Price",
			// translations: {"all": "All", "items": "Price"}
		});
	}
	if ($('select#mobile_price').length) {
		let mobile_price = new filterMultiSelect("#mobile_price", {
			// "maxOptionWidth": 110,
			// "maxHeight": 200,
			"search": false,
			disableSelectAll: true,
			placeHolder: "Price",
			// translations: {"all": "All", "items": "Price"}
		});
		// $('select#price').each(function () {
		// 	$(this).select2({
		// 		placeholder: $(this).attr('placeholder'),
		// 		minimumResultsForSearch: -1,
		// 		tags: true,
		// 		allowClear: Boolean($(this).data('allow-clear')),
		// 	});
		// });
	}

	if ($('select#user_agent').length) {
		// let user_agent = new filterMultiSelect("#user_agent", {
		// 	// "maxOptionWidth": 110,
		// 	// "maxHeight": 200,
		// 	"search": false,
		// 	// disableSelectAll: true,
		// 	placeHolder: "Agent",
		// 	// translations: {"all": "All", "items": "Price"}
		// });
		// Initialize Select2.js on the select element
		(function ($) {

			var Defaults = $.fn.select2.amd.require('select2/defaults');

			$.extend(Defaults.defaults, {
				searchInputPlaceholder: ''
			});

			var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');

			var _renderSearchDropdown = SearchDropdown.prototype.render;

			SearchDropdown.prototype.render = function (decorated) {

				// invoke parent method
				var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));

				this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));

				return $rendered;
			};

		})(window.jQuery);

		$('#user_agent').select2({
			placeholder: "+ Choose Agent",
			allowClear: true,
			searchInputPlaceholder: 'Search...',
			templateResult: formatUserOption, // Custom template function for options
			templateSelection: formatUserSelection, // Custom template function for selected option
			escapeMarkup: function (markup) {
				return markup;
			}
		});

		// Custom template function for options with icons
		function formatUserOption(user) {
			if (!user.id) {
				return user.text;
			}

			// Get the icon URL for the user
			var iconUrl = user.element.getAttribute('data-icon');
			var user_email = user.element.getAttribute('data-email');

			// Create the option markup with the user's display name and icon
			var option = $('<span class="user_wrap"><span class="user_name">' + user.text + '<span>Agent</span></span><span class="user_email">' + user_email + '</span></span>');
			var imageSpan = $('<span>').addClass('user_image');

			if (iconUrl) {
				var img = $('<img>').attr('src', iconUrl).addClass('user-icon');
				imageSpan.append(img);
			}
			// else {
			// 	// Use a placeholder image when data-icon is empty
			// 	var placeholderImg = $('<img>').attr('src', 'path/to/placeholder.jpg').addClass('user-icon');
			// 	imageSpan.append(placeholderImg);
			// }

			option.prepend(imageSpan);

			return option;
		}

		// Custom template function for the selected option
		function formatUserSelection(user) {
			if (!user.id) {
				return user.text;
			}

			// Get the icon URL for the selected user
			var iconUrl = user.element.getAttribute('data-icon');

			// Create the selected option markup with the user's display name and icon
			var selection = $('<span>' + user.text + '</span>');
			var imageSpan = $('<span>').addClass('user_image');

			if (iconUrl) {
				var img = $('<img>').attr('src', iconUrl).addClass('user-icon');
				imageSpan.append(img);
			}

			selection.prepend(imageSpan);

			return selection;
		}

	}

	if ($('select#listing_collections').length) {

		var $listing_collections = $('#listing_collections').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
		$('.listing_collections_open').on('click', function () {
			$listing_collections.select2("open");
		});
	}

	if ($('select#building_amenities').length) {

		var $building_amenities = $('#building_amenities').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
		$('.building_amenities_open').on('click', function () {
			$building_amenities.select2("open");
		});
	}

	if ($('select#building_posts').length) {

		var building_posts = $('#building_posts').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
		$('.building_posts_open').on('click', function () {
			building_posts.select2("open");
		});
	}

	if ($('select#building_neighborhood').length) {

		var building_neighborhood = $('#building_neighborhood').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
		$('.building_neighborhood_open').on('click', function () {
			building_neighborhood.select2("open");
		});


		var building_neighborhood_single = $('#building_neighborhood_single').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
	}

	if ($('select#apartment_amenities').length) {

		var $apartment_amenities = $('#apartment_amenities').select2({
			// placeholder: "+ Add Collection",
			allowClear: true,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Search...',
			// dropdownCssClass: "custom_select_dropdown",
		});
		$('.apartment_amenities_open').on('click', function () {
			$apartment_amenities.select2("open");
		});
	}

// on listing page
	if ($('select#status_select2').length) {
		var $neighborhood_select2 = $('#status_select2').select2({
			allowClear: false,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Status.',
			minimumResultsForSearch: -1, // disable search
			// dropdownCssClass: "custom_select_dropdown",
		});
	}

	if ($('select#neighborhood_select2').length) {
		var $neighborhood_select2 = $('#neighborhood_select2').select2({
			allowClear: false,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Neighborhood.',
			minimumResultsForSearch: -1, // disable search
			// dropdownCssClass: "custom_select_dropdown",
		});
	}

	if ($('select#user_agent_select2').length) {
		var $neighborhood_select2 = $('#user_agent_select2').select2({
			allowClear: false,
			dropdownAutoWidth: true,
			searchInputPlaceholder: 'Agent.',
			minimumResultsForSearch: -1, // disable search
			// dropdownCssClass: "custom_select_dropdown",
		});
	}


	$('.mobile_search__form_btn').on('click', function () {
		$('.search_banner__form').slideDown();
	});

	$('.search_banner__form--close').on('click', function () {
		$('.search_banner__form').slideUp();
	});
	$('.search_banner__form .vsb-main').each(function () {
		$(this).on('click', function () {
			var isActive = $(this).find('.vsb-menu').hasClass('active');

			$('.vsb-menu').removeClass('active').slideUp(0);
			if (!isActive) {
				$(this).find('.vsb-menu').addClass('active').slideDown();
			}
		});
	});
	$(document).mouseup(function (e) {
		var container = $('select#neighborhood + .vsb-main');
		var search_banner__form = $('.search_banner__form');

		// If the target element is not within the container, remove the active class
		if (!search_banner__form.is(e.target) && search_banner__form.has(e.target).length === 0) {
			search_banner__form.slideUp(0);
		}

		// If the target element is not within the container, remove the active class
		if (!container.is(e.target) && container.has(e.target).length === 0) {
			container.find('.vsb-menu').removeClass('active').slideUp(0);
		}


	});


	$('.select2_select').select2({
		minimumResultsForSearch: -1, // disable search
	});
}

function AppartamentGallerySlider() {
	var appartament_gallery = new Swiper('.appartament_gallery__slider', {
		loop: true,
		spaceBetween: 30,
		slidesPerView: 1,
		centeredSlides: true,
		autoplay: false,
		watchSlidesProgress: true,
		// autoplay: {
		// 	delay: 2500,
		// 	disableOnInteraction: false,
		// },
		// pagination: {
		// 	el: slider.querySelector('.swiper-pagination'),
		// 	clickable: true,
		// },
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		on: {
			// lazy load images
			slideChange: function () {
				try {
					lazyLoadInstance.update();
				} catch (e) {
				}
			}
		},
		breakpoints: {
			1200: {
				spaceBetween: 54,
			},
		},
	});

	var swiper2 = new Swiper(".appartament_banner_slider", {
		loop: true,
		slidesPerView: 1,
		spaceBetween: 10,
		autoplay: false,
		// autoplay: {
		// 	delay: 5500,
		// 	disableOnInteraction: false,
		// },
		pagination: {
			el: ".swiper-pagination",
			// dynamicBullets: true,
			clickable: true,
		},
		navigation: {
			nextEl: ".appartament_banner_slider .swiper-button-next",
			prevEl: ".appartament_banner_slider .swiper-button-prev",
		},
		on: {
			// lazy load images
			slideChange: function () {
				try {
					lazyLoadInstance.update();
				} catch (e) {
				}
			}
		},
	});
}

function neighborhoodsAjaxLoadMore() {
	jQuery(document).ready(function ($) {
		$('.neighborhoods_section .load-more-btn').click(function (e) {
			e.preventDefault();
			$('.preloader_container').addClass('loading');

			var next = $('.buildings__grid .col-12').length + 1;
			var page = 2;

			$.ajax({
				url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
				type: 'post',
				data: {
					action: 'load_more_neighborhoods',
					'page': page,
					next: next
				},
				success: function (response) {
					$('.buildings__grid').append(response);
					console.log(response);
					// Hide the preloader
					$('.preloader_container').removeClass('loading');
					if ('' === response) {
						$('.load-more-btn').hide();
						return;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
	});
}

function collectionsAjaxLoadMore() {
	jQuery(document).ready(function ($) {
		$('.collections_section .load-more-btn').click(function (e) {
			e.preventDefault();
			$('.preloader_container').addClass('loading');

			var next = $('.buildings__grid .col-lg-6').length + 1;
			var page = 2;

			$.ajax({
				url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
				type: 'post',
				data: {
					action: 'load_more_collections',
					'page': page,
					next: next
				},
				success: function (response) {
					$('.buildings__grid').append(response);
					// Hide the preloader
					$('.preloader_container').removeClass('loading');
					if ('' === response) {
						$('.load-more-btn').hide();
						return;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				},
				complete: function (xhr, status) {
				}
			});
		});
	});
}

function portfolioAjaxLoadMore() {
	// Add event listener to the load more button
	jQuery(document).ready(function ($) {
		$('.portfolio_section .load-more-btn').click(function (e) {
			e.preventDefault();
			$('.preloader_container').addClass('loading');

			var next = $('.appartaments__grid .col-lg-4').length + 1;
			var pageID = $('.appartaments__grid').attr('data-pageID');
			var page = 2;

			$.ajax({
				url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
				type: 'post',
				data: {
					action: 'load_more_portfolio',
					'page': page,
					next: next,
					pageID: pageID
				},
				success: function (response) {
					$('.appartaments__grid').append(response);
					console.log(wpApiSettings.ajaxUrl);
					console.log(response);
					// Hide the preloader
					$('.preloader_container').removeClass('loading');
					if ('' === response || $('.appartaments__grid > div').length % 12 != 0) {
						$('.load-more-btn').hide();
						return;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.responseText);
				}
			});
		});
	});
}

function buildingsAjaxLoadMore() {
	// Add event listener to the load more button
	$('.buildings_section .load-more-btn').click(function (e) {
		e.preventDefault();
		$('.preloader_container').addClass('loading');

		var next = $('.ajax_buildings__grid .col-md-4.col-sm-6').length + 1;
		var page = 2;

		$.ajax({
			url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
			type: 'post',
			data: {
				action: 'load_more_buildings',
				'page': page,
				next: next,
			},
			success: function (response) {
				$('.ajax_buildings__grid').append(response);
				// console.log(wpApiSettings.ajaxUrl);
				// console.log(response);
				// Hide the preloader
				$('.preloader_container').removeClass('loading');
				if ('' === response || $('.ajax_buildings__grid .col-md-4.col-sm-6').length % 3 != 0) {
					$('.load-more-btn').hide();
					return;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.responseText);
			}
		});
	});
}

function blogAjaxLoadMore() {
	// Add event listener to the load more button
	$('.blog-archive-wrapper .load-more-btn').click(function (e) {
		e.preventDefault();
		$('.preloader_container').addClass('loading');

		var next = $('.ajax_blog__grid > div').length + 1;
		var termId = $('.ajax_blog__grid').attr('data-term');
		var page = 2;

		$.ajax({
			url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
			type: 'post',
			data: {
				action: 'load_more_blog',
				'page': page,
				next: next,
				termId: termId,
			},
			success: function (response) {
				$('.ajax_blog__grid').append(response);
				// console.log(wpApiSettings.ajaxUrl);
				// console.log(response);
				// Hide the preloader
				$('.preloader_container').removeClass('loading');
				if ('' === response) {
					$('.load-more-btn').hide();
					return;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.responseText);
			}
		});
	});
}

function searchAjaxLoadMore() {
	// Add event listener to the load more button
	$('.search-archive-wrapper .load-more-btn').click(function (e) {
		e.preventDefault();
		$('.preloader_container').addClass('loading');

		var next = $('.ajax_search__grid .col-lg-4').length + 1;
		var dataFilter = $('.ajax_search__grid').attr('data-filter');
		var dataNeighborhoods = $('.ajax_search__grid').attr('data-neighborhoods');
		var dataBedrooms = $('.ajax_search__grid').attr('data-bedrooms');
		var dataPrice = $('.ajax_search__grid').attr('data-price');
		var page = 2;

		$.ajax({
			url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
			type: 'post',
			data: {
				action: 'load_more_search',
				'page': page,
				next: next,
				dataFilter: dataFilter,
				neighborhoods: dataNeighborhoods,
				bedrooms: dataBedrooms,
				price: dataPrice,
			},
			success: function (response) {
				$('.ajax_search__grid').append(response);
				// console.log(wpApiSettings.ajaxUrl);
				// console.log(response);
				// Hide the preloader
				$('.preloader_container').removeClass('loading');
				apartamentCardSlider();
				if ('' === response || $('.ajax_search__grid .col-lg-4').length % 12 != 0) {
					$('.load-more-btn').hide();
					return;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.responseText);
			}
		});
	});
}

// load more on scroll for search results page
function handleIntersection(entries, observer) {
	entries.forEach(entry => {
		// If the button is in the viewport
		if (entry.isIntersecting) {
			// Trigger a click event on the button
			const loadMoreBtn = document.querySelector('.search-results .load-more-btn');
			loadMoreBtn.click();
		}
	});
}

// Create a new Intersection Observer
const observer = new IntersectionObserver(handleIntersection);

// Target the button you want to observe
const loadMoreBtn = document.querySelector('.search-results .load-more-btn');

// Start observing the button
if (loadMoreBtn && $('.search-results')) {
	observer.observe(loadMoreBtn);
}

function taxCollectionsAjaxLoadMore() {
	// Add event listener to the load more button
	$('.tax-collections-archive-wrapper .load-more-btn').click(function (e) {
		e.preventDefault();
		$('.preloader_container').addClass('loading');

		var next = $('.tax_collection_grid .col-lg-4').length + 1;
		var dataTerm = $('.tax_collection_grid').attr('data-term');
		var page = 2;

		$.ajax({
			url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
			type: 'post',
			data: {
				action: 'load_more_tax_collections',
				'page': page,
				next: next,
				dataTerm: dataTerm,
			},
			success: function (response) {
				$('.tax_collection_grid').append(response);
				// console.log(wpApiSettings.ajaxUrl);
				// console.log(response);
				// Hide the preloader
				$('.preloader_container').removeClass('loading');
				apartamentCardSlider();
				if ('' === response || $('.tax_collection_grid > div').length % 12 != 0) {
					$('.load-more-btn').hide();
					return;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.responseText);
			}
		});
	});
}

function taxNeighborhoodsAjaxLoadMore() {
	// Add event listener to the load more button
	$('.tax-neighborhoods-archive-wrapper .load-more-btn').click(function (e) {
		e.preventDefault();
		$('.preloader_container').addClass('loading');

		var next = $('.tax_neighborhood_grid .col-lg-4').length + 1;
		var dataTerm = $('.tax_neighborhood_grid').attr('data-term');
		var page = 2;

		$.ajax({
			url: wpApiSettings.ajaxUrl, // Make sure to define this in your PHP file
			type: 'post',
			data: {
				action: 'load_more_tax_neighborhoods',
				'page': page,
				next: next,
				dataTerm: dataTerm,
			},
			success: function (response) {
				$('.tax_neighborhood_grid').append(response);
				// console.log(wpApiSettings.ajaxUrl);
				// console.log(response);
				// Hide the preloader
				$('.preloader_container').removeClass('loading');
				apartamentCardSlider();
				if ('' === response || $('.tax_neighborhood_grid > div').length % 12 != 0) {
					$('.load-more-btn').hide();
					return;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.responseText);
			}
		});
	});
}

function module_collections_slider() {

	/* Swiper
	**************************************************************/
	var swiper = Swiper;
	var init = false;


	/* Which media query
	**************************************************************/
	function swiperMode() {
		let mobile = window.matchMedia('(min-width: 0px) and (max-width: 991px)');
		let desktop = window.matchMedia('(min-width: 992px)');
		let swiper = null;
		let init = false;

		function enableSwiper() {
			if (!init) {
				init = true;
				swiper = new Swiper('.module_collections__slider', {
					slidesPerView: 1,
					autoplay: false,
					loop: true,
					spaceBetween: 30,
					direction: 'horizontal',
					pagination: {
						el: ".swiper-pagination",
						clickable: true,
					},
					breakpoints: {
						576: {
							slidesPerView: 2,
						},
					}
				});
			}
		}

		function disableSwiper() {
			if (init) {
				swiper.destroy();
				swiper = null;
				init = false;
			}
		}

// Initial check on page load
		if (mobile.matches) {
			enableSwiper();
		} else {
			disableSwiper();
		}

// Update Swiper on window resize
		$(window).on('resize', function () {
			if (mobile.matches) {
				enableSwiper();
			} else {
				disableSwiper();
			}
		});

	}

	/* On Load
	**************************************************************/
	window.addEventListener('load', function () {
		swiperMode();
	});

	/* On Resize
	**************************************************************/
	window.addEventListener('resize', function () {
		swiperMode();
	});
}

function module_tiles_slider() {

	/* Swiper
	**************************************************************/
	var swiper = Swiper;
	var init = false;


	/* Which media query
	**************************************************************/
	function swiperMode() {
		let mobile = window.matchMedia('(min-width: 0px) and (max-width: 991px)');
		// let tablet = window.matchMedia('(min-width: 769px) and (max-width: 1024px)');
		let desktop = window.matchMedia('(min-width: 992px)');

		if ($('.tiles_slider').length) {
			// Enable (for mobile)
			if (mobile.matches) {
				if (!init) {
					init = true;
					swiper = new Swiper('.tiles_slider', {
						slidesPerView: 1,
						autoplay: false,
						// autoplay: {
						// 	delay: 1000,
						// 	disableOnInteraction: false,
						// },
						// centeredSlides: true,
						loop: true,
						spaceBetween: 30,
						direction: 'horizontal',
						pagination: {
							el: ".swiper-pagination",
							// dynamicBullets: true,
							clickable: true,
						},

						breakpoints: {

							576: {
								slidesPerView: 2,
							},

						}

					});
				}
			}
			// Disable (for desktop)
			else if (desktop.matches) {
				swiper.destroy();
				init = false;
			}
		}
	}

	/* On Load
	**************************************************************/
	window.addEventListener('load', function () {
		swiperMode();
	});

	/* On Resize
	**************************************************************/
	window.addEventListener('resize', function () {
		swiperMode();
	});
}

function module_why_us_slider() {

	/* Swiper
	**************************************************************/
	var swiper = Swiper;
	var init = false;


	/* Which media query
	**************************************************************/
	function swiperMode() {
		let mobile = window.matchMedia('(min-width: 0px) and (max-width: 991px)');
		// let tablet = window.matchMedia('(min-width: 769px) and (max-width: 1024px)');
		let desktop = window.matchMedia('(min-width: 992px)');

		if ($('.module_why_us__slider').length) {
			// Enable (for mobile)
			if (mobile.matches) {
				if (!init) {
					init = true;
					swiper = new Swiper('.module_why_us__slider', {
						slidesPerView: 1,
						autoplay: false,
						// autoplay: {
						// 	delay: 1000,
						// 	disableOnInteraction: false,
						// },
						// centeredSlides: true,
						loop: true,
						spaceBetween: 30,
						direction: 'horizontal',
						pagination: {
							el: ".swiper-pagination",
							// dynamicBullets: true,
							clickable: true,
						},

						breakpoints: {

							576: {
								slidesPerView: 2,
							},

						}

					});
				}
			}
			// Disable (for desktop)
			else if (desktop.matches) {
				swiper.destroy();
				init = false;
			}
		}
	}

	/* On Load
	**************************************************************/
	window.addEventListener('load', function () {
		swiperMode();
	});

	/* On Resize
	**************************************************************/
	window.addEventListener('resize', function () {
		swiperMode();
	});
}

function adminLoginForm() {
	$('#lostpasswordform input[type="text"]').attr('placeholder', 'Username or Email');
	$('#loginform input[type="text"]').attr('placeholder', 'Email');
	$('#loginform input[type="password"]').attr('placeholder', 'Password');
	$('#loginform input[type="submit"]').attr('value', 'Log In');

	$('#lostpasswordform label[for="user_login"]').contents().filter(function () {
		return this.nodeType === 3;
	}).remove();

	$('#loginform label[for="user_login"]').contents().filter(function () {
		return this.nodeType === 3;
	}).remove();
	$('#loginform label[for="user_pass"]').contents().filter(function () {
		return this.nodeType === 3;
	}).remove();

	$('input[type="checkbox"]').click(function () {
		$(this + ':checked').parent('label').css("background-position", "0px -20px");
		$(this).not(':checked').parent('label').css("background-position", "0px 0px");
	});
}

function adminListingFilter() {

	$('.filter_el_input').on('keyup', function () {
		var filter = $('.listing_filter_form');

		$.ajax({
			url: filter.attr('action'),
			data: filter.serialize(), // form data
			type: filter.attr('method'), // POST
			beforeSend: function (xhr) {
				console.log('before send ajax');
			},
			success: function (data) {
				$('.listing_grid--body').html(data); // insert data
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
		return false;
	});
	$('.filter_el').change(function () {
		// $('#filter_curr_page').val(1);
		var filter = $('.listing_filter_form');

		$.ajax({
			url: filter.attr('action'),
			data: filter.serialize(), // form data
			type: filter.attr('method'), // POST
			beforeSend: function (xhr) {
				console.log('before send ajax');
			},
			success: function (data) {
				$('.listing_grid--body').html(data); // insert data
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
		return false;
	});

	$('.listing_filter_form--btn').on('click', function () {
		$('.listing_filter_form--right_side').addClass('active');
	});

	$('.listing_filter_form--right_side .close_filter').on('click', function () {
		$('.listing_filter_form--right_side').removeClass('active');
	});
}

function adminSettingPage() {

	if ($('#firs_last_name').length) {

		const fullNameInput = document.getElementById('firs_last_name');
		const firstNameInput = document.getElementById('first-name');
		const lastNameInput = document.getElementById('last-name');

		fullNameInput.addEventListener('input', function () {
			const fullNameValue = fullNameInput.value.trim();
			const words = fullNameValue.split(' ');

			const firstName = words.shift() || '';
			const lastName = words.join(' ');

			if (lastName.trim()) {
				lastNameInput.value = lastName.trim();
			} else {
				lastNameInput.value = '\u00A0'; // Use '\u00A0' for non-breaking space
			}
			firstNameInput.value = firstName;
		});
	}


	$('#acf-field_6450261def2b1').on('change', function () {
		// var fileName = $(this).prop('files')[0].name;
		// $('.img_txt').text(fileName);
		$('.img_txt').text('Image added');
		// if (fileName == null || fileName == false || typeof fileName !== 'undefined') {
		// 	console.log('1111111');
		// }

		// try {
		// 	var fileName = $(this).prop('files')[0].name;
		// 	$('.img_txt').text(fileName);
		// } catch (error) {
		// 	console.log('hello');
		// }


	});
}

function ajaxEditListing() {
	jQuery(document).ready(function ($) {
		if ($('select#collections').length) {
			let bedrooms = new filterMultiSelect("#collections", {
				"maxHeight": 200,
				"search": false,
				// disableSelectAll: true,
				placeHolder: "collections",
				translations: {"all": "All", "items": "collections"}
			});
		}

		// function formatText(icon) {
		// 	return $('<span><img src=' + $(icon.element).data('icon') + ' /> ' + icon.text + '</span>');
		// }
		//
		// $("#user_agent").select2({
		// 	// placeholder: '<i class="fa fa-sitemap"></i>Branch name',
		// 	// templateResult: formatGrid,
		// 	// escapeMarkup: function (markup) {
		// 	// 	return markup;
		// 	// }
		// 	width: "50%",
		// 	templateSelection: formatText,
		// 	templateResult: formatText
		// });
		//
		// $("#collections").select2({
		// 	// placeholder: '<i class="fa fa-sitemap"></i>Branch name',
		// 	// templateResult: formatGrid,
		// 	// escapeMarkup: function (markup) {
		// 	// 	return markup;
		// 	// }
		// 	// width: "50%",
		// 	// templateSelection: formatText,
		// 	// templateResult: formatText
		// });

		$('.preview').on('click', function (e) {
			e.preventDefault();

			var formData = $('#edit_listing_form').serialize();
			var previewURL = $(this).attr('href');
			var newURL = previewURL + '&' + formData;

			// Open the preview page in a new tab
			var newTab = window.open(newURL, '_blank');
			newTab.focus();

			// Send AJAX request
			// $.ajax({
			// 	url: previewURL + '?preview=true', // URL of the preview page
			// 	method: 'GET',
			// 	success: function(response) {
			// 		// Handle the preview response
			// 		// You can update a preview section or open a new window to display the preview content
			// 		// For example, you can update a div with the preview HTML
			// 		$('#preview_content').html(response);
			// 	},
			// 	error: function(xhr, status, error) {
			// 		// Handle error
			// 		console.log(error);
			// 	}
			// });
		});


		// TODO: Open images from media library
		// var mediaUploader;
		// $('#gallery').click(function(e) {
		// 	e.preventDefault();
		// 	if (mediaUploader) {
		// 		mediaUploader.open();
		// 		return;
		// 	}
		// 	mediaUploader = wp.media.frames.file_frame = wp.media({
		// 		title: 'Choose Image',
		// 		button: {
		// 			text: 'Choose Image'
		// 		},
		// 		multiple: true
		// 	});
		// 	mediaUploader.on('select', function() {
		// 		var selection = mediaUploader.state().get('selection');
		// 		selection.each(function(attachment) {
		// 			var attachmentId = attachment.id;
		// 			var attachmentUrl = attachment.attributes.url;
		// 			// Access the attachment ID and URL as needed
		// 			console.log( attachmentId);
		// 			console.log(attachmentUrl);
		// 		});
		// 	});
		// 	mediaUploader.open();
		// });


		// edit listing gallery
		$('#gallery').on('change', function () {
			const files = this.files;

			// Check file size
			const file = this.files[0];
			const fileSizeInMB = file.size / (1024 * 1024);
			if (fileSizeInMB > 1) {
				alert('File size exceeds the limit of 1MB.');
				return;
			}

			for (let i = 0; i < files.length; i++) {
				const file = files[i];
				const img = $('<img>').addClass('preview-image').prop('file', file);
				const innerDiv = $('<div>').addClass('new_image_inner').append(img);
				const removeIcon = $('<i>').addClass('remove-icon fa fa-times');
				const radioInput = $('<label>').addClass('new_image_input_wrapper').append('<input type="radio" name="listing_image_input">Select as Cover Image');
				const div = $('<div>').addClass('new_image').append(innerDiv, removeIcon);
				$('#imagePreviewContainer').append(div);

				const reader = new FileReader();
				reader.onload = (function (aImg) {
					return function (e) {
						aImg.attr('src', e.target.result);
					};
				})(img);

				reader.readAsDataURL(file);
			}
		});

		// upload thumbnail for building single
		$('#thumb').on('change', function () {
			const file = this.files[0];

			// Check file size
			const fileSizeInMB = file.size / (1024 * 1024);
			if (fileSizeInMB > 1) {
				alert('File size exceeds the limit of 1MB.');
				return;
			}

			const img = $('<img>').addClass('preview-image').prop('file', file);
			const innerDiv = $('<div>').addClass('new_image_inner').append(img);
			const removeIcon = $('<i>').addClass('remove-icon fa fa-times');
			const div = $('<div>').addClass('new_image').append(innerDiv, removeIcon);
			$('#imagePreviewContainer .new_image').remove();
			$('#imagePreviewContainer').append(div);

			const reader = new FileReader();
			reader.onload = (function (aImg) {
				return function (e) {
					aImg.attr('src', e.target.result);
				};
			})(img);

			reader.readAsDataURL(file);
		});

		// upload banner_img for building single
		$('#banner_img').on('change', function () {
			const file = this.files[0];

			// Check file size
			const fileSizeInMB = file.size / (1024 * 1024);
			if (fileSizeInMB > 1) {
				alert('File size exceeds the limit of 1MB.');
				return;
			}

			const img = $('<img>').addClass('preview-image').prop('file', file);
			const innerDiv = $('<div>').addClass('new_image_inner').append(img);
			const removeIcon = $('<i>').addClass('remove-icon fa fa-times');
			const div = $('<div>').addClass('new_image').append(innerDiv, removeIcon);
			$('#banner_img_container .new_image').remove();
			$('#banner_img_container').append(div);

			const reader = new FileReader();
			reader.onload = (function (aImg) {
				return function (e) {
					aImg.attr('src', e.target.result);
				};
			})(img);

			reader.readAsDataURL(file);
		});


		$('#imagePreviewContainer').on('click', '.remove-icon', function () {
			$(this).closest('.new_image').remove();
			var imgID = $(this).parent().attr('id');

			var hidden_gallery_input = $('#banner_img').val();
			var array = hidden_gallery_input.split(", ").map(Number);
			var elementToRemove = parseInt(imgID); // Parse imgID to an integer
			array = $.grep(array, function (value) {
				return value !== elementToRemove;
			});

			if ($('#thumb_image_val').length) {
				$('#thumb_image_val').val('reset');
			}

// Update hidden_gallery_input field with the updated array
			$('#hidden_gallery_input').val(array.join(", "));
		});


		// for building banner image
		$('#banner_img_container').on('click', '.remove-icon', function () {
			$(this).closest('.new_image').remove();
			var imgID = $(this).parent().attr('id');
			var hidden_gallery_input = $('#banner_img').val();
			var array = hidden_gallery_input.split(", ").map(Number);
			var elementToRemove = parseInt(imgID); // Parse imgID to an integer
			array = $.grep(array, function (value) {
				return value !== elementToRemove;
			});

			if ($('#banner_image_val').length) {
				$('#banner_image_val').val('reset');
			}

// Update hidden_gallery_input field with the updated array
			$('#hidden_gallery_input').val(array.join(", "));

		});


		// only for apartaments

		var subwayLines = [
			'1', '2', '3', '4', '5', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'j', 'l', 'm', 'n', 'q', 's', 'sf', 'sir', 'sr', 'w', 'z'
		];

		$('.new_subway_line').on('click', function () {
			var select = $('<select>').attr('name', 'subway_lines_type[]');

			subwayLines.forEach(function (line) {
				select.append($('<option>').text(line).val(line));
			});

			var div = $('<div>').addClass('row').append(
				$('<div>').addClass('col-sm-4 col-3').append(select),
				$('<div>').addClass('col-sm-4 col-6').append('<input type="text" name="subway_lines_title[]">'),
				$('<div>').addClass('col-sm-4 col-3').append('<input type="text" name="subway_lines_location[]">'),
				$('<div>').addClass('remove_subway_line').text('remove')
			);

			$('.subway_lines_body').append(div);
		});

		//
		$(document).on("click", ".remove_subway_line", function () {
			var parent = $(this).parent();
			parent.find('input').val('');
			parent.remove();
		});


		$('#edit_listing_form .submit').on('click', function () {
			$('#edit_listing_form #status').val($(this).attr('data-status'));
		});
		// $('#edit_listing_form').on('submit', function (e) {
		// 	e.preventDefault(); // Prevent the form from submitting normally
		// 	$('.preloader_container').addClass('loading');
		// 	// var formData = $(this).serialize(); // Serialize the form data
		//
		//
		// 	var formData = new FormData(this);
		// 	formData.append("action", "ajax_edit_listing");
		//
		// 	// console.log(formData);
		//
		//
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: wpApiSettings.ajaxUrl,
		// 		// data: {
		// 		// 	action: 'ajax_edit_listing',
		// 		// 	form_data: formData,
		// 		// },
		// 		data: formData,
		// 		cache: false,
		// 		contentType: false,
		// 		processData: false,
		// 		dataType: "json",
		// 		mimeType: "multipart/form-data",
		//
		//
		// 		success: function (response) {
		// 			// Handle the success response here
		// 			// console.log(response);
		// 			// You can display a success message or perform other actions
		//
		// 			console.log(wpApiSettings.ajax_url);
		// 			// console.log(wpApiSettings.ajax_url);
		// 			$('.edit_listing_form_msg').addClass('active');
		// 			setTimeout(function () {
		// 				$('.edit_listing_form_msg').removeClass('active');
		// 			}, 2500);
		// 		},
		// 		error: function (xhr, status, error) {
		// 			// Handle the error response here
		// 			console.error(error);
		// 			// You can display an error message or perform other actions
		// 		}
		// 	});
		//
		// 	setTimeout(function () {
		// 		// location.reload();
		// 	}, 500);
		// });
	});
}

function ajaxNewListing() {
	jQuery(document).ready(function ($) {

// new listing
		$('#new_listing_form .submit').on('click', function () {
			$('#new_listing_form #status').val($(this).attr('data-status'));
		});
		$('#new_listing_form').on('submit', function (e) {
			e.preventDefault(); // Prevent the form from submitting normally
			// $('.preloader_container').addClass('loading');

			var formData = new FormData(this);
			formData.append("action", "ajax_new_listing");
			// var formData = $(this).serialize(); // Serialize the form data

			// console.log(formData);

			$.ajax({
				type: 'POST',
				url: wpApiSettings.ajaxUrl,
				// data: {
				// 	action: 'ajax_new_listing',
				// 	form_data: formData,
				// },
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				// dataType: "json",
				mimeType: "multipart/form-data",

				success: function (response) {
					// Handle the success response here
					// console.log(response);
					// You can display a success message or perform other actions

					// console.log(wpApiSettings.ajax_url);
					$('.edit_listing_form_msg').addClass('active');
					setTimeout(function () {
						$('.edit_listing_form_msg').removeClass('active');


						window.location.href = '/listing/';
						// if (response.success) {
						// 	window.location.href = '/edit-listing/?id=' + response.data.post_id;
						// } else {
						// 	console.log('Error creating the post.');
						// }
					}, 2500);
					// console.log(response.data.post_id);
				},
				error: function (xhr, status, error) {
					// Handle the error response here
					console.error(error);
					// You can display an error message or perform other actions
				}
			});
		});


// new building
		$('#new_building_form .submit').on('click', function () {
			$('#new_building_form #status').val($(this).attr('data-status'));
		});
		$('#new_building_form').on('submit', function (e) {
			e.preventDefault(); // Prevent the form from submitting normally
			// $('.preloader_container').addClass('loading');
			var formData = new FormData(this);
			formData.append("action", "ajax_new_building");
			// var buildingFormData = $(this).serialize(); // Serialize the form data

			// console.log(formData);

			$.ajax({
				type: 'POST',
				url: wpApiSettings.ajaxUrl,
				// data: {
				// 	action: 'ajax_new_building',
				// 	building_form_data: buildingFormData,
				// },
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				// dataType: "json",
				mimeType: "multipart/form-data",

				success: function (response) {
					// Handle the success response here
					// You can display a success message or perform other actions

					// console.log(wpApiSettings.ajax_url);
					$('.edit_listing_form_msg').addClass('active');
					setTimeout(function () {
						$('.edit_listing_form_msg').removeClass('active');
					}, 2500);


					// window.location.href = '/edit-building/?id=' + response.data.post_id;
					window.location.href = '/my-buildings';
				},
				error: function (xhr, status, error) {
					// Handle the error response here
					console.error(error);
					// You can display an error message or perform other actions
				}
			});
		});
	});
}

function agents_search() {

	$('.agents_filter_el_input').on('keyup', function () {
		var filter = $('.agents_filter_form');

		$.ajax({
			url: filter.attr('action'),
			data: filter.serialize(), // form data
			type: filter.attr('method'), // POST
			beforeSend: function (xhr) {
				console.log('before send ajax');
			},
			success: function (data) {
				$('.agents_grid--body').html(data); // insert data
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
		return false;
	});
}


/**
 * Slider Images
 */
function swiper_images() {
	document.querySelectorAll('.swiper-images').forEach(slider => {
		const swiper = new Swiper(slider, {
			loop: true,
			spaceBetween: 50,
			slidesPerView: "auto",
			centeredSlides: true,
			autoplay: false,
			// autoplay: {
			// 	delay: 2500,
			// 	disableOnInteraction: false,
			// },
			pagination: {
				el: slider.querySelector('.swiper-pagination'),
				clickable: true,
			},
			// navigation: {
			// 	nextEl: slider.querySelector('.swiper-button-next'),
			// 	prevEl: slider.querySelector('.swiper-button-prev'),
			// },
			on: {
				// lazy load images
				slideChange: function () {
					try {
						lazyLoadInstance.update();
					} catch (e) {
					}
				}
			},
			breakpoints: {
				1200: {
					spaceBetween: 30,
				},
			},
		});
	});
}


function edit_user_page() {

	$('#settings_main_photo').on('click', function () {
		$(this).val(null);
		$(this).prev().find('img').remove();
	});
	$('#settings_main_photo').on('change', function () {
		const files = this.files;

		for (let i = 0; i < files.length; i++) {
			const file = files[i];
			const img = $('<img>').addClass('preview-image').prop('file', file);
			$('.settings_main_photo .inner_img').append(img);

			const reader = new FileReader();
			reader.onload = (function (aImg) {
				return function (e) {
					aImg.attr('src', e.target.result);
				};
			})(img);

			reader.readAsDataURL(file);
		}
	});


	$(window).on('scroll', function () {
		var $footer_elem = $('.admin-footer');
		if ($footer_elem.length) {
			var $settings_main = $('.settings_main');
			var $edit_listing_footer = $('.edit_listing_form--footer');

			var windowHeight = $(window).height();
			var scrollTop = $(window).scrollTop();
			var footerOffsetTop = $footer_elem.offset().top;
			// var elemOffsetTop = $settings_main.offset().top;
			// var elemHeight = $settings_main.outerHeight();

			// var elemInView = (scrollTop + windowHeight) > (elemOffsetTop + elemHeight/2);

			// if (elemInView) {
			if (footerOffsetTop - scrollTop - 20 <= windowHeight) {
				$settings_main.addClass('not_fixed_btn');
			} else {
				$settings_main.removeClass('not_fixed_btn');
			}

			if (footerOffsetTop - scrollTop - 20 <= windowHeight) {
				$edit_listing_footer.addClass('not_fixed');
			} else {
				$edit_listing_footer.removeClass('not_fixed');
			}
		}
	});


}

function datepicker() {
	var date = new Date();
	var currentMonth = date.getMonth();
	var currentDate = date.getDate();
	var currentYear = date.getFullYear();
	$(".datepicker").datepicker({
		minDate: new Date(currentYear, currentMonth, currentDate),
		dateFormat: 'dd/mm/yy'
	});
	// $.datepicker.regional['en'] = {
	// 	clearText: 'Effacer', clearStatus: '',
	// 	closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
	// 	prevText: '&lt;Préc', prevStatus: 'Voir le mois précédent',
	// 	nextText: 'Suiv&gt;', nextStatus: 'Voir le mois suivant',
	// 	currentText: 'Courant', currentStatus: 'Voir le mois courant',
	// 	monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
	// 		'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
	// 	monthNamesShort: ['January', 'Febuary', 'March', 'April', 'May', 'Jun',
	// 		'July', 'August', 'September', 'October', 'November', 'December'],
	// 	monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
	// 	weekHeader: 'Sm', weekStatus: '',
	// 	dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
	// 	dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
	// 	dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
	// 	dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
	// 	dateFormat: 'dd/mm/yy', firstDay: 0,
	// 	initStatus: 'Choisir la date', isRTL: false
	// };
	// $.datepicker.setDefaults($.datepicker.regional['en']);

}

// other scripts
function submit_application() {
	if ($('.simpay-checkout-form').length) {
		$('.simpay-form-control').each(function () {
			var label = $(this).find('label');
			var label_txt = label.text();
			var new_label = label_txt.replace(/\s+/g, ' ').trim();
			label.remove();
			$(this).find('input').attr('placeholder', new_label);
		})
	}
}


// ------------------------------------------------------------------

document.querySelectorAll('.features_slider').forEach(slider => {
	const swiper = new Swiper(slider, {
		// loopedSlides: 8,
		loop: true,
		// freeMode: true,
		// mousewheel: {
		// 	releaseOnEdges: false,
		// },
		autoplay: {
			delay: 2500,
			disableOnInteraction: false,
		},
		// watchSlidesProgress: true,
		spaceBetween: 15,
		slidesPerView: "auto",
		centeredSlides: true,
		pagination: {
			el: slider.querySelector('.swiper-pagination'),
			clickable: true,
		},
		on: {
			// lazy load images
			slideChange: function () {
				try {
					lazyLoadInstance.update();
				} catch (e) {
				}
			}
		},
		breakpoints: {
			640: {
				spaceBetween: 30,
				// slidesPerView: 2,
				// centeredSlides: true,
			},
			// 768: {
			// 	slidesPerView: 3,
			// 	centeredSlides: true,
			// },
			// 1024: {
			// 	slidesPerView: 4,
			// 	centeredSlides: true,
			// },
			// 1199: {
			// 	slidesPerView: 5,
			// 	centeredSlides: true,
			// },
		},
	});
	$('.features_slider').on('mouseenter', function (e) {
		swiper.autoplay.stop();
	})
	$('.features_slider').on('mouseleave', function (e) {
		swiper.autoplay.start();
	})
});

document.querySelectorAll('.testimonials_slider').forEach(slider => {
	const swiper = new Swiper(slider, {
		// loopedSlides: 8,
		loop: true,
		// freeMode: true,
		// mousewheel: {
		// 	releaseOnEdges: false,
		// },
		spaceBetween: 15,
		slidesPerView: "auto",
		centeredSlides: true,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
		},
		// watchSlidesProgress: true,
		pagination: {
			el: slider.querySelector('.swiper-pagination'),
			clickable: true,
		},
		on: {
			// lazy load images
			slideChange: function () {
				try {
					lazyLoadInstance.update();
				} catch (e) {
				}
			}
		},
		breakpoints: {
			640: {
				slidesPerView: 2,
				centeredSlides: false,
				spaceBetween: 30,
			},
			768: {
				slidesPerView: 3,
				centeredSlides: false,
			},
			1200: {
				slidesPerView: 4,
				centeredSlides: false,
			},
		},
	});
});


function apartamentCardSlider() {

	document.querySelectorAll('.new_appartament__item__slider').forEach(slider => {

		const slides = slider.querySelectorAll('.slide');
		const btnLeft = slider.querySelector('.slider__btn--left');
		const btnRight = slider.querySelector('.slider__btn--right');
		const dotContainer = slider.querySelector('.dots');

		let curSlide = 0;
		const maxSlide = slides.length;

		// Functions
		const createDots = function () {
			dotContainer.innerHTML = '';
			slides.forEach(function (_, i) {
				dotContainer.insertAdjacentHTML(
					'beforeend',
					`<span class="swiper-pagination-bullet" data-slide="${i}"></span>`
				);
			});
		};

		const activateDot = function (slide) {
			slider
				.querySelectorAll('.swiper-pagination-bullet')
				.forEach(dot => dot.classList.remove('swiper-pagination-bullet-active'));

			slider
				.querySelector(`.swiper-pagination-bullet[data-slide="${slide}"]`)
				.classList.add('swiper-pagination-bullet-active');
		};

		const goToSlide = function (slide) {
			slides.forEach(
				(s, i) => (s.style.transform = `translateX(${100 * (i - slide)}%)`)
			);
		};

		// Next slide
		const nextSlide = function () {
			if (curSlide === maxSlide - 1) {
				curSlide = 0;
			} else {
				curSlide++;
			}

			goToSlide(curSlide);
			activateDot(curSlide);
		};

		const prevSlide = function () {
			if (curSlide === 0) {
				curSlide = maxSlide - 1;
			} else {
				curSlide--;
			}
			goToSlide(curSlide);
			activateDot(curSlide);
		};

		const init = function () {
			goToSlide(0);
			createDots();

			activateDot(0);
		};
		init();

		// Event handlers
		btnRight.addEventListener('click', nextSlide);
		btnLeft.addEventListener('click', prevSlide);

		document.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft') prevSlide();
			e.key === 'ArrowRight' && nextSlide();
		});

		dotContainer.addEventListener('click', function (e) {
			if (e.target.classList.contains('swiper-pagination-bullet')) {
				const {slide} = e.target.dataset;
				goToSlide(slide);
				activateDot(slide);
			}
		});

	});

}


