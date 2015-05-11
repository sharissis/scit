<?php get_header(); global $gp_settings; ?>


<!-- BEGIN CONTENT -->

<div id="content">


	<!-- BEGIN PADDER -->

	<div class="padder">


		<!-- BEGIN TITLE -->

		<h1 class="page-title"><?php _e('Page Not Found', 'gp_lang'); ?></h1>
		
		<!-- END TITLE -->

		
		<h4><?php _e('Oops, it looks like this page does not exist. If you are lost try using the search box.', 'gp_lang'); ?></h4>
	
	
		<div class="sc-divider clear"></div>
	
	
		<h4><?php _e('Search The Site', 'gp_lang'); ?></h4>
		<?php get_search_form(); ?>


		<div class="clear"></div>


	</div>
	
	<!-- END PADDER -->
	
	
</div>

<!-- END CONTENT -->


<?php get_footer(); ?>