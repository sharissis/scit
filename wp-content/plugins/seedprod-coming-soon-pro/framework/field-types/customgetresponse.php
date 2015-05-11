<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db
$ajax_url = html_entity_decode(wp_nonce_url('admin-ajax.php?action=seed_csp3_refresh_list','seed_csp3_refresh_list'));


echo "<select id='$id' class='" . ( empty( $class ) ? '' : $class ) . "' name='{$setting_id}[$id]'>";
foreach ( $option_values as $k => $v ) {
	if(is_array($v)){
		echo '<optgroup label="'.ucwords($k).'">';
		foreach ( $v as $k1=>$v1 ) {
			echo "<option value='$k1' " . selected( $options[ $id ], $k1, false ) . ">$v1</option>";
		}
		echo '</optgroup>';
	}else{
    	echo "<option value='$k' " . selected( $options[ $id ], $k, false ) . ">$v</option>";
	}
}
echo "</select>";

echo "<button id='seed_csp3_getresponse_refresh' type='button' class='button-secondary'>".__('Refresh List','seedprod')."</button>"
?>
<script type='text/javascript'>
jQuery(document).ready(function($) {
    $('#seed_csp3_getresponse_refresh').click(function() {
    	$('#seed_csp3_getresponse_refresh').attr("disabled", "disabled");
        apikey = $('#getresponse_api_key').val();
        $.get('<?php echo $ajax_url; ?>&provider=getresponse&apikey='+apikey, function(data) {
          lists = $.parseJSON(data);
          if(lists){
              $('#getresponse_listid').html('');
          }
          $.each(lists,function(k,v){
              $('#getresponse_listid').prepend('<option value=\"'+k+'\">'+v+'</option>');
          });
          $('#seed_csp3_getresponse_refresh').html('Lists Refreshed');
        });
    }); 
});
</script>