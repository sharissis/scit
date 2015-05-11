<?php
/**
 * Main Theme Options Class
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
 * Main theme options class
 *
 **/
class OxyOptions {

    /**
     * Stores all option pages / sections / fields
     *
     * @var array
     **/
    private $theme;

    /**
     * stores all theme options
     *
     * @var array
     **/
    private $_options;

    /**
     * Main constructor
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $theme ) {
        $this->theme = $theme;
        // admin init
        add_action( 'admin_init', array( &$this, 'admin_init' ) );

        // load all option pages into admin menu
        add_action( 'admin_menu', array( &$this, 'create_option_pages' ), 1 );
    }

    /**
     * Setup theme options
     *
     * @return void
     * @since 1.0
     **/
    function admin_init() {
        // check for default options
        $this->_options = get_option( THEME_SHORT . '-options' );
        if( $this->_options === false ) {
            $this->create_default_options();
        }
        else {
            // check for missing default options
            $this->create_missing_default_options();
        }

        // register theme settings
        register_setting( THEME_SHORT . '-options', THEME_SHORT . '-options', array( &$this, 'validate_options' ) );

        // create settings
        // create default options
        foreach( $this->theme->option_pages as $page ) {
            foreach( $page['sections'] as $section_id => $section ) {
                add_settings_section( $section_id, $section['title'], array( &$this, 'section_description' ), $page['slug'] );
                foreach( $section['fields'] as $field ) {
                    add_settings_field( $field['id'], $field['name'], array(&$this, 'render_option' ), $page['slug'], $section_id, $field );
                }
            }
        }
    }

    /**
     * Checks all default options are set for missing options
     *
     * @return void
     * @since 1.1
     **/
    function create_missing_default_options() {
        // create default options for missing ones
        foreach( $this->theme->option_pages as $page ) {
            foreach( $page['sections'] as $section ) {
                foreach( $section['fields'] as $field ) {
                    if( isset( $field['default'] ) ) {
                        if( !isset( $this->_options[$field['id']] ) ) {
                            $this->_options[$field['id']] = $field['default'];
                        }
                    }
                }
            }
        }
        // save default options
        update_option( THEME_SHORT . '-options', $this->_options );
    }

    /**
     * Displays the section description
     *
     * @return void
     * @since 1.0
     **/
    function section_description( $section_data ) {
        foreach( $this->theme->option_pages as $page ) {
            foreach( $page['sections'] as $section_id => $section ) {
                if( $section_id == $section_data['id'] ) {
                    if( isset( $section['header'] ) ) {
                        echo '<p class="section-description">' . $section['header'] . '</p>';
                    }
                    break;
                }
            }
        }
    }

    /**
     * Validates all options on save
     *
     * @return void
     * @since 1.0
     **/
    function validate_options( $new_options ) {
       // reset button was not pressed , so we validate and update the options
        if( ! isset($_POST['reset']) ) {

            foreach( $this->theme->option_pages as $page ) {
                foreach( $page['sections'] as $section ) {
                    foreach( $section['fields'] as $field ) {
                        // has this field been saved?
                        if( isset( $new_options[$field['id']] ) ) {
                            // does it need validation?
                            if( isset( $field['validation'] ) ) {
                                $validators = explode( '|', $field['validation'] );
                                foreach( $validators as $validation ) {
                                    // load class for validation
                                    $class_file = OXY_FRAMEWORK_DIR . 'options/validation/' . $validation . '.php';
                                    if( file_exists( $class_file ) ) {
                                        require_once $class_file;
                                        $validator_class = 'Oxy' . ucwords( $validation );
                                        if( class_exists( $validator_class ) ) {
                                            $validator = new $validator_class();
                                            $this->_options = $validator->validate( $field, $this->_options, $new_options );
                                        }
                                    }
                                }
                            }
                            else {
                                // no validation so just save whatever we get
                                $this->_options[$field['id']] = $new_options[$field['id']];
                            }
                        }
                    }
                }
            }
        }
        else {// reset defaults button was pressed , so we reset this page to default options
            $url = parse_url(wp_get_referer());
            parse_str($url['query'], $path);
            $pagename = $path['page'];
            foreach( $this->theme->option_pages as $page ) {
                if( $page['slug'] == $pagename ) {
                    foreach( $page['sections'] as $section ) {
                        foreach( $section['fields'] as $field ) {
                            if( isset( $field['default'] ) ) {
                                $this->_options[$field['id']] = $field['default'];
                            }
                        }
                    }
                    break;
                }
            }

        }
        // special case for options that we create conditionally on the fly.
        if( isset($new_options['unregistered'] ) ) {
            $this->_options['unregistered'] = $new_options['unregistered'];
        }
        return $this->_options;
    }

    /**
     * Creates default options
     *
     * @return void
     * @since 1.0
     **/
    function create_default_options() {
        $this->_options = array();
        // create default options
        foreach( $this->theme->option_pages as $page ) {
            foreach( $page['sections'] as $section ) {
                foreach( $section['fields'] as $field ) {
                    if( isset( $field['default'] ) ) {
                        $this->_options[$field['id']] = $field['default'];
                    }
                }
            }
        }
        // save default options
        add_option( THEME_SHORT . '-options', $this->_options );
    }

