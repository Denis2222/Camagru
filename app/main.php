<?php

if(isset($_POST['addable'])){
    if(@getimagesize($_FILES['newaddable']['tmp_name']) == FALSE){
        echo "<span class='image_select'>please select an image</span>";

    }
    else{
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
						}
            else { //uploaded but not moved
						}
        echo "</p>";
    }
}
?>
<div id="cam">
	<video id="video"></video>
	<img src="./toy/bower.png" class="toy" style="top:0px;left:0px;width:80px;">
	<img src="./toy/bower.png" class="toy" style="top:0px;left:0px;width:80px;">
	<img src="./toy/dino.png" class="toy" style="top:0px;left:0px;width:80px;">
</div>

<div id="addable">
	<?php
		$files = glob('./toy/*.png');
		foreach($files as $file) {
			echo '<img src="'.$file.'" class="addabletoy">';
		}
	?>
	<form method="POST" action="" enctype='multipart/form-data'>
		<input type="file" id="newaddable" name="newaddable" >
		<input type="submit" name="addable" value="ADD">
	</form>
</div>

<button id="startbutton">Prendre une photo</button>
<br />
<canvas id="canvas"></canvas>

<form method="POST" action="upload.php">
	<input type="hidden" id="postcache" name="img" >
	<input type="hidden" id="jsoncache" name="toys" >
	<input type="submit" id="send"      name="submit" value="send">
</form>
