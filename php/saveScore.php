<?php
session_start();
include("db_connect.php");

$sql = "INSERT INTO solo_highscore(wpm, user_id , paragraph_id) VALUES({$_POST['score']},{$_SESSION['user_id']}, {$_POST['par']})";

if($conn->query($sql)){
  echo "SUCCESS";
}else{
  echo "FAIL";
}

 ?>
