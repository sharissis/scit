<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db
if(empty($options[ $id ])){
	$options[ $id ] = '';
}

echo '<strong>'.home_url()."/</strong><input id='$id' class='all-options' name='{$setting_id}[$id]' type='text' value='" . esc_attr( $options[ $id ] ) . "' /><br>";