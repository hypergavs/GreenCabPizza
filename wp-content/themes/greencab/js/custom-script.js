// JavaScript Document
$(document).ready(function(e) {
    $(".menu-item-has-children").hover(function(){
		$(".sub-menu", this).stop(true, true).delay(10).slideDown();
	}, function(){
		$(".sub-menu", this).stop(true, true).delay(10).slideUp();
	});
	
	function validation(regex, string){
		var validate = string.match(regex);
		if(validate == null){
			return false;	
		}else{
			return true;	
		}
	}
	
	$(".menu-item-17, .sometext-and-btn a").click(function(e){
		e.preventDefault();
		$("#cab-locator-form input[type=text]").focus();
	});
	
	function notif(state, msg){		
		$(".notif").addClass(state).text(msg).show();
	}
	
	function locate_error(selector){
		$(selector).parent("div").addClass("has-error");
		//grecaptcha.reset();
		//$(selector).attr("id", "inputError2");	
	}
	
	var login_form = $("#form-login");
	login_form.submit(function(e){
		e.preventDefault();
			verify_to = $(this).attr("action") + "process.php";
			$.post(verify_to, $(this).serialize(), function(data){
				if(data=='OK'){
					var authen_to = $("#form-login").attr("action") + "/verify-login.php";
					$.post(authen_to,{ authen: "gmpass"},function(data){
						if(data=='OK'){
							window.location.href = "http://127.0.0.1/greencab/userdash";
						}
					});
				}else{
					notif("alert", data);
				}
			});
	});
	
	
});

	



(function($) {  
	$.fn.verticalCarousel = function(options) {  

		var carouselContainerClass = "vc_container";
		var carouselGroupClass = "vc_list";
		var carouselGoUpClass = "vc_goUp";
		var carouselGoDownClass = "vc_goDown";
  
		var defaults = { currentItem: 1, showItems: 1 };
		var options = $.extend(defaults, options);

		var carouselContainer;
		var carouselGroup;
		var carouselUp;
		var carouselDown;
		var totalItems;

		var setContainerHeight = (function(){
			var containerHeight = 0;
			var marginTop = 0;
			if (options.showItems == 1){
				containerHeight = $("> :nth-child(" + options.currentItem + ")", carouselGroup).outerHeight(true);
			}
			else{
				for (i = 1; i <= options.showItems; i++) {
				    containerHeight = containerHeight + $("> :nth-child(" + i + ")", carouselGroup).outerHeight(true);
				}
			}
			var nextItem = options.showItems + options.currentItem;
			marginTop = $("> :nth-child(" + nextItem + ")", carouselGroup).css("marginTop");
			containerHeight = containerHeight - parseInt(marginTop);
			$(carouselContainer).css("height", containerHeight);
		});

		var setOffset = (function(){
			var currentItemOffset = $("> :nth-child(" + options.currentItem + ")", carouselGroup).offset();
			var carouselGroupOffset = $(carouselGroup).offset();
			var offsetDiff = carouselGroupOffset.top - currentItemOffset.top;
			$(carouselGroup).css({
				"-ms-transform": "translateY(" + offsetDiff + "px)",
				"-webkit-transform": "translateY(" + offsetDiff + "px)",
				"transform": "translateY(" + offsetDiff + "px)"
			})
		});

		var updateNavigation = (function(direction){
			if (options.currentItem == 1){
				$(carouselUp).addClass("isDisabled");
			}
			else if (options.currentItem > 1){
				$(carouselUp).removeClass("isDisabled");
			}
			if(options.currentItem == totalItems || options.currentItem + options.showItems > totalItems){
				$(carouselDown).addClass("isDisabled");
			}
			else if (options.currentItem < totalItems){
				$(carouselDown).removeClass("isDisabled");
			}
		});

		var moveCarousel = (function(direction){
			if (direction == "up"){
				options.currentItem = options.currentItem - 1;
			}
			if (direction == "down"){
				options.currentItem = options.currentItem + 1;
			}
			updateNavigation();
			setContainerHeight();
			setOffset();
		});
		
		return this.each(function() {
			$(this).find("." + carouselGroupClass).wrap('<div class="' + carouselContainerClass + '"></div>');
			carouselContainer = $(this).find("." + carouselContainerClass);
			carouselGroup = $(this).find("." + carouselGroupClass);
			carouselUp = $(this).find("." + carouselGoUpClass);
			carouselDown = $(this).find("." + carouselGoDownClass);
			totalItems = $(carouselGroup).children().length;
			updateNavigation()
			setContainerHeight();
			setOffset();
			$(carouselUp).on("click", function(e){
				if (options.currentItem > 1){
					moveCarousel("up");
				}
				e.preventDefault();
			});
			$(carouselDown).on("click", function(e){
				if (options.currentItem + options.showItems <= totalItems){
					moveCarousel("down");
				}
				e.preventDefault();
			});
		});

	};  
})(jQuery);