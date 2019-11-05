<?php if ($_SESSION['is_logged'] === FALSE): ?>

  <nav class="navbar navbar-expand-sm navbar-light bg-white p-3 mb-3 border-bottom shadow-sm">
    <a class="navbar-brand" href="<?php echo Config::ROOT; ?>">Purrfect Partner</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="<?php echo Config::ROOT; ?>index.php?cat=register">Register</a></li>
        <li class="nav-item active"><a class="nav-link" href="<?php echo Config::ROOT; ?>index.php?cat=login">Log in</a></li>
      </ul>
    </div>
  </nav>

<?php else: ?>

  <nav class="navbar navbar-expand-sm navbar-light bg-white p-3 mb-3 border-bottom shadow-sm">
    <a class="navbar-brand" href="<?php echo Config::ROOT; ?>">Purrfect Partner</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active"><a class="nav-link" href="<?php echo Config::ROOT; ?>index.php?cat=search">Search</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo Config::ROOT; ?>index.php?cat=chat">Chat room</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">[<?php echo $_SESSION['username']; ?>]</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="<?php echo Config::ROOT; ?>index.php?cat=profile&id_user=<?php echo $_SESSION['id_user']; ?>">Profile</a>
            <a class="dropdown-item" href="<?php echo Config::ROOT; ?>index.php?cat=account">Account</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo Config::ROOT; ?>index.php?cat=logout">Log out</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

<?php endif; ?>
