<?php global $gp_settings; ?>

<?php get_sidebar('left'); ?>


<!-- BEGIN CONTENT -->

<div id="content">


	<!-- BEGIN PADDER -->

	<div class="padder">


		<!-- BEGIN TITLE -->

		<?php if($gp_settings['title'] == "Show") { ?>
			<h1 class="page-title">
			<?php if(is_search()) { ?>
				<?php echo $wp_query->found_posts; ?> <?php _e('search results for', 'gp_lang'); ?> "<?php echo esc_html($s); ?>"
			<?php } elseif(is_category()) { ?>
				<?php single_cat_title(); ?>
			<?php } elseif(is_tag()) { ?>
				<?php single_tag_title(); ?>
			<?php } elseif(is_author()) { ?>
				<?php wp_title(''); ?>'s Posts
			<?php } elseif(is_archive()) { ?>
				<?php _e('Archives', 'gp_lang'); ?> <?php wp_title(' / '); ?>			
			<?php } ?>
			</h1>
		<?php } ?>
		
		<!-- END TITLE -->
		
		
		<!-- BEGIN POST WRAPPER -->
		
		<div class="post-wrapper">
			
			<?php if (have_posts()) : while (have_posts()) : the_post();
			
			// Image Dimensions
			
			if(get_post_meta($post->ID, $dirname.'_thumbnail_width', true) && get_post_meta($post->ID, $dirname.'_thumbnail_width', true) != "") {
				$image_width = get_post_meta($post->ID, $dirname.'_thumbnail_width', true);
			} else {
				$image_width = $gp_settings['thumbnail_width'];
			}
			if(get_post_meta($post->ID, $dirname.'_thumbnail_height', true) && get_post_meta($post->ID, $dirname.'_thumbnail_height', true) != "") {
				$image_height = get_post_meta($post->ID, $dirname.'_thumbnail_height', true);
			} else {
				$image_height = $gp_settings['thumbnail_height'];
			}	
		
			// Image Dimensions For Mobiles
	
			if($image_width <= 460 && get_option($dirname.'_responsive') == "0") {
				$image_ratio = 460 / $image_width;
				$new_image_width = $image_width * $image_ratio;
				$new_image_height = $image_height * $image_ratio;
			} else {
				$new_image_width = $image_width;
				$new_image_height = $image_height;
			}
			
			?>

			
				<!-- BEGIN POST -->
			
				<div <?php post_class('post-loop '.$gp_settings['preload']); ?>>
				
				
					<!-- BEGIN IMAGE -->
					
					<?php if(has_post_thumbnail()) { ?>				
						<div class="post-thumbnail<?php if($gp_settings['image_wrap'] == "Enable") { ?> wrap<?php } ?>">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php $image = vt_resize(get_post_thumbnail_id(), '', $new_image_width, $new_image_height, true); ?>
								<img src="<?php echo $image['url']; ?>" width="<?php echo $image_width; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" />		
							</a>				
						</div><?php if($gp_settings['image_wrap'] == "Disable") { ?><div class="clear"></div><?php } ?>
					<?php } ?>
					
					<!-- END IMAGE -->
					
					
					<!-- BEGIN POST TEXT -->
					
					<div class="post-text"<?php if(has_post_thumbnail() && $gp_settings['image_wrap'] == "Enable") { ?> style="margin-left: <?php echo $image_width + 20; ?>px;"<?php } ?>>
					
						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						
						<!-- BEGIN POST META -->
						
						<?php if($gp_settings['meta_date'] == "0" OR $gp_settings['meta_author'] == "0" OR $gp_settings['meta_cats'] == "0" OR $gp_settings['meta_comments'] == "0") { ?>
						
							<div class="post-meta">
								
								<?php if($gp_settings['meta_author'] == "0") { ?><span><i class="icon-user"></i><a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php the_author_meta('display_name', $post->post_author); ?></a></span><?php } ?>
								
								<?php if($gp_settings['meta_date'] == "0") { ?><span><i class="icon-calendar"></i><?php the_time(get_option('date_format')); ?></span><?php } ?>
								
								<?php if($gp_settings['meta_cats'] == "0" && $post->post_type == "post") { ?><span><i class="icon-folder-open"></i><?php the_category(', '); ?></span><?php } ?>
								
								<?php if($gp_settings['meta_comments'] == "0" && 'open' == $post->comment_status) { ?><span><i class="icon-comments"></i><?php comments_popup_link(__('0', 'gp_lang'), __('1', 'gp_lang'), __('%', 'gp_lang'), 'comments-link', ''); ?></span><?php } ?>
							
							</div>
							
						<?php } ?>
						
						<!--END POST META -->
						
						
						<!-- BEGIN POST CONTENT -->
					
						<?php if($gp_settings['content_display'] == "1") { ?>	
						
							<?php the_content('&raquo;'); ?>
							
						<?php } else { ?>
						
							<?php if($gp_settings['excerpt_length'] != "0") { ?><p><?php echo excerpt($gp_settings['excerpt_length']); ?><?php if($gp_settings['read_more'] == "0") { ?> <a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title(); ?>"> &raquo;</a><?php } ?></p><?php } ?>
							
						<?php } ?>
						
						<!-- END POST CONTENT -->
						
						
						<!-- BEGIN POST TAGS -->
						
						<?php if($gp_settings['meta_tags'] == "0") { ?>
							<?php the_tags('<div class="post-meta post-tags"><span><i class="icon-tags"></i>', ', ', '</span></div>'); ?>
						<?php } ?>
						
						<!-- END POST TAGS -->
						
						
					</div>
					
					<!-- END POST TEXT -->
		
		
				</div>

				<!-- END POST -->
						

			<?php endwhile; ?>
				
				
				<?php gp_pagination(); ?>
		
		
			<?php else : ?>	
		
		
				<h4><?php _e('Try searching again using the search form below.', 'gp_lang'); ?></h4>
			
				<div class="sc-divider"></div>
				
				<h3><?php _e('Search The Site', 'gp_lang'); ?></h3>
				<?php get_search_form(); ?>	
			
			
			<?php endif; ?>	
	
	
		</div>
		
		<!-- END POST WRAPPER -->


	</div>
	
	<!-- END PADDER -->
	
	
</div>	

<!-- END CONTENT -->


<?php get_sidebar('right'); ?>