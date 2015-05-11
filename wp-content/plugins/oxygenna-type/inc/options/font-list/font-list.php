<?php
/**
 * Font list for selecting fonts to load
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

require_once OXY_TYPE_DIR . 'options/font-select/font-select.php';

/**
 * Simple Text Input Box
 */
class OxyFontlist extends OxyOption {

    private $add_font_select;

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'text' );
        $this->set_attr( 'value', esc_attr( $value ) );

        $this->add_font_select = new OxyFontselect( array(), array(), array( 'id' => 'fontstack-select') );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render() { ?>
        <table id="fontstack-list" class="widefat">
            <thead>
                <tr>
                    <th>Font</th>
                    <th>Provider</th>
                    <th>Variants</th>
                    <th>Elements</th>
                    <th>Subsets</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <h4>Add a font to the stack</h4>
        <?php
        $this->add_font_select->render();
        ?>
        <button id="add-font-to-stack" class="button button-primary">Add</button>
        <?php
        add_thickbox();
    }


    public function enqueue() {
        parent::enqueue();
        $this->add_font_select->enqueue();
        wp_enqueue_script( 'font-list-option', OXY_TYPE_URI . 'options/font-list/font-list.js', array( 'jquery', 'underscore' ) );

        wp_localize_script( 'font-list-option', 'fontListData', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
        ));
    }
}