<?php
/**
 * Oxygennas Typography Plugin
 *
 * @package Oxygenna Typography Plugin
 * @since 0.1
 *
 * @copyright **COPYRIGHT**
 * @license **LICENSE**
 * @version 1.0.3
 */

/**
 * Class that sets up all typography stuff
 *
 **/

class OxyTypography {
    /**
     * Constructor, this should be called plugin base
     */
    function __construct() {
        // frontend stuff
        add_action( 'wp_head', array( &$this, 'wp_head' ) );

        add_action( 'init', array( &$this, 'init' ) );

         // register google fonts list ajax call
        add_action( 'wp_ajax_google_fonts_list', array( &$this, 'google_fetch_fonts_list' ) );
        add_action( 'wp_ajax_nopriv_google_fonts_list', array( &$this, 'google_fetch_fonts_list' ) );

         // register typekit update kits
        add_action( 'wp_ajax_typekit_update_kits', array( &$this, 'typekit_update_kits' ) );
        add_action( 'wp_ajax_nopriv_typekit_update_kits', array( &$this, 'typekit_update_kits' ) );

         // fetch full font stack
        add_action( 'wp_ajax_fontstack_list', array( &$this, 'fontstack_list' ) );
        add_action( 'wp_ajax_nopriv_fontstack_list', array( &$this, 'fetch_fontstack' ) );

         // add to fontstack page
        add_action( 'wp_ajax_fontstack_add_page', array( &$this, 'add_to_fontstack_page' ) );
        add_action( 'wp_ajax_nopriv_fontstack_add_page', array( &$this, 'add_to_fontstack_page' ) );

        // save fontstack
        add_action( 'wp_ajax_fontstack_save', array( &$this, 'fontstack_save' ) );
        add_action( 'wp_ajax_nopriv_fontstack_save', array( &$this, 'fontstack_save' ) );

        $this->create_font_js( get_option( 'oxy-fontstack' ) );
    }

    function wp_head() {
        echo get_option( 'oxy-typography-js' );
        echo get_option( 'oxy-typography-css' );
    }

    function init() {
        // load option pages options
        include OXY_TYPE_DIR . 'option-pages.php';
    }

    function get_system_fonts() {
        return include OXY_TYPE_DIR . 'providers/system.php';
    }

    function get_google_fonts() {
        return get_option( 'oxy-google-fonts' );
    }

    function get_typekit_fonts() {
        return get_option( 'oxy-typekit-fonts' );
    }

    function google_fetch_fonts_list() {
        if( isset( $_POST['nonce'] ) ) {
            if( wp_verify_nonce( $_POST['nonce'], 'google-fetch-fonts-nonce') ) {
                header( 'Content-Type: application/json' );
                $resp = new stdClass();

                $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVQGrQVBkgCBi9JgPiPpBeKN69jIRk8ZA';
                $response = wp_remote_retrieve_body( wp_remote_get( $google_api_url, array('sslverify' => false ) ) );

                if( is_wp_error( $response ) ) {
                    $resp->status = 'error';
                } else {
                    $resp->status = 'ok';
                    // we got a new list , so we update the theme options
                    $list = json_decode( $response, true );
                    update_option( 'oxy-google-fonts', $list['items'] );
                }

                echo json_encode( $resp );
            }
            die();
        }
    }

