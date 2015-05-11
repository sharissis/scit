/******************************************************
*
*	Shortcode generator
*
******************************************************/
jQuery(function(){
	jQuery('#camera_all_meta').each(function(){
		var t = jQuery(this);
		jQuery('input.button',t).mousedown(function(){
			var c = jQuery('select option:selected',t).val();
			jQuery('input[type="hidden"]',t).val('[camera slideshow="'+c+'"]');
		});
	});	

	tinymce.create('tinymce.plugins.AddCameraSc', {
		init : function(ed, url) {

			ed.addButton('camera_slideshow_sc', {
				title : 'Camera shortcode',
				image : plugindir+'/css/images/shortcode_button.png',
				onclick : function() {
					var t = jQuery("#camera_all_meta");
					t.dialog({
						height: 250,
						width: 500,
						modal: true,
						dialogClass: 'wp-dialog',
						title: 'Camera shortcode generator',
						zIndex: 50
					});
					jQuery('.button',t).one('click',function(){
						t.dialog('close');
						var sC = jQuery('input[type="hidden"]',t).val();
						tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sC);
					});
				}
			});

		}

	});
	
    tinymce.PluginManager.add('camera_slideshow_sc', tinymce.plugins.AddCameraSc);
	
	
	jQuery('#camera_all_meta-hide').parents('label').remove();
	jQuery('#camera_all_meta .handlediv, #camera_all_meta .hndle').remove();

});

