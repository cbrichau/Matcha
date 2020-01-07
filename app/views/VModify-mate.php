<form method="POST">
  <?php echo $success_alert; ?>
  <h1><?php echo $output->get_head_title(); ?></h1>

  <label class="label">Gender</label>
  <?php echo $error_alert['seeked_gender']; ?>
  <select class="form-control" name="seeked_gender">
    <option value="" <?php echo $form_prefill['seeked_gender_any']; ?>>Any</option>
    <option value="F" <?php echo $form_prefill['seeked_gender_F']; ?>>Female</option>
    <option value="M" <?php echo $form_prefill['seeked_gender_M']; ?>>Male</option>
  </select>

  <div class="form-row">
    <div class="form-group col-6">
      <label class="label">Age min</label>
      <input type="number" min="0" max="35" name="seeked_age_min" value="<?php echo $form_prefill['seeked_age_min']; ?>" class="form-control">
    </div>
    <div class="form-group col-6 text-right">
      <label class="label">Age max</label>
      <input type="number" min="0" max="35" name="seeked_age_max" value="<?php echo $form_prefill['seeked_age_max']; ?>" class="form-control">
    </div>
    <?php echo $error_alert['seeked_age']; ?>
  </div>

  <label class="label">Distance</label>
  <?php echo $error_alert['seeked_distance']; ?>
  <div>
    <output id="ageOutputId">Max <?php echo $form_prefill['seeked_distance']; ?> km</output>
    <input type="range" id="ageInputId" class="form-control-range" min="1" max="15" oninput="ageOutputId.value = 'Max ' + ageInputId.value + ' km'" name="seeked_distance" value="<?php echo $form_prefill['seeked_distance']; ?>">
  </div>

  <label class="label">Interests</label>
  <?php echo $error_alert['seeked_interests']; ?>
  <div class="interests_list">
    <?php
    foreach ($list_interests as $value => $label)
    {
      echo '<label class="form-check">
              <input class="form-check-input" type="checkbox" name="i_'.$value.'" '.$form_prefill["seeked_interest_".$value].'>'.$label.'
            </label>';
    }
    ?>
  </div>

  <label class="label">Popularity score range</label>
  <?php echo $error_alert['seeked_popularity_range']; ?>
  <div class="card-body">
    <output id="scoreOutputId">Max <?php echo $form_prefill['seeked_popularity_range']; ?> points interval</output>
    <input type="range" id="scoreInputId" class="form-control-range" min="1" max="100" oninput="scoreOutputId.value = 'Max ' + scoreInputId.value + ' points interval'" name="seeked_popularity_range" value="<?php echo $form_prefill['seeked_popularity_range']; ?>">
  </div>

  <button type="submit" name="modify" class="btn btn-primary btn-block my-3"><?php echo $output->get_head_title(); ?></button>

  <p>Modify my <a href="<?php echo Config::ROOT.'index.php?cat=modify-account'; ?>">account</a>,
    <a href="<?php echo Config::ROOT.'index.php?cat=modify-profile'; ?>">profile</a>, or
    <a href="<?php echo Config::ROOT.'index.php?cat=modify-pictures'; ?>">pictures</a>.</p>
</form>
