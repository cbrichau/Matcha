<div class="row m-3">

  <div class="col-sm-5 col-lg-4 bg-white py-4 px-5">

    <div class="row">
      <h2 class="col-9"><?php echo $user_details['username']; ?></h2>
      <?php if ($user_details['id_user'] != $_SESSION['id_user']): ?>
        <div class="col-2 dropdown">
          <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'report');">Report</button>
            <button <?=$display['block']?> id="block" class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'block');">Block</button>
            <button <?=$display['unblock']?> id="unblock" class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'unblock');">Unblock</button>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <?php if ($user_details['status'] == 'Online'): ?>
      <p class="status online"><i class="fa fa-check-circle"></i> Online</p>
    <?php else: ?>
      <p class="status offline"><i class="fa fa-times-circle-o"></i> <?= $user_details['status']; ?></p>
    <?php endif; ?>

    <a class="nav-link" href="http://localhost:8081/gitmatcha/index.php?cat=chat&id_user=<?=$_GET['id_user']?>">Chat room</a>



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
				<button style="position:absolute; top:30px;right:15px; color:white; z-index:50;" onclick="actual_picture_into_first('delete_pic');" class="btn ">X</button>
			</div>
			<?php foreach ($profile_pics as $key => $value): if($key != 0){?>
				<div class="carousel-item">
					<img src="<?= $value; ?>" class="d-block w-100 img-fluid" alt="...">
					<button style="position:absolute; top:30px;right:15px; color:white; z-index:50;" onclick="actual_picture_into_first('delete_pic');" class="btn ">X</button>
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





    <?php if ($user_details['id_user'] == $_SESSION['id_user']){ ?>
      <a href="<?php echo Config::ROOT; ?>index.php?cat=account" class="btn btn-primary">Modify my account</a>
	<form action="<?= Config::ROOT; ?>index.php?cat=profile&id_user=<?=$_GET['id_user']?>" method="post" enctype="multipart/form-data">
		<input type="file" name="fileToUpload" accept="image/jpg">
		<input type="submit" value="Upload" name="submit">
	</form>
	  <button onclick="actual_picture_into_first('change_pic');" class="btn btn-primary">Change has profile pic</button>
	  <?php //echo $error; echo $target_file; ?>
  	<?php } else { ?>
	     <button <?=$display['like']?> id="like" class="btn btn-primary" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'like');">Like</button>
	     <button <?=$display['unlike']?> id="unlike" class="btn btn-primary" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'dislike');">Unlike</button>
  	<?php } ?>
  </div>

  <div id="response"></div>

  <div class="col-sm-7 col-lg-8 bg-white py-4 px-5">
    <h2 class="mb-3">I am:</h2>
    <?php foreach ($i_am as $label => $value): ?>
      <div class="row">
        <p class="col-md-4 col-lg-3"><?= $label; ?></p>
        <p class="col-md-8 col-lg-9"><?= $value; ?></p>
      </div>
    <?php endforeach; ?>

    <h2 class="mb-3">Seeking:</h2>
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
  <div class="col-md-6 bg-white mb-3">
    <h3>My visitors</h3>
		<?php
    foreach ($user_visitors as $key => $value)
    {
      if (file_exists(Config::IMAGES_PATH.'profile_pictures/'.$value['id_user_visited'].'-1.jpg'))
        echo '<img style="width:20%;height:auto;" class="user-icon" src="'.Config::IMAGES_PATH.'profile_pictures/'.$value['id_user_visited'].'-1.jpg">';
      else
        echo '<img style="width:20%;height:auto;" class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png">';
      echo '<div>'.$value['username'].'</div>
            <div class="time hidden-xs">Last visit : '.$value['last_visit'].'</div>';
		}
    ?>
  </div>
  <div class="col-md-6 bg-white mb-3">
    <h3>My likers</h3>
		<?php
    foreach ($user_likers as $key => $value)
    {
      if (file_exists(Config::IMAGES_PATH.'profile_pictures/'.$value->get_id_user().'-1.jpg'))
        echo '<img style="width:20%;height:auto;" class="user-icon" src="'.Config::IMAGES_PATH.'profile_pictures/'.$value->get_id_user().'-1.jpg">';
      else
        echo '<img style="width:20%;height:auto;" class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png">';
      echo '<div>'.$value->get_username().'</div>
            <div class="time hidden-xs">Last activity : '.$value->get_last_activity().'</div>';
		}
    ?>
  </div>
</div>
