<?php

// Definir shortcode que muestra el formulario
add_shortcode('subscription-form', 'create_subscription_form');

add_action('admin_post_nopriv_subscription', 'get_form_values_and_send_to_api');
add_action('admin_post_subscription', 'get_form_values_and_send_to_api');

/**
 * Function to create subscription form
 * @return false|string
 */
function create_subscription_form() {

    ob_start();
    ?>
    <form action="<?php echo esc_url(admin_url('admin-post.php'))?>" method="post">
      <?php wp_nonce_field('send_values', 'value_nonce'); ?>
      <div class="form-group">
        <label class="form-label" for="name">Nombre</label>
        <input class="form-control" type="text" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="last_name">Apellido</label>
        <input class="form-control" type="text" id="last_name" name="last_name" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="email">Correo</label>
        <input class="form-control" type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="country">Pais</label>
        <input class="form-control" type="text" id="country" name="country" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="">Departamento</label>
        <input class="form-control" type="text" id="state" name="state" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="">Ciudad</label>
        <input class="form-control" type="text" id="city" name="city" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="address">Dirección</label>
        <input class="form-control" type="text" id="address" name="address" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="mobile">Celular</label>
        <input class="form-control" type="text" id="mobile" name="mobile" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="card">Numero tarjeta de credito</label>
        <input class="form-control" type="number" id="card" name="card" required>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="month">Mes</label>
          <input type="number" class="form-control" id="month" name="month" required>
        </div>
        <div class="form-group col-md-6">
          <label for="year">Año</label>
          <input type="number" class="form-control" id="year" name="year" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="cvv">CVV</label>
        <input class="form-control" type="number" id="cvv" name="cvv" required>
      </div>
      <div class="form-input">
        <input type="submit" value="Enviar">
      </div>
      <div class="form-input">
        <input type="hidden" name="action" value="subscription">
      </div>
    </form>
    <?php

    // Devuelve el contenido del buffer de salida
    return ob_get_clean();
}

function get_form_values_and_send_to_api() {

    if (!empty($_POST)) {
      if (wp_verify_nonce($_POST['value_nonce'], 'send_values')) {

        $name = sanitize_text_field($_POST['name']);
        $lastName = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_file_name($_POST['mobile']);
        $state = sanitize_text_field($_POST['state']);
        $city = sanitize_text_field($_POST['city']);
        $address = sanitize_text_field($_POST['address']);
        $card = sanitize_text_field($_POST['card']);
        $month = sanitize_text_field($_POST['month']);
        $year = sanitize_text_field($_POST['year']);
        $cvv = sanitize_text_field($_POST['cvv']);

        if (!empty($name) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($state) && !empty($city) &&
        !empty($address) && !empty($card) && !empty($month) && !empty($year) && !empty($cvv)) {

          //billing address
          $billingAddress = [
              'firstName' => $name,
              'lastName' => $lastName,
              'email' => $email,
              'phone' => $phone,
              'country' => 'CO',
              'state' => $state,
              'city' => $city,
              'line1' => $address
          ];

          //data customer
          $customer = [
              'firstName' => $name,
              'lastName' => $lastName,
              'email' => $email,
              'phone' => $phone
          ];

          //Data card
          $card = [
              "gatewayAccountId" => "gw_16CKjISS2yZ1E61V",
              "number" => $card,
              "expiryMonth" => $month,
              "expiryYear" => $year,
              "cvv" => $cvv
          ];

          $api = new Subscription_Form_Chargebee();
          $api->create_subcription_chargebee($billingAddress, $customer, $card);
        }
      }
    }
}
