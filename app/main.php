<?php
if ($_GET['action'] == "reset")
{
  unset($_SESSION['tmp_img']);
}
if(isset($_POST['addable'])){
	var_dump($_FILES['newaddable']);
    if(@getimagesize($_FILES['newaddable']['tmp_name']) == FALSE){
        echo "<div class='decobox'>please select an image</span>";
    }
    else {
        $image = addslashes($_FILES['newaddable']['tmp_name']);
        $name  = addslashes($_FILES['newaddable']['name']);

		if($_FILES['newaddable']['size'] <= 700000 && $_FILES['newaddable']["type"] == "image/png") {
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
		} else {
			echo "<div class='decobox'>";
			if ($_FILES['newaddable']['size'] > 700000)
				echo " File too big: ".$_FILES['newaddable']['size']." octets | max : 200ko";
			if ($_FILES['newaddable']["type"] != "image/png")
				echo " Only PNG allowed";
			echo "</div>";
		}
    }
}


if(isset($_POST['altimage'])){
  //echo "HERE";
    if(@getimagesize($_FILES['newaltimage']['tmp_name']) == FALSE){
        echo "<span class='image_select'>please select an image</span>";
    }
    else {
        $image = addslashes($_FILES['newaltimage']['tmp_name']);
        $name  = addslashes($_FILES['newaltimage']['name']);
		//var_dump($_FILES['newaltimage']);
		if($_FILES['newaltimage']['size'] <= 700000 && $_FILES['newaltimage']["type"] == "image/jpeg") {
	        $image = file_get_contents($image);
	        $image = base64_encode($image);
	        //saveimage($name,$image);
	        $uploaddir = './tmp/'; //this is your local directory
	        $uploadfile = $uploaddir . basename($_FILES['newaltimage']['name']);
	        echo $uploadfile;
	        $_SESSION['tmp_img'] = $uploadfile;
	        //print_r($_FILES['newaltimage']);
	        echo "<p>";
	            if (move_uploaded_file($_FILES['newaltimage']['tmp_name'], $uploadfile)) {
	              //echo "move OK";
								// file uploaded and moved
				} else { //uploaded but not moved
      //echo "up not move";
				}
	        echo "</p>";
		} else {
			echo "<div class='decobox'>";
			if ($_FILES['newaltimage']['size'] > 700000)
				echo "File too big: ".$_FILES['newaltimage']['size']." octets |  max : 700ko";
			if ($_FILES['newaltimage']["type"] != "image/jpeg")
				echo "Only JPEG allowed";
			echo "</div>";
		}
    }
}

?>
<div class="decobox">
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
      <a class="delaltimg" href="index.php?page=photo&action=reset"></a>';
    }?>
  </div>
	<video id="video"></video>
</div>

<div id="addable">

Cliquez sur les images pour ajouter a la scene:<br />
	<?php
		$files = glob('./toy/*.png');
		foreach($files as $file) {
			echo '<img src="'.$file.'" class="addabletoy">';
		}
	?><br />
Ajoutez un image au format PNG:<br />
	<form method="POST" action="" enctype='multipart/form-data'>
		<input type="file" id="newaddable" name="newaddable" >
		<input type="submit" name="addable" value="ADD">
	</form>
</div>
<canvas id="canvas" style="display:none;"></canvas>
	<form id="theForm" name="theForm" method="POST" action="upload.php">
		<input type="hidden" id="postcache" name="img" >
		<input type="hidden" id="jsoncache" name="toys" >
		<input type="submit" id="send" onclick="if(document.getElementsByClassName('toy').length===0){alert('Minimum 1 image');return false;}takepicture();return true;" name="submit" value="Enregistrer">
	</form>
</div>
