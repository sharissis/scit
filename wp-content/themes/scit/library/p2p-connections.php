<?php
global $post;
// Post to Post connection functions for templates


///////////////////
// Performers to Teams
///////////////////

function scit_connected_performers_to_teams() {
    
    // Get post ID    
    $post_id = get_the_id();
    
    // Find connected Performers
    $performerQuery = new WP_Query( array(
        'connected_type' => 'scit_performers_to_teams',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );

    // Collect connected post's data
    while ( $performerQuery->have_posts() ) : $performerQuery->the_post();
        $performerId = get_the_id();
        $performerTitle = get_the_title();
        $performerLink = get_permalink();

        $performerExclude = get_the_term_list( $post->ID, 'scit_performer-category');
        if (strpos($performerExclude,'Exclude')>0) {
            $performerQueryResult = $performerQueryResult.'<li>'.$performerTitle.'</li> ';
        }
        else {
            $performerQueryResult = $performerQueryResult.'<li><a href="'.$performerLink.'">'.$performerTitle.'</a></li> ';
        }
   




    endwhile;
    
    if ($performerQueryResult != '') {
        // Use appropriate titles for performer vs team page
        if (is_singular( 'scit_performer' )) {
            echo '<p class="h5 featuring">Performs with:</p>';       
        } else if (is_singular( 'scit_team' )) {
            if(is_)
            echo '<p class="h5 featuring">The Players:</p>';
        }
        echo '<ul>'.$performerQueryResult.'</ul>';
    }

    wp_reset_postdata(); // set $post back to original post
}

///////////////////
// Teams to Events
///////////////////

function scit_connected_teams_to_events() {
    
    // Set $post back to original post
    wp_reset_postdata(); 
    
    // Find connected pages    
    $post_id = get_the_id();
    
    // Find connected posts: Events
    $teamEventQuery = new WP_Query( array(
        'connected_type' => 'scit_teams_to_events',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    
    while ( $teamEventQuery->have_posts() ) : $teamEventQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        $eventDate = tribe_get_start_date(null, false, 'l, F d, ga');
        ob_start();
        the_content();
        $eventDescription = ob_get_clean();
        $eventFeaturedImage = get_the_post_thumbnail($eventId, 'FULL');
        
        $eventExclude = get_the_term_list( $post->ID, 'scit_team-category');
        // Displays events on the teams page
        if (strpos($eventExclude,'Exclude')>0) {
            $eventQueryResult = $eventQueryResult.'<li>'.$eventTitle.'</li> ';
        }
        else {
            $eventQueryResult = $eventQueryResult.'<li><a href="'.$eventLink.'">'.$eventTitle.'</a></li> ';
        }
   
        // Displays teams on the events page
        if (strpos($eventExclude,'Exclude')>0) {
            $teamPageQueryResult = $teamPageQueryResult.'<li>'.$eventDate.'</li> ';
        }
        else {
            $teamPageQueryResult = $teamPageQueryResult.'<li><a href="'.$eventLink.'">'.$eventDate.'</a></li> ';
        }

    endwhile;

    // Determine data display based on page - probably not the best way to do this
    if ($eventQueryResult != '') {
        if( is_singular('scit_team')) {
            echo '<p class="h5 featuring">Upcoming shows: </p>';  
            echo '<ul>' . $teamPageQueryResult . '</ul>';
        } else if( is_singular('tribe_events')) {
            echo '<p class="h5 featuring">Featuring: </p>';  
            echo '<ul>' . $eventQueryResult . '</ul>';    
        }
    }
    
    wp_reset_postdata(); // set $post back to original post
}


///////////////////
// Teams to Events Featured
///////////////////

function scit_connected_teams_to_events_Featured() {
    // Set $post back to original post
    wp_reset_postdata(); 
    
    // Find connected pages    
    $post_id = get_the_id();
    
    // Find connected posts: Events
    $teamEventFeaturedQuery = new WP_Query( array(
        'connected_type' => 'scit_teams_to_events_Featured',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
     

    while ( $teamEventFeaturedQuery->have_posts() ) : $teamEventFeaturedQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        $eventDate = tribe_get_start_date(null, false, 'l, F d, ga');

        ob_start();
        the_content();
        $eventDescription = ob_get_clean();
        $eventFeaturedImage = get_the_post_thumbnail($eventId, 'FULL');
        

        $eventExclude = get_the_term_list( $post->ID, 'scit_team-category');
        // Displays events on the teams page
        if (strpos($eventExclude,'Exclude')>0) {
            $eventQueryResult = $eventQueryResult.'<li>'.$eventTitle.'</li> ';
        }
        else {
            $eventQueryResult = $eventQueryResult.'<li><a href="'.$eventLink.'">'.$eventTitle.'</a></li> ';
        }
   
        // Displays teams on the events page
        if (strpos($eventExclude,'Exclude')>0) {
            $teamPageQueryResult = $teamPageQueryResult.'<li>'.$eventDate.'</li> ';
        }
        else {
            $teamPageQueryResult = $teamPageQueryResult.'<li><a href="'.$eventLink.'">'.$eventDate.'</a></li> ';
        }


    endwhile;

    // Determine whether team or event page and show corresponding data
    if ($eventQueryResult != '') {
        if( is_singular('scit_team')) {
            echo '<p class="h5 featuring">Upcoming shows: </p>';  
            echo '<ul>' . $teamPageQueryResult . '</ul>';
        } else if( is_singular('tribe_events')) {
            echo '<p class="h5 featuring">With: </p>';  
            echo '<ul>' . $eventQueryResult . '</ul>';    
        }
    }
    
    wp_reset_postdata(); // set $post back to original post
}


///////////////////
// Performers to Events
///////////////////

function scit_connected_performers_to_events() {
    
    // Set $post back to original post
    wp_reset_postdata(); 
    
    // Find connected pages    
    $post_id = get_the_id();
    
    // Find connected posts: Events
    $openerQuery = new WP_Query( array(
        'connected_type' => 'scit_events_to_performers_Featured',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    
    while ( $openerQuery->have_posts() ) : $openerQuery->the_post();
        $openerId = get_the_id();
        $openerTitle = get_the_title();
        $openerLink = get_permalink();
        //$openerDescription = the_content();
        ob_start();
        the_content();
        $openerDescription = ob_get_clean();
        $openerFeaturedImage = get_the_post_thumbnail($openerId, 'FULL');
        

        $openerExclude = get_the_term_list( $post->ID, 'scit_performer-category');
        if (strpos($openerExclude,'Exclude')>0) {
            $openerQueryResult = $openerQueryResult.'<li>'.$openerTitle.'</li> ';
        }
        else {
            $openerQueryResult = $openerQueryResult.'<li><a href="'.$openerLink.'">'.$openerTitle.'</a></li> ';
        }
    endwhile;
    
    wp_reset_postdata(); // set $post back to original post
    
    // If there is an opener, show it
    if ($openerQueryResult != '') {
        echo '<h5 class="opener">With: </h5>';  
        echo '<ul>'.$openerQueryResult.'</ul>';
        echo '</p>';
    }
    
    wp_reset_postdata(); // set $post back to original post
}

///////////////////
// Products to Performers
///////////////////
// (Woocommerce product type)

function scit_connected_products_to_performers() {
    wp_reset_postdata();
    // Get post ID    
    $post_id = get_the_id();
    
    // Find connected Performers
    $performerQuery = new WP_Query( array(
        'connected_type' => 'scit_products_to_performers',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    
    // Collect connected post's data
        while ( $performerQuery->have_posts() ) : $performerQuery->the_post();
            $performerId = get_the_id();
            $performerTitle = get_the_title();
            $performerLink = get_permalink();
            $performerThumb = get_the_post_thumbnail();
            
            if (is_singular('product') ) { 
                ?>
                &nbsp;
                <section class="clearfix">                 
                    <div class="header-thumb">
                        <?php checkAndPrintThumbnail('bones-thumb-300'); ?>
                    </div>
                    <div class="header-info">
                        <h3><a href="<?php echo $performerLink; ?>"><?php the_title(); ?></a></h3> 
                        <?php the_excerpt(); ?>
                    </div>
                </section>
            <?php } else { ?>
                <p class="instructor">With <a href="<?php echo $performerLink; ?>"><?php echo $performerTitle; ?></a></p>
            <?php }

        endwhile;
    
        wp_reset_postdata(); // set $post back to original post
}


///////////////////
// Products to Courses
///////////////////
// Woocommerce products to curriculum post type

function scit_connected_products_to_courses() {
    
    // Get post ID    
    $post_id = get_the_id();
    
    // Find connected Courses
    $courseQuery = new WP_Query( array(
        'connected_type' => 'scit_products_to_courses',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );

    // Collect connected post's data
        while ( $courseQuery->have_posts() ) : $courseQuery->the_post();
            $courseId = get_the_id();
            $courseTitle = get_the_title();
            $courseLink = get_permalink();
            $courseThumb = get_the_post_thumbnail();
            
            if (is_singular('product') ) { 
                ?>
                <p>
                    <?php the_content(); ?>
                </p>
            <?php } else { ?>
                <p class="instructor">Course Description: <a href="<?php echo $courseLink; ?>"><?php echo $courseTitle; ?></a></p>   
            <?php }

        endwhile;
    
        wp_reset_postdata(); // set $post back to original post
}

///////////////////
// Courses to Performers
///////////////////
// Redundant: same as Products to Performers, except to the course post type
function scit_connected_courses_to_performers() {
    wp_reset_postdata();

    // Get post ID    
    $post_id = get_the_id();
    
    // Find connected Performers
    $performerQuery = new WP_Query( array(
        'connected_type' => 'scit_curriculum_to_performers',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    
    // Collect connected post's data
        while ( $performerQuery->have_posts() ) : $performerQuery->the_post();
            $performerId = get_the_id();
            $performerTitle = get_the_title();
            $performerLink = get_permalink();
            $performerThumb = get_the_post_thumbnail();
            
            if (is_singular('scit_course') ) { 
                ?>
                &nbsp;
                <section class="clearfix">
                    <div class="header-thumb">
                        <?php checkAndPrintThumbnail('bones-thumb-300'); ?>
                    </div>
                    <div class="header-info">
                        <h3><a href="<?php echo $performerLink; ?>"><?php the_title(); ?></a></h3> 
                        <?php the_excerpt(); ?>
                    </div>
                </section>
            <?php } else { ?>
                <p class="instructor">With <a href="<?php echo $performerLink; ?>"><?php echo $performerTitle; ?></a></p>
            <?php }

        endwhile;
    
        wp_reset_postdata(); // set $post back to original post
}


function print_event_team_description() {
    $post_id = get_the_id();
    $teamQuery = new WP_Query( array(
        'connected_type' => 'scit_teams_to_events',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );

    while ( $teamQuery->have_posts() ) : $teamQuery->the_post();
        $teamDesc = the_content();
        $teamExcerpt = substr($teamDesc,0,10).'...';
    endwhile;

    if(is_singular('tribe_events')) {
        echo $teamDesc;    
    } else {
        echo $teamExcerpt;
    }
    
    wp_reset_postdata();
}

function print_event_team_thumb() {
    $post_id = get_the_id();
    $teamQuery = new WP_Query( array(
        'connected_type' => 'scit_teams_to_events',
        'connected_items' => $post_id,
        'nopaging' => true,
        'reciprocal' => false,
        'meta_key'    => '_thumbnail_id'
    ) );
    while ( $teamQuery->have_posts() ) : $teamQuery->the_post();
        
        // Do not grab thumbnail... actually grab the large image per request.

        //$thumb = get_the_post_thumbnail();
        $thumb = the_post_thumbnail('');
    endwhile;

    if(!has_post_thumbnail()) {
        //checkAndPrintThumbnail('bones-300');
        //
        echo $thumb;
    } else {
        echo $thumb;
    }
    
    //wp_reset_postdata();
}



function scit_strip_datestamp_from_title() {
    //wp_reset_postdata();
    // Get post ID    
    $post_id = $post->ID;
    //
    $format = "Y-m-d";
    $title      = get_the_title();
    $titleLength = strlen($title);
    $titleDate = substr($title, ($titleLength-10));
    // Fuck, this is PHP 5.3 or higher.
    // $date = DateTime::createFromFormat($format, $titleDate);
    // if ($date == false || !(date_format($date,$format) == $titleDate) ) 
    //  { $title = $title; }
    // else
    //  { $title = substr($title, 0, ($titleLength-11)); }

    // < 5.3.0 (Hostgator...)
    $titleDate = strtotime($titleDate);
    if ($titleDate > 0)
        { $title = substr($title, 0, ($titleLength-11));  }
    else
        { $title = $title; }

    echo $title;
}


function scit_connected_performers_to_teams_Alpha() {

    // Get post ID    
    $post_id = get_the_id();
    
    //
    //
    //  Everything below this line is custom code to bring back stuff in alphabetical order and the like ... I want it to be as clean as above. -JSF
    //
    //
    //
    //  Custom Post-To-Post Shizzle
    $weekSundayTime = strtotime('Sunday this week');
    $thisSun = strtotime('last Sunday', $weekSundayTime);
    $thisMon = strtotime('last Monday', $weekSundayTime);
    $thisTue = strtotime('last Tuesday', $weekSundayTime);
    $thisWed = strtotime('last Wednesday', $weekSundayTime);
    $thisThu = strtotime('last Thursday', $weekSundayTime);
    $thisFri = strtotime('last Friday', $weekSundayTime);
    $thisSat = strtotime('last Saturday', $weekSundayTime);

    $current_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime('60 days'));

    $get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date,'eventDisplay'=>'upcoming','posts_per_page'=>20) );
    ?>
    <?php
    // Find connected pages
    //  TEAMS #1
    $post_id = get_the_id();
    $teamQuery = new WP_Query( array(
        'connected_type' => 'scit_performers_to_teams',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    // Display connected pages
    while ( $teamQuery->have_posts() ) : $teamQuery->the_post();
        $teamId = get_the_id();
        $teamTitle = get_the_title();
        $teamLink = get_permalink();
        //
        $exclude = get_the_term_list( $post->ID, 'scit_performer-category');
        if (strpos($exclude,'Exclude')>0) {
            $playerArray[] = ''.$teamTitle.'</a><br/>';
        }
        else {
            $playerArray[] = '<a href="'.$teamLink.'">'.$teamTitle.'</a><br/>';
        }
        
        
    endwhile;

    //
    //  EVENTS #2
    wp_reset_postdata(); // set $post back to original post
    // Find connected pages
    $userEventQuery = new WP_Query( array(
            'connected_type' => 'scit_teams_to_events'
            , 'connected_items' => $post
            , 'nopaging' => true
            , 'start_date'=>$current_date
            , 'end_date'=>$end_date
            , 'eventDisplay'=>'upcoming'
            // // , 'posts_per_page'=>20
            // , 'meta_key' => 'start_date'
            // , 'meta_value'=>time()
            , 'orderby' => 'start_date'
            , 'order' => 'DESC'
        ) );
    //Display connected pages
    while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        //
        //$eventDate = "mykey"; $eventDate get_post_meta($eventId, $eventDate, true);
        $eventDate = tribe_get_start_date(null, false, 'l, F d');
        $sortDate = tribe_get_start_date(null, false, 'Y-m-d');
        //
        $exclude = get_the_term_list( $post->ID, 'scit_team-category');
        if (strpos($exclude,'Exclude')>0) {
            $eventArray[] = ''.$eventTitle.'</a><br/>';
        }
        else {
            $eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
        }

    endwhile;
    wp_reset_postdata(); // set $post back to original post
    //
    //
    //  EVENTS #2
    // Find connected pages
    $userEventQuery = new WP_Query( array(
            'connected_type' => 'scit_openers_to_events',
            'connected_items' => $post,
            'nopaging' => true
                , 'start_date'=>$current_date
                , 'end_date'=>$end_date
                , 'eventDisplay'=>'upcoming'
                , 'posts_per_page'=>20
                    // , 'meta_key' => 'start_date'
                    , 'orderby' => 'start_date'
                    , 'order' => 'DESC'
            

        ) );
    //Display connected pages
    while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        //
        //$openingActDate = "mykey"; $openingActDate get_post_meta($eventId, $openingActDate, true);
        $openingActDate = tribe_get_start_date(null, false, 'l, F d');
        $sortActDate = tribe_get_start_date(null, false, 'Y-m-d');

        //
        $exclude = get_the_term_list( $post->ID, 'scit_team-category');
        if (strpos($exclude,'Exclude')>0) {
            $eventArray[] = ''.$eventTitle.'</a><br/>';
        }
        else {
            $eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
        }
        // 
    endwhile;
    wp_reset_postdata(); // set $post back to original post

    if ($playerArray <> null) {
        // echo rtrim($teamQueryResult, ', ').'<br/><br/>';
        sort($playerArray);
        $playerArrayLength=count($playerArray);
        for($x=0;$x<$playerArrayLength;$x++)
           {
           echo $playerArray[$x];
           //echo "<br>";
           }
    }

}

function scit_connected_events_to_teams_Alpha() {

    // Get post ID    
    $post_id = get_the_id();
    
    //
    //
    //  Everything below this line is custom code to bring back stuff in alphabetical order and the like ... I want it to be as clean as above. -JSF
    //
    //
    //
    //  Custom Post-To-Post Shizzle
    $weekSundayTime = strtotime('Sunday this week');
    $thisSun = strtotime('last Sunday', $weekSundayTime);
    $thisMon = strtotime('last Monday', $weekSundayTime);
    $thisTue = strtotime('last Tuesday', $weekSundayTime);
    $thisWed = strtotime('last Wednesday', $weekSundayTime);
    $thisThu = strtotime('last Thursday', $weekSundayTime);
    $thisFri = strtotime('last Friday', $weekSundayTime);
    $thisSat = strtotime('last Saturday', $weekSundayTime);

    $current_date = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime('60 days'));

    $get_posts = tribe_get_events(array('start_date'=>$current_date,'end_date'=>$end_date,'eventDisplay'=>'upcoming','posts_per_page'=>20) );
    ?>
    <?php
    // Find connected pages
    //  TEAMS #1
    $post_id = get_the_id();
    $teamQuery = new WP_Query( array(
        'connected_type' => 'scit_performers_to_teams',
        'connected_items' => $post_id,
        'nopaging' => true
    ) );
    // Display connected pages
    while ( $teamQuery->have_posts() ) : $teamQuery->the_post();
        $teamId = get_the_id();
        $teamTitle = get_the_title();
        $teamLink = get_permalink();
        //
        $exclude = get_the_term_list( $post->ID, 'scit_performer-category');
        if (strpos($exclude,'Exclude')>0) {
            $playerArray[] = ''.$teamTitle.'</a><br/>';
        }
        else {
            $playerArray[] = '<a href="'.$teamLink.'">'.$teamTitle.'</a><br/>';
        }
        
    endwhile;

    //
    //  EVENTS #2
    wp_reset_postdata(); // set $post back to original post
    // Find connected pages
    $userEventQuery = new WP_Query( array(
            'connected_type' => 'scit_teams_to_events'
            , 'connected_items' => $post
            , 'nopaging' => true
            , 'start_date'=>$current_date
            , 'end_date'=>$end_date
            , 'eventDisplay'=>'upcoming'
            // // , 'posts_per_page'=>20
            // , 'meta_key' => 'start_date'
            // , 'meta_value'=>time()
            , 'orderby' => 'start_date'
            , 'order' => 'DESC'
        ) );
    //Display connected pages
    while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        //
        //$eventDate = "mykey"; $eventDate get_post_meta($eventId, $eventDate, true);
        $eventDate = tribe_get_start_date(null, false, 'l, F d');
        $sortDate = tribe_get_start_date(null, false, 'Y-m-d');
        //
        //
        $exclude = get_the_term_list( $post->ID, 'scit_team-category');
        if (strpos($exclude,'Exclude')>0) {
            $eventArray[] = ''.$eventTitle.'</a><br/>';
        }
        else {
            $eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
        }
        // 
    endwhile;
    wp_reset_postdata(); // set $post back to original post
    //
    //
    //  EVENTS #2
    // Find connected pages
    $userEventQuery = new WP_Query( array(
            'connected_type' => 'scit_openers_to_events',
            'connected_items' => $post,
            'nopaging' => true
                , 'start_date'=>$current_date
                , 'end_date'=>$end_date
                , 'eventDisplay'=>'upcoming'
                , 'posts_per_page'=>20
                    // , 'meta_key' => 'start_date'
                    , 'orderby' => 'start_date'
                    , 'order' => 'DESC'
            

        ) );
    //Display connected pages
    while ( $userEventQuery->have_posts() ) : $userEventQuery->the_post();
        $eventId = get_the_id();
        $eventTitle = get_the_title();
        $eventLink = get_permalink();
        //
        //$openingActDate = "mykey"; $openingActDate get_post_meta($eventId, $openingActDate, true);
        $openingActDate = tribe_get_start_date(null, false, 'l, F d');
        $sortActDate = tribe_get_start_date(null, false, 'Y-m-d');

        //
        //
        $exclude = get_the_term_list( $post->ID, 'scit_team-category');
        if (strpos($exclude,'Exclude')>0) {
            $eventArray[] = ''.$eventTitle.'</a><br/>';
        }
        else {
            $eventArray[] = '<a class="'.$sortDate.'" href="'.$eventLink.'">'.$eventTitle.'</a>: '.$eventDate.'<br/>';
        }
        // 
    endwhile;
    wp_reset_postdata(); // set $post back to original post

    if ($eventArray <> null) {
    // echo rtrim($eventQueryResult, ', ').'<br/>';
    sort($eventArray);
    $eventArrayLength=count($eventArray);
    for($x=0;$x<$eventArrayLength;$x++)
       {
       echo $eventArray[$x];
       //echo "<br>";
       }
     }
     else {
        echo "<em>No upcoming shows.</em>";
     }

}


?>