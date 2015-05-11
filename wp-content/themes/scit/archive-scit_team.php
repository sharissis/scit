<?php

/* Template Name: SCIT Teams */ 

?>

<?php get_header(); ?>
<div id="content">

	<div id="inner-content" class="wrap clearfix">
	    <div id="main" class="clearfix" role="main">
		
			<h1 class="page-title">Shows</h1>

			<nav class="clearfix page-nav">
				<?php scit_teams_nav(); ?>
			</nav>

			<?php
			
			$args = array( 
				'post_type' => 'scit_team',
				'posts_per_page' => 99
				, 'orderby' => 'rand'
				,
				//	Do not bring back "Exclude" Category
				array(
			        'taxonomy'  => 'scit_team-category', // taxonomy = custom post type category
			        'field'     => 'slug',
			        'terms'     => 'exclude', // terms = Category
			        'operator'  => 'NOT IN')
				// Only bring back if they have an image.
				//, 'meta_key'=>'_thumbnail_id'
				);

			$loop = new WP_Query( $args );

			if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
				get_template_part('include/post-loop', 'thumbs');
			
			endwhile; endif; ?>
		
		</div> <!-- #main -->

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


	</div><!-- #inner-content -->

</div><!-- #content -->
					
<?php get_footer(); ?>