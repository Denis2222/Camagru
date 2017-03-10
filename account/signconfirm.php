<?php
  $token = trim(htmlspecialchars($_GET['token']));

  $sql = 'SELECT * FROM user WHERE confirm = "'.$token.'"';

  $req = $db->query($sql);
  $data = $req->fetch();
  $req->closeCursor();

  if ($data['confirm'] == $token) {
    $req = $db->exec("UPDATE user SET confirm = '' WHERE id = '".$data['id']."' ");
    mess("Adresse email confirme");
    ?>
      <SCRIPT LANGUAGE="JavaScript">
        setTimeout(function (){
          document.location.href="./"
        }
        ,2);
      </SCRIPT>
    <?php
  } else {
    ?>
      <SCRIPT LANGUAGE="JavaScript">
        document.location.href="./";
      </SCRIPT>
    <?php
  }
?>
