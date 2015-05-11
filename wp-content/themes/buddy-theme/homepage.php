<?php
/*
Template Name: Homepage
*/
get_header(); global $gp_settings, $user_ID, $user_identity, $user_level; ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<!-- BEGIN CONTENT -->	

	<div id="content">


		<!-- BEGIN POST CONTENT -->	

		<?php if($post->post_content) { ?>	
		
			<div id="post-content">
				<?php the_content(__('Read More &raquo;', 'gp_lang')); ?>
			</div>
			
		<?php } ?>

		<!-- END POST CONTENT -->			


	</div>
	
	<!-- END CONTENT -->	
	

<?php endwhile; endif; ?>


<?php get_footer(); ?>