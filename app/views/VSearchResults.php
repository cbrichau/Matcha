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
      <?php foreach ($results as $values): ?>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="<?php echo Config::ROOT.$values['user']->get_profile_pics(0); ?>" class="card-img-top">
            <div class="card-body">
              <div class="card-text">
              <?php
                echo '<p><a href="'.Config::ROOT.'index.php?cat=profile&id_user='.$values['user']->get_id_user().'" class="stretched-link">'.$values['user']->get_username().'</a></p>';
                $s = ($values['user']->get_age() > 1) ? 's' : '';
                echo '<p>'.$values['user']->get_gender().'</p>';
                echo '<p>'.$values['user']->get_age().' year'.$s.' old</p>';
                echo '<p>'.$values['user']->get_popularity_score().' points</p>';
                echo '<p>'.$values['distance'].' km away</p>';
                echo '<p>'.$values['interests'].'</p>';
              ?>
              </div>
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
