<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "typeracer";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn->error){
  die("CONNECTION FAILED:".$conn->connect_error);
}



 ?>
