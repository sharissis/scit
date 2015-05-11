<?php 
/* Template Name: SCIT Performers */ 
?>

<?php get_header(); ?>
<div id="content">

	<div id="inner-content" class="wrap clearfix">
	    <div id="main" class="clearfix" role="main">

			<h1 class="page-title"><?php post_type_archive_title(); ?></h1>

				<nav class="clearfix page-nav">
					<?php scit_people_nav(); ?>
				</nav>
				
				<?php 

				$args = array(
					'post_type' => 'scit_performer'
					, 'posts_per_page' => 99
					, 'orderby' => 'rand'
					//	Do not bring back "Exclude" Category
					, 'tax_query' => array(
				    array(
				        'taxonomy'  => 'scit_performer-category', // taxonomy = custom post type category
				        'field'     => 'slug',
				        'terms'     => 'exclude', // terms = Category
				        'operator'  => 'NOT IN')

				        )
				// Only bring back if they have an image.
				//, 'meta_key'=>'_thumbnail_id'
				);	
				$loop = new WP_Query( $args );
				
				if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); 
					get_template_part('include/post-loop', 'thumbs');
				 endwhile; ?>

				<?php endif; ?>

			<?php if (function_exists('bones_page_navi')) { ?>
	         	<?php bones_page_navi(); ?>
	        <?php } else { ?>
	            <nav class="prev-next">    
	    	        <div class="prev"><?php next_posts_link(__('&laquo; Older Entries', "bonestheme")) ?></div>
	    	        <div class="next"><?php previous_posts_link(__('Newer Entries &raquo;', "bonestheme")) ?></div>
	            </nav>
	        <?php } ?>

		</div> <!-- #main -->

	</div><!-- #inner-content -->

</div><!-- #content -->
					
<?php get_footer(); ?>