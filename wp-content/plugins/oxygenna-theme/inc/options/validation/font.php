<?php
/**
 * Checks for valid date
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

/**
 * Validates a date
 *
 * @package **THEME**
 * @since 1.0
 **/
class OxyFont {
    /**
     * Validates the option data
     *
     * @return validated options array
     * @since 1.0
     **/
    function validate( $field, $options, $new_options ) {

      $font = array();
      if(is_array($new_options[$field['id']])){
        $font = $new_options[$field['id']];
      }
      else{
        $font['font'] = $new_options[$field['id']];
      }

      if(isset($_POST) && !empty($_POST)){
        if(isset($_POST[$field['id'].'_variant']))
          $font['variant'] = $_POST[$field['id'].'_variant'];
        if(isset($_POST[$field['id'].'_provider']))
          $font['provider'] = $_POST[$field['id'].'_provider'];
        if(isset($_POST[$field['id'].'_subsets']))
          $font['subsets'] = $_POST[$field['id'].'_subsets'];
      }
      $options[$field['id']] = $font;
      update_option( THEME_SHORT .'-'. $field['id'], $font );
      return $options;
    }
}