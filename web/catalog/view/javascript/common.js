function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

$(document).ready(function() {


	// increase number of product
	 function minus(){
	   if(document.getElementById('input-quantity').value <= 0) {
	  return false;
	   }
		document.getElementById('input-quantity').value --;
	 }
	// decrease of product
	 function plus(){
	   document.getElementById('input-quantity').value ++;
	 }
	 $('#minus').click(function(){
	  minus();
	 });
	 $('#plus').click(function(){
	  plus();
	 });
	 
	 
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
		
	// Currency
	$('#currency .currency-select').on('click', function(e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

		$('#currency').submit();
	});
	// slider
         if($().owlCarousel) {
		$(".image-additional").owlCarousel({
			navigation:true,
			pagination: false,
			slideSpeed : 500,
			goToFirstSpeed : 1500,
			autoHeight : true,
			items :4, //10 items above 1000px browser width
			itemsDesktop : [1000,4], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,4], // betweem 900px and 601px
			itemsTablet: [600,2], //2 items between 600 and 0
			itemsMobile : [480,2] // itemsMobile disabled - inherit from itemsTablet option
		  });
		  //related products
                  
		  $(".view-related").owlCarousel({
			navigation:true,
			pagination: false,
			slideSpeed : 500,
			goToFirstSpeed : 1500,
			autoHeight : false,
			items : 3, //10 items above 1000px browser width
			itemsDesktop : [1000,2], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,2], // betweem 900px and 601px
			itemsTablet: [600,2], //2 items between 600 and 0
			itemsMobile : [480,1] // itemsMobile disabled - inherit from itemsTablet option
		  });
            }

	// Language
	$('#language a').on('click', function(e) {
		e.preventDefault();

		$('#language input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#language').submit();
	});

	/* Search */
	$('#search input[name=\'search\']').parent().find('button').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('header input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('header input[name=\'search\']').parent().find('button').trigger('click');
		}
	});

	// Menu
	$('#menu .dropdown-menu').each(function() {
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();

		var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});
	// click grid/list
	$(document).on('click', '#grid-view', function(e){
		e.preventDefault();
		display('grid');
	});

	$(document).on('click', '#list-view', function(e){
		e.preventDefault();
		display('list');
	});
	// Product List
function display(view) {
	if (view == 'list') {
		$('#content .row > div.clearfix').remove();
		
		$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
		$('.product-list > div').each(function(index, element) {
			html = '<div class="row">';
			html += '<div class="col-xs-12 col-sm-4 col-md-4">';
			html += '<div class="box-left">';
			html += '<div class="left-block">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="zoom-in">';
				html += '<div class="button-group">';
				html += $(element).find('.button-group').html() ;
				html +='</div>';
			html +='</div>';
			html += '</div>';
			html += '</div>';
			html += '<div class="right-block col-xs-12 col-sm-8 col-md-8"><div class="caption">';
				html += '<div class="name">' + $(element).find('.name').html() + '</div>';
				var price = $(element).find('.price').html();
				if (price != null) {
					html += '<p class="price">' + price  + '</p>';
				}
				var rating = $(element).find('.rating').html();
				if (rating != null) {
					html += '<div class="rating">' + rating + '</div>';
				}
				html += ' <p class="description">' + $(element).find('.description').html() + '</p>';
			html += '</div></div>';
			$(element).html(html);
		
		});
		localStorage.setItem('display', 'list');
		$('.btn-group').find('#list-view').addClass('selected');
		$('.btn-group').find('#grid-view').removeClass('selected');
		
	} else {
		$('#content .row > .clearfix').remove();
		
		
		
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-6 col-mobile');

			$('#content .product-layout:nth-child(2n)').after('<div class="clearfix"></div>');
		} else if (cols == 1) {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mobile');

			$('#content .product-layout:nth-child(3n)').after('<div class="clearfix"></div>');
		} else {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-6 col-mobile');

			$('#content .product-layout:nth-child(4n)').after('<div class="clearfix"></div>');
		}

		$('.product-grid > div').each(function(index, element) {
			html = '<div class="item-inner">';
			html += '<div class="left-block">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="right-block"><div class="caption">';
				html += '<div class="name">' + $(element).find('.name').html() + '</div>';
				var price = $(element).find('.price').html();
				if (price != null) {
					html += '<p class="price">' + price  + '</p>';
				}
				html += '<div class="item-container">'
					html += '<div class="item-description" onclick="javascript:location.href=\'' + $(element).find('.name a').attr("href") + '\'">';
						html += '<div class="name">' + $(element).find('.name').html() + '</div>';
						var price = $(element).find('.price').html();
						if (price != null) {
						html += '<p class="price">' + price  + '</p>';
						}
						html += ' <p class="description">' + $(element).find('.description').html() + '</p>';
						var rating = $(element).find('.rating').html();
						if (rating != null) {
							html += '<div class="rating">' + rating + '</div>';
						}
						html += '<div class="actions"><div class="button-group">' +$(element).find('.button-group').html() + '</div></div>';
					+'</div>';
				+'</div>';
			html += '</div></div></div>';
			$(element).html(html);
		});
		
		 localStorage.setItem('display', 'grid');
		 $('.btn-group').find('#grid-view').addClass('selected');
		 $('.btn-group').find('#list-view').removeClass('selected');
	}
}

	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
	

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});

    // hide #back-top first
    $("#back-top").hide();
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

    $(function() {

        function e() {
            n.attr("href", "#page").addClass("hamburger--collapse is-active");
        }

        function t() {
            n.attr("href", "#menu").removeClass("hamburger--arrow is-active").addClass("hamburger--collapse");
        }

        if ($.fn.mmenu) {
            var a = $('nav#menu').mmenu({
                    navbar: {
                        title: 'Меню',
                        drag 		: true,
                    }
                }, {
					offCanvas: {pageSelector: '#page'},
					searchfield: {clear: !0}
				}).data('mmenu'),
                n = $("#hamburger").children(".hamburger");
            a.bind('close:finish', function () {
                setTimeout(t, 0);
            }),
			a.bind('open:start', function () {
				$('nav#menu').css('opacity', 1);
			}),
			a.bind('open:finish', function () {
                setTimeout(e, 0);
            });
        }
    });


	$('.popup-gallery').magnificPopup({
		type: 'ajax'
	});

    $('.popup-gallery').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

});

// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();

				$('#cart > button').button('reset');

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#cart-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('#cart > button').button('reset');

				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			success: function(json) {
				$('#cart > button').button('reset');

				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				$('#cart-total').html(json['total']);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['info']) {
					$('#content').parent().before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				$('#wishlist-total').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		});
	},
	'remove': function() {

	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			}
		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

/* Autocomplete */
(function($) {
	function Autocomplete(element, options) {
		this.element = element;
		this.options = options;
		this.timer = null;
		this.items = new Array();

		$(element).attr('autocomplete', 'off');
		$(element).on('focus', $.proxy(this.focus, this));
		$(element).on('blur', $.proxy(this.blur, this));
		$(element).on('keydown', $.proxy(this.keydown, this));

		$(element).after('<ul class="dropdown-menu"></ul>');
		$(element).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));
	}

	Autocomplete.prototype = {
		focus: function() {
			this.request();
		},
		blur: function() {
			setTimeout(function(object) {
				object.hide();
			}, 200, this);
		},
		click: function(event) {
			event.preventDefault();

			value = $(event.target).parent().attr('data-value');

			if (value && this.items[value]) {
				this.options.select(this.items[value]);
			}
		},
		keydown: function(event) {
			switch(event.keyCode) {
				case 27: // escape
					this.hide();
					break;
				default:
					this.request();
					break;
			}
		},
		show: function() {
			var pos = $(this.element).position();

			$(this.element).siblings('ul.dropdown-menu').css({
				top: pos.top + $(this.element).outerHeight(),
				left: pos.left
			});

			$(this.element).siblings('ul.dropdown-menu').show();
		},
		hide: function() {
			$(this.element).siblings('ul.dropdown-menu').hide();
		},
		request: function() {
			clearTimeout(this.timer);

			this.timer = setTimeout(function(object) {
				object.options.source($(object.element).val(), $.proxy(object.response, object));
			}, 200, this);
		},
		response: function(json) {
			html = '';

			if (json.length) {
				for (i = 0; i < json.length; i++) {
					this.items[json[i]['value']] = json[i];
				}

				for (i = 0; i < json.length; i++) {
					if (!json[i]['category']) {
						html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
					}
				}

				// Get all the ones with a categories
				var category = new Array();

				for (i = 0; i < json.length; i++) {
					if (json[i]['category']) {
						if (!category[json[i]['category']]) {
							category[json[i]['category']] = new Array();
							category[json[i]['category']]['name'] = json[i]['category'];
							category[json[i]['category']]['item'] = new Array();
						}

						category[json[i]['category']]['item'].push(json[i]);
					}
				}

				for (i in category) {
					html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

					for (j = 0; j < category[i]['item'].length; j++) {
						html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
					}
				}
			}

			if (html) {
				this.show();
			} else {
				this.hide();
			}

			$(this.element).siblings('ul.dropdown-menu').html(html);
		}
	};

	$.fn.autocomplete = function(option) {
		return this.each(function() {
			var data = $(this).data('autocomplete');

			if (!data) {
				data = new Autocomplete(this, option);

				$(this).data('autocomplete', data);
			}
		});
	}
        
         // function to set the height on fly
/* function autoHeight() {
   $('.text-container').css('min-height', 0);
   $('.text-container').css('min-height', (
     $(document).height() - $('header').outerHeight() - $('#pt_custommenu').outerHeight() - $('.footer').outerHeight() - $('.powered').outerHeight()
   ));
 }*/

 // onDocumentReady function bind

   //autoHeight();


 // onResize bind of the function
/* $(window).resize(function() {
   autoHeight();
 })
 */
})(window.jQuery);

