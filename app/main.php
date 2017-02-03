<?php
$user = $_SESSION['logged_user'];
echo "<p> Bonjour $user !</p>";

?>
<a href="index.php?log_out=true">Log out</a>

<div id="cam">
	<video id="video"></video>
	<img src="./resources/bower.png" class="toy" draggable="true" style="top:0px;left:0px;">
</div>

<button id="startbutton">Prendre une photo</button>
<br />
<canvas id="canvas"></canvas>

<form method="POST" action="upload.php">
	<input type="hidden" name="img" id="postcache">
	<input type="submit" id="send" name="submit" value="send">
</form>
<div class="images">
	<img src="./resources/bower.png" id="bower" class="toy" draggable="true">
	<img src="https://media.giphy.com/media/bnZO61TOFUNXy/giphy.gif" id="fire">
</div>
