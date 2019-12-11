<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <h2>Identifiers:</h2>

  <label>Email</label>
  <?php echo $error_alert['email']; ?>
  <input type="email" name="email" value="<?php echo $form_prefill['email']; ?>" class="form-control" required>

  <label>Username</label>
  <?php echo $error_alert['username']; ?>
  <input type="text" name="username" value="<?php echo $form_prefill['username']; ?>" class="form-control" required>

  <label>First name</label>
  <?php echo $error_alert['first_name']; ?>
  <input type="text" name="first_name" value="<?php echo $form_prefill['first_name']; ?>" class="form-control" required>

  <label>Last name</label>
  <?php echo $error_alert['last_name']; ?>
  <input type="text" name="last_name" value="<?php echo $form_prefill['last_name']; ?>" class="form-control" required>

  <label>Password</label>
  <?php echo $error_alert['password']; ?>
  <input type="password" name="pass" placeholder="Password" value="" class="form-control my-2" required>
  <input type="password" name="passcheck" placeholder="Re-type password" value="" class="form-control" required>

  <h2>My profile:</h2>

  <label>Gender</label>
  <?php echo $error_alert['gender']; ?>
  <select class="form-control" name="gender">
    <option value="NULL">Undefined</option>
    <option value="F">Female</option>
    <option value="M">Male</option>
  </select>

  <label>Date of birth</label>
  <?php echo $error_alert['date_of_birth']; ?>
  <input type="date" name="date_of_birth" value="<?php echo $form_prefill['date_of_birth']; ?>" class="form-control">

  <label>Location</label>
  <?php echo $error_alert['location']; ?>
  <input type="text" name="location" value="" class="form-control">

  <label>Bio</label>
  <?php echo $error_alert['bio']; ?>
  <textarea name="bio" placeholder="Enter a short description of yourself" value="" class="form-control" rows="3"></textarea>

  <label>Interests</label>
  <?php echo $error_alert['interests']; ?>
  <label><input type="checkbox" name="i" value="i"> Interest 1</label>
  <label><input type="checkbox" name="i" value="i"> Interest 2</label>
  <label><input type="checkbox" name="i" value="i"> Interest 3</label>

  <h2>My ideal mate:</h2>

  <label>Gender</label>
  <?php echo $error_alert['seeked_gender']; ?>
  <select class="form-control" name="seeked_gender">
    <option value="NULL">Undefined</option>
    <option value="F">Female</option>
    <option value="M">Male</option>
  </select>

  <label>Age</label>
  <div class="form-row">
    <div class="form-group col-6">
      <p>Min</p>
      <input type="number" min="0" max="35" name="seeked_age_min" value="<?php echo $form_prefill['seeked_age_min']; ?>" class="form-control">
    </div>
    <div class="form-group col-6 text-right">
      <p>Max</p>
      <input type="number" min="0" max="35" name="seeked_age_max" value="<?php echo $form_prefill['seeked_age_max']; ?>" class="form-control">
    </div>
  </div>

  <label>Distance</label>
  <div>
    <output id="ageOutputId">Max <?php echo $form_prefill['seeked_distance']; ?> km</output>
    <input type="range" id="ageInputId" class="form-control-range" min="1" max="15" oninput="ageOutputId.value = 'Max ' + ageInputId.value + ' km'" name="seeked_distance" value="<?php echo $form_prefill['seeked_distance']; ?>">
  </div>

  <label>Interests</label>


  <label>Popularity score</label>
  <div class="card-body">
    <output id="scoreOutputId">Max <?php echo $form_prefill['seeked_popularity_range']; ?> points interval</output>
    <input type="range" id="scoreInputId" class="form-control-range" min="1" max="100" oninput="scoreOutputId.value = 'Max ' + scoreInputId.value + ' points interval'" name="seeked_popularity_range" value="<?php echo $form_prefill['seeked_popularity_range']; ?>">
  </div>




  <button type="submit" name="modify" class="btn btn-primary btn-block"><?php echo $output->get_head_title(); ?></button>
</form>
