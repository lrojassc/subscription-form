<?php
/**
 * Plugin Name: Subscription Form
 * Description: Plugin para crear un formulario personalizado y crear una suscripción de pago utilizando una API, utilizar el shortcode [subscription-form]
 * Version: 0.1.0
 * Author: Liever Rojas
 */

require_once plugin_dir_path(__FILE__).'public/functions.php';
require_once plugin_dir_path(__FILE__).'public/class-subscription-form-chargebee.php';
require_once plugin_dir_path(__FILE__).'admin/functions.php';