<?php
/*  ************************************************************  */
class woocommerce_disable_checkout_fields {
 
  var $update_billing;
  var $disabled_billing;
  var $disabled_shipping;
  var $update_shipping;
 
  public function __construct() { 
 
    // If you do not have shipping on checkout, then only billing will have an effect
    $this->disabled_shipping = array('shipping_last_name');
    $this->update_shipping = array();
 
    $this->disabled_billing = array('billing_company', 'billing_address_1', 'billing_address_2', 'billing_city', 
            'billing_postcode', 'billing_country', 'billing_state');//, 'billing_phone');
    $this->update_billing = array(
      //'billing_first_name'  => array(
      //  'name'=>  'billing_first_name',
      //  'label'                 => __('Name','wc_disable_checkout_fields'),
      //  'placeholder'     => __('Name','wc_disable_checkout_fields'),
      //  'required'              => true,
      //  'class'                 => array('form-row-first')
      //  ),
      //'billing_company'         => array(
      //  'label'                 => __('Company','wc_disable_checkout_fields'),
      //  'placeholder'     => __('Company','wc_disable_checkout_fields'),
      //  'required'              => false,
      //  'class'                 => array('form-row-first')
      //  ),
      'billing_email'   => array(
        'label'                 => __('Email','wc_disable_checkout_fields'),
        'placeholder'     => __('you@yourdomain.com','wc_disable_checkout_fields'),
        'required'              => true,
        'class'                 => array('form-row-first')
        )
      ,
      'billing_phone'         => array(
        'label'                 => __('Phone','wc_disable_checkout_fields'),
        'placeholder'     => __('Phone number','wc_disable_checkout_fields'),
        'required'              => true,
        'class'                 => array('form-row-first')
        )
      );
 
    // Filters for checkout actions
    add_filter( 'woocommerce_shipping_fields', array(&$this, 'filter_shipping'), 10, 1 );
    add_filter( 'woocommerce_billing_fields', array(&$this, 'filter_billing'), 10, 1 );
  } 
 
 
  // array_flip is a somewhat smelly way to make a normal array into an associative one
  // 
  // This does not work wit hversion of PHP on HostGator unfortunately... need to figure this out. :X - jSF
  // 
  function filter_shipping( $fields_array ) {
    $fields_array = array_replace($fields_array, $this->update_shipping);
    return array_diff_key($fields_array, array_flip($this->disabled_shipping));
  }
 
  function filter_billing( $fields_array ) {
    $fields_array = array_replace($fields_array, $this->update_billing);
    return array_diff_key($fields_array, array_flip($this->disabled_billing));
  }
 
 
}

$woocommerce_disable_checkout_fields = new woocommerce_disable_checkout_fields();

/*
http://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
//
type – type of field (text, textarea, password, select)
label – label for the input field
placeholder – placeholder for the input
class – class for the input
required – true or false, whether or not the field is require
clear – true or false, applies a clear fix to the field/label
label_class – class for the label element
options – for select boxes, array of options (key => value pairs)

 */

/////////////////////////////////// Custom Checkout Options specific to Steel City Improv
//
//
/**
 * Add the field to the checkout
 **/
add_action('woocommerce_before_order_notes', 'my_custom_checkout_shippingArea_field');

function my_custom_checkout_shippingArea_field( $checkout ) {

    echo '<div id="my_custom_checkout_shippingArea_field"><h3>'.__('Attendee / Student Details').'</h3>';
    echo '<input type="checkbox" name="check1" onchange="copyTextValue(this);"/> Same?';
    woocommerce_form_field( 'attendee_first_name_1', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('First Name'),
        'placeholder'   => __('Please enter a First Name'),
        'required'    => 'true',
        )
    , $checkout->get_value( 'attendee_first_name_1' ));

    woocommerce_form_field( 'attendee_last_name_1', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Last Name'),
        'placeholder'   => __('Please enter a Last Name'),
        'required'    => 'true',
        )
    , $checkout->get_value( 'attendee_last_name_1' ));

    woocommerce_form_field( 'attendee_email_1', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Email'),
        'placeholder'   => __('them@theirdomain.com'),
        'required'    => 'true',
        )
    , $checkout->get_value( 'attendee_email_1' ));

    woocommerce_form_field( 'attendee_phone_1', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Phone #'),
        'placeholder'   => __('Please enter a Contact #'),
        'required'    => 'true',
        )
    , $checkout->get_value( 'attendee_phone_1' ));


    echo '</div>';

}


add_action('woocommerce_before_checkout_billing_form', 'my_custom_checkout_billingArea_field');

