<?php 
	// Disclaimer:

	// Yes, I hate myself for doing this. 
	// In the interest of TIME, well, all of this content is in the post editor.
	// Complete with a wealth of permalinks.
	// Until we determine the best handling of courses, drop-ins and other shit.

	// Disclaimer Response from Jerome:
	// Hahah, nice one.  Agreed.  We can hand-hold when/where appropriate if they decide to add a lot of Classes all of a sudden!
?>

<!-- <h4 class="event-day">Courses</h4> -->
<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/shop/advancing-game-through-character/">Advancing Game Through Character</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/shop/advancing-game-through-character/">Michael Capristo</a><br />
Saturday, August 17th, 2013<br />
Prerequisite: Improv Level Two or Equivalent Experience<br />
<br/>
<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/shop/level-one-foundations-of-improv-2013-7-31/">Level One: Foundations of Improv</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/shop/level-one-foundations-of-improv-2013-7-31/">Justin Zell</a><br />
Begins Wednesday, July 31st, 2013<br />
Prerequisite: None<br />
<br/>
<?php
// requested by Zell to remove the Drop-In Classes from the Main Page. -20130506
// Assuming this may need to come back, wnated to keep the code commented out in PHP. -jsf
/*
<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/shop/level-two-building-a-dynamic-scene-2013-07-24/">Level Two: Building a Dynamic Scene</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/performers/woody-drennan/">Woody Drennan</a><br />
Begins Wednesday, July 24th, 2013<br />
Prerequisite: Level One<br />
<span style="color: red;"><em>Sale Price ends <strong>June 29th</strong></em></span>
<br/>
<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/shop/level-one-the-principles-of-improv-2013-06-15/">Level One: The Principles of Improv</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/performers/justin-zell/">Justin Zell</a><br />
Begins Saturday, June 15, 2013<br />
Prerequisite: NONE<br />
<span style="color: red;"><em><strong>Sold out!</strong></em></span>

<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/shop/level-two-scene-work-2013-06-05//">Level Two: Scene Work</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/performers/justin-zell/">Justin Zell</a><br />
Begins Wednesday, June 05, 2013<br />
Prerequisite: <a href="<?php echo get_bloginfo('url'); ?>/curriculum/level-one-the-principles-of-improv/">Level One</a><br />
<!-- <span style="color: red;"><em>Special Price until May 21st.</em></span> -->
<br/>

<br />
<br />
<h4 class="event-day">Drop In Classes (Pay-as-you-go)</h4>

<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/curriculum/learn-to-play/">Improv Booster Shot</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/performers/ayne-terceira/">Ayne Terciera</a><br />
Every Saturday 12-3pm<br />
Recommended Level One and up<br />

<h5 class="h4"><a href="<?php echo get_bloginfo('url'); ?>/curriculum/learn-to-play/">Learn to Play</a></h5>
with <a href="<?php echo get_bloginfo('url'); ?>/performers/keara-kelly/">Keara Kelly</a><br />
Every Saturday 3-6pm<br />
Recommended Absolute Beginners! <br />
*/
?>
<?php
	/* 

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 3,
		'product_cat' => 'courses',
		);
	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) { ?>
		<div class="home-feed clearfix">
			<h3>Courses</h3>
			<ul class="products">
		<?php while ( $loop->have_posts() ) : $loop->the_post();
			woocommerce_get_template_part( 'content', 'product-home' );
		endwhile; ?>
			</ul><!-- .products -->
	</div>

<?php } */ ?>
	
<?php
	/* $args = array(
		'post_type' => 'product',
		'posts_per_page' => 3,
		'product_cat' => 'workshops',
		);
	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) { ?>

		<div class="home-feed clearfix">
			<h3>Workshops</h3>
			<ul class="products">

			<?php while ( $loop->have_posts() ) : $loop->the_post();
				woocommerce_get_template_part( 'content', 'product-home' );
			endwhile; ?>
			</ul><!-- .products -->
		</div>

<?php } ?>
	
<div class="home-feed clearfix">

	<h3 class=>Drop-in Classes<span style="color: red; font-size: 0.7em;"><em> New!</em></span></h3>
	<?php the_content(); ?>
</div>

</section>

<?php
/*$args = array(
	'post_type' => 'tribe_events',
	'posts_per_page' => 3,
	'tribe_events_cat' => 'drop-ins',
	);
$loop = new WP_Query( $args );
if ( $loop->have_posts() ) { ?>

<section>
	<h3 class="h1 page-title">Drop-in Classes<span style="color: red; font-size: 0.7em;"><em> New!</em></span></h3>
	
	<div class="home-feed clearfix">
		
		<ul class="products">

		<?php while ( $loop->have_posts() ) : $loop->the_post();
			the_content();
			woocommerce_get_template_part( 'content', 'product-home' );
		endwhile; ?>
		</ul><!-- .products -->
	</div>
	<a class="button last">See all...</a>
</section>

<?php }*/ 


// Moving the see all link to the home page so this template can be reused on the classes page?>

<!-- <a class="button last" href="<?php //echo get_permalink( get_page_by_title( 'Classes' ) ); ?>">See all...</a> -->