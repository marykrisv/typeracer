<?php
  session_start();


  $solo_sql = "SELECT * FROM solo_highscore WHERE user_id = {$_SESSION['user_id']}";
  $solo_result = $conn->query($solo_sql);

  $pvp_sql = "SELECT * FROM pvp_highscore WHERE user_id = {$_SESSION['user_id']}";


  $solo_sql = "SELECT  solo_highscore.wpm FROM solo_highscore INNER JOIN user ON paragraph.id=solo_highscore.paragraph_id WHERE user_id = 3"

 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
