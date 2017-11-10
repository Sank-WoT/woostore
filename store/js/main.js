jQuery(document).ready(function($) {

	if ($('.js-home-slider').length) {
		$('.js-home-slider').owlCarousel({
			navigation: true,
			slideSpeed: 300,
			paginationSpeed: 400,
			singleItem: true,
			addClassActive: true
		});
	}


	if ($('.js-works-slider').length) {
		$('.js-works-slider').owlCarousel({
			navigation: true,
			slideSpeed: 300,
			paginationSpeed: 400,
			addClassActive: true,
			dots: true,
			items: 4,
			scrollPerPage : true
		});
	}

	var stickyHeaderTop = $('.js-header-top');

	function stickyMenu() {
		if ($(window).scrollTop() > 200) {
			stickyHeaderTop.addClass('fixed');
		} else {
			stickyHeaderTop.removeClass('fixed');
		}
	};

	stickyMenu();

	$(window).scroll(function() {
		stickyMenu();
	});

	if ($('.js-product').length) {
		$('.js-product').magnificPopup({
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			gallery: {
				enabled: true
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
			}
		});
	}

	if ($('.js-popup').length) {
		$('.js-popup').magnificPopup({
			removalDelay: 500, //delay removal by X to allow out-animation
			callbacks: {
				beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
		});
	}


	if ($('.js-search').length) {
		$('.js-search').click(function(e){
			e.preventDefault();

			$('.header-top.fixed').css('z-index', 2000);
			$('.popup.popup_search').removeClass('mfp-hide');
			$('.popup.popup_search').stop().fadeIn();
			$('.search__field').first().focus();

			$('body').find('.search-overlay').addClass('mfp-bg mfp-move-from-top mfp-ready');
		});
	}

	if ($('.search-overlay').length) {
		$('.search-overlay').on('click', function(){
			$('html').css('overflow', 'auto');
			$('.popup.popup_search').stop().fadeOut(200);
			$('.search-overlay').removeClass('mfp-bg mfp-move-from-top mfp-ready');
			$('.header-top.fixed').css('z-index', 20);
		});
	}


	/* Checkout */
	$(document).on('click' , ".quantity-up", function(e) {
		var oldValue = parseFloat($(this).parents('.wrap-quantity').find("input").val());
		if (oldValue >= $(this).parents('.wrap-quantity').find("input").attr('max')) {
			var newVal = oldValue;
		} else {
			var newVal = oldValue + 1;
		}
		$(this).parents('.wrap-quantity').find("input").val(newVal);
		$(this).parents('.wrap-quantity').find("input").trigger("change");
	});
	$(document).on('click' , ".quantity-down", function(e) {
		var oldValue = parseFloat($(this).parents('.wrap-quantity').find("input").val());
		if (oldValue <= $(this).parents('.wrap-quantity').find("input").attr('min')) {
			var newVal = oldValue;
		} else {
			var newVal = oldValue - 1;
		}
		$(this).parents('.wrap-quantity').find("input").val(newVal);
		$(this).parents('.wrap-quantity').find("input").trigger("change");
	});

	// Set cookie
	function setCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();
		} else {
			var expires = "";
		}
		document.cookie = name + "=" + value + expires + "; path=/";
	}

	// Get cookie
	function getCookie(name) {
		var matches = document.cookie.match(new RegExp(
			"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	// Delete cookie
	function deleteCookie(name) {
		document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}


	// Change city
	if (!getCookie('city')) {
		$('.your-city-info').show();
	}

	$('#change-city').click(function(e) {
		e.preventDefault();
		$(this).addClass('disabled-btn');
		if( $('#all-city').is(':visible') ) {
			return false;
		}
		$('#all-city').stop( true, true ).slideToggle(100);
		setTimeout((function(){
			$('#s2id_select-your-city').select2('open');
		}), 300);
	});

	$('.js-fix-margin').click(function(e) {
		e.preventDefault();
		$('html').css({
			'margin-right': '0'
		})
	});

	$('#select-city').click(function(e) {
		e.preventDefault();
		$('#select-city-popup').parent().addClass('container');
	});

	var magnificPopup = $.magnificPopup.instance;

	$('#city-approve').click(function(e){
		e.preventDefault();
		magnificPopup.close();

		if ($(location).attr('href').match('/payment-shipping/')) {
			location.reload();
		}
	});

	// Add select2 to select city
	var delivery_point_select2 = function() {
		$( '#delivery #billing_delivery_point' ).select2( {
			minimumResultsForSearch: 10,
			placeholder: 'Выберите пункт выдачи заказов',
			placeholderOption: 'first',
			width: '100%',
		}).on('select2-selecting', function(event) {
			var deliveryPoint = event.object.text;

			deleteCookie('delivery_point');
			setCookie('delivery_point', deliveryPoint, 365);

			$('#delivery-point').text(deliveryPoint);
		});
	};


	// Get yandex map
	var delivery_points_map = function() {

		ymaps.ready(function () {

			var contactmap;
			var map_container = 'edostavka_map';
			var points = $( '#' + map_container ).data('points');

			ymaps.geocode( $( '#' + map_container ).data('state-name') , { results: 1 }).then( function( response ){

				var getCoordinats = response.geoObjects.get(0).geometry.getCoordinates();
				contactmap = new ymaps.Map( map_container, {
					center: getCoordinats,
					zoom: 9,
					behaviors: ['default', 'scrollZoom'],
					controls: []
				});

				$.map( points, function( point ) {
					addPointToMap( point );
				});

				function addPointToMap( point ) {

					placemark = new ymaps.Placemark( [ point.coordY, point.coordX ], {
						balloonContentBody: [
							'<address>',
							'<strong>' + point.Name + '</strong>',
							'<br/>',
							'Адрес: г.' + point.City + ' ул.' + point.Address,
							'<br/>',
							'Телефон: ' + point.Phone,
							'<br/>',
							'Время работы: ' + point.WorkTime,
							'<br/>',
							'Дополнительно: ' + point.Note,
							'</address>'
						].join('')
					} );

					placemark.events.add('click', function( event ) {
						$("select#billing_delivery_point")
							.val( point.Code )
							.select2( 'val', point.Code );

							deleteCookie('delivery_point');
							setCookie('delivery_point', point.Address, 365);

							$('#delivery-point').text(' ул.' + point.Address);
					});

					contactmap.geoObjects.add( placemark );
				};

				// if( contactmap.geoObjects.getLength() > 1 ) {
				//     contactmap.setBounds( contactmap.geoObjects.getBounds() );
				// } else {
				//     contactmap.setCenter( contactmap.geoObjects.get(0).geometry.getCoordinates() );
				// }

				contactmap.setCenter(result.geoObjects.get(0).geometry.getCoordinates(), 1, {duration: 300});

			});

		});
	};


	var wc_params = { "default_country": "RU", "api_url": "\/\/api.cdek.ru\/city\/getListByTerm\/jsonp.php" };

	// Select2 russian localization
	console.log($.fn.select2.defaults);
	$.fn.select2.defaults.formatNoMatches = function () { return "Совпадений не найдено"; },
	$.fn.select2.defaults.formatInputTooShort = function (input, min) { return "Пожалуйста, введите еще хотя бы" + character(min - input.length); },
	$.fn.select2.defaults.formatInputTooLong = function (input, max) { return "Пожалуйста, введите на" + character(input.length - max) + " меньше"; },
	$.fn.select2.defaults.formatSelectionTooBig = function (limit) { return "Вы можете выбрать не более " + limit + " элемент" + (limit%10 == 1 && limit%100 != 11 ? "а" : "ов"); },
	$.fn.select2.defaults.formatLoadMore = function (pageNumber) { return "Загрузка данных…"; },
	$.fn.select2.defaults.formatSearching = function () { return "Поиск…"; }

	function character (n) {
		return " " + n + " символ" + (n%10 < 5 && n%10 > 0 && (n%100 < 5 || n%100 > 20) ? n%10 > 1 ? "a" : "" : "ов");
	}

	// Select 2 get ajax data
	$('#select-your-city, #billing_state_field').select2({
		placeholder: 'Выберите город',
		placeholderOption: 'first',
		width: '100%',
		ajax: {
			url: wc_params.api_url,
			method: 'POST',
			dataType: "jsonp",
			delay: 250,
			data: function(params) {
				return {
					q: params,
					name_startsWith: params,
					countryCodeList: function() {
						return [wc_params.default_country] }
				};
			},
			processResults: function(data) {
				return {
					results: $.map(data.geonames, function(item) {
						if (!item || item.countryIso == null || item.countryIso !== wc_params.default_country) return;
						return {
							id: item.name,
							city_id: item.id,
							city_name: item.cityName,
							text: item.cityName
						}
					})
				};
			},
			cache: true
		},
		minimumInputLength: 1,
		initSelection: function (element, callback) {
			callback({
				'id': element.val(),
				'text': element.val()
			});
		},
		formatSelection: function(data) {
			return data.text;
		},
	}).on('select2-selecting', function(event) {
		var yourCity = event.object.text;
		var yourCityFullName = event.object.id;
		var yourCityId = event.object.city_id;

		if($('#billing_state').length > 0){
			$('#billing_city').attr('value', yourCity).change();
			$('.select2-selection__placeholder').text(yourCityFullName);
			$('#billing_state').attr('value', yourCityFullName);
			$('#billing_state_id').attr('value', yourCityId);

			$('#select2-chosen-1').text(yourCityFullName);
			$('input[name="billing_state"]').val(yourCityFullName);
			$('input[name="billing_city"]').val(yourCityFullName);
		}

		deleteCookie('city');
		//setCookie('city', yourCity, 365);

		deleteCookie('city_id');
		setCookie('city_id', yourCityId, 365);

		deleteCookie('delivery_point');

		var data = {
			'action': 'ajax_city',
			'city': yourCity
		};
		$.post(fotooboi_ajax.url, data, function(response) {
			$('#your-city, #select-city').text(response);
		});


		$.ajax({
			url: fotooboi_ajax.url,
			data: {
				action: 'ajax_pvz'
			},
			success: function(data){
				$('#delivery-point').text(data);
			}
		});
	});


	// Update pvz select and yandex map
	if ( $('#billing_delivery_point option').length > 0 && $().select2 ) {
		$( '#billing_delivery_point_field' ).find( '.select2-container' ).remove();
		$('div#edostavka_map').empty();
		delivery_point_select2();
		delivery_points_map();
	}


	$(document.body).on("adding_to_cart", function() {
		var oldCnt = $(".cart-cnt").text();
		$(".cart-cnt").text(+oldCnt + 1);
	});


	// Update cart
	$(document).on("click",".quantity-button", function (e) {
		$( ".shop_table.cart .button" ).click(function() {
			$('input[name="update_cart"]' ).removeProp( 'disabled');
		});

		setTimeout((function(){
			$('.shop_table.cart .button').trigger('click')
		}), 100);
	});

	// Like btn product
	if($('div[id^=wpm-like]').length > 0) {

		$.each($('div[id^=wpm-like]'), function(idx, element) {
			var selfBtn = $(element).find('.js-add-like');
			var categ_id = selfBtn.data('id');

			$.ajax({
				type: "POST",
				data: {
					action: 'get_product_like',
					categ_id: categ_id,
				},
				url: fotooboi_ajax.url,
				beforeSend: function() {
					selfBtn.html('<span class="alax-loader"></span>');
				},
				success: function(data) {
					if (data) {
						selfBtn.html('Отменить голос');
						selfBtn.removeClass('add').addClass('added');
					} else {
						selfBtn.html('Нравится этот товар');
						selfBtn.removeClass('added').addClass('add');
					}
				}
			});
		});
		$('.js-add-like').on('click', function (e) {
			e.preventDefault();
			var categ_id = $(this).data('id');
			var selfBtn = $(this);

			$.ajax({
				type: "POST",
				data: {
					action: 'switch_product_like',
					categ_id: categ_id,
				},
				url: fotooboi_ajax.url,
				beforeSend: function() {
					selfBtn.html('<span class="alax-loader"></span>');
				},
				success: function(data) {
					if (data) {
						if (selfBtn.is('.added')) {
							selfBtn.removeClass('added').addClass('add').html('Нравится этот товар');
						} else {
							selfBtn.removeClass('add').addClass('added').html('Отменить голос');
						}
						selfBtn.siblings('.count-box').text(data);
					}
				}
			});
		});
	}


	//VC Composer
	$('.red-feature-box').matchHeight();
	$('body.archive.tax-product_cat .product__item').matchHeight();

	$('.js-testimonial-gallery').each(function() { // the containers for all your galleries
	    $(this).magnificPopup({
	        type: 'image',
	        tLoading: 'Загрузка #%curr%...',
	        mainClass: 'mfp-img-mobile',
	        delegate: 'a',
	        gallery: {
	            enabled: true,
	            navigateByImgClick: true,
	            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
	        },
	        image: {
	            tError: '<a href="%url%">Изображение #%curr%</a> не может быть загружено.',
	        }
	    });
	});

    $('.js-work').magnificPopup({
        type: 'image',
        tLoading: 'Загрузка #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">Изображение #%curr%</a> не может быть загружено.',
        }
    });

}); // end jQuery document.ready

jQuery(document).ready(function(){
	var headerCity = $.trim($('#select-city').text());
	$('#select2-chosen-1').text(headerCity);
	$('input[name="billing_state"]').val(headerCity);
	$('input[name="billing_city"]').val(headerCity);
	$('#select2-chosen-1').text(headerCity);

	$('.choice-color__buttons_reset-all').click(function (e) {
		e.preventDefault();
		$('input:checked').prop('checked', false);
	});

	$('.current-cat__pseudo').on('click', function(e) {
		e.stopPropagation();
		e.preventDefault();

		if($(this).parents('.cat-item').find('.child-cats').length > 0 ) {
			$(this).parents('.cat-item').find('.child-cats').stop().slideToggle();
		}
	});

	if ($('.current-cat').children('.child-cats')) {
		$('.current-cat__pseudo').addClass('current-cat__pseudo_visible')
	};
});

jQuery(window).on('load', function(){
	$('.product__item').each(function(){
		var $this = $(this);
		var itemWidth = $this.width();
		if(itemWidth > 350) {
			$this.addClass('_type_horizontal');
		}
	});
});
