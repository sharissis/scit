<?php
/**
 * Radio Option
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
 * Creates radio option using jquery ui
 */
class OxyRadio extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'radio' );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render( $echo = true ) { ?>
        <div class="ui-radio">
        <?php
        foreach( $this->_field['options'] as $key => $label ) {
            // set radio options
            $this->set_attr( 'id', $this->_field['id'] . '_' . $key );
            $this->set_attr( 'value', $key );
            // create radio and label
            echo '<input ' . $this->create_attributes() . checked($this->_value, $key, false) . ' />';
            echo '<label for="' . $this->_field['id'] . '_' . $key . '">' . $label . '</label>';
        } ?>
        </div>
    <?php
    }

    public function enqueue() {
        parent::enqueue();
        // load styles
        wp_enqueue_style( 'jquery-oxygenna-ui-theme' );
        // load scripts
        wp_enqueue_script( 'radio-field', OXY_FRAMEWORK_URI . 'options/fields/radio/radio.js', array( 'jquery-ui-button' ) );
    }
}