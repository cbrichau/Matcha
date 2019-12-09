<div class="row m-3">

  <div class="col-sm-5 col-lg-4 bg-white py-4 px-5">
    <h2><?php echo $user_details['username']; ?></h2>
	<div class="dropdown">
	  <button class="btn btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	   <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
	  </button>
	  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	    <button class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'report');">Report</button>
	    <button <?=$display['block']?> id="block" class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'block');">Block</button>
		<button <?=$display['unblock']?> id="unblock" class="dropdown-item" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'unblock');">Unblock</button>
	  </div>
	</div>

    <?php if ($user_details['status'] == 'Online'): ?>
      <p class="status online"><i class="fa fa-check-circle"></i> Online</p>
    <?php else: ?>
      <p class="status offline"><i class="fa fa-times-circle-o"></i> <?php echo $user_details['status']; ?></p>
    <?php endif; ?>
	
	<a class="nav-link" href="http://localhost:8081/gitmatcha/index.php?cat=chat&id_user=<?=$_GET['id_user']?>">Chat room</a>

    <img src="<?php echo Config::ROOT.$user->get_profile_pics(0); ?>" class="img-fluid">

    <?php if ($user_details['id_user'] == $_SESSION['id_user']){ ?>
      <a href="<?php echo Config::ROOT; ?>index.php?cat=account" class="btn btn-primary">Modify my account</a>
  	<?php } else { ?>
	  <button <?=$display['like']?> id="like" class="btn btn-primary" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'like');">Like</button>
	  <button <?=$display['unlike']?> id="unlike" class="btn btn-primary" onclick="actions_user(<?=$_SESSION['id_user']?>,<?=$_GET['id_user']?>,'dislike');">unlike</button>
  	<?php } ?>
  </div>

  <div class="col-sm-7 col-lg-8 bg-white py-4 px-5">
    <?php foreach ($user_details_labeled as $label => $value): ?>
      <div class="row">
        <p class="col-md-4 col-lg-3"><?php echo $label; ?></p>
        <p class="col-md-8 col-lg-9"><?php echo $value; ?></p>
      </div>
    <?php endforeach; ?>
	<div id="response"></div>
  </div>

</div>

<div class="row m-3">

  <div class="col-md-6 bg-white mb-3">
    <h3>My visitors</h3>
			<?php foreach ($userMng->who_visits_me($_GET['id_user']) as $key => $value) {
				if(file_exists('resources/images/profile_pictures/' . $value['id_user_visited'] . '-1.jpg')){
				?>
				<img style="width:20%;height:auto;"class="user-icon" src="http://localhost:8081/gitmatcha/resources/images/profile_pictures/<?=$value['id_user_visited']?>-1.jpg" alt="">
			<?php } else { ?>
				<img style="width:20%;height:auto;" class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
			<?php } ?>
				<div><?=$value['username']?></div>
				<div class="time hidden-xs">Last visit : <?=$value['last_visit']?></div>
		<?php } ?>
  </div>

  <div class="col-md-6 bg-white mb-3">
    <h3>My likers</h3>
			<?php foreach ($userMng->who_like_me($_GET['id_user']) as $key => $value) {
				if(file_exists('resources/images/profile_pictures/' . $value->get_id_user() . '-1.jpg')){
				?>

				<img style="width:20%;height:auto;"class="user-icon" src="http://localhost:8081/gitmatcha/resources/images/profile_pictures/<?=$value->get_id_user()?>-1.jpg" alt="">
			<?php } else { ?>
				<img style="width:20%;height:auto;" class="user-icon" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
			<?php } ?>
				<div><?=$value->get_username()?></div>
				<div class="time hidden-xs">Last activity : <?=$value->get_last_activity()?></div>

			<?php } ?>


  </div>

</div>
