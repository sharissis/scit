<?php
/*

Custom Type Template: 
	Single Performer

Connections:
	Performer to Team
	Team to Event

*/

$post_type = get_post_type_object( get_post_type($post) );

?>


<?php get_header(); ?>
			
		<div id="content">
		
			<div id="inner-content" class="wrap clearfix">
		
			    <div id="main" class="eightcol first clearfix" role="main">
					
					<h1>Performers</h1>
					
				    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php
					$content = get_the_content();
					if (strlen($content)==0) {
						$content = "<em>A proper description of this wonderful player will be here soon!</em>";
					}
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
							$teamFeaturedImage = get_the_post_thumbnail($teamId, 'thumbnail');
							//$teamQueryResult = $teamQueryResult.'<br/>'.$teamFeaturedImage.'<a href="'.$teamLink.'">'.$teamTitle.'</a>, ';
							//
							//
							//$teamQueryResult = $teamQueryResult.'<a href="'.$teamLink.'">'.$teamFeaturedImage.'</a> ';
							//
							//$teamArray[] = '<a href="'.$teamLink.'">'.$teamFeaturedImage.'</a> ';
							$teamArray[] = '<a href="'.$teamLink.'">'.$teamTitle.'</a><br/>';
							//
							//
							// Find connected pages
							//	EVENTS #1
							//echo $teamId;
							//

							$teamEventQuery = new WP_Query( array(
									'connected_type' => 'scit_teams_to_events'
									, 'connected_items' => $teamId
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
							
							while ( $teamEventQuery->have_posts() ) : $teamEventQuery->the_post();
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
								// $myArr2[] = '<br/><a href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate;
							endwhile;
							
						endwhile;
						wp_reset_postdata(); // set $post back to original post
						//
						//	EVENTS #2
						wp_reset_postdata(); // set $post back to original post
						// Find connected pages
						$userEventQuery = new WP_Query( array(
								'connected_type' => 'scit_events_to_users',
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
							//$eventDate = "mykey"; $eventDate get_post_meta($eventId, $eventDate, true);
							$eventDate = tribe_get_start_date(null, false, 'l, F d');
							$sortDate = tribe_get_start_date(null, false, 'Y-m-d');

							//
							// $eventQueryResult = $eventQueryResult.'<br/><a href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.', ';
							$eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
							// $myArr2[] = '<br/><a href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate;
						endwhile;
						//

						//
						wp_reset_postdata(); // set $post back to original post
						?>

					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix entry-content'); ?> role="article">
							
						    <header class="article-header clearfix">

						    	<div class="header-thumb">
									<?php checkAndPrintThumbnail('bones-thumb-300'); ?>
								</div>
								<div class="header-info">
							    	<h1 class="single-title custom-post-type-title"><?php the_title(); ?></h1>
									<!-- <p class="byline vcard"><?php //echo get_the_term_list( $post->ID, 'scit_performer-category', 'Filed under: ', ', ', '' ); ?></p> -->
									<?php
									// This isn't alphabeitcal at the moment, or sortable rather.
									// 	scit_connected_performers_to_teams();
									// 	
									echo '<span class="h5">Performs with:</span><br />';
									// echo rtrim($teamQueryResult, ', ').'<br/><br/>';
									// 
									if ($teamArray <> null) {
										sort($teamArray);
										$teamArrayLength=count($teamArray);
										for($x=0;$x<$teamArrayLength;$x++)
										   {
										   echo $teamArray[$x];
										   //echo "<br>";
										   }
									}
									else {
										echo "N/A";
									}
									?>
								</div>
						    </header> <!-- end article header -->
					
						    <section class="clearfix">
								<?php echo $content; ?>
								<?php //edit_post_link(); ?>
								<br/>
								<?php
								echo '<br/><span class="h5">Upcoming Shows (next 2 months):</span><br/>';
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
								 	echo "N/A";
								 }
								?>
						    </section> <!-- end article section -->
								
						    <footer class="article-header clearfix"> 
						    	<nav class="prev-next">
									<div class="prev">
										<?php previous_post('&larr; %', '', 'yes'); ?><br />
										&larr; <a href="/<?php echo strtolower($post_type->label) ; ?>">Back to all Performers</a>
					<br/>
									</div>
									<div class="next">
										<?php next_post('% &rarr; ', '', 'yes'); ?>
									</div>
								</nav> <!-- end navigation -->
						    </footer> <!-- end article footer -->
							
    		    		</article> <!-- end article -->
				
				    <?php endwhile; ?>			
				
				    <?php else : ?>
				
    					<?php require('include/notfound.php'); ?>
				
				    <?php endif; ?>
		
			    </div> <!-- end #main -->

			    <?php get_sidebar(); ?>
			    
			</div> <!-- end #inner-content -->

		</div> <!-- end #content -->

<?php get_footer(); ?>