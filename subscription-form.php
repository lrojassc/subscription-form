<?php
/**
 * Plugin Name: Subscription Form
 * Description: Plugin para crear un formulario personalizado y crear una suscripción de pago utilizando una API, utilizar el shortcode [subscription-form]
 * Version: 0.1.0
 * Author: Liever Rojas
 */

register_activation_hook(__FILE__, 'create_table_conection_api');

/**
 * Crea la tabla para recoger los datos del formulario de administración
 * @return void
 */
function create_table_conection_api() {
  global $wpdb;
  $connectionTable = $wpdb->prefix . 'connection_api';
  $charsetCollate = $wpdb->get_charset_collate();

  //Consulta para crear la tabla
  $query = "CREATE TABLE IF NOT EXISTS $connectionTable (
    id integer (10) NOT NULL,
    site varchar(100) NOT NULL,
    api_key varchar(100) NOT NULL,
    ip varchar (300),
    created_at datetime NOT NULL 
  ) $charsetCollate";

  //La función dbDelta permite crear tablas de manera segura
  include_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($query);

  //Insertar datos test
  $createdAt = date('Y-m-d H:i:s');
  $wpdb->insert(
    $connectionTable,
    array(
      'id' => '1',
      'site' => 'test',
      'api_key' => 'test',
      'ip' => 'test',
      'created_at' => $createdAt
    )
  );
}


require_once plugin_dir_path(__FILE__).'public/functions.php';
require_once plugin_dir_path(__FILE__).'public/class-subscription-form-chargebee.php';
require_once plugin_dir_path(__FILE__).'admin/functions.php';