<?php require(gp_inc . 'options.php'); global $gp_settings; ?>


<?php if($gp_settings['layout'] == "sb-right" OR $gp_settings['layout'] == "sb-both") { ?>
		
	
	<!-- BEGIN SIDEBAR -->
		
	<div id="sidebar-right" class="sidebar">
			
		
		<!-- BEGIN BUDYYPRESS SITEWIDE NOTICES -->
			
		<?php if(function_exists('bp_message_get_notices')) { ?>
			<?php bp_message_get_notices(); ?>
		<?php } ?>
		
		<!-- END BUDYYPRESS SITEWIDE NOTICES -->
		
					
		<?php if(is_active_sidebar($gp_settings['sidebar_right'])) { ?>
	
	
			<!-- BEGIN SELECTED WIDGETS -->

			<?php dynamic_sidebar($gp_settings['sidebar_right']); ?>

			<!-- END SELECTED WIDGETS -->						


		<?php } else { ?>
				
					
			<!-- BEGIN DEFAULT WIDGETS -->
					
			<?php the_widget('WP_Widget_Meta'); ?> 
			
			<?php the_widget('WP_Widget_Recent_Posts'); ?> 
			
			<?php the_widget('WP_Widget_Calendar', 'title=Calendar'); ?> 
			
			<?php the_widget('WP_Widget_Text', 'title=Text Widget&text=Globally productivate business web-readiness before excellent internal or "organic" sources. Synergistically cultivate.'); ?> 
			
			<!-- END DEFAULT WIDGETS -->
			
		
		<?php } ?>
		
		
	</div>
	
	<!-- END SIDEBAR -->
	
	
<?php } ?>