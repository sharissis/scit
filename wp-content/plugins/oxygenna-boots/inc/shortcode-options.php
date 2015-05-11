<?php
/**
 * Declare all shortcode options
 *
 * @package Oxygenna Boostrap Plugin
 * @since 0.1
 *
 * @copyright **COPYRIGHT**
 * @license **LICENSE**
 * @version 1.1
 */

global $oxy_theme;
if( isset($oxy_theme)){
    $shortcode_options = array(
        'row' => array(
            'shortcode' => 'row',
            'insert'    => '[row][/row]',
            'title'     => __('Blank Row', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span1' =>  array(
            'shortcode' => 'span1',
            'insert'    => '[span1][/span1]',
            'title'     => __('Span1 (1/12th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span2' =>  array(
            'shortcode' => 'span2',
            'insert'    => '[span2][/span2]',
            'title'     => __('Span2 (1/6th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span3' =>  array(
            'shortcode' => 'span3',
            'insert'    => '[span3][/span3]',
            'title'     => __('Span3 (1/4)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span4' =>  array(
            'shortcode' => 'span4',
            'insert'    => '[span4][/span4]',
            'title'     => __('Span4 (1/3rd)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span5' =>  array(
            'shortcode' => 'span5',
            'insert'    => '[span5][/span5]',
            'title'     => __('Span5 (5/12th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span6' =>  array(
            'shortcode' => 'span6',
            'insert'    => '[span6][/span6]',
            'title'     => __('Span6 (1/2)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span7' =>  array(
            'shortcode' => 'span7',
            'insert'    => '[span7][/span7]',
            'title'     => __('Span7 (7/12th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span8' =>  array(
            'shortcode' => 'span8',
            'insert'    => '[span8][/span8]',
            'title'     => __('Span8 (2/3rd)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span9' =>  array(
            'shortcode' => 'span9',
            'insert'    => '[span9][/span9]',
            'title'     => __('Span9 (3/4)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span10' =>  array(
            'shortcode' => 'span10',
            'insert'    => '[span10][/span10]',
            'title'     => __('Span10 (10/12th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span11' =>  array(
            'shortcode' => 'span11',
            'insert'    => '[span11][/span11]',
            'title'     => __('Span11 (11/12th)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'span12' =>  array(
            'shortcode' => 'span12',
            'insert'    => '[span12][/span12]',
            'title'     => __('Span12 (one whole row)', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout21' => array(
            'shortcode' => 'layout21',
            'insert'    => '[row][span6]Column1[/span6][span6]Column 2[/span6][/row]',
            'title'     => __('&frac12; - &frac12;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout22' => array(
            'shortcode' => 'layout22',
            'insert'    => '[row][span4]Column1[/span4][span8]Column 2[/span8][/row]',
            'title'     => __('&#8531; - &#8532;',  'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout23' => array(
            'shortcode' => 'layout',
            'insert'    => '[row][span8]Column1[/span8][span4]Column 2[/span4][/row]',
            'title'     => __('&#8532; - &#8531;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout24' => array(
            'shortcode' => 'layout',
            'insert'    => '[row][span3]Column1[/span3][span9]Column 2[/span9][/row]',
            'title'     => __('&frac14; - &frac34;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout25' => array(
            'shortcode' => 'layout',
            'insert'    => '[row][span9]Column1[/span9][span3]Column 2[/span3][/row]',
            'title'     => __('&frac34; - &frac14;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout3' => array(
            'shortcode' => 'layout',
            'insert'    => '[row][span4]Column1[/span4][span4]Column 2[/span4][span4]Column 3[/span4][/row]',
            'title'     => __('&#8531; - &#8531; - &#8531;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'layout4' => array(
            'shortcode' => 'layout',
            'insert'    => '[row][span3]Column1[/span3][span3]Column 2[/span3][span3]Column 3[/span3][span3]Column 4[/span3][/row]',
            'title'     => __('&frac14; - &frac14; - &frac14; - &frac14;', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'button' =>  array(
            'shortcode'   => 'button',
            'title'       => __('Button', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'General',
                    'fields'  => array(
                        array(
                            'name'    => __('Button type', 'PLUGIN_TD'),
                            'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                            'id'      => 'type',
                            'type'    => 'select',
                            'default' => 'default',
                            'options' => array(
                                    'default' => __('Default', 'PLUGIN_TD'),
                                    'primary' => __('Primary', 'PLUGIN_TD'),
                                    'info'    => __('Info', 'PLUGIN_TD'),
                                    'success' => __('Success', 'PLUGIN_TD'),
                                    'warning' => __('Warning', 'PLUGIN_TD'),
                                    'danger'  => __('Danger', 'PLUGIN_TD'),
                                    'inverse' => __('Inverse', 'PLUGIN_TD'),
                                    'link'    => __('Link', 'PLUGIN_TD'),
                            ),
                        ),
                        array(
                            'name'    => __('Button size', 'PLUGIN_TD'),
                            'desc'    => __('Size of button to display', 'PLUGIN_TD'),
                            'id'      => 'size',
                            'type'    => 'select',
                            'default' => '',
                            'options' => array(
                                    ''             => __('Default', 'PLUGIN_TD'),
                                    'btn-large'    => __('Large', 'PLUGIN_TD'),
                                    'btn-small'    => __('Small', 'PLUGIN_TD'),
                                    'btn-mini'     => __('Mini', 'PLUGIN_TD'),
                            ),
                        ),
                        array(
                            'name'    => __('Text', 'PLUGIN_TD'),
                            'id'      => 'label',
                            'type'    => 'text',
                            'default' => __('My button', 'PLUGIN_TD'),
                            'desc'    => __('Add a label to the button', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Link', 'PLUGIN_TD'),
                            'id'      => 'link',
                            'type'    => 'text',
                            'default' => '',
                            'desc'    => __('Where the button links to', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Icon Position', 'PLUGIN_TD'),
                            'desc'    => __('The position of the icon on the button', 'PLUGIN_TD'),
                            'id'      => 'side',
                            'type'    => 'radio',
                            'default' => 'left',
                            'options' => array(
                                    'left'     => __('Left', 'PLUGIN_TD'),
                                    'right'    => __('Right', 'PLUGIN_TD'),
                            ),
                        ),
                    )
                ),
                array(
                    'title'   => 'Advanced',
                    'fields'  => array(
                        array(
                            'name'    => __('Extra classes', 'PLUGIN_TD'),
                            'id'      => 'xclass',
                            'type'    => 'text',
                            'default' => '',
                            'desc'    => __('Add an extra class to the button', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Open Link In', 'PLUGIN_TD'),
                            'id'      => 'link_open',
                            'type'    => 'select',
                            'default' => '_self',
                            'options' => array(
                                '_self'   => __('Same page as it was clicked ', 'PLUGIN_TD'),
                                '_blank'  => __('Open in new window/tab', 'PLUGIN_TD'),
                                '_parent' => __('Open the linked document in the parent frameset', 'PLUGIN_TD'),
                                '_top'    => __('Open the linked document in the full body of the window', 'PLUGIN_TD')
                            ),
                            'desc'    => __('Where the button link opens to', 'PLUGIN_TD'),
                        ),
                    )
                ),
                array(
                    'title'   => 'Icon',
                    'fields'  => array(
                        array(
                            'name'    => __('Icon', 'PLUGIN_TD'),
                            'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                            'id'      => 'icon',
                            'type'    => 'icons',
                            'default' => ''
                        )
                    ),
                ),
            ),
        ),
        'button-fancy' =>  array(
            'shortcode'   => 'button-fancy',
            'title'       => __('Fancy Button', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'General',
                    'fields'  => array(
                        array(
                            'name'    => __('Button Swatch', 'PLUGIN_TD'),
                            'desc'    => __('Choose a color swatch for the button', 'PLUGIN_TD'),
                            'id'      => 'button_swatch',
                            'type'    => 'select',
                            'default' => 'swatch-coral',
                            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                        ),
                        array(
                            'name'    => __('Button Animation', 'PLUGIN_TD'),
                            'desc'    => __('Choose a button animation', 'PLUGIN_TD'),
                            'id'      => 'button_animation',
                            'type'    => 'select',
                            'default' => '',
                            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                        ),
                        array(
                            'name'    => __('Button size', 'PLUGIN_TD'),
                            'desc'    => __('Size of button to display', 'PLUGIN_TD'),
                            'id'      => 'size',
                            'type'    => 'select',
                            'default' => '',
                            'options' => array(
                                    ''             => __('Default', 'PLUGIN_TD'),
                                    'btn-large'    => __('Large', 'PLUGIN_TD'),
                                    'btn-small'    => __('Small', 'PLUGIN_TD'),
                                    'btn-mini'     => __('Mini', 'PLUGIN_TD'),
                            ),
                        ),
                        array(
                            'name'    => __('Text', 'PLUGIN_TD'),
                            'id'      => 'label',
                            'type'    => 'text',
                            'default' => __('My button', 'PLUGIN_TD'),
                            'desc'    => __('Add a label to the button', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Link', 'PLUGIN_TD'),
                            'id'      => 'link',
                            'type'    => 'text',
                            'default' => '',
                            'desc'    => __('Where the button links to', 'PLUGIN_TD'),
                        ),
                    )
                ),
                array(
                    'title'   => 'Advanced',
                    'fields'  => array(
                        array(
                            'name'    => __('Extra classes', 'PLUGIN_TD'),
                            'id'      => 'xclass',
                            'type'    => 'text',
                            'default' => '',
                            'desc'    => __('Add an extra class to the button', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Open Link In', 'PLUGIN_TD'),
                            'id'      => 'link_open',
                            'type'    => 'select',
                            'default' => '_self',
                            'options' => array(
                                '_self'   => __('Same page as it was clicked ', 'PLUGIN_TD'),
                                '_blank'  => __('Open in new window/tab', 'PLUGIN_TD'),
                                '_parent' => __('Open the linked document in the parent frameset', 'PLUGIN_TD'),
                                '_top'    => __('Open the linked document in the full body of the window', 'PLUGIN_TD')
                            ),
                            'desc'    => __('Where the button link opens to', 'PLUGIN_TD'),
                        ),
                    )
                ),
                array(
                    'title'   => 'Icon',
                    'fields'  => array(
                        array(
                            'name'    => __('Icon', 'PLUGIN_TD'),
                            'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                            'id'      => 'icon',
                            'type'    => 'icons',
                            'default' => '',
                        )
                    ),
                ),
            ),
        ),
        'alert' => array(
            'shortcode'   => 'alert',
            'title'       => __('Bootstrap alert', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'general',
                    'fields'  => array(
                        array(
                            'name'    => __('Alert type', 'PLUGIN_TD'),
                            'desc'    => __('Type of alert to display', 'PLUGIN_TD'),
                            'id'      => 'type',
                            'type'    => 'select',
                            'default' => 'default',
                            'options' => array(
                                    ''              => __('default', 'PLUGIN_TD'),
                                    'alert-block'   => __('block', 'PLUGIN_TD'),
                                    'alert-error'   => __('danger', 'PLUGIN_TD'),
                                    'alert-success' => __('success', 'PLUGIN_TD'),
                                    'alert-info'    => __('information', 'PLUGIN_TD'),
                            ),
                        ),
                        array(
                            'name'    => __('Label', 'PLUGIN_TD'),
                            'id'      => 'label',
                            'type'    => 'text',
                            'default' => __('warning!', 'PLUGIN_TD'),
                            'desc'    => __('The alert label', 'PLUGIN_TD'),
                        ),
                        array(
                            'name'    => __('Description', 'PLUGIN_TD'),
                            'id'      => 'Description',
                            'type'    => 'text',
                            'default' => __('something is wrong!', 'PLUGIN_TD'),
                            'desc'    => __('Add a description to your warning', 'PLUGIN_TD'),
                        )
                    )
                ),
            ),
        ),
        'accordions' => array(
            'shortcode' => 'accordions',
            'title'     => __('Accordion', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'general',
                    'fields'  => array(
                        array(
                            'name'    => __('Button Swatch', 'PLUGIN_TD'),
                            'desc'    => __('Choose a color swatch for the button', 'PLUGIN_TD'),
                            'id'      => 'accordion_swatch',
                            'type'    => 'select',
                            'default' => 'swatch-white',
                            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                        ),
                        array(
                            'name'    => __('Accordions', 'PLUGIN_TD'),
                            'desc'    => __('Number of accordions', 'PLUGIN_TD'),
                            'id'      => 'accordion_details',
                            'type'    => 'slider',
                            'default' => 2,
                            'attr'    => array(
                                'max'  => 10,
                                'min'  => 1,
                                'step' => 1
                            )
                        ),
                    )
                )
            )
        ),
        'tabs' => array(
            'shortcode' => 'tabs',
            'insert'    => '[tabs style="top"][tab title="First title"]First content here[/tab][tab title="Second title"]Second content[/tab][/tabs]',
            'title'     => __('Tabs', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'panel' => array(
            'shortcode' => 'panel',
            'insert'    => '[panel header="My header"]This is the content of the panel[/panel]',
            'title'     => __('Panel', 'PLUGIN_TD'),
            'insert_with' => 'insert',
        ),
        'progress' =>    array(
            'shortcode'   => 'progress',
            'title'       => __('Progress Bar', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'general',
                    'fields'  => array(
                        array(
                            'name'    => __('Percentage', 'PLUGIN_TD'),
                            'desc'    => __('Percentage of the progress bar', 'PLUGIN_TD'),
                            'id'      => 'percentage',
                            'type'    => 'slider',
                            'default' => 50,
                            'attr'    => array(
                                'max'  => 100,
                                'min'  => 1,
                                'step' => 1
                            )
                        ),
                        array(
                            'name'    => __('Bar Type', 'PLUGIN_TD'),
                            'desc'    => __('Type of bar to display', 'PLUGIN_TD'),
                            'id'      => 'type',
                            'type'    => 'radio',
                            'default' => 'progress',
                            'options' => array(
                                'progress'                        => __('Normal', 'PLUGIN_TD'),
                                'progress progress-striped'       => __('Striped', 'PLUGIN_TD'),
                                'progress progress-striped active'=> __('Animated', 'PLUGIN_TD'),
                            ),
                        ),
                        array(
                            'name'    => __('Bar Style', 'PLUGIN_TD'),
                            'desc'    => __('Style of bar to display', 'PLUGIN_TD'),
                            'id'      => 'style',
                            'type'    => 'select',
                            'default' => 'progress-info',
                            'options' => array(
                                'progress-info'     => __('Info', 'PLUGIN_TD'),
                                'progress-success'  => __('Success', 'PLUGIN_TD'),
                                'progress-warning'  => __('Warning', 'PLUGIN_TD'),
                                'progress-danger'   => __('Danger', 'PLUGIN_TD'),
                            ),
                        ),


                    )
                ),
            ),
        ),
        'lead_paragraph' => array(
            'shortcode'   => 'lead',
            'title'       => __('Lead Paragraph', 'PLUGIN_TD'),
            'insert_with' => 'insert',
            'insert'      => '[lead centered="yes"][/lead]'
        ),
        'blockquote' => array(
            'shortcode'   => 'blockquote',
            'title'       => __('Blockquote', 'PLUGIN_TD'),
            'insert_with' => 'insert',
            'insert'      => '[blockquote who="" cite="" align="left"][/blockquote]'
        ),
        'iconlist' => array(
            'shortcode'   => 'iconlist',
            'title'       => __('Iconlist', 'PLUGIN_TD'),
            'insert_with' => 'insert',
            'insert'      => '[iconlist][iconitem  icon="icon-ok"]Some list item[/iconitem][iconitem  icon="icon-ok"]Some list item[/iconitem][/iconlist]'
        ),
        'icon' => array(
            'shortcode'   => 'icon',
            'title'       => __('Icon', 'PLUGIN_TD'),
            'insert_with' => 'dialog',
            'sections'    => array(
                array(
                    'title'   => 'General',
                    'fields'  => array(
                        array(
                            'name'    => __('Font Size', 'PLUGIN_TD'),
                            'desc'    => __('Size of font to use for icon ( set to 0 to inhertit font size from container )', 'PLUGIN_TD'),
                            'id'      => 'size',
                            'type'    => 'slider',
                            'default' => 0,
                            'attr'    => array(
                                'max'  => 48,
                                'min'  => 0,
                                'step' => 1
                            )
                        ),
                    )
                ),
                array(
                    'title'   => 'Icon',
                    'fields'  => array(
                        array(
                            'name'    => __('Icon', 'PLUGIN_TD'),
                            'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                            'id'      => 'content',
                            'type'    => 'icons',
                            'default' => 'icon-glass'
                        )
                    ),
                ),
            ),
        ),
    );

    // add options to accordion shortcode
    foreach ( $shortcode_options as &$shortcode ) {
        if( isset($shortcode['shortcode']) && $shortcode['shortcode'] == 'accordions'){
            for( $i = 0 ; $i < 10 ; $i++ ){
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Accordion %s title', 'PLUGIN_TD'), $i+1 ),
                    'id'      => sprintf( __('accordion_%s_title', 'PLUGIN_TD'), $i+1 ),
                    'type'    => 'text',
                    'default' => '',
                    'desc'    => __('Add text to the accordion', 'PLUGIN_TD'),
                );
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Accordion %s content', 'PLUGIN_TD'), $i+1 ),
                    'id'      => sprintf( __('accordion_%s_content', 'PLUGIN_TD'), $i+1 ),
                    'type'    => 'textarea',
                    'default' => '',
                    'desc'    => __('Add text to the accordion', 'PLUGIN_TD'),
                );
            }
        }
    }

    $oxy_theme->register_shortcode_options($shortcode_options);
}