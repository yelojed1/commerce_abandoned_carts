<?php
/**
 * Implements hook_views_data().
 */
function commerce_abandoned_carts_views_data() {
  
  $data['commerce_abandoned_carts']['table']['group'] = t('Abandoned Carts');
  $data['commerce_abandoned_carts']['table']['base'] = array(
    'field' => 'order_id', // This is the identifier field for the view.
    'title' => t('Order ID'),
    'help' => t('Abandoned Cart Order ID.'),
    'weight' => -10,
  );
 
  $data['commerce_abandoned_carts']['table']['join'] = array(  
    'commerce_order' => array(
      'left_field' => 'order_id',
      'field' => 'order_id',
    ),
  );
     
  $data['commerce_abandoned_carts']['status'] = array(
    'title' => t('Email Sent'),
    'help' => t('Show if an Abandoned Cart email been sent for this order'),
    'field' => array(
      'handler' => 'views_handler_field_boolean',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_boolean_operator',
      // Note that you can override the field-wide label:
      'label' => t('Published'),
      // This setting is used by the boolean filter handler, as possible option.
      'type' => 'yes-no',
      // use boolean_field = 1 instead of boolean_field <> 0 in WHERE statement.
      'use equal' => TRUE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );
   
  $data['commerce_abandoned_carts']['timestamp'] = array(
    'title' => t('Timestamp'),
    'help' => t('Timestamp when the email was sent.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort_date',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
  );
  return $data;
}