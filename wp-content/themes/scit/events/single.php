<?php
/**
* A single event.  This displays the event title, description, meta, and 
* optionally, the Google map for the event.
*
* You can customize this view by putting a replacement file of the same name (single.php) in the events/ directory of your theme.
*/

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }
?>
<div id="tribe-events-content" class="upcoming clearfix">
	<div class="header-thumb">
		<?php 
			if( has_post_thumbnail() ) {
				checkAndPrintThumbnail('');
			} else {
				print_event_team_thumb('full'); 
				wp_reset_postdata();
			}
		 ?>
	</div>
	<div class="header-info">
	<?php
		$gmt_offset = (get_option('gmt_offset') >= '0' ) ? ' +' . get_option('gmt_offset') : " " . get_option('gmt_offset');
	 	$gmt_offset = str_replace( array( '.25', '.5', '.75' ), array( ':15', ':30', ':45' ), $gmt_offset );
	 	if (strtotime( tribe_get_end_date(get_the_ID(), false, 'Y-m-d G:i') . $gmt_offset ) <= time() ) { ?><div class="event-passed"><?php  _e('This event has passed.', 'tribe-events-calendar'); ?></div><?php } ?>
	 	
			<span class="single-event-time">
				<!-- <?php if( function_exists('tribe_get_gcal_link') ): ?>
				<a href="<?php echo tribe_get_gcal_link(); ?>" class="gcal-add" title="<?php _e('Add to Google Calendar', 'tribe-events-calendar'); ?>" target="_blank"><?php _e('+ Google Calendar', 'tribe-events-calendar'); ?></a>
				<?php endif; ?> -->
				<?php if (tribe_get_start_date() !== tribe_get_end_date() ) { ?>
					<h3><?php echo tribe_get_start_date(null, false, 'l, F d');?></h3><h3><?php echo tribe_get_start_date(null, false, 'g:i a'); ?> - <?php echo tribe_get_end_date(null, false, 'g:i a'); ?></h3>
				<?php } else { ?>
					<h3><?php echo tribe_get_start_date(null, false, 'l, F d');?></h3><h3><?php echo tribe_get_start_date(null, false, 'g:i a'); ?> - <?php echo tribe_get_end_date(null, false, 'g:i a'); ?>
				<?php } ?></h3>
			</span>
			
			<?php scit_connected_teams_to_events();  ?>
			<?php scit_connected_performers_to_events(); ?>
			<?php scit_connected_teams_to_events_Featured(); ?>

			<p class="byline vcard"><?php echo get_the_term_list( $post->ID, 'tribe_events_cat', 'Filed under: ', ', ', '' ); ?> </p>
			<?php if( function_exists('tribe_get_gcal_link') ): ?>
			   <a href="<?php echo tribe_get_gcal_link(); ?>" class="gcal-add" title="<?php _e('Add to Google Calendar', 'tribe-events-calendar'); ?>"><?php _e('+ Google Calendar', 'tribe-events-calendar'); ?></a>
			<?php endif; ?>			
	</div> <!-- .header-info -->
</div> <!-- .upcoming -->

<div class="entry-content">
	<div class="summary">
		<?php
		
			$content = get_the_content();
			
			if( $content == '' ) {
				print_event_team_description();
			} else {
				the_content(); 
			} 

		?>
		<?php if (function_exists('tribe_get_ticket_form') && tribe_get_ticket_form()) { tribe_get_ticket_form(); } ?>		
		<br/>
		<br/>
		Unless otherwise noted, each shows is $5 at the Box Office.<br/>
		Steel City Improv students get in for free.
	</div>
</div>
<?php
// 	We need to trun these off for the moment, they are pulling next/previous by Post Id, and not Dates.  And it will not make sense to the End-User. - JSF
// 	?>
<!-- <nav class="prev-next">
	<div class="prev"><?php //tribe_previous_event_link('&larr; %title%'); ?></div>

	<div class="next"><?php //tribe_next_event_link('%title% &rarr;'); ?></div>
	&nbsp;
	<div class="back clearfix"><a href="<?php //echo tribe_get_events_link(); ?>"><?php //_e('&larr; Back to all events', 'tribe-events-calendar'); ?></a></div>				

</nav> -->