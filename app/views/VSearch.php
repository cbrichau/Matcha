<div class="row">

<?php /* -------------- Sidebar -------------- */ ?>

  <aside class="mb-3 col-sm-5 col-md-4 col-lg-3">
    <form class="card text-left p-0" method="POST">

      <h6 class="card-header">Gender</h6>
      <div class="card-body">
        <label class="form-check"><input class="form-check-input" type="radio" name="gender" value="any" checked>Any</label>
        <label class="form-check"><input class="form-check-input" type="radio" name="gender" value="female">Female</label>
        <label class="form-check"><input class="form-check-input" type="radio" name="gender" value="male">Male</label>
      </div>

      <h6 class="card-header">Age</h6>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-6">
            <label>Min</label>
            <input type="number" class="form-control" placeholder="2" min="1" max="25" name="age_min" value="">
          </div>
          <div class="form-group col-6 text-right">
            <label>Max</label>
            <input type="number" class="form-control" placeholder="12" min="1" max="25" name="age_max" value="">
          </div>
        </div>
      </div>

      <h6 class="card-header">Distance</h6>
      <div class="card-body">
        <output id="ageOutputId">8 km</output>
        <input type="range" id="ageInputId" class="form-control-range" min="1" max="15" oninput="ageOutputId.value = ageInputId.value + ' km'" name="distance" value="">
      </div>

      <h6 class="card-header">Interests</h6>
      <div class="card-body">
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Hunting</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Sunbathing</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Nightlife</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Naps</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Chillaxing</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Gourmet food</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Wildlife</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Cardboard boxes</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Cuddles</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Running</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Meditation</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Knocking things off the table</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Bird watching</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Adventure</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Food</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Window-gazing</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Silently judging you</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Climbing</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Staring in the void</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Grooming</label>
        <label class="form-check"><input class="form-check-input" type="checkbox" value="">Rolling in dirt</label>
      </div>

    </form>
  </aside>

<?php /* -------------- Main section -------------- */ ?>

  <main class="col-sm-7 col-md-8 col-lg-9">
    <div class="container-fluid">
      <div class="row">

        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="..." class="card-img-top">
            <div class="card-body">
              <p><a href="#" class="stretched-link">Username</a></p>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>

        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="..." class="card-img-top">
            <div class="card-body">
              <p><a href="#" class="stretched-link">Username</a></p>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>

        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="..." class="card-img-top">
            <div class="card-body">
              <p><a href="#" class="stretched-link">Username</a></p>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>

        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="..." class="card-img-top">
            <div class="card-body">
              <p><a href="#" class="stretched-link">Username</a></p>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class='d-flex'>
      <ul class="pagination mx-auto">
        <li class="page-item disabled"><span class="page-link">Previous</span></li>
        <li class="page-item active"><span class="page-link">1</span></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </div>

  </main>
</div>