function my_custom_checkout_billingArea_field( $checkout ) {

    echo '<div id="my_custom_checkout_billingArea_field">';

    woocommerce_form_field( 'billing_first_name', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('First Name'),
        'placeholder'   => __('Please enter a First Name'),
        'required'    => 'true',
        ), $checkout->get_value( 'billing_first_name' ));

    woocommerce_form_field( 'billing_last_name', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Last Name'),
        'placeholder'   => __('Please enter a Last Name'),
        'required'    => 'true',
        ), $checkout->get_value( 'billing_last_name' ));

    woocommerce_form_field( 'billing_email', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Email'),
        'placeholder'   => __('you@yourdomain.com'),
        'required'    => 'true',
        ), $checkout->get_value( 'billing_email' ));

    woocommerce_form_field( 'billing_phone', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Phone #'),
        'placeholder'   => __('Please enter a Contact Number'),
        'required'    => 'true',
        ), $checkout->get_value( 'billing_phone' ));



    echo '</div>';

}



/**
 * Process the checkout
 **/
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
    global $woocommerce;

    // Check if set, if its not set add an error.
    if (!$_POST['attendee_first_name_1'] || !$_POST['attendee_last_name_1'] || !$_POST['attendee_email_1'] || !$_POST['attendee_phone_1'])
         $woocommerce->add_error( __('Please fill in all required fields.') );
}

/**
 * Update the order meta with field value
 **/
add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');

function my_custom_checkout_field_update_order_meta( $order_id ) {
//
//  We need to port the custom field display to the WooCommerce _fields.
    if ($_POST['billing_first_name']) update_post_meta( $order_id, '_billing_first_name', esc_attr($_POST['billing_first_name']));
    if ($_POST['billing_last_name']) update_post_meta( $order_id, '_billing_last_name', esc_attr($_POST['billing_last_name']));
    if ($_POST['billing_email']) update_post_meta( $order_id, '_billing_email', esc_attr($_POST['billing_email']));
    if ($_POST['billing_phone']) update_post_meta( $order_id, '_billing_phone', esc_attr($_POST['billing_phone']));
    //if ($_POST['billing_postcode']) update_post_meta( $order_id, '_billing_postcode', esc_attr($_POST['billing_postcode']));


    //  This is if we just want their information to be stored as Custom Data
    if ($_POST['attendee_first_name_1']) update_post_meta( $order_id, '_attendee1_first_name', esc_attr($_POST['attendee_first_name_1']));
    if ($_POST['attendee_last_name_1']) update_post_meta( $order_id, '_attendee1_last_name', esc_attr($_POST['attendee_last_name_1']));
    if ($_POST['attendee_email_1']) update_post_meta( $order_id, '_attendee1_email', esc_attr($_POST['attendee_email_1']));
    if ($_POST['attendee_phone_1']) update_post_meta( $order_id, '_attendee1_phone', esc_attr($_POST['attendee_phone_1']));
    //
    //
    //  This is if we want to store their data as the Shipping Address
    if ($_POST['attendee_first_name_1']) update_post_meta( $order_id, '_shipping_first_name', esc_attr($_POST['attendee_first_name_1']));
    if ($_POST['attendee_last_name_1']) update_post_meta( $order_id, '_shipping_last_name', esc_attr($_POST['attendee_last_name_1']));
    if ($_POST['attendee_email_1']) update_post_meta( $order_id, '_shipping_email', esc_attr($_POST['attendee_email_1']));
    if ($_POST['attendee_phone_1']) update_post_meta( $order_id, '_shipping_phone', esc_attr($_POST['attendee_phone_1']));

    
}

/////////////////////////////////////////////////////////////////////////////////////////
/* Remove Woocommerce User Fields */
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields' );

function custom_override_checkout_fields( $fields ) {
  unset($fields['billing_first_name']);
  unset($fields['billing_last_name']);
  unset($fields['billing_phone']);
  unset($fields['billing_email']);
  unset($fields['shipping_first_name']);
  unset($fields['shipping_last_name']);
  unset($fields['shipping_phone']);
  unset($fields['shipping_email']);
  //
  unset($fields['billing_state']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_city']);
  //
  //
  //
  unset($fields['shipping']['shipping_state']);
  unset($fields['shipping']['shipping_country']);
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_address_1']);
  unset($fields['shipping']['shipping_address_2']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_city']);
  return $fields;
}
function custom_override_billing_fields( $fields ) {
  unset($fields['billing_first_name']);
  unset($fields['billing_last_name']);
  unset($fields['billing_phone']);
  unset($fields['billing_email']);
  //
  unset($fields['billing_state']);
  unset($fields['billing_country']);
  unset($fields['billing_company']);
  unset($fields['billing_address_1']);
  unset($fields['billing_address_2']);
  unset($fields['billing_postcode']);
  unset($fields['billing_city']);
  return $fields;
}
function custom_override_shipping_fields( $fields ) {
  unset($fields['shipping_first_name']);
  unset($fields['shipping_last_name']);
  unset($fields['shipping_phone']);
  unset($fields['shipping_email']);
  //
  unset($fields['shipping_state']);
  unset($fields['shipping_country']);
  unset($fields['shipping_company']);
  unset($fields['shipping_address_1']);
  unset($fields['shipping_address_2']);
  unset($fields['shipping_postcode']);
  unset($fields['shipping_city']);
  return $fields;
}
/* End - Remove Woocommerce User Fields */

?>