    /**
     * Creates option page
     *
     * @return void
     * @since 1.0
     **/
    function create_option_pages() {
        // create a new page array using hooks for keys
        $pages = array();

        // create menus and save returned hook value
        $main_menu_slug = null;
        foreach( $this->theme->option_pages as $page_data ) {
            if( $page_data['main_menu'] == true ) {
                $main_menu_slug = $page_data['slug'];
                $hook = add_menu_page( $page_data['page_title'], THEME_NAME, 'manage_options', $page_data['slug'], array( &$this , 'option_page_html' ), OXY_FRAMEWORK_URI . 'images/theme.png' );
                $hook = add_submenu_page( $main_menu_slug, $page_data['page_title'], $page_data['menu_title'], 'manage_options', $page_data['slug'], array( &$this , 'option_page_html' ) );
            }
            else {
                $hook = add_submenu_page( $main_menu_slug, $page_data['page_title'], $page_data['menu_title'], 'manage_options', $page_data['slug'], array( &$this , 'option_page_html' ) );
            }
            // store page data using new hook
            $pages[$hook] = $page_data;
            add_action('load-'.$hook, array( &$this, 'option_page_loaded' ) );
        }
        // now store the pages with hooks
        $this->theme->option_pages = $pages;
        // add action to enqueue scripts for each page
        add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_scripts') );
    }

    function option_page_loaded() {
        if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ) {
            do_action( 'oxy-options-updated-' . $_GET['page'] );
        }
    }

    /**
     * Enqueues scripts needed for each option page
     *
     * @return void
     * @since 1.0
     **/
    function enqueue_scripts( $hook ) {
        // if we are on an option page enqueue script and style for options
        if( isset( $this->theme->option_pages[$hook] ) ) {
            // always enqueue base option css
            wp_enqueue_style( 'oxy-option-page' );

            wp_enqueue_style( 'jquery-oxygenna-ui-theme' );
            wp_enqueue_script( 'theme-options-page', OXY_FRAMEWORK_URI . 'javascripts/theme-options-page.js', array( 'jquery', 'jquery-ui-tooltip' ) );
        }

        // load any option page js
        if( isset( $this->theme->option_pages[$hook]['javascripts'] ) ) {
            foreach( $this->theme->option_pages[$hook]['javascripts'] as $js ) {
                wp_enqueue_script( $js['handle'], $js['src'], $js['deps'] );
                if( isset( $js['localize'] ) ) {
                    wp_localize_script( $js['handle'], $js['localize']['object_handle'], $js['localize']['data'] );
                }
            }
        }

        // now load any option specific js / css
        foreach( $this->theme->option_pages as $page_hook => $page_data ) {
            if( $page_hook == $hook ) {
                foreach( $page_data['sections'] as $section ) {
                    foreach( $section['fields'] as $field ) {
                        if( isset( $field['type'] ) ) {
                            $new_field = OxyOptions::create_option( $field );
                            if( $new_field !== false ) {
                                $new_field->enqueue();
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Displays the option page
     *
     * @return void
     * @since 1.0
     **/
    function option_page_html() { ?>
        <div class="wrap">
            <div class="icon32">
                <img src="<?php echo OXY_FRAMEWORK_URI . 'images/oxygenna.png' ?>" alt="Oxygenna logo">
            </div>
            <h2><?php echo get_admin_page_title(); ?></h2>
            <?php settings_errors(); ?>
            <div id="ajax-errors-here"></div>
            <form method="post" action="options.php">
                <?php settings_fields( THEME_SHORT . '-options' ); ?>
                <?php do_settings_sections( $_GET['page'] ); ?>
                <div class="submit-footer">
                    <?php submit_button(); ?>
                    <?php submit_button(__('Restore Defaults', 'PLUGIN_TD'), 'secondary', 'reset' ); ?>
                </div>
            </form>
        </div>
<?php
    }

    /**
     * Creates a single option
     *
     * @return void
     * @since 1.0
     **/
    function render_option( $field ) {
        $value = isset( $this->_options[$field['id']] ) ? $this->_options[$field['id']] : null;
        $attr = array( 'name' => THEME_SHORT . '-options[' . $field['id'] . ']' );

        // create new field
        $form_field = OxyOptions::create_option( $field, $value, $attr );
        $form_field->render();

        if( isset( $field['desc'] ) ) {
            echo '</td><td>';
            echo '<a class="description" title="' . $field['desc'] . '"><img src="' . OXY_FRAMEWORK_URI . 'images/what.png" alt="Tooltip"></a>';
        }
    }

    /**
     * Creates a nice new field for you
     *
     * @return object field false on error
     * @since 1.0
     **/
    static function create_option( $field, $value = '', $attr = array() ) {
        if( isset( $field['type'] ) ) {
            // load class for option type
            // if class-file is set by plugin then use the custom class file
            $class_file = isset( $field['class-file'] ) ? $field['class-file'] : OXY_FRAMEWORK_DIR . 'options/fields/' . $field['type'] . '/' . $field['type'] . '.php';
            //print_r($class_file);die();
            if( file_exists( $class_file ) ) {
                require_once $class_file;
                $option_class = 'Oxy' . ucwords( $field['type'] );
                if( class_exists( $option_class ) ) {
                    return new $option_class( $field, $value, $attr );
                }
            }
        }
        return false;
    }
}