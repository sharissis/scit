<?php
/**
 * Sets up the typography option Pages
 *
 * @package Oxygenna Typography Plugin
 * @since 0.1
 *
 * @copyright **COPYRIGHT**
 * @license **LICENSE**
 * @version 1.0.3
 */

global $oxy_theme;
if( isset($oxy_theme) ) {
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Typography Settings', 'PLUGIN_TD'),
        'menu_title' => __('Typography', 'PLUGIN_TD'),
        'slug'       => THEME_SHORT . '-typography',
        'main_menu'  => false,
        'icon'       => 'tools',
        'javascripts' => array(
            array(
                'handle' => 'typography-page',
                'src'    => OXY_TYPE_URI . 'javascripts/option-pages/typography-page.js',
                'deps'   => array( 'jquery' ),
                'localize' => array(
                    'object_handle' => 'typographyPage',
                    'data' => array(
                        'ajaxurl' => admin_url( 'admin-ajax.php' ),
                        'updateNonce'  => wp_create_nonce( 'update-fontstack' ),
                        'restoreNonce' => wp_create_nonce( 'restore-fontstack' ),
                    )
                )
            ),
        ),
        'sections'   => array(
            'font-section' => array(
                'title'   => __('Fonts settings section', 'PLUGIN_TD'),
                'header'  => __('Setup Fonts settings here.', 'PLUGIN_TD'),
                'fields' => array(
                    array(
                        'name' => __('Font Stack:', 'PLUGIN_TD'),
                        'id' => 'font_list',
                        'type' => 'fontlist',
                        'class-file' => OXY_TYPE_DIR . 'options/font-list/font-list.php',
                    ),
                )
            )
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Typography Settings', 'PLUGIN_TD'),
        'menu_title' => __('Fonts', 'PLUGIN_TD'),
        'slug'       => THEME_SHORT . '-fonts',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'google-fonts-section' => array(
                'title'   => __('Google Fonts', 'PLUGIN_TD'),
                'header'  => __('Setup Your Google Fonts Here.', 'PLUGIN_TD'),
                'fields' => array(
                    array(
                        'name'        => __('Fetch Latest Fonts From Google', 'PLUGIN_TD'),
                        'button-text' => __('Update Fonts', 'PLUGIN_TD'),
                        'id'          => 'google_update_fonts_button',
                        'type'        => 'button',
                        'attr'        => array(
                            'id'    => 'google-update-fonts-button',
                            'class' => 'button button-primary'
                        ),
                        'javascripts' => array(
                            array(
                                'handle' => 'google-font-updater',
                                'src'    => OXY_TYPE_URI . 'javascripts/options/google-font-updater.js',
                                'deps'   => array( 'jquery' ),
                                'localize' => array(
                                    'object_handle' => 'googleUpdate',
                                    'data' => array(
                                        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                                        // generate a nonce with a unique ID "myajax-post-comment-nonce"
                                        // so that you can check it later when an AJAX request is sent
                                        'nonce'     => wp_create_nonce( 'google-fetch-fonts-nonce' ),
                                    )
                                )
                            ),
                        ),
                    )
                )
            ),
            'typekit-provider-options' => array(
                'title'   => __('TypeKit Fonts', 'PLUGIN_TD'),
                'header'  => __('Setup Your TypeKit settings Here.', 'PLUGIN_TD'),
                'fields' => array(
                    array(
                        'name' => __('Typekit API Token', 'PLUGIN_TD'),
                        'desc' => __('Add your typekit api token here'),
                        'id'   => 'typekit_api_token',
                        'type' => 'text',
                        'attr'        => array(
                            'id'    => 'typekit-api-key',
                        )
                    ),
                    array(
                        'name'        => __('TypeKit Kits', 'PLUGIN_TD'),
                        'button-text' => __('Update your kits', 'PLUGIN_TD'),
                        'id'          => 'typekit_kits_button',
                        'type'        => 'button',
                        'attr'        => array(
                            'id'    => 'typekit-kits-button',
                            'class' => 'button button-primary'
                        ),
                        'javascripts' => array(
                            array(
                                'handle' => 'typekit-kit-updater',
                                'src'    => OXY_TYPE_URI . 'javascripts/options/typekit-updater.js',
                                'deps'   => array( 'jquery' ),
                                'localize' => array(
                                    'object_handle' => 'localData',
                                    'data' => array(
                                        'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                                        'nonce'     => wp_create_nonce( 'typekit-kits-nonce' ),
                                    )
                                )
                            ),
                        ),
                    )
                )
            )
        )
    ));
}