    function typekit_update_kits() {
        $api_key = $_POST['api_key'];
        // fetch list of kits available for this token
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, 'https://typekit.com/api/v1/json/kits' );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'X-Typekit-Token: ' . $api_key ) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $kits_list = curl_exec( $ch );
        // decode list
        $kits = json_decode( $kits_list );
        if( null !== $kits ) {
            if( empty( $kits->errors ) ) {
                // create an array and fetch details of each kit inside
                $kits_details = array();
                foreach( $kits->kits as $kit ) {
                    curl_setopt( $ch, CURLOPT_URL, 'https://typekit.com/api/v1/json/kits/' . $kit->id );
                    $kit_details = curl_exec( $ch );
                    $kits_details[] = json_decode( $kit_details, true );
                }
                curl_close( $ch );

                update_option( 'oxy-typekit-fonts', $kits_details );
                echo json_encode( $kits_details );
            }
        }

        die();
    }

    function fetch_font( $family, $provider ) {
        switch( $provider ) {
            case 'system_fonts':
                $system_fonts = $this->get_system_fonts();
                if( isset( $system_fonts[$family] ) ) {
                    return $system_fonts[$family];
                }
            break;
            case 'google_fonts':
                $google_fonts = $this->get_google_fonts();
                foreach( $google_fonts as $font ) {
                    if( $family == $font['family'] ) {
                        return $font;
                    }
                }
            break;
            // typekit sends the kit id
            default:
                $typekit = $this->get_typekit_fonts();
                if( null !== $typekit ) {
                    foreach( $typekit as $kit ) {
                        if( $kit['kit']['id'] === $provider ) {
                            foreach( $kit['kit']['families'] as $font ) {
                                if( $font['name'] == $family ) {
                                    $font['family'] = $font['name'];
                                    $font['variants'] = $font['variations'];
                                    return $font;
                                }
                            }
                        }
                    }
                }
            break;
        }
    }

    function fontstack_list() {
        $fontstack = get_option( 'oxy-fontstack' );
        if( $fontstack === false ) {
            $fontstack = array();
        }
        // return the temp fontstack
        echo json_encode( $fontstack );
        die();
    }

    function add_to_fontstack_page() {
        include OXY_TYPE_DIR . 'fontstack/add-font.php';
        die();
    }

    function fontstack_save() {
        $resp = new stdClass();
        $resp->status = false;
        $resp->message = 'Failed';

        if( isset( $_POST['nonce'] ) ) {
            if( wp_verify_nonce( $_POST['nonce'], 'update-fontstack' ) ) {
                header( 'Content-Type: application/json' );
                if( !empty( $_POST['fontstack'] ) ) {
                    $fontstack = $_POST['fontstack'];
                    update_option( 'oxy-fontstack', $fontstack );
                    // now update the font css
                    $this->create_font_css( $fontstack );
                    // now update the font js
                    $this->create_font_js( $fontstack );
                }
                else {
                    delete_option( 'oxy-fontstack' );
                    delete_option( 'oxy-typography-css' );
                    delete_option( 'oxy-typography-js' );
                    $fontstack = array();
                }
                // set response to ok
                $resp->status = true;
                $resp->message = __('Fontsack Updated Successfully', 'PLUGIN_TD');
                $resp->fontstack = $fontstack;
            }
        }

        echo json_encode( $resp );
        die();
    }

    function create_font_css( $fontstack ) {
        if( !empty( $fontstack ) ) {
            $google_import = $this->create_google_import_url( $fontstack );
            $css_rules = $this->create_font_css_rules( $fontstack );
$css = <<<CSS
<style type="text/css" media="screen">
{$google_import}
{$css_rules}
</style>
CSS;
            // echo $css;
            update_option( 'oxy-typography-css', $css );
        }
    }

    function create_font_css_rules( $fontstack ) {
        $css = '';
        foreach( $fontstack as $font ) {
            if( isset( $font['elements'] ) ) {
                foreach( $font['elements'] as $element ) {
                    // get font family
                    $family = $this->get_font_family( $font );
                    switch( $element ) {
                        case 'body':
                            $css .= <<<CSS
body {
    font-family: {$family}
}
CSS;
                        break;
                        case 'headings':
                            $css .= <<<CSS
h1, h2, h3, h4, h5, h6 {
    font-family: {$family}
}
CSS;
                        break;
                        case 'blockquote':
                            $css .= <<<CSS
blockquote {
    font-family: {$family}
}
CSS;
                        break;
                        case 'forms':
                            $css .= <<<CSS
input, textarea, .btn, button {
    font-family: {$family}
}
CSS;
                        break;
                    }
                }
            }
            // add any custom css
            if( isset( $font['extracss'] ) ) {
                $css .= $font['extracss'];
            }
        }
        return $css;
    }

    function get_font_family( $font ) {
        $font_info = $this->fetch_font( $font['family'], $font['provider'] );
        switch( $font['provider'] ) {
            case 'google_fonts':
            case 'system_fonts':
                return $font_info['family'];
            default:
                return $font_info['css_stack'] . ';';
        }
    }

    function create_google_import_url( $fontstack ) {
        $font_codes = array();
        $subsets = array();
        foreach( $fontstack as $font ) {
            if( $font['provider'] === 'google_fonts' ) {
                // remove regular and italic and replace with url format
                $font['variants'] = $this->convert_google_variants_to_url( $font['variants'] );
                $variants = empty( $font['variants'] ) ? '' : ':' . implode( ',', $font['variants'] );
                if( isset( $font['subsets'] ) ) {
                    foreach( $font['subsets'] as $add_subset ) {
                        $subsets[] = $add_subset;
                    }
                }
                $font_codes[] = str_replace( ' ', '+', $font['family'] ) . $variants;
            }
        }
        if( !empty( $font_codes ) ) {
            $families = implode( '|', $font_codes );
            $subsets_url = empty( $subsets ) ? '' : '&subset=' . implode( ',', $subsets );
            return '@import url(http://fonts.googleapis.com/css?family=' . $families . $subsets_url . ');';
        }
    }

    function convert_google_variants_to_url( $variants ) {
        $new_variants = array();
        foreach( $variants as $variant ) {
            $new_variants[] = $this->google_variant_to_url_format( $variant );
        }
        return $new_variants;
    }

    function google_variant_to_url_format( $variant ) {
        switch( $variant ) {
            case 'regular':
                return '400';
            case 'italic':
                return '400italic';
            default:
                return $variant;
        }
    }

    function create_font_js( $fontstack ) {
        $js = '';
        if( is_array( $fontstack ) ) {
            foreach( $fontstack as $font ) {
                switch( $font['provider'] ) {
                    case 'google_fonts':
                    case 'system_fonts':
                        // do nothing
                    break;
                    default:
                        $kit = $font['provider'];
                        $js .= <<<JS
    <script type="text/javascript" src="//use.typekit.net/{$kit}.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
JS;
                    break;
                }
            }
            update_option( 'oxy-typography-js', $js );
        }
    }

    function oxy_get_font_weight_style( $variant, $provider ) {
        $variations = array(
            'font-style' => array(
                'n' => 'normal',
                'i' => 'italic',
                'o' => 'oblique'
            ),
            'font-weight' => array(
                '1' => '100',
                '2' => '200',
                '3' => '300',
                '4' => '400',
                '5' => '500',
                '6' => '600',
                '7' => '700',
                '8' => '800',
                '9' => '900',
                '4' => 'normal',
                '7' => 'bold'
            )
        );

        $weight_style = array( 'style' => 'normal', 'weight' => 'normal' );
        if( null !== $variant ) {
            switch( $provider ) {
                case 'google_fonts':
                    // if variant has italic inside string set style otherwise use normal
                    $weight_style['style'] = ( strpos( $variant, 'italic' ) === FALSE ) ? 'normal' : 'italic';
                    // remove italic from weight
                    $weight_style['weight'] = str_replace( 'italic', '', $variant );
                    if( $weight_style['weight'] == '' || $weight_style['weight'] == 'regular' ) {
                        $weight_style['weight'] = 'normal';
                    }
                break;
                default:
                case 'system_fonts':
                    if( 2 == strlen( $variant ) ) {
                        $pieces = str_split( $variant, 1 );
                        if( array_key_exists( $pieces[1], $variations['font-weight'] ) ) {
                            $weight_style['weight'] = $variations['font-weight'][$pieces[1]];
                        }
                        if( array_key_exists( $pieces[0], $variations['font-style'] ) ) {
                            $weight_style['style'] = $variations['font-style'][$pieces[0]];
                        }
                    }
                break;
            }
        }
        return implode( ' - ', $weight_style );
    }
}

