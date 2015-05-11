<?php require(gp_inc . 'options.php'); global $gp_settings; ?>


<?php if($gp_settings['layout'] == "sb-left" OR $gp_settings['layout'] == "sb-both") { ?>

	
	<!-- BEGIN SIDEBAR -->
		
	<div id="sidebar-left" class="sidebar">
			
			
		<?php if(is_active_sidebar($gp_settings['sidebar_left'])) { ?>
	
			
			<!-- BEGIN SELECTED WIDGETS -->

			<?php dynamic_sidebar($gp_settings['sidebar_left']); ?>

			<!-- END SELECTED WIDGETS -->	
			
			
		<?php } else { ?>
				
				
			<!-- BEGIN DEFAULT WIDGETS -->
					
			<?php the_widget('BP_Core_Members_Widget', 'title=Members'); ?> 
			
			<?php the_widget('BP_Groups_Widget', 'title=Groups'); ?> 
			
			<?php the_widget('WP_Widget_Recent_Posts'); ?> 
			
			<?php the_widget('WP_Widget_Calendar', 'title=Calendar'); ?> 
			
			<?php the_widget('WP_Widget_Text', 'title=Text Widget&text=Globally productivate business web-readiness before excellent internal or "organic" sources. Synergistically cultivate.'); ?> 
			
			<!-- END DEFAULT WIDGETS -->
			
					
		<?php } ?>
		
		
	</div>
	
	<!-- END SIDEBAR -->
	
	
<?php } ?>	