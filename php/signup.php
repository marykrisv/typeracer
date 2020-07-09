<?php
include("db_connect.php");

$sql = "INSERT INTO user(username, password, role) VALUES('{$_POST['username']}','{$_POST['password']}','player')";
// $sql = "INSERT INTO user(username, password, role) VALUES('{$_GET['username']}','{$_GET['password']}','player')";
// echo $sql;
if($conn->query($sql)){
  echo "SUCCESS";
}else{
  echo "FAILED";
}
 ?>
