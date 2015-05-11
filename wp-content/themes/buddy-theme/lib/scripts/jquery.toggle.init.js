jQuery(".toggle-box").hide(); 
jQuery(".toggle").toggle(
	function(){
		jQuery(this).find("i").addClass("icon-minus-sign").removeClass("icon-plus-sign");
	},
	function() {
		jQuery(this).find("i").removeClass("icon-minus-sign").addClass("icon-plus-sign");
	}
);
jQuery(".toggle").click(function(){
	jQuery(this).next(".toggle-box").slideToggle();
});