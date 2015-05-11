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
/* ------------------ LAYOUT SHORTCODES ------------------- */

/* ------------------ COLUMNS SHORTCODES ------------------- */

function oxy_shortcode_row( $atts, $content = null, $code ) {
    return '<div class="row-fluid">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'row', 'oxy_shortcode_row' );

function oxy_shortcode_layout( $atts, $content = null, $code ) {
    return '<div class="' . $code . '">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'span1', 'oxy_shortcode_layout' );
add_shortcode( 'span2', 'oxy_shortcode_layout' );
add_shortcode( 'span3', 'oxy_shortcode_layout' );
add_shortcode( 'span4', 'oxy_shortcode_layout' );
add_shortcode( 'span5', 'oxy_shortcode_layout' );
add_shortcode( 'span6', 'oxy_shortcode_layout' );
add_shortcode( 'span7', 'oxy_shortcode_layout' );
add_shortcode( 'span8', 'oxy_shortcode_layout' );
add_shortcode( 'span9', 'oxy_shortcode_layout' );
add_shortcode( 'span10', 'oxy_shortcode_layout' );
add_shortcode( 'span11', 'oxy_shortcode_layout' );
add_shortcode( 'span12', 'oxy_shortcode_layout' );


/* ---------------------- COMPONENTS SHORTCODES --------------------- */

/* ---- BOOTSTRAP BUTTON SHORTCODE ----- */

function oxy_shortcode_button($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'type'        => 'default',
        'size'        => '',
        'side'        => 'left',
        'xclass'      => '',
        'link'        => '',
        'label'       => 'My button',
        'icon'        => '',
        'link_open'   => '_self'
    ), $atts ) );

    switch ($side){
        case 'left':
            if($icon != '')
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '"><i class="'.$icon.'"></i>   '. $label . '</a>';
            else
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '</a>';
        break;
        case 'right':
            if($icon != '')
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '   <i class="'.$icon.'"></i></a>';
            else
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '</a>';
        break;

    }
}


add_shortcode( 'button', 'oxy_shortcode_button' );


/* ---- BOOTSTRAP FANCY BUTTON SHORTCODE ----- */

function oxy_shortcode_button_fancy($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'button_swatch'     => 'swatch-coral',
        'button_animation'  => '',
        'size'              => 'default',
        'xclass'            => '',
        'link'              => '',
        'label'             => 'My button',
        'icon'              => '',
        'link_open'         => '_self',
        'rel'               => ''
    ), $atts ) );

    $animation = ( $button_animation != "") ? ' data-animation="'.$button_animation.'"' :"";
    return '<a href="'. $link .'" class="btn '. $size.' btn-icon-right '. $xclass . ' '. $button_swatch .'" target="' . $link_open . '" rel="' . $rel . '"> '. $label . '<span><i class="'.$icon.'" '.$animation.'></i></span></a>';

}


add_shortcode( 'button-fancy', 'oxy_shortcode_button_fancy' );



/* ---- BOOTSTRAP ALERT SHORTCODE ----- */

function oxy_shortcode_alert($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'type'        => 'default',
        'label'       => 'Warning!',
        'description' => 'Something is wrong!',

    ), $atts ) );

    return '<div class="alert ' . $type . '"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.$label.' </strong>'. $description .'</div>';
}


add_shortcode( 'alert', 'oxy_shortcode_alert' );

/* ----------------- BOOTSTRAP ACCORDION SHORTCODES ---------------*/

function oxy_shortcode_accordions($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'accordion_swatch' => 'swatch-white',
    ), $atts ) );

    $id = 'accordion_'.rand(100,999);
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );
    //var_dump($matches);
    $lis = array();
    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'accordion', $matches[2] ) ) {
        for( $i = 0; $i < $count; $i++ ) {
            $group_id = 'group_'.rand(100,999);
            // is it a tab?
            if( 'accordion' == $matches[2][$i] ) {
                $accordion_atts = shortcode_parse_atts( $matches[3][$i] );
                $open_close_class = 'collapse';
                if( isset( $accordion_atts['open'] ) ) {
                    $open_close_class = 'true' == $accordion_atts['open'] ? 'in' : 'collapse';
                }
                $lis[] = '<div class="accordion-heading">';
                $lis[] .= '<a class="accordion-toggle collapsed" data-parent="#'.$id.'" data-toggle="collapse" href="#'.$group_id.'">';
                $lis[] .= $accordion_atts['title'] .'</a></div>';
                $lis[] .= '<div class="accordion-body ' . $open_close_class . '" id="'.$group_id.'"><div class="accordion-inner">' .do_shortcode( $matches[5][$i] ) .'</div></div>';
            }
        }
    }

    return '<div class="accordion '.$accordion_swatch.'" id="'.$id.'"><div class="accordion-group">' . implode( $lis ) . '</div></div>';
}

add_shortcode( 'accordions', 'oxy_shortcode_accordions' );


function oxy_shortcode_accordion($atts , $content=''){

    return do_shortcode($content);
}

