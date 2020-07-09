<?php
session_start();
require("db_connect.php");

$sql = "SELECT * FROM matches join paragraph on matches.mmParId = paragraph.id where mId = {$_SESSION['match_id']}";
$result = $conn->query($sql);

// print_r($result);
if($result->num_rows > 0){
  $row = mysqli_fetch_assoc($result);
  $_SESSION['par_id'] = $row['id'];
  $json = json_encode($row);

  echo $json;
}


?>
