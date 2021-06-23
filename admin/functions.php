<?php

function connection_parameters_form_page_html() {
  global $wpdb;
  $connectionTable = $wpdb->prefix . 'connection_api';
  $valueConection = $wpdb->get_row("SELECT site, api_key FROM $connectionTable WHERE id = 1 ");

  if (!empty($_POST)){
    $site = sanitize_text_field($_POST['site']);
    $apiKey = sanitize_text_field($_POST['api_key']);

    if (!empty($site) && !empty($apiKey) && wp_verify_nonce($_POST['value_nonce'], 'save_value')) {

      $createdAt = date('Y-m-d H:i:s');
      $wpdb->update(
        $connectionTable,
        array(
            'site' => $site,
            'api_key' => $apiKey,
            'ip' => $_POST['value_nonce'],
            'created_at' => $createdAt
        ),
        array(
            'id' => '1'
        )
      );
    }
  }

  ?>
  <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="<?php get_the_permalink(); ?>" method="post">
      <div class="wp-privacy-request-form-field">
        <table class="form-table">
          <?php wp_nonce_field('save_value', 'value_nonce'); ?>
          <tr>
            <th scope="row">
              <label for="site"><?php esc_html_e( 'Site' ); ?></label>
            </th>
            <td>
              <input type="text" required class="regular-text ltr" id="site" name="site" value="<?php esc_html_e($valueConection->site); ?>" />
            </td>
          </tr>
          <tr>
            <th scope="row">
              <label for="api_key"><?php esc_html_e( 'API key' ); ?></label>
            </th>
            <td>
              <input type="text" required class="regular-text ltr" id="api_key" name="api_key" value="<?php esc_html_e($valueConection->api_key); ?>" />
            </td>
          </tr>
        </table>
      </div>
      <?php
      // output security fields for the registered setting "wporg_options"
      settings_fields( 'wporg_options' );
      // output setting sections and their fields
      // (sections are registered for "wporg", each field is registered to a specific section)
      do_settings_sections( 'wporg' );
      // output save settings button
      submit_button( __( 'Save', 'textdomain' ) );
      ?>
    </form>
  </div>
  <?php

}

function connection_form_options_page() {
  add_submenu_page(
  'tools.php',
  'Conexion API Chargebee',
  'Conexion API',
  'manage_options',
  'api_connection',
  'connection_parameters_form_page_html'
  );
}

add_action('admin_menu', 'connection_form_options_page');
