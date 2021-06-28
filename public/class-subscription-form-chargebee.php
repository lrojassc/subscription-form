<?php

require_once plugin_dir_path(__FILE__).'../includes/vendor/autoload.php';

class Subscription_Form_Chargebee {

  /**
   * Function that create subscription to API chargebee
   * @param $billingAddress
   * @param $customer
   * @param $card
   */
  public function create_subscription_chargebee($billingAddress, $customer, $card) {
    try {
      $site = carbon_get_theme_option('site');
      $apiKey = carbon_get_theme_option('api_key');

      //enviar datos a API
      ChargeBee_Environment::configure($site, $apiKey);

      $result = ChargeBee_Subscription::create(array(
        "planId" => "basic---annual",
        "billingAddress" => $billingAddress,
        "customer" => $customer,
        "card" => $card
      ));

      return true;
    } catch (Exception $e) {
      return false;
    }
  }

}