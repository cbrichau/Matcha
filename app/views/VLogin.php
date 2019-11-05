<form method="POST">
  <h1><?php echo $output->get_head_title(); ?></h1>

  <?php echo $error_alert; ?>
  <input type="text" name="username" placeholder="Username" value="<?php echo $form_prefill['username']; ?>" class="form-control my-2" required>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
  <button type="submit" name="login" class="btn btn-primary btn-block"><?php echo $output->get_head_title(); ?></button>
  <a href="<?php echo Config::ROOT.'index.php?cat=reset'; ?>">Forgotten password?</a>
</form>
