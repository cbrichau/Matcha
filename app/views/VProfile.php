<div class="row m-3">

  <div class="col-md-5 bg-white py-4 px-5">

    <h2><?php echo $user_details['username']; ?></h2>
    <?php echo $user_details['status']; ?>

  	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
  		<?php $profile_pics = $user->get_profile_pics("all");?>
  		<ol class="carousel-indicators">
  			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="margin-bottom:5px;"></li>
  			<?php foreach ($profile_pics as $key => $value): if($key != 0){?>
  			<li data-target="#carouselExampleIndicators" data-slide-to="<?=$key?>"></li>
  			<?php } endforeach; ?>
  		</ol>

  		<div class="carousel-inner" data-interval="false">
  			<div class="carousel-item active">
  				<img src="<?= $user->get_profile_pics(0); ?>" class="d-block w-100 img-fluid" alt="...">
				<?php if ($_SESSION['id_user'] == $_GET['id_user']){ ?>
  				<button style="position:absolute; top:30px;right:15px; color:white; z-index:50;" onclick="actual_picture_into_first('delete_pic');" class="btn ">X</button>
				<?php }  ?>
  			</div>
  			<?php foreach ($profile_pics as $key => $value): if($key != 0){?>
  				<div class="carousel-item">
  					<img src="<?= $value; ?>" class="d-block w-100 img-fluid" alt="...">
					<?php if ($_SESSION['id_user'] == $_GET['id_user']){ ?>
  					<button style="position:absolute; top:30px;right:15px; color:white; z-index:50;" onclick="actual_picture_into_first('delete_pic');" class="btn ">X</button>
					<?php }  ?>
  				</div>
  			<?php } endforeach; ?>

  		</div>
  		<?php if(count($profile_pics) != '1') { ?>
  		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
  			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
  			<span class="sr-only">Previous</span>
  		</a>
  		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
  			<span class="carousel-control-next-icon" aria-hidden="true"></span>
  			<span class="sr-only">Next</span>
  		</a>
  		<?php } ?>
  	</div>

    <?php if ($user_details['id_user'] == $_SESSION['id_user'] && count($profile_pics) != '5'){ ?>
    	<form action="<?= Config::ROOT; ?>index.php?cat=profile&id_user=<?=$_GET['id_user']?>" method="post" enctype="multipart/form-data">
    		<input type="file" name="fileToUpload" accept="image/jpg">
    		<input type="submit" value="Upload" name="submit">
    	</form>
      <button onclick="actual_picture_into_first('change_pic');" class="btn btn-primary">Change has profile pic</button>
      <?php //echo $error; echo $target_file; ?>
    <?php } ?>

    <div id="response"></div>
  </div>

  <div class="col-md-7 bg-white py-4 px-5">
    <div class="text-right"><?php if(($NotDefault != "resources/images/profile_pictures/0default.jpg" && $profile_pics[0] != "resources/images/profile_pictures/0default.jpg") || $user_details['id_user'] == $_SESSION['id_user']) {
		 echo $action;
	 } ?></div>
    <?php echo $match; ?>

    <h2 class="my-3">I am:</h2>
    <?php foreach ($i_am as $label => $value): ?>
      <div class="row">
        <p class="col-md-4 col-lg-3"><?= $label; ?></p>
        <p class="col-md-8 col-lg-9"><?= $value; ?></p>
      </div>
    <?php endforeach; ?>

    <h2 class="my-3">My ideal mate:</h2>
    <?php foreach ($seeking as $label => $value): ?>
      <div class="row">
        <p class="col-md-4 col-lg-3"><?= $label; ?></p>
        <p class="col-md-8 col-lg-9"><?= $value; ?></p>
      </div>
    <?php endforeach; ?>
    <?php echo $potential_matches_link; ?>
  </div>

</div>

<div class="row m-3">
  <div class="col-md-6 bg-white mb-3 py-4 px-5">
    <h3>My visitors</h3>
    <div class="row">
      <?php
      foreach ($user_visitors as $values)
      {
        $profile_pic = Config::IMAGES_PATH.'profile_pictures/'.$values['id_user_visitor'].'-1.jpg';
        $avatar = (file_exists($profile_pic)) ? $profile_pic : Config::IMAGES_PATH.'profile_pictures/0default.jpg';
        $last_visit = date("j M Y (G:i)", strtotime($values['last_visit']));
        ?>
        <div class="col-6 col-sm-6 col-xl-4 mb-3">
          <div class="card">
            <img src="<?php echo $avatar; ?>" class="card-img-top">
            <div class="card-body">
              <div class="card-text">
                <p><a href="<?php echo Config::ROOT.'index.php?cat=profile&id_user='.$values['id_user_visitor']; ?>" class="stretched-link"><?php echo $values['username']; ?></a></p>
                <p>Last visit: <?php echo $last_visit; ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
  <div class="col-md-6 bg-white mb-3 py-4 px-5">
    <h3>My likers</h3>
    <div class="row">
      <?php
      foreach ($user_likers as $values)
      {
        $profile_pic = Config::IMAGES_PATH.'profile_pictures/'.$values['id_user_liker'].'-1.jpg';
        $avatar = (file_exists($profile_pic)) ? $profile_pic : Config::IMAGES_PATH.'profile_pictures/0default.jpg';
        $last_visit = date("j M Y (G:i)", strtotime($values['last_activity']));
        ?>
        <div class="col-6 col-sm-6 col-xl-4 mb-3">
          <div class="card">
            <img src="<?php echo $avatar; ?>" class="card-img-top">
            <div class="card-body">
              <div class="card-text">
                <p><a href="<?php echo Config::ROOT.'index.php?cat=profile&id_user='.$values['id_user_liker']; ?>" class="stretched-link"><?php echo $values['username']; ?></a></p>
                <p>Last seen: <?php echo $last_visit; ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
</div>
