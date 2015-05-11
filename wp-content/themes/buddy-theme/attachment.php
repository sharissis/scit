<?php get_header(); ?>


<!-- BEGIN CONTENT -->

<div id="content">


	<!-- BEGIN PADDER -->

	<div class="padder">
	
	
		<!-- BEGIN TITLE -->
		
		<h1 class="page-title"><?php the_title(); ?></h1>
		
		<!-- END TITLE -->
		
		
		<!-- BEGIN IMAGE -->
			
		<?php the_attachment_link($post->post_ID, true) ?>
		
		<!-- END IMAGE -->
		
		
		<!-- BEGIN POST CONTENT -->
		
		<div id="post-content">
		
			<?php the_content(); ?>
			
		</div>
		
		<!-- END POST CONTENT -->
		
			
		<div class="clear"></div>
		
	
	</div>
	
	<!-- END PADDER -->
	
		
</div>

<!-- END CONTENT -->


<?php get_footer(); ?>