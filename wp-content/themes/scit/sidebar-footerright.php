				<div id="footerright" class="sidebar fourcol last clearfix" role="complementary">

					<?php if ( is_active_sidebar( 'footerright' ) ) : ?>

						<?php dynamic_sidebar( 'footerright' ); ?>

					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the backend. -->
						
						<div class="alert help">
							<p><?php _e("Please activate some Widgets.", "bonestheme");  ?></p>
						</div>

					<?php endif; ?>

				</div>