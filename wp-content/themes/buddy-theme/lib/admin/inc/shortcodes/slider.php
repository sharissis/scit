<?php 

//////////////////////////////////////// Slider ////////////////////////////////////////

function gp_slider($atts, $content = null) {
    extract(shortcode_atts(array(
		'content' => 'slide',
		'cats' => '',
		'ids' => '',
        'width' => '670',
        'height' => '280',
        'hard_crop' => 'false',
        'cats' => '',
        'slides' => '-1',
        'effect' => 'fade',
        'timeout' => '6',
        'orderby' => 'menu_order',
        'order' => 'asc',
        'buttons' => 'true',
        'shadow' => 'false',
        'content_display' => 'excerpt',
        'excerpt_length' => '0',
        'title' => 'true',       
        'title_length' => '40',        
		'margins' => '',
        'align' => 'aligncenter',
        'preload' => 'false'
    ), $atts));

	require(gp_inc . 'options.php'); global $post, $is_IE, $is_gecko, $gp_settings, $dirname;
	

	// Unique Name
	
	STATIC $i = 0;
	$i++;
	$name = 'slider'.$i;
	
	
	// Load Scripts

	if($i == 1) {
		wp_enqueue_script('gp-flexslider');
		wp_enqueue_script('gp-touchswipe');
	}
		
	// Categories
	
	if($cats) { 
		$slide_cats = array('taxonomy' => 'slide_categories', 'terms' => explode(',', $cats), 'field' => 'id');
		$post_cats = array('taxonomy' => 'category', 'terms' => explode(',', $cats), 'field' => 'id');
	} else {
		$slide_cats = null;
		$post_cats = null;
	}
	

	// IDs
	
	if($ids) { 
		$ids = explode(',', $ids);
	} else {
		$ids = null;
	}


	// Shadow
	
	if($shadow == "true") {
		$shadow = " shadow";
	} else {
		$shadow = "";
	}
	
	
	// Margins
	
	if($margins != "") {
		if(preg_match('/%/', $margins) OR preg_match('/em/', $margins) OR preg_match('/px/', $margins)) {
			$margins = str_replace(",", " ", $margins);
			$margins = 'margin: '.$margins.'; ';	
		} else {
			$margins = str_replace(",", "px ", $margins);
			$margins = 'margin: '.$margins.'px; ';		
		}
		$margins = str_replace("autopx", "auto", $margins);
	} else {
		$margins = "";
	}
	
	
	// Preload
	
	if($preload == "true") {
		$preload = " preload";
	} else {
		$preload = "";
	}
	
	
	// Slider Query	
	
	$args=array(
	'post_type' => explode(',', $content),
	'posts_per_page' => $slides,
	'post__in' => $ids,
	'ignore_sticky_posts' => 0,
	'orderby' => $orderby,
	'order' => $order,
	'tax_query' => array('relation' => 'OR', $slide_cats, $post_cats)
	);
	
	$featured_query = new wp_query($args);
	
	ob_start(); ?>
	
	
	<?php if ($featured_query->have_posts()) : $slide_counter = ""; ?>
	
	
	<!-- BEGIN SLIDER WRAPPER -->	
	
	<div id="<?php echo $name; ?>" class="flexslider <?php echo $align; ?><?php echo $shadow; ?><?php echo $preload; ?>" style="width: <?php echo $width; ?>px; <?php echo $margins; ?>">
		
		
		<!-- BEGIN SLIDER -->	
		
		<ul class="slides">


			<?php while ($featured_query->have_posts()) : $featured_query->the_post(); $slide_counter++;
			
			
			// Video Type
			
			$vimeo = strpos(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true),"vimeo.com");
			$yt1 = strpos(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true),"youtube.com");
			$yt2 = strpos(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true),"youtu.be"); 
												
			?>


				<li class="slide<?php if($slide_counter != "1") {} elseif(get_post_meta($post->ID, '_'.$dirname.'_slide_autostart_video', true)) { ?> video-autostart<?php } ?>" id="<?php echo $name; ?>-slide-<?php the_ID(); ?>">
					
					
					<!-- BEGIN CAPTION -->	
					
					<?php if((!get_post_meta($post->ID, '_'.$dirname.'_slide_title', true) && $title == "true") OR get_post_meta($post->ID, '_'.$dirname.'_slide_caption_link_text', true) OR ($post->post_content && $excerpt_length != "0")) { ?>
						
						<div class="caption <?php if(get_post_meta($post->ID, '_'.$dirname.'_slide_caption_position', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_slide_caption_position', true); } else { echo "caption-bottomright"; } ?>">
						
							
							<!-- BEGIN SLIDE TITLE -->
							
							<?php if(!get_post_meta($post->ID, '_'.$dirname.'_slide_title', true) && $title == "true") { ?><h2><?php echo the_title_limit($title_length); ?></h2><?php } ?>
											
							<!-- END SLIDER TITLE -->
							
				
							<!-- BEGIN POST CONTENT -->
							
							<?php if($content_display == "full") { ?>	
							
								<?php global $more; $more = 0; the_content('&raquo;'); ?>
								
							<?php } else { ?>
							
								<?php if($excerpt_length != "0") { ?><p><?php echo excerpt($excerpt_length); ?></p><?php } ?>
								
							<?php } ?>
							
							<!-- END POST CONTENT -->
							
							
						</div>
					
					<?php } ?>
					
					<!-- END CAPTION -->	
					
					
					<!-- BEGIN CONTENT -->	
					
					<?php if(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true) OR get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true) OR get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true)) { ?>

						
						<!-- VIDEO IMAGE-->
									
						<?php if(wp_is_mobile()) { ?><a href="file=<?php if($is_gecko && get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true); } elseif(get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, '_'.$dirname.'_slide_video', true); } ?>" rel="prettyPhoto"><?php } ?>
								
							<div class="video-image">
						
								<div class="video-button"></div>
							
								<?php if(has_post_thumbnail()) { ?>
									<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width, $height, $hard_crop, false, true); ?>
									<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width*2, $height*2, $hard_crop, false, true); } else { $retina = ""; } ?>
									<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />
								<?php } ?>
								
							</div>
						
						<?php if(wp_is_mobile()) { ?></a><?php } ?>
						
						<!-- END VIDEO IMAGE -->
						
						
						<!-- BEGIN VIDEO -->

						<?php if(!wp_is_mobile()) { ?>
				
							<?php if($vimeo) { ?>
						
						
								<!-- BEGIN VIMEO VIDEO -->
							
								<?php if(preg_match('/www.vimeo/', get_post_meta($post->ID, '_'.$dirname.'_slide_video', true))) {							
									$vimeoid = trim(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true),'http://www.vimeo.com/');
								} else {							
									$vimeoid = trim(get_post_meta($post->ID, '_'.$dirname.'_slide_video', true),'http://vimeo.com/');
								} ?>

								<div class="video-player">
						
									<iframe src="http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=<?php if($slide_counter != "1") { ?>0<?php } elseif(get_post_meta($post->ID, '_'.$dirname.'_slide_autostart_video', true)) { ?>1<?php } else { ?>0<?php } ?>" allowFullScreen></iframe>

								</div>

								<script>		
								jQuery(window).load(function() {
					
									// Play Vimeo Player
						
									jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function(){
									  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
									  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1'));
									  jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').show();
									});
						
									// Stop Vimeo Player
						
									jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function(){
									  var thePage = jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player");
									  thePage.html(thePage.html().replace('http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=1', 'http://player.vimeo.com/video/<?php echo $vimeoid; ?>?byline=0&amp;portrait=0&amp;autoplay=0'));
									  jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').hide();
									});
						
								});
								</script>
															
								<!-- END VIMEO VIDEO -->
														
							
							<?php } else { ?>								

								
								<!-- BEGIN JWPLAYER VIDEO -->
	
								<div class="video-player">
									<div id="<?php echo $name; ?>-player-<?php the_ID(); ?>" class="video-player"></div>															
								</div>
								
								<script>
								//<![CDATA[

								jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").setup({
									image: "<?php echo get_template_directory_uri(); ?>/lib/images/black.gif",
									icons: "true",
									autostart: "<?php if($slide_counter != '1') { ?>false<?php } elseif(get_post_meta($post->ID, '_'.$dirname.'_slide_autostart_video', true)) { ?>true<?php } else { ?>false<?php } ?>",
									stretching: "fill",
									controlbar: "<?php if(get_post_meta($post->ID, '_'.$dirname.'_slide_video_controls', true) == 'Over') { ?>over<?php } elseif(get_post_meta($post->ID, '_'.$dirname.'_slide_video_controls', true) == 'Bottom') { ?>bottom<?php } else { ?>none<?php } ?>",
									skin: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/fs39/fs39.xml",
									width: "100%",
									height: "<?php echo $height; ?>",
									screencolor: "000000",
									modes:
										[
										<?php if($is_IE OR get_post_meta($post->ID, '_'.$dirname.'_slide_video_priority', true) == 'Flash') { ?>
											{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, '_'.$dirname.'_slide_video', true); ?>"}},					
											{type: "html5", config: {file: "<?php if($is_gecko && get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true); } elseif(get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, '_'.$dirname.'_slide_video', true); } ?>"}}
										<?php } else { ?>
											{type: "html5", config: {file: "<?php if($is_gecko && get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_ogg_slide_video', true); } elseif(get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_webm_mp4_slide_video', true); } else { echo get_post_meta($post->ID, '_'.$dirname.'_slide_video', true); } ?>"}},
											{type: "flash", src: "<?php echo get_template_directory_uri(); ?>/lib/scripts/mediaplayer/player.swf", config: {file: "<?php echo get_post_meta($post->ID, '_'.$dirname.'_slide_video', true); ?>"}}
										<?php } ?>
										],
									plugins: {}
								});


								// Play JW Player
										
								jQuery(document).ready(function(){
									jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function() {
										jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').show();
										jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").play();
									});	
								});
						
						
								// Stop JW Player
						
								jQuery(window).load(function() {	
									jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function() {
										if(jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").getState() === "PLAYING") {
											jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-player').hide();
											jwplayer("<?php echo $name; ?>-player-<?php the_ID(); ?>").stop();
										}
									});
								});
								
														
								//]]>
								</script>
							
								<!-- END JWPLAYER VIDEO -->
						
						
							<?php } ?>

						<?php } ?>

						<!-- END VIDEO -->

							
						<?php if(!wp_is_mobile()) { ?>
						
							<script>
						
							jQuery(document).ready(function() {
						
								// Hide Video Image/Play Button

								jQuery("#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image").click(function() {
									jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .video-image').hide();
									jQuery('#<?php echo $name; ?>-slide-<?php the_ID(); ?> .caption').hide();
								});	

							});	
							
							</script>
								
						<?php } ?>	


					<?php } else { ?>
					
						
						<!-- BEGIN FEATURED IMAGE -->
							
						<?php if(has_post_thumbnail()) { ?>
						
							<?php if(get_post_meta($post->ID, '_'.$dirname.'_custom_url', true) OR get_post_meta($post->ID, '_'.$dirname.'_link_type', true) != "None") { ?>
							<a href="<?php if(get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Video") { ?>file=<?php echo get_post_meta($post->ID, '_'.$dirname.'_custom_url', true); } elseif(get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Image") { if(get_post_meta($post->ID, '_'.$dirname.'_custom_url', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_custom_url', true); } else { echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); }} else { if(get_post_meta($post->ID, '_'.$dirname.'_custom_url', true)) { echo get_post_meta($post->ID, '_'.$dirname.'_custom_url', true); } else { the_permalink(); }} ?>" title="<?php the_title(); ?>"<?php if(get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Image" OR get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Video") { ?> rel="prettyPhoto[<?php echo $name; the_ID(); ?>]"<?php } ?>>
							<?php } ?>
								
								<?php if(get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Image" OR get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Video") { ?><span class="lightbox-hover icon-plus"></span><?php } ?>							
																																																											
								<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width, $height, $hard_crop, false, true); ?>
								<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id($post->ID)), $width*2, $height*2, $hard_crop, false, true); } else { $retina = ""; } ?>
								<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />
									
							<?php if(get_post_meta($post->ID, '_'.$dirname.'_custom_url', true) OR  get_post_meta($post->ID, '_'.$dirname.'_link_type', true) != "None") { ?></a><?php } ?>	
					
						<?php } ?>
													
						<!-- END FEATURED IMAGE -->
						

						<!-- BEGIN LIGHTBOX IMAGES -->
				
						<?php if(get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Image" OR get_post_meta($post->ID, '_'.$dirname.'_link_type', true) == "Lightbox Video") { ?>

							<?php $args = array('post_type' => 'attachment', 'post_parent' => $post->ID, 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'asc', 'post__not_in'	=> array(get_post_thumbnail_id())); $attachments = get_children($args); if($attachments) { foreach ($attachments as $attachment) { ?>
				
								<a href="<?php if(get_post_meta($attachment->ID, '_'.$dirname.'_lightbox_url', true)) { ?>file=<?php echo get_post_meta($attachment->ID, '_'.$dirname.'_lightbox_url', true); } else { echo wp_get_attachment_url($attachment->ID); } ?>" rel="prettyPhoto[<?php echo $name; the_ID(); ?>]" title="<?php echo $attachment->post_content; ?>" style="display: none;"><img src="" alt="<?php echo $attachment->post_title; ?>"></a>
				
							<?php }} ?>
						
						<?php } ?>
										
						<!-- END LIGHTBOX IMAGES -->
						
							
					<?php } ?>
					
					<!-- END CONTENT -->
					

				</li>
				

			<?php endwhile; ?>
		
		
			</ul>
			
			<!-- END SLIDER -->	
			
		
		</div>
		
		<!-- END SLIDER WRAPPER -->	


	<?php endif; wp_reset_query(); ?>
		
		
	<script>
	jQuery(document).ready(function(){
		
		jQuery("#<?php echo $name; ?>.flexslider").flexslider({ 
			animation: "<?php echo $effect; ?>",
			slideshowSpeed: <?php if($timeout == 0) { echo "9999999"; } else { echo $timeout*1000; } ?>,
			animationDuration: 600,
			directionNav: false,			
			controlNav: <?php if($buttons == "true") { ?>true<?php } else { ?>false<?php } ?>,				
			pauseOnAction: true, 
			pauseOnHover: false,
			start: function(slider) {

				// Pause Slider
				jQuery("#<?php echo $name; ?> .flex-control-nav li a, #<?php echo $name; ?> .video-image").click(function() { 
					slider.pause(); 
				});
		
			}
			
		});	

					
		// Resize Video Player
	
		jQuery(window).load(function(){
			resizePlayer();
			jQuery(window).resize(function() {
				resizePlayer();
			});	
		});

		function resizePlayer() {
			parentContainer = jQuery("#<?php echo $name; ?> .slides").parent().attr('id');
			sliderWidth = jQuery('#'+parentContainer).width();
			newVideoWidth = sliderWidth;
			newVideoHeight = (sliderWidth * <?php echo $height; ?>) / <?php echo $width; ?>;
			jQuery("#<?php echo $name; ?>.flexslider .slides > li, #<?php echo $name; ?>.flexslider .video-image, #<?php echo $name; ?>.flexslider iframe, #<?php echo $name; ?>.flexslider video, #<?php echo $name; ?> .flexslider object, #<?php echo $name; ?>.flexslider embed").width(newVideoWidth).height(newVideoHeight);						
		}

								
		// Show All Video Images & Captions

		jQuery("#<?php echo $name; ?> .flex-control-nav li a").click(function() {
			jQuery('#<?php echo $name; ?> .video-image').show();
			jQuery('#<?php echo $name; ?> .video-player').hide();
			jQuery('#<?php echo $name; ?> .caption').show();
		});	
		
	});			
	</script>
	
	
<?php

	$output_string = ob_get_contents();
	ob_end_clean(); 
	
	return $output_string;

}
add_shortcode('slider', 'gp_slider');

?>