<?php require(gp_inc . 'options.php'); global $dirname; ?>


<?php if(!is_page_template('blank-page.php')) { ?>

	
			<?php get_sidebar('left'); ?>
			<?php get_sidebar('right'); ?>
	
	
			<div class="clear"></div>
		
		
		</div>
	
		<!-- END CONTENT WRAPPER -->

	</div>

	<!-- END PAGE WRAPPER -->
	

	<!-- BEGIN FOOTER -->

	<?php if(is_active_sidebar('gp-footer-1') OR is_active_sidebar('gp-footer-2') OR is_active_sidebar('gp-footer-3') OR is_active_sidebar('gp-footer-4')) { ?>

		<div id="footer">
	
			<div id="footer-widgets">
			
				<?php
				if(is_active_sidebar('gp-footer-1') && is_active_sidebar('gp-footer-2') && is_active_sidebar('gp-footer-3') && is_active_sidebar('gp-footer-4') && is_active_sidebar('gp-footer-5')) { $footer_widgets = "footer-fifth"; }
				elseif(is_active_sidebar('gp-footer-1') && is_active_sidebar('gp-footer-2') && is_active_sidebar('gp-footer-3') && is_active_sidebar('gp-footer-4')) { $footer_widgets = "footer-fourth"; }
				elseif(is_active_sidebar('gp-footer-1') && is_active_sidebar('gp-footer-2') && is_active_sidebar('gp-footer-3')) { $footer_widgets = "footer-third"; }
				elseif(is_active_sidebar('gp-footer-1') && is_active_sidebar('gp-footer-2')) {
				$footer_widgets = "footer-half"; }	
				elseif(is_active_sidebar('gp-footer-1')) { $footer_widgets = "footer-whole"; }
				?>
		
				<?php if(is_active_sidebar('gp-footer-1')) { ?>
					<div class="footer-widget footer-1 <?php echo($footer_widgets); ?>">
						<?php dynamic_sidebar('gp-footer-1'); ?>
					</div>
				<?php } ?>
		
				<?php if(is_active_sidebar('gp-footer-2')) { ?>
					<div class="footer-widget footer-2 <?php echo($footer_widgets); ?>">
						<?php dynamic_sidebar('gp-footer-2'); ?>
					</div>
				<?php } ?>
			
				<?php if(is_active_sidebar('gp-footer-3')) { ?>
					<div class="footer-widget footer-3 <?php echo($footer_widgets); ?>">
						<?php dynamic_sidebar('gp-footer-3'); ?>
					</div>
				<?php } ?>
			
				<?php if(is_active_sidebar('gp-footer-4')) { ?>
					<div class="footer-widget footer-4 <?php echo($footer_widgets); ?>">
						<?php dynamic_sidebar('gp-footer-4'); ?>
					</div>
				<?php } ?>

				<?php if(is_active_sidebar('gp-footer-5')) { ?>
					<div class="footer-widget footer-5 <?php echo($footer_widgets); ?>">
						<?php dynamic_sidebar('gp-footer-5'); ?>
					</div>
				<?php } ?>
					
			</div>
		
		</div>

	<?php } ?>

	<!-- END FOOTER -->


	<!-- BEGIN COPYRIGHT -->
	
	<div id="copyright"><?php if(get_option($dirname.'_footer_content')) { echo stripslashes(get_option($dirname.'_footer_content')); } else { ?><?php _e('Copyright &copy;', 'gp_lang'); ?> <?php echo date('Y'); ?> <a href="http://themeforest.net/user/GhostPool/portfolio?ref=GhostPool"><?php _e('GhostPool.com', 'gp_lang'); ?></a>. <?php _e('All rights reserved.', 'gp_lang'); ?><?php } ?></div>
	
	<!-- END COPYRIGHT -->


<?php } ?>


<?php wp_footer(); ?>

</body>
</html>