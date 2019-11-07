Profile
https://www.bootdey.com/snippets/view/User-profile-with-friends-and-chat


<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<div class="container bootstrap snippets">
  <div class="row" id="user-profile">

    <div class="col-lg-3 col-md-4 col-sm-4">
      <div class="main-box clearfix">
        <h2>John Doe </h2>
        <div class="profile-status">
            <i class="fa fa-check-circle"></i> Online
        </div>
        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="profile-img img-responsive center-block">
      </div>
    </div>

    <div class="col-lg-9 col-md-8 col-sm-8">
      <div class="main-box clearfix">

        <div class="profile-header">
          <h3><span>User info</span></h3>
          <a href="#" class="btn btn-primary edit-profile"><i class="fa fa-pencil-square fa-lg"></i> Edit profile</a>
        </div>

        <div class="row profile-user-info">
          <div class="col-sm-8">
            <?php foreach ($user_values as $key => $value): ?>
              <div class="profile-user-details clearfix">
                <div class="profile-user-details-label"><?php echo $key; ?></div>
                <div class="profile-user-details-value"><?php echo $value; ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
