<aside class="mb-3 col-sm-5 col-md-4 col-lg-3">
  <form method="GET" id="search_form" class="card text-left p-0">
    <input type="hidden" name="cat" value="search">

    <h6 class="card-header">Gender</h6>
    <div class="card-body">
      <label class="form-check"><input class="form-check-input" type="radio" name="gender" value="A" checked>Any</label>
      <?php foreach ($filter_genders as $key => $value): ?>
        <label class="form-check"><input class="form-check-input" type="radio" name="gender" value="<?php echo $key; ?>"><?php echo $value; ?></label>
      <?php endforeach; ?>
    </div>

    <h6 class="card-header">Age</h6>
    <div class="card-body">
      <div class="form-row">
        <div class="form-group col-6">
          <label>Min</label>
          <input type="number" class="form-control" min="1" max="25" name="age_min" value="2">
        </div>
        <div class="form-group col-6 text-right">
          <label>Max</label>
          <input type="number" class="form-control" min="1" max="25" name="age_max" value="12">
        </div>
      </div>
    </div>

    <h6 class="card-header">Distance</h6>
    <div class="card-body">
      <output id="ageOutputId">Max 8 km</output>
      <input type="range" id="ageInputId" class="form-control-range" min="1" max="15" oninput="ageOutputId.value = 'Max ' + ageInputId.value + ' km'" name="distance" value="8">
    </div>

    <h6 class="card-header">Interests</h6>
    <div class="card-body">
      <label class="form-check"><input class="form-check-input" type="radio" name="interests" value="any" checked>Any</label>
      <?php foreach ($filter_genders as $key => $value): ?>
        <label class="form-check"><input class="form-check-input" type="checkbox" name="interest<?php echo $key; ?>" value="<?php echo $key; ?>"><?php echo $value; ?></label>
      <?php endforeach; ?>
    </div>

  </form>
</aside>
