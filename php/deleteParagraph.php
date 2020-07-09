<?php
include("db_connect.php");

$sql = "DELETE FROM paragraph WHERE id = {$_POST['id']}";

// echo $sql;
if($conn->query($sql) === true){
  echo "DELETED";
}else{
  echo "FAILED";
}

 ?>
