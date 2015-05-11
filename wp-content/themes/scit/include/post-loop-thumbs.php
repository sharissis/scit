

	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix archive-thumb-article'); ?> role="article">
		
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<div class="archive-thumb">
					<?php checkAndPrintThumbnail('bones-thumb-300'); ?>
				</div>
				<h3 class="h4 team-name"><?php the_title(); ?></h3>
			</a>
		
	</article> <!-- end article -->