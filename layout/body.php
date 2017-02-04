<article class="main">
  <?php
  if (!$_SESSION['logged_user']){
  	switch ($_GET['page']) {
  		case 'sign_in':
  			include 'account/sign_in.php';
  			break;
  		case 	'pwdlost':
  			include 'account/pwdlost.php';
  			break;
  		case 	'pwdreset':
  			include 'account/pwdreset.php';
  			break;
      default:
        include 'album.php';
  	}
  } else {
  	if (!$_GET['page'] || $_GET['page'] == 'photo')
  		include 'app/main.php';
  	if ($_GET['page'] == 'account')
  		include 'account/account.php';
    if ($_GET['page'] == 'gallery')
  		include 'album.php';
  }
  ?>
</article>
