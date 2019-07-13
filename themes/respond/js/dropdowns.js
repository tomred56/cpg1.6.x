(function($){
	$.fn.dropdowns = function (opts) {

		var defaults = { toggleWidth: 768 };

		var options = $.extend(defaults, opts);

		var ww = window.innerWidth,
			timo = false,
			dly = 50;

		var addParents = function() {
			$(".nav li a").each(function() {
				if ($(this).next().length > 0) {
					$(this).addClass("parent");
				}
			});
		};

		var adjustMenu = function() {
			if (ww < options.toggleWidth) {
				$(".toggleMenu").css("display", "inline-block");
				if (!$(".toggleMenu").hasClass("active")) {
					$(".nav").hide();
				} else {
					$(".nav").show();
				}
				$(".nav li").unbind('mouseenter mouseleave');
				$(".nav li a.parent").unbind('click').bind('click', function(e) {
					// must be attached to anchor element to prevent bubbling
					e.preventDefault();
					$(this).parent("li").siblings().removeClass("hover");
					$(this).parent("li").toggleClass("hover");
				});
			}
			else if (ww >= options.toggleWidth) {
				$(".toggleMenu").css("display", "none");
				$(".nav").show();
				$(".nav li").removeClass("hover");
				$(".nav li a").unbind('click');
				$(".nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
					// must be attached to li so that mouseleave is not triggered when hover over submenu
					$(this).toggleClass('hover');
				});
			}
		};

		return this.each(function() {
			$(".toggleMenu").click(function(e) {
				e.preventDefault();
				$(this).toggleClass("active");
				$(this).next(".nav").toggle();
				adjustMenu();
			});
			adjustMenu();
			addParents();
			$(window).bind('resize orientationchange', function() {
				clearTimeout(timo);
				timo = setTimeout(function(){
					ww = window.innerWidth;
					adjustMenu();
				}, dly);
			});
		});

	};
})(jQuery);
