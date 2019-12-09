<div class="row m-3">

  <div class="col-sm-5 col-lg-4 bg-white py-4 px-5">

    <div class="row">
      <h2 class="col-9"><?php echo $user_details['username']; ?></h2>
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
    </div>

    <?php if ($user_details['status'] == 'Online'): ?>
      <p class="status online"><i class="fa fa-check-circle"></i> Online</p>
    <?php else: ?>
      <p class="status offline"><i class="fa fa-times-circle-o"></i> <?= $user_details['status']; ?></p>
    <?php endif; ?>

    <a class="nav-link" href="http://localhost:8081/gitmatcha/index.php?cat=chat&id_user=<?=$_GET['id_user']?>">Chat room</a>

    <img src="<?php echo Config::ROOT.$user->get_profile_pics(0); ?>" class="img-fluid">

    <?php if ($user_details['id_user'] == $_SESSION['id_user']){ ?>
      <a href="<?php echo Config::ROOT; ?>index.php?cat=account" class="btn btn-primary">Modify my account</a>
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
