<main class="col-sm-7 col-md-8 col-lg-9">
  <div class="container-fluid">
    <div class="row">

      <?php foreach ($results as $user): ?>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="..." class="card-img-top">
            <div class="card-body">
              <p><a href="#" class="stretched-link"><?php echo $user->get_username(); ?></a></p>
              <p class="card-text"><?php echo $user->get_bio(); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

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
