<form method="POST">
	<?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

	<?php echo $error_alert['location']; ?>
	<input type="hidden" name="latitude" value="<?php echo $form_prefill['latitude']; ?>">
	<input type="hidden" name="longitude" value="<?php echo $form_prefill['longitude']; ?>">

  <?php echo $error_alert['email']; ?>
  <input type="email" name="email" placeholder="Email" value="<?php echo $form_prefill['email']; ?>" class="form-control my-2" required>

	<?php echo $error_alert['username']; ?>
  <input type="text" name="username" placeholder="Username" value="<?php echo $form_prefill['username']; ?>" class="form-control my-2" required>

	<?php echo $error_alert['first_name']; ?>
  <input type="text" name="first_name" placeholder="First name" value="<?php echo $form_prefill['first_name']; ?>" class="form-control my-2" required>

  <?php echo $error_alert['last_name']; ?>
  <input type="text" name="last_name" placeholder="Last name" value="<?php echo $form_prefill['last_name']; ?>" class="form-control my-2" required>

	<?php echo $error_alert['password']; ?>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
  <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control my-2" required>

	<button type="submit" name="register" class="btn btn-primary btn-block"><?php echo $output->get_head_title(); ?></button>
</form>

<?php
$ip = '0.0.0.0';
	 $ip = $_SERVER['REMOTE_ADDR'];
	 $clientDetails = json_decode(file_get_contents("http://ipinfo.io/$ip/json"));
	 print_r($clientDetails);

 ?>
