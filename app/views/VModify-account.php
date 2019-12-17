<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <label class="label">Email</label>
  <?php echo $error_alert['email']; ?>
  <input type="email" name="email" value="<?php echo $form_prefill['email']; ?>" class="form-control" required>

  <label class="label">Username</label>
  <?php echo $error_alert['username']; ?>
  <input type="text" name="username" value="<?php echo $form_prefill['username']; ?>" class="form-control" required>

  <label class="label">First name</label>
  <?php echo $error_alert['first_name']; ?>
  <input type="text" name="first_name" value="<?php echo $form_prefill['first_name']; ?>" class="form-control" required>

  <label class="label">Last name</label>
  <?php echo $error_alert['last_name']; ?>
  <input type="text" name="last_name" value="<?php echo $form_prefill['last_name']; ?>" class="form-control" required>

  <label class="label">Password</label>
  <?php echo $error_alert['password']; ?>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control mb-1" required>
  <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control" required>

  <button type="submit" name="modify" class="btn btn-primary btn-block my-3"><?php echo $output->get_head_title(); ?></button>

  <p>Modify my <a href="<?php echo Config::ROOT.'index.php?cat=modify-profile'; ?>">profile</a>,
    <a href="<?php echo Config::ROOT.'index.php?cat=modify-pictures'; ?>">pictures</a>, or
    <a href="<?php echo Config::ROOT.'index.php?cat=modify-mate'; ?>">ideal mate</a>.</p>
</form>
