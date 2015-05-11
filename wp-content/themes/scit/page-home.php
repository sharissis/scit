<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>
			<!-- TODO: This will be a real slider  -->	
 			<!-- <a href="<?php echo home_url(); ?>" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/library/images/header-test.jpg" class="slide-image" /></a> -->
 			
			<div id="content">
				<div id="inner-content" class="clearfix">
					
				    <div class="clearfix" role="main">
					    
					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
					    	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix wrap'); ?> role="article">
					    		
				    			<section class="fourcol first">
								    <h3 class="home-section-title">Upcoming Shows</h3>
								    <?php get_template_part('include/post-loop', 'events-home'); ?>
							    </section> <!-- upcoming shows -->								    								    
								
								<div class="eightcol last">
									<section>
										<?php echo do_shortcode( '[responsive_slider]' ); ?>
									</section> <!-- slider -->

									<div class="clearfix">
									
										<div class="sixcol first">
									
											<section class="clearfix">
												<h3 class="home-section-title">Now Registering</h3>
												<?php // Old hard-coded way of pulling in the courses
												// get_template_part('include/post-loop', 'courses-home'); ?>
												<?php
													$include = get_pages('include=76');
													$content = apply_filters('the_content',$include[0]->post_content);
													echo $content;
												?>
												<div class="clearfix">
													<br />
													<a class="button last" href="<?php echo get_permalink( get_page_by_title( 'Classes' ) ); ?>">See all...</a>
												</div>
											</section> <!-- classes -->

										</div>

										<div class="sixcol last">
											<section>
												<h3 class="home-section-title">News</h3>
												<?php get_template_part('include/post-loop', 'news-home'); ?>
											</section> <!-- news -->
											
											<section>
												<h3 class="home-section-title">Location</h3>
												<a href="https://maps.google.com/maps?q=Greenbriar+Way+%26+Ellsworth+Ave.,+Pittsburgh,+PA&hl=en&sll=40.431368,-79.9805&sspn=0.223438,0.528374&hnear=Ellsworth+Ave+%26+Greenbriar+Way,+Pittsburgh,+Allegheny,+Pennsylvania+15232&t=m&z=17&iwloc=A" target="_blank"><span class="h4">5950 Ellsworth Ave, Pittsburgh</span>
												<br />
												<img src="<?php echo get_bloginfo('template_directory'); ?>/library/images/map.png"></a>
												<span>(Corner of Ellsworth and Greenrbiar)</span>
						    				</section> <!-- map -->

										</div> <!-- sixcol -->

									</div> <!-- clearfix -->

							</div> <!-- eightcol -->
					
					    </article> <!-- end article -->

						
					    <?php endwhile; ?>	
					
					    <?php else : ?>
					
        					<article id="post-not-found" class="hentry clearfix">
        					    <header class="article-header">
        						    <h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
        						</header>
        					    <section class="entry-content">
        						    <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
        						<footer class="article-footer">
        						    <p><?php _e("This is the error message in the page-custom.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>
					
					    <?php endif; ?>

				    </div> <!-- end #main -->
				    
					

				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
