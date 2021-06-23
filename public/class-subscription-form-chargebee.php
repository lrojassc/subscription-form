<?php

require_once plugin_dir_path(__FILE__).'../includes/vendor/autoload.php';

class Subscription_Form_Chargebee {

  public function create_subcription_chargebee($billingAddress, $customer, $card) {

    //Obtener valores para acceder a la API
    global $wpdb;
    $connectionTable = $wpdb->prefix . 'connection_api';
    $valueConection = $wpdb->get_row("SELECT site, api_key FROM $connectionTable WHERE id = 1 ");

    //enviar datos a API
    ChargeBee_Environment::configure($valueConection->site, $valueConection->api_key);

    $result = ChargeBee_Subscription::create(array(
      "planId" => "basic---annual",
      "autoCollection" => "off",
      "billingAddress" => $billingAddress,
      "customer" => $customer,
      "card" => $card
    ));

    $subscription = $result->subscription();
    $customer = $result->customer();
    $card = $result->card();
    $invoice = $result->invoice();

  }

}