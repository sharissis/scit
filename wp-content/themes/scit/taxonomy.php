<?php 
/* Template Name: SCIT Team Category */ 
?>

<?php get_header(); ?>
<div id="content">

	<div id="inner-content" class="wrap clearfix">
		
	    <div id="main" class="clearfix" role="main">
	    	<h1 class="page-title"><?php
			$term =	$wp_query->queried_object;
			echo $term->name;
			?></h1>

			<nav class="clearfix">
				<?php
				
				if (is_tax('scit_team-category')) {
					scit_teams_nav();
				} else if (is_tax('scit_performer-category')) {
					scit_people_nav();
				} ?>

			</nav>
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); 

					get_template_part('include/post-loop', 'thumbs');

				endwhile; endif; ?>

			<?php if (function_exists('bones_page_navi')) { ?>
	         	<?php bones_page_navi(); ?>
	        <?php } else { ?>
	            <nav class="wp-prev-next">
	                <ul class="clearfix">
	        	        <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></li>
	        	        <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></li>
	                </ul>
	            </nav>
	        <?php } ?>

		</div> <!-- #main -->

	</div><!-- #inner-content -->

</div><!-- #content -->
					
<?php get_footer(); ?>