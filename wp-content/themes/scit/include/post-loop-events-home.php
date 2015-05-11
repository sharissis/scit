<div class="home-feed clearfix">
<?php
    $weekSundayTime = strtotime('Sunday this week');
    $thisSun = strtotime('last Sunday', $weekSundayTime);
    $thisMon = strtotime('last Monday', $weekSundayTime);
    $thisTue = strtotime('last Tuesday', $weekSundayTime);
    $thisWed = strtotime('last Wednesday', $weekSundayTime);
    $thisThu = strtotime('last Thursday', $weekSundayTime);
    $thisFri = strtotime('last Friday', $weekSundayTime);
    $thisSat = strtotime('last Saturday', $weekSundayTime);
    //echo "<p span=\"alpha\">".$thisSun."<br/>".$thisMon."<br/>".$thisSun."<br/>".$thisTue."<br/>".$thisWed."<br/>".$thisThu."<br/>".$thisFri."<br/>".$thisSat."</span>"

	//	Query Breakdowns
	//	
	//	Upcoming:
	// 	'eventDisplay'=>'upcoming'
	// 	
	 	//global $post;
	 	// $today = date ('l, F dS', strtotime('today')).'<br/>';
	 	// $current_date = date('Y-m-d');
    	// $current_date = date('Y-m-d', strtotime("-1 day"));
    	$current_date = date('Y-m-d', strtotime("-6 hours"));
		// $end_date = date('Y-m-d', strtotime('7 days'));
		$end_date = date('Y-m-d', strtotime("next monday + 1 week"));
		// strtotime("next saturday + 1 week")

		//$current_date = strtotime('today');
		//$end_date = strtotime('today')+8;
		//	'posts_per_page'=>10,
		$get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date,'eventDisplay'=>'custom','posts_per_page'=>15) );
		// $get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date,'eventDisplay'=>'custom') );
		// $get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date) );
		// $get_posts = upcomingEvents();
	//	
	//	
	//$args = array( 'post_type' => 'tribe_events', 'posts_per_page' => 13, 'showposts' => 4, 'order' => 'ASC', 'eventDisplay'=>'upcoming'	 );	
	//$loop = new WP_Query( $args );

	foreach($get_posts as $post) { setup_postdata($post); 
//	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();

		$startTime		= tribe_get_start_date( $post->ID, false, 'hA' );


	?>
				
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix indiv-event'); ?> role="article">
		<?php if ( tribe_is_new_event_day() && !tribe_is_day() && !tribe_is_multiday() ) : ?>
        	<h4 class="event-day"><?php echo tribe_get_start_date(null, false, 'l, F d');?></h4>
        <?php endif; ?>
        <?php if( !tribe_is_day() && tribe_is_multiday() ) : ?>
            <h4 class="event-day"><?php echo tribe_get_start_date(null, false, 'l, F d');?> - <?php echo tribe_get_end_date(null, false, 'l, F d');?></h4>
        <?php endif; ?>
        <?php if ( tribe_is_day() && $first ) : $first = false; ?>
            <h4 class="event-day"><?php echo tribe_event_format_date(strtotime(get_query_var('eventDate')), false); ?></h4>
        <?php endif; ?>
		<div class="clearfix">
			
			<div class="list-info">
				<p class="event-time"><?php echo tribe_get_start_date(null, false, 'g:ia'); ?><br /><?php echo '<a href="'.tribe_get_event_link().'" title="'.the_title_attribute('echo=0').'" rel="bookmark">';?><?php scit_strip_datestamp_from_title(); ?><?php echo '</a>'; ?></p>
			</div>

			<div class="list-thumbnail">
				<?php 
					// echo $end_date;
					// if( has_post_thumbnail() ) {
					// 	checkAndPrintThumbnail('bones-thumb-300');
					// } else {
					// 	print_event_team_thumb();
					// 	wp_reset_postdata();
					// }
				?>
			</div>
		</div>

	</article> <!-- end article -->

<?php
//	endwhile;
?>
<?php
// endif;
?>
<?php
	 } //endforeach
wp_reset_query();
?>
<a class="button first" href="https://www.google.com/calendar/render?cid=http://steelcityimprov.com/events/ical/">Subscribe to SCIT Calendar</a>
<a class="button last" href="/events/">See all...</a>
</div>