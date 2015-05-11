<?php


$args = array( 
	'post_type' => 'scit_team'
	, 'posts_per_page' => 5
	, 'orderby' => 'rand'
	,
	//	Do not bring back "Exclude" Category
	array(
        'taxonomy'  => 'scit_team-category', // taxonomy = custom post type category
        'field'     => 'slug',
        'terms'     => 'exclude', // terms = Category
        'operator'  => 'NOT IN')
	// Only bring back if they have an image.
	, 'meta_key'=>'_thumbnail_id'
	);

	$loop = new WP_Query( $args );
				
	if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); ?>
	
    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix team-home'); ?> role="article">
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
		    <!-- <h3 class="h4 team-name"><?php the_title(); ?></h3> -->
			<?php checkAndPrintThumbnail('bones-thumb-300'); ?>

	    </a>
	</article> <!-- end article -->

<?php endwhile; ?>

<?php endif; ?>