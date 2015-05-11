<?php
/**
 * Font Select Box
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

require_once OXY_FRAMEWORK_DIR . 'options/fields/select/select.php';

/**
 * Simple Text Input Box
 */
class OxyFontselect extends OxySelect {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        $field['options'] = $this->load_select_data();
        $attr['class'] = 'font-select select2';
        // $attr['id'] = $field['id'];

        parent::__construct( $field, $value, $attr );
    }

    function load_select_data() {
        // get data
        $data = array();

        // get default system fonts first
        global $oxy_typography;
        $system_fonts = $oxy_typography->get_system_fonts();
        $data['system_fonts'] = array(
            'optgroup' => __('System Fontstacks', 'PLUGIN_TD'),
            'options' => array()
        );
        foreach( $system_fonts as $key => $font ) {
            $data['system_fonts']['options'][$key] = $font['family'];
        }

        // include typekit fonts if available
        $typekit = $oxy_typography->get_typekit_fonts();
        if( false !== $typekit ) {
            foreach( $typekit as $kit ) {
                $key = $kit['kit']['id'];
                $data[$key] = array(
                    'optgroup' => __('TypeKit', 'PLUGIN_TD') . ' - ' . $kit['kit']['name'] . ' Kit',
                    'options' => array()
                );
                foreach( $kit['kit']['families'] as $font ) {
                    $data[$key]['options'][$font['name']] = $font['name'];
                }
            }
        }
        // include google fonts if they exist
        $google_fonts = $oxy_typography->get_google_fonts();
        if( $google_fonts !== false ) {
            $data['google_fonts'] = array(
                'optgroup' => __('Google Web Fonts', 'PLUGIN_TD'),
                'options' => array()
            );
            foreach( $google_fonts as $font ) {
                $data['google_fonts']['options'][$font['family']] = $font['family'];
            }
        }

        return $data;
    }

    public function enqueue() {
        parent::enqueue();
    }
}