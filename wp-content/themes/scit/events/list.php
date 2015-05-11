<?php
/**
* The TEC template for a list of events. This includes the Past Events and Upcoming Events views 
* as well as those same views filtered to a specific category.
*
* You can customize this view by putting a replacement file of the same name (list.php) in the events/ directory of your theme.
*/

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

?>
<!--
<div class="tribe-events-calendar">
	<h2>Events in <span class="cat_totally-free cat_totally-free-mondays"><strong> GREEN </strong></span> are <span class="cat_totally-free cat_totally-free-mondays"><strong> FREE </strong></span>!</h2>
</div>
-->

<div id="tribe-events-content" class="upcoming">

	<?php if(!tribe_is_day()): ?>
		<div id='tribe-events-calendar-header' class="clearfix">
		<span class='tribe-events-calendar-buttons'> 
			<a class='tribe-events-button-on' href='<?php echo tribe_get_listview_link(); ?>'><?php _e('Event List', 'tribe-events-calendar'); ?></a>
			<a class='tribe-events-button-off' href='<?php echo tribe_get_gridview_link(); ?>'><?php _e('Calendar', 'tribe-events-calendar'); ?></a>
		</span>

		</div><!--tribe-events-calendar-header-->
	<?php endif; ?>
	<div id="tribe-events-loop" class="tribe-events-events post-list clearfix">
	
	<?php if (have_posts()) : ?>
	<?php $hasPosts = true; $first = true; ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php global $more; $more = false; ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('tribe-events-event clearfix'); ?> itemscope itemtype="http://schema.org/Event">
		<?php
		//	Show Date, then for each show preface it with the TIME ... down the line if there are more than one venue we can adapt, but for now no address/venue information is needed.
		?>
			<?php if ( tribe_is_new_event_day() && !tribe_is_day() && !tribe_is_multiday() ) : ?>
				<h2 class="event-day"><?php echo tribe_get_start_date(null, false, 'l, F d');?></h2>
			<?php endif; ?>
			<?php if( !tribe_is_day() && tribe_is_multiday() ) : ?>
				<h2 class="event-day"><?php echo tribe_get_start_date(null, false, 'l, F d');?> - <?php echo tribe_get_end_date(null, false, 'l, F d');?></h2>
			<?php endif; ?>
			<?php if ( tribe_is_day() && $first ) : $first = false; ?>
				<h2 class="event-day"><?php echo tribe_event_format_date(strtotime(get_query_var('eventDate')), false); ?></h2>
			<?php endif; ?>

			<?php
			//	Start:	Individual Events 	?>
			<div class="indiv-event">
				<div class="clearfix">
					<div class="list-thumbnail threecol first">
						<?php 
							if( has_post_thumbnail() ) {
								checkAndPrintThumbnail('bones-thumb-300');
							} else {
								print_event_team_thumb(); 
								wp_reset_postdata();
							}
						?>
					</div>
					<div class="ninecol last">
						<h4 class="event-time"><?php echo tribe_get_start_date(null, false, 'g:i a'); ?></h4>
						
						<?php the_title('<h4 class="event-title" itemprop="name"><a href="' . tribe_get_event_link() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h4>'); ?>
						
						<div class="entry-content tribe-events-event-entry" itemprop="description">
							&nbsp;
							<?php
							
								$content = get_the_content();
								$excerpt = '<p>' . substr($content,0,250).'...<!--more--></p>';

								if( $content == '' ) {
									print_event_team_description();
								} else {
									echo $excerpt; 
								}
							?>

							<p class="byline vcard"><?php echo get_the_term_list( $post->ID, 'tribe_events_cat', 'Filed under: ', ', ', '' ); ?> </p>

						</div> <!-- End tribe-events-event-entry -->
					</div> <!-- .ninecol -->
				</div>

				<div class="tribe-events-event-list-meta" itemprop="location" itemscope itemtype="http://schema.org/Place">
				<?php if (tribe_is_multiday() || !tribe_get_all_day()): ?>
					<?php
					// RIGHT HAND SIDE

					 // Ticket Form
					//	<a href="/event/irony-city-2013-01-18/?add-to-cart=185" rel="nofollow" data-product_id="185" class="add_to_cart_button button product_type_simple">Add Ticket to Cart</a>
					if (function_exists('tribe_get_ticket_form') && tribe_get_ticket_form()) { tribe_get_ticket_form(); } ?>
					<?php endif; ?>

				</div>
			</div> <!-- .indiv-event -->
		</div> <!-- End post -->

	<?php endwhile;// posts ?>
	<?php else :?>
		<div class="tribe-events-no-entry">
		<?php 
			$tribe_ecp = TribeEvents::instance();
			if ( is_tax( $tribe_ecp->get_event_taxonomy() ) ) {
				$cat = get_term_by( 'slug', get_query_var('term'), $tribe_ecp->get_event_taxonomy() );
				if( tribe_is_upcoming() ) {
					$is_cat_message = sprintf(__(' listed under %s. Check out past events for this category or view the full calendar.','tribe-events-calendar'),$cat->name);
				} else if( tribe_is_past() ) {
					$is_cat_message = sprintf(__(' listed under %s. Check out upcoming events for this category or view the full calendar.','tribe-events-calendar'),$cat->name);
				}
			}
		?>
		<?php if(tribe_is_day()): ?>
			<?php printf( __('No events scheduled for <strong>%s</strong>. Please try another day.', 'tribe-events-calendar'), date_i18n('F d, Y', strtotime(get_query_var('eventDate')))); ?>
		<?php endif; ?>

		<?php if(tribe_is_upcoming()){ ?>
			<?php _e('No upcoming events', 'tribe-events-calendar');
			echo !empty($is_cat_message) ? $is_cat_message : "."; ?>

		<?php }elseif(tribe_is_past()){ ?>
			<?php _e('No previous events' , 'tribe-events-calendar');
			echo !empty($is_cat_message) ? $is_cat_message : "."; ?>
		<?php } ?>
		</div>
	<?php endif; ?>


	</div><!-- #tribe-events-loop -->
	<div id="tribe-events-nav-below" class="tribe-events-nav prev-next clearfix">

		<div class="tribe-events-nav-previous"><?php 
		// Display Previous Page Navigation
		if( tribe_is_upcoming() && get_previous_posts_link() ) : ?>
			<?php previous_posts_link( '<span>'.__('&larr; Previous Events', 'tribe-events-calendar').'</span>' ); ?>
		<?php elseif( tribe_is_upcoming() && !get_previous_posts_link( ) ) : ?>
			<a href='<?php echo tribe_get_past_link(); ?>'><span><?php _e('&larr; Previous Events', 'tribe-events-calendar' ); ?></span></a>
		<?php elseif( tribe_is_past() && get_next_posts_link( ) ) : ?>
			<?php next_posts_link( '<span>'.__('&larr; Previous Events', 'tribe-events-calendar').'</span>' ); ?>
		<?php endif; ?>
		</div>

		<div class="tribe-events-nav-next"><?php
		// Display Next Page Navigation
		if( tribe_is_upcoming() && get_next_posts_link( ) ) : ?>
			<?php next_posts_link( '<span>'.__('Next Events &rarr;', 'tribe-events-calendar').'</span>' ); ?>
		<?php elseif( tribe_is_past() && get_previous_posts_link( ) ) : ?>
			<?php previous_posts_link( '<span>'.__('Next Events &rarr;', 'tribe-events-calendar').'</span>' ); // a little confusing but in 'past view' to see newer events you want the previous page ?>
		<?php elseif( tribe_is_past() && !get_previous_posts_link( ) ) : ?>
			<a href='<?php echo tribe_get_upcoming_link(); ?>'><span><?php _e('Next Events &rarr;', 'tribe-events-calendar'); ?></span></a>
		<?php endif; ?>
		</div>

	</div>
	<?php if ( !empty($hasPosts) && function_exists('tribe_get_ical_link') ): ?>
		<a title="<?php esc_attr_e('iCal Import', 'tribe-events-calendar'); ?>" class="ical" href="<?php echo tribe_get_ical_link(); ?>"><?php _e('iCal Import', 'tribe-events-calendar'); ?></a>
	<?php endif; ?>
</div>
