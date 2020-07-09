<?php
session_start();
require("db_connect.php");

$sql = "SELECT * FROM paragraph ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

// print_r($result);
if($result->num_rows > 0){
  $row = mysqli_fetch_assoc($result);
  $_SESSION['par_id'] = $row['id'];
  $json = json_encode($row);

  echo $json;
}


?>
