<?php
/**
 * Slider Option
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
 * Creates slider bar option
 */
class OxySlider extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'text' );
        $this->set_attr( 'class', 'slider-option' );
        $this->set_attr( 'value', floatval( $value ) );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render( $echo = true ) { ?>
        <div></div>
        <input <?php echo $this->create_attributes(); ?> />
    <?php
    }

    public function enqueue() {
        parent::enqueue();
        // load styles
        wp_enqueue_style( 'jquery-oxygenna-ui-theme' );
        // load scripts
        wp_enqueue_script( 'slider-field', OXY_FRAMEWORK_URI . 'options/fields/slider/slider.js', array( 'jquery-ui-slider' ) );
    }
}