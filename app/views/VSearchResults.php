<main class="col-sm-7 col-md-8 col-lg-9">
  <div class="container-fluid">

    <div class="row mx-1">
      <form method="GET" id="sort_form" class="col bg-white text-right">
        <label>Sort by:</label>
        <select name="sort">
          <?php
          foreach ($list_sort_options as $value => $label)
            echo '<option value="'.$value.'" '.$form_prefill['sort_'.$value].'>'.$label.'</option>';
          ?>
        </select>

        <?php foreach ($list_order_options as $value => $label): ?>
          <label class="pl-2">
            <input type="radio" name="order" value="<?php echo $value; ?>" <?php echo $form_prefill['order_'.$value]; ?>>
            <?php echo $label; ?>
          </label>
        <?php endforeach; ?>
      </form>
    </div>

    <div class="row">
      <?php foreach ($results as $values): ?>
        <div class="mb-3 col-sm-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="<?php echo Config::ROOT.$values['user']->get_profile_pics(0); ?>" class="card-img-top">
            <div class="card-body">

              <div class="card-text">
                <?php
                $icon_gender = '';
                if ($values['user']->get_gender() == 'F')
                  $icon_gender = '<i class="fa fa-female" style="color:#ff99ff;"></i>';
                elseif ($values['user']->get_gender() == 'M')
                  $icon_gender = '<i class="fa fa-male" style="color:#66a3ff;"></i>';
                echo '
                  <p>
                    <span class="float-right">'.$icon_gender.'</span>
                    <a href="'.Config::ROOT.'index.php?cat=profile&id_user='.$values['user']->get_id_user().'" class="stretched-link">
                      '.$values['user']->get_username().'
                      ('.$values['user']->get_age().')
                    </a>
                  </p>
                  <p>
                    <i class="far fa-heart"></i>
                    '.$values['interests'].'
                  </p>
                  <p>
                    <i class="fas fa-star"></i>'.$values['user']->get_popularity_score().'
                    <span class="float-right"><i class="fas fa-map-marker-alt"></i> '.$values['distance'].' km</span>
                  </p>';
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
