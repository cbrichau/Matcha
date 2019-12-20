<div id="response"></div>

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
  <form action="<?= Config::ROOT; ?>index.php?cat=profile&id_user=<?=$_GET['id_user']?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" accept="image/jpg">
    <input type="submit" value="Upload" name="submit">
  </form>

  <button onclick="actual_picture_into_first('change_pic');" class="btn btn-primary">Change has profile pic</button>
  <?php //echo $error; echo $target_file; ?>
<?php } ?>

<p>Modify my <a href="<?php echo Config::ROOT.'index.php?cat=modify-account'; ?>">account</a>,
  <a href="<?php echo Config::ROOT.'index.php?cat=modify-profile'; ?>">profile</a>, or
  <a href="<?php echo Config::ROOT.'index.php?cat=modify-mate'; ?>">ideal mate</a>.</p>
