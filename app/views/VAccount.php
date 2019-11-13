<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <?php echo $error_alert['email']; ?>
  <input type="email" name="email" placeholder="Email" value="<?php echo $form_prefill['email']; ?>" class="form-control my-2" required>

  <?php echo $error_alert['username']; ?>
  <input type="text" name="username" placeholder="Username" value="<?php echo $form_prefill['username']; ?>" class="form-control my-2" required>

  <?php echo $error_alert['first_name']; ?>
  <input type="text" name="first_name" placeholder="First name" value="<?php echo $form_prefill['first_name']; ?>" class="form-control my-2" required>

  <?php echo $error_alert['last_name']; ?>
  <input type="text" name="last_name" placeholder="Last name" value="<?php echo $form_prefill['last_name']; ?>" class="form-control my-2" required>

  <hr/>

  <?php echo $error_alert['password']; ?>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
  <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control my-2" required>

  <hr/>

  <?php echo $error_alert['date_of_birth']; ?>
  <input type="date" name="date_of_birth" placeholder="Date of birth" value="<?php echo $form_prefill['date_of_birth']; ?>" class="form-control my-2">

  <?php echo $error_alert['location']; ?>
  <input type="text" name="location" placeholder="Location" value="" class="form-control my-2">

  <?php echo $error_alert['gender_self']; ?>
  <label><input type="radio" name="gender_self" value="NULL" checked> Undefined</label>
  <label><input type="radio" name="gender_self" value="F"> Female</label>
  <label><input type="radio" name="gender_self" value="M"> Male</label>

  <?php echo $error_alert['gender_seeked']; ?>
  <label><input type="radio" name="gender_seeked" value="NULL" checked> Any</label>
  <label><input type="radio" name="gender_seeked" value="F"> Female</label>
  <label><input type="radio" name="gender_seeked" value="M"> Male</label>

  <?php echo $error_alert['bio']; ?>
  <textarea name="bio" placeholder="Bio" value="" class="form-control my-2" rows="3"></textarea>

  <?php echo $error_alert['interests']; ?>
  <label><input type="checkbox" name="i" value="i"> Interest 1</label>
  <label><input type="checkbox" name="i" value="i"> Interest 2</label>
  <label><input type="checkbox" name="i" value="i"> Interest 3</label>

  <button type="submit" name="modify" class="btn btn-primary btn-block"><?php echo $output->get_head_title(); ?></button>
</form>
