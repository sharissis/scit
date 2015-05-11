/////////////////////////////////////// Image Preloader ///////////////////////////////////////


jQuery(function () {
	jQuery('.preload').hide();
});

var i = 0;
var int=0;
jQuery(window).bind("load", function() {
	var int = setInterval("doThis(i)",100);
});

function doThis() {
	var images = jQuery('.preload').length;
	if (i >= images) {
		clearInterval(int);
	}
	jQuery('.preload:hidden').eq(0).fadeIn(400);
	i++;
}


/////////////////////////////////////// Document Ready ///////////////////////////////////////


jQuery(document).ready(function(){

	"use strict";


	/////////////////////////////////////// Mobile Navigation Menu ///////////////////////////////////////


	jQuery("<option />", {"selected": "selected", "value": "", "text": navigationText}).prependTo("#nav select");
        	
	jQuery("#nav select").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});
	

	/////////////////////////////////////// Lightbox ///////////////////////////////////////


	jQuery("div.gallery-item .gallery-icon a").prepend('<span class="lightbox-hover icon-plus"></span>').attr("rel", "prettyPhoto[gallery]").width(jQuery(this).find('.attachment-thumbnail').width());
		
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		deeplinking: false,
		social_tools: ''
	});



	/////////////////////////////////////// Image Hover ///////////////////////////////////////


	jQuery('.lightbox-hover').css({'opacity':'0'});
	jQuery("a[rel^='prettyPhoto']").hover(
		function() {
			jQuery(this).find('.lightbox-hover').stop().fadeTo(750, 1);
		},
		function() {
			jQuery(this).find('.lightbox-hover').stop().fadeTo(750, 0);
		}
	);


	/////////////////////////////////////// Back To Top ///////////////////////////////////////


	jQuery().UItoTop({ 
		text: '<i class="icon-chevron-up"></i>',
		scrollSpeed: 600
	});


	/////////////////////////////////////// Prevent Empty Search - Thomas Scholz http://toscho.de ///////////////////////////////////////


	(function($) {
		$.fn.preventEmptySubmit = function(options) {
			var settings = {
				inputselector: "#searchbar",
				msg          : emptySearchText
			};
			if (options) {
				$.extend(settings, options);
			}
			this.submit(function() {
				var s = $(this).find(settings.inputselector);
				if(!s.val()) {
					alert(settings.msg);
					s.focus();
					return false;
				}
				return true;
			});
			return this;
		};
	})(jQuery);

	jQuery('#searchform').preventEmptySubmit();


});


/////////////////////////////////////// Window Loaded ///////////////////////////////////////


jQuery(window).load(function(){

	"use strict";
	
	/////////////////////////////////////// Display Page ///////////////////////////////////////
	
	
	jQuery('#content-wrapper').css('visibility', 'visible');
	
	
	/////////////////////////////////////// Navigation Menu Positioning ///////////////////////////////////////


	gpNavPos();

	jQuery(window).resize(function() {
		gpNavPos();
	});
	
	function gpNavPos() {	
		jQuery("#nav > ul > li").each(function() {
			var navPos = jQuery(this).offset();
			if(navPos.left + 200 > jQuery(window).width()+document.body.scrollLeft-200) {
				jQuery(this).addClass("left-nav");
			} else {
				jQuery(this).removeClass("left-nav");
			}
		});	
	}	
	
			
});