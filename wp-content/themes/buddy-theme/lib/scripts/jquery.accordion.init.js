jQuery(".accordion").accordion({header: "h3.accordion-title"});
jQuery("h3.accordion-title").toggle(
	function(){
		jQuery(this).find("i").addClass("icon-circle-arrow-up").removeClass("icon-circle-arrow-down");
	},
	function() {
		jQuery(this).find("i").removeClass("icon-circle-arrow-up").addClass("icon-circle-arrow-down");
	}
);