<?php
/**
 * Text option
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
 * Simple Text Input Box
 */
class OxyPreview extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'value', esc_attr( $value ) );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render() {
        echo '<div '. $this->create_attributes() .'><h' . $this->_field['size'] . '>'.$this->_field['heading'].'</h' . $this->_field['size'] . '><p>' . $this->_field['default'] . '</p></div>';
    }
}