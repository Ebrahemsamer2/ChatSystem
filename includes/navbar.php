<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/User.php";
  require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Message.php";

  User::searchUser();

  $count_not_seen_message = User::count_not_seen_messages();
  if( $count_not_seen_message > 9 ) { $count_not_seen_message = "9+"; }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/?home=1">
      <img class='' width="50" src='/images/chat_logo.png' >
    </a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/?home=1">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link chat-link" href="/?chat=1">Chat 
            <?php if($count_not_seen_message > 0): ?>
            <span class="badge bg-danger"><?php echo $count_not_seen_message; ?></span>
          <?php endif; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/?profile=1" tabindex="-1" aria-disabled="true">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/?logout=1" tabindex="-1" aria-disabled="true">Sign out</a>
        </li>

        <?php if(User::isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link border-danger text-danger" href="admin/index.php" tabindex="-1" aria-disabled="true">Admin Dashboard</a>
        </li>
      <?php endif; ?>
      </ul>
      <form class="d-flex">
        <input id='user_search_input' class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        
      </form>
    </div>
  </div>
</nav>