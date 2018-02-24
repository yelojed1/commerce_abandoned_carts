<?php

namespace Drupal\commerce_abandoned_carts\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Commerce Abandonned Carts settings form.
 */
class AdminForm extends ConfigFormBase {

  /**
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * Constructs a \Drupal\system\ConfigFormBase object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory,ModuleHandlerInterface $module_handler, ThemeHandlerInterface $theme_handler) {
    parent::__construct($config_factory);
    $this->moduleHandler = $module_handler;
    $this->themeHandler = $theme_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('module_handler'),
      $container->get('theme_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'commerce_abandoned_carts_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['commerce_abandoned_carts.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('commerce_abandoned_carts.settings');

    $form = [];
    $form['commerce_abandoned_carts']['commerce_abandoned_carts_timeout'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Send Timeout'),
      '#default_value' => $config->get('commerce_abandoned_carts_timeout') ? $config->get('commerce_abandoned_carts_timeout') : 1440,
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('How many minutes to wait before sending the abandoned cart message in <strong>minutes</strong>. Note, there are 1440 minutes in one day?'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_history_limit'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('History Limit'),
      '#default_value' => $config->get('commerce_abandoned_carts_history_limit') ? $config->get('commerce_abandoned_carts_history_limit') : 21600,
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('What is the limit (in minutes) to how far back to search for abandoned carts. Default is 15 days.'),
    ];

    //TOFIX
    // Use the right function to return commerce_order_status.
    //$statuses = '';
    $options = array();
    /*foreach ($statuses as $key => $status){
      $options[$key] = $status['title'];
    }*/

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_abandoned_statuses'] = [
      '#type'          => 'checkboxes',
      '#title'         => $this->t('Abandoned Statuses'),
      '#options'       => $options,
      '#default_value' => $config->get('commerce_abandoned_carts_abandoned_statuses') ? $config->get('commerce_abandoned_carts_abandoned_statuses') : array('draft'),
      '#description'   => $this->t('Select all cart/order statuses that will be considered abandoned. Only carts/orders with the selected statuses will be processes for sending messages to.'),
    ];

    $options = array(
      5 => '5',
      10 => '10',
      25 => '25',
      50 => '50',
      75 => '75',
      100 => '100',
    );

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_batch_limit'] = [
      '#type'          => 'select',
      '#title'         => $this->t('Batch Limit'),
      '#options'       => $options,
      '#default_value' => $config->get('commerce_abandoned_carts_batch_limit') ? $config->get('commerce_abandoned_carts_batch_limit') : 10,
      '#description'   => $this->t('What is the maximum emails to send per cron run? Note, larger batches may cause performance issues.'),
    ];

    //TODO Add #element_validate to validate email.
    $form['commerce_abandoned_carts']['commerce_abandoned_carts_from_email'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('From Email Address'),
      '#default_value' => $config->get('commerce_abandoned_carts_from_email') ? $config->get('commerce_abandoned_carts_from_email') : '',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter the email address to send the emails from. Leave blank to use site-wide email address.'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_from_name'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('From Email Name'),
      '#default_value' => $config->get('commerce_abandoned_carts_from_name') ? $config->get('commerce_abandoned_carts_from_name') : '',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter the name to send the emails from.  Leave blank to use site name.'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_subject'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Subject Line'),
      '#default_value' => $config->get('commerce_abandoned_carts_from_subject') ? $config->get('commerce_abandoned_carts_from_subject') : 'Your order is incomplete.',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter the subject of the email.'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_customer_service_phone_number'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Customer Service Phone Number'),
      '#default_value' => $config->get('commerce_abandoned_carts_customer_service_phone_number') ? $config->get('commerce_abandoned_carts_customer_service_phone_number') : '',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter a phone number to be displayed in the email template for customers who may have had trouble checking out. Leave empty to obmit from email.'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_bcc_active'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Send BCC?'),
      '#default_value' => $config->get('commerce_abandoned_carts_bcc_active') ? $config->get('commerce_abandoned_carts_bcc_active') : 0,
      '#description'   => $this->t('Would you like to send a Blind Carbon Copy of all Abandoned Cart messages to an admin account for monintoring?'),
    ];

    //TODO add element validate for email.
    $form['commerce_abandoned_carts']['commerce_abandoned_carts_bcc_email'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('BCC Email Address'),
      '#default_value' => $config->get('commerce_abandoned_carts_bcc_email') ? $config->get('commerce_abandoned_carts_bcc_email') : '',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter the email address to send the test emails to.'),
    ];

    $form['commerce_abandoned_carts']['commerce_abandoned_carts_testmode_active'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Enable Test Mode'),
      '#default_value' => $config->get('commerce_abandoned_carts_testmode_active') ? $config->get('commerce_abandoned_carts_testmode_active') : 1,
      '#description'   => $this->t('When test mode is active all abandoned carts messages will be sent to the test email address instead of cart owner for testing purposes. When in test module the status of the message is not updated so the same messages will be sent on each cron run.'),
    ];

    //TODO add element validate for email.
    $form['commerce_abandoned_carts']['commerce_abandoned_carts_testmode_email'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Test Mode Email'),
      '#default_value' => $config->get('commerce_abandoned_carts_testmode_email') ? $config->get('commerce_abandoned_carts_testmode_email') : '',
      '#size'          => 60,
      '#maxlength'     => 128,
      '#description'   => $this->t('Enter the email address to send the test emails to.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('commerce_abandoned_carts.settings');

    // Set the default timeout.
    if ($form_state->hasValue('commerce_abandoned_carts_timeout')) {
      $config->set('format', $form_state->getValue('commerce_abandoned_carts_timeout'));
    }
    $config->save();
  }

}
