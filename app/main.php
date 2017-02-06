<?php
if ($_GET['action'] == "reset")
{
  unset($_SESSION['tmp_img']);
}
if(isset($_POST['addable'])){
    if(@getimagesize($_FILES['newaddable']['tmp_name']) == FALSE){
        echo "<span class='image_select'>please select an image</span>";

    }
    else {
        $image = addslashes($_FILES['newaddable']['tmp_name']);
        $name  = addslashes($_FILES['newaddable']['name']);
        $image = file_get_contents($image);
        $image = base64_encode($image);
        //saveimage($name,$image);
        $uploaddir = './toy/'; //this is your local directory
        $uploadfile = $uploaddir . basename($_FILES['newaddable']['name']);

        echo "<p>";
            if (move_uploaded_file($_FILES['newaddable']['tmp_name'], $uploadfile)) {
							// file uploaded and moved
						} else { //uploaded but not moved
						}
        echo "</p>";
    }
}


if(isset($_POST['altimage'])){
  echo "HERE";
    if(@getimagesize($_FILES['newaltimage']['tmp_name']) == FALSE){
        echo "<span class='image_select'>please select an image</span>";
    }
    else {
      echo "HERE";
        $image = addslashes($_FILES['newaltimage']['tmp_name']);
        $name  = addslashes($_FILES['newaltimage']['name']);
        $image = file_get_contents($image);
        $image = base64_encode($image);
        //saveimage($name,$image);
        $uploaddir = './tmp/'; //this is your local directory
        $uploadfile = $uploaddir . basename($_FILES['newaltimage']['name']);
        echo $uploadfile;
        $_SESSION['tmp_img'] = $uploadfile;
        print_r($_FILES['newaltimage']);
        echo "<p>";
            if (move_uploaded_file($_FILES['newaltimage']['tmp_name'], $uploadfile)) {
              echo "move OK";
							// file uploaded and moved
						} else { //uploaded but not moved
              echo "up not move";
						}
        echo "</p>";
    }
}

?>
<div>
<div id="cam">
  <div id="photo">
    <?php if (!$_SESSION['tmp_img']) { ?>
    Si vous n'avez pas de webcam envoyez votre image ici.
    <form method="POST" action="" enctype='multipart/form-data'>
  		Cliquez sur les images pour ajouter:
  		<input type="file" id="newaltimage" name="newaltimage" >
  		<input type="submit" name="altimage" value="ADD">
  	</form>
    <?php } else {
      echo '<img id="photoimg" src="'.$_SESSION['tmp_img'].'">
      <a class="del" href="index.php?page=photo&action=reset">
        <img src="./resources/delete.png">
      </a>';
    }?>
  </div>
	<video id="video"></video>
	<img src="./toy/45777f7a.png" class="toy" style="top:50px;left:80px;width:160px;">
</div>

<div id="addable">

	<?php
		$files = glob('./toy/*.png');
		foreach($files as $file) {
			echo '<img src="'.$file.'" class="addabletoy">';
		}
	?>

	<form method="POST" action="" enctype='multipart/form-data'>
		Cliquez sur les images pour ajouter:
		<input type="file" id="newaddable" name="newaddable" >
		<input type="submit" name="addable" value="ADD">
	</form>
</div>
<canvas id="canvas" style="display:none;"></canvas>
	<form id="theForm" name="theForm" method="POST" action="upload.php">
		<input type="hidden" id="postcache" name="img" >
		<input type="hidden" id="jsoncache" name="toys" >
		<input type="submit" id="send" name="submit" value="Enregistrer">
	</form>
</div>
