<div class="home-feed clearfix">
	<?php
	    $args = array(
	        'post_type' => 'post'
	        , 'posts_per_page'=>5
	    );

	    $post_query = new WP_Query($args);
	if($post_query->have_posts() ) {
	  while($post_query->have_posts() ) {
	    $post_query->the_post(); ?>

		<h1 class="h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p class="byline vcard"><?php
		// printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', '));
		printf(__('Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')));		?></p>
	    
	    <?php
	  }
	}
	?>
	
	<a class="button last" href="/blog/" title="News">See all...</a>
</div>