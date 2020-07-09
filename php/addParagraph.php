<?php
include("db_connect.php");

$sql = "INSERT INTO paragraph (paragraph) VALUES('{$_POST['paragraph']}')";
// $sql = "INSERT INTO paragraph (paragraph) VALUES('{$_GET['paragraph']}')";

if(($result =$conn->query($sql)) === true){
  $last_id = $conn->insert_id;
  echo $last_id;
}else{
  echo "FAILED";
}

 ?>
