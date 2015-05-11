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
				    	
					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php 
							$content = get_the_content();
							if (strlen($content)==0) {
								$content = "<em>A proper description of this wonderful show will be here soon!</em>";
							}
							// Custom Code to put stuff in alpha-order and the like.  Would like to port this easily into what you have above but I'm fried at the moment. - JSF
							// 
							// 
							?>
							<!--	Custom: Related Items	-->
							<?php
							//
							//
							//	Everything below this line is custom code to bring back stuff in alphabetical order and the like ... I want it to be as clean as above. -JSF
							//
							//
							//
							//	Custom Post-To-Post Shizzle
						    $weekSundayTime = strtotime('Sunday this week');
						    $thisSun = strtotime('last Sunday', $weekSundayTime);
						    $thisMon = strtotime('last Monday', $weekSundayTime);
						    $thisTue = strtotime('last Tuesday', $weekSundayTime);
						    $thisWed = strtotime('last Wednesday', $weekSundayTime);
						    $thisThu = strtotime('last Thursday', $weekSundayTime);
						    $thisFri = strtotime('last Friday', $weekSundayTime);
						    $thisSat = strtotime('last Saturday', $weekSundayTime);

						    $current_date = date('Y-m-d');
							$end_date = date('Y-m-d', strtotime('60 days'));

							$get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date,'eventDisplay'=>'upcoming','posts_per_page'=>20) );
							?>
							<?php
								// Find connected pages
								//	TEAMS #1
								$post_id = get_the_id();
								$teamQuery = new WP_Query( array(
									'connected_type' => 'scit_performers_to_teams',
									'connected_items' => $post_id,
									'nopaging' => true
								) );
								// Display connected pages
								while ( $teamQuery->have_posts() ) : $teamQuery->the_post();
									$teamId = get_the_id();
									$teamTitle = get_the_title();
									$teamLink = get_permalink();
									// $teamQueryResult = $teamQueryResult.'<a href="'.$teamLink.'">'.$teamTitle.'</a>, ';
									$playerArray[] = '<a href="'.$teamLink.'">'.$teamTitle.'</a><br/>';
									
								endwhile;
								
								//
								//	EVENTS #2
								wp_reset_postdata(); // set $post back to original post
								// Find connected pages
								$userEventQuery = new WP_Query( array(
										'connected_type' => 'scit_teams_to_events'
										, 'connected_items' => $post
										, 'nopaging' => true
										, 'start_date'=>$current_date
										, 'end_date'=>$end_date
										, 'eventDisplay'=>'upcoming'
										// // , 'posts_per_page'=>20
										// , 'meta_key' => 'start_date'
										// , 'meta_value'=>time()
										, 'orderby' => 'start_date'
										, 'order' => 'DESC'
									) );
								//Display connected pages
								while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
									$eventId = get_the_id();
									$eventTitle = get_the_title();
									$eventLink = get_permalink();
									//
									//$eventDate = "mykey"; $eventDate get_post_meta($eventId, $eventDate, true);
									$eventDate = tribe_get_start_date(null, false, 'l, F d');
									$sortDate = tribe_get_start_date(null, false, 'Y-m-d');
									//
									// $eventQueryResult = $eventQueryResult.'<br/><a href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.', ';
									$eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
									// 
								endwhile;
								wp_reset_postdata(); // set $post back to original post
								//
								//
								//	EVENTS #2
								// Find connected pages
								$userEventQuery = new WP_Query( array(
										'connected_type' => 'scit_openers_to_events',
										'connected_items' => $post,
										'nopaging' => true
											, 'start_date'=>$current_date
											, 'end_date'=>$end_date
											, 'eventDisplay'=>'upcoming'
											, 'posts_per_page'=>20
												// , 'meta_key' => 'start_date'
												, 'orderby' => 'start_date'
												, 'order' => 'DESC'
										

									) );
								//Display connected pages
								while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
									$eventId = get_the_id();
									$eventTitle = get_the_title();
									$eventLink = get_permalink();
									//
									//$openingActDate = "mykey"; $openingActDate get_post_meta($eventId, $openingActDate, true);
									$openingActDate = tribe_get_start_date(null, false, 'l, F d');
									$sortActDate = tribe_get_start_date(null, false, 'Y-m-d');

									//
									// $eventQueryResult = $eventQueryResult.'<br/><a href="'.$eventLink.'">'.$eventTitle.'</a>: '.$openingActDate.', ';
									$eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
									// 
								endwhile;
								wp_reset_postdata(); // set $post back to original post
								//
	
								?>
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
							<div class="clearfix">
							    		
								<section class="clearfix">
								    
							    	<div class="sixcol first">
										<?php the_post_thumbnail(''); ?>
									</div>
								    <div class="sixcol last">
										<header class="article-header">
									    	<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									    	
											 <!-- <p class="byline vcard"><?php //echo get_the_term_list( $post->ID, 'scit_team-category', 'Filed under: ', ', ', '' ); ?> </p> -->

											  
											<?php 
												// library/p2p-connections.php
												echo '<p>'.$content.'</p>';
												// This doesn't display alphabetically for now...
												// scit_connected_teams_to_events();
												// scit_connected_performers_to_teams();
												// 

												//
												//
												if ($playerArray <> null) {
													echo '<span class="h5">The Players:</span><br />';
													// echo rtrim($teamQueryResult, ', ').'<br/><br/>';
													sort($playerArray);
													$playerArrayLength=count($playerArray);
													for($x=0;$x<$playerArrayLength;$x++)
													   {
													   echo $playerArray[$x];
													   //echo "<br>";
													   }
												}

												// 
												// 
												echo '<br /><span class="h5">Upcoming Shows (next 2 months):</span><br />';
												if ($eventArray <> null) {
												// echo rtrim($eventQueryResult, ', ').'<br/>';
												sort($eventArray);
												$eventArrayLength=count($eventArray);
												for($x=0;$x<$eventArrayLength;$x++)
												   {
												   echo $eventArray[$x];
												   //echo "<br>";
												   }
												 }
												 else {
												 	echo "<em>No upcoming shows.</em>";
												 }
												//
												//
											?>

										</header> <!-- end article header -->
										<?php
										// 	We need to trun these off for the moment, they are pulling next/previous by Post Id, and not Dates.  And it will not make sense to the End-User. - JSF 
										?>
										<nav class="nav prev-next">
											<div class="prev">
												<?php previous_post('&larr; %', '', 'yes'); ?>
												<br />
												&larr; <a href="/<?php echo strtolower($post_type->label) ; ?>">Back to all Teams</a>
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
								<!-- <p class="featuring">Upcoming Shows:</p>-->
								<?php //scit_connected_teams_to_events(); ?>
							    

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