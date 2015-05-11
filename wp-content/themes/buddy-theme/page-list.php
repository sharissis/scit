<?php
/*
Template Name: Page List
*/
get_header(); global $gp_settings; ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	
	<!-- BEGIN CONTENT -->
	
	<div id="content">
			
		
		<!-- BEGIN IMAGE -->
					
		<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?>	
			<div class="post-thumbnail single-thumbnail">
				<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width'], $gp_settings['image_height'], $gp_settings['hard_crop'], false, true); ?>
				<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width']*2, $gp_settings['image_height']*2, $gp_settings['hard_crop'], false, true); } else { $retina = ""; } ?>
				<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />				
			</div>					
		<?php } ?>
		
		<!-- END IMAGE -->
		
		
		<!-- BEGIN PADDER -->
							
		<div class="padder<?php if(has_post_thumbnail() && $gp_settings['show_image'] == "Show") { ?> content-post-thumbnail<?php } ?>">


			<!-- BEGIN TITLE -->

			<?php if($gp_settings['title'] == "Show") { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>

			<!-- END TITLE -->
			

			<!-- BEGIN IMAGE -->
	
			<?php if(has_post_thumbnail() && $gp_settings['image_wrap'] == "Enable" && $gp_settings['show_image'] == "Show") { ?>
				<div class="post-thumbnail wrap">
					<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width'], $gp_settings['image_height'], $gp_settings['hard_crop'], false, true); ?>
					<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width']*2, $gp_settings['image_height']*2, $gp_settings['hard_crop'], false, true); } else { $retina = ""; } ?>
					<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />		
				</div>
			<?php } ?>
			
			<!-- END IMAGE -->
					
								
			<!-- BEGIN PAGE LIST -->
									
			<?php $children = wp_list_pages('depth=1&title_li=&child_of='.$post->ID.'&echo=0'); if($children) { ?>
			
				<ul class="page-list">
					<?php echo $children; ?>
				</ul>
				
			<?php } ?>
			
			<!-- END PAGE LIST -->
			
			
			<div class="clear"></div>
			
		
		</div>
		
		<!-- END PADDER -->
		
		
	</div>
	
	<!-- END CONTENT -->
	
	
<?php endwhile; endif; ?>


<?php get_footer(); ?>