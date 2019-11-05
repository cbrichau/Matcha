<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <?php if ($reset_request_form): ?>
    <?php echo $error_alert['email']; ?>
    <input type="email" name="email" placeholder="Email" value="<?php echo $form_prefill['email']; ?>" class="form-control my-2" required>
    <button type="submit" name="reset_request" class="btn btn-primary btn-block">Reset my password</button>

  <?php elseif ($new_password_form): ?>
    <?php echo $error_alert['password']; ?>
    <input type="hidden" name="validation_code" value="<?php echo $form_prefill['validation_code']; ?>" required>
    <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
    <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control my-2" required>
    <button type="submit" name="new_password" class="btn btn-primary btn-block">Save my new password</button>

  <?php endif; ?>
</form>
