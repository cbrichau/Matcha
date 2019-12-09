<aside class="mb-3 col-sm-5 col-md-4 col-lg-3">
  <form method="GET" id="filter_form" class="card text-left p-0">
    <input type="hidden" name="cat" value="search">

    <h6 class="card-header">Gender</h6>
    <div class="card-body">
      <?php foreach ($list_genders as $value => $label): ?>
        <label class="form-check">
          <input class="form-check-input" type="radio" name="gender" value="<?php echo $value; ?>" <?php echo $form_prefill['gender_'.$value]; ?>>
          <?php echo $label; ?>
        </label>
      <?php endforeach; ?>
    </div>

    <h6 class="card-header">Age</h6>
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-6">
          <p>Min</p>
          <input type="number" class="form-control" min="0" max="35" name="age_min" value="<?php echo $form_prefill['age_min']; ?>">
        </div>
        <div class="form-group col-6 text-right">
          <p>Max</p>
          <input type="number" class="form-control" min="0" max="35" name="age_max" value="<?php echo $form_prefill['age_max']; ?>">
        </div>
      </div>
    </div>

    <h6 class="card-header">Distance</h6>
    <div class="card-body">
      <output id="ageOutputId">Max <?php echo $form_prefill['distance']; ?> km</output>
      <input type="range" id="ageInputId" class="form-control-range" min="1" max="15" oninput="ageOutputId.value = 'Max ' + ageInputId.value + ' km'" name="distance" value="<?php echo $form_prefill['distance']; ?>">
    </div>

    <h6 class="card-header">Interests</h6>
    <div class="card-body">
      <label class="form-check">
        <input class="form-check-input" type="radio" name="interests" value="any" <?php echo $form_prefill['interest_any']; ?>>
        Any
      </label>
      <?php foreach ($list_interests as $value => $label): ?>
        <label class="form-check">
          <input class="form-check-input" type="checkbox" name="i_<?php echo $value; ?>" <?php echo $form_prefill['interest_'.$value]; ?>>
          <?php echo $label; ?>
        </label>
      <?php endforeach; ?>
    </div>

    <h6 class="card-header">Popularity score</h6>
    <div class="card-body">
      <output id="scoreOutputId">Max <?php echo $form_prefill['popularity_range']; ?> points interval</output>
      <input type="range" id="scoreInputId" class="form-control-range" min="1" max="1000" oninput="scoreOutputId.value = 'Max ' + scoreInputId.value + ' points interval'" name="popularity_range" value="<?php echo $form_prefill['popularity_range']; ?>">
    </div>

    <input type="hidden" name="sort" value="<?php echo $form_prefill['sort']; ?>">
    <input type="hidden" name="order" value="<?php echo $form_prefill['order']; ?>">

  </form>
</aside>