add_shortcode( 'accordion' , 'oxy_shortcode_accordion');


function oxy_shortcode_panel($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'header'        => 'My header',
        'swatch'        => 'swatch-white',

    ), $atts ) );
    return '<div class="panel '.$swatch.'"><div class="panel-header overlay"><h3 class="panel-title">'.$header.'</h3></div><div class="panel-body text-center"><p>'.$content.'</p></div></div>';
}

add_shortcode( 'panel' , 'oxy_shortcode_panel');

/* ----------- BOOTSTRAP TABS AND TAB PANES SHORTCODES --------- */


function oxy_shortcode_tab($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'style'        => 'top',

    ), $atts ) );
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );
    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'tab', $matches[2] ) ) {
        $lis  = array();
        $divs = array();
        $extraclass = ' active';
        for( $i = 0; $i < $count; $i++ ) {
            $pane_id = 'group_'.rand(100,999);
            // is it a tab?
            if( 'tab' == $matches[2][$i] ) {
                $tab_atts = wp_parse_args( $matches[3][$i] );
                $lis[] ='<li class="'.$extraclass.'"><a data-toggle="tab" href="#'.$pane_id.'">'.substr( $tab_atts['title'], 1, -1 ) .'</a></li>';
                $divs[] ='<div class="tab-pane'.$extraclass.'" id="'.$pane_id.'">'.do_shortcode( $matches[5][$i] ).'</div>';
                $extraclass = '';
            }
        }
    }
    switch ($style) {
        case 'top':
            $position = '';
            break;
        case 'bottom':
            $position = 'tabs-below';
            break;
        case 'left':
            $position = 'tabs-left';
            break;
        case 'right':
            $position = 'tabs-right';
            break;
        default:
            $position = '';
            break;
    }
    if($style == 'bottom'){
        return '<div class="tabbable '.$position.'"><div class="tab-content">'.implode( $divs ).'</div><ul class="nav nav-tabs" data-tabs="tabs">' . implode( $lis ) . '</ul></div>';
   }
    else{
        return '<div class="tabbable '.$position.'"><ul class="nav nav-tabs" data-tabs="tabs">' . implode( $lis ) . '</ul><div class="tab-content">'.implode( $divs ).'</div></div>';
    }
}

add_shortcode( 'tabs', 'oxy_shortcode_tab' );


function oxy_shortcode_tab_pane($atts , $content=''){

    return do_shortcode($content);
}

add_shortcode( 'tab' , 'oxy_shortcode_tab_pane');


/* ------------------ PROGRESS BAR SHORTCODE -------------------- */

function oxy_shortcode_progress_bar($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'percentage'  =>  50,
        'type'        => 'progress',
        'style'       => 'progress-info',

    ), $atts ) );

    return '<div class="'. $type .' '.$style.'"><div class="bar" style="width: '.$percentage.'%"></div></div>';
}


add_shortcode( 'progress', 'oxy_shortcode_progress_bar' );

/**
 * Icon shortcode - for showing an icon
 *
 * @return Icon html
 **/
function oxy_shortcode_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'size'       => 0,
    ), $atts ) );

    $output = '<i class="' . $content . '"';
    if( $size !== 0 ) {
        $output .= ' style="font-size:' . $size . 'px"';
    }
    $output .= '></i>';
    return $output;
}
add_shortcode( 'icon', 'oxy_shortcode_icon' );


/**
 * Blockquote Shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_blockquote( $atts, $content ) {
    extract( shortcode_atts( array(
        'who'   => '',
        'cite'  => '',
        'align'  => 'left',
    ), $atts ) );
    $output = '<blockquote ';
    if($align == 'right')
        {
        $output .= 'class = "pull-right"';
        }
    $output .='><p>' . do_shortcode($content) .'</p>';
    if( !empty( $who ) ) {
        $output .= '<small>' . $who;
        if( !empty( $cite ) ) {
            $output .= ' <cite title="source title">' . $cite . '</cite>';
        }
        $output .= '</small>';
    }
    $output .= '</blockquote>';

    return $output;
}add_shortcode( 'blockquote', 'oxy_shortcode_blockquote' );


/**
 * Icon List Shortcode
 *
 * @return Icon List
 **/
function oxy_shortcode_iconlist( $atts, $content = null ) {
    $output = '<ul class="icons-ul">';
    $output .= do_shortcode( $content );
    $output .= '</ul>';
    return $output;
}
add_shortcode( 'iconlist', 'oxy_shortcode_iconlist' );

/**
 * Icon Item Shortcode - for use inside an iconlist shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_iconitem( $atts, $content = null) {
    extract( shortcode_atts( array(
        'icon'          => ''
    ), $atts ) );

    $output = '<li>';
    $output .= '<i class="icon-li ' . $icon . '" ';
    $output .= '></i>'.$content.' </li>';
    return $output;
}
add_shortcode( 'iconitem', 'oxy_shortcode_iconitem' );