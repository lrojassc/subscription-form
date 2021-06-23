<?php

function dbi_load_carbon_fields() {
  \Carbon_Fields\Carbon_Fields::boot();
}

add_action( 'after_setup_theme', 'dbi_load_carbon_fields' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function dbi_add_plugin_settings_page() {
  Container::make( 'theme_options', __( 'Conexion API' ) )
    ->set_page_parent( 'tools.php' )
    ->add_fields( array(
        Field::make( 'text', 'site', 'Site' )
            ->set_attribute( 'maxLength', 40 )
            ->set_default_value( 'test' ),
        Field::make( 'text', 'api_key', 'API Key' )
            ->set_attribute( 'maxLength', 100 )
            ->set_default_value( 'test' ),
    ) );
}
add_action( 'carbon_fields_register_fields', 'dbi_add_plugin_settings_page' );