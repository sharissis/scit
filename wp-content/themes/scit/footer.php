			<footer class="footer" role="contentinfo">
			
				<div id="inner-footer" class="wrap">
					<div class="clearfix">					
 						<?php get_sidebar('footerleft'); ?>
						<?php get_sidebar('footercenter'); ?>
						<?php get_sidebar('footerright'); ?>
					</div>
					
					<p class="source-org copyright">
						&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
					</p>
				
				</div> <!-- end #inner-footer -->
				
			</footer> <!-- end footer -->
		
		</div> <!-- end #container -->
		
		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>
		<!-- Google Analytics -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-40555873-1', 'steelcityimprov.com');
		  ga('send', 'pageview');

		</script>
	</body>

</html> <!-- end page. what a ride! -->