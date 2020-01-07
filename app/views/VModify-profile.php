<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <label class="label">Gender</label>
  <?php echo $error_alert['gender']; ?>
  <select class="form-control" name="gender">
    <option value="" <?php echo $form_prefill['gender_any']; ?>>Undefined</option>
    <option value="F" <?php echo $form_prefill['gender_F']; ?>>Female</option>
    <option value="M" <?php echo $form_prefill['gender_M']; ?>>Male</option>
  </select>

  <label class="label">Date of birth</label>
  <?php echo $error_alert['date_of_birth']; ?>
  <input type="date" name="date_of_birth" value="<?php echo $form_prefill['date_of_birth']; ?>" class="form-control">

  <label class="label">Location</label>
  <?php echo $error_alert['location']; ?>
  <select class="form-control" name="location_on">
    <option value="1" <?php echo $form_prefill['location_yes']; ?>>On</option>
    <option value="0" <?php echo $form_prefill['location_no']; ?>>Off</option>
  </select>

  <?php
  $loc = str_replace(' ', ',', $form_prefill['location']);
  if ($form_prefill['location_on'] == '1')
    echo '<input type="text" name="location" value="'.$form_prefill['location'].'" class="form-control">
          <a href="https://www.google.be/maps/place/'.$loc.'" target="_blank">View on Maps</a>';
  else
    echo '<input type="hidden" name="location" value="'.$form_prefill['location'].'" class="form-control">';
  ?>

  <label class="label">Bio</label>
  <?php echo $error_alert['bio']; ?>
  <textarea name="bio" class="form-control" rows="3"><?php echo $form_prefill['bio']; ?></textarea>

  <label class="label">Interests</label>
  <?php echo $error_alert['interests']; ?>
  <div class="interests_list">
    <?php
    foreach ($list_interests as $value => $label)
    {
      echo '<label class="form-check">
              <input class="form-check-input" type="checkbox" name="i_'.$value.'" '.$form_prefill["interest_".$value].'>'.$label.'
            </label>';
    }
    ?>
  </div>

  <button type="submit" name="modify" class="btn btn-primary btn-block my-3"><?php echo $output->get_head_title(); ?></button>

  <p>Modify my <a href="<?php echo Config::ROOT.'index.php?cat=modify-account'; ?>">account</a> or
    <a href="<?php echo Config::ROOT.'index.php?cat=modify-mate'; ?>">ideal mate</a>.</p>
</form>
