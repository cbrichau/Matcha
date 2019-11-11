<div class="row m-3">

  <div class="col-sm-5 col-lg-4 bg-white py-4 px-5">
    <h2><?php echo $user_details['username']; ?></h2>

    <?php if ($user_details['status'] == 'Online'): ?>
      <p class="status online"><i class="fa fa-check-circle"></i> Online</p>
    <?php else: ?>
      <p class="status offline"><i class="fa fa-times-circle-o"></i> <?php echo $user_details['status']; ?></p>
    <?php endif; ?>

    <img src="<?php echo Config::ROOT.$user->get_profile_pics(0); ?>" class="img-fluid">

    <?php if ($user_details['id_user'] == $_SESSION['id_user']): ?>
      <a href="<?php echo Config::ROOT; ?>index.php?cat=account" class="btn btn-primary">Modify my account</a>
    <?php endif; ?>
  </div>

  <div class="col-sm-7 col-lg-8 bg-white py-4 px-5">
    <?php foreach ($user_details_labeled as $label => $value): ?>
      <div class="row">
        <p class="col-md-4 col-lg-3"><?php echo $label; ?></p>
        <p class="col-md-8 col-lg-9"><?php echo $value; ?></p>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<div class="row m-3">

  <div class="col-md-6 bg-white mb-3">
    <h3>My visitors</h3>
  </div>

  <div class="col-md-6 bg-white mb-3">
    <h3>My likers</h3>
  </div>

</div>
