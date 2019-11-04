<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <?php echo $error_alert['email']; ?>
  <input type="email" name="email" placeholder="Email" value="<?php echo $form_prefill['email']; ?>" class="form-control my-2" required>

  <?php echo $error_alert['password']; ?>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
  <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control my-2" required>

  <button type="submit" name="reset" class="btn btn-primary btn-block"><?php echo $output->get_head_title(); ?></button>
</form>
