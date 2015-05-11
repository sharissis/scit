jQuery(document).ready(function(){


	/////////////////////////////////////// Remove "|" from item options ///////////////////////////////////////

	
	jQuery('.item-options').contents().filter(function() {
		return this.nodeType == 3;
	}).remove();


	/////////////////////////////////////// Moved messages on activity stream ///////////////////////////////////////


	jQuery('body.activity-permalink #message').prependTo('#activity-stream');

	
});	