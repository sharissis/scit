<?php
/*

Custom Type Template: 
	Single Team

Connections:
	Team to Performer
	Team to Event

*/

	
$post_type = get_post_type_object( get_post_type($post) );

?>

<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="clearfix" role="main">
				    	
						<a class="vcard byline" href="<?php echo $post_type->label ; ?>">Back to all Teams</a>
					    
					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
							<div class="clearfix">
								
								<section class="clearfix">
								    
							    	<div class="sixcol first">
										<?php the_post_thumbnail(''); ?>
									</div>
								    <div class="sixcol last">
										<header class="article-header">
									    	<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									    	
											 <p class="byline vcard"><?php echo get_the_term_list( $post->ID, 'scit_team-category', 'Filed under: ', ', ', '' ); ?> </p>

											  	
											<?php 
												// library/p2p-connections.php
												the_content();
												scit_connected_teams_to_events();
												scit_connected_performers_to_teams();
											?>
											
										</header> <!-- end article header -->
										<nav class="nav prev-next">
											<div class="prev">
												<?php previous_post('&larr; %', '', 'yes'); ?>
											</div>
											<div class="next">
												<?php next_post('% &rarr; ', '', 'yes'); ?>
											</div>
										</nav> <!-- end navigation -->
									</div>
						
							    </section> <!-- end article section -->
							</div>
						    <footer class="article-footer">
						    	<?php edit_post_link(); ?>
						    	<!-- TODO: show only future events before enabling this -->
								<!-- <p class="featuring">Upcoming Shows:</p>
								<?php scit_connected_teams_to_events(); ?>
							    -->

						    </footer> <!-- end article footer -->
                            
					    </article> <!-- end article -->
					
					    <?php endwhile; ?>			
					
					    <?php else : ?>
					
        					<?php require('include/notfound.php'); ?>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <?php // get_sidebar(); ?>
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>