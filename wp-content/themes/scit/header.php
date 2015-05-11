<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php bloginfo('name'); ?> | <?php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons  -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<meta property="og:image" content="http://steelcityimprov.com/assets/scit/img/logo/header.jpg" />
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head();
		//<script type="text/javascript" src="/assets/global/js/plugins/jquery.reveal.js"></script>
		 ?>
		 <!-- end of wordpress head -->

		

	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="header" role="banner">
				<?php	//php is_home() || is_front_page() ? bloginfo('description') : wp_title(''); ?>
				<?php

				//	2013.05.27:	First Attempt at putting in a SALES Header.  Need to still allow ability to get to "Home" Page on Mobile, I feel.

				$isSale = 0;	// 	If no Sale is going on.
				//$isSale = 1; 	//	If there is a Sale

				if ($isSale == 0) {
					$headerImage	= get_template_directory_uri()."/library/images/header_logo.png";
					//$headerImage 	= get_template_directory_uri()."/library/images/scit-header-006e.jpg";
					//$headerImage 	= "http://steelcityimprov.com/wp-content/uploads/2013/04/header-test.png";
					$headerHref		= "/";
					$headerTitle 	= "Home";
					$headerId 		= "logo";
				}
				else {
					//$headerImage	= "/assets/scit/special/scit-improv-level-one-class-sale.png";
					$headerImage	= get_template_directory_uri()."/library/images/header_sale.png";
					$headerHref		= "/shop/level-one-the-principles-of-improv-2013-06-15/";
					$headerTitle 	= "LEVEL ONE SALE!";
					$headerId 		= "sale";
				}


					if ((is_home() || is_front_page() == true) && $isSale == 0) {
						echo "<div id=\"logo\"><img src=\"".$headerImage."\" id=\"".$headerId."\" /></div>";
					}
					else {
						echo "<div id=\"logo\"><a href=\"".$headerHref."\" title=\"".$headerTitle."\"><img src=\"".$headerImage."\" id=\"".$headerId."\" /></a></div>";
					}

				?>
				
				<div class="clearfix">
					
					<!-- <a href="<?php echo home_url(); ?>" rel="nofollow" class="threecol first"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo_new.png" id="logo" /></a> -->
					<nav class="clearfix top-bar" role="navigation">
						<div class="wrap">
							<?php bones_main_nav(); ?>
						</div>
					</nav>
				</div>
			

				<!--<div id="inner-header" class="wrap clearfix">
				</div> end #inner-header -->

				<div class="visible-phone text-center">
					<a href="tel:1-412-404-2695">+1 (412) 404-2695</a>
					<br />
					5950 Ellsworth Ave, Pittsburgh PA 15232<br />
					(Corner of Ellsworth and Greenbriar)<br/>
					<a href="https://maps.google.com/maps?q=Greenbriar+Way+%26+Ellsworth+Ave.,+Pittsburgh,+PA&hl=en&sll=40.431368,-79.9805&sspn=0.223438,0.528374&hnear=Ellsworth+Ave+%26+Greenbriar+Way,+Pittsburgh,+Allegheny,+Pennsylvania+15232&t=m&z=17&iwloc=A" target="_blank">Click here for Google Map</a>
				</div>


			</header> <!-- end header -->
