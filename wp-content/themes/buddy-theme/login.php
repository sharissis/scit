<?php
/*
Template Name: Login
*/
get_header(); global $gp_settings, $user_ID, $user_identity, $user_level; 

if(isset($_SERVER['HTTP_REFERER'])) { $referrer = $_SERVER['HTTP_REFERER']; }

?>


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
			
			
			<!-- BEGIN POST CONTENT -->
				
			<?php if($post->post_content) { ?>	
			
				<div id="post-content">


					<!-- BEGIN IMAGE -->
			
					<?php if(has_post_thumbnail() && $gp_settings['image_wrap'] == "Enable" && $gp_settings['show_image'] == "Show") { ?>
						<div class="post-thumbnail wrap">
							<?php $image = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width'], $gp_settings['image_height'], $gp_settings['hard_crop'], false, true); ?>
							<?php if(get_option($dirname.'_retina') == "0") { $retina = aq_resize(wp_get_attachment_url(get_post_thumbnail_id(get_the_id())),  $gp_settings['image_width']*2, $gp_settings['image_height']*2, $gp_settings['hard_crop'], false, true); } else { $retina = ""; } ?>
							<img src="<?php echo $image[0]; ?>" data-rel="<?php echo $retina[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="<?php if(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)) { echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); } else { echo get_the_title(); } ?>" class="wp-post-image" />	
						</div>
					<?php } ?>
					
					<!-- END IMAGE -->
					
									
					<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
					
				</div>
				
			<?php } else { ?>
			
				<?PHP the_content(__('Read More &raquo;', 'gp_lang')); ?>
				
			<?php } ?>
			
			<!-- END POST CONTENT -->
			
			
			<?php if($user_ID) { ?>
			
				<h2><?php _e('You are already logged in.', 'gp_lang'); ?></h2>
			
			<?php } else { ?>
			
			
				<!-- BEGIN LOGIN FORM -->

				<form action="<?php echo site_url('wp-login.php', 'login_post'); ?>" method="post" id="login-page-form">
				
					<p><label for="log"><?php _e('Username', 'gp_lang'); ?></label>
					<input type="text" name="log" id="log" value="<?php echo esc_html(stripslashes($user_login), 1) ?>" size="22" placeholder="<?php _e('Username', 'gp_lang'); ?>" /></p>
					
					<p><label for="pwd"><?php _e('Password', 'gp_lang'); ?></label>
					<input type="password" name="pwd" id="pwd" size="22" placeholder="<?php _e('Password', 'gp_lang'); ?>" /></p>
					
					<p><input type="submit" name="submit" value="<?php _e('Login', 'gp_lang'); ?> &rarr;" class="button" />
					<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> <?php _e('Remember Me', 'gp_lang'); ?></label></p>
					<input type="hidden" name="redirect_to" value="<?php if(preg_match("/key=/", $referrer)) { echo home_url(); } else { echo $referrer; } ?>"/>
					
				</form>
				
				<!-- END LOGIN FORM -->
				
			
				<!-- BEGIN LOGIN LINKS -->

				<div id="login-page-links">
				
					<?php if(function_exists('bp_is_active') && bp_get_signup_allowed()) { ?><i class="icon-signin"></i> <a href="<?php echo bp_get_signup_page(false); ?>"><?php _e('Register', 'gp_lang'); ?></a><?php } ?>
				
					&nbsp;&nbsp;&nbsp;<i class="icon-question-sign"></i> <a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post'); ?>"><?php _e('Lost Password', 'gp_lang'); ?></a>
			
				</div>
				
				<!-- END LOGIN LINKS -->
				
				
			<?php } ?>
			
		
		</div>
		
		<!-- END PADDER -->

	</div>
	
	<!-- END CONTENT -->
	

<?php endwhile; endif; ?>


<?php get_footer(); ?>