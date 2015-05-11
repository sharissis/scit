<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and 
 * optionally, the Google map for the event.
 *
 * This view contains the filters required to create an effective single event view.
 *
 * You can recreate an ENTIRELY new single event view by doing a template override, and placing
 * a single-event.php file in a tribe-events/ directory within your theme directory, which
 * will override the /views/single-event.php.
 *
 * You can use any or all filters included in this file or create your own filters in 
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters (TO-DO)
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }
$event_id = get_the_ID();

//	Feel free to kill me here.  I want to utlize the new features of Filters et al, but let's just get it back to the old look and feel for now and build on it later. - Jerome, 20130425_1334

// // Start single template
// echo apply_filters( 'tribe_events_single_event_before_template', '', $event_id );

// 	// Event notice
// 	echo apply_filters( 'tribe_events_single_event_notices', $event_id );
	
// 	// Event title
// 	echo apply_filters( 'tribe_events_single_event_before_the_title', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_the_title', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_after_the_title', '', $event_id );
	
// 	// Event header
//     echo apply_filters( 'tribe_events_single_event_before_header', '', $event_id );

//     	// Navigation
//     	echo apply_filters( 'tribe_events_single_event_before_header_nav', '', $event_id );
// 		echo apply_filters( 'tribe_events_single_event_header_nav', '', $event_id );
// 		echo apply_filters( 'tribe_events_single_event_after_header_nav', '', $event_id );

// 	echo apply_filters( 'tribe_events_single_event_after_header', '', $event_id );
	
// 	// Event featured image
// 	echo apply_filters( 'tribe_events_single_event_featured_image', '', $event_id );

// 	// Event content
// 	echo apply_filters( 'tribe_events_single_event_before_the_content', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_the_content', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_after_the_content', '', $event_id );	

// 	// Event meta
// 	echo apply_filters( 'tribe_events_single_event_before_the_meta', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_the_meta', '', $event_id );
// 	echo apply_filters( 'tribe_events_single_event_after_the_meta', '', $event_id );
	
// 	// Event footer
//     echo apply_filters( 'tribe_events_single_event_before_footer', '', $event_id );

//     	// Navigation
//     	echo apply_filters( 'tribe_events_single_event_before_footer_nav', '', $event_id );
// 		echo apply_filters( 'tribe_events_single_event_footer_nav', '', $event_id );
// 		echo apply_filters( 'tribe_events_single_event_after_footer_nav', '', $event_id );

// 	echo apply_filters( 'tribe_events_single_event_after_footer', '', $event_id );
	
// // End single template
// echo apply_filters( 'tribe_events_single_event_after_template', '', $event_id );

?>
<div id="tribe-events-content" class="upcoming clearfix">
	<div class="header-thumb">
		<?php 
			if( has_post_thumbnail() ) {
				checkAndPrintThumbnail('bones-thumb-300');
			} else {
				print_event_team_thumb(); 
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
		
	</div>
	<div class="disclaimer">
		&dash;&dash;<br/>Unless otherwise noted, each show is $5 cash at the Box Office.<br/><small>SCIT students get in for free upon availability with a valid SCIT Student Card.</small>
	</div>
</div>

<nav class="prev-next">
	<div class="prev"><?php tribe_previous_event_link('&larr; %title%'); ?></div>

	<div class="next"><?php tribe_next_event_link('%title% &rarr;'); ?></div>
	&nbsp;
	<div class="back clearfix"><a href="<?php echo tribe_get_events_link(); ?>"><?php _e('&larr; Back to all events', 'tribe-events-calendar'); ?></a></div>				
</nav>