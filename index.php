<?php
  session_start();
  ob_start();
  if ($_GET['log_out'] == 'true') {
  	$_SESSION['logged_user'] = NULL;
  	header('Location: index.php');
  }
  require_once('config.php');
?>
<html class="">
<head>
  <meta charset="UTF-8">
	<title>Camagru</title>
	<script src="./resources/webcam.js" async></script>
  <link rel="stylesheet" media="all" href="./resources/style.css">
</head><body >
<div class="wrapper">
  <header class="header">
    <?php
    include 'layout/header.php';
    ?>
  </header>
  <article class="main">
    <?php
    if (!$_SESSION['logged_user']) {
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
        case 	'signconfirm':
    			include 'account/signconfirm.php';
    			break;
        default:
          include 'album.php';
          break;
    	}
    } else if ($_GET['page'] == 'gallery' || !$_GET['page']) {
      include 'album.php';
    } else if ($_GET['page'] == 'photo') {
    		include 'app/main.php';
    }
    ?>
  </article>

  <aside class="aside aside-2">
    <?php
      include 'layout/menu.php';
    ?>
  </aside>
  <footer class="footer">Footer</footer>
</div>
</body>
</html>
