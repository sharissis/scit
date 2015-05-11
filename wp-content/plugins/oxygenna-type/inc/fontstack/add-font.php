<?php
/**
 * Adds a font to the fontstack
 *
 * @package Oxygenna Typography Plugin
 * @since 0.1
 *
 * @copyright **COPYRIGHT**
 * @license **LICENSE**
 * @version 0.1
 */
global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow, $wp_version,
    $current_site, $update_title, $total_update_count, $parent_file;

global $oxy_typography;
$font_info = $oxy_typography->fetch_font( $_GET['family'], $_GET['provider'] );

if( $_GET['provider'] === 'typekit_fonts' ) {
                                    // $font_info = array();
    $font_info['family'] = $font_info['name'];
    $font_info['variants'] = $font_info['variations'];
    $font_info['subsets'] = $font_info['subset'];
}
$elements = array(
    'body'       => __('All (body tag)'),
    'headings'   => __('Headings (h1-h6 tags)', 'PLUGIN_TD'),
    'forms'      => __('Forms (all input tags)', 'PLUGIN_TD'),
    'blockquote' => __('Block Quote (blockquote tag)', 'PLUGIN_TD'),
);

wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'utils' );
wp_enqueue_script( 'add-font', OXY_TYPE_URI . 'javascripts/fontstack/add-font.js', array( 'jquery' ) );
wp_enqueue_style( 'add-font', OXY_TYPE_URI . 'stylesheets/fontstack/add-font.css' );

wp_localize_script( 'add-font', 'localData', array(
    // URL to wp-admin/admin-ajax.php to process the request
    'ajaxurl'   => admin_url( 'admin-ajax.php' ),
    // generate a nonce with a unique ID "myajax-post-comment-nonce"
    // so that you can check it later when an AJAX request is sent
    'nonce'     => wp_create_nonce( 'oxygenna-add-fontstack' ),
    )
);
?>
<html>
    <head>
        <?php
        // do_action('admin_enqueue_scripts', $hook_suffix);
        do_action("admin_print_styles-$hook_suffix");
        do_action('admin_print_styles');
        do_action("admin_print_scripts-$hook_suffix");
        do_action('admin_print_scripts');
        // do_action("admin_head-$hook_suffix");
        do_action('admin_head');
        ?>
    </head>

    <body id="plugin-information" class="wp-admin wp-core-ui js iframe  plugin-install-php locale-en-us">
        <div id="section-holder" class="wrap">
            <div id="section-description" class="section" style="display: block;">
                <h2 class="long-header">Add font <?php echo $font_info['family']; ?></h2>
            </div>
            <form id="add-font-form">
                <div class="row">
                    <div class="third">
                        <h3>Variants</h3>
                        <p>Choose the weights of fonts you would like to load</p>
                        <?php foreach( $font_info['variants'] as $variant ) : ?>
                            <p>
                                <input class="variants" type="checkbox" id="<?php echo $variant; ?>" value="<?php echo $variant; ?>" />
                                <label for="<?php echo $variant; ?>">
                                    <?php echo $oxy_typography->oxy_get_font_weight_style( $variant, $_GET['provider'] ); ?>
                                </label>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="third">
                        <h3>Elements</h3>
                        <p>Select which HTML tags will use this font.</p>
                        <?php foreach( $elements as $tag => $element ) : ?>
                            <p>
                                <input class="elements" name="elements[<?php echo $tag; ?>]" type="checkbox" id="<?php echo $tag; ?>" value="<?php echo $tag; ?>">
                                <label for="<?php echo $tag; ?>"><?php echo $element; ?></label>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <?php if( $_GET['provider'] === 'google_fonts' ) : ?>
                    <div class="third">
                        <h3>Charsets</h3>
                        <p>Select language character sets to load.</p>
                        <?php foreach( $font_info['subsets'] as $subset ) : ?>
                            <p>
                                <input class="subsets" name="subsets[<?php echo $subset; ?>]" type="checkbox" id="<?php echo $subset; ?>" value="<?php echo $subset; ?>">
                                <label for="<?php echo $subset; ?>"><?php echo $subset; ?></label>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <h3>Extra CSS</h3>
                    <p>Add any extra CSS rules you would like to use for this font here.</p>
                    <textarea name="extracss" id="extracss" cols="30" rows="10"></textarea>
                </div>
                <input type="hidden" name="action" value="fontstack_add" />
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'oxygenna-add-fontstack' ); ?>" />
                <input type="hidden" name="family" value="<?php echo $_GET['family']; ?>" />
                <input type="hidden" name="provider" value="<?php echo $_GET['provider']; ?>" />
                <div class="row">
                    <p class="action-button">
                        <a id="add-font" href="#">Add Font</a>
                    </p>
                </div>
            </form>
        </div>
    </body>
</html>