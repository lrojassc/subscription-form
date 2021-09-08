<?php

// Definir shortcode que muestra el formulario
add_shortcode('subscription-form', 'create_subscription_form');

function create_subscription_form() {
    if (!empty($_POST)){
      if (wp_verify_nonce($_POST['value_nonce'], 'send_values')) {
        $name = sanitize_text_field($_POST['nombre']);
        $lastName = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_file_name($_POST['mobile']);
        $state = sanitize_text_field($_POST['state']);
        $city = sanitize_text_field($_POST['city']);
        $address = sanitize_text_field($_POST['address']);
        $card = sanitize_text_field($_POST['card']);
        $month = sanitize_text_field($_POST['mes']);
        $year = sanitize_text_field($_POST['año']);
        $cvv = sanitize_text_field($_POST['cvv']);

        if (!empty($name) && !empty($lastName) && !empty($email)) {
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

          //Data customer
          $customer = [
              'firstName' => $name,
              'lastName' => $lastName,
              'email' => $email,
              'phone' => $phone,
              'company' => 'Test'
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
          $subscription = $api->create_subscription_chargebee($billingAddress, $customer, $card);
        }
      }
    }

    ob_start();
    ?>
    <?php if (isset($subscription)) { ?>
        <p><strong>Se ha realizado la suscripción.</strong></p>
    <?php } ?>
    <form action="<?php get_the_permalink(); ?>" method="post">
      <?php wp_nonce_field('send_values', 'value_nonce'); ?>
      <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input class="form-control" type="text" id="nombre" name="nombre" required>
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
          <label for="mes">Mes</label>
          <input type="number" class="form-control" id="mes" name="mes" required>
        </div>
        <div class="form-group col-md-6">
          <label for="año">Año</label>
          <input type="number" class="form-control" id="año" name="año" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label" for="cvv">CVV</label>
        <input class="form-control" type="number" id="cvv" name="cvv" required>
      </div>
      <div class="form-input">
        <input type="submit" value="Enviar">
      </div>
    </form>
  <?php

  // Devuelve el contenido del buffer de salida
  return ob_get_clean();
}