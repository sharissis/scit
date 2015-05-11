<?php
function camera_manage(){
	if ($_GET['page']=='camera_manage') { 
	
global $content_width, $pix_plugindir;	
if ( ! isset( $content_width ) )
	$content_width = 920;

?>


<div class="inner_tabs_parent">
    <h3>Manage your slideshows:</h3>
    <div class="camera_inner_tabs dyna_tabs">
		<?php 
       $camera_added_slideshows = camera_get_option( 'camera_added_slideshows' );
		echo '<select id="sort_slideshow">';
        foreach($camera_added_slideshows as $option => $value) {
			echo '<option value="'.get_admin_url().'admin.php?page=camera_dynamic&slideshow='.sanitize_title($value).'">'.$value.'</option>';
        }
		echo '</select>';
        ?>
    </div>
</div><!-- .inner_tabs_parent -->

<div id="camera_tab_source">
	<div id="camera_tab_target">
    </div><!-- #camera_tab_target -->
</div><!-- #camera_tab_source -->
	
<?php 
	}
}

?>