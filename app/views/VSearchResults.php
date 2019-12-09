<main class="col-sm-7 col-md-8 col-lg-9">
  <div class="container-fluid">

    <form method="GET" id="sort_form" class="form-inline bg-white mb-3 mr-0">
      <label>Sort by:</label>
      <select class="form-control" form="search_form" name="sort">
        <?php
        foreach ($list_sort_options as $value => $label)
          echo '<option value="'.$value.'" '.$form_prefill['sort_'.$value].'>'.$label.'</option>';
        ?>
      </select>

      <?php foreach ($list_order_options as $value => $label): ?>
        <label class="form-check">
          <input class="form-check-input" type="radio" name="order" value="<?php echo $value; ?>" <?php echo $form_prefill['order_'.$value]; ?>>
          <?php echo $label; ?>
        </label>
      <?php endforeach; ?>
    </form>

    <div class="row">
      <?php foreach ($results as $user): ?>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="<?php echo Config::ROOT.$user->get_profile_pics(0); ?>" class="card-img-top">
            <div class="card-body">
              <p>
                <a href="<?php echo Config::ROOT.'index.php?cat=profile&id_user='.$user->get_id_user(); ?>" class="stretched-link">
                  <?php echo $user->get_username(); ?>
                </a>
              </p>
              <p>
                <?php
                  $s = ($user->get_age() > 1) ? 's' : '';
                  echo $user->get_gender().' | '.$user->get_age().' year'.$s.' old | '.$user->get_popularity_score().' points';
                ?>
              </p>
              <p class="card-text"><?php echo '#interests list'; ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <ul class="pagination justify-content-center flex-wrap">
    <?php
      // Previous page
      if ($pagination['current_page'] == 1)
        echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
      else
      {
        $prev = $pagination['current_page'] - 1;
        echo '<li class="page-item"><a class="page-link" href="'.$pagination['url'].$prev.'">Previous</a></li>';
      }

      // Numbered pages
    	for ($i = 1; $i <= $pagination['nb_pages']; $i++)
    	{
    		if ($i == $pagination['current_page'])
    			echo '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
    		else
    			echo '<li class="page-item"><a class="page-link" href="'.$pagination['url'].$i.'">'.$i.'</a></li>';
    	}

      // Next page
      if ($pagination['current_page'] == $pagination['nb_pages'])
        echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
      else
      {
        $next = $pagination['current_page'] + 1;
        echo '<li class="page-item"><a class="page-link" href="'.$pagination['url'].$next.'">Next</a></li>';
      }
  	?>
  </ul>
</main>
