<div class="alert alert-primary text-center my-3">
  You can only chat with users you like, and who like you.
  <a href="'.Config::ROOT.'index.php?cat=chat&id_user='.$_GET['id_user'].'">Go find users you like</a>.
</div>

<div class="row">
  <?php foreach ($results as $values): ?>
    <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
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
              <p><b>'.$values['user']->get_username().'</b> ('.$values['user']->get_age().') <span class="float-right">'.$icon_gender.'</span></p>
              <p><i class="far fa-heart"></i> '.$values['interests'].'</p>
              <p>
                <i class="fas fa-star"></i> '.$values['user']->get_popularity_score().'
                <span class="float-right"><i class="fas fa-map-marker-alt"></i> '.$values['distance'].' km</span>
              </p>
              <p>
                <a href="'.Config::ROOT.'index.php?cat=chat&id_user_1='.$current_user->get_id_user().'&id_user_2='.$values['user']->get_id_user().'" class="btn btn-primary mx-auto stretched-link">Go to chat</a>
              </p>';
            ?>
          </div>

        